<?php

require 'includes/auth.php';
require '../includes/db.php';



$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM pages
    WHERE id = ?
");

$stmt->execute([$id]);

$page = $stmt->fetch();

if(!$page){

    die("Page not found");
}

/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $title =
        trim($_POST['title']);

    $slug =
        trim($_POST['slug']);

    $content =
        $_POST['content'];

    $metaTitle =
        trim($_POST['meta_title']);

    $metaDescription =
        trim($_POST['meta_description']);

    $status =
        $_POST['status'];

    $updateStmt = $pdo->prepare("
        UPDATE pages
        SET

            title = ?,
            slug = ?,
            content = ?,
            meta_title = ?,
            meta_description = ?,
            status = ?,
            updated_at = NOW()

        WHERE id = ?
    ");

    $updateStmt->execute([

        $title,
        $slug,
        $content,
        $metaTitle,
        $metaDescription,
        $status,
        $id

    ]);

    header("Location: pages.php");
    exit;
}
include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';
?>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

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

    /* CKEditor Deep Customization Overrides to fit Cinematic Dark Palette */
    .ck-reset_all, .ck-reset_all * {
        color: #f1f5f9 !important;
    }
    .ck.ck-editor__top .ck-sticky-panel .ck-toolbar {
        background: rgba(15, 17, 21, 0.7) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-bottom: none !important;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important;
    }
    .ck.ck-editor__main>.ck-editor__editable {
        background: rgba(15, 17, 21, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        color: #ffffff !important;
        min-height: 250px;
    }
    .ck.ck-editor__main>.ck-editor__editable.ck-focused {
        border-color: rgba(56, 189, 248, 0.5) !important;
        box-shadow: inset 0 0 0 1px rgba(56, 189, 248, 0.5) !important;
    }
    .ck.ck-button {
        cursor: pointer !important;
    }
    .ck.ck-button:not(.ck-disabled):hover, a.ck.ck-button:not(.ck-disabled):hover {
        background: rgba(255, 255, 255, 0.08) !important;
    }
    .ck.ck-button.ck-on {
        background: rgba(56, 189, 248, 0.2) !important;
        color: #38bdf8 !important;
    }
    .ck.ck-list {
        background: #1e293b !important;
    }
    .ck.ck-list__item .ck-button:hover:not(.ck-disabled) {
        background: rgba(56, 189, 248, 0.15) !important;
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-5">
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
            Edit Page
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Modify core template parameters, adjust search metadata, and reorganize block configurations.
        </p>
    </div>

    <div class="card border-0 p-4 mb-4" style="
        max-width: 950px;
        border-radius: 14px;
        background: rgba(21, 25, 34, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    ">

        <form method="POST">

            <div class="row">
                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Page Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-control glass-input-field" 
                        value="<?= htmlspecialchars($page['title']) ?>" 
                        required
                    >
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Slug</label>
                    <input 
                        type="text" 
                        name="slug" 
                        class="form-control glass-input-field" 
                        value="<?= htmlspecialchars($page['slug']) ?>" 
                        required
                    >
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Meta Title</label>
                    <input 
                        type="text" 
                        name="meta_title" 
                        class="form-control glass-input-field" 
                        value="<?= htmlspecialchars($page['meta_title']) ?>"
                    >
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="glass-label">Status</label>
                    <select name="status" class="form-control glass-input-field" style="cursor: pointer;">
                        <option value="published" <?= $page['status'] == 'published' ? 'selected' : '' ?> style="background: #1e293b; color: #ffffff;">
                            Published
                        </option>
                        <option value="draft" <?= $page['status'] == 'draft' ? 'selected' : '' ?> style="background: #1e293b; color: #ffffff;">
                            Draft
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control glass-input-field"><?= htmlspecialchars($page['meta_description']) ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="glass-label">Page Content</label>
                <textarea name="content" id="editor" rows="10" class="form-control glass-input-field"><?= htmlspecialchars($page['content']) ?></textarea>
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
                    Update Page
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>

</div>
</body>
</html>