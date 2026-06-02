<?php

require 'includes/db.php';
include 'includes/header.php';

$stmt = $pdo->query("
    SELECT *
    FROM blogs
    WHERE status = 1
    ORDER BY id DESC
");

$blogs = $stmt->fetchAll();
?>

<div class="container py-5">

    <h1 class="mb-5">
        Blogs & Videos
    </h1>

    <div class="row">

        <?php foreach($blogs as $blog): ?>

            <div class="col-md-4 mb-4">

                <div class="card h-100">

                    <img
                        src="<?= htmlspecialchars($blog['image']) ?>"
                        class="card-img-top"
                    >

                    <div class="card-body">

                        <h5>

                            <?= htmlspecialchars($blog['title']) ?>

                        </h5>

                        <p>

                            <?= htmlspecialchars(
                                $blog['short_description']
                            ) ?>

                        </p>

                        <a
                            href="blog.php?slug=<?= urlencode($blog['slug']) ?>"
                            class="btn btn-dark"
                        >
                            Read More
                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>