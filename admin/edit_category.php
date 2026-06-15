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

<div class="container-fluid py-4">

    <div class="mb-4 mb-md-5">
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
            Edit Category
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Modify properties, routing endpoints, or image assets for this product group.
        </p>
    </div>

    <div class="card border-0" style="
        border-radius: 14px;
        background: rgba(21, 25, 34, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    ">
        <div class="card-body p-4 p-md-5">

            <form method="POST" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Category Name
                            </label>
                            <input type="text" name="name" class="form-control glass-input" value="<?= htmlspecialchars($category['name']) ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Slug
                            </label>
                            <input type="text" name="slug" class="form-control glass-input" value="<?= htmlspecialchars($category['slug']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Short Description
                    </label>
                    <textarea name="short_description" rows="2" class="form-control glass-input"><?= htmlspecialchars($category['short_description']) ?></textarea>
                </div>

                <div class="form-group mb-4">
                    <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Description
                    </label>
                    <textarea name="description" rows="5" class="form-control glass-input"><?= htmlspecialchars($category['description']) ?></textarea>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: block;">
                                Current Category Image
                            </label>
                            <?php if(!empty($category['image'])): ?>
                                <div style="
                                    width: 120px;
                                    height: 120px;
                                    overflow: hidden;
                                    border-radius: 8px;
                                    border: 1px solid rgba(255, 255, 255, 0.08);
                                    background: rgba(15, 17, 21, 0.8);
                                ">
                                    <img src="../<?= htmlspecialchars($category['image']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            <?php else: ?>
                                <div style="width: 120px; height: 120px; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.1); background: rgba(255,255,255,0.01); display: flex; align-items: center; justify-content: center; font-size: 12px; color: #475569;">
                                    None Set
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: block;">
                                Current Banner Image
                            </label>
                            <?php if(!empty($category['banner_image'])): ?>
                                <div style="
                                    width: 220px;
                                    height: 120px;
                                    overflow: hidden;
                                    border-radius: 8px;
                                    border: 1px solid rgba(255, 255, 255, 0.08);
                                    background: rgba(15, 17, 21, 0.8);
                                ">
                                    <img src="../<?= htmlspecialchars($category['banner_image']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            <?php else: ?>
                                <div style="width: 220px; height: 120px; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.1); background: rgba(255,255,255,0.01); display: flex; align-items: center; justify-content: center; font-size: 12px; color: #475569;">
                                    None Set
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Replace Category Image
                            </label>
                            <input type="file" name="image" class="form-control glass-file-input">
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label style="color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Replace Banner Image
                            </label>
                            <input type="file" name="banner_image" class="form-control glass-file-input">
                        </div>
                    </div>
                </div>

                <div class="form-group form-check mb-5 d-flex align-items-center" style="padding-left: 0; gap: 10px;">
                    <div class="custom-checkbox-wrapper" style="position: relative; width: 20px; height: 20px;">
                        <input type="checkbox" name="featured" id="featuredCheck" <?= $category['featured'] ? 'checked' : '' ?> style="
                            width: 20px;
                            height: 20px;
                            cursor: pointer;
                            appearance: none;
                            -webkit-appearance: none;
                            background: <?= $category['featured'] ? '#38bdf8' : 'rgba(255, 255, 255, 0.02)' ?>;
                            border: 1px solid <?= $category['featured'] ? '#38bdf8' : 'rgba(255, 255, 255, 0.1)' ?>;
                            border-radius: 6px;
                            outline: none;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            transition: all 0.2s ease;
                        " onchange="this.style.background = this.checked ? '#38bdf8' : 'rgba(255, 255, 255, 0.02)';"
                        onmouseover="this.style.borderColor = 'rgba(56, 189, 248, 0.5)';"
                        onmouseout="this.style.borderColor = this.checked ? '#38bdf8' : 'rgba(255, 255, 255, 0.1)';">
                    </div>
                    <label class="form-check-label" for="featuredCheck" style="color: #e2e8f0; font-size: 14px; font-weight: 500; cursor: pointer; user-select: none;">
                        Featured Category
                    </label>
                </div>

                <button class="btn px-5 py-2.5 btn-glow-transition" style="
                    background: linear-gradient(135deg, #38bdf8, #0284c7);
                    color: #ffffff;
                    font-weight: 600;
                    font-size: 14px;
                    border: none;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(56, 189, 248, 0.25);
                ">
                    Update Category
                </button>

            </form>

        </div>
    </div>

</div>

<style>
    /* Styling Standard Text Field and Area Elements */
    .glass-input {
        background: rgba(15, 17, 21, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 8px !important;
        color: #ffffff !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        transition: all 0.2s ease-in-out !important;
    }
    .glass-input:focus {
        background: rgba(15, 17, 21, 0.6) !important;
        border-color: rgba(56, 189, 248, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15) !important;
        outline: none !important;
    }

    /* Styling Custom Native File Picker Fields */
    .glass-file-input {
        background: rgba(15, 17, 21, 0.4) !important;
        border: 1px dashed rgba(255, 255, 255, 0.15) !important;
        border-radius: 8px !important;
        color: #94a3b8 !important;
        padding: 8px !important;
        font-size: 14px !important;
    }
    .glass-file-input::-webkit-file-upload-button {
        background: rgba(255, 255, 255, 0.05);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px 12px;
        border-radius: 6px;
        cursor: pointer;
        margin-right: 10px;
        font-size: 13px;
        transition: background 0.2s;
    }
    .glass-file-input::-webkit-file-upload-button:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* Glow Transitions for Action Controls */
    .btn-glow-transition {
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }
    .btn-glow-transition:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(56, 189, 248, 0.4) !important;
    }

    /* Inject dynamic checkmark for the custom featured box */
    #featuredCheck:checked::after {
        content: '';
        position: absolute;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        top: 3px;
        left: 7px;
    }
</style>