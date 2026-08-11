<?php

session_start();

require 'includes/db.php';

$cartId = (int)($_GET['id'] ?? 0);

if($cartId <= 0){

    header("Location: cart.php");
    exit;

}

$userId = $_SESSION['user_id'] ?? null;
$sessionId = session_id();


if($userId){

    $stmt = $pdo->prepare("
        UPDATE cart
        SET closure_option_id = NULL
        WHERE id = ?
        AND user_id = ?
    ");

    $stmt->execute([
        $cartId,
        $userId
    ]);

}else{

    $stmt = $pdo->prepare("
        UPDATE cart
        SET closure_option_id = NULL
        WHERE id = ?
        AND session_id = ?
    ");

    $stmt->execute([
        $cartId,
        $sessionId
    ]);

}


header("Location: cart.php");
exit;