<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM gallery
    WHERE id = ?
");

$stmt->execute([$id]);

$item = $stmt->fetch();

if(!$item){
    die('Not Found');
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $stmt = $pdo->prepare("
        UPDATE gallery
        SET
            title = ?,
            description = ?,
            category = ?
        WHERE id = ?
    ");

    $stmt->execute([

        $_POST['title'],
        $_POST['description'],
        $_POST['category'],
        $id

    ]);

    header("Location: gallery.php");
    exit;
}

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';
?>

<div class="content-wrapper">
<div class="container-fluid">

<form method="POST">

    <div class="form-group">

        <label>Title</label>

        <input
            type="text"
            name="title"
            class="form-control"
            value="<?= htmlspecialchars($item['title']) ?>"
        >

    </div>

    <div class="form-group">

        <label>Description</label>

        <textarea
            name="description"
            class="form-control"
            rows="5"
        ><?= htmlspecialchars($item['description']) ?></textarea>

    </div>

    <div class="form-group">

        <label>Category</label>

        <input
            type="text"
            name="category"
            class="form-control"
            value="<?= htmlspecialchars($item['category']) ?>"
        >

    </div>

    <button class="btn btn-primary">

        Update

    </button>

</form>

</div>
</div>

