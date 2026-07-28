<?php

require 'includes/auth.php';
require '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    exit;
}

$stmt = $pdo->prepare("
    UPDATE products
    SET display_order = ?
    WHERE id = ?
");

foreach ($data as $row) {

    $stmt->execute([
        (int)$row['order'],
        (int)$row['id']
    ]);

}

echo json_encode([
    "success" => true
]);