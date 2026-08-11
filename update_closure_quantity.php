<?php

session_start();

require 'includes/db.php';

$cartId = (int)($_POST['id'] ?? 0);

$closureQuantity = (int)($_POST['closure_quantity'] ?? 0);

if($cartId <= 0 || $closureQuantity < 1){

    header("Location: cart.php");
    exit;

}

$userId = $_SESSION['user_id'] ?? null;

$sessionId = session_id();

if($userId){

    $stmt = $pdo->prepare("
        UPDATE cart
        SET closure_quantity = ?
        WHERE id = ?
        AND user_id = ?
        AND closure_option_id IS NOT NULL
    ");

    $stmt->execute([
        $closureQuantity,
        $cartId,
        $userId
    ]);

}else{

    $stmt = $pdo->prepare("
        UPDATE cart
        SET closure_quantity = ?
        WHERE id = ?
        AND session_id = ?
        AND closure_option_id IS NOT NULL
    ");

    $stmt->execute([
        $closureQuantity,
        $cartId,
        $sessionId
    ]);

}

header("Location: cart.php");
exit;