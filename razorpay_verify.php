<?php

session_start();

require 'vendor/autoload.php';
require 'includes/db.php';
require 'includes/payment_config.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

/*
|--------------------------------------------------------------------------
| CHECK PENDING ORDER
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['pending_order'])) {

    die('Pending order not found.');

}

$order = $_SESSION['pending_order'];

/*
|--------------------------------------------------------------------------
| VERIFY PAYMENT
|--------------------------------------------------------------------------
*/

$api = new Api(
    RAZORPAY_KEY_ID,
    RAZORPAY_KEY_SECRET
);

$attributes = [

    'razorpay_order_id'   => $_POST['razorpay_order_id'] ?? '',
    'razorpay_payment_id' => $_POST['razorpay_payment_id'] ?? '',
    'razorpay_signature'  => $_POST['razorpay_signature'] ?? ''

];

try {

    $api->utility->verifyPaymentSignature($attributes);

    $payment = $api->payment->fetch($_POST['razorpay_payment_id']);

    if ($payment->status != 'captured') {

        die('Payment not captured.');

    }

} catch (SignatureVerificationError $e) {

    die('Payment verification failed.');

}

/*
|--------------------------------------------------------------------------
| DUPLICATE PAYMENT CHECK
|--------------------------------------------------------------------------
*/

$check = $pdo->prepare("
    SELECT id
    FROM orders
    WHERE razorpay_payment_id=?
");

$check->execute([
    $_POST['razorpay_payment_id']
]);

if ($check->fetch()) {

    die("Payment already processed.");

}

/*
|--------------------------------------------------------------------------
| START TRANSACTION
|--------------------------------------------------------------------------
*/

$pdo->beginTransaction();

try {

    /*
    |--------------------------------------------------------------------------
    | INSERT ORDER
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO orders(

            user_id,
            order_number,

            customer_name,
            customer_email,
            customer_phone,
            customer_company,
            customer_address,
            customer_city,
            customer_state,
            customer_pincode,

            subtotal,
            gst_total,

            shipping_charge,
            shipping_method_id,
            shipping_method,
            shipping_gst_percent,
            shipping_gst,

            grand_total,

            payment_method,
            payment_status,
            payment_date,

            razorpay_order_id,
            razorpay_payment_id,
            razorpay_signature,

            order_status

        ) VALUES(

            ?,?,
            ?,?,?,?,?,?,?,?,
            ?,?,
            ?,?,?,?,?,
            ?,
            ?,?,
            ?,
            ?,?,?,
            ?

        )
    ");

    $stmt->execute([

        $_SESSION['user_id'] ?? null,

        $order['order_number'],

        $order['customer_name'],
        $order['customer_email'],
        $order['customer_phone'],
        $order['customer_company'],
        $order['customer_address'],
        $order['customer_city'],
        $order['customer_state'],
        $order['customer_pincode'],

        $order['subtotal'],
        $order['gst_total'],

        $order['shipping_charge'],
        $order['shipping_method_id'],
        $order['shipping_method'],
        $order['shipping_gst_percent'],
        $order['shipping_gst'],

        $order['grand_total'],

        'razorpay',
        'paid',
        date('Y-m-d H:i:s'),

        $_POST['razorpay_order_id'],
        $_POST['razorpay_payment_id'],
        $_POST['razorpay_signature'],

        'confirmed'

    ]);

    $orderId = $pdo->lastInsertId();

    /*
    |--------------------------------------------------------------------------
    | FETCH CART
    |--------------------------------------------------------------------------
    */

    $userId = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    if ($userId) {

        $cart = $pdo->prepare("
            SELECT
                cart.*,
                products.name,
                products.image,
                products.price,
                closure_options.name AS closure_name,
                closure_options.price AS closure_price,
                closure_options.image AS closure_image
            FROM cart
            JOIN products ON cart.product_id=products.id
            LEFT JOIN closure_options ON cart.closure_option_id=closure_options.id
            WHERE cart.user_id=?
        ");

        $cart->execute([$userId]);

    } else {

        $cart = $pdo->prepare("
            SELECT
                cart.*,
                products.name,
                products.image,
                products.price,
                closure_options.name AS closure_name,
                closure_options.price AS closure_price,
                closure_options.image AS closure_image
            FROM cart
            JOIN products ON cart.product_id=products.id
            LEFT JOIN closure_options ON cart.closure_option_id=closure_options.id
            WHERE cart.session_id=?
        ");

        $cart->execute([$sessionId]);

    }

    $items = $cart->fetchAll();

    /*
    |--------------------------------------------------------------------------
    | INSERT ITEMS
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| INSERT ITEMS
|--------------------------------------------------------------------------
*/

foreach ($items as $item) {


    /*
    |--------------------------------------------------------------------------
    | PRODUCT DATA
    |--------------------------------------------------------------------------
    */

    $qty =
        (int)$item['quantity'];

    $productPrice =
        (float)$item['price'];

    $gstPercent =
        (float)$item['gst_percent'];


    /*
    |--------------------------------------------------------------------------
    | PRODUCT CALCULATION
    |--------------------------------------------------------------------------
    */

    $productSubtotal =
        $productPrice * $qty;

    $productGST =
        ($productSubtotal * $gstPercent) / 100;

    $productTotal =
        $productSubtotal + $productGST;


    /*
    |--------------------------------------------------------------------------
    | INSERT PRODUCT
    |--------------------------------------------------------------------------
    */

    $itemStmt = $pdo->prepare("
        INSERT INTO order_items (
            order_id,
            product_id,
            closure_option_id,
            product_name,
            closure_option_name,
            product_image,
            price,
            closure_option_price,
            quantity,
            order_unit,
            pieces_per_box,
            gst_percent,
            line_total

        ) VALUES (
            ?, ?, NULL,
            ?, NULL,
            ?,
            ?, 0,
            ?, ?, ?,
            ?,
            ?
        )
    ");

    $itemStmt->execute([
        $orderId,
        $item['product_id'],
        $item['name'],
        $item['image'],
        $productPrice,
        $qty,
        $item['order_unit'],
        $item['pieces_per_box'],
        $gstPercent,
        $productTotal
    ]);


    /*
    |--------------------------------------------------------------------------
    | CLOSURE DATA
    |--------------------------------------------------------------------------
    */

    $closureOptionId =
        !empty($item['closure_option_id'])
            ? (int)$item['closure_option_id']
            : null;

    $closureName =
        $item['closure_name'] ?? null;

    $closureImage =
        $item['closure_image'] ?? null;

    $closurePrice =
        (float)($item['closure_price'] ?? 0);

    $closureQty =
        max(
            0,
            (int)($item['closure_quantity'] ?? 0)
        );


    /*
    |--------------------------------------------------------------------------
    | INSERT CLOSURE AS SEPARATE LINE
    |--------------------------------------------------------------------------
    */

    if (
        $closureOptionId &&
        $closurePrice > 0 &&
        $closureQty > 0
    ) {

        $closureSubtotal =
            $closurePrice * $closureQty;

        $closureGST =
            ($closureSubtotal * $gstPercent) / 100;

        $closureTotal =
            $closureSubtotal + $closureGST;


        $closureStmt = $pdo->prepare("
            INSERT INTO order_items (
                order_id,
                product_id,
                closure_option_id,
                product_name,
                closure_option_name,
                product_image,
                price,
                closure_option_price,
                quantity,
                order_unit,
                pieces_per_box,
                gst_percent,
                line_total

            ) VALUES (
                ?, NULL, ?,
                NULL, ?,
                ?,
                ?, ?,
                ?, 'piece', 1,
                ?,
                ?
            )
        ");

        $closureStmt->execute([
            $orderId,
            $closureOptionId,
            $closureName,
            $closureImage,
            $closurePrice,
            $closurePrice,
            $closureQty,
            $gstPercent,
            $closureTotal
        ]);
    }
}

    /*
    |--------------------------------------------------------------------------
    | CLEAR CART
    |--------------------------------------------------------------------------
    */

    if ($userId) {

        $clear = $pdo->prepare("
            DELETE FROM cart
            WHERE user_id=?
        ");

        $clear->execute([$userId]);

    } else {

        $clear = $pdo->prepare("
            DELETE FROM cart
            WHERE session_id=?
        ");

        $clear->execute([$sessionId]);

    }

    $pdo->commit();

} catch (Exception $e) {

    $pdo->rollBack();

    die($e->getMessage());

}

/*
|--------------------------------------------------------------------------
| CLEAN SESSION
|--------------------------------------------------------------------------
*/

unset($_SESSION['pending_order']);
unset($_SESSION['razorpay_order_id']);

/*
|--------------------------------------------------------------------------
| SUCCESS
|--------------------------------------------------------------------------
*/

header("Location: thankyou.php?order=" . $order['order_number']);
exit;