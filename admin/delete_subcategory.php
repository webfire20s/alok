<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

if($id <= 0){

    header("Location: subcategories.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| GET SUBCATEGORY
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT image
    FROM subcategories
    WHERE id = ?
");

$stmt->execute([$id]);

$subcategory = $stmt->fetch();

if(!$subcategory){

    header("Location: subcategories.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| DELETE IMAGE
|--------------------------------------------------------------------------
*/

if(
    !empty($subcategory['image'])
    &&
    file_exists("../".$subcategory['image'])
){

    unlink("../".$subcategory['image']);

}

/*
|--------------------------------------------------------------------------
| DELETE SUBCATEGORY
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE
    FROM subcategories
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: subcategories.php");

exit;