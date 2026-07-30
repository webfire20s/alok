<?php

require 'includes/auth.php';
require '../includes/db.php';



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
            Add Blog
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Compose fresh narrative posts, anchor interactive visual descriptions, and stage system publishing attributes.
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
                    <label class="glass-label">Blog Title</label>
                    <input type="text" name="title" class="form-control glass-input-field" required>
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Slug</label>
                    <input type="text" name="slug" class="form-control glass-input-field" required>
                    <small style="color: #64748b; font-size: 11px; display: block; margin-top: 4px;">
                        Example: <span style="font-family: monospace; color: #94a3b8;">glass-bottle-buying-guide</span>
                    </small>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">Short Description</label>
                <textarea name="short_description" rows="3" class="form-control glass-input-field"></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">Blog Content</label>
                <textarea name="content" rows="12" class="form-control glass-input-field" style="line-height: 1.6;"></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">YouTube Video URL</label>
                <input type="text" name="video_url" class="form-control glass-input-field" placeholder="https://www.youtube.com/embed/xxxxx">
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Featured Image</label>
                    <input type="file" name="image" class="form-control glass-input-field" style="padding: 7px 12px;">
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Status</label>
                    <select name="status" class="form-control glass-input-field" style="cursor: pointer;">
                        <option value="1" style="background: #1e293b; color: #ffffff;">Published</option>
                        <option value="0" style="background: #1e293b; color: #ffffff;">Draft</option>
                    </select>
                </div>
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
                    Save Blog
                </button>
            </div>

        </form>

    </div>
</div>

</div>
</body>
</html>