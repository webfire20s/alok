<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT *
    FROM categories
    ORDER BY id DESC
");

$categories = $stmt->fetchAll();

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="mb-0">
        Categories
    </h2>

    <a
        href="add_category.php"
        class="btn btn-dark"
    >
        Add Category
    </a>

</div>

<div class="card-box p-4">

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="thead-dark">

                <tr>

                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Featured</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($categories as $category): ?>

                    <tr>

                        <td>
                            <?= $category['id'] ?>
                        </td>

                        <td width="120">

                            <?php if(!empty($category['image'])): ?>

                                <img
                                    src="../<?= htmlspecialchars($category['image']) ?>"
                                    style="
                                        width:80px;
                                        height:80px;
                                        object-fit:cover;
                                        border-radius:8px;
                                    "
                                >

                            <?php endif; ?>

                        </td>

                        <td>
                            <?= htmlspecialchars($category['name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($category['slug']) ?>
                        </td>

                        <td>

                            <?php if($category['featured']): ?>

                                <span class="badge badge-success">
                                    Yes
                                </span>

                            <?php else: ?>

                                <span class="badge badge-secondary">
                                    No
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a
                                href="edit_category.php?id=<?= $category['id'] ?>"
                                class="btn btn-sm btn-primary"
                            >
                                Edit
                            </a>

                            <a
                                href="delete_category.php?id=<?= $category['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete category?')"
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
</body>
</html>