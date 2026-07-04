<?php

require 'includes/auth.php';
require '../includes/db.php';



$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM video_gallery
    WHERE id = ?
");

$stmt->execute([$id]);

$video = $stmt->fetch();

if(!$video){

    die("Video not found.");

}

/*
|--------------------------------------------------------------------------
| EXTRACT YOUTUBE ID
|--------------------------------------------------------------------------
*/

function getYoutubeId($url)
{
    $url = trim($url);

    if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $match)) {
        return $match[1];
    }

    if (preg_match('/v=([a-zA-Z0-9_-]+)/', $url, $match)) {
        return $match[1];
    }

    if (preg_match('/embed\/([a-zA-Z0-9_-]+)/', $url, $match)) {
        return $match[1];
    }

    if (preg_match('/shorts\/([a-zA-Z0-9_-]+)/', $url, $match)) {
        return $match[1];
    }

    return "";
}

$message = "";
$error = "";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $title = trim($_POST['title']);

    $youtube_url = trim($_POST['youtube_url']);

    $description = trim($_POST['description']);

    $category = trim($_POST['category']);

    $sort_order = (int)$_POST['sort_order'];

    $status = $_POST['status'];

    $featured = isset($_POST['featured']) ? 1 : 0;

    $youtube_id = getYoutubeId($youtube_url);

    if(empty($youtube_id)){

        $error = "Invalid YouTube URL.";

    }else{

        if($featured){

            $pdo->exec("
                UPDATE video_gallery
                SET featured = 0
            ");

        }

        $update = $pdo->prepare("
            UPDATE video_gallery
            SET

            title=?,
            youtube_url=?,
            youtube_id=?,
            description=?,
            category=?,
            sort_order=?,
            status=?,
            featured=?

            WHERE id=?

        ");

        $update->execute([

            $title,
            $youtube_url,
            $youtube_id,
            $description,
            $category,
            $sort_order,
            $status,
            $featured,
            $id

        ]);

        header("Location: video_gallery.php");

        exit;

    }

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
    .glass-label {
        color: #94a3b8; 
        font-size: 12px; 
        font-weight: 600; 
        text-transform: uppercase; 
        letter-spacing: 0.04em; 
        margin-bottom: 8px; 
        display: block;
    }
    .glass-check-label {
        color: #e2e8f0;
        font-size: 13.5px;
        font-weight: 500;
        cursor: pointer;
        user-select: none;
    }
    .glass-check-input {
        background-color: rgba(15, 17, 21, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 4px !important;
        cursor: pointer;
        width: 16px;
        height: 16px;
        margin-top: 3px;
    }
    .glass-check-input:checked {
        background-color: #0284c7 !important;
        border-color: #38bdf8 !important;
    }
    .glass-alert-danger {
        background: rgba(239, 68, 68, 0.06) !important;
        border: 1px solid rgba(239, 68, 68, 0.15) !important;
        color: #f87171 !important;
        font-size: 13.5px;
        border-radius: 8px;
    }
</style>

<div class="content-wrapper py-4">
    <div class="container-fluid">

        <div class="mb-5">
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                Edit Video
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Update stream endpoints, adjust database sorting parameters, and reassign status properties.
            </p>
        </div>

        <div class="card border-0" style="
            max-width: 900px;
            border-radius: 14px;
            background: rgba(21, 25, 34, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        ">
            <div class="card-body p-4 p-sm-5">

                <?php if($error): ?>
                    <div class="alert glass-alert-danger mb-4">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <div class="row align-items-center mb-5 p-3" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.04); border-radius: 10px;">
                    <div class="col-md-5 mb-3 mb-md-0">
                        <div style="position: relative; border-radius: 6px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); background: #0f1115;">
                            <img src="https://img.youtube.com/vi/<?= htmlspecialchars($video['youtube_id']) ?>/mqdefault.jpg" class="img-fluid d-block w-100" alt="Video cover">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <a href="<?= htmlspecialchars($video['youtube_url']) ?>" target="_blank" class="btn px-4 py-2" style="
                            background: #ef4444;
                            color: #ffffff;
                            font-size: 13px;
                            font-weight: 600;
                            border-radius: 6px;
                            border: none;
                            transition: background 0.2s;
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                        "
                        onmouseover="this.style.background='#dc2626';"
                        onmouseout="this.style.background='#ef4444';">
                            <i class="fab fa-youtube"></i> Watch on YouTube
                        </a>
                    </div>
                </div>

                <form method="POST">

                    <div class="row">
                        <div class="col-md-6 form-group mb-4">
                            <label class="glass-label">Video Title</label>
                            <input type="text" name="title" class="form-control glass-input-field" value="<?= htmlspecialchars($video['title']) ?>" required>
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="glass-label">YouTube URL</label>
                            <input type="text" name="youtube_url" class="form-control glass-input-field" value="<?= htmlspecialchars($video['youtube_url']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="glass-label">Description</label>
                        <textarea name="description" rows="5" class="form-control glass-input-field"><?= htmlspecialchars($video['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group mb-4">
                            <label class="glass-label">Category</label>
                            <input type="text" name="category" class="form-control glass-input-field" value="<?= htmlspecialchars($video['category']) ?>">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="glass-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control glass-input-field" value="<?= $video['sort_order'] ?>">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="glass-label">Status</label>
                            <select name="status" class="form-control glass-input-field" style="cursor: pointer;">
                                <option value="active" <?= $video['status'] == "active" ? "selected" : "" ?> style="background: #1e293b; color: #ffffff;">Active</option>
                                <option value="inactive" <?= $video['status'] == "inactive" ? "selected" : "" ?> style="background: #1e293b; color: #ffffff;">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-check d-flex align-items-start gap-2 mb-4 pb-2">
                        <input type="checkbox" name="featured" id="featured" class="form-check-input glass-check-input" <?= $video['featured'] ? "checked" : "" ?>>
                        <label for="featured" class="form-check-label glass-check-label">Featured Video</label>
                    </div>

                    <div class="d-flex align-items-center gap-3 pt-2">
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
                            Update Video
                        </button>

                        <a href="video_gallery.php" class="btn px-4 py-2" style="
                            background: rgba(255, 255, 255, 0.03);
                            color: #e2e8f0;
                            border: 1px solid rgba(255, 255, 255, 0.08);
                            font-weight: 500;
                            font-size: 14px;
                            border-radius: 6px;
                            transition: all 0.2s;
                        "
                        onmouseover="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.color='#ffffff';"
                        onmouseout="this.style.background='rgba(255, 255, 255, 0.03)'; this.style.color='#e2e8f0';">
                            Back
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

