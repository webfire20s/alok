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

$closureOptionId = !empty($_POST['closure_option_id'])
    ? (int)$_POST['closure_option_id']
    : null;

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
| VALIDATE CLOSURE OPTION
|--------------------------------------------------------------------------
*/

if($closureOptionId){

    $closureStmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM product_closure_options pco
        INNER JOIN closure_options co
            ON co.id = pco.closure_option_id
        WHERE
            pco.product_id = ?
            AND pco.closure_option_id = ?
            AND co.status = 1
    ");

    $closureStmt->execute([
        $productId,
        $closureOptionId
    ]);

    if(!$closureStmt->fetchColumn()){
        die("Invalid closure option.");
    }

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
        AND (
            closure_option_id = ?
            OR (closure_option_id IS NULL AND ? IS NULL)
        )
    ");

    $cartStmt->execute([
        $userId,
        $productId,
        $orderUnit,
        $closureOptionId,
        $closureOptionId
    ]);

}else{

    $cartStmt = $pdo->prepare("
        SELECT *
        FROM cart
        WHERE session_id = ?
        AND product_id = ?
        AND order_unit = ?
        AND (
            closure_option_id = ?
            OR (closure_option_id IS NULL AND ? IS NULL)
        )
    ");

    $cartStmt->execute([
        
        $sessionId,
        $productId,
        $orderUnit,
        $closureOptionId,
        $closureOptionId
    
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
            closure_option_id,
            quantity,
            order_unit,
            pieces_per_box,
            gst_percent
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $insertStmt->execute([
        $sessionId,
        $userId,
        $productId,
        $closureOptionId,
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