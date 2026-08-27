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
    ORDER BY display_order ASC, id ASC
")->fetchAll();
?>


<!-- DEPENDENCIES FOR ICONS AND FONTS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- DEPENDENCIES FOR ICONS ONLY -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        Over 50 years of precision engineering excellence. Discover
                        wholesale-ready glass packaging and advanced custom decoration
                        solutions built for international brands.
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
                    <span class="value-title" style="color: #c8232c;">5 Decades</span>
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
            <div class="row">

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
                        <div class="col-6 col-md-6 col-lg-4 mb-4">
                    -->
                    <div class="col-16 col-sm-3 col-lg-6 mb-2">

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
            SELECT * FROM categories 
            WHERE section_title IS NOT NULL 
            ORDER BY FIELD(id, 6, 10, 25) ASC, id ASC
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
                ORDER BY display_order ASC, id ASC
                
            ");

            $productStmt->execute([$category['id']]);
            $products = $productStmt->fetchAll();

            if(count($products) === 0){
                continue;
            }
            ?>

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
                            <button class="scroller-prev-btn" aria-label="Scroll Left"><i class="fa-solid fa-chevron-left"></i></button>
                            <button class="scroller-next-btn" aria-label="Scroll Right"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <!-- Scrollable Window Area -->
                    <div class="ticker-viewport">
                        <div class="ticker-track">
                            
                            <?php foreach($products as $product): ?>
                                <a href="product.php?slug=<?= urlencode($product['slug']) ?>" class="ticker-product-card">
                                    <div class="ticker-media-box">
                                        <img src="<?= htmlspecialchars($product['image']) ?>" 
                                            alt="<?= htmlspecialchars($product['name']) ?>" 
                                            loading="lazy" 
                                            decoding="async"
                                            width="240" 
                                            height="240">
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

        <?php endforeach; ?>

        <!-- HIGH-PERFORMANCE MULTI-SECTION ANIMATION CONTROLLER -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Select all rendered category ticker wrappers on the page
                const showcaseWrappers = document.querySelectorAll('.ticker-showcase-wrapper');

                showcaseWrappers.forEach(wrapper => {
                    const viewport = wrapper.querySelector('.ticker-viewport');
                    const nextBtn = wrapper.querySelector('.scroller-next-btn');
                    const prevBtn = wrapper.querySelector('.scroller-prev-btn');
                    
                    if (!viewport) return;

                    const scrollAmount = 264; // Distance to scroll on button click
                    const autoScrollSpeed = 0.8; // Speed multiplier for smooth rAF loop
                    
                    let isPlaying = true;
                    let scrollDirection = 1; // 1 = Right, -1 = Left
                    let animationFrameId = null;

                    // Hardware-accelerated smooth auto-scrolling
                    function step() {
                        if (isPlaying) {
                            viewport.scrollLeft += autoScrollSpeed * scrollDirection;
                            
                            const maxScrollLeft = viewport.scrollWidth - viewport.clientWidth;
                            
                            // Reverse direction smoothly at borders
                            if (viewport.scrollLeft >= maxScrollLeft - 1) {
                                scrollDirection = -1;
                            } else if (viewport.scrollLeft <= 1) {
                                scrollDirection = 1;
                            }
                        }
                        animationFrameId = requestAnimationFrame(step);
                    }

                    function startScroll() {
                        isPlaying = true;
                    }

                    function stopScroll() {
                        isPlaying = false;
                    }

                    // Manual navigation buttons scoped specifically to this wrapper
                    if (nextBtn && prevBtn) {
                        nextBtn.addEventListener('click', () => {
                            stopScroll();
                            viewport.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                        });

                        prevBtn.addEventListener('click', () => {
                            stopScroll();
                            viewport.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                        });
                    }

                    // Hover & Touch Events (Pause on interaction)
                    viewport.addEventListener('mouseenter', stopScroll, { passive: true });
                    viewport.addEventListener('mouseleave', startScroll, { passive: true });
                    viewport.addEventListener('touchstart', stopScroll, { passive: true });
                    viewport.addEventListener('touchend', startScroll, { passive: true });

                    // Initialize auto-scroll loop for this individual category showcase
                    animationFrameId = requestAnimationFrame(step);
                });
            });
        </script>
    <!-- Popular bottle Ends -->
        
        
        <!-- Stats Starts -->
        

            <!-- DEPENDENCIES FOR VECTOR STAT ICONS -->

            <div class="container-fluid counter-scaffolding mask-reveal">
                <div class="container">
                    <!-- Grid updated to accommodate 7 columns on desktop -->
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-7 justify-content-center g-2 g-md-4">
                        
                        <!-- METRIC 1: BOTTLES -->
                        <div class="col stat-metric-node">
                            <div class="stat-icon-wrapper">
                                <i class="fa-solid fa-wine-bottle stat-node-icon"></i>
                            </div>
                            <h3 class="stat-node-number">
                                <span class="live-count" data-target="70000">0</span>+
                            </h3>
                            <p class="stat-node-label">Bottles Manufactured Daily</p>
                        </div>
                        
                        <!-- METRIC 2: TUMBLERS -->
                        <div class="col stat-metric-node">
                            <div class="stat-icon-wrapper">
                                <i class="fa-solid fa-glass-water stat-node-icon"></i>
                            </div>
                            <h3 class="stat-node-number">
                                <span class="live-count" data-target="100000">0</span>+
                            </h3>
                            <p class="stat-node-label">Tumblers Manufactured Daily</p>
                        </div>
                        
                        <!-- METRIC 3: PERFUME BOTTLES -->
                        <div class="col stat-metric-node">
                            <div class="stat-icon-wrapper">
                                <i class="fa-solid fa-spray-can-sparkles stat-node-icon"></i>
                            </div>
                            <h3 class="stat-node-number">
                                <span class="live-count" data-target="500000">0</span>+
                            </h3>
                            <p class="stat-node-label">Perfume Bottles Manufactured Daily</p>
                        </div>
                        
                        <!-- METRIC 4: JARS -->
                        <div class="col stat-metric-node">
                            <div class="stat-icon-wrapper">
                                <i class="fa-solid fa-jar stat-node-icon"></i>
                            </div>
                            <h3 class="stat-node-number">
                                <span class="live-count" data-target="125000">0</span>+
                            </h3>
                            <p class="stat-node-label">Jars Manufactured Daily</p>
                        </div>
                        
                        <!-- METRIC 5: PRODUCTION CAPACITY -->
                        <div class="col stat-metric-node">
                            <div class="stat-icon-wrapper">
                                <i class="fa-solid fa-industry stat-node-icon"></i>
                            </div>
                            <h3 class="stat-node-number">
                                <span class="live-count" data-target="400">0</span>+ 
                            </h3>
                            <p class="stat-node-label">Tonnes Daily Production Capacity</p>
                        </div>
            
                        <!-- METRIC 6: EXPERIENCE -->
                        <div class="col stat-metric-node">
                            <div class="stat-icon-wrapper">
                                <i class="fa-solid fa-award stat-node-icon"></i>
                            </div>
                            <h3 class="stat-node-number">
                                <span class="live-count" data-target="53">0</span>+
                            </h3>
                            <p class="stat-node-label">Years of Experience</p>
                        </div>
            
                        <!-- METRIC 7: SKUS -->
                        <div class="col stat-metric-node">
                            <div class="stat-icon-wrapper">
                                <i class="fa-solid fa-boxes stat-node-icon"></i>
                            </div>
                            <h3 class="stat-node-number">
                                <span class="live-count" data-target="2000">0</span>+
                            </h3>
                            <p class="stat-node-label">SKUs to Choose From</p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const counterElements = document.querySelectorAll(".live-count");
                    
                    const runCounterAnimation = (element) => {
                        const targetValue = parseInt(element.getAttribute("data-target"), 10);
                        const cycleDuration = 1800; // Animation duration in ms
                        const frameRateInterval = 1000 / 60; // 60 FPS target
                        const totalFrames = Math.round(cycleDuration / frameRateInterval);
                        let currentFrame = 0;

                        const countingTick = () => {
                            currentFrame++;
                            const progressionRatio = currentFrame / totalFrames;
                            
                            // Easing curve (Ease-Out Quad)
                            const easedProgress = 1 - Math.pow(1 - progressionRatio, 2);
                            const currentValCalculated = Math.floor(targetValue * easedProgress);

                            if (currentFrame < totalFrames) {
                                element.innerText = currentValCalculated.toLocaleString('en-US');
                                requestAnimationFrame(countingTick);
                            } else {
                                element.innerText = targetValue.toLocaleString('en-US'); // Snap to exact formatted value
                            }
                        };
                        
                        requestAnimationFrame(countingTick);
                    };

                    const moduleScrollObserver = new IntersectionObserver((entries, observer) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                runCounterAnimation(entry.target);
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.15 });

                    counterElements.forEach(element => moduleScrollObserver.observe(element));
                });
            </script>
        <!-- Stats Starts -->

    
        <!-- International Coverage Starts -->
        <!-- International Coverage Starts -->
            <!-- <div class="container pt-6 reveal-on-scroll" style="padding-top: 4rem; padding-bottom: 4rem;">
                
                
                <h2 class="text-center text-uppercase org-brd-btm mb-5" style="font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 700; color: #111111; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 3.5rem;">
                    <img src="assets/themes/storefront/public/images/international-coverage-icone8da.png?v=2.0.3" class="pr-3" style="max-height: 32px; width: auto;" alt="" />
                    <span style="position: relative; padding-bottom: 12px;">
                        International coverage on Alok Glass Works Bottle
                        <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background-color: #c8232c;"></span>
                    </span>
                </h2>

                <div class="row" style="display: flex; flex-wrap: wrap; gap: 0;">
                    
                    
                    <div class="col-md-6 pb-4" style="margin-bottom: 1.5rem;">
                        <div class="shadow-post lt-blue-bg bor-radius-25" style="background-color: #fdfdfd; border: 1px solid #eef0f2; border-radius: 8px; overflow: hidden; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 24px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.04)';">
                            
                            
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

                    
                    <div class="col-md-6 pb-4" style="margin-bottom: 1.5rem;">
                        <div class="shadow-post lt-blue-bg bor-radius-25" style="background-color: #fdfdfd; border: 1px solid #eef0f2; border-radius: 8px; overflow: hidden; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 24px rgba(17,17,17,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.04)';">
                            
                            
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
            </div> -->
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
                    image,
                    short_description
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

                                        <?php if (!empty($blog['short_description'])): ?>
                                            <p class="blog-short-desc">
                                                <?= htmlspecialchars($blog['short_description']) ?>
                                            </p>
                                        <?php endif; ?>

                                        <div class="blog-action-footer">
                                            <a href="blog.php?slug=<?= urlencode($blog['slug']) ?>" class="blog-read-more">
                                                Read More <span class="arrow">&rsaquo;</span>
                                            </a>
                                        </div>

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

                    <!-- 3 Certificates Side-By-Side In 1 Single Row -->
                    <div class="row g-4 align-items-center justify-content-center">
                        
                        <!-- Certificate 01 -->
                        <div class="col-4">
                            <div class="certificate-pure-item">
                                <img src="assets/themes/storefront/public/images/reg1.jpg" alt="ISO Certification Quality Management" />
                            </div>
                        </div>

                        <!-- Certificate 02 -->
                        <div class="col-4">
                            <div class="certificate-pure-item">
                                <img src="assets/themes/storefront/public/images/reg2.jpg" alt="Safety Standard Certification" />
                            </div>
                        </div>

                        <!-- Certificate 03 -->
                        <div class="col-4">
                            <div class="certificate-pure-item">
                                <img src="assets/themes/storefront/public/images/reg3.jpg" alt="Manufacturing Excellence Award" />
                            </div>
                        </div>

                    </div>

                </div>
            </section>
        <!-- OUR CERTIFICATES ENDS -->



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
                                <img src="assets/themes/storefront/public/images/brand1.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 1" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/image.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 2" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand3.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 3" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand4.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 4" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand5.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 5" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand6.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 6" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand7.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 7" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand8.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 8" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand9.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 9" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand10.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 10" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand11.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 11" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand12.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 12" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand13.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 13" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand14.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 14" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand15.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 15" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand16.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 16" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand17.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 17" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand18.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 18" />
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand19.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 19" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand20.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 20" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand21.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 21" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand22.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 22" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand23.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 23" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand24.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 24" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand25.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 25" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand26.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 26" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand27.jpeg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 27" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand28.png?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 28" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand29.jpg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 29" />
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="brand-asset-chassis">
                                <img src="assets/themes/storefront/public/images/brand30.jpg?v=2.0.3" class="brand-vector-img img-fluid" alt="Brand Logo 30" />
                            </div>
                        </div>

                    </div>

                    <!-- Section Accent Footer -->
                    <div class="pt-2">
                        <h3 class="text-md-right text-center text-uppercase brands-footer-text pr-md-2">And many more</h3>
                    </div>

                </div>
            </div>
        <!-- Brands Ends -->


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

        <!-- CATALOG DOWNLOAD SECTION -->
                <?php

                $homeCatalogStmt = $pdo->prepare("
                    SELECT
                        id,
                        title,
                        description,
                        file_path,
                        thumbnail
                    FROM catalogs
                    WHERE status = 1
                    AND show_on_home = 1
                    ORDER BY display_order ASC, id ASC
                ");

                $homeCatalogStmt->execute();

                $homeCatalogs = $homeCatalogStmt->fetchAll();

                ?>
        <!-- MAIN PRODUCT CATALOGS SECTION -->
            <?php if(!empty($homeCatalogs)): ?>

            <div class="catalog-page-section">
                <div class="container">

                    <!-- SECTION HEADER -->
                    <div class="catalog-header-wrap">

                        <span class="catalog-pretitle"> Resources </span>
                        <h2 class="catalog-main-title"> Product Catalogs & Technical Media </h2>
                        <div class="catalog-title-underline"></div>

                        <p class="catalog-main-desc"> Explore our latest product catalogs, collections and technical resources. </p>
                    </div>


                    <!-- CATALOG GRID -->
                    <div class="row g-3">
                        <?php foreach($homeCatalogs as $index => $catalog): ?>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="product-category-card">

                                    <!-- CATALOG TITLE -->
                                    <div class=" product-card-banner <?= ($index % 2 === 0) ? 'bg-palette-accent' : 'bg-palette-charcoal' ?> ">
                                        <span class="product-card-link"> <?= htmlspecialchars($catalog['title']) ?> </span>
                                    </div>

                                    <!-- OPTIONAL DESCRIPTION -->

                                    <?php if(!empty($catalog['description'])): ?>
                                        <!-- <div style=" padding:12px 14px; text-align:center; min-height:55px; display:flex; align-items:center; justify-content:center; ">
                                            <p style=" margin:0; font-size:12px; line-height:1.5; color:#666666; "> <?= htmlspecialchars($catalog['description']) ?> </p>
                                        </div> -->
                                    <?php endif; ?>

                                    <!-- ACTION BUTTONS -->
                                    <div class="catalog-action-row">

                                        <!-- PREVIEW -->
                                        <a href="<?= htmlspecialchars($catalog['file_path']) ?>" target="_blank" rel="noopener noreferrer" class="catalog-btn-action btn-preview-dark" > <i class="fa-solid fa-eye"></i> Preview </a>
                                        <!-- DOWNLOAD -->
                                        <a href="<?= htmlspecialchars($catalog['file_path']) ?>" download class="catalog-btn-action btn-download-red" > <i class="fa-solid fa-download"></i> Download </a>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- DEDICATED COMPANY PROFILE & CREDENTIALS SECTION -->
            <!-- COMPANY PROFILE & CLIENT PORTFOLIO SECTION -->

            <div class="catalog-page-section">
                <div class="container">

                    <!-- SECTION HEADER -->
                    <div class="catalog-header-wrap">

                        <span class="catalog-pretitle"> Corporate Dossier </span>
                        <h2 class="catalog-main-title"> Company Profile & Client Credentials </h2>
                        <div class="catalog-title-underline"></div>

                        <p class="catalog-main-desc"> Explore our company profile and client portfolio. </p>
                    </div>


                    <!-- CORPORATE DOCUMENT GRID -->
                    <div class="row g-3">

                        <!-- COMPANY PROFILE -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="product-category-card">
                                <div class="product-card-banner bg-palette-accent">

                                    <span class="product-card-link"> Company Profile </span>

                                </div>

                                <div class="catalog-action-row">

                                    <a href="assets/catalogs/company_profile.pdf" target="_blank" rel="noopener noreferrer" class="catalog-btn-action btn-preview-dark" > <i class="fa-solid fa-eye"></i> Preview </a>

                                    <a href="assets/catalogs/company_profile.pdf" download class="catalog-btn-action btn-download-red" > <i class="fa-solid fa-download"></i> Download </a>

                                </div>
                            </div>
                        </div>

                        <!-- CLIENT PORTFOLIO -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="product-category-card">
                                <div class="product-card-banner bg-palette-charcoal">
                                    <span class="product-card-link"> Client Portfolio </span>
                                </div>


                                <div class="catalog-action-row">

                                    <a href="assets/catalogs/client_portfolio.pdf" target="_blank" rel="noopener noreferrer" class="catalog-btn-action btn-preview-dark" > <i class="fa-solid fa-eye"></i> Preview </a>

                                    <a href="assets/catalogs/client_portfolio.pdf" download class="catalog-btn-action btn-download-red" > <i class="fa-solid fa-download"></i> Download </a>

                                </div>
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

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/917037677289"
   class="whatsapp-float"
   target="_blank"
   aria-label="Chat on WhatsApp">

    <svg xmlns="http://www.w3.org/2000/svg"
         width="32"
         height="32"
         viewBox="0 0 32 32"
         fill="white">  

        <!-- Centered Inner Phone Handle -->
        <path d="M20.96 17.71c-.29-.15-1.72-.85-1.99-.95-.27-.1-.47-.15-.67.15-.2.29-.77.95-.94 1.14-.17.2-.35.22-.64.07-.29-.15-1.23-.45-2.34-1.43-.86-.77-1.44-1.71-1.61-2-.17-.29-.02-.44.13-.59.13-.13.29-.35.44-.52.15-.17.2-.29.3-.49.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.29-1.03 1.01-1.03 2.46 0 1.45 1.05 2.86 1.2 3.05.15.2 2.07 3.17 5.02 4.45.7.3 1.25.48 1.67.62.7.22 1.34.19 1.84.12.56-.08 1.72-.7 1.96-1.37.24-.67.24-1.25.17-1.37-.07-.12-.27-.2-.56-.35z"/>
        
        <!-- Outer Speech Bubble Chassis -->
        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 3C8.82 3 3 8.82 3 16c0 2.54.75 5.01 2.16 7.12L3.5 28.5l5.52-1.62A12.92 12.92 0 0 0 16 29c7.18 0 13-5.82 13-13S23.18 3 16 3zm0 23.6c-2.06 0-4.08-.56-5.84-1.63l-.42-.25-3.27.96.97-3.19-.28-.44A10.55 10.55 0 0 1 5.4 16C5.4 10.15 10.15 5.4 16 5.4S26.6 10.15 26.6 16 21.85 26.6 16 26.6z"/>
    </svg>

</a>

<?php include 'includes/footer.php'; ?>