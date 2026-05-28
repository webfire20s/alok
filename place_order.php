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
            products.price
        FROM cart
        JOIN products
        ON cart.product_id = products.id
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
            products.price
        FROM cart
        JOIN products
        ON cart.product_id = products.id
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
| TOTALS
|--------------------------------------------------------------------------
*/

$subtotal = 0;

$totalGST = 0;

foreach($cartItems as $item){

    $qty = $item['quantity'];

    $price = $item['price'];

    $gstPercent = $item['gst_percent'];

    $lineSubtotal =
    $price * $qty;

    $gstAmount =
    ($lineSubtotal * $gstPercent) / 100;

    $subtotal += $lineSubtotal;

    $totalGST += $gstAmount;
}

$grandTotal =
$subtotal + $totalGST;

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
        grand_total,

        payment_method,
        order_status

    ) VALUES (

        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?,
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

    $price = $item['price'];

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
            product_name,
            product_image,
            price,
            quantity,
            order_unit,
            pieces_per_box,
            gst_percent,
            line_total

        ) VALUES (

            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?

        )
    ");

    $itemStmt->execute([

        $orderId,
        $item['product_id'],
        $item['name'],
        $item['image'],
        $price,
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

$clearStmt = $pdo->prepare("
    DELETE FROM cart
    WHERE session_id = ?
");

$clearStmt->execute([$sessionId]);

/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: thankyou.php?order=" . $orderNumber);

exit;