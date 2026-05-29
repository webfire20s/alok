<?php

session_start();

require 'includes/db.php';

$productId =
(int)($_POST['product_id'] ?? 0);

$customerName =
trim($_POST['customer_name'] ?? '');

$customerEmail =
trim($_POST['customer_email'] ?? '');

$rating =
(int)($_POST['rating'] ?? 5);

$review =
trim($_POST['review'] ?? '');

$userId =
$_SESSION['user_id'] ?? null;

/*
|--------------------------------------------------------------------------
| VALIDATION
|--------------------------------------------------------------------------
*/

if(
    !$productId ||
    !$customerName ||
    !$customerEmail ||
    !$review
){
    die("Invalid review data");
}

/*
|--------------------------------------------------------------------------
| INSERT REVIEW
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    INSERT INTO product_reviews (

        product_id,
        user_id,
        customer_name,
        customer_email,
        rating,
        review

    ) VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([

    $productId,
    $userId,
    $customerName,
    $customerEmail,
    $rating,
    $review

]);

header("Location: " . $_SERVER['HTTP_REFERER']);

exit;