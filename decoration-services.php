<?php
include 'includes/header.php';
?>

<!-- HERO -->

<!-- INTEGRATED DECORATION & BRANDING SYSTEM STYLES -->
<style>
    @keyframes srvFadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes srvLineExpand {
        from { width: 0; }
        to { width: 50px; }
    }
    .srv-animate-fade {
        animation: srvFadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }
    
    /* Hero Banner Modern Elements */
    .srv-hero-banner-frame {
        background: #ffffff; 
        border: 1px solid #eeeeee; 
        padding: 12px; 
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        width:50vw;
    }
    .srv-hero-img {
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        vertical-align: right; 
        border-radius: 8px;
    }
    @media (max-width: 992px) {
        .srv-hero-banner-frame {
            width: 100vw;
        }
    }
    
    /* Premium Slide-Fill Action Button */
    .srv-btn-quote {
        background: linear-gradient(135deg, #c8232c 0%, #a81a21 100%);
        color: #ffffff; 
        font-size: 13px; 
        font-weight: 700; 
        letter-spacing: 0.06em; 
        padding: 15px 34px; 
        border: none; 
        border-radius: 6px; 
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: color 0.4s ease, box-shadow 0.4s ease;
        display: inline-block;
        text-decoration: none;
    }
    .srv-btn-quote::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, #111111 0%, #222222 100%);
        z-index: -1;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        transform: scaleX(0);
        transform-origin: right;
    }
    .srv-btn-quote:hover::before {
        transform: scaleX(1);
        transform-origin: left;
    }
    .srv-btn-quote:hover {
        color: #ffffff;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(200, 35, 44, 0.25);
    }

    /* Grid Functional Card Modular Matrix */
    .srv-card {
        border: 1px solid #eeeeee; 
        border-radius: 12px; 
        overflow: hidden; 
        background: #ffffff; 
        display: flex; 
        flex-direction: column; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.01); 
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .srv-card:hover {
        border-color: #e0e0e0;
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.05);
    }
    .srv-card-img-wrap {
        height: 240px; 
        background: #fafafa;
        overflow: hidden;
        position: relative;
    }
    .srv-card-img {
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .srv-card:hover .srv-card-img {
        transform: scale(1.05);
    }
    .srv-card:hover .srv-card-title {
        color: #c8232c;
    }
    .srv-card-title {
        font-size: 16px; 
        font-weight: 800; 
        color: #111111; 
        margin-bottom: 12px; 
        text-transform: uppercase; 
        letter-spacing: 0.03em;
        transition: color 0.3s ease;
    }
</style>

<!-- HERO INTRODUCTORY SEGMENT -->
<section class="py-5" style="background-color: #fafafa; font-family: 'Montserrat', sans-serif;">
    <div class="container py-4">
        <div class="row align-items-center">

            <!-- Core Typography Text Column -->
            <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5 srv-animate-fade" style="animation-delay: 0.05s;">
                <h1 class="text-uppercase mb-4" style="font-size: 38px; font-weight: 800; color: #111111; letter-spacing: -0.01em; line-height: 1.25; position: relative; padding-bottom: 18px;">
                    Decoration & Branding Services
                    <span style="position: absolute; bottom: 0; left: 0; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px; animation: srvLineExpand 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;"></span>
                </h1>

                <p class="mb-4" style="font-size: 15px; line-height: 1.8; color: #555555; font-weight: 500; margin-top: 24px;">
                    Elevate your packaging with premium decoration solutions including screen printing, 
                    UV printing, frosting, coating, labeling, and custom branding for glass bottles and jars.
                </p>

                <div class="mt-4 pt-2">
                    <a href="bulk_inquiry.php" class="btn srv-btn-quote text-uppercase">
                        Request Bulk Quote
                    </a>
                </div>
            </div>

            <!-- Visual Asset Column Wrapper -->
            <div class="col-lg-6 srv-animate-fade" style="animation-delay: 0.15s;">
                <div class="srv-hero-banner-frame">
                    <img src="storage/media/decoration-banner.jpg" class="img-fluid srv-hero-img" alt="Decoration Services">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- COMPREHENSIVE SERVICES GRID DETAILED MATRIX -->
<section class="py-5" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">

        <!-- Grid Subsection Structural Header -->
        <div class="text-center mb-5 srv-animate-fade" style="animation-delay: 0.2s;">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Our Decoration Services
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
            <p class="text-muted" style="font-size: 14px; font-weight: 500; color: #777777 !important; margin-top: 6px;">
                Complete packaging customization solutions.
            </p>
        </div>

        <!-- Dynamic Modular Row Matrix -->
        <div class="row">
            
            <!-- Service Block 1 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch srv-animate-fade" style="animation-delay: 0.25s;">
                <div class="card srv-card w-100">
                    <div class="srv-card-img-wrap">
                        <img src="storage/media/screen-printing.jpg" class="srv-card-img" alt="Screen Printing" loading="lazy">
                    </div>
                    <div class="card-body" style="padding: 28px; display: flex; flex-direction: column;">
                        <h4 class="srv-card-title">Screen Printing</h4>
                        <p style="font-size: 13.5px; line-height: 1.65; color: #666666; font-weight: 400; margin-bottom: 0;">
                            Permanent direct printing on glass bottles and jars with excellent durability.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service Block 2 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch srv-animate-fade" style="animation-delay: 0.3s;">
                <div class="card srv-card w-100">
                    <div class="srv-card-img-wrap">
                        <img src="storage/media/uv-printing.jpg" class="srv-card-img" alt="UV Printing" loading="lazy">
                    </div>
                    <div class="card-body" style="padding: 28px; display: flex; flex-direction: column;">
                        <h4 class="srv-card-title">UV Printing</h4>
                        <p style="font-size: 13.5px; line-height: 1.65; color: #666666; font-weight: 400; margin-bottom: 0;">
                            Vibrant multi-color branding with premium finish and excellent clarity.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service Block 3 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch srv-animate-fade" style="animation-delay: 0.35s;">
                <div class="card srv-card w-100">
                    <div class="srv-card-img-wrap">
                        <img src="storage/media/frosted-bottle.jpg" class="srv-card-img" alt="Frosting & Coating" loading="lazy">
                    </div>
                    <div class="card-body" style="padding: 28px; display: flex; flex-direction: column;">
                        <h4 class="srv-card-title">Frosting & Coating</h4>
                        <p style="font-size: 13.5px; line-height: 1.65; color: #666666; font-weight: 400; margin-bottom: 0;">
                            Elegant matte and luxury finishes for premium packaging products.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service Block 4 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch srv-animate-fade" style="animation-delay: 0.4s;">
                <div class="card srv-card w-100">
                    <div class="srv-card-img-wrap">
                        <img src="storage/media/metallic-coating.jpg" class="srv-card-img" alt="Metallic Coating" loading="lazy">
                    </div>
                    <div class="card-body" style="padding: 28px; display: flex; flex-direction: column;">
                        <h4 class="srv-card-title">Metallic Coating</h4>
                        <p style="font-size: 13.5px; line-height: 1.65; color: #666666; font-weight: 400; margin-bottom: 0;">
                            Gold, silver and premium metallic decorative effects.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service Block 5 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch srv-animate-fade" style="animation-delay: 0.45s;">
                <div class="card srv-card w-100">
                    <div class="srv-card-img-wrap">
                        <img src="storage/media/label-application.jpg" class="srv-card-img" alt="Label Application" loading="lazy">
                    </div>
                    <div class="card-body" style="padding: 28px; display: flex; flex-direction: column;">
                        <h4 class="srv-card-title">Label Application</h4>
                        <p style="font-size: 13.5px; line-height: 1.65; color: #666666; font-weight: 400; margin-bottom: 0;">
                            Accurate and professional labeling solutions for every industry.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service Block 6 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch srv-animate-fade" style="animation-delay: 0.5s;">
                <div class="card srv-card w-100">
                    <div class="srv-card-img-wrap">
                        <img src="storage/media/perfume-decoration.jpg" class="srv-card-img" alt="Custom Branding" loading="lazy">
                    </div>
                    <div class="card-body" style="padding: 28px; display: flex; flex-direction: column;">
                        <h4 class="srv-card-title">Custom Branding</h4>
                        <p style="font-size: 13.5px; line-height: 1.65; color: #666666; font-weight: 400; margin-bottom: 0;">
                            End-to-end packaging customization for your brand identity.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- VIDEO -->
<!-- INTEGRATED DECORATION PROCESS & INDUSTRIES SYSTEM STYLES -->
<style>
    /* Responsive Premium Video Frame Container */
    .proc-video-container {
        position: relative;
        padding-bottom: 56.25%; /* Perfect 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        border: 1px solid #eeeeee;
        border-radius: 12px;
        background: #111111;
        box-shadow: 0 15px 40px rgba(0,0,0,0.04);
        padding: 10px;
    }
    .proc-video-iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
        border-radius: 8px;
    }

    /* Industry Matrix Card Blocks */
    .ind-card {
        border: 1px solid #eeeeee; 
        border-radius: 10px; 
        padding: 28px 14px; 
        background-color: #ffffff; 
        height: 100%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
        position: relative; 
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.01);
    }
    .ind-card:hover {
        border-color: #c8232c; 
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(200, 35, 44, 0.08);
    }
    .ind-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #c8232c, #e0535a);
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }
    .ind-card:hover::after {
        transform: scaleX(1);
    }
    .ind-card-text {
        font-size: 13px; 
        font-weight: 700; 
        color: #111111; 
        text-transform: uppercase; 
        letter-spacing: 0.06em; 
        line-height: 1.5;
        transition: color 0.3s ease;
    }
    .ind-card:hover .ind-card-text {
        color: #c8232c;
    }
</style>

<!-- WATCH OUR DECORATION PROCESS VIDEO SEGMENT -->
<section class="py-5" style="background-color: #fafafa; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">

        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Watch Our Decoration Process
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="proc-video-container">
                    <iframe
                        class="proc-video-iframe"
                        src="https://www.youtube.com/embed/ScMzIvxBSi4"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- INDUSTRIES WE SERVE MATRIX SEGMENT -->
<section class="py-5" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">

        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Industries We Serve
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
        </div>

        <div class="row text-center justify-content-center g-4">

            <!-- Food & Beverage -->
            <div class="col-6 col-lg-2 col-md-4">
                <div class="ind-card">
                    <span class="ind-card-text">
                        Food &<br>Beverage
                    </span>
                </div>
            </div>

            <!-- Cosmetics -->
            <div class="col-6 col-lg-2 col-md-4">
                <div class="ind-card">
                    <span class="ind-card-text">
                        Cosmetics
                    </span>
                </div>
            </div>

            <!-- Perfumes -->
            <div class="col-6 col-lg-2 col-md-4">
                <div class="ind-card">
                    <span class="ind-card-text">
                        Perfumes
                    </span>
                </div>
            </div>

            <!-- Pharmaceuticals -->
            <div class="col-6 col-lg-2 col-md-4">
                <div class="ind-card">
                    <span class="ind-card-text">
                        Pharmaceu&shy;ticals
                    </span>
                </div>
            </div>

            <!-- Chemicals -->
            <div class="col-6 col-lg-2 col-md-4">
                <div class="ind-card">
                    <span class="ind-card-text">
                        Chemicals
                    </span>
                </div>
            </div>

            <!-- Hospitality -->
            <div class="col-6 col-lg-2 col-md-4">
                <div class="ind-card">
                    <span class="ind-card-text">
                        Hospitality
                    </span>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- WHY CHOOSE -->

<!-- INTEGRATED VALUE PROPOSITION & CTA SYSTEM STYLES -->
<style>
    /* Value Badge Feature Block Matrix */
    .val-badge {
        background-color: #ffffff; 
        border: 1px solid #eeeeee; 
        border-radius: 8px; 
        padding: 20px 22px; 
        display: flex; 
        align-items: center; 
        height: 100%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.01);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .val-badge:hover {
        border-color: #c8232c;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(200, 35, 44, 0.06);
    }
    .val-badge-icon {
        margin-right: 14px; 
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    .val-badge:hover .val-badge-icon {
        transform: scale(1.15);
    }
    .val-badge-text {
        font-size: 14px; 
        font-weight: 700; 
        color: #111111; 
        letter-spacing: 0.01em;
    }

    /* Premium Dynamic CTA Section Variables */
    .cta-premium-bg {
        background: linear-gradient(135deg, #272727 0%, #252525 100%); 
        color: #ffffff; 
        position: relative;
        overflow: hidden;
    }
    .cta-premium-bg::before {
        content: '';
        position: absolute;
        top: -50%; left: -30%; width: 60%; height: 200%;
        background: radial-gradient(circle, rgba(200,35,44,0.15) 0%, rgba(0,0,0,0) 70%);
        transform: rotate(-15deg);
        pointer-events: none;
    }
    
    /* Sliding Interaction Button Link Layout */
    .cta-btn-action {
        background: #c8232c;
        color: #ffffff; 
        font-size: 13px; 
        font-weight: 700; 
        letter-spacing: 0.06em; 
        padding: 15px 36px; 
        border: 1px solid #c8232c; 
        border-radius: 6px; 
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: color 0.4s ease, border-color 0.4s ease;
        display: inline-block;
        text-decoration: none;
    }
    .cta-btn-action::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: #ffffff;
        z-index: -1;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        transform: scaleY(0);
        transform-origin: bottom;
    }
    .cta-btn-action:hover::before {
        transform: scaleY(1);
    }
    .cta-btn-action:hover {
        color: #111111;
        border-color: #ffffff;
        text-decoration: none;
        box-shadow: 0 10px 25px rgba(255, 255, 255, 0.1);
    }
</style>

<!-- VALUE PROPOSITION GRID BLOCK -->
<section class="py-5" style="background-color: #fafafa; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">

        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Why Choose Alok Glass
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
        </div>

        <div class="row g-4">

            <!-- Core Value 1 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">Low MOQ</span>
                </div>
            </div>

            <!-- Core Value 2 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">Fast Turnaround</span>
                </div>
            </div>

            <!-- Core Value 3 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">Premium Quality</span>
                </div>
            </div>

            <!-- Core Value 4 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">Custom Branding</span>
                </div>
            </div>

            <!-- Core Value 5 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">Food Grade Solutions</span>
                </div>
            </div>

            <!-- Core Value 6 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">Export Packaging</span>
                </div>
            </div>

            <!-- Core Value 7 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">Experienced Team</span>
                </div>
            </div>

            <!-- Core Value 8 -->
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="val-badge">
                    <svg class="val-badge-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span class="val-badge-text">End-to-End Support</span>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- CONVERSION-FOCUSED CLOSING CTA SEGMENT -->
<section class="py-5 text-center cta-premium-bg" style="font-family: 'Montserrat', sans-serif;">
    <div class="container py-4" style="position: relative; z-index: 2;">

        <h2 class="mb-3 text-uppercase" style="font-size: 28px; font-weight: 800; letter-spacing: 0.04em;">
            Need Custom Decorated Packaging?
        </h2>

        <p class="mb-4 mx-auto" style="font-size: 15px; font-weight: 400; max-width: 620px; color: #cccccc; line-height: 1.7;">
            Get in touch with our team for customized glass bottle and jar decoration solutions.
        </p>

        <div class="mt-4 pt-2">
            <a href="bulk_inquiry.php" class="btn cta-btn-action text-uppercase">
                Request Bulk Quote
            </a>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>