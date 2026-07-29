<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT image
    FROM tour_images
    WHERE id=?
");

$stmt->execute([$id]);

$image = $stmt->fetch();

if($image){

    $file="../storage/tour/".$image['image'];

    if(file_exists($file)){
        unlink($file);
    }

    $delete=$pdo->prepare("
        DELETE
        FROM tour_images
        WHERE id=?
    ");

    $delete->execute([$id]);

}

header("Location: tour_images.php");

exit;