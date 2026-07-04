<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$message = "";
$error = "";

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

/*
|--------------------------------------------------------------------------
| SAVE
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = trim($_POST['title']);
    $youtube_url = trim($_POST['youtube_url']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $sort_order = (int)$_POST['sort_order'];

    $status = $_POST['status'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    $youtube_id = getYoutubeId($youtube_url);

    if (empty($youtube_id)) {

        $error = "Invalid YouTube URL.";

    } else {

        if ($featured) {

            $pdo->exec("
                UPDATE video_gallery
                SET featured = 0
            ");

        }

        $stmt = $pdo->prepare("
            INSERT INTO video_gallery
            (
                title,
                youtube_url,
                youtube_id,
                description,
                category,
                sort_order,
                status,
                featured
            )
            VALUES
            (
                ?,?,?,?,?,?,?,?
            )
        ");

        $stmt->execute([

            $title,
            $youtube_url,
            $youtube_id,
            $description,
            $category,
            $sort_order,
            $status,
            $featured

        ]);

        $message = "Video added successfully.";

    }

}

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
    .glass-alert-success {
        background: rgba(34, 197, 94, 0.06) !important;
        border: 1px solid rgba(34, 197, 94, 0.15) !important;
        color: #4ade80 !important;
        font-size: 13.5px;
        border-radius: 8px;
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
                Add Video
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Register multimedia streams, define structural tracking info, and adjust presentation priorities.
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

                <?php if($message): ?>
                    <div class="alert glass-alert-success mb-4">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <?php if($error): ?>
                    <div class="alert glass-alert-danger mb-4">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="row">
                        <div class="col-md-6 form-group mb-4">
                            <label class="glass-label">Video Title</label>
                            <input type="text" name="title" class="form-control glass-input-field" required>
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="glass-label">YouTube URL</label>
                            <input 
                                type="text" 
                                name="youtube_url" 
                                class="form-control glass-input-field" 
                                placeholder="https://www.youtube.com/watch?v=..." 
                                required
                            >
                            <small style="color: #475569; font-size: 11px; margin-top: 4px; display: block;">
                                Paste any YouTube URL link asset string.
                            </small>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="glass-label">Description</label>
                        <textarea name="description" class="form-control glass-input-field" rows="4"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group mb-4">
                            <label class="glass-label">Category</label>
                            <input type="text" name="category" class="form-control glass-input-field" placeholder="Factory Tour">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="glass-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control glass-input-field" value="0">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="glass-label">Status</label>
                            <select name="status" class="form-control glass-input-field" style="cursor: pointer;">
                                <option value="active" style="background: #1e293b; color: #ffffff;">Active</option>
                                <option value="inactive" style="background: #1e293b; color: #ffffff;">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-check d-flex align-items-start gap-2 mb-4 pb-2">
                        <input type="checkbox" name="featured" id="featured" class="form-check-input glass-check-input">
                        <label for="featured" class="form-check-label glass-check-label">
                            Set as Featured Video
                        </label>
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
                            Save Video
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