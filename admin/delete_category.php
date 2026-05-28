<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

/*
|--------------------------------------------------------------------------
| OPTIONAL:
| DELETE CATEGORY IMAGES
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM categories
    WHERE id = ?
");

$stmt->execute([$id]);

$category = $stmt->fetch();

if($category){

    if(!empty($category['image'])){

        $imagePath =
            "../" . $category['image'];

        if(file_exists($imagePath)){

            unlink($imagePath);

        }
    }

    if(!empty($category['banner_image'])){

        $bannerPath =
            "../" . $category['banner_image'];

        if(file_exists($bannerPath)){

            unlink($bannerPath);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CATEGORY
    |--------------------------------------------------------------------------
    */

    $deleteStmt = $pdo->prepare("
        DELETE FROM categories
        WHERE id = ?
    ");

    $deleteStmt->execute([$id]);
}

header("Location: categories.php");
exit;