<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT *
    FROM gallery
    ORDER BY id DESC
");

$gallery = $stmt->fetchAll();
?>

<div class="content-wrapper">
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">

        <h3>Gallery</h3>

        <a
            href="add_gallery.php"
            class="btn btn-primary"
        >
            Add Images
        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($gallery as $item): ?>

                    <tr>

                        <td width="120">

                            <img
                                src="../<?= $item['image'] ?>"
                                width="100"
                            >

                        </td>

                        <td>
                            <?= htmlspecialchars($item['title']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($item['category']) ?>
                        </td>

                        <td>
                            <?= date(
                                'd M Y',
                                strtotime($item['created_at'])
                            ) ?>
                        </td>

                        <td>

                            <a
                                href="edit_gallery.php?id=<?= $item['id'] ?>"
                                class="btn btn-sm btn-warning"
                            >
                                Edit
                            </a>

                            <a
                                href="delete_gallery.php?id=<?= $item['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete image?')"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
</div>

