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

    <h1 class="mb-5 text-uppercase" style="font-family: 'Montserrat', sans-serif; font-size: 28px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 14px;">
        Blogs & Videos
        <span style="position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background-color: #c8232c;"></span>
    </h1>

    <div class="row">

        <?php foreach($blogs as $blog): ?>

            <div class="col-md-4 mb-4 d-flex align-items-stretch">

                <div class="card w-100" style="border: 1px solid #eeeeee; border-radius: 4px; overflow: hidden; background: #ffffff; display: flex; flex-direction: column; box-shadow: none; transition: border-color 0.3s ease;" onmouseover="this.style.borderColor='#c8232c'" onmouseout="this.style.borderColor='#eeeeee'">

                    <a href="blog.php?slug=<?= urlencode($blog['slug']) ?>" class="d-block overflow-hidden" style="background: #fdfdfd; height: 210px;">
                        <img
                            src="<?= htmlspecialchars($blog['image']) ?>"
                            class="card-img-top"
                            alt="<?= htmlspecialchars($blog['title']) ?>"
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                            onmouseover="this.style.transform='scale(1.04)'"
                            onmouseout="this.style.transform='scale(1.0)'"
                        >
                    </a>

                    <div class="card-body" style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1; font-family: 'Montserrat', sans-serif;">

                        <h5 style="font-size: 16px; font-weight: 700; line-height: 1.4; color: #111111; margin-bottom: 12px; height: 44px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars($blog['title']) ?>
                        </h5>

                        <p style="font-size: 13px; line-height: 1.6; color: #666666; font-weight: 400; margin-bottom: 20px; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars($blog['short_description']) ?>
                        </p>

                        <div>
                            <a
                                href="blog.php?slug=<?= urlencode($blog['slug']) ?>"
                                class="btn text-uppercase"
                                style="background-color: #111111; color: #ffffff; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; padding: 10px 20px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out;"
                                onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                                onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
                            >
                                Read More
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>