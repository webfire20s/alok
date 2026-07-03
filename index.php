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
    LIMIT 4
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
    </style>

    <!-- YOUTUBE HERO SECTION -->
    <div class="hero-yt-section">

        <!-- Configured YouTube Video Background Source -->
        <div class="hero-yt-wrapper">
            <iframe 
                src="https://www.youtube.com/embed/2NvHXuq7Dq4?autoplay=1&mute=1&loop=1&playlist=2NvHXuq7Dq4&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
            </iframe>
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
                    <span class="value-title">Wholesale Rates</span>
                </div>

                <!-- Metric Card 3 -->
                <div class="col-6 col-md-3 value-item">
                    <span class="value-metric">Fast Dispatch</span>
                    <span class="value-title">Guaranteed</span>
                </div>

                <!-- Metric Card 4 -->
                <div class="col-6 col-md-3 value-item">
                    <span class="value-metric">Secure Support</span>
                    <span class="value-title">Hassle-Free</span>
                </div>

            </div>
        </div>
    </div>

    <!-- <div class="container-fluid mobile-trust-cards-container only-mobile pt-4 pb-4">
        <div class="container-fluid no-gutters pl-2 pr-2">
            <div class="row no-gutters" style="display: flex; flex-wrap: wrap; margin: 0; row-gap: 12px; column-gap: 0;">
                
                <!-- MOBILE BADGE 1 -->
                <!-- <div class="col-6 mobile-badge-col" style="padding: 0 60px;">
                    <div class="mobile-trust-card">
                        <img src="assets/themes/storefront/public/images/safe-shopping-icone8da.png?v=2.0.3" class="mobile-badge-icon" alt="Safe Shopping" />
                        <span class="mobile-badge-text">
                            Trusted for <br/>
                            <label>4 Decades</label>
                        </span>
                    </div>
                </div> -->

                <!-- MOBILE BADGE 2 -->
                <!-- <div class="col-6 mobile-badge-col" style="padding: 0 6px;">
                    <div class="mobile-trust-card">
                        <img src="assets/themes/storefront/public/images/lowest-price-icone8da.png?v=2.0.3" class="mobile-badge-icon" alt="Lowest Price" />
                        <span class="mobile-badge-text">
                            Highest Quality <br/>
                            <label>Lowest Price</label>
                        </span>
                    </div>
                </div> -->

                <!-- MOBILE BADGE 3 -->
                <!-- <div class="col-6 mobile-badge-col" style="padding: 0 6px;">
                    <div class="mobile-trust-card">
                        <img src="assets/themes/storefront/public/images/guarantee-dispatch-icone8da.png?v=2.0.3" class="mobile-badge-icon" alt="Guaranteed Dispatch" />
                        <span class="mobile-badge-text">
                            Fast Despatch <br/>
                            <label>Guaranteed</label>
                        </span>
                    </div>
                </div> -->

                <!-- MOBILE BADGE 4 -->
                <!-- <div class="col-6 mobile-badge-col" style="padding: 0 6px;">
                    <div class="mobile-trust-card">
                        <img src="assets/themes/storefront/public/images/30-days-icone8da.png?v=2.0.3" class="mobile-badge-icon" alt="Money Back" />
                        <span class="mobile-badge-text">
                            Hassle Free Return <br/>
                            <label style="font-size: 10px;">Money Back</label>
                        </span>
                    </div>
                </div> -->

                <!-- MOBILE BADGE 5 -->
                <!-- <div class="col-6 mobile-badge-col" style="padding: 0 6px;">
                    <div class="mobile-trust-card">
                        <img src="assets/themes/storefront/public/images/safe-shopping-icone8da.png?v=2.0.3" class="mobile-badge-icon" alt="Secure Shopping" />
                        <span class="mobile-badge-text">
                            Safe <br/>
                            <label>and Secure</label>
                        </span>
                    </div>
                </div> -->

                <!-- MOBILE BADGE 6 -->
                <!-- <div class="col-6 mobile-badge-col" style="padding: 0 6px;">
                    <div class="mobile-trust-card">
                        <img src="assets/themes/storefront/public/images/verifiede8da.png?v=2.0.3" class="mobile-badge-icon" alt="One Stop Solution" />
                        <span class="mobile-badge-text">
                            One Stop <br/>
                            <label>Solution</label>
                        </span>
                    </div>
                </div> -->

            <!-- </div>
        </div>
    </div> -->

        <!-- Shop by Industry Starts -->
        <!-- Shop by Industry Starts -->
        <!-- HIGHER-END COMPONENT STYLING ENGINE -->
        <style>
            /* Component Reset & Scoping */
            .industry-section-wrapper {
                font-family: 'Montserrat', sans-serif;
                background-color: #ffffff;
            }

            /* Minimalist High-End Section Title */
            .industry-main-title {
                font-size: 32px;
                font-weight: 800;
                color: #111111;
                letter-spacing: 0.04em;
                position: relative;
                display: inline-block;
                padding-bottom: 16px;
            }
            .industry-main-title::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 50px;
                height: 3px;
                background-color: #c8232c;
            }

            /* B2B Industry Mega Container Card */
            .industry-mega-card {
                background-color: #ffffff;
                border: 1px solid #eef0f2;
                border-top: 4px solid #111111;
                border-radius: 6px;
                height: 100%;
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            border-top-color 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            }
            .industry-mega-card:hover {
                transform: translateY(-6px);
                border-color: #e2e4e8;
                border-top-color: #c8232c;
                box-shadow: 0 20px 38px rgba(17, 17, 17, 0.07);
            }

            /* Elegant Structural Heading Links */
            .industry-card-heading {
                font-size: 20px;
                font-weight: 700;
                color: #111111;
                letter-spacing: 0.01em;
            }

            /* Product Mini Grid Wrappers */
            .industry-product-media-link {
                display: block;
                overflow: hidden;
                border-radius: 6px;
                background-color: #ffffff;
                border: 1px solid #f0f0f0;
                padding: 12px;
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
            }
            .industry-product-media-link img {
                width: 100%;
                height: auto;
                aspect-ratio: 1 / 1;
                object-fit: contain;
                transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            
            /* Interactive States tied logically to hovering any part of the micro item */
            .industry-product-cell:hover .industry-product-media-link {
                border-color: #e2e4e8;
                box-shadow: 0 8px 18px rgba(0, 0, 0, 0.04);
            }
            .industry-product-cell:hover .industry-product-media-link img {
                transform: scale(1.06);
            }
            .industry-product-cell:hover .industry-product-title {
                color: #c8232c;
            }

            /* Typography Clamping Engine */
            .industry-product-title {
                font-size: 13px;
                font-weight: 600;
                color: #222222;
                text-decoration: none;
                line-height: 1.4;
                margin-top: 10px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                height: 36px;
                transition: color 0.2s ease;
            }
            .industry-product-title:hover {
                text-decoration: none;
            }
        </style>

        <!-- INDUSTRY DISPLAY LAYOUT MODALITY -->
        <div class="container industry-section-wrapper py-5 reveal-on-scroll">

            <!-- Section Title Area -->
            <div class="text-center mb-5 pb-2">
                <h2 class="text-uppercase industry-main-title">
                    Shop by Industry
                </h2>
            </div>

            <!-- Active Structural Row Grid -->
            <div class="row">

                <?php foreach($categories as $category): ?>

                    <div class="col-lg-6 mb-4 pb-2">

                        <!-- Industry Category Card Container -->
                        <div class="industry-mega-card p-4 p-md-5">

                            <!-- Category Heading -->
                            <h3 class="industry-card-heading mb-4">
                                <?= htmlspecialchars($category['name']) ?>
                            </h3>

                            <!-- Fluid Inner Grid Layout -->
                            <div class="row g-3">

                                <?php
                                $stmt = $pdo->prepare("
                                    SELECT * FROM products
                                    WHERE category_id = ?
                                    LIMIT 4
                                ");
                                $stmt->execute([$category['id']]);
                                $categoryProducts = $stmt->fetchAll();
                                ?>

                                <?php foreach($categoryProducts as $product): ?>

                                    <!-- Product Grid Cell Element -->
                                    <div class="col-6 col-sm-3 col-md-6 col-lg-3 text-center industry-product-cell d-flex flex-column align-items-center">

                                        <!-- Interactive Image Link wrapper -->
                                        <a href="product.php?slug=<?= $product['slug'] ?>" class="industry-product-media-link w-100">
                                            <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                        </a>

                                        <!-- Product Anchor Title -->
                                        <a href="product.php?slug=<?= $product['slug'] ?>" class="industry-product-title">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </a>

                                    </div>

                                <?php endforeach; ?>

                                <!-- Empty Result Space Control Fallback if needed -->
                                <?php if (empty($categoryProducts)): ?>
                                    <div class="col-12 text-muted py-3" style="font-size: 13px;">No direct product configurations allocated inside this grouping.</div>
                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
        <!-- Shop by Industry Ends -->
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
            LIMIT 8
        ");

        $productStmt->execute([$category['id']]);

        $products = $productStmt->fetchAll();

        if(count($products) === 0){
            continue;
        }
        ?>

        <!-- B2B HIGH-END PRODUCT GRID SYSTEM STYLES -->
        <style>
            /* Section Scoping Base Layout */
            .showcase-grid-wrapper {
                font-family: 'Montserrat', sans-serif;
                background-color: #ffffff;
            }

            /* Minimalist High-End Section Title */
            .showcase-main-title {
                font-size: 32px;
                font-weight: 800;
                color: #111111;
                letter-spacing: 0.04em;
                position: relative;
                display: inline-block;
                padding-bottom: 16px;
            }
            .showcase-main-title::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 50px;
                height: 3px;
                background-color: #c8232c;
            }

            /* Product Item Core Card Frame */
            .showcase-product-card {
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            /* Media Frame Isolation Matrix */
            .showcase-media-box {
                position: relative;
                overflow: hidden;
                border: 1px solid #eef0f2;
                border-radius: 6px;
                background-color: #ffffff;
                margin-bottom: 16px;
                transition: border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .showcase-media-box img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                padding: 16px;
                margin: 0;
                transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }

            /* Premium Dynamic Sliding Floating Button Custom Setup */
            .showcase-action-btn {
                position: absolute;
                bottom: 16px;
                left: 50%;
                transform: translateX(-50%) translateY(15px);
                width: 85%;
                background-color: #c8232c;
                color: #ffffff;
                font-weight: 700;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                border: none;
                padding: 11px 0;
                border-radius: 4px;
                box-shadow: 0 6px 20px rgba(200, 35, 44, 0.3);
                opacity: 0;
                pointer-events: none; /* Prevents splitting anchor target focus errors */
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                            opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                            background-color 0.2s ease;
            }

            /* Content Data Panel Layout */
            .showcase-details-box {
                text-align: left;
                padding: 0 4px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }
            .showcase-product-title {
                font-size: 14px;
                font-weight: 600;
                color: #111111;
                text-decoration: none;
                line-height: 1.4;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                height: 38px;
                margin-bottom: 8px;
                transition: color 0.2s ease;
            }
            .showcase-product-title:hover {
                text-decoration: none;
                color: #c8232c;
            }
            .showcase-product-price {
                font-size: 16px;
                font-weight: 800;
                color: #c8232c;
                margin-top: auto;
            }

            /* Synchronized Micro Interactivity Animations */
            .showcase-product-card:hover .showcase-media-box {
                border-color: #e2e4e8;
                box-shadow: 0 12px 24px rgba(17, 17, 17, 0.06);
            }
            .showcase-product-card:hover .showcase-media-box img {
                transform: scale(1.05);
            }
            .showcase-product-card:hover .showcase-action-btn {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
            .showcase-product-card:hover .showcase-product-title {
                color: #c8232c;
            }

            /* Fluid Fallback Fixes for Mobile Touch Screens */
            @media (max-width: 767.98px) {
                /* Persistent elegant exposure instead of hiding actions on mobile */
                .showcase-action-btn {
                    position: relative;
                    bottom: 0;
                    left: 0;
                    transform: none !important;
                    width: 100%;
                    opacity: 1 !important;
                    margin-top: 8px;
                    box-shadow: none;
                    padding: 8px 0;
                }
                .showcase-media-box {
                    margin-bottom: 10px;
                }
            }
        </style>

        <!-- PRODUCT SHOWCASE SECTION -->
        <div class="container showcase-grid-wrapper py-5 reveal-on-scroll">

            <!-- Section Heading Area -->
            <div class="text-center mb-5 pb-2">
                <h2 class="text-uppercase showcase-main-title">
                    <?= htmlspecialchars($category['section_title']) ?>
                </h2>
            </div>

            <!-- Active Grid Architecture Component Container -->
            <div class="row g-3 g-md-4">

                <?php foreach($products as $product): ?>

                    <!-- Responsive Frame Partitioning Model Structure -->
                    <div class="col-6 col-md-4 col-lg-3 mb-4">

                        <div class="showcase-product-card">

                            <!-- Image & Action Container Frame -->
                            <div class="showcase-media-box">

                                <a href="product.php?slug=<?= urlencode($product['slug']) ?>" class="d-block w-100 position-relative aspect-ratio-box" style="aspect-ratio: 1 / 1;">

                                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">

                                    <button type="button" class="btn showcase-action-btn">
                                        Buy Now
                                    </button>

                                </a>

                            </div>

                            <!-- Meta Content Labels Details Block -->
                            <div class="showcase-details-box">

                                <a href="product.php?slug=<?= urlencode($product['slug']) ?>" class="showcase-product-title">
                                    <?= htmlspecialchars($product['name']) ?>
                                </a>

                                <span class="showcase-product-price">
                                    ₹<?= number_format($product['price'], 2) ?>
                                </span>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

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
                        <div class="col-md-3 col-6" style="margin-bottom: 2rem; display: flex; flex-direction: column;">

                            <div class="latest-image-box" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 4px; overflow: hidden; height: 100%; display: flex; flex-direction: column; box-shadow: 0 3px 10px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 20px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 10px rgba(0,0,0,0.03)';">

                                <a href="public/blog/vacuum-packaging-machine/index.html" style="display: block; width: 100%; aspect-ratio: 16/10; overflow: hidden; background-color: #f7f7f7;">
                                    <img src="blog/wp-content/uploads/2026/03/blog-Heading-12.png" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';" alt="" />
                                </a>

                                <div style="padding: 14px; flex-grow: 1; display: flex; flex-direction: column;">
                                    <a href="public/blog/vacuum-packaging-machine/index.html" class="blog-title-link" style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 600; color: #111111; text-decoration: none; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s ease;">
                                        2026 Complete Vacuum Packaging Machine Guide for Better Freshness & Reduced Product Waste
                                    </a>
                                </div>

                            </div>

                        </div>

                        <!-- Blog Item 2 -->
                        <div class="col-md-3 col-6" style="margin-bottom: 2rem; display: flex; flex-direction: column;">

                            <div class="latest-image-box" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 4px; overflow: hidden; height: 100%; display: flex; flex-direction: column; box-shadow: 0 3px 10px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 20px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 10px rgba(0,0,0,0.03)';">

                                <a href="public/blog/amber-glass-bottles/index.html" style="display: block; width: 100%; aspect-ratio: 16/10; overflow: hidden; background-color: #f7f7f7;">
                                    <img src="blog/wp-content/uploads/2026/02/blog-Heading-10.png" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';" alt="" />
                                </a>

                                <div style="padding: 14px; flex-grow: 1; display: flex; flex-direction: column;">
                                    <a href="public/blog/amber-glass-bottles/index.html" class="blog-title-link" style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 600; color: #111111; text-decoration: none; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s ease;">
                                        High Impact Amber Glass Bottles For 2026: Uses, Benefits, Sizes, and How to Choose the Right One
                                    </a>
                                </div>

                            </div>

                        </div>

                        <!-- Blog Item 3 -->
                        <div class="col-md-3 col-6" style="margin-bottom: 2rem; display: flex; flex-direction: column;">

                            <div class="latest-image-box" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 4px; overflow: hidden; height: 100%; display: flex; flex-direction: column; box-shadow: 0 3px 10px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 20px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 10px rgba(0,0,0,0.03)';">

                                <a href="public/blog/dropper-bottles/index.html" style="display: block; width: 100%; aspect-ratio: 16/10; overflow: hidden; background-color: #f7f7f7;">
                                    <img src="blog/wp-content/uploads/2026/02/blog-Heading-9.png" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';" alt="" />
                                </a>

                                <div style="padding: 14px; flex-grow: 1; display: flex; flex-direction: column;">
                                    <a href="public/blog/dropper-bottles/index.html" class="blog-title-link" style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 600; color: #111111; text-decoration: none; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s ease;">
                                        5 Powerful Dropper Bottles Insights for Serums & Oils: Perfect Fit, Leak-Free Design & Costly Mistakes to Avoid
                                    </a>
                                </div>

                            </div>

                        </div>

                        <!-- Blog Item 4 -->
                        <div class="col-md-3 col-6" style="margin-bottom: 2rem; display: flex; flex-direction: column;">

                            <div class="latest-image-box" style="background-color: #ffffff; border: 1px solid #eef0f2; border-radius: 4px; overflow: hidden; height: 100%; display: flex; flex-direction: column; box-shadow: 0 3px 10px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 20px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 10px rgba(0,0,0,0.03)';">

                                <a href="public/blog/liquid-filling-machine/index.html" style="display: block; width: 100%; aspect-ratio: 16/10; overflow: hidden; background-color: #f7f7f7;">
                                    <img src="blog/wp-content/uploads/2026/02/blog-Heading-7.png" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';" alt="" />
                                </a>

                                <div style="padding: 14px; flex-grow: 1; display: flex; flex-direction: column;">
                                    <a href="public/blog/liquid-filling-machine/index.html" class="blog-title-link" style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 600; color: #111111; text-decoration: none; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s ease;">
                                        7 Key Tips To Select The Perfect Liquid Filling Machine For Your Business
                                    </a>
                                </div>

                            </div>

                        </div>

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