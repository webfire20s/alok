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


<!-- DEPENDENCIES FOR ICONS AND FONTS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- DEPENDENCIES FOR ICONS ONLY -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style.css">   
<main role="main">
    

    <!-- INTEGRATED YOUTUBE HERO SYSTEM -->
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
        

    <!-- Shop by Product Ends -->
    <!-- Shop by Product Ends -->


    <!-- Popular bottle Starts -->
        <?php
        require 'includes/db.php';

        $stmt = $pdo->prepare("
            SELECT *
            FROM categories
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
            LIMIT 14
            
        ");

        $productStmt->execute([$category['id']]);

        $products = $productStmt->fetchAll();

        if(count($products) === 0){
            continue;
        }
        ?>

        <!-- B2B HIGH-END PRODUCT GRID SYSTEM STYLES -->
        

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
            
        <!-- Latest Blogs Ends -->
        <!-- Latest Blogs Ends -->
        
        
        <!-- OUR  CERTIFICATES STARTS -->
        <section class="py-5 certificates-section reveal-on-scroll">
            <div class="container py-4">
                
                <!-- Section Title Area -->
                <div class="text-center mb-5 pb-2">
                    <h2 class="text-uppercase cert-main-title">
                        Our Certifications
                    </h2>
                </div>

                <!-- 3-Column Certificate Display Layout Model Grid -->
                <div class="row g-4 justify-content-center">
                    
                    <!-- Certificate 01 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="certificate-premium-card">
                            <div class="certificate-media-wrapper">
                                <!-- Update image path below -->
                                <img src="assets/themes/storefront/public/images/reg1.jpg" alt="ISO Certification Quality Management" />
                            </div>
                            <h3 class="certificate-title-label">ISO 9001:2015 Certification</h3>
                            <p class="certificate-sub-label">Quality Management Standard</p>
                        </div>
                    </div>

                    <!-- Certificate 02 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="certificate-premium-card">
                            <div class="certificate-media-wrapper">
                                <!-- Update image path below -->
                                <img src="assets/themes/storefront/public/images/reg2.jpg" alt="Safety Standard Certification" />
                            </div>
                            <h3 class="certificate-title-label">Operational Safety Compliance</h3>
                            <p class="certificate-sub-label">Industrial Standards Certified</p>
                        </div>
                    </div>

                    <!-- Certificate 03 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="certificate-premium-card">
                            <div class="certificate-media-wrapper">
                                <!-- Update image path below -->
                                <img src="assets/themes/storefront/public/images/reg3.jpg" alt="Manufacturing Excellence Award" />
                            </div>
                            <h3 class="certificate-title-label">Premium Manufacturing Excellence</h3>
                            <p class="certificate-sub-label">Verified Glass Decorator</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- OUR CERTIFICATES ENDS -->

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
                                <a href="assets/catalogs/master-catalog-2026.pdf" download class="catalog-download-btn btn-premium-red w-100">
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
                                <h4 class="catalog-name standard-name">Gift Pack Range</h4>
                                <p class="catalog-meta standard-meta"><i class="fa-regular fa-file-pdf"></i> PDF &bull; 12 MB</p>
                            </div>
                            <a href="assets/catalogs/gift-pack.pdf" download class="catalog-download-btn btn-outline-charcoal">
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
                            <a href="assets/catalogs/beverage_bottles_brochure.pdf" download class="catalog-download-btn btn-outline-charcoal">
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
                            <a href="assets/catalogs/technical_specifications.pdf" download class="catalog-download-btn btn-outline-charcoal">
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
                            <a href="assets/catalogs/shipping_packaging_guide.pdf" download class="catalog-download-btn btn-outline-charcoal">
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