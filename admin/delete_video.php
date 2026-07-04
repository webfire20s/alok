<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

if(!$id){

    header("Location: video_gallery.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| CHECK VIDEO EXISTS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM video_gallery
    WHERE id = ?
");

$stmt->execute([$id]);

$video = $stmt->fetch();

if(!$video){

    header("Location: video_gallery.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

$delete = $pdo->prepare("
    DELETE FROM video_gallery
    WHERE id = ?
");

$delete->execute([$id]);

header("Location: video_gallery.php");

exit;

?>