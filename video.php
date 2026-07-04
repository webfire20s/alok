<?php

include 'includes/header.php';
require 'includes/db.php';

/*
|--------------------------------------------------------------------------
| FEATURED VIDEO
|--------------------------------------------------------------------------
*/

$featuredStmt = $pdo->query("
    SELECT *
    FROM video_gallery
    WHERE status='active'
    ORDER BY featured DESC,
             sort_order ASC,
             id DESC
    LIMIT 1
");

$featuredVideo = $featuredStmt->fetch();

?>

<!-- AOS Animations & Professional Google Typography Core Framework CDN -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

<!-- VIDEO GALLERY MASTER ARCHITECTURE STYLES -->
<style>
    /* Scoping and Base Typography Design Settings */
    .v-gallery-wrapper, .video-hero, .featured-video {
        font-family: 'Montserrat', sans-serif;
    }

    /* Minimalist High-End Cinematic Header Section */
    .video-hero {
        background-color: #fafafa;
        border-bottom: 1px solid #eef0f2;
        padding: 5rem 0;
    }
    .video-hero h6 {
        color: #c8232c; 
        font-size: 13px; 
        font-weight: 700; 
        letter-spacing: 0.15em;
        margin-bottom: 12px;
    }
    .video-hero h1 {
        font-size: 42px; 
        font-weight: 800; 
        color: #111111; 
        letter-spacing: -0.01em; 
        line-height: 1.2;
        text-transform: uppercase;
    }
    .video-hero p {
        color: #555555; 
        font-size: 15px; 
        line-height: 1.8; 
        max-width: 680px; 
        margin: 0 auto;
        font-weight: 500;
    }

    /* Asymmetric Premium Featured Split-Card System */
    .featured-card {
        background: #ffffff;
        border: 1px solid #eef0f2;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(17, 17, 17, 0.04);
        transition: box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .featured-card:hover {
        box-shadow: 0 20px 50px rgba(17, 17, 17, 0.08);
    }

    /* Fluid Asymmetric Layout Matrix Split Styles */
    .featured-video-frame {
        background-color: #000000;
        display: flex;
        align-items: center;
        height: 50vh;
    }
    .featured-video-frame iframe {
        border: none;
        width: 100%;
        height: 100%;
    }

    .video-details-box {
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: #ffffff;
    }

    /* Premium B2B Micro-Elements */
    .badge-featured {
        background-color: #c8232c;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 6px 14px;
        border-radius: 4px;
        display: inline-block;
        align-self: flex-start;
        box-shadow: 0 4px 12px rgba(200, 35, 44, 0.2);
    }
    .video-details-box h2 {
        font-size: 26px;
        font-weight: 800;
        color: #111111;
        line-height: 1.3;
        letter-spacing: -0.01em;
    }
    .video-details-box p {
        font-size: 14px;
        line-height: 1.7;
        color: #666666;
        font-weight: 500;
    }

    /* Responsive Breakdown Adaptations */
    @media (max-width: 991.98px) {
        .video-hero {
            padding: 4rem 0;
        }
        .video-hero h1 {
            font-size: 32px;
        }
        .video-details-box {
            padding: 2rem 1.5rem;
        }
        .video-details-box h2 {
            font-size: 20px;
        }
        .featured-video-frame {
            width: 100%;
        }
    }
</style>

<div class="v-gallery-wrapper">

    <!-- HERO SECTION -->
    <section class="video-hero">
        <div class="container text-center">
            <h6 data-aos="fade-down" data-aos-duration="600">
                ALOK GLASS WORKS
            </h6>
            <h1 data-aos="zoom-in" data-aos-duration="700" data-aos-delay="100">
                Video Gallery
            </h1>
            <p class="mt-3" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                Explore our manufacturing excellence, factory tours, machinery, product showcases, trade exhibitions and behind-the-scenes videos.
            </p>
        </div>
    </section>

    <!-- FEATURED VIDEO DISPLAY CONTAINER -->
    <?php if($featuredVideo): ?>
    <section class="featured-video py-5 bg-white">
        <div class="container py-2">
            
            <!-- Asymmetrical Split Grid Grid Layout -->
            <div class="featured-card" data-aos="fade-up" data-aos-duration="900">
                <div class="row g-0">
                    
                    <!-- Left Video Canvas Column (Bootstrap standard 16:9 Aspect Ratio Mask) -->
                    <div class="col-12 col-lg-7 featured-video-frame">
                        <div class="ratio ratio-16x9 w-100 h-100">
                            <iframe 
                                src="https://www.youtube.com/embed/<?= htmlspecialchars($featuredVideo['youtube_id']) ?>" 
                                title="<?= htmlspecialchars($featuredVideo['title']) ?>"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- Right Typography Metadata Column Layout Frame -->
                    <div class="col-12 col-lg-5 video-details-box">
                        <span class="badge-featured">
                            Featured Video
                        </span>
                        
                        <h2 class="mt-3">
                            <?= htmlspecialchars($featuredVideo['title']) ?>
                        </h2>
                        
                        <hr class="my-3" style="border-top: 1px solid #eef0f2; opacity: 1;">
                        
                        <p class="mb-0">
                            <?= nl2br(htmlspecialchars($featuredVideo['description'])) ?>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <?php endif; ?>

</div>

<?php
$videosStmt = $pdo->query("
    SELECT *
    FROM video_gallery
    WHERE status='active'
    ORDER BY
        featured DESC,
        sort_order ASC,
        id DESC
");

$videos = $videosStmt->fetchAll();

// Ready for Part 2 loop handling setup...
?>
<!-- GRID GALLERY & MODAL MATRIX STYLES -->
<style>
    /* Scoping Wrapper Configurations */
    .latest-videos-section {
        background-color: #fcfbfa !important;
        font-family: 'Montserrat', sans-serif;
    }

    /* Core Section Title Realignment */
    .gallery-grid-title {
        font-size: 32px;
        font-weight: 800;
        color: #111111;
        letter-spacing: -0.01em;
        text-transform: uppercase;
    }

    /* Premium Industrial Video Display Cards */
    .video-card {
        background: #ffffff;
        border: 1px solid #eef0f2;
        border-radius: 6px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01) !important;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                    box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .video-card:hover {
        transform: translateY(-6px);
        border-color: #e2e4e8;
        box-shadow: 0 16px 36px rgba(17, 17, 17, 0.06) !important;
    }

    /* Cinematic Aspect Aspect-Ratio Thumb Lock Container */
    .video-thumb {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        background-color: #000000;
        overflow: hidden;
        cursor: pointer;
    }
    .video-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), 
                    filter 0.4s ease;
    }
    .video-card:hover .video-thumb img {
        transform: scale(1.05);
        filter: brightness(0.85);
    }

    /* Fluid Micro-Play Button Overlay Anchor */
    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        width: 54px;
        height: 54px;
        background: rgba(200, 35, 44, 0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 16px;
        box-shadow: 0 8px 24px rgba(200, 35, 44, 0.3);
        opacity: 0.9;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none; /* Passes click tracking down cleanly to data container */
        padding-left: 3px; /* Optical centering compensation */
    }
    .video-card:hover .play-button {
        transform: translate(-50%, -50%) scale(1.1);
        background: #c8232c;
        opacity: 1;
        box-shadow: 0 12px 28px rgba(200, 35, 44, 0.5);
    }

    /* Metadata & Typography Layout Details Frame */
    .video-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .badge-category {
        background-color: #f1f3f5;
        color: #111111;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 5px 10px;
        border-radius: 4px;
        align-self: flex-start;
        border: 1px solid #e2e4e8;
    }

    .video-card-body h5 {
        font-size: 16px;
        font-weight: 700;
        color: #111111;
        line-height: 1.4;
        margin-top: 10px;
        margin-bottom: 8px;
        transition: color 0.3s ease;
    }
    .video-card:hover .video-card-body h5 {
        color: #c8232c;
    }

    .video-card-body p {
        font-size: 13px;
        line-height: 1.6;
        color: #666666;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* Minimalist Technical Outline Action Control Trigger Button */
    .btn-watch-action {
        border: 1px solid #111111;
        background-color: transparent;
        color: #111111;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 10px 20px;
        border-radius: 4px;
        margin-top: auto; /* Forces execution pinning to bottom card margins */
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-watch-action:hover {
        background-color: #c8232c;
        color: #ffffff;
    }

    /* Corporate Video Modal Architecture Modifiers */
    #videoModal .modal-content {
        background-color: #111111;
        border: 1px solid #222222;
        border-radius: 8px;
        overflow: hidden;
    }
    #videoModal .modal-header {
        border-bottom: 1px solid #222222;
        background-color: #161616;
        padding: 16px 24px;
        align-items: center;
    }
    #videoModal .modal-title {
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        font-family: 'Montserrat', sans-serif;
    }
    #videoModal .close {
        color: #ffffff;
        opacity: 0.6;
        font-size: 28px;
        font-weight: 300;
        text-shadow: none;
        transition: opacity 0.2s ease;
        background: transparent;
        border: 0;
        padding: 0;
        margin: 0;
    }
    #videoModal .close:hover {
        opacity: 1;
    }
</style>

<!-- LATEST VIDEOS SECTION CONTAINER -->
<section class="py-5 latest-videos-section">
    <div class="container py-4">

        <!-- Top Header Typography Section Frame -->
        <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="600">
            <h2 class="gallery-grid-title">Latest Videos</h2>
            <p class="text-muted max-width-580 mx-auto mt-2" style="font-size: 15px; font-weight: 500; max-width: 600px;">
                Watch factory tours, manufacturing processes, quality checks and product showcases.
            </p>
        </div>

        <!-- 3-Column Grid Array Execution Node Loop -->
        <div class="row g-4">
            <?php foreach($videos as $video): ?>
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-duration="700">
                <div class="video-card">
                    
                    <!-- Thumbnail Media Module Canvas Base -->
                    <div class="video-thumb watch-video" data-id="<?= htmlspecialchars($video['youtube_id']) ?>" data-title="<?= htmlspecialchars($video['title']) ?>">
                        <img 
                            src="https://img.youtube.com/vi/<?= htmlspecialchars($video['youtube_id']) ?>/hqdefault.jpg" 
                            class="img-fluid" 
                            alt="<?= htmlspecialchars($video['title']) ?>">
                        
                        <div class="play-button">
                            <i class="fa fa-play"></i>
                        </div>
                    </div>

                    <!-- Meta text container framework box -->
                    <div class="video-card-body">
                        <?php if(!empty($video['category'])): ?>
                        <span class="badge-category mb-2">
                            <?= htmlspecialchars($video['category']) ?>
                        </span>
                        <?php endif; ?>

                        <h5>
                            <?= htmlspecialchars($video['title']) ?>
                        </h5>

                        <p class="text-muted">
                            <?= substr(strip_tags($video['description']), 0, 120) ?>...
                        </p>

                        <button 
                            class="btn btn-watch-action watch-video w-100" 
                            data-id="<?= htmlspecialchars($video['youtube_id']) ?>" 
                            data-title="<?= htmlspecialchars($video['title']) ?>">
                            Watch Video
                        </button>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- PREMIUM VIDEO PLAYBACK MODAL VIEWPORT FRAME -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="videoTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">
                <!-- High-performance 16:9 Aspect Ratio Box Frame Container -->
                <div class="ratio ratio-16x9" style="background-color: #000000;">
                    <iframe 
                        id="youtubePlayer" 
                        src="" 
                        style="border:0; width: 100%; height: 100%;"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Initializing Animation Engine Script Target Execution Hooks -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    // Handles initializing AOS constraints without conflict 
    if (typeof AOS !== 'undefined') {
        AOS.init({
            once: true,
            offset: 100
        });
    }
</script>
<script>

    AOS.init({

        once:true,

        duration:800

    });

    /*
    |--------------------------------------------------------------------------
    | VIDEO POPUP
    |--------------------------------------------------------------------------
    */

    $(document).ready(function(){

        $(".watch-video, .video-thumb").click(function(){

            let id=$(this).data("id");

            let title=$(this).data("title");

            $("#videoTitle").text(title);

            $("#youtubePlayer").attr(

                "src",

                "https://www.youtube.com/embed/"+id+"?autoplay=1&rel=0"

            );

            $("#videoModal").modal("show");

        });

    });

    /*
    |--------------------------------------------------------------------------
    | STOP VIDEO WHEN MODAL CLOSES
    |--------------------------------------------------------------------------
    */

    $('#videoModal').on('hidden.bs.modal',function(){

        $("#youtubePlayer").attr("src","");

    });

</script>

<?php include 'includes/footer.php';?>