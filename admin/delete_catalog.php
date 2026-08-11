<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: catalogs.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH CATALOG
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM catalogs
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$catalog = $stmt->fetch();

if (!$catalog) {
    header("Location: catalogs.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| DELETE THUMBNAIL FILE
|--------------------------------------------------------------------------
*/

if (!empty($catalog['thumbnail'])) {

    $thumbnailPath = dirname(__DIR__) . '/' . ltrim($catalog['thumbnail'], '/');

    if (is_file($thumbnailPath)) {
        unlink($thumbnailPath);
    }
}


/*
|--------------------------------------------------------------------------
| DELETE CATALOG FILE
|--------------------------------------------------------------------------
*/

if (!empty($catalog['file_path'])) {

    $filePath = dirname(__DIR__) . '/' . ltrim($catalog['file_path'], '/');

    if (is_file($filePath)) {
        unlink($filePath);
    }
}


/*
|--------------------------------------------------------------------------
| DELETE DATABASE RECORD
|--------------------------------------------------------------------------
*/

$deleteStmt = $pdo->prepare("
    DELETE FROM catalogs
    WHERE id = ?
");

$deleteStmt->execute([$id]);


/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: catalogs.php");
exit;