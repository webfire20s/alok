<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| SAVE PAGE
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

    $stmt = $pdo->prepare("
        INSERT INTO pages (

            title,
            slug,
            content,
            meta_title,
            meta_description,
            status

        ) VALUES (

            ?, ?, ?, ?, ?, ?

        )
    ");

    $stmt->execute([

        $title,
        $slug,
        $content,
        $metaTitle,
        $metaDescription,
        $status

    ]);

    header("Location: pages.php");
    exit;
}

?>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<h2 class="mb-4">
    Add Page
</h2>

<div class="card-box p-4">

    <form method="POST">

        <div class="form-group">

            <label>Page Title</label>

            <input
                type="text"
                name="title"
                class="form-control"
                required
            >

        </div>

        <div class="form-group">

            <label>Slug</label>

            <input
                type="text"
                name="slug"
                class="form-control"
                placeholder="about-us"
                required
            >

        </div>

        <div class="form-group">

            <label>Meta Title</label>

            <input
                type="text"
                name="meta_title"
                class="form-control"
            >

        </div>

        <div class="form-group">

            <label>Meta Description</label>

            <textarea
                name="meta_description"
                rows="3"
                class="form-control"
            ></textarea>

        </div>

        <div class="form-group">

            <label>Status</label>

            <select
                name="status"
                class="form-control"
            >

                <option value="published">
                    Published
                </option>

                <option value="draft">
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
            ></textarea>

        </div>

        <button class="btn btn-dark">

            Save Page

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