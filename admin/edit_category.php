<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| GET CATEGORY
|--------------------------------------------------------------------------
*/

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM categories
    WHERE id = ?
");

$stmt->execute([$id]);

$category = $stmt->fetch();

if(!$category){

    die("Category not found");

}

/*
|--------------------------------------------------------------------------
| UPDATE CATEGORY
|--------------------------------------------------------------------------
*/

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
    | CATEGORY IMAGE
    |--------------------------------------------------------------------------
    */

    $imageName = $category['image'];

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
    | BANNER IMAGE
    |--------------------------------------------------------------------------
    */

    $bannerImage = $category['banner_image'];

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
    | UPDATE
    |--------------------------------------------------------------------------
    */

    $updateStmt = $pdo->prepare("
        UPDATE categories
        SET

            name = ?,
            slug = ?,
            image = ?,
            description = ?,
            short_description = ?,
            banner_image = ?,
            featured = ?

        WHERE id = ?
    ");

    $updateStmt->execute([

        $name,
        $slug,
        $imageName,
        $description,
        $shortDescription,
        $bannerImage,
        $featured,
        $id

    ]);

    header("Location: categories.php");
    exit;
}

?>

<h2 class="mb-4">
    Edit Category
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
                value="<?= htmlspecialchars($category['name']) ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Slug</label>

            <input
                type="text"
                name="slug"
                class="form-control"
                value="<?= htmlspecialchars($category['slug']) ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Short Description</label>

            <textarea
                name="short_description"
                rows="3"
                class="form-control"
            ><?= htmlspecialchars($category['short_description']) ?></textarea>

        </div>

        <div class="form-group">

            <label>Description</label>

            <textarea
                name="description"
                rows="6"
                class="form-control"
            ><?= htmlspecialchars($category['description']) ?></textarea>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>Current Category Image</label>

                    <br>

                    <?php if(!empty($category['image'])): ?>

                        <img
                            src="../<?= htmlspecialchars($category['image']) ?>"
                            style="
                                width:120px;
                                height:120px;
                                object-fit:cover;
                                border-radius:8px;
                            "
                        >

                    <?php endif; ?>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>Current Banner Image</label>

                    <br>

                    <?php if(!empty($category['banner_image'])): ?>

                        <img
                            src="../<?= htmlspecialchars($category['banner_image']) ?>"
                            style="
                                width:220px;
                                height:120px;
                                object-fit:cover;
                                border-radius:8px;
                            "
                        >

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <div class="form-group">

            <label>Replace Category Image</label>

            <input
                type="file"
                name="image"
                class="form-control"
            >

        </div>

        <div class="form-group">

            <label>Replace Banner Image</label>

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
                <?= $category['featured'] ? 'checked' : '' ?>
            >

            <label
                class="form-check-label"
                for="featuredCheck"
            >
                Featured Category
            </label>

        </div>

        <button class="btn btn-dark">

            Update Category

        </button>

    </form>

</div>

</div>
</body>
</html>