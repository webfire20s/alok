<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| GET BLOG
|--------------------------------------------------------------------------
*/

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM blogs
    WHERE id = ?
");

$stmt->execute([$id]);

$blog = $stmt->fetch();

if(!$blog){

    die("Blog not found");

}

/*
|--------------------------------------------------------------------------
| UPDATE BLOG
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $title =
        trim($_POST['title']);

    $slug =
        trim($_POST['slug']);

    $shortDescription =
        trim($_POST['short_description']);

    $content =
        trim($_POST['content']);

    $videoUrl =
        trim($_POST['video_url']);

    $status =
        (int)$_POST['status'];

    $image =
        $blog['image'];

    /*
    |--------------------------------------------------------------------------
    | IMAGE REPLACE
    |--------------------------------------------------------------------------
    */

    if(!empty($_FILES['image']['name'])){

        $fileName =
            time().'_'.
            basename($_FILES['image']['name']);

        move_uploaded_file(

            $_FILES['image']['tmp_name'],

            '../storage/media/'.$fileName

        );

        $image =
            'storage/media/'.$fileName;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    $update = $pdo->prepare("
        UPDATE blogs
        SET

            title = ?,
            slug = ?,
            image = ?,
            short_description = ?,
            content = ?,
            video_url = ?,
            status = ?

        WHERE id = ?
    ");

    $update->execute([

        $title,
        $slug,
        $image,
        $shortDescription,
        $content,
        $videoUrl,
        $status,
        $id

    ]);

    header("Location: blogs.php");
    exit;
}

?>

<h2 class="mb-4">
    Edit Blog
</h2>

<div class="card-box p-4">

<form
    method="POST"
    enctype="multipart/form-data"
>

    <div class="form-group">

        <label>Title</label>

        <input
            type="text"
            name="title"
            class="form-control"
            value="<?= htmlspecialchars($blog['title']) ?>"
            required
        >

    </div>

    <div class="form-group">

        <label>Slug</label>

        <input
            type="text"
            name="slug"
            class="form-control"
            value="<?= htmlspecialchars($blog['slug']) ?>"
            required
        >

    </div>

    <div class="form-group">

        <label>Short Description</label>

        <textarea
            name="short_description"
            rows="3"
            class="form-control"
        ><?= htmlspecialchars($blog['short_description']) ?></textarea>

    </div>

    <div class="form-group">

        <label>Content</label>

        <textarea
            name="content"
            rows="12"
            class="form-control"
        ><?= htmlspecialchars($blog['content']) ?></textarea>

    </div>

    <div class="form-group">

        <label>YouTube URL</label>

        <input
            type="text"
            name="video_url"
            class="form-control"
            value="<?= htmlspecialchars($blog['video_url']) ?>"
        >

    </div>

    <div class="form-group">

        <label>Current Image</label>

        <br>

        <?php if(!empty($blog['image'])): ?>

            <img
                src="../<?= htmlspecialchars($blog['image']) ?>"
                style="
                    width:180px;
                    border-radius:8px;
                "
            >

        <?php endif; ?>

    </div>

    <div class="form-group">

        <label>Replace Image</label>

        <input
            type="file"
            name="image"
            class="form-control"
        >

    </div>

    <div class="form-group">

        <label>Status</label>

        <select
            name="status"
            class="form-control"
        >

            <option
                value="1"
                <?= $blog['status']==1?'selected':'' ?>
            >
                Published
            </option>

            <option
                value="0"
                <?= $blog['status']==0?'selected':'' ?>
            >
                Draft
            </option>

        </select>

    </div>

    <button class="btn btn-dark">

        Update Blog

    </button>

</form>

</div>

</div>
</body>
</html>