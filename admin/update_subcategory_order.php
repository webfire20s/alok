<?php

require 'includes/auth.php';
require '../includes/db.php';

$data=json_decode(file_get_contents("php://input"),true);

$stmt=$pdo->prepare("
UPDATE subcategories
SET display_order=?
WHERE id=?
");

foreach($data as $row){

    $stmt->execute([
        $row['order'],
        $row['id']
    ]);

}

echo "success";