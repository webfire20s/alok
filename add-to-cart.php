<?php

session_start();

require 'includes/db.php';

/*
|--------------------------------------------------------------------------
| GET FORM DATA
|--------------------------------------------------------------------------
*/

$productId = (int)($_POST['product_id'] ?? 0);

$quantity = (int)($_POST['quantity'] ?? 1);

$orderUnit = $_POST['order_unit'] ?? 'piece';

$sessionId = session_id();
$userId = $_SESSION['user_id'] ?? null;

/*
|--------------------------------------------------------------------------
| VALIDATE PRODUCT
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE id = ?
");

$stmt->execute([$productId]);

$product = $stmt->fetch();

if(!$product){
    die("Product not found");
}

/*
|--------------------------------------------------------------------------
| MOQ VALIDATION
|--------------------------------------------------------------------------
*/

if($quantity < $product['min_order_qty']){

    $quantity = $product['min_order_qty'];

}

/*
|--------------------------------------------------------------------------
| PIECES PER BOX
|--------------------------------------------------------------------------
*/

$piecesPerBox = (int)($product['pieces_per_box'] ?? 1);

/*
|--------------------------------------------------------------------------
| GST
|--------------------------------------------------------------------------
*/

$gstPercent = (float)($product['gst_percent'] ?? 18);

/*
|--------------------------------------------------------------------------
| CHECK EXISTING CART ITEM
|--------------------------------------------------------------------------
*/

if($userId){

    $cartStmt = $pdo->prepare("
        SELECT *
        FROM cart
        WHERE user_id = ?
        AND product_id = ?
        AND order_unit = ?
    ");

    $cartStmt->execute([
        $userId,
        $productId,
        $orderUnit
    ]);

}else{

    $cartStmt = $pdo->prepare("
        SELECT *
        FROM cart
        WHERE session_id = ?
        AND product_id = ?
        AND order_unit = ?
    ");

    $cartStmt->execute([
        $sessionId,
        $productId,
        $orderUnit
    ]);

}

$existing = $cartStmt->fetch();

/*
|--------------------------------------------------------------------------
| UPDATE EXISTING
|--------------------------------------------------------------------------
*/

if($existing){

    $updateStmt = $pdo->prepare("
        UPDATE cart
        SET quantity = quantity + ?
        WHERE id = ?
    ");

    $updateStmt->execute([
        $quantity,
        $existing['id']
    ]);

}else{

    /*
    |--------------------------------------------------------------------------
    | INSERT NEW
    |--------------------------------------------------------------------------
    */

    $insertStmt = $pdo->prepare("
        INSERT INTO cart (
            session_id,
            user_id,
            product_id,
            quantity,
            order_unit,
            pieces_per_box,
            gst_percent
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $insertStmt->execute([
        $sessionId,
        $userId,
        $productId,
        $quantity,
        $orderUnit,
        $piecesPerBox,
        $gstPercent
    ]);
}

/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: cart.php");

exit;