<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| SAVE BLOG
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
        (int)($_POST['status'] ?? 1);

    /*
    |--------------------------------------------------------------------------
    | IMAGE UPLOAD
    |--------------------------------------------------------------------------
    */

    $image = '';

    if(!empty($_FILES['image']['name'])){

        $fileName =
            time() . '_' .
            basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            '../storage/media/' . $fileName
        );

        $image =
            'storage/media/' . $fileName;
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT BLOG
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO blogs(

            title,
            slug,
            image,
            short_description,
            content,
            video_url,
            status

        ) VALUES(

            ?, ?, ?, ?, ?, ?, ?

        )
    ");

    $stmt->execute([

        $title,
        $slug,
        $image,
        $shortDescription,
        $content,
        $videoUrl,
        $status

    ]);

    header("Location: blogs.php");
    exit;
}

?>

<h2 class="mb-4">
    Add Blog
</h2>

<div class="card-box p-4">

    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <div class="form-group">

            <label>
                Blog Title
            </label>

            <input
                type="text"
                name="title"
                class="form-control"
                required
            >

        </div>

        <div class="form-group">

            <label>
                Slug
            </label>

            <input
                type="text"
                name="slug"
                class="form-control"
                required
            >

            <small class="text-muted">

                Example:
                glass-bottle-buying-guide

            </small>

        </div>

        <div class="form-group">

            <label>
                Short Description
            </label>

            <textarea
                name="short_description"
                rows="3"
                class="form-control"
            ></textarea>

        </div>

        <div class="form-group">

            <label>
                Blog Content
            </label>

            <textarea
                name="content"
                rows="12"
                class="form-control"
            ></textarea>

        </div>

        <div class="form-group">

            <label>
                YouTube Video URL
            </label>

            <input
                type="text"
                name="video_url"
                class="form-control"
                placeholder="https://www.youtube.com/embed/xxxxx"
            >

        </div>

        <div class="form-group">

            <label>
                Featured Image
            </label>

            <input
                type="file"
                name="image"
                class="form-control"
            >

        </div>

        <div class="form-group">

            <label>
                Status
            </label>

            <select
                name="status"
                class="form-control"
            >

                <option value="1">
                    Published
                </option>

                <option value="0">
                    Draft
                </option>

            </select>

        </div>

        <button
            class="btn btn-dark"
        >
            Save Blog
        </button>

    </form>

</div>

</div>
</body>
</html>