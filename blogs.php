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

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes lineExpandLeft {
        from { width: 0; }
        to { width: 50px; }
    }
    .blog-section-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: #fafafa;
    }
    .blog-animate-fade {
        animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }
    .blog-card {
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        position: relative;
    }
    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        border-color: #e0e0e0;
    }
    .img-container {
        height: 230px;
        overflow: hidden;
        position: relative;
        background-color: #111111;
    }
    /* Subtle gradient overlay on image for rich depth */
    .img-container::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 60%, rgba(0,0,0,0.15) 100%);
        transition: opacity 0.4s ease;
    }
    .blog-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .blog-card:hover .blog-img {
        transform: scale(1.06);
    }
    .blog-title-link {
        color: #111111;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .blog-card:hover .blog-title-link {
        color: #c8232c;
    }
    .read-more-btn {
        background: linear-gradient(135deg, #111111 0%, #222222 100%);
        color: #ffffff;
        padding: 13px 28px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: color 0.4s ease, box-shadow 0.4s ease;
        display: inline-block;
        text-decoration: none;
    }
    .read-more-btn::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, #c8232c 0%, #91131a 100%);
        z-index: -1;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        transform: scaleX(0);
        transform-origin: right;
    }
    .read-more-btn:hover::before {
        transform: scaleX(1);
        transform-origin: left;
    }
    .read-more-btn:hover {
        color: #ffffff;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(200, 35, 44, 0.25);
    }
</style>

<div class="blog-section-wrapper container py-5">

    <div class="mb-5 blog-animate-fade" style="animation-delay: 0.05s;">
        <h1 class="text-uppercase" style="font-size: 34px; font-weight: 800; color: #111111; letter-spacing: 0.02em; margin-bottom: 12px; position: relative;">
            Blogs
        </h1>
        <div style="height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px; animation: lineExpandLeft 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;"></div>
    </div>

    <div class="row">
        <?php $delay = 0.1; foreach($blogs as $blog): ?>
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch blog-animate-fade" style="animation-delay: <?= $delay ?>s;">
                <article class="card blog-card w-100">
                    
                    <a href="blog.php?slug=<?= urlencode($blog['slug']) ?>" class="d-block img-container">
                        <img src="<?= htmlspecialchars($blog['image']) ?>" 
                             class="blog-img" 
                             alt="<?= htmlspecialchars($blog['title']) ?>"
                             loading="lazy">
                    </a>

                    <div class="card-body" style="padding: 32px; display: flex; flex-direction: column;">
                        
                        <h5 style="font-size: 19px; font-weight: 800; line-height: 1.45; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; letter-spacing: -0.01em;">
                            <a href="blog.php?slug=<?= urlencode($blog['slug']) ?>" class="blog-title-link">
                                <?= htmlspecialchars($blog['title']) ?>
                            </a>
                        </h5>

                        <p style="font-size: 14px; line-height: 1.75; color: #555555; margin-bottom: 28px; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars($blog['short_description']) ?>
                        </p>

                        <div class="mt-auto">
                            <a href="blog.php?slug=<?= urlencode($blog['slug']) ?>" class="btn read-more-btn">
                                Read Article
                            </a>
                        </div>
                    </div>

                </article>
            </div>
        <?php $delay += 0.05; endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>