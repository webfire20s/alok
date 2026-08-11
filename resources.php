<?php

require 'includes/db.php';
include 'includes/header.php';

/*
|--------------------------------------------------------------------------
| Latest Blogs
|--------------------------------------------------------------------------
*/

$blogStmt = $pdo->query("
    SELECT *
    FROM blogs
    WHERE status = 1
    ORDER BY id DESC
    LIMIT 5
");

$blogs = $blogStmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Latest Videos
|--------------------------------------------------------------------------
*/

$videoStmt = $pdo->query("
    SELECT *
    FROM video_gallery
    WHERE status='active'
    ORDER BY
        featured DESC,
        sort_order ASC,
        id DESC
    LIMIT 5
");

$videos = $videoStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- AOS Animations Engine CDN Framework -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

<style>
    /* MASTER RESOURCES INTERFACE ARCHITECTURE */
    .resources-section {
        padding: 90px 0;
        background: #fcfbfa;
        font-family: 'Montserrat', sans-serif;
    }

    /* FORCE PERFECT SIDE-BY-SIDE GRID EVEN IF BOOTSTRAP IS BROKEN */
    .resources-flex-row {
        display: flex;
        flex-wrap: wrap;
        gap: 30px; /* Clean gap spacing between column elements */
        width: 100%;
    }

    .resources-flex-col {
        flex: 1;
        min-width: 300px; /* Prevents awkward column squeezing */
        display: flex;
        flex-direction: column;
    }

    /* Premium B2B Column Grid Containment Matrix */
    .resource-column {
        background: #ffffff;
        border: 1px solid #eef0f2;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01) !important;
        height: 100%;
        display: flex;
        flex-direction: column;
        width: 100%;
        box-sizing: border-box;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                    box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .resource-column:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(17, 17, 17, 0.05) !important;
    }

    /* Asymmetric Section Header System */
    .resource-heading {
        font-size: 26px;
        font-weight: 800;
        color: #111111;
        margin-bottom: 35px;
        position: relative;
        text-transform: uppercase;
        letter-spacing: -0.01em;
    }
    .resource-heading:after {
        content: '';
        width: 50px;
        height: 4px;
        background: #c8232c;
        display: block;
        margin-top: 14px;
        border-radius: 2px;
    }

    /* Media List Aggregation Core Items */
    .blog-item,
    .video-item {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #eef0f2;
        transition: border-color 0.3s ease;
    }
    .blog-item:last-child,
    .video-item:last-child {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }
    .blog-item:hover,
    .video-item:hover {
        border-color: #d1d5db;
    }

    /* High-Performance Canvas Thumbnail Masks */
    .blog-thumb {
        width: 130px;
        height: 90px;
        border-radius: 4px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #eaeaea;
        display: block;
    }
    .blog-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .blog-item:hover .blog-thumb img {
        transform: scale(1.06);
    }

    .video-thumb-small {
        width: 130px;
        height: 90px;
        border-radius: 4px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        flex-shrink: 0;
        background-color: #000000;
    }
    .video-thumb-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), 
                    filter 0.3s ease;
    }
    .video-item:hover .video-thumb-small img {
        transform: scale(1.06);
        filter: brightness(0.85);
    }

    /* Custom Glass Play HUD overlay */
    .video-thumb-small:before {
        content: '▶';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(200, 35, 44, 0.95);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        padding-left: 2px;
        box-shadow: 0 4px 12px rgba(200, 35, 44, 0.3);
        z-index: 2;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .video-item:hover .video-thumb-small:before {
        transform: translate(-50%, -50%) scale(1.05);
        background: #c8232c;
        box-shadow: 0 6px 16px rgba(200, 35, 44, 0.5);
    }

    /* Content Typography Trimming Framework */
    .resource-content-box {
        flex-grow: 1;
    }

    .resource-title {
        font-size: 16px;
        font-weight: 700;
        color: #111111;
        margin-bottom: 6px;
        line-height: 1.4;
        transition: color 0.2s ease;
    }
    .resource-title a {
        color: #111111;
        text-decoration: none;
    }
    .blog-item:hover .resource-title a,
    .video-item:hover .resource-title {
        color: #c8232c;
    }

    .resource-desc {
        color: #555555;
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 0;
        font-weight: 500;
    }

    /* Minimalist Corporate Action Links */
    .view-all-btn {
        display: inline-block;
        margin-top: auto; /* Forces button anchoring to base of column */
        align-self: flex-start;
        background: #c8232c;
        color: #ffffff !important;
        text-decoration: none;
        padding: 12px 28px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid #c8232c;
    }
    .view-all-btn:hover {
        background: #111111;
        border-color: #111111;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(200, 35, 44, 0.2);
    }

    /* Modern Minimal Tag Badges */
    .badge-video {
        display: inline-block;
        background: #f1f3f5;
        color: #111111;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 8px;
        border: 1px solid #e2e4e8;
    }

    /* Responsive Adaptation Breakpoints */
    @media(max-width: 991.98px) {
        .resources-section {
            padding: 60px 0;
        }
        .resources-flex-col {
            flex: 0 0 100%; /* Drops cleanly down to full width stacked on mobile devices */
        }
        .resource-column {
            padding: 30px 24px;
        }
        .resource-heading {
            font-size: 22px;
            margin-bottom: 25px;
        }
        .view-all-btn {
            margin-top: 30px;
            width: 100%;
            text-align: center;
        }
    }
    
    @media(max-width: 480px) {
        .blog-item, .video-item {
            flex-direction: column;
            gap: 14px;
        }
        .blog-thumb, .video-thumb-small {
            width: 100%;
            height: 160px;
        }
    }
</style>

<section class="resources-section">
    <div class="container">
        
        <!-- Reinforced Bulletproof Flex Row System -->
        <div class="resources-flex-row">

            <!-- LEFT QUADRANT: BLOGS INTERFACE FEED -->
            <div class="resources-flex-col" data-aos="fade-right" data-aos-duration="800">
                <div class="resource-column">
                    <h2 class="resource-heading">Latest Blogs</h2>

                    <div class="resource-feed-list mb-4">
                        <?php foreach($blogs as $blog): ?>
                        <div class="blog-item">
                            <a class="blog-thumb" href="blog.php?slug=<?= urlencode($blog['slug']) ?>">
                                <img src="<?= htmlspecialchars($blog['image']) ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
                            </a>

                            <div class="resource-content-box">
                                <h5 class="resource-title">
                                    <a href="blog.php?slug=<?= urlencode($blog['slug']) ?>">
                                        <?= htmlspecialchars($blog['title']) ?>
                                    </a>
                                </h5>
                                <p class="resource-desc">
                                    <?= htmlspecialchars(substr($blog['short_description'], 0, 100)) ?>...
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <a href="blogs.php" class="view-all-btn">View All Blogs</a>
                </div>
            </div>

            <!-- RIGHT QUADRANT: VIDEO LIGHTBOX INTERFACE FEED -->
            <div class="resources-flex-col" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
                <div class="resource-column">
                    <h2 class="resource-heading">Latest Videos</h2>

                    <div class="resource-feed-list mb-4">

                        <?php foreach($videos as $video): ?>

                        <a
                            href="https://www.youtube.com/watch?v=<?= htmlspecialchars($video['youtube_id']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="video-item"
                            style="
                                display:flex;
                                text-decoration:none;
                                color:inherit;
                                cursor:pointer;
                            "
                        >

                            <div
                                class="video-thumb-small"
                                data-id="<?= htmlspecialchars($video['youtube_id']) ?>"
                                data-title="<?= htmlspecialchars($video['title']) ?>"
                            >
                                <img
                                    src="https://img.youtube.com/vi/<?= htmlspecialchars($video['youtube_id']) ?>/hqdefault.jpg"
                                    alt="<?= htmlspecialchars($video['title']) ?>"
                                >
                            </div>

                            <div class="resource-content-box">

                                <?php if(!empty($video['category'])): ?>
                                <!-- <span class="badge-video">
                                    <?= htmlspecialchars($video['category']) ?>
                                </span> -->
                                <?php endif; ?>

                                <h5 class="resource-title">
                                    <?= htmlspecialchars($video['title']) ?>
                                </h5>

                                <p class="resource-desc">
                                    <?= htmlspecialchars(
                                        substr(
                                            strip_tags($video['description']),
                                            0,
                                            100
                                        )
                                    ) ?>
                                </p>

                            </div>

                        </a>

                        <?php endforeach; ?>

                    </div>

                    <a href="video.php" class="view-all-btn">View All Videos</a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- AOS Engine Animation Lifecycle Interceptor -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    (function () {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                once: true,
                duration: 800,
                offset: 60
            });
        }
    })();
</script>

<?php include 'includes/footer.php'; ?>