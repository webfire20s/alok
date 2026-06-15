<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$pages = $pdo->query("
    SELECT *
    FROM pages
    ORDER BY id DESC
")->fetchAll();

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">

        <h2>Pages</h2>

        <a
            href="add_page.php"
            class="btn btn-primary"
        >
            Add Page
        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($pages as $page): ?>

                    <tr>

                        <td><?= $page['id'] ?></td>

                        <td>
                            <?= htmlspecialchars($page['title']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($page['slug']) ?>
                        </td>

                        <td>

                            <span class="badge badge-info">

                                <?= ucfirst($page['status']) ?>

                            </span>

                        </td>

                        <td>

                            <a
                                href="edit_page.php?id=<?= $page['id'] ?>"
                                class="btn btn-sm btn-dark"
                            >
                                Edit
                            </a>

                            <a
                                href="delete_page.php?id=<?= $page['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete page?')"
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

