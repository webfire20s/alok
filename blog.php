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

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <h1 class="mb-3">

                <?= htmlspecialchars($blog['title']) ?>

            </h1>

            <p class="text-muted mb-4">

                <?= date(
                    'd M Y',
                    strtotime($blog['created_at'])
                ) ?>

            </p>

            <?php if(!empty($blog['image'])): ?>

                <img
                    src="<?= htmlspecialchars($blog['image']) ?>"
                    class="img-fluid rounded shadow mb-4"
                    alt="<?= htmlspecialchars($blog['title']) ?>"
                >

            <?php endif; ?>

            <?php if(!empty($blog['short_description'])): ?>

                <div
                    class="alert alert-light border mb-4"
                >

                    <?= nl2br(
                        htmlspecialchars(
                            $blog['short_description']
                        )
                    ) ?>

                </div>

            <?php endif; ?>

            <div
                style="
                    line-height:1.9;
                    font-size:16px;
                "
            >

                <?= nl2br(
                    htmlspecialchars(
                        $blog['content']
                    )
                ) ?>

            </div>

            <?php if(!empty($blog['video_url'])): ?>

                <div class="mt-5">

                    <h4 class="mb-3">
                        Video
                    </h4>

                    <div
                        style="
                            position:relative;
                            padding-bottom:56.25%;
                            height:0;
                            overflow:hidden;
                        "
                    >

                        <iframe

                            src="<?= htmlspecialchars($blog['video_url']) ?>"

                            style="
                                position:absolute;
                                top:0;
                                left:0;
                                width:100%;
                                height:100%;
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