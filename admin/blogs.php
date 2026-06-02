<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT *
    FROM blogs
    ORDER BY id DESC
");

$blogs = $stmt->fetchAll();

?>

<div class="d-flex justify-content-between mb-4">

    <h2>Blogs</h2>

    <a
        href="add_blog.php"
        class="btn btn-dark"
    >
        Add Blog
    </a>

</div>

<div class="card-box p-4">

    <div class="table-responsive">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($blogs as $blog): ?>

                    <tr>

                        <td><?= $blog['id'] ?></td>

                        <td width="120">

                            <?php if(!empty($blog['image'])): ?>

                                <img
                                    src="../<?= htmlspecialchars($blog['image']) ?>"
                                    style="
                                        width:100px;
                                        height:70px;
                                        object-fit:cover;
                                        border-radius:6px;
                                    "
                                >

                            <?php endif; ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($blog['title']) ?>

                        </td>

                        <td>

                            <?= $blog['status']
                                ? 'Published'
                                : 'Draft' ?>

                        </td>

                        <td>

                            <?= date(
                                'd M Y',
                                strtotime($blog['created_at'])
                            ) ?>

                        </td>

                        <td>

                            <a
                                href="edit_blog.php?id=<?= $blog['id'] ?>"
                                class="btn btn-sm btn-primary"
                            >
                                Edit
                            </a>

                            <a
                                href="delete_blog.php?id=<?= $blog['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete blog?')"
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