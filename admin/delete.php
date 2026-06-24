<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("
    SELECT image
    FROM gallery
    WHERE id = ?
");

$stmt->execute([$id]);

$image = $stmt->fetchColumn();

if($image){

    @unlink('../' . $image);

    $stmt = $pdo->prepare("
        DELETE FROM gallery
        WHERE id = ?
    ");

    $stmt->execute([$id]);
}

header("Location: gallery.php");
exit;