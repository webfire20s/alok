<?php

session_start();

require 'includes/db.php';

/*
|--------------------------------------------------------------------------
| SESSION
|--------------------------------------------------------------------------
*/

$sessionId = session_id();

/*
|--------------------------------------------------------------------------
| GET CART ITEMS
|--------------------------------------------------------------------------
*/

$userId = $_SESSION['user_id'] ?? null;

$sessionId = session_id();

if($userId){

    $stmt = $pdo->prepare("
        SELECT
            cart.*,
            products.name,
            products.image,
            products.slug,
            products.price,

            closure_options.name AS closure_name,
            closure_options.price AS closure_price

        FROM cart

        JOIN products
        ON cart.product_id = products.id

        LEFT JOIN closure_options
        ON cart.closure_option_id = closure_options.id

        WHERE cart.user_id = ?
        ORDER BY cart.id DESC
    ");

    $stmt->execute([$userId]);

}else{

    $stmt = $pdo->prepare("
        SELECT
            cart.*,
            products.name,
            products.image,
            products.slug,
            products.price,

            closure_options.name AS closure_name,
            closure_options.price AS closure_price

        FROM cart

        JOIN products
        ON cart.product_id = products.id

        LEFT JOIN closure_options
        ON cart.closure_option_id = closure_options.id

        WHERE cart.session_id = ?
        ORDER BY cart.id DESC
    ");

    $stmt->execute([$sessionId]);

}

$cartItems = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| EMPTY CART CHECK
|--------------------------------------------------------------------------
*/

if(empty($cartItems)){

    header("Location: cart.php");

    exit;
}

/*
|--------------------------------------------------------------------------
| CUSTOMER DATA
|--------------------------------------------------------------------------
*/

$customerName =
trim($_POST['customer_name'] ?? '');

$customerEmail =
trim($_POST['customer_email'] ?? '');

$customerPhone =
trim($_POST['customer_phone'] ?? '');

$customerCompany =
trim($_POST['customer_company'] ?? '');

$customerAddress =
trim($_POST['customer_address'] ?? '');

$customerCity =
trim($_POST['customer_city'] ?? '');

$customerState =
trim($_POST['customer_state'] ?? '');

$customerPincode =
trim($_POST['customer_pincode'] ?? '');

$paymentMethod =
trim($_POST['payment_method'] ?? 'inquiry');

/*
|--------------------------------------------------------------------------
| SHIPPING
|--------------------------------------------------------------------------
*/

$shippingMethodId = (int)($_POST['shipping_method_id'] ?? 0);

$shippingMethod = trim($_POST['shipping_method'] ?? '');

$shippingCharge = (float)($_POST['shipping_charge'] ?? 0);

$shippingGSTPercent = (float)($_POST['shipping_gst_percent'] ?? 0);

$shippingGST = (float)($_POST['shipping_gst'] ?? 0);

/*
|--------------------------------------------------------------------------
| TOTALS
|--------------------------------------------------------------------------
*/

$subtotal = 0;

$totalGST = 0;

foreach($cartItems as $item){

    $qty = $item['quantity'];

    $productPrice = (float)$item['price'];

    $closurePrice = (float)($item['closure_price'] ?? 0);

    $price = $productPrice + $closurePrice;

    $gstPercent = $item['gst_percent'];

    $lineSubtotal =
    $price * $qty;

    $gstAmount =
    ($lineSubtotal * $gstPercent) / 100;

    $subtotal += $lineSubtotal;

    $totalGST += $gstAmount;
}

$grandTotal =
    $subtotal +
    $totalGST +
    $shippingCharge +
    $shippingGST;

/*
|--------------------------------------------------------------------------
| ORDER NUMBER
|--------------------------------------------------------------------------
*/

$orderNumber =
'ORD' . date('YmdHis') . rand(100,999);

/*
|--------------------------------------------------------------------------
| INSERT ORDER
|--------------------------------------------------------------------------
*/

$orderStmt = $pdo->prepare("

    INSERT INTO orders (

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
        order_status

    ) VALUES (

        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,

        ?, ?,

        ?, ?, ?, ?, ?,

        ?,

        ?, ?

    )

");

$orderStmt->execute([

    $_SESSION['user_id'] ?? null,
    $orderNumber,

    $customerName,
    $customerEmail,
    $customerPhone,
    $customerCompany,
    $customerAddress,
    $customerCity,
    $customerState,
    $customerPincode,

    $subtotal,
    $totalGST,

    $shippingCharge,
    $shippingMethodId,
    $shippingMethod,
    $shippingGSTPercent,
    $shippingGST,

    $grandTotal,

    $paymentMethod,
    'pending'

]);

$orderId = $pdo->lastInsertId();

/*
|--------------------------------------------------------------------------
| INSERT ORDER ITEMS
|--------------------------------------------------------------------------
*/

foreach($cartItems as $item){

    $qty = $item['quantity'];

    $productPrice = (float)$item['price'];

    $closurePrice = (float)($item['closure_price'] ?? 0);

    $price = $productPrice + $closurePrice;

    $gstPercent = $item['gst_percent'];

    $lineSubtotal =
    $price * $qty;

    $gstAmount =
    ($lineSubtotal * $gstPercent) / 100;

    $lineTotal =
    $lineSubtotal + $gstAmount;

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

            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?

        )
    ");

    $itemStmt->execute([

        $orderId,

        $item['product_id'],
        $item['closure_option_id'],

        $item['name'],
        $item['closure_name'],

        $item['image'],

        $price,
        $item['closure_price'] ?? 0,

        $qty,
        $item['order_unit'],
        $item['pieces_per_box'],
        $gstPercent,
        $lineTotal

    ]);
}

/*
|--------------------------------------------------------------------------
| CLEAR CART
|--------------------------------------------------------------------------
*/

if($userId){

    $clearStmt = $pdo->prepare("
        DELETE FROM cart
        WHERE user_id = ?
    ");

    $clearStmt->execute([$userId]);

}else{

    $clearStmt = $pdo->prepare("
        DELETE FROM cart
        WHERE session_id = ?
    ");

    $clearStmt->execute([$sessionId]);

}
/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: thankyou.php?order=" . $orderNumber);

exit;