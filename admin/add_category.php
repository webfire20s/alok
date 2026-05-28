<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name =
        trim($_POST['name']);

    $slug =
        trim($_POST['slug']);

    $description =
        trim($_POST['description']);

    $shortDescription =
        trim($_POST['short_description']);

    $featured =
        isset($_POST['featured']) ? 1 : 0;

    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */

    $imageName = '';

    if(!empty($_FILES['image']['name'])){

        $fileName =
            time() . '_' .
            basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../storage/media/" . $fileName
        );

        $imageName =
            "storage/media/" . $fileName;
    }

    /*
    |--------------------------------------------------------------------------
    | BANNER
    |--------------------------------------------------------------------------
    */

    $bannerImage = '';

    if(!empty($_FILES['banner_image']['name'])){

        $bannerFile =
            time() . '_banner_' .
            basename($_FILES['banner_image']['name']);

        move_uploaded_file(
            $_FILES['banner_image']['tmp_name'],
            "../storage/media/" . $bannerFile
        );

        $bannerImage =
            "storage/media/" . $bannerFile;
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO categories (

            name,
            slug,
            image,
            description,
            short_description,
            banner_image,
            featured

        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([

        $name,
        $slug,
        $imageName,
        $description,
        $shortDescription,
        $bannerImage,
        $featured

    ]);

    header("Location: categories.php");
    exit;
}

?>

<h2 class="mb-4">
    Add Category
</h2>

<div class="card-box p-4">

    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <div class="form-group">

            <label>Category Name</label>

            <input
                type="text"
                name="name"
                class="form-control"
                required
            >

        </div>

        <div class="form-group">

            <label>Slug</label>

            <input
                type="text"
                name="slug"
                class="form-control"
                required
            >

        </div>

        <div class="form-group">

            <label>Short Description</label>

            <textarea
                name="short_description"
                rows="3"
                class="form-control"
            ></textarea>

        </div>

        <div class="form-group">

            <label>Description</label>

            <textarea
                name="description"
                rows="6"
                class="form-control"
            ></textarea>

        </div>

        <div class="form-group">

            <label>Category Image</label>

            <input
                type="file"
                name="image"
                class="form-control"
            >

        </div>

        <div class="form-group">

            <label>Banner Image</label>

            <input
                type="file"
                name="banner_image"
                class="form-control"
            >

        </div>

        <div class="form-group form-check">

            <input
                type="checkbox"
                name="featured"
                class="form-check-input"
                id="featuredCheck"
            >

            <label
                class="form-check-label"
                for="featuredCheck"
            >
                Featured Category
            </label>

        </div>

        <button class="btn btn-dark">

            Save Category

        </button>

    </form>

</div>

</div>
</body>
</html>