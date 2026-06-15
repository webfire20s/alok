<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

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

?>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<h2 class="mb-4">
    Edit Page
</h2>

<div class="card-box p-4">

    <form method="POST">

        <div class="form-group">

            <label>Page Title</label>

            <input
                type="text"
                name="title"
                class="form-control"
                value="<?= htmlspecialchars($page['title']) ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Slug</label>

            <input
                type="text"
                name="slug"
                class="form-control"
                value="<?= htmlspecialchars($page['slug']) ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Meta Title</label>

            <input
                type="text"
                name="meta_title"
                class="form-control"
                value="<?= htmlspecialchars($page['meta_title']) ?>"
            >

        </div>

        <div class="form-group">

            <label>Meta Description</label>

            <textarea
                name="meta_description"
                rows="3"
                class="form-control"
            ><?= htmlspecialchars($page['meta_description']) ?></textarea>

        </div>

        <div class="form-group">

            <label>Status</label>

            <select
                name="status"
                class="form-control"
            >

                <option
                    value="published"
                    <?= $page['status']=='published' ? 'selected' : '' ?>
                >
                    Published
                </option>

                <option
                    value="draft"
                    <?= $page['status']=='draft' ? 'selected' : '' ?>
                >
                    Draft
                </option>

            </select>

        </div>

        <div class="form-group">

            <label>Page Content</label>

            <textarea
                name="content"
                id="editor"
                rows="10"
                class="form-control"
            ><?= htmlspecialchars($page['content']) ?></textarea>

        </div>

        <button class="btn btn-dark">

            Update Page

        </button>

    </form>

</div>

<script>

ClassicEditor
.create(
    document.querySelector('#editor')
)
.catch(error => {
    console.error(error);
});

</script>

</div>

</body>
</html>