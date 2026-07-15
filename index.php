<?php include 'includes/header.php'; ?>
<?php
require 'includes/db.php';

$categories = $pdo->query("
    SELECT * FROM categories
")->fetchAll();

$products = $pdo->query("
    SELECT * FROM products
")->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

$featuredCategories = $pdo->query("
    SELECT *
    FROM categories
    WHERE featured = 1
")->fetchAll();
?>
            
            
<main role="main">
    
    <style>
        /* Scoped styles for high-fidelity animations and premium layouts on index.php */
        
        /* 1. HERO SLIDER PREMIUM UPGRADES */
        .home-slider-wrap {
            position: relative;
            background-color: #0b0d10;
        }

        /* Cinematic overlay gradients with optimized contrast for premium glass photography */
        .slide-overlay-left {
            background: linear-gradient(90deg, rgba(17, 20, 26, 0.85) 0%, rgba(17, 20, 26, 0.6) 40%, rgba(17, 20, 26, 0) 100%) !important;
        }
        
        .slide-overlay-right {
            background: linear-gradient(270deg, rgba(17, 20, 26, 0.85) 0%, rgba(17, 20, 26, 0.6) 40%, rgba(17, 20, 26, 0) 100%) !important;
        }

        /* Hardware accelerated Ken Burns zoom effect for slides */
        .slider-image {
            transition: transform 8s cubic-bezier(0.16, 1, 0.3, 1) !important;
            will-change: transform;
        }
        
        .slide:hover .slider-image {
            transform: scale(1.05);
        }

        /* Captions entrance layout with high-performance CSS timing paths */
        .captions .caption-1 {
            opacity: 0;
            transform: translateY(20px);
            animation: sliderFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.3s;
        }

        .captions .caption-2 {
            opacity: 0;
            transform: translateY(25px);
            animation: sliderFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.5s;
        }

        .captions .btn-slider {
            opacity: 0;
            transform: translateY(30px);
            animation: sliderFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.7s;
        }

        @keyframes sliderFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 2. TRUST VALUE PROPOSITIONS (TRUST CARDS) */
        .trust-cards-wrapper {
            background-color: #ffffff;
            border-bottom: 1px solid #eef1f5;
        }

        /* Professional card wrapper that transitions smoothly */
        .trust-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: #ffffff;
            border: 1px solid rgba(17, 20, 26, 0.05);
            padding: 20px 24px;
            border-radius: 8px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        /* Premium hover states with delicate brand indicators */
        .trust-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-accent, #c8232c);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .trust-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(17, 20, 26, 0.05);
            border-color: rgba(200, 35, 44, 0.15);
        }

        .trust-card:hover::before {
            transform: scaleX(1);
        }

        /* Micro-animations for card icon images */
        .trust-card-icon {
            height: 40px !important;
            width: auto;
            object-fit: contain;
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .trust-card:hover .trust-card-icon {
            transform: scale(1.15) rotate(3deg);
        }

        .trust-card-text {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #2c323e;
            line-height: 1.4;
        }

        .trust-card-text b, 
        .trust-card-text label {
            font-family: 'Montserrat', sans-serif;
            color: var(--primary-accent, #c8232c) !important;
            font-weight: 700;
            font-size: 14px;
            margin: 0;
            display: inline-block;
        }

        /* Fluid layout adjustments for responsiveness */
        @media (max-width: 991.98px) {
            .trust-cards-grid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 16px !important;
                padding: 15px !important;
            }
            .trust-card {
                padding: 16px 20px;
            }
        }

        @media (max-width: 575.98px) {
            .trust-cards-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <!-- INTEGRATED YOUTUBE HERO SYSTEM -->
    <style>
        /* Hero Container Setup */
        .hero-yt-section {
            position: relative;
            width: 100%;
            min-height: 80vh; 
            display: flex;
            align-items: center;
            overflow: hidden;
            background-color: #111111;
            font-family: 'Montserrat', sans-serif;
        }

        /* YouTube Iframe Scaling Wrapper */
        .hero-yt-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Crucial: Makes the video unclickable */
            z-index: 1;
        }

        /* Scaling the iframe to cover the full container like 'object-fit: cover' */
        .hero-yt-wrapper iframe {
            width: 100vw;
            height: 56.25vw; /* 16:9 Aspect Ratio */
            min-height: 100vh;
            min-width: 177.77vh; /* 16:9 Aspect Ratio */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Overlay for Legibility */
        .hero-yt-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(75deg, rgba(17, 17, 17, 0.85) 0%, rgba(17, 17, 17, 0.4) 60%, rgba(17, 17, 17, 0.2) 100%);
            z-index: 2;
        }

        .hero-yt-content {
            position: relative;
            z-index: 3;
            width: 100%;
            
            /* Add animation properties */
            animation: heroFadeIn 1s ease-in forwards;
            opacity: 0; /* Starts hidden before animation */
        }

        /* Define the animation keyframes */
        @keyframes heroFadeIn {
            from {
                opacity: 0;
                transform: translateX(200px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }


        /* Premium Dynamic Button Link Layout */
        .hero-btn-action {
            background: #c8232c;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.06em;
            padding: 16px 36px;
            border: 1px solid #c8232c;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: color 0.4s ease, border-color 0.4s ease;
            display: inline-block;
            text-decoration: none;
            text-transform: uppercase;
        }
        .hero-btn-action::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #ffffff;
            z-index: -1;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            transform: scaleY(0);
            transform-origin: bottom;
        }
        .hero-btn-action:hover::before {
            transform: scaleY(1);
        }
        .hero-btn-action:hover {
            color: #111111;
            border-color: #ffffff;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.1);
        }

        /* Mobile Fluid Interventions */
        @media (max-width: 767.98px) {
            .hero-yt-section {
                min-height: 600px; /* Locks solid height on smaller portrait touch screens */
            }
            .hero-yt-content {
                text-align: center !important;
            }
            .hero-yt-content .text-start {
                text-align: center !important;
            }
        }

        .hero-yt-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .hero-local-video {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Forces the video to fill the container without distorting */
            pointer-events: none; /* Prevents users from right-clicking to pause or save the video */
        }
    </style>

    <!-- YOUTUBE HERO SECTION -->
    <div class="hero-yt-section">

        <div class="hero-yt-wrapper">
            <video 
                autoplay 
                muted 
                loop 
                playsinline 
                preload="auto"
                class="hero-local-video">
                <source src="assets/storage/media/hero-background.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Overlay Mask -->
        <div class="hero-yt-overlay"></div>

        <!-- Content Panel -->
        <div class="container hero-yt-content py-5">
            <div class="row">
                <div class="col-xl-7 col-lg-8 text-start">
                    
                    <span class="text-uppercase d-block mb-3" style="font-size: 14px; font-weight: 600; color: #ffffff; letter-spacing: 0.12em; opacity: 0.9;">
                        Premium Glassware Solutions
                    </span>

                    <h2 class="text-uppercase mb-4" style="font-size: 46px; font-weight: 800; color: var(--light-bg) !important; line-height: 1.2; letter-spacing: 0.001em;">
                        Crafting Glass With<br>Uncompromised Trust
                    </h2>
                    
                    <p class="mb-5" style="font-size: 16px; color: #dddddd; line-height: 1.7; max-width: 580px; font-weight: 400;">
                        Over 40 years of precision engineering excellence. Discover standard wholesale distribution lines and automated custom decoration systems built for international brands.
                    </p>

                    <div>
                        <a href="contact" class="hero-btn-action">
                            Contact Us
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- PREMIUM VALUE PROPOSITION BAR STYLES -->
    <style>
        .brand-value-bar {
            background-color: #ffffff;
            border-top: 1px solid #eeeeee;
            border-bottom: 1px solid #eeeeee;
            font-family: 'Montserrat', sans-serif;
        }

        .value-item {
            padding: 24px 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        /* Subtle interaction accent */
        .value-item:hover {
            transform: translateY(-2px);
        }

        /* Elegant top metric */
        .value-metric {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #777777;
            letter-spacing: 0.1em;
            margin-bottom: 4px;
        }

        /* Bold accent baseline */
        .value-title {
            display: block;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            color: #111111;
            letter-spacing: 0.02em;
        }

        /* Subtle left borders between elements on desktop layouts */
        @media (min-width: 768px) {
            .value-item {
                border-left: 1px solid #f0f0f0;
            }
            .row > .value-item:first-child {
                border-left: none;
            }
        }

        /* Clean row gaps on small viewports */
        @media (max-width: 767.98px) {
            .value-item {
                padding: 20px 10px;
            }
            /* Visual separation for 2x2 grid format on phones */
            .value-item:nth-child(1), .value-item:nth-child(2) {
                border-bottom: 1px solid #f5f5f5;
            }
        }
    </style>

    <!-- VALUE PROPOSITION SECTION -->
    <div class="container-fluid brand-value-bar py-2">
        <div class="container">
            <!-- 
            Using proper Bootstrap responsive columns:
            col-6  = 2 items per row on mobile (neat 2x2 grid)
            col-md-3 = 4 items in a single line on tablets and desktops
            -->
            <div class="row g-0">
                
                <!-- Metric Card 1 -->
                <div class="col-6 col-md-3 value-item">
                    <span class="value-metric">Trusted For</span>
                    <span class="value-title" style="color: #c8232c;">4 Decades</span>
                </div>

                <!-- Metric Card 2 -->
                <div class="col-6 col-md-3 value-item">
                    <span class="value-metric">Highest Quality</span>
                    <span class="value-title" style="color: #c8232c;">Wholesale Rates</span>
                </div>

                <!-- Metric Card 3 -->
                <div class="col-6 col-md-3 value-item">
                    <span class="value-metric">Fast Dispatch</span>
                    <span class="value-title" style="color: #c8232c;">Guaranteed</span>
                </div>

                <!-- Metric Card 4 -->
                <div class="col-6 col-md-3 value-item">
                    <span class="value-metric">Secure Support</span>
                    <span class="value-title" style="color: #c8232c;">Hassle-Free</span>
                </div>

            </div>
        </div>
    </div>

        <!-- Shop by Industry Starts -->
        
        <!-- Shop by Industry Ends -->
        
       <!-- Shop by Product Starts -->
       <!-- Shop by Product Starts -->
        <!-- PREMIUM PRODUCT CATEGORIES STYLES -->
        <style>
            /* Component Reset & Scoping */
            .product-section-wrapper {
                font-family: 'Montserrat', sans-serif;
                background-color: #ffffff;
            }

            /* Minimalist High-End Section Title */
            .product-main-title {
                font-size: 32px;
                font-weight: 800;
                color: #111111;
                letter-spacing: 0.04em;
                position: relative;
                display: inline-block;
                padding-bottom: 16px;
            }
            .product-main-title::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 50px;
                height: 3px;
                background-color: #c8232c;
            }

            /* B2B Premium Category Card Structure */
            .product-category-card {
                border: 1px solid #eef0f2;
                border-radius: 6px;
                overflow: hidden;
                background-color: #ffffff;
                height: 100%;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }

            /* Image Scaling Mechanism */
            .product-card-media {
                display: block;
                overflow: hidden;
                aspect-ratio: 4 / 3;
                background-color: #ffffff;
                position: relative;
            }
            .product-card-media img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }

            /* Text Band Base Layer Setup */
            .product-card-banner {
                padding: 18px 12px;
                text-align: center;
                text-transform: uppercase;
                transition: background-color 0.3s ease;
            }
            
            .product-card-link {
                font-size: 14px;
                font-weight: 700;
                color: #ffffff;
                text-decoration: none;
                display: block;
                letter-spacing: 0.05em;
            }
            .product-card-link:hover {
                text-decoration: none;
                color: #ffffff;
            }

            /* Dynamic Parent-Child Animation Sync */
            .product-category-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 16px 32px rgba(17, 17, 17, 0.08);
            }
            .product-category-card:hover .product-card-media img {
                transform: scale(1.05);
            }

            /* Palette Variant Engine */
            .bg-palette-accent {
                background-color: #c8232c;
                border-top: 2px solid #a11b22;
            }
            .bg-palette-charcoal {
                background-color: #111111;
                border-top: 2px solid #222222;
            }
        </style>

        <!-- PRODUCT CATEGORY GRID LAYOUT -->
        <div class="container product-section-wrapper py-5 reveal-on-scroll">

            <!-- Section Header Area -->
            <div class="text-center mb-5 pb-2">
                <h2 class="text-uppercase product-main-title">
                    Shop by Product
                </h2>
            </div>

            <!-- Active Responsive Column Grid Matrix -->
            <div class="row g-4">

                <?php foreach($featuredCategories as $index => $category): ?>

                    <?php
                    // Assign custom high-end palette classification tokens based on original indexing
                    $variantClass = ($index % 2 == 0) ? 'bg-palette-accent' : 'bg-palette-charcoal';
                    ?>

                    <!-- 
                        Replaced exclusive desktop lock with smooth fluid breaks:
                        col-12 = Full stack on mobile
                        col-sm-6 = 2 cards side-by-side on tablets
                        col-lg-4 = 3 cards clean row on wide desktop displays
                    -->
                    <div class="col-16 col-sm-6 col-lg-6 mb-2">

                        <!-- Product Category Card Frame with modern lifting effect -->
                        <div class="product-category-card">

                            <!-- Image Wrapper Container for Zoom Effect -->
                            <a href="category.php?slug=<?= $category['slug'] ?>" class="product-card-media">
                                <img src="<?= $category['image'] ?>" alt="<?= htmlspecialchars($category['name']) ?>">
                            </a>

                            <!-- Styled Banner Text Band -->
                            <div class="product-card-banner <?= $variantClass ?>">
                                <a href="category.php?slug=<?= $category['slug'] ?>" class="product-card-link">
                                    <?= htmlspecialchars($category['name']) ?>
                                </a>
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
        <!-- MOBILE VERSION -->
        <!-- <div class="container pt-6 only-mobile animate__animated animate__fadeInUp" style="padding-top: 3.5rem; padding-bottom: 2.5rem; padding-left: 15px; padding-right: 0px; overflow-x: hidden; --animate-duration: 0.8s;"> -->

            <!-- Section Title with Accent Underline -->
            <!-- <h2 class="text-center text-uppercase org-brd-btm mb-4" style="font-family: 'Montserrat', sans-serif; font-size: 22px; font-weight: 700; color: #111111; letter-spacing: 0.04em; display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 2.5rem; padding-right: 15px;">
                <img src="assets/themes/storefront/public/images/shop-by-product-icone8da.png?v=2.0.3" class="pr-3 pt-2" style="max-height: 28px; width: auto;" alt="" />
                <span style="position: relative; padding-bottom: 10px;">
                    Shop by Product
                    <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 45px; height: 3px; background-color: #c8232c;"></span>
                </span>
            </h2> -->

            <!-- Smooth Horizontal Touch Scroller Container -->
            <!-- <div class="mobile-product-scroller" style="display: flex; overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch; gap: 16px; padding-bottom: 15px; padding-right: 15px; scroll-snap-type: x mandatory;">

                <?php foreach($featuredCategories as $index => $category): ?>

                    <?php
                    // Alternating brand themes for item cards -->
                    // $bgStyle = ($index % 2 == 0)
                    //     ? 'background-color: #c8232c; border-top: 2px solid #a11b22;' 
                    //     : 'background-color: #111111; border-top: 2px solid #222222;';
                    // ?>

                    <!-- Individual Product Card Item -->
                    <!-- <div class="scroller-item <?= $index == 0 ? 'active' : '' ?>" style="flex: 0 0 78%; min-width: 260px; max-width: 300px; background-color: #ffffff; border-radius: 6px; overflow: hidden; box-shadow: 0 4px 12px rgba(17, 17, 17, 0.06); border: 1px solid #eef0f2; scroll-snap-align: start; transition: transform 0.2s ease;">

                        <a href="category.php?slug=<?= $category['slug'] ?>" style="display: block; width: 100%; aspect-ratio: 4/3; overflow: hidden;">
                            <img
                                src="<?= $category['image'] ?>"
                                class="d-block w-100"
                                style="width: 100%; height: 100%; object-fit: cover;"
                                alt="<?= htmlspecialchars($category['name']) ?>"
                            >
                        </a> -->

                        <!-- Styled Text Band Label -->
                        <!-- <div class="<?= $bgClass ?> sb text-uppercase fs18 text-center p-2" style="<?= $bgStyle ?> padding: 14px 8px;">

                            <a
                                href="category.php?slug=<?= $category['slug'] ?>"
                                class="link-block text-white"
                                style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 700; color: #ffffff; text-decoration: none; display: block; letter-spacing: 0.03em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                            >
                                <?= htmlspecialchars($category['name']) ?>
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div> -->
        <!-- Custom Style Component to hide scrollbars elegantly across browsers -->
        <!-- <style>
            .mobile-product-scroller::-webkit-scrollbar {
                display: none;
            }
            .mobile-product-scroller {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }
        </style> -->

        <!-- Shop by Product Ends -->
        <!-- Shop by Product Ends -->


        <!-- Popular bottle Starts -->
        <?php
        require 'includes/db.php';

        $stmt = $pdo->prepare("
            SELECT *
            FROM categories
            WHERE section_title IS NOT NULL
        ");

        $stmt->execute();

        $homeCategories = $stmt->fetchAll();
        ?>

        <?php foreach($homeCategories as $category): ?>

        <?php
        $productStmt = $pdo->prepare("
            SELECT *
            FROM products
            WHERE category_id = ?
            AND show_on_home = 1
            ORDER BY id DESC
            
        ");

        $productStmt->execute([$category['id']]);

        $products = $productStmt->fetchAll();

        if(count($products) === 0){
            continue;
        }
        ?>

        <!-- B2B HIGH-END PRODUCT GRID SYSTEM STYLES -->
        <!-- DEPENDENCIES FOR ICONS ONLY -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            /* ==========================================================================
            PREMIUM INTERACTIVE SCROLLER SYSTEM
            ========================================================================== */
            .ticker-showcase-wrapper {
                background-color: #ffffff;
                padding: 60px 0;
                font-family: 'Montserrat', sans-serif;
                position: relative;
            }

            /* Header Grid: Title on Left, Custom Arrows on Right */
            .ticker-header-container {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                margin-bottom: 30px;
                border-bottom: 2px solid #eef0f2;
                padding-bottom: 15px;
            }

            .ticker-section-title {
                font-size: 28px;
                font-weight: 800;
                color: #111111;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin: 0;
                position: relative;
            }
            .ticker-section-title::after {
                content: '';
                position: absolute;
                bottom: -17px;
                left: 0;
                width: 60px;
                height: 3px;
                background-color: #c8232c; /* Alok Red Accent */
            }

            /* Sleek Navigation Controls */
            .ticker-control-btns {
                display: flex;
                gap: 8px;
            }
            .ticker-control-btns button {
                background: #161616 !important;
                border: 1px solid #262626 !important;
                color: #ffffff !important;
                width: 40px;
                height: 40px;
                border-radius: 4px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .ticker-control-btns button:hover {
                background: #c8232c !important;
                border-color: #c8232c !important;
            }

            /* THE MANUAL SCROLL WINDOW (With custom high-end scrollbar) */
            .ticker-viewport {
                width: 100%;
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
                position: relative;
                padding: 15px 0 25px 0;
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch; /* Butter-smooth iOS momentum scrolling */
            }

            /* Premium Sleek Scrollbar Styling */
            .ticker-viewport::-webkit-scrollbar {
                height: 6px;
            }
            .ticker-viewport::-webkit-scrollbar-track {
                background: #eef0f2;
                border-radius: 10px;
            }
            .ticker-viewport::-webkit-scrollbar-thumb {
                background: #c8232c; /* Red Scrollbar Grabber */
                border-radius: 10px;
                transition: background 0.3s ease;
            }
            .ticker-viewport::-webkit-scrollbar-thumb:hover {
                background: #111111; /* Darkens on hover */
            }

            .ticker-track {
                display: inline-flex;
                gap: 24px;
            }

            /* ==========================================================================
            PRODUCT ITEM CARD ARCHITECTURE (Charcoal and Red Theme)
            ========================================================================== */
            .ticker-product-card {
                display: inline-flex;
                flex-direction: column;
                width: 240px; /* Fixed standard sizing */
                background: #161616; /* Clean Charcoal Base */
                border: 1px solid #262626;
                border-radius: 18px;
                padding: 16px;
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                            box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                text-decoration: none !important;
                white-space: normal; /* Restores normal text wrapping inside card blocks */
                box-sizing: border-box;
            }

            .ticker-product-card:hover {
                transform: translateY(-5px);
                border-color: #c8232c;
                box-shadow: 0 12px 30px rgba(200, 35, 44, 0.15);
            }

            /* White Background Container to Pop Your Glassware Products */
            .ticker-media-box {
                width: 100%;
                aspect-ratio: 1 / 1;
                background-color: #ffffff;
                border-radius: 4px;
                overflow: hidden;
                margin-bottom: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 15px;
                box-sizing: border-box;
            }

            .ticker-media-box img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                transition: transform 0.5s ease;
            }

            .ticker-product-card:hover .ticker-media-box img {
                transform: scale(1.06);
            }

            /* Details Panel Typography */
            .ticker-details-box {
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }

            .ticker-product-title {
                font-size: 13.5px;
                font-weight: 600;
                color: #c8232c !important;
                line-height: 1.4;
                margin: 0 0 8px 0;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                height: 38px;
            }

            .ticker-product-price {
                font-size: 15px;
                font-weight: 700;
                color: #ffffff;
                margin-top: auto;
            }

            /* RESPONSIVE LAYOUT MATRIX ADJUSTMENTS */
            @media (max-width: 767.98px) {
                .ticker-showcase-wrapper { padding: 40px 0; }
                .ticker-header-container { flex-direction: column; align-items: flex-start; gap: 15px; }
                .ticker-section-title { font-size: 22px; }
                .ticker-product-card { width: 190px; padding: 12px; }
                .ticker-product-title { font-size: 12.5px; height: 34px; }
                .ticker-product-price { font-size: 14px; }
                .ticker-control-btns { display: none; } /* On mobile, standard native touch swiping is preferred */
            }
        </style>

    <!-- PRODUCT SHOWCASE SECTION -->
        <div class="ticker-showcase-wrapper">
            <div class="container">
                
                <!-- Premium Section Header Console -->
                <div class="ticker-header-container">
                    <h2 class="ticker-section-title">
                        <?= htmlspecialchars($category['section_title'] ?? 'Our Featured Range') ?>
                    </h2>
                    
                    <!-- Sleek Control Pillar -->
                    <div class="ticker-control-btns">
                        <button id="scroller-prev-btn" aria-label="Scroll Left"><i class="fa-solid fa-chevron-left"></i></button>
                        <button id="scroller-next-btn" aria-label="Scroll Right"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>

                <!-- Scrollable Window Area -->
                <div class="ticker-viewport" id="scroll-engine-viewport">
                    <div class="ticker-track">
                        
                        <?php foreach($products as $product): ?>
                            <a href="product.php?slug=<?= urlencode($product['slug']) ?>" class="ticker-product-card">
                                <div class="ticker-media-box">
                                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                                </div>
                                <div class="ticker-details-box">
                                    <h3 class="ticker-product-title"><?= htmlspecialchars($product['name']) ?></h3>
                                    <span class="ticker-product-price">₹<?= number_format($product['price'], 2) ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>

                    </div>
                </div>

            </div>
        </div>

    <!-- STABLE MULTI-INTERACTION CONTROLLER SCRIPT -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const viewport = document.getElementById('scroll-engine-viewport');
                const nextBtn = document.getElementById('scroller-next-btn');
                const prevBtn = document.getElementById('scroller-prev-btn');
                
                const scrollAmount = 264; // Distance to scroll on click (240px card width + 24px gap)
                const autoScrollSpeed = 1; // Pixels to slide per interval step
                const autoScrollInterval = 30; // Milliseconds between steps
                
                let autoPlayActive = true;
                let scrollDirection = 1; // 1 = Right, -1 = Left
                let autoScrollTimer;

                // Smooth Auto-Scrolling System
                function runAutoScroll() {
                    if (!autoPlayActive) return;
                    
                    // Increment container scroll layout
                    viewport.scrollLeft += (autoScrollSpeed * scrollDirection);
                    
                    // Loop scroll direction boundaries smoothly
                    const maxScrollLeft = viewport.scrollWidth - viewport.clientWidth;
                    if (viewport.scrollLeft >= maxScrollLeft - 1) {
                        scrollDirection = -1; // Reverse to left once the end is reached
                    } else if (viewport.scrollLeft <= 1) {
                        scrollDirection = 1; // Slide forward once the beginning is reached
                    }
                }

                // Start running the loop
                function startLoop() {
                    stopLoop();
                    autoScrollTimer = setInterval(runAutoScroll, autoScrollInterval);
                }

                function stopLoop() {
                    if (autoScrollTimer) clearInterval(autoScrollTimer);
                }

                // Action Click Events (Standard behavior)
                if (nextBtn && prevBtn) {
                    nextBtn.addEventListener('click', function() {
                        autoPlayActive = false;
                        stopLoop();
                        viewport.scrollLeft += scrollAmount;
                    });

                    prevBtn.addEventListener('click', function() {
                        autoPlayActive = false;
                        stopLoop();
                        viewport.scrollLeft -= scrollAmount;
                    });
                }

                // Hover Pausing Loops for Mouse Users
                viewport.addEventListener('mouseenter', () => {
                    autoPlayActive = false;
                    stopLoop();
                });

                viewport.addEventListener('mouseleave', () => {
                    autoPlayActive = true;
                    startLoop();
                });

                // Touch Interaction Safety Hooks
                viewport.addEventListener('touchstart', () => {
                    autoPlayActive = false;
                    stopLoop();
                });

                // Start initialization sequence
                startLoop();
            });
        </script>
        <?php endforeach; ?>
        <!-- Popular bottle Ends -->
        
        
        <!-- Stats Starts -->
        <style>
            .counter-scaffolding {
                background-color: #fcfbfa; 
                border-top: 1px solid #eef0f2; 
                border-bottom: 1px solid #eef0f2;
                font-family: 'Montserrat', sans-serif;
            }

            .stat-metric-node {
                padding: 40px 15px;
                text-align: center;
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            
            .stat-metric-node:hover {
                transform: translateY(-5px);
            }

            .stat-node-icon {
                height: 44px; 
                width: auto; 
                object-fit: contain;
                filter: drop-shadow(0 2px 4px rgba(0,0,0,0.02));
                transition: transform 0.3s ease;
            }
            .stat-metric-node:hover .stat-node-icon {
                transform: scale(1.08);
            }

            .stat-node-number {
                font-size: 32px; 
                font-weight: 800; 
                color: #c8232c; 
                margin: 12px 0 4px 0;
                line-height: 1.1;
                letter-spacing: -0.02em;
            }

            .stat-node-label {
                font-size: 12px; 
                font-weight: 700; 
                color: #111111; 
                margin: 0; 
                text-transform: uppercase; 
                letter-spacing: 0.06em;
                line-height: 1.4;
            }

            /* Mobile & Tablet Fine-Tuning Overrides */
            @media (max-width: 991.98px) {
                .stat-metric-node {
                    padding: 25px 10px;
                }
                .stat-node-number {
                    font-size: 26px;
                }
            }
        </style>

        <div class="container-fluid counter-scaffolding mask-reveal">
            <div class="container">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 justify-content-center g-2 g-md-4">
                    
                    <div class="col stat-metric-node">
                        <img src="assets/themes/storefront/public/images/stats-satisfied-customer-icone8da.png?v=2.0.3" class="stat-node-icon" alt="Customers" />
                        <h3 class="stat-node-number">
                            <span class="live-count" data-target="7379">0</span>+
                        </h3>
                        <p class="stat-node-label">Satisfied Customers</p>
                    </div>
                    
                    <div class="col stat-metric-node">
                        <img src="assets/themes/storefront/public/images/stats-bottle-choose-icone8da.png?v=2.0.3" class="stat-node-icon" alt="Selection" />
                        <h3 class="stat-node-number">
                            <span class="live-count" data-target="157">0</span>+ Bottles
                        </h3>
                        <p class="stat-node-label">To Choose From</p>
                    </div>
                    
                    <div class="col stat-metric-node">
                        <img src="assets/themes/storefront/public/images/stats-bottle-sold-icone8da.png?v=2.0.3" class="stat-node-icon" alt="Volume" />
                        <h3 class="stat-node-number">
                            <span class="live-count" data-target="3">0</span>Billion+
                        </h3>
                        <p class="stat-node-label">Bottles Sold</p>
                    </div>
                    
                    <div class="col stat-metric-node">
                        <img src="assets/themes/storefront/public/images/stats-experience-icone8da.png?v=2.0.3" class="stat-node-icon" alt="History" />
                        <h3 class="stat-node-number">
                            <span class="live-count" data-target="40">0</span>+
                        </h3>
                        <p class="stat-node-label">Years Experience</p>
                    </div>
                    
                    <div class="col col-12 col-md-4 col-lg stat-metric-node">
                        <img src="assets/themes/storefront/public/images/stats-revenue-icone8da.png?v=2.0.3" class="stat-node-icon" alt="Retention" />
                        <h3 class="stat-node-number">
                            <span class="live-count" data-target="96">0</span>%
                        </h3>
                        <p class="stat-node-label">Repeat Revenue</p>
                    </div>
                    
                </div>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counterElements = document.querySelectorAll(".live-count");
            
            const runCounterAnimation = (element) => {
                const targetValue = parseInt(element.getAttribute("data-target"), 10);
                const cycleDuration = 2000; // Total runtime speed in milliseconds
                const frameRateInterval = 1000 / 60; // 60 FPS Calculations
                const totalFrames = Math.round(cycleDuration / frameRateInterval);
                let currentFrame = 0;

                const countingTick = () => {
                    currentFrame++;
                    // Smooth progress easing curve
                    const progressionRatio = currentFrame / totalFrames;
                    const currentValCalculated = Math.floor(targetValue * progressionRatio);

                    if (currentFrame < totalFrames) {
                        element.innerText = currentValCalculated;
                        requestAnimationFrame(countingTick);
                    } else {
                        element.innerText = targetValue; // Snap perfectly to absolute target
                    }
                };
                
                requestAnimationFrame(countingTick);
            };

            // Intersection Observer Engine triggers animation ONLY when user scrolls to it
            const moduleScrollObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        runCounterAnimation(entry.target);
                        observer.unobserve(entry.target); // Prevents re-triggering when scrolling away
                    }
                });
            }, { threshold: 0.15 });

            counterElements.forEach(element => moduleScrollObserver.observe(element));
        });
        </script>
        <!-- Stats Starts -->

    
        <!-- International Coverage Starts -->
        <!-- International Coverage Starts -->
        <div class="container pt-6 reveal-on-scroll" style="padding-top: 4rem; padding-bottom: 4rem;">
            
            <!-- Section Title with Accent Underline -->
            <h2 class="text-center text-uppercase org-brd-btm mb-5" style="font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 700; color: #111111; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 3.5rem;">
                <img src="assets/themes/storefront/public/images/international-coverage-icone8da.png?v=2.0.3" class="pr-3" style="max-height: 32px; width: auto;" alt="" />
                <span style="position: relative; padding-bottom: 12px;">
                    International coverage on Alok Glass Works Bottle
                    <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background-color: #c8232c;"></span>
                </span>
            </h2>

            <div class="row" style="display: flex; flex-wrap: wrap; gap: 0;">
                
                <!-- First Card Segment -->
                <div class="col-md-6 pb-4" style="margin-bottom: 1.5rem;">
                    <div class="shadow-post lt-blue-bg bor-radius-25" style="background-color: #fdfdfd; border: 1px solid #eef0f2; border-radius: 8px; overflow: hidden; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 24px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.04)';">
                        
                        <!-- Header Flex Splitter -->
                        <div style="display: flex; width: 100%; align-items: stretch; border-bottom: 1px solid #eef0f2;">
                            <div style="flex: 1; background-color: #ffffff; display: flex; align-items: center; justify-content: center; padding: 15px;">
                                <a href="#" style="display: block; width: 100%; max-width: 140px;">
                                    <img src="assets/themes/storefront/public/images/harward-logoe8da.jpg?v=2.0.3" class="img-fluid d-block m-auto" style="max-height: 50px; width: auto;" alt="Harvard" />
                                </a>
                            </div>
                            <div style="flex: 1; background-color: #111111; display: flex; align-items: center; justify-content: center; padding: 15px; border-left: 1px solid #eef0f2;">
                                <h3 class="text-white font-weight-bold text-uppercase" style="font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 700; color: #ffffff; letter-spacing: 0.08em; margin: 0;">Case Study</h3>
                            </div>
                        </div>

                        <!-- Card Body Elements -->
                        <div class="pt-4 pr-4 pb-4 pl-4" style="padding: 2rem 1.5rem;">
                            <p class="text-center fs18" style="margin-bottom: 1rem;">
                                <a href="#" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#c8232c'" onmouseout="this.style.color='#111111'">
                                    <strong>Alok Glass Works PACKAGING:</strong> Key Account Management
                                </a>
                            </p>
                            <p class="pb-4" style="font-family: 'Montserrat', sans-serif; font-size: 13.5px; line-height: 1.6; color: #555555; text-align: justify; margin-bottom: 1.5rem;">
                                In the fall of 2017, Alok Glass Works Packaging (Alok Glass Works) was among the fastest growing glass bottle-packaging companies in India. Although the company had a large buyer base of 1,700 customers, buyer, S.F. Foods (SF) which accounted for 15 per cent of Alok Glass Works's revenue.
                            </p>
                            <div class="text-center">
                                <a href="https://hbsp.harvard.edu/product/W18241-PDF-ENG" style="text-decoration: none;">
                                    <button type="button" class="btn btn-org-1" style="background-color: #c8232c; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 13px; border: none; padding: 10px 24px; border-radius: 4px; box-shadow: 0 4px 12px rgba(200, 35, 44, 0.2); transition: all 0.2s ease; cursor: pointer;" onmouseover="this.style.backgroundColor='#111111'" onmouseout="this.style.backgroundColor='#c8232c'">
                                        View More &rsaquo;
                                    </button>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Second Card Segment -->
                <div class="col-md-6 pb-4" style="margin-bottom: 1.5rem;">
                    <div class="shadow-post lt-blue-bg bor-radius-25" style="background-color: #fdfdfd; border: 1px solid #eef0f2; border-radius: 8px; overflow: hidden; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 24px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.04)';">
                        
                        <!-- Header Flex Splitter -->
                        <div style="display: flex; width: 100%; align-items: stretch; border-bottom: 1px solid #eef0f2;">
                            <div style="flex: 1; background-color: #ffffff; display: flex; align-items: center; justify-content: center; padding: 15px;">
                                <a href="#" style="display: block; width: 100%; max-width: 140px;">
                                    <img src="assets/themes/storefront/public/images/harward-logoe8da.jpg?v=2.0.3" class="img-fluid d-block m-auto" style="max-height: 50px; width: auto;" alt="Harvard" />
                                </a>
                            </div>
                            <div style="flex: 1; background-color: #111111; display: flex; align-items: center; justify-content: center; padding: 15px; border-left: 1px solid #eef0f2;">
                                <h3 class="text-white font-weight-bold text-uppercase" style="font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 700; color: #ffffff; letter-spacing: 0.08em; margin: 0;">Case Study</h3>
                            </div>
                        </div>

                        <!-- Card Body Elements -->
                        <div class="pt-4 pr-4 pb-4 pl-4" style="padding: 2rem 1.5rem;">
                            <p class="text-center fs18" style="margin-bottom: 1rem;">
                                <a href="#" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#c8232c'" onmouseout="this.style.color='#111111'">
                                    <strong>Alok Glass Works PACKAGING</strong>
                                </a>
                            </p>
                            <p class="pb-4" style="font-family: 'Montserrat', sans-serif; font-size: 13.5px; line-height: 1.6; color: #555555; text-align: justify; margin-bottom: 1.5rem;">
                                The Indian packaging industry - represented by a mix of paperboard, plastics, metals and glass - had seen great change leading up to 2013. In 2012, Suppliers of glass bottles in India with an employee base of more than 50 and net revenues of US$100 million.
                            </p>
                            <div class="text-center">
                                <a href="https://hbsp.harvard.edu/product/W13599-PDF-ENG" style="text-decoration: none;">
                                    <button type="button" class="btn btn-org-1" style="background-color: #c8232c; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 13px; border: none; padding: 10px 24px; border-radius: 4px; box-shadow: 0 4px 12px rgba(200, 35, 44, 0.2); transition: all 0.2s ease; cursor: pointer;" onmouseover="this.style.backgroundColor='#111111'" onmouseout="this.style.backgroundColor='#c8232c'">
                                        View More &rsaquo;
                                    </button>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- International Coverage Ends -->
        <!-- International Coverage Ends -->
        
        <!-- Latest Blog Starts -->
        <!-- Latest Blogs Starts -->

            <?php

            $homeBlogsStmt = $pdo->query("
                SELECT
                    id,
                    title,
                    slug,
                    image
                FROM blogs
                WHERE status = 1
                ORDER BY id DESC
                LIMIT 4
            ");

            $homeBlogs = $homeBlogsStmt->fetchAll(PDO::FETCH_ASSOC);

            ?>
         
            <div class="container pt-6 mask-reveal reveal-on-scroll" style="padding-top: 4rem; padding-bottom: 4rem;">

                <!-- Section Title with Accent Underline -->
                <h2 class="text-center text-uppercase org-brd-btm mb-5" style="font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 14px; margin-bottom: 3.5rem;">
                    Latest Blogs
                    <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background-color: #c8232c;"></span>
                </h2>

                <div class="row">

                    <div class="col-md-12">

                        <div class="row" style="display: flex; flex-wrap: wrap;">

                            <!-- Blog Item 1 -->
                            <?php
                            $delay = 100;
                            foreach($homeBlogs as $blog):
                            ?>

                            <div
                                class="col-md-3 col-6"
                                style="margin-bottom:2rem;display:flex;flex-direction:column;"
                                data-aos="fade-up"
                                data-aos-delay="<?= $delay ?>"
                                data-aos-duration="700">

                                <div class="latest-image-box">

                                    <a
                                        href="blog.php?slug=<?= urlencode($blog['slug']) ?>"
                                        class="blog-image-link">

                                        <img
                                            src="<?= htmlspecialchars($blog['image']) ?>"
                                            class="img-fluid"
                                            alt="<?= htmlspecialchars($blog['title']) ?>">
                                    </a>

                                    <div class="blog-content-box">

                                        <a
                                            href="blog.php?slug=<?= urlencode($blog['slug']) ?>"
                                            class="blog-title-link">

                                            <?= htmlspecialchars($blog['title']) ?>

                                        </a>

                                    </div>

                                </div>

                            </div>

                            <?php
                            $delay += 100;
                            endforeach;
                            ?>

                        </div>

                        <!-- Footer View Action Button -->
                        <div class="text-center pt-4 pb-3">
                            <a href="blogs.php" style="text-decoration: none;">
                                <button type="button" class="btn btn-org-1" style="background-color: #c8232c; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 13px; border: none; padding: 10px 24px; border-radius: 4px; box-shadow: 0 4px 12px rgba(200, 35, 44, 0.2); transition: all 0.2s ease; cursor: pointer;" onmouseover="this.style.backgroundColor='#111111'" onmouseout="this.style.backgroundColor='#c8232c'">
                                    More Blogs &rsaquo;
                                </button>
                            </a>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Dynamic styling hooks for link title hover triggers -->
            <style>
                .latest-image-box:hover .blog-title-link {
                    color: #c8232c !important;
                }
                .latest-image-box{

                    background:#ffffff;
                    border:1px solid #eef0f2;
                    border-radius:4px;
                    overflow:hidden;

                    height:100%;

                    display:flex;
                    flex-direction:column;

                    box-shadow:0 3px 10px rgba(0,0,0,.03);

                    transition:
                        transform .45s cubic-bezier(.22,.61,.36,1),
                        box-shadow .45s ease;

                }

                .latest-image-box:hover{

                    transform:translateY(-6px);

                    box-shadow:0 14px 28px rgba(17,17,17,.08);

                }

                .blog-image-link{

                    display:block;

                    width:100%;

                    aspect-ratio:16/10;

                    overflow:hidden;

                    background:#f7f7f7;

                }

                .blog-image-link img{

                    width:100%;

                    height:100%;

                    object-fit:cover;

                    transition:transform .55s ease;

                }

                .latest-image-box:hover img{

                    transform:scale(1.06);

                }

                .blog-content-box{

                    padding:14px;

                    display:flex;

                    flex-grow:1;

                }

                .blog-title-link{

                    font-family:'Montserrat',sans-serif;

                    font-size:13px;

                    font-weight:600;

                    color:#111;

                    text-decoration:none;

                    line-height:1.5;

                    display:-webkit-box;

                    -webkit-line-clamp:3;

                    -webkit-box-orient:vertical;

                    overflow:hidden;

                    transition:color .25s ease;

                }

                .latest-image-box:hover .blog-title-link{

                    color:#c8232c;

                }
            </style>
        <!-- Latest Blogs Ends -->
        <!-- Latest Blogs Ends -->

        <!-- Google Review Starts -->
        <!-- Google Reviews Section Starts -->
        <div class="container pt-6 reveal-on-scroll" style="padding-top: 4rem; padding-bottom: 4rem;">

            
            <!-- Heading Container with Red Accent Underline -->
            <h2 class="text-center text-uppercase org-brd-btm mb-5" style="font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 700; color: #111111; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 3.5rem; position: relative; padding-bottom: 14px;">
                <img src="assets/themes/storefront/public/images/google-reviews-icone8da.png?v=2.0.3" class="pr-3" style="max-height: 32px; width: auto;" alt="" />
                <span>
                    GOOGLE REVIEWS BY REAL CUSTOMERS
                    <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background-color: #c8232c;"></span>
                </span>
            </h2>

            <div class="row" style="display: flex; flex-wrap: wrap; align-items: stretch;">
                
                <!-- Left Column: Company Rating Summary Panel -->
                <div class="col-md-4 pb-5 text-center google-company-details" style="margin-bottom: 1.5rem; display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: #fdfdfd; border: 1px solid #eef0f2; border-radius: 8px; padding: 2.5rem 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <h3 class="txt-333" style="font-family: 'Montserrat', sans-serif; font-size: 20px; font-weight: 700; color: #111111; margin-bottom: 1rem;">Alok Glass Works Bottle Pvt Ltd</h3>
                    
                    <ul class="pb-4" style="list-style: none; padding: 0; margin: 0 0 1.5rem 0; display: flex; align-items: center; justify-content: center; gap: 4px; flex-wrap: wrap;">
                        <li class="txt-gray fs32 pr-2 align-middle" style="font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 700; color: #111111; margin-right: 8px;">4.8</li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" style="height: 22px; width: auto;" alt="Star" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" style="height: 22px; width: auto;" alt="Star" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" style="height: 22px; width: auto;" alt="Star" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" style="height: 22px; width: auto;" alt="Star" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" style="height: 22px; width: auto;" alt="Star" /></li>
                        <li class="txt-gray align-content-center" style="font-family: 'Montserrat', sans-serif; font-size: 13.5px; color: #666666; width: 100%; margin-top: 6px;">815 reviews</li>
                    </ul>

                    <button type="button" class="btn btn-org-1" style="background-color: #c8232c; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 13px; border: none; padding: 12px 24px; border-radius: 4px; box-shadow: 0 4px 12px rgba(200, 35, 44, 0.2); transition: all 0.2s ease; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px;" onmouseover="this.style.backgroundColor='#111111'" onmouseout="this.style.backgroundColor='#c8232c'">
                        <img src="assets/themes/storefront/public/images/vision-icone8da.png?v=2.0.3" style="height: 16px; width: auto; filter: brightness(0) invert(1);" alt="" />
                        See More Reviews
                    </button> 
                </div>

                <!-- Right Column: Carousel Track Box -->
                <div class="col-md-8 pb-5 google-reviews" style="margin-bottom: 1.5rem; display: flex; flex-direction: column; justify-content: center;">
                    <div class="row" style="margin: 0; position: relative;">

                        <div id="demo" class="carousel slide" data-ride="carousel" style="width: 100%; padding: 0 15px;">
                            <div class="carousel-inner">
                                
                                <!-- Review Item 1 -->
                                <div class="carousel-item active">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Pallavi Khemka</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">( March 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            Good collection and reasonable rates. Looking forward to getting more variety and awesome service as always.
                                        </div>
                                    </div>
                                </div> 

                                <!-- Review Item 2 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Prithipal Singh</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">( March 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> Gurgaon</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            It was a very warm experience while visiting your office. Everything was explained in detail and the quotation was provided immediately. Thanks for the courtesy extended during our visit. Overall good experience.<br>Thanks
                                        </div>
                                    </div>    
                                </div>

                                <!-- Review Item 3 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Anchal Srivastava</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">(March 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            It was excellent professional process of order and delivery of high quality Glass Jar at very reasonable price. which we ordered for using in pur processed food packing. And to Mention every query and request was handled by Mr Rahul Kashyap in a very professional approach. Thanks .. Would surely recommend to others and for sure going to continue for long term business.
                                        </div>
                                    </div>   
                                </div>

                                <!-- Review Item 4 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Charu Mehta</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">(March 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            Very Good product, prompt delivery, good response by salers we got all d feedback about products delivery status etc.by Rahul
                                        </div>
                                    </div>   
                                </div>

                                <!-- Review Item 5 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Asif Dar</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">(FEBRUARY 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            Best & authentic place to find any kind of glass bottles. Highly recommended.
                                        </div>
                                    </div>   
                                </div>

                                <!-- Review Item 6 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">veluri neelima</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">(FEBRUARY 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            The team is really very polite. Excellent response. Their service is very commendable. I would recommend for the wide varieties available and also giving the exact timely delivery.
                                        </div>
                                    </div>   
                                </div>

                                <!-- Review Item 7 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Javed Sabunwala</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">(FEBRUARY 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            It was good experience with Alok Glass Works, Bhawna, she really helped me related to there products and send me the samples which I had demanded for, Thanks
                                        </div>
                                    </div>   
                                </div>

                                <!-- Review Item 8 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Sinish Dominic</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">(FEBRUARY 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify;">
                                            Very good, awesome experience Appreciated to to the quick response
                                        </div>
                                    </div>   
                                </div>

                                <!-- Review Item 9 -->
                                <div class="carousel-item">
                                    <div class="border-review p-3 m-ml-12px" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 6px; padding: 2rem !important; min-height: 250px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                                        <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px;">
                                            <span class="font-weight-bold txt-black pb-2" style="font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 700; color: #111111;">Sahil Sharma</span>
                                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 3px;">
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" style="height: 14px; width: auto;" alt="Star" /></li>
                                                <li style="font-family: 'Montserrat', sans-serif; font-size: 12px; color: #888888; margin-left: 6px;">(JAN 2022)</li>
                                            </ul>
                                        </div>
                                        <p style="font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 10px; color: #666666;"><b style="font-weight: 600; color: #111111;">Address:</b> New Delhi</p>
                                        <div style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.6; color: #444444; text-align: justify; max-height: 150px; overflow-y: auto; padding-right: 5px;">
                                            My self Ved.Sahil Sharma (Ayurvedacharya) my feedback regards ur product your service is awesome and quality is 100 out of 100 ● I personally satisfied with price, special quality,air tight keep shinning keep growing Near 1 month ago our college National college of ayurveda ,barwala,hisar. we had already purchased 12,00 jars of around ₹22k around stay blessed ur product rocks # I always suggest all my known doctors or frnds to use this rating full out of full in every aspect... By heart really ur company hard works is valuable and a great value of Money......Thanku so much again....Jai bharat I heartly support made in bharat all hard working souls for our country for our earth....i had use First time this company a month ago and now always every time I will definitely use Alok Glass Works products in future from my experience and Strongly Recommend to all spcl to those who want premium quality and satisfaction anywhere they sell their product packed in Alok Glass Works jars/bottles who receives it will definitely satisfied.....
                                        </div>
                                    </div>   
                                </div>

                            </div>
                            
                            <!-- Custom Circular Carousel Controls -->
                            <a class="carousel-control-prev" href="#demo" data-slide="prev" style="width: 40px; height: 40px; background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 50%; top: 50%; transform: translateY(-50%); left: -10px; opacity: 1; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center;">
                                <span class="carousel-control-prev-icon" style="background-image: none; display: flex; align-items: center; justify-content: center; width: auto; height: auto;">
                                    <img src="assets/themes/storefront/public/images/google-review-left-icone8da.gif?v=2.0.3" style="height: 14px; width: auto;" alt="Prev" />
                                </span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next" style="width: 40px; height: 40px; background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 50%; top: 50%; transform: translateY(-50%); right: -10px; opacity: 1; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center;">
                                <span class="carousel-control-next-icon" style="background-image: none; display: flex; align-items: center; justify-content: center; width: auto; height: auto;">
                                    <img src="assets/themes/storefront/public/images/google-review-right-icone8da.gif?v=2.0.3" style="height: 14px; width: auto;" alt="Next" />
                                </span>
                            </a>

                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
        <!-- Google Reviews Section Ends -->
        <!-- Google Review Ends -->


            <style>
                /* ==========================================================================
                INFINITE ASSOCIATE MARQUEE SYSTEM
                ========================================================================== */
                .marquee-section {
                    background-color: #161616; /* Premium Charcoal Black Base */
                    padding: 40px 0;
                    overflow: hidden;
                    border-top: 1px solid #262626;
                    border-bottom: 1px solid #262626;
                    position: relative;
                }

                /* Subtle industrial framing gradient overlays to fade logos at edges */
                .marquee-section::before,
                .marquee-section::after {
                    content: "";
                    position: absolute;
                    top: 0;
                    width: 150px;
                    height: 100%;
                    z-index: 2;
                    pointer-events: none;
                }
                .marquee-section::before {
                    left: 0;
                    background: linear-gradient(to right, #161616 0%, rgba(22, 22, 22, 0) 100%);
                }
                .marquee-section::after {
                    right: 0;
                    background: linear-gradient(to left, #161616 0%, rgba(22, 22, 22, 0) 100%);
                }

                /* Flex container housing the track wrapper */
                .marquee-viewport {
                    display: flex;
                    width: 100%;
                }

                /* The moving track containing duplicated lists for a perfect infinite loop */
                .marquee-track {
                    display: flex;
                    gap: 60px; /* Uniform spatial distancing between logos */
                    padding-right: 60px;
                    animation: premiumMarqueeLoop 25s linear infinite;
                    will-change: transform;
                }

                /* Pause on hover mechanism for premium interactive control */
                .marquee-viewport:hover .marquee-track {
                    animation-play-state: paused;
                }

                /* Individual Logo Item Architecture */
                .marquee-logo-item {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 50px;
                    width: 140px;
                    flex-shrink: 0;
                }

                .marquee-logo-item img {
                    max-width: 100%;
                    max-height: 100%;
                    object-fit: contain;
                    filter: grayscale(0%) brightness(1) invert(0); /* Forces logos to clean White */
                    opacity: 1;
                    transition: opacity 0.3s ease, filter 0.3s ease;
                }

                /* Interactive logo activation highlights on individual focus */
                .marquee-logo-item img:hover {
                    opacity: 1;
                    filter: grayscale(0%) brightness(1) invert(0); /* Restores brand color or fully pops image */
                }

                /* ==========================================================================
                HARDWARE-ACCELERATED CSS TRACK TRANSLATION KEYFRAMES
                ========================================================================== */
                @keyframes premiumMarqueeLoop {
                    0% {
                        transform: translate3d(0, 0, 0);
                    }
                    100% {
                        transform: translate3d(-100%, 0, 0);
                    }
                }

                /* RESPONSIVE CONTROL MATRIX */
                @media (max-width: 767.98px) {
                    .marquee-section { padding: 30px 0; }
                    .marquee-track { gap: 40px; padding-right: 40px; animation-duration: 18s; } /* Slightly faster speed adjustment on small viewports */
                    .marquee-logo-item { width: 110px; height: 40px; }
                    .marquee-section::before, .marquee-section::after { width: 60px; }
                }
            </style>

        <!-- ASSOCIATES MARQUEE STRIP -->
            <h2 class="text-center text-uppercase org-brd-btm mb-5" style="font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 700; color: #111111; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 3.5rem;">
                <span style="position: relative; padding-bottom: 12px;">
                    Our Group Of Plants
                    <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 90px; height: 3px; background-color: #c8232c;"></span>
                </span>
            </h2>
            <div class="marquee-section">
                <div class="marquee-viewport">
                    
                    <!-- TRACK SET A: Primary sequence element loop -->
                    <div class="marquee-track">
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_01.png" alt="Associate Brand One" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_02.png" alt="Associate Brand Two" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_03.png" alt="Associate Brand Three" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_04.png" alt="Associate Brand Four" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_05.png" alt="Associate Brand Five" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_06.png" alt="Associate Brand Six" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_07.png" alt="Associate Brand Seven" loading="lazy"></div>
                    </div>

                    <!-- TRACK SET B: Exact clone sequence element to prevent visual popping/gaps at loop boundaries -->
                    <div class="marquee-track" aria-hidden="true">
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_01.png" alt="Associate Brand One" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_02.png" alt="Associate Brand Two" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_03.png" alt="Associate Brand Three" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_04.png" alt="Associate Brand Four" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_05.png" alt="Associate Brand Five" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_06.png" alt="Associate Brand Six" loading="lazy"></div>
                        <div class="marquee-logo-item"><img src="assets/images/plants/plant_07.png" alt="Associate Brand Seven" loading="lazy"></div>
                    </div>

                </div>
            </div>


        
        
            <!-- Brands Starts -->
        <!-- Brands Section -->
        <style>
            /* Section Scoped Styling Variables */
            :root {
                --br-bg: #f9f9f9;
                --br-card-bg: #ffffff;
                --br-accent: #c8232c;
                --br-text-dark: #111111;
                --br-text-muted: #666666;
                --br-border: rgba(0, 0, 0, 0.04);
                --br-ease: cubic-bezier(0.16, 1, 0.3, 1);
            }

            .brands-trusted-wrapper {
                background-color: var(--br-bg);
            }

            .brands-title-premium {
                font-family: 'Montserrat', sans-serif;
                font-size: 26px;
                font-weight: 700;
                color: var(--br-text-dark);
                letter-spacing: 0.05em;
                position: relative;
                padding-bottom: 16px;
                display: inline-flex;
                align-items: center;
                gap: 12px;
            }

            .brands-title-premium::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background-color: var(--br-accent);
            }

            .brands-title-icon {
                max-height: 32px;
                width: auto;
            }

            /* Grid Chassis Config */
            .brands-premium-flexgrid {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center;
                gap: 16px;
            }

            /* Premium Logo Slot Chassis */
            .brand-asset-chassis {
                background: var(--br-card-bg);
                border: 1px solid var(--br-border);
                border-radius: 6px;
                padding: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100px;
                transition: transform 0.4s var(--br-ease), box-shadow 0.4s var(--br-ease), border-color 0.4s var(--br-ease);
            }

            .brand-asset-chassis:hover {
                transform: translateY(-3px);
                border-color: rgba(200, 35, 44, 0.12);
                box-shadow: 0 10px 25px rgba(200, 35, 44, 0.05);
            }

            .brand-vector-img {
                max-height: 55px;
                width: auto;
                object-fit: contain;
                filter: grayscale(20%);
                transition: filter 0.4s var(--br-ease), transform 0.4s var(--br-ease);
            }

            .brand-asset-chassis:hover .brand-vector-img {
                filter: grayscale(0%);
                transform: scale(1.04);
            }

            .brands-footer-text {
                font-family: 'Montserrat', sans-serif;
                font-size: 14px;
                font-weight: 600;
                color: var(--br-text-muted);
                letter-spacing: 0.05em;
            }

            /* Custom Flex Items Breakdowns for a Clean 5-Column Desktop Flow */
            @media (min-width: 992px) {
                .brands-premium-flexgrid > div {
                    flex: 0 0 calc(20% - 13px) !important; /* Perfect 5 items row grid flow split */
                    max-width: calc(20% - 13px) !important;
                }
            }

            /* Balanced Responsive Grid Downscaling Breakpoints */
            @media (max-width: 991.98px) {
                .brands-title-premium {
                    font-size: 22px;
                    padding-bottom: 12px;
                }
                .brands-title-premium::after {
                    width: 50px;
                }
                .brands-title-icon {
                    max-height: 28px;
                }
                .brands-premium-flexgrid > div {
                    flex: 0 0 calc(33.333% - 11px) !important; /* Balanced 3 item grid layout split */
                    max-width: calc(33.333% - 11px) !important;
                }
                .brand-asset-chassis {
                    padding: 16px;
                    height: 85px;
                }
                .brand-vector-img {
                    max-height: 44px;
                }
            }

            @media (max-width: 575.98px) {
                .brands-premium-flexgrid {
                    gap: 10px;
                }
                .brands-premium-flexgrid > div {
                    flex: 0 0 calc(50% - 5px) !important; /* Balanced 2 item square grid mobile split */
                    max-width: calc(50% - 5px) !important;
                }
                .brand-asset-chassis {
                    padding: 12px;
                    height: 75px;
                }
                .brand-vector-img {
                    max-height: 38px;
                }
                .brands-footer-text {
                    font-size: 12px;
                    text-align: center !important;
                }
            }
        </style>

        <div class="container-fluid brands-trusted-wrapper py-5 mask-reveal reveal-on-scroll">
            <div class="container py-4">
                
                <!-- Premium Section Header -->
                <div class="text-center mb-5">
                    <h2 class="brands-title-premium text-uppercase">
                        <img src="assets/themes/storefront/public/images/brands-icone8da.png?v=2.0.3" class="brands-title-icon" alt="Trust Icon" />
                        <span>BRANDS WHO TRUST US</span>
                    </h2>
                </div>

                <!-- Premium Clean Layout Unified Brand Asset Grid Flow -->
                <div class="row brands-premium-flexgrid mb-4">
                    
                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-1e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 1" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-2e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 2" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-3e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 3" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-4e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 4" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-5e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 5" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-6e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 6" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-7e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 7" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-8e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 8" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-9e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 9" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-10e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 10" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-11e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 11" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-12e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 12" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-13e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 13" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-14e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 14" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-15e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 15" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-16e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 16" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-17e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 17" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-18e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 18" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/brands-icon-19e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 19" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/Keventers-13e8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Keventers Logo" />
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="brand-asset-chassis">
                            <img src="assets/themes/storefront/public/images/TRUEOILe8da.png?v=2.0.3" class="brand-vector-img img-fluid" alt="True Oil Logo" />
                        </div>
                    </div>

                </div>

                <!-- Section Accent Footer -->
                <div class="pt-2">
                    <h3 class="text-md-right text-center text-uppercase brands-footer-text pr-md-2">And many more</h3>
                </div>

            </div>
        </div>


        <!-- DEPENDENCIES FOR ICONS AND FONTS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            /* ==========================================================================
            CATALOG SYSTEM BASE ARCHITECTURE
            ========================================================================== */
            .catalog-section {
                background-color: #ffffff;
                padding: 80px 0;
                font-family: 'Montserrat', sans-serif;
            }

            /* Section Typography Header Block */
            .catalog-header {
                max-width: 700px;
                margin-bottom: 50px;
            }

            .catalog-pretitle {
                display: inline-block;
                font-size: 11px;
                font-weight: 700;
                color: #c8232c; /* Alok Red */
                text-transform: uppercase;
                letter-spacing: 0.15em;
                margin-bottom: 12px;
            }

            .catalog-title {
                font-size: 32px;
                font-weight: 800;
                color: #111111; /* Charcoal Black base */
                text-transform: uppercase;
                letter-spacing: 0.03em;
                line-height: 1.2;
            }

            /* ==========================================================================
            ASYMMETRIC GRID WORKSPACE
            ========================================================================== */
            .catalog-master-grid {
                display: flex;
                gap: 30px;
                align-items: stretch;
            }

            /* PRIMARY FEATURED BLOCK CONTAINER */
            .catalog-featured-pillar {
                flex: 0 0 45%;
                display: flex;
            }

            .catalog-featured-card {
                background: #161616; /* Charcoal Panel Frame */
                border: 1px solid #262626;
                border-radius: 8px;
                padding: 40px;
                width: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: relative;
                overflow: hidden;
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                            box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }

            /* Subtle decorative industrial structural element inside card background */
            .catalog-featured-card::before {
                content: '\f1c1';
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
                position: absolute;
                right: -20px;
                bottom: -30px;
                font-size: 200px;
                color: rgba(255, 255, 255, 0.02);
                pointer-events: none;
                transition: color 0.4s ease;
            }

            .catalog-featured-card:hover::before {
                color: rgba(200, 35, 44, 0.04); /* Glows faint red on focus */
            }

            /* SECONDARY PRODUCT RANGE GRID */
            .catalog-matrix-pillar {
                flex: 1;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .catalog-item-card {
                background: #ffffff;
                border: 1px solid #eef0f2;
                border-radius: 8px;
                padding: 24px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                            box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }

            /* ==========================================================================
            TYPOGRAPHY AND INTERACTIVE BUTTON ELEMENT ACTIONS
            ========================================================================== */
            .catalog-badge {
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                padding: 4px 10px;
                border-radius: 2px;
                display: inline-block;
                margin-bottom: 20px;
            }
            
            .featured-badge { background: #c8232c; color: #ffffff; }
            .standard-badge { background: #f4f5f7; color: #666666; }

            .catalog-name {
                font-weight: 700;
                line-height: 1.4;
                margin-bottom: 8px;
                color: #ffffff !important;
            }
            .featured-name { font-size: 24px; color: #ffffff; }
            .standard-name { font-size: 16px; color: #111111; }

            .catalog-meta {
                font-size: 12px;
                font-weight: 500;
                margin-bottom: 30px;
            }
            .featured-meta { color: #888888; }
            .standard-meta { color: #999999; }

            /* Clean Action Icons Buttons Layout */
            .catalog-download-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                text-decoration: none !important;
                padding: 14px 24px;
                border-radius: 4px;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .btn-premium-red {
                background: #c8232c;
                color: #ffffff;
                border: 1px solid #c8232c;
            }
            .btn-premium-red:hover {
                background: #ffffff;
                color: #c8232c;
            }

            .btn-outline-charcoal {
                background: transparent;
                color: #111111;
                border: 1px solid #111111;
                margin-top: auto;
            }
            .btn-outline-charcoal:hover {
                background: #c8232c;
                color: #ffffff;
                border-color: #c8232c;
            }

            /* CARD HOVER TRIGGER EFFECTS */
            .catalog-featured-card:hover {
                transform: translateY(-5px);
                border-color: #c8232c;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .catalog-item-card:hover {
                transform: translateY(-5px);
                border-color: #c8232c;
                box-shadow: 0 15px 35px rgba(17, 17, 17, 0.05);
            }

            /* ==========================================================================
            RESPONSIVE MATRIX BREAKPOINTS
            ========================================================================== */
            @media (max-width: 991.98px) {
                .catalog-master-grid {
                    flex-direction: column;
                }
                .catalog-featured-pillar {
                    width: 100%;
                    flex: 0 0 auto;
                }
            }

            @media (max-width: 767.98px) {
                .catalog-section { padding: 50px 0; }
                .catalog-title { font-size: 26px; }
                .catalog-matrix-pillar {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }
                .catalog-featured-card { padding: 30px; }
                .featured-name { font-size: 20px; }
            }
        </style>

        <!-- CATALOG DOWNLOAD SECTION -->
        <div class="catalog-section">
            <div class="container">
                
                <!-- Premium Section Header Box -->
                <div class="catalog-header">
                    <span class="catalog-pretitle">Resources</span>
                    <h2 class="catalog-title">Product Catalogs & Technical Media</h2>
                </div>

                <!-- Master Asymmetric Grid Layout -->
                <div class="catalog-master-grid">
                    
                    <!-- MASTER/MAIN CATALOG FLANK -->
                    <div class="catalog-featured-pillar">
                        <div class="catalog-featured-card">
                            <div>
                                <span class="catalog-badge featured-badge">Complete Collection</span>
                                <h3 class="catalog-name featured-name">2026 Master Product Catalog</h3>
                                <p class="catalog-meta featured-meta"><i class="fa-regular fa-file-pdf"></i> PDF Format &bull; 45 MB &bull; English</p>
                            </div>
                            <div>
                                <a href="assets/docs/catalogs/master_catalog_2026.pdf" download class="catalog-download-btn btn-premium-red w-100">
                                    <i class="fa-solid fa-arrow-down-to-line"></i> Download Master Catalog
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- SPECIALIZED SUB-CATALOGS GRID FLANK -->
                    <div class="catalog-matrix-pillar">
                        
                        <!-- Item Card 1 -->
                        <div class="catalog-item-card">
                            <div>
                                <span class="catalog-badge standard-badge">Range 01</span>
                                <h4 class="catalog-name standard-name">Square & Round Glass Jars</h4>
                                <p class="catalog-meta standard-meta"><i class="fa-regular fa-file-pdf"></i> PDF &bull; 12 MB</p>
                            </div>
                            <a href="assets/docs/catalogs/glass_jars_brochure.pdf" download class="catalog-download-btn btn-outline-charcoal">
                                <i class="fa-solid fa-download"></i> Download PDF
                            </a>
                        </div>

                        <!-- Item Card 2 -->
                        <div class="catalog-item-card">
                            <div>
                                <span class="catalog-badge standard-badge">Range 02</span>
                                <h4 class="catalog-name standard-name">Premium Beverage Bottles</h4>
                                <p class="catalog-meta standard-meta"><i class="fa-regular fa-file-pdf"></i> PDF &bull; 8.4 MB</p>
                            </div>
                            <a href="assets/docs/catalogs/beverage_bottles_brochure.pdf" download class="catalog-download-btn btn-outline-charcoal">
                                <i class="fa-solid fa-download"></i> Download PDF
                            </a>
                        </div>

                        <!-- Item Card 3 -->
                        <div class="catalog-item-card">
                            <div>
                                <span class="catalog-badge standard-badge">Technical</span>
                                <h4 class="catalog-name standard-name">Specifications & Tolerances</h4>
                                <p class="catalog-meta standard-meta"><i class="fa-regular fa-file-pdf"></i> PDF &bull; 4.2 MB</p>
                            </div>
                            <a href="assets/docs/catalogs/technical_specifications.pdf" download class="catalog-download-btn btn-outline-charcoal">
                                <i class="fa-solid fa-download"></i> Download PDF
                            </a>
                        </div>

                        <!-- Item Card 4 -->
                        <div class="catalog-item-card">
                            <div>
                                <span class="catalog-badge standard-badge">Logistics</span>
                                <h4 class="catalog-name standard-name">Packaging & Shipping Guide</h4>
                                <p class="catalog-meta standard-meta"><i class="fa-regular fa-file-pdf"></i> PDF &bull; 3.1 MB</p>
                            </div>
                            <a href="assets/docs/catalogs/shipping_packaging_guide.pdf" download class="catalog-download-btn btn-outline-charcoal">
                                <i class="fa-solid fa-download"></i> Download PDF
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        

        <style>
            /* Premium Orange Accent Modifications over base style */
            .btn-org { background: #c8232c; color: #fff; font-size: 14px; padding: 6px 30px; border-radius: 5px; transition: background 0.2s ease; }
            .btn-org:hover, .btn-org:focus { color: #fff; background: #111111; }
            .btn-org-1 { background: #c8232c; color: #fff; font-size: 14px; padding: 6px 20px; border-radius: 5px; transition: background 0.2s ease; }
            .btn-org-1:hover { color: #fff; background: #111111; }
            .btn-white-outline { background: #fff; color: #404040; border: 1px solid #cccccc; font-size: 14px; padding: 2px 16px; }
            .btm-colors { width: 100%; min-height: 25px; }
            .float-red-btn { position: absolute; width: 50%; margin: 0 auto; background: #c8232c; text-align: center; font-size: 14px; color: #fff; left: 26%; bottom: 18%; display: none; }
            
            div.show-buy-now-btn { position: relative; }
            div.show-buy-now-btn:hover button { display: block; }
        </style>
</main>

<?php include 'includes/footer.php'; ?>