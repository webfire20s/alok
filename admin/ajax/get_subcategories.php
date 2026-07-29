<?php

require '../../includes/db.php';

header('Content-Type: application/json');

$categoryId = (int)($_GET['category_id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT
        id,
        name
    FROM subcategories
    WHERE category_id = ?
    AND status = 1
    ORDER BY
        display_order ASC,
        name ASC
");

$stmt->execute([$categoryId]);

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);