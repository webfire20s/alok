<?php include 'includes/header.php'; ?>
<!-- SYSTEM DEPENDENCIES & PREMIUM FONTS -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* MASTER DESIGN VARS & SCOPING */
    :root {
        --infra-brand: #c8232c;
        --infra-brand-hover: #b01e25;
        --infra-dark: #111111;
        --infra-muted: #555555;
        --infra-bg-light: #fcfbfa;
        --infra-border: #eef0f2;
    }

    .infra-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: #ffffff;
        color: var(--infra-dark);
        overflow-x: hidden;
    }

    /* PREMIUM JUMBOTRON HERO */
    .infra-hero {
        background: linear-gradient(135deg, #161616 0%, #080808 100%);
        padding: 7rem 0 6rem 0;
        position: relative;
        border-bottom: 3px solid var(--infra-brand);
    }
    .infra-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(200, 35, 44, 0.08) 0%, transparent 50%);
        pointer-events: none;
    }
    .infra-hero h6 {
        color: var(--infra-brand) !important;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
    }
    .infra-hero h1 {
        font-size: 46px;
        font-weight: 800;
        color: var(--light-bg) !important;
        letter-spacing: -0.02em;
        text-transform: uppercase;
    }
    .infra-hero p {
        color: #b0b5bc;
        font-size: 16px;
        line-height: 1.8;
        max-width: 720px;
        font-weight: 400;
    }

    /* INDUSTRIAL STATS STRIP */
    .infra-stats-counter {
        background-color: var(--infra-dark);
        padding: 2.5rem 0;
        border-bottom: 1px solid #222222;
    }
    .stat-metric-box {
        text-align: center;
        border-right: 1px solid #222222;
    }
    .stat-metric-box:last-child {
        border-right: none;
    }
    .stat-number {
        font-size: 36px;
        font-weight: 800;
        color: var(--infra-brand);
        line-height: 1;
        margin-bottom: 6px;
    }
    .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: #999999;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    /* BALANCED ASYMMETRIC GRID FEATURE */
    .infra-split-section {
        background-color: var(--light-bg) !important;
    }
    .infra-title-main {
        font-size: 32px;
        font-weight: 800;
        color: var(--infra-dark);
        letter-spacing: -0.01em;
        text-transform: uppercase;
        position: relative;
        padding-bottom: 16px;
    }
    .infra-title-underline {
        position: absolute;
        bottom: 0; left: 0; width: 60px; height: 4px;
        background: var(--infra-brand);
        border-radius: 2px;
    }
    .infra-desc-text {
        font-size: 15px;
        line-height: 1.8;
        color: var(--infra-muted);
        font-weight: 500;
    }
    .infra-spec-list {
        list-style: none;
        padding-left: 0;
    }
    .infra-spec-list li {
        font-size: 14px;
        font-weight: 600;
        color: var(--infra-dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }
    .infra-spec-list li i {
        color: var(--infra-brand);
        margin-right: 12px;
        font-size: 16px;
    }

    /* INTERACTIVE MEDIA GALLERY GRID */
    .infra-media-card {
        background: #ffffff;
        border: 1px solid var(--infra-border);
        border-radius: 6px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .infra-media-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(17, 17, 17, 0.06);
        border-color: #e2e4e8;
    }
    .infra-media-viewport {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 10;
        background-color: #000000;
        overflow: hidden;
    }
    .infra-media-viewport img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .infra-media-card:hover .infra-media-viewport img {
        transform: scale(1.05);
    }
    
    /* SHUTTER PLAY OVERLAY ICON */
    .infra-play-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(17, 17, 17, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s ease;
    }
    .infra-media-card:hover .infra-play-overlay {
        background: rgba(17, 17, 17, 0.4);
    }
    .infra-icon-circle {
        width: 50px; height: 50px;
        background-color: var(--infra-brand);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 8px 20px rgba(200, 35, 44, 0.3);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .infra-media-card:hover .infra-icon-circle {
        transform: scale(1.1);
    }

    .infra-card-body {
        padding: 24px;
    }
    .infra-card-body h5 {
        font-size: 18px;
        font-weight: 700;
        color: var(--infra-dark);
        margin-bottom: 8px;
    }
    .infra-card-body p {
        font-size: 13px;
        line-height: 1.6;
        color: var(--infra-muted);
        margin-bottom: 0;
    }

    /* RESPONSIVE DESIGN ADJUSTMENTS */
    @media (max-width: 991.98px) {
        .infra-hero { padding: 5rem 0; text-align: center; }
        .infra-hero p { margin: 0 auto; }
        .stat-metric-box { border-right: none; border-bottom: 1px solid #222222; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
        .stat-metric-box:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
        .infra-media-viewport { aspect-ratio: 16 / 9; }
    }
</style>

<div class="infra-wrapper">

    <!-- HERO DISPLAY HEADER -->
    <section class="infra-hero">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <h6 data-aos="fade-down" data-aos-duration="600">Alok Glass Works</h6>
                    <h1 class="mt-2" data-aos="zoom-in-right" data-aos-duration="700" data-aos-delay="100">Our Infrastructure</h1>
                    <p class="mt-3 mb-0" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        Step inside our state-of-the-art manufacturing infrastructure. Combining advanced European furnace technologies, high-speed automated processing tracks, and rigorous testing cleanrooms to engineer unmatched structural integrity in glass manufacturing.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- METRIC METERS BLOCK STRIP -->
    <section class="infra-stats-counter">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-duration="600" data-aos-delay="50">
                    <div class="stat-metric-box">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Tons / Day Capacity</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-duration="600" data-aos-delay="150">
                    <div class="stat-metric-box">
                        <div class="stat-number">45,000+</div>
                        <div class="stat-label">Sq. Meters Facility</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-duration="600" data-aos-delay="250">
                    <div class="stat-metric-box">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Automated Inspection</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-duration="600" data-aos-delay="350">
                    <div class="stat-metric-box">
                        <div class="stat-number">24 / 7</div>
                        <div class="stat-label">Continuous Production</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SPLIT-GRID CONTENT & MACHINERY INTRO -->
    <section class="py-5 my-lg-4 infra-split-section">
        <div class="container py-3">
            <div class="row align-items-stretch g-5">
                
                <!-- Left Text Column Grid -->
                <div class="col-12 col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-right" data-aos-duration="800">
                    <h2 class="infra-title-main">
                        Advanced Manufacturing Plant
                        <span class="infra-title-underline"></span>
                    </h2>
                    <p class="infra-desc-text mt-4">
                        Our facility utilizes industry-leading melting technologies alongside high-speed IS glass forming lines. This robust setup runs flawlessly under localized system controls to ensure perfect consistency across large custom manufacturing campaigns.
                    </p>
                    <ul class="infra-spec-list mt-3">
                        <li><i class="fa-solid fa-circle-check"></i> Microprocessor Controlled Gas-Fired Regenerative Furnaces</li>
                        <li><i class="fa-solid fa-circle-check"></i> Advanced Multi-Section IS Forming Machinery Tracks</li>
                        <li><i class="fa-solid fa-circle-check"></i> Precision Electronic Annealing Lehrs for Stress Relief</li>
                        <li><i class="fa-solid fa-circle-check"></i> Direct Closed-Loop Laser Dimensions Monitoring Matrix</li>
                    </ul>
                </div>

                <!-- Right Visual Context Box Column -->
                <div class="col-12 col-lg-6" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">
                    <div class="ratio ratio-9x16 h-100 rounded shadow-sm overflow-hidden" style="min-height: 340px; background-color:#111;">
                        <!-- Embed Showcase Video Frame -->
                        <iframe 
                            src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0" 
                            title="Alok Glass Works Plant Tour" 
                            style="border:0;" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- VISUAL MIXED PHOTOS/VIDEOS INFRASTRUCTURE GRID ARRAY -->
    <section class="py-5 bg-white">
        <div class="container">
            
            <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="600">
                <h2 class="infra-title-main d-inline-block px-3">
                    Facility Showcase
                    <span class="infra-title-underline" style="left:50%; transform:translateX(-50%); width:50px;"></span>
                </h2>
                <p class="text-muted mx-auto mt-3 mb-0" style="max-width: 560px; font-size:14px; font-weight: 500;">
                    A look inside our high-performance technical segments, staging facilities, cleanrooms, and testing departments.
                </p>
            </div>

            <div class="row g-4">
                
                <!-- Card Item 1 (Photo Layout Node) -->
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-duration="700" data-aos-delay="50">
                    <div class="infra-media-card">
                        <div class="infra-media-viewport">
                            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=600&q=80" alt="Melting Furnace Segment">
                            <div class="infra-play-overlay">
                                <span class="infra-icon-circle"><i class="fa-solid fa-camera"></i></span>
                            </div>
                        </div>
                        <div class="infra-card-body">
                            <h5>High-Heat Furnaces</h5>
                            <p>Regenerative thermal processors reaching up to 1550°C to guarantee exceptional crystal structural consistency.</p>
                        </div>
                    </div>
                </div>

                <!-- Card Item 2 (Dynamic Video Pop-out Event Node) -->
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-duration="700" data-aos-delay="150">
                    <div class="infra-media-card watch-video" data-id="dQw4w9WgXcQ" data-title="Automated Quality Testing Inspection Track">
                        <div class="infra-media-viewport">
                            <img src="https://images.unsplash.com/photo-1563784462041-5f97ac9523dd?auto=format&fit=crop&w=600&q=80" alt="Testing inspection track">
                            <div class="infra-play-overlay">
                                <span class="infra-icon-circle"><i class="fa-solid fa-play"></i></span>
                            </div>
                        </div>
                        <div class="infra-card-body">
                            <h5>Automated Testing Line</h5>
                            <p>High-resolution optoelectronic cameras check and drop defective units under automated physical parameter constraints.</p>
                        </div>
                    </div>
                </div>

                <!-- Card Item 3 (Photo Layout Node) -->
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-duration="700" data-aos-delay="250">
                    <div class="infra-media-card">
                        <div class="infra-media-viewport">
                            <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80" alt="Custom Forming Processing Track">
                            <div class="infra-play-overlay">
                                <span class="infra-icon-circle"><i class="fa-solid fa-camera"></i></span>
                            </div>
                        </div>
                        <div class="infra-card-body">
                            <h5>IS Bottle Forming Sections</h5>
                            <p>Advanced molding tracks engineered for high efficiency, capable of hot-swapping container templates rapidly.</p>
                         </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>

<!-- RE-USING SYSTEM POPUP LIGHTBOX (Matches Video Gallery Modal Hooks) -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: var(--infra-dark); border: 1px solid #222; border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="border-bottom: 1px solid #222; background-color: #161616; padding: 16px 24px; align-items:center;">
                <h5 class="modal-title" id="videoTitle" style="color:#fff; font-size:16px; font-weight:700;"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; background:transparent; border:0; font-size:28px; opacity:0.6; line-height:1; padding:0; margin:0;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9" style="background-color: #000;">
                    <iframe id="youtubePlayer" src="" style="border:0; width:100%; height:100%;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    // Safe-execution initialization closure
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

