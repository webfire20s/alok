<?php
include 'includes/header.php';
?>
<!-- INTEGRATED ABOUT US PAGE SYSTEM STYLES -->
<style>
    /* Hero Banner Architecture */
    .about-hero {
        background: linear-gradient(135deg, #8d8c8c 0%, #5a5a5a 100%);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: 0; right: 0; width: 50%; height: 100%;
        background: radial-gradient(circle, rgba(252, 252, 252, 0.12) 0%, rgba(236, 225, 225, 0) 80%);
        pointer-events: none;
    }
    /* Scoping and Base Typography Configuration */
    .about-hero, .certificates-section {
        font-family: 'Montserrat', sans-serif;
    }

    /* Modern Hero Image Engine with Deep Readable Vignette Overlay */
    .about-hero {
        /* Replace 'path/to/your-hero-image.jpg' with your active image asset file path */
        background-image: linear-gradient(to right, rgba(49, 48, 48, 0.95) 30%, rgba(0, 0, 0, 0.6) 100%), 
                          url('assets/themes/storefront/public/images/aboutherobanner.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    /* Ambient Subtle Identity Glow Grid Overlay */
    .about-hero::before {
        content: '';
        position: absolute;
        top: 0; 
        right: 0; 
        width: 50%; 
        height: 100%;
        background: radial-gradient(circle, rgba(200, 35, 44, 0.2) 0%, rgba(0, 0, 0, 0) 80%);
        pointer-events: none;
    }

    /* Certificates Subsection Base Structural Styling */
    .certificates-section {
        background-color: #ffffff;
    }

    /* High-End Clean Section Title */
    .cert-main-title {
        font-size: 26px;
        font-weight: 800;
        color: #111111;
        letter-spacing: 0.04em;
        position: relative;
        display: inline-block;
        padding-bottom: 16px;
    }
    .cert-main-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: #c8232c;
    }

    /* Industrial Premium Certificate Display Card Frame */
    .certificate-premium-card {
        background: #ffffff;
        border: 1px solid #eef0f2;
        border-radius: 6px;
        padding: 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                    box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                    border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Framed Graphic Wrapper Display Target */
    .certificate-media-wrapper {
        width: 100%;
        aspect-ratio: 4 / 3;
        background-color: #fcfbfa;
        border: 1px solid #c8232c;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .certificate-media-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Keeps certificate proportions crisp and undistorted */
        padding: 10px;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .certificate-title-label {
        font-size: 15px;
        font-weight: 700;
        color: #111111;
        margin-bottom: 6px;
        line-height: 1.4;
        transition: color 0.3s ease;
    }
    .certificate-sub-label {
        font-size: 12px;
        font-weight: 500;
        color: #777777;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Interactive Parent-Child Animation Synchronization Engine */
    .certificate-premium-card:hover {
        transform: translateY(-6px);
        border-color: #e2e4e8;
        box-shadow: 0 16px 36px rgba(17, 17, 17, 0.08);
    }
    .certificate-premium-card:hover .certificate-media-wrapper img {
        transform: scale(1.04);
    }
    .certificate-premium-card:hover .certificate-title-label {
        color: #c8232c;
    }

    /* Core Metrics Dashboard Counters */
    .metric-card {
        border-left: 3px solid #c8232c;
        padding-left: 20px;
        height: 100%;
    }
    .metric-number {
        font-size: 36px;
        font-weight: 800;
        color: #c8232c;
        line-height: 1.1;
        margin-bottom: 5px;
    }
    .metric-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #111111;
        letter-spacing: 0.05em;
    }

    /* Custom Timeline Infrastructure */
    .history-timeline {
        position: relative;
        padding: 20px 0;
    }
    .history-timeline::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 50%;
        width: 2px;
        background: #eeeeee;
        transform: translateX(-50%);
    }
    .timeline-node {
        position: relative;
        margin-bottom: 40px;
    }
    .timeline-node:last-child {
        margin-bottom: 0;
    }
    .timeline-marker {
        position: absolute;
        top: 5px; left: 50%;
        width: 16px; height: 16px;
        background: #ffffff;
        border: 4px solid #c8232c;
        border-radius: 50%;
        transform: translateX(-50%);
        z-index: 2;
    }
    .timeline-content {
        width: 45%;
        padding: 24px;
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.01);
        transition: border-color 0.3s ease;
    }
    .timeline-node:hover .timeline-content {
        border-color: #c8232c;
    }
    .timeline-node:nth-child(odd) .timeline-content {
        float: left;
        text-align: right;
    }
    .timeline-node:nth-child(even) .timeline-content {
        float: right;
        text-align: left;
    }
    .timeline-year {
        font-size: 20px;
        font-weight: 800;
        color: #c8232c;
        margin-bottom: 6px;
    }

    /* Clearfix for Custom Floating Timeline elements */
    .history-timeline::after, .timeline-node::after {
        content: "";
        display: table;
        clear: both;
    }

    /* Corporate Pillars Grid System */
    .pillar-card {
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 8px;
        padding: 35px 25px;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .pillar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.05);
        border-color: #eeeeee;
    }
    .pillar-icon-box {
        width: 50px; height: 50px;
        background: #fafafa;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }
    .pillar-card:hover .pillar-icon-box {
        background: rgba(200,35,44,0.06);
    }

    /* Responsive Design Media Rule Interventions */
    @media (max-width: 767.98px) {
        .history-timeline::before {
            left: 15px;
        }
        .timeline-marker {
            left: 15px;
        }
        .timeline-content {
            width: calc(100% - 40px);
            float: right !important;
            text-align: left !important;
            margin-left: 40px;
        }
    }

    /* SECTION STYLING */
    ./* SECTION STYLING */
    /* SECTION STYLING */
    /* SECTION STYLING */
    .directors-section {
        background-color: #fcfcfc;
    }

    .directors-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #111111;
        letter-spacing: 0.05em;
        position: relative;
    }

    .title-underline {
        width: 60px;
        height: 3px;
        background-color: #c8232c;
        margin: 12px auto 0 auto;
        border-radius: 2px;
    }

    /* CARD CONTAINER */
    .director-card {
        background: #ffffff;
        border: 1px solid #eef0f2;
        border-radius: 12px;
        padding: 20px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .director-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(17, 17, 17, 0.08);
    }

    /* PORTRAIT AVATAR FRAME - FITS ENTIRE PORTRAIT PHOTO WITHOUT STRETCHING OR SIDE GAPS */
    .director-avatar-wrapper {
        position: relative;
        width: 100%;
        margin-bottom: 18px;
    }

    .director-avatar-box {
        width: 100%;
        aspect-ratio: 3 / 4; /* Perfect standard portrait ratio for executive photos */
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eef0f2;
        background-color: #f7f7f7;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        transition: border-color 0.35s ease;
    }

    .director-card:hover .director-avatar-box {
        border-color: #c8232c;
    }

    .director-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Fills container completely without distortion */
        object-position: top center; /* Focuses cleanly on the face */
        display: block;
    }

    /* PILL BADGE OVERLAY */
    .badge-role-pill {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #111111;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-size: 10px;
        font-weight: 600;
        padding: 4px 14px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: background-color 0.35s ease;
    }

    .director-card:hover .badge-role-pill {
        background-color: #c8232c;
    }

    /* NAME & DESIGNATION AREA */
    .director-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding-top: 6px;
    }

    .director-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: #111111;
        margin-bottom: 2px;
    }

    .director-designation {
        font-family: 'Montserrat', sans-serif;
        font-size: 11px;
        font-weight: 600;
        color: #c8232c;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0;
        display: block;
    }
    /* MANUFACTURING ECOSYSTEM SECTION */
    .ecosystem-section {
        background-color: #ffffff;
        font-family: 'Montserrat', sans-serif;
    }

    .ecosystem-pretitle {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #c8232c;
        display: block;
    }

    .ecosystem-main-title {
        font-size: 28px;
        font-weight: 800;
        color: #111111;
        letter-spacing: 0.03em;
    }

    .ecosystem-title-underline {
        width: 50px;
        height: 3px;
        background-color: #c8232c;
        margin: 10px auto 0 auto;
        border-radius: 2px;
    }

    .ecosystem-lead-box {
        max-width: 820px;
    }

    .ecosystem-tagline {
        font-size: 18px;
        font-weight: 700;
        color: #111111;
        margin-bottom: 10px;
    }

    .ecosystem-lead-desc {
        font-size: 15px;
        line-height: 1.7;
        color: #555555;
        font-weight: 400;
    }

    /* CARDS ARCHITECTURE */
    .ecosystem-card {
        background-color: #fcfbfa;
        border: 1px solid #eef0f2;
        border-radius: 10px;
        padding: 30px 24px;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .ecosystem-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.06);
        border-color: rgba(200, 35, 44, 0.3);
    }

    .ecosystem-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .ecosystem-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background-color: rgba(200, 35, 44, 0.08);
        color: #c8232c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .ecosystem-badge {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background-color: #111111;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .ecosystem-card-title {
        font-size: 20px;
        font-weight: 800;
        color: #111111;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .ecosystem-card-subtitle {
        font-size: 14px;
        font-weight: 700;
        color: #c8232c;
        margin-bottom: 14px;
        line-height: 1.4;
    }

    .ecosystem-card-text {
        font-size: 13.5px;
        color: #555555;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* SPEC LIST FOR IS MACHINES */
    .ecosystem-spec-list {
        list-style: none;
        padding: 0;
        margin: 0 0 14px 0;
    }

    .ecosystem-spec-list li {
        font-size: 12.5px;
        font-weight: 600;
        color: #222222;
        padding: 6px 0;
        border-bottom: 1px dashed #e2e4e8;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ecosystem-spec-list li i {
        color: #c8232c;
        font-size: 11px;
    }

    /* TAGS FOR DECORATION */
    .ecosystem-tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .eco-tag {
        font-size: 11px;
        font-weight: 600;
        background-color: #ffffff;
        border: 1px solid #e2e4e8;
        color: #333333;
        padding: 4px 10px;
        border-radius: 20px;
        transition: background-color 0.2s ease;
    }

    .eco-tag:hover {
        border-color: #c8232c;
        color: #c8232c;
    }

    /* HIGHLIGHT STRIP */
    .ecosystem-highlight-strip {
        background-color: #111111;
        border-radius: 10px;
        padding: 24px 20px;
        color: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .highlight-item {
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .highlight-item:last-child {
        border-right: none;
    }

    .highlight-value {
        font-size: 22px;
        font-weight: 800;
        color: #c8232c;
        letter-spacing: 0.03em;
        margin-bottom: 2px;
    }

    .highlight-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #cccccc;
    }

    /* RESPONSIVE FINE-TUNING */
    @media (max-width: 767.98px) {
        .highlight-item {
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
        }
        
        .highlight-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .highlight-value {
            font-size: 18px;
        }
        
        .highlight-label {
            font-size: 10px;
        }
    }
</style>

<!-- HEADER HERO BANNER SEGMENT -->
<!-- HERO & CERTIFICATE COMPONENT ENGINE STYLES -->

<!-- HEADER HERO BANNER SEGMENT -->
<!-- <section class="py-5 about-hero">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="text-uppercase d-block mb-2" style="color: #c8232c; font-size: 13px; font-weight: 700; letter-spacing: 0.1em;">
                    Crafting Visual Identities Since 1998
                </span>
                <h1 class="text-uppercase mb-4" style=" color: #cccccc; font-size: 42px; font-weight: 800; letter-spacing: 0.02em; line-height: 1.2;">
                    Pioneers in Premium Glass Decoration
                </h1>
                <p class="mb-0" style="color: #cccccc; font-size: 16px; line-height: 1.8; max-width: 620px;">
                    At Alok Glass, we combine state-of-the-art automation printing with master craftsmanship to transform standard glass bottles and jars into iconic, shelf-ready brand experiences.
                </p>
            </div>
        </div>
    </div>
</section> -->

<!-- RESPONSIVE ANIMATED OUR JOURNEY SECTION -->
<style>
    /* COMPACT VISIBILITY TIMELINE ENGINE */
    .brand-journey-wrapper {
        background: #111111 !important;
        padding: 50px 0;
        font-family: 'Poppins', sans-serif;
        position: relative;
    }

    /* Horizontal Grid Controller */
    .journey-split-grid {
        display: flex;
        align-items: stretch; /* Forces both columns to match height perfectly */
        gap: 30px;
    }

    /* Left Column matching the exact structure of the right container */
    .journey-left-pillar {
        flex: 0 0 35%;
        z-index: 2;
        background: #161616 !important;
        border: 1px solid #262626;
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 30px;
        height: 320px;
        box-sizing: border-box;
    }

    .journey-main-title {
        font-size: 28px;
        font-weight: 800;
        color: #ffffff !important;
        text-transform: uppercase;
        letter-spacing: -0.01em;
        line-height: 1.2;
        margin: 0;
    }
    .journey-main-title span {
        color: #c8232c !important; /* Brand Crimson */
    }

    /* Navigation Arrow Placements inside the left card */
    .brand-journey-wrapper .journey-nav-wrapper {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }
    .brand-journey-wrapper .journey-nav-wrapper button {
        background: #222222 !important;
        border: 1px solid #333333 !important;
        color: #ffffff !important;
        width: 40px;
        height: 40px;
        border-radius: 4px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px !important;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .brand-journey-wrapper .journey-nav-wrapper button:hover {
        background: #c8232c !important;
        border-color: #c8232c !important;
    }

    /* RIGHT QUADRANT: SLIDING CONTAINER AREA */
    .journey-right-canvas {
        flex: 1;
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #262626;
        height: 320px;
        background: #161616 !important;
    }

    /* Pure CSS Content Node - Handled natively without plugins */
    .journey-slide-item-native {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: #1a1a1a !important;
        display: flex;
        align-items: center;
        box-sizing: border-box;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.6s cubic-bezier(0.25, 1, 0.5, 1), transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        transform: translateX(20px); /* Tighter clean entrance feel */
    }

    /* Visible State Activation Rules */
    .journey-slide-item-native.active-slide {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }

    /* Identical Shape & Style Content Card Frame */
    .journey-sliding-card {
        position: relative;
        z-index: 10;
        background: #161616 !important; /* Exact same color matching left panel */
        border-left: 4px solid #c8232c !important;
        padding: 30px;
        margin: 0 30px;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-sizing: border-box;
    }

    .journey-meta-year {
        font-size: 38px;
        font-weight: 800;
        color: #ffffff !important;
        line-height: 1;
        margin: 0 0 12px 0;
        letter-spacing: -0.01em;
    }

    .journey-slide-desc {
        font-size: 14px;
        color: #e5e7eb !important;
        line-height: 1.6;
        font-weight: 400;
        margin-bottom: 0;
    }

    /* MOBILE RESPONSE LAYOUT MATRIX ADJUSTMENTS */
    @media (max-width: 991.98px) {
        .brand-journey-wrapper { padding: 40px 0; }
        .journey-split-grid { flex-direction: column; gap: 20px; }
        .journey-left-pillar { flex: 0 0 auto; width: 100%; height: auto; min-height: 180px; text-align: center; align-items: center; }
        .journey-right-canvas { height: 280px; }
        .journey-sliding-card { margin: 0; padding: 20px; border-radius: 4px; }
        .journey-meta-year { font-size: 32px; }
        .brand-journey-wrapper .journey-nav-wrapper { justify-content: center; margin-top: 20px; }
    }
</style>

<section class="brand-journey-wrapper">
    <div class="container">
        
        <div class="journey-split-grid">
            
            <!-- LEFT COLUMN: SECTION HEADING HOLDER CARD -->
            <div class="journey-left-pillar">
                <h2 class="journey-main-title">
                    Our Successful<br><span>Journey</span>
                </h2>
                
                <!-- Explicit Target Actions Mapping Native Script Control Hooks -->
                <div class="journey-nav-wrapper">
                    <button id="native-prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
                    <button id="native-next-btn"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>

            <!-- RIGHT COLUMN: HIGH-VISIBILITY NATIVE AUTOMATED TIMELINE SLIDER -->
            <div class="journey-right-canvas" id="native-journey-container">
                
                <!-- Slide Item: 1973 (Set active-slide here by default) -->
                <div class="journey-slide-item-native active-slide" style="background-image: url('images/1972.png');">
                    <div class="journey-sliding-card">
                        <h3 class="journey-meta-year">From a Pot Furnace to Mathur Glass Industries</h3>
                        <p class="journey-slide-desc">
                            <!-- <b>From a Pot Furnace to Mathur Glass Industries </b><br> -->
                           <br> The journey began with Shri Nannumal Agarwal Ji, working with a modest 500 kg pot furnace and an enduring belief in craftsmanship. In 1985, this foundation took form as Mathur Glass Industries, which later grew under Mr. Mohit Mohan Agarwal Ji into a modern 20-tonne glass-bangle manufacturing unit.

                        </p>
                    </div>
                </div>

                <!-- Slide Item: 1974 -->
                <div class="journey-slide-item-native" style="background-image: url('images/1974.png');">
                    <div class="journey-sliding-card">
                        <h3 class="journey-meta-year">Enterprise Built Through Partnership</h3>
                        <p class="journey-slide-desc">
                            <!-- <b>Enterprise Built Through Partnership</b><br> -->
                           <br> Mr. Mohit Mohan Agarwal Ji combined industrial vision with a remarkable instinct for recognising potential in people—building ventures through trust, shared responsibility and room to lead. This philosophy strengthened GM Glass Works in liquor-bottle manufacturing and Crystal Glass Industries in mouth-blown and pressed glassware.

                        </p>
                    </div>
                </div>

                <!-- Slide Item: 2016 -->
                <div class="journey-slide-item-native" style="background-image: url('images/2016image.png');">
                    <div class="journey-sliding-card">
                        <h3 class="journey-meta-year">Reinvention Across Categories</h3>
                        <p class="journey-slide-desc">
                            <!-- <b>Reinvention Across Categories</b><br> -->
                           <br> Firozabad Block Glass Enterprises evolved from bangles and marbles to mouth-blown products and scientific glassware. Pioneer Glass Industries complemented this journey with expertise in press-glass tumblers, bowls and vacuum thermos manufacturing—reflecting a culture of adaptation while preserving specialist craftsmanship.

                        </p>
                    </div>
                </div>

                <!-- Slide Item: 2018 -->
                <div class="journey-slide-item-native" style="background-image: url('images/2018image.png');">
                    <div class="journey-sliding-card">
                        <h3 class="journey-meta-year">A Connected Glass Ecosystem</h3>
                        <p class="journey-slide-desc">
                           <!-- <b> A Connected Glass Ecosystem</b><br> -->
                          <br>  Alok Glass Works was named in honour of a newborn cousin in the family—“Alok,” meaning light—making it a symbol of hope and a new beginning. Emaar Glass Industries added trading and lug-cap capabilities, while Neon Business India brought printing, coating, frosting, hot stamping and decal application under an advanced glass-decoration facility.

                        </p>
                    </div>
                </div>
                <!-- Slide Item: last slide -->
                <div class="journey-slide-item-native" style="background-image: url('images/2018image.png');">
                    <div class="journey-sliding-card">
                        <h3 class="journey-meta-year">Carrying the Legacy Forward</h3>
                        <p class="journey-slide-desc">
                            <!-- <b>Carrying the Legacy Forward </b><br> -->
                          <br>  With Mr. Mohit Mohan Agarwal Ji’s two sons joining the business, the third generation is bringing a contemporary perspective to its established foundations. AI-enabled workflows, digital production systems, e-commerce, modern marketing and global customer development are carrying the journey forward with purpose and continuity.


                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- BRAND STORY & METRICS INFOGRAPHIC SEGMENT -->
<!-- OUR MANUFACTURING ECOSYSTEM SECTION -->
<section class="ecosystem-section py-5">
    <div class="container py-4">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <span class="ecosystem-pretitle">Infrastructure &amp; Capabilities</span>
            <h2 class="ecosystem-main-title text-uppercase mt-1">
                Our Manufacturing Ecosystem
            </h2>
            <div class="ecosystem-title-underline"></div>
            
            <div class="ecosystem-lead-box mt-4 mx-auto">
                <h3 class="ecosystem-tagline">Precision at the Hot End. Possibility at the Finish.</h3>
                <p class="ecosystem-lead-desc mb-0">
                    Alok Glass combines advanced forming technology with comprehensive in-house decoration—creating one connected journey from molten glass to market-ready packaging.
                </p>
            </div>
        </div>

        <!-- 3 Feature Pillars Grid -->
        <div class="row g-4 mb-5">

            <!-- Box 1: Precision Press Technology -->
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="ecosystem-card w-100">
                    <div class="ecosystem-card-header">
                        <div class="ecosystem-icon-box">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <span class="ecosystem-badge">Waltec Engineering</span>
                    </div>
                    <h3 class="ecosystem-card-title">Precision Press Technology</h3>
                    <h4 class="ecosystem-card-subtitle">German Waltec Triple-Gob Press Machine</h4>
                    <p class="ecosystem-card-text">
                        India’s only installation of its kind, engineered for precision, consistency and high-volume press-glass production.
                    </p>
                </div>
            </div>

            <!-- Box 2: IS Forming Technology -->
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="ecosystem-card w-100">
                    <div class="ecosystem-card-header">
                        <div class="ecosystem-icon-box">
                            <i class="fa-solid fa-industry"></i>
                        </div>
                        <span class="ecosystem-badge">Multi-Section Lines</span>
                    </div>
                    <h3 class="ecosystem-card-title">IS Forming Technology</h3>
                    
                    <ul class="ecosystem-spec-list">
                        <li><i class="fa-solid fa-check-double"></i> Triple-Gob &bull; 8-Section IS Machine</li>
                        <li><i class="fa-solid fa-check-double"></i> Double-Gob &bull; 6-Section IS Machine</li>
                        <li><i class="fa-solid fa-check-double"></i> Single-Gob &bull; 10-Section IS Machine</li>
                        <li><i class="fa-solid fa-check-double"></i> Double-Gob &bull; 8-Section IS Machine</li>
                    </ul>

                    <p class="ecosystem-card-text mt-auto pt-2">
                        Versatile machine configurations enable us to manufacture a broad spectrum of bottles, containers and specialist glass designs.
                    </p>
                </div>
            </div>

            <!-- Box 3: Decoration & Value Addition -->
            <div class="col-lg-4 col-md-12 d-flex align-items-stretch py-4">
                <div class="ecosystem-card w-100">
                    <div class="ecosystem-card-header">
                        <div class="ecosystem-icon-box">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <span class="ecosystem-badge">Complete Finishing</span>
                    </div>
                    <h3 class="ecosystem-card-title">Decoration &amp; Value Addition</h3>
                    
                    <div class="ecosystem-tags-container mb-3">
                        <span class="eco-tag">Automated Coating Plants</span>
                        <span class="eco-tag">Frosting</span>
                        <span class="eco-tag">Screen Printing</span>
                        <span class="eco-tag">UV Screen Printing</span>
                        <span class="eco-tag">Decal Application</span>
                        <span class="eco-tag">Multi-Colour Printing</span>
                        <span class="eco-tag">Hot Stamping</span>
                        <span class="eco-tag">Gold Foiling</span>
                    </div>

                    <p class="ecosystem-card-text mt-auto">
                        Complete in-house finishing capabilities allow us to create everything from understated functional finishes to distinctive premium packaging.
                    </p>
                </div>
            </div>

        </div>

        <!-- HIGHLIGHT STRIP -->
        <div class="ecosystem-highlight-strip">
            <div class="row g-3 text-center align-items-center">
                
                <div class="col-6 col-md-3 highlight-item">
                    <div class="highlight-value">GERMAN</div>
                    <div class="highlight-label">Triple-Gob Press Tech</div>
                </div>

                <div class="col-6 col-md-3 highlight-item">
                    <div class="highlight-value">4</div>
                    <div class="highlight-label">IS Machine Lines</div>
                </div>

                <div class="col-6 col-md-3 highlight-item">
                    <div class="highlight-value">8+</div>
                    <div class="highlight-label">In-House Finishing Tech</div>
                </div>

                <div class="col-6 col-md-3 highlight-item">
                    <div class="highlight-value">END-TO-END</div>
                    <div class="highlight-label">Forming To Finishing</div>
                </div>

            </div>
        </div>

    </div>
</section>
<!-- BRAND MILESTONES CHRONOLOGICAL TIMELINE SEGMENT -->
<section class="py-5" style="background-color: #fafafa; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">
        
        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Our Strategic Evolution
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
        </div>

        <div class="history-timeline">
            
            <!-- Milestone Node 1 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">1973</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">WHERE IT BEGAN</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">Alok Glass was established with semi-automatic press machines and mouth-blown production, creating tumblers and everyday glassware through skilled hands and enduring craftsmanship.</p>
                </div>
            </div>

            <!-- Milestone Node 2 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2024</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">A NEW SCALE</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">A 100-tonne cosmetic-flint furnace with a German Waltec triple-gob press machine marked our transition towards greater precision, consistency and production scale</p>
                </div>
            </div>

            <!-- Milestone Node 3 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2026</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">ENGINEERED FOR PERFUMERY</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">A Sanjin triple-gob IS machine, purpose-installed for perfume bottles, expanded our capabilities in refined, design-led packaging for the fragrance and cosmetics sectors.</p>
                </div>
            </div>

            <!-- Milestone Node 4 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">THE NEXT CHAPTER</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">INFRASTRUCTURE FOR TOMORROW</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">Our next investment is a 200,000 sq. ft. dust-controlled, palletized warehouse with modern racking, supported by expanded coating, printing and value-addition lines.</p>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- DIRECTORS MESSAGE SECTION -->
<section class="directors-section py-5">
    <div class="container-fluid container-xl py-4">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 class="directors-title text-uppercase">
                Leadership
            </h2>
            <div class="title-underline"></div>
        </div>

        <!-- Directors Grid - Single Row Layout -->
        <div class="row g-3 g-lg-4 justify-content-center">

            <!-- Director 1 -->
            <div class="col-lg-4 col-md-4 col-12 d-flex align-items-stretch" data-aos="fade-up" data-aos-duration="700">
                <div class="director-card text-center">
                    <div class="director-avatar-wrapper">
                        <div class="director-avatar-box">
                            <img src="assets/images/directors/director1.png" alt="Mohit Mohan Agarwal" class="img-fluid" loading="lazy">
                        </div>
                        <!-- <span class="badge-role-pill">Chairman</span> -->
                    </div>
                    <div class="director-content">
                        <h4 class="director-name">Mohit Mohan Agarwal</h4>
                        <span class="director-designation">Chairman</span>
                    </div>
                </div>
            </div>

            <!-- Director 2 -->
            <div class="col-lg-4 col-md-4 col-12 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="150" data-aos-duration="700">
                <div class="director-card text-center">
                    <div class="director-avatar-wrapper">
                        <div class="director-avatar-box">
                            <img src="assets/images/directors/director2.png" alt="Pranjal Agarwal" class="img-fluid" loading="lazy">
                        </div>
                        <!-- <span class="badge-role-pill">Director</span> -->
                    </div>
                    <div class="director-content">
                        <h4 class="director-name">Pranjal Agarwal</h4>
                        <span class="director-designation">Director</span>
                    </div>
                </div>
            </div>

            <!-- Director 3 -->
            <div class="col-lg-4 col-md-4 col-12 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300" data-aos-duration="700">
                <div class="director-card text-center">
                    <div class="director-avatar-wrapper">
                        <div class="director-avatar-box">
                            <img src="assets/images/directors/director3.png" alt="Ujjwal Agarwal" class="img-fluid" loading="lazy">
                        </div>
                        <!-- <span class="badge-role-pill">Director</span> -->
                    </div>
                    <div class="director-content">
                        <h4 class="director-name">Ujjwal Agarwal</h4>
                        <span class="director-designation">Director</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- RESPONSIVE ANIMATED CERTIFICATIONS SECTION -->
<!-- <section class="py-5 certificates-section reveal-on-scroll">
    <div class="container py-4">
        
    
        <div class="text-center mb-5 pb-2">
            <h2 class="text-uppercase cert-main-title">
                Our Certifications
            </h2>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="certificate-premium-card">
                    <div class="certificate-media-wrapper">
                        <img src="assets/themes/storefront/public/images/reg1.jpg" alt="ISO Certification Quality Management" />
                    </div>
                    <h3 class="certificate-title-label">ISO 9001:2015 Certification</h3>
                    <p class="certificate-sub-label">Quality Management Standard</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="certificate-premium-card">
                    <div class="certificate-media-wrapper">
                        <img src="assets/themes/storefront/public/images/reg2.jpg" alt="Safety Standard Certification" />
                    </div>
                    <h3 class="certificate-title-label">Operational Safety Compliance</h3>
                    <p class="certificate-sub-label">Industrial Standards Certified</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="certificate-premium-card">
                    <div class="certificate-media-wrapper">
                        <img src="assets/themes/storefront/public/images/reg3.jpg" alt="Manufacturing Excellence Award" />
                    </div>
                    <h3 class="certificate-title-label">Premium Manufacturing Excellence</h3>
                    <p class="certificate-sub-label">Verified Glass Decorator</p>
                </div>
            </div>

        </div>

    </div>
</section> -->


<!-- VALUES & OPERATIONAL PILLARS SEGMENT -->
<!-- <section class="py-5" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">

        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Our Operational Pillars
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
        </div>

        <div class="row g-4">
            
            <div class="col-md-4">
                <div class="pillar-card">
                    <div class="pillar-icon-box">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 700; color: #111111; margin-bottom: 12px;">Uncompromising Quality</h4>
                    <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.6;">Every run undergoes strict cross-hatch adhesion validation, thermal stress profiling, and dimensional verification tests to ensure defect-free performance on filling lines.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pillar-card">
                    <div class="pillar-icon-box">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 700; color: #111111; margin-bottom: 12px;">Agile Turnaround</h4>
                    <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.6;">Through automated multi-stage inline systems and advanced pre-press engineering blocks, we dramatically accelerate prototyping-to-delivery workflows.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pillar-card">
                    <div class="pillar-icon-box">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="2.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 700; color: #111111; margin-bottom: 12px;">Eco-Innovation</h4>
                    <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.6;">We maintain active compliance with modern ecological thresholds by utilizing lead- and cadmium-free ink solutions alongside closed-loop clean wash processing layers.</p>
                </div>
            </div>

        </div>

    </div>
</section> -->

<!-- CONVERSION-FOCUSED CLOSING CTA SEGMENT -->
<section class="py-5 text-center cta-premium-bg" style="font-family: 'Montserrat', sans-serif;">
    <div class="container py-4" style="position: relative; z-index: 2;">
        
        <h2 class="mb-3 text-uppercase" style="font-size: 28px; font-weight: 800; letter-spacing: 0.04em;">
            Partner With Alok Glass Today
        </h2>

        <p class="mb-4 mx-auto" style="font-size: 15px; font-weight: 400; max-width: 620px; color: #c8232c; line-height: 1.7;">
            Connect directly with our engineering and business consulting team to explore technical solutions for your custom branding goals.
        </p>
        
        <div class="mt-4 pt-2">
            <a href="bulk_inquiry.php" class="btn cta-btn-action text-uppercase" >
                Request a Custom Quote
            </a>
        </div>

    </div>
</section>
<!-- DEPENDENCIES FOR ICONS ONLY -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<!-- LIGHTWEIGHT NATIVE SLIDER ENGINE -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var slides = document.querySelectorAll('.journey-slide-item-native');
        var nextBtn = document.getElementById('native-next-btn');
        var prevBtn = document.getElementById('native-prev-btn');
        var currentIndex = 0;
        var slideInterval;

        function updateSlides(nextIndex) {
            // Remove active status from currently shown slide element
            slides[currentIndex].classList.remove('active-slide');
            
            // Loop boundaries safely
            currentIndex = (nextIndex + slides.length) % slides.length;
            
            // Activate next matching item card view
            slides[currentIndex].classList.add('active-slide');
        }

        function startAutoPlay() {
            stopAutoPlay(); // Protect loop from creating multiple timers
            slideInterval = setInterval(function() {
                updateSlides(currentIndex + 1);
            }, 5000); // Transitions or interchanges automatically every 5 seconds
        }

        function stopAutoPlay() {
            if (slideInterval) clearInterval(slideInterval);
        }

        // Click Interactions Engine
        nextBtn.addEventListener('click', function() {
            stopAutoPlay();
            updateSlides(currentIndex + 1);
            startAutoPlay();
        });

        prevBtn.addEventListener('click', function() {
            stopAutoPlay();
            updateSlides(currentIndex - 1);
            startAutoPlay();
        });

        // Pause tracking loops if mouse hover matches container profile
        var container = document.getElementById('native-journey-container');
        container.addEventListener('mouseenter', stopAutoPlay);
        container.addEventListener('mouseleave', startAutoPlay);

        // Turn on the system timeline loop automatically
        if(slides.length > 0) {
            startAutoPlay();
        }
    });
</script>

<?php
include 'includes/footer.php';
?>