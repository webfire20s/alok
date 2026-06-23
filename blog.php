<?php

require 'includes/db.php';

$slug =
    trim($_GET['slug'] ?? '');

$stmt = $pdo->prepare("
    SELECT *
    FROM blogs
    WHERE slug = ?
    AND status = 1
    LIMIT 1
");

$stmt->execute([$slug]);

$blog = $stmt->fetch();

if(!$blog){

    die("Blog not found");

}

include 'includes/header.php';

?>

<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <h1 class="mb-3 text-uppercase" style="font-size: 32px; font-weight: 700; color: #111111; letter-spacing: -0.01em; line-height: 1.3; position: relative; padding-bottom: 16px;">
                <?= htmlspecialchars($blog['title']) ?>
                <span style="position: absolute; bottom: 0; left: 0; width: 60px; height: 3px; background-color: #c8232c;"></span>
            </h1>

            <p class="text-muted mb-4" style="font-size: 13px; font-weight: 500; letter-spacing: 0.05em; color: #888888 !important; margin-top: 15px;">
                <i class="fa-regular fa-calendar-days me-1"></i> <?= date('d M Y', strtotime($blog['created_at'])) ?>
            </p>

            <?php if(!empty($blog['image'])): ?>
                <div class="mb-5 text-center" style="background: #ffffff; border: 1px solid #eeeeee; padding: 12px; border-radius: 4px;">
                    <img
                        src="<?= htmlspecialchars($blog['image']) ?>"
                        class="img-fluid"
                        alt="<?= htmlspecialchars($blog['title']) ?>"
                        style="width: 100%; max-height: 500px; object-fit: cover; vertical-align: middle;"
                    >
                </div>
            <?php endif; ?>

            <?php if(!empty($blog['short_description'])): ?>
                <div
                    class="mb-4"
                    style="
                        background-color: #f8f9fa;
                        border-left: 4px solid #111111;
                        padding: 20px 24px;
                        font-size: 15px;
                        line-height: 1.7;
                        color: #444444;
                        font-weight: 500;
                    "
                >
                    <?= nl2br(htmlspecialchars($blog['short_description'])) ?>
                </div>
            <?php endif; ?>

            <div
                class="mb-5"
                style="
                    line-height: 1.9;
                    font-size: 15px;
                    color: #333333;
                    font-weight: 400;
                    letter-spacing: 0.01em;
                "
            >
                <?= nl2br(htmlspecialchars($blog['content'])) ?>
            </div>

            <?php if(!empty($blog['video_url'])): ?>
                <div class="mt-5 pt-4 border-top" style="border-color: #eeeeee !important;">

                    <h4 class="mb-4 text-uppercase" style="font-size: 16px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 10px;">
                        Video Feature
                        <span style="position: absolute; bottom: 0; left: 0; width: 30px; height: 2px; background-color: #c8232c;"></span>
                    </h4>

                    <div
                        style="
                            position: relative;
                            padding-bottom: 56.25%;
                            height: 0;
                            overflow: hidden;
                            border: 1px solid #eeeeee;
                            border-radius: 4px;
                            background: #000000;
                        "
                    >
                        <iframe
                            src="<?= htmlspecialchars($blog['video_url']) ?>"
                            style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                border: 0;
                            "
                            frameborder="0"
                            allowfullscreen
                        ></iframe>
                    </div>

                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>