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

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes lineExpandLeft {
        from { width: 0; }
        to { width: 60px; }
    }
    .blog-view-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: #fafafa;
    }
    .blog-animate-fade {
        animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }
    .blog-content-area {
        background: #ffffff;
        border-radius: 24px;
        padding: 50px 60px;
        box-shadow: 0 10px 50px rgba(0,0,0,0.02);
        border: 1px solid #eeeeee;
    }
    @media (max-width: 768px) {
        .blog-content-area {
            padding: 30px 24px;
        }
    }
    .blog-hero-image-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(0,0,0,0.06);
        border: 1px solid #eaeaea;
        background-color: #f5f5f5;
        transition: transform 0.4s ease;
    }
    .blog-hero-image {
        width: 100%;
        height: auto;
        display: block;
    }
    .description-highlight {
        background: linear-gradient(90deg, rgba(200, 35, 44, 0.03) 0%, rgba(200, 35, 44, 0.005) 100%) !important;
        border-left: 4px solid #c8232c !important;
        border-radius: 0 12px 12px 0;
        padding: 30px 35px !important;
        font-style: italic;
        font-weight: 500;
        font-size: 17px;
        line-height: 1.8;
        color: #222222 !important;
        box-shadow: inset 10px 0 20px -10px rgba(200, 35, 44, 0.02);
    }
    .blog-main-body-text {
        line-height: 1.9; 
        font-size: 16px; 
        color: #444444;
        letter-spacing: 0.01em;
    }
    .blog-main-body-text p {
        margin-bottom: 24px;
    }
    .video-section-header::after {
        content: '';
        display: block;
        width: 30px;
        height: 3px;
        background-color: #c8232c;
        margin-top: 10px;
        border-radius: 2px;
    }
    .video-wrapper {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        border: 1px solid #e5e5e5;
    }
</style>

<div class="blog-view-wrapper container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="blog-content-area blog-animate-fade" style="animation-delay: 0.05s;">
                
                <header class="mb-4">
                    <h1 class="mb-3 text-uppercase" style="font-size: 38px; font-weight: 800; color: #111111; letter-spacing: -0.01em; line-height: 1.25;">
                        <?= htmlspecialchars($blog['title']) ?>
                    </h1>
                    <div class="mb-4" style="height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px; animation: lineExpandLeft 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;"></div>
                    
                    <div class="d-flex align-items-center" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: #888888;">
                        <span style="display: inline-flex; align-items: center;">
                            <i class="fa-regular fa-calendar-days me-2" style="color: #c8232c; font-size: 13px;"></i> 
                            <?= date('d M Y', strtotime($blog['created_at'])) ?>
                        </span>
                    </div>
                </header>

                <?php if(!empty($blog['image'])): ?>
                    <div class="mb-5 blog-hero-image-container">
                        <img src="<?= htmlspecialchars($blog['image']) ?>" 
                             class="blog-hero-image" 
                             alt="<?= htmlspecialchars($blog['title']) ?>">
                    </div>
                <?php endif; ?>

                <?php if(!empty($blog['short_description'])): ?>
                    <div class="mb-5 description-highlight">
                        <?= nl2br(htmlspecialchars($blog['short_description'])) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-5 blog-main-body-text">
                    <?= nl2br(htmlspecialchars($blog['content'])) ?>
                </div>

                <?php if(!empty($blog['video_url'])): ?>
                    <div class="mt-5 pt-5 border-top" style="border-top-color: #eeeeee !important;">
                        <h4 class="mb-4 text-uppercase video-section-header" style="font-size: 13px; font-weight: 800; color: #111111; letter-spacing: 0.1em;">
                            Featured Video Documentation
                        </h4>
                        <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0;">
                            <iframe src="<?= htmlspecialchars($blog['video_url']) ?>" 
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #000000;" 
                                    frameborder="0" 
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>