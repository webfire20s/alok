<?php

require 'includes/auth.php';
require '../includes/db.php';

$categories = $pdo->query("
    SELECT id,name
    FROM categories
    ORDER BY name
")->fetchAll();

if(isset($_POST['save'])){

    $categoryId = (int)$_POST['category_id'];
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $featured = isset($_POST['featured']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;

    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */

    $image = '';

    if(!empty($_FILES['image']['name'])){

        $extension = strtolower(
            pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION)
        );

        $imageName =
            time().'_'.uniqid().'.'.$extension;

        $destination =
            '../storage/media/'.$imageName;

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $destination
        );

        $image =
            'storage/media/'.$imageName;

    }

    /*
    |--------------------------------------------------------------------------
    | DISPLAY ORDER
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT COALESCE(MAX(display_order),0)+1
        FROM subcategories
        WHERE category_id=?
    ");

    $stmt->execute([$categoryId]);

    $displayOrder = $stmt->fetchColumn();

    /*
    |--------------------------------------------------------------------------
    | INSERT
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO subcategories(

            category_id,
            name,
            slug,
            image,
            featured,
            status,
            display_order

        )VALUES(?,?,?,?,?,?,?)
    ");

    $stmt->execute([

        $categoryId,
        $name,
        $slug,
        $image,
        $featured,
        $status,
        $displayOrder

    ]);

    header("Location: subcategories.php");

    exit;

}

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

    <div class="card border-0" style=" background:rgba(21,25,34,.60); border-radius:14px; ">

        <div class="card-header">
            <h3 style="color:#fff;"> Add Subcategory </h3>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" >

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label text-white"> Category </label>
                        <select name="category_id" class="form-control" required >

                            <option value=""> Select Category </option>

                            <?php foreach($categories as $category): ?>

                            <option value="<?= $category['id'] ?>" >

                            <?= htmlspecialchars($category['name']) ?>

                            </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label text-white"> Subcategory Name </label>
                        <input type="text" name="name" id="name" class="form-control" required >

                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label text-white"> Slug </label>
                        <input type="text" name="slug" id="slug" class="form-control" required >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label text-white"> Image </label>
                        <input type="file" name="image" class="form-control" accept="image/*" >
                    </div>

                    <div class="col-md-3 mb-3">

                        <label>
                        <input type="checkbox" name="featured" > Featured </label>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label>
                        <input type="checkbox" name="status" checked > Active </label>

                    </div>

                    <div class="col-12">

                        <button type="submit" name="save" class="btn btn-primary" > Save Subcategory </button>
                        <a href="subcategories.php" class="btn btn-secondary" > Cancel </a>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    document .getElementById("name") .addEventListener("keyup",function(){

        document
        .getElementById("slug")
        .value=this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g,"-")
        .replace(/^-|-$/g,"");

    });

</script>

</body>

</html>