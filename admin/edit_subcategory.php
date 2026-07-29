<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

/*
|--------------------------------------------------------------------------
| SUBCATEGORY
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM subcategories
    WHERE id=?
");

$stmt->execute([$id]);

$subcategory = $stmt->fetch();

if(!$subcategory){

    die("Subcategory not found");

}

/*
|--------------------------------------------------------------------------
| CATEGORIES
|--------------------------------------------------------------------------
*/

$categories = $pdo->query("
    SELECT id,name
    FROM categories
    ORDER BY name
")->fetchAll();

/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

if(isset($_POST['update'])){

    $categoryId = (int)$_POST['category_id'];

    $name = trim($_POST['name']);

    $slug = trim($_POST['slug']);

    $featured = isset($_POST['featured']) ? 1 : 0;

    $status = isset($_POST['status']) ? 1 : 0;

    $image = $subcategory['image'];

    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */

    if(!empty($_FILES['image']['name'])){

        if(
            !empty($image)
            &&
            file_exists("../".$image)
        ){

            unlink("../".$image);

        }

        $extension = strtolower(
            pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            )
        );

        $imageName =
            time().'_'.uniqid().'.'.$extension;

        move_uploaded_file(

            $_FILES['image']['tmp_name'],

            "../storage/media/".$imageName

        );

        $image =
            "storage/media/".$imageName;

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("

        UPDATE subcategories

        SET

            category_id=?,
            name=?,
            slug=?,
            image=?,
            featured=?,
            status=?

        WHERE id=?

    ");

    $stmt->execute([

        $categoryId,

        $name,

        $slug,

        $image,

        $featured,

        $status,

        $id

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
            <h3 style="color:#fff;"> Edit Subcategory </h3>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" >

                <div class="row">
                    <div class="col-md-6 mb-3">

                        <label class="text-white"> Category </label>
                        <select name="category_id" class="form-control" required >

                            <?php foreach($categories as $category): ?>

                            <option value="<?= $category['id'] ?>" <?= $subcategory['category_id']==$category['id'] ? 'selected' : '' ?> >

                            <?= htmlspecialchars($category['name']) ?>

                            </option>

                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-white"> Subcategory Name </label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($subcategory['name']) ?>" required >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-white"> Slug </label>
                        <input type="text" name="slug" id="slug" class="form-control" value="<?= htmlspecialchars($subcategory['slug']) ?>" required >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-white"> Image </label>
                        <input type="file" name="image" class="form-control" accept="image/*" >

                        <?php if($subcategory['image']): ?>

                        <img src="../<?= $subcategory['image'] ?>" style=" height:80px; margin-top:10px; border-radius:8px; ">

                        <?php endif; ?>
                    </div>

                    <div class="col-md-3">
                        <label> <input type="checkbox" name="featured" <?= $subcategory['featured'] ? 'checked' : '' ?> > Featured </label>
                    </div>

                    <div class="col-md-3">
                        <label>
                        <input type="checkbox" name="status" <?= $subcategory['status'] ? 'checked' : '' ?> > Active</label>
                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn btn-primary" name="update" > Update Subcategory </button>
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