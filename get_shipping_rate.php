<?php

require 'includes/db.php';

header('Content-Type: application/json');

$stateId = (int)($_GET['state_id'] ?? 0);
$methodId = (int)($_GET['shipping_method_id'] ?? 0);

if($stateId <= 0 || $methodId <= 0){

    echo json_encode([
        'success' => false
    ]);

    exit;
}

$stmt = $pdo->prepare("
    SELECT
        shipping_rates.charge,
        shipping_methods.name,
        shipping_methods.gst_percent
    FROM shipping_rates

    INNER JOIN shipping_methods
        ON shipping_rates.shipping_method_id = shipping_methods.id

    WHERE shipping_rates.state_id = ?
    AND shipping_rates.shipping_method_id = ?
    AND shipping_rates.status = 1

    LIMIT 1
");

$stmt->execute([
    $stateId,
    $methodId
]);

$rate = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$rate){

    echo json_encode([
        'success' => false
    ]);

    exit;
}

$shippingCharge = (float)$rate['charge'];
$gstPercent = (float)$rate['gst_percent'];
$shippingGST = ($shippingCharge * $gstPercent) / 100;

echo json_encode([

    'success' => true,

    'charge' => round($shippingCharge,2),

    'gst_percent' => $gstPercent,

    'gst' => round($shippingGST,2),

    'method' => $rate['name']

]);