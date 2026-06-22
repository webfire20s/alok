<?php

require 'includes/auth.php';
require '../includes/db.php';



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
include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';
?>

<style>
    .glass-input-field {
        background: rgba(15, 17, 21, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 8px !important;
        color: #ffffff !important;
        font-size: 14px !important;
        transition: all 0.2s ease-in-out !important;
    }
    .glass-input-field:focus {
        background: rgba(15, 17, 21, 0.6) !important;
        border-color: rgba(56, 189, 248, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15) !important;
    }
    .glass-input-field::placeholder {
        color: #475569 !important;
    }
    .glass-label {
        color: #94a3b8; 
        font-size: 12px; 
        font-weight: 600; 
        text-transform: uppercase; 
        letter-spacing: 0.04em; 
        margin-bottom: 8px; 
        display: block;
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-5">
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
            Edit Blog
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Modify core copy specifications, update contextual metadata, replace media configurations, or adjust deployment visibility logs.
        </p>
    </div>

    <div class="card border-0 p-4 mb-4" style="
        max-width: 900px;
        border-radius: 14px;
        background: rgba(21, 25, 34, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    ">

        <form method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-control glass-input-field" 
                        value="<?= htmlspecialchars($blog['title']) ?>" 
                        required
                    >
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Slug</label>
                    <input 
                        type="text" 
                        name="slug" 
                        class="form-control glass-input-field" 
                        value="<?= htmlspecialchars($blog['slug']) ?>" 
                        required
                    >
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">Short Description</label>
                <textarea name="short_description" rows="3" class="form-control glass-input-field"><?= htmlspecialchars($blog['short_description']) ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">Content</label>
                <textarea name="content" rows="12" class="form-control glass-input-field" style="line-height: 1.6;"><?= htmlspecialchars($blog['content']) ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">YouTube URL</label>
                <input 
                    type="text" 
                    name="video_url" 
                    class="form-control glass-input-field" 
                    value="<?= htmlspecialchars($blog['video_url']) ?>"
                >
            </div>

            <div class="row align-items-end">
                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Current Image</label>
                    <?php if(!empty($blog['image'])): ?>
                        <div style="width: 180px; border-radius: 8px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.08); background: rgba(0,0,0,0.2); padding: 4px;">
                            <img
                                src="../<?= htmlspecialchars($blog['image']) ?>"
                                style="width: 100%; height: auto; display: block; border-radius: 6px;"
                            >
                        </div>
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center" style="width: 180px; height: 100px; border-radius: 8px; background: rgba(255,255,255,0.02); border: 1px dashed rgba(255, 255, 255, 0.1); color: #64748b; font-size: 12px;">
                            No image designated
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Replace Image</label>
                    <input type="file" name="image" class="form-control glass-input-field" style="padding: 7px 12px;">
                </div>
            </div>

            <div class="form-group mb-4" style="max-width: 300px;">
                <label class="glass-label">Status</label>
                <select name="status" class="form-control glass-input-field" style="cursor: pointer;">
                    <option value="1" <?= $blog['status'] == 1 ? 'selected' : '' ?> style="background: #1e293b; color: #ffffff;">
                        Published
                    </option>
                    <option value="0" <?= $blog['status'] == 0 ? 'selected' : '' ?> style="background: #1e293b; color: #ffffff;">
                        Draft
                    </option>
                </select>
            </div>

            <div class="pt-2">
                <button class="btn px-4 py-2" style="
                    background: linear-gradient(135deg, #38bdf8, #0284c7); 
                    border: none; 
                    color: #ffffff; 
                    font-size: 14px; 
                    font-weight: 600; 
                    border-radius: 6px; 
                    box-shadow: 0 4px 12px rgba(56, 189, 248, 0.15); 
                    transition: transform 0.2s, box-shadow 0.2s;
                "
                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.3)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.15)';">
                    Update Blog
                </button>
            </div>

        </form>

    </div>
</div>

</div>
</body>
</html>