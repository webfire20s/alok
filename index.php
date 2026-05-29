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
    
        <div class="text-center header-bg-1920"> 

            <!-- banner code start here -->

            
                    <div class="home-slider-wrap">
                        <div
                            class="home-slider"
                            data-speed="1500"
                            data-autoplay="1"
                            data-autoplay-speed="3000"
                            data-fade="1"
                            data-dots="1"
                            data-arrows="1"
                        >
                                                        <div class="slide">
                                    <img src="assets/publics/storage/media/SOfX1kpP7ZEkLECuVjKJC2GrC7RzaNmGCJYUwUR4.jpg" data-animation-in="zoomInImage" class="slider-image animated">

                                    <div class="slide-content align-left">
                                        <div class="captions">
                                            <span
                                                class="caption caption-1"
                                                data-animation-in="fadeInUp"
                                                data-delay-in=""
                                            >
                                                
                                            </span>

                                            <span
                                                class="caption caption-2"
                                                data-animation-in="fadeInUp"
                                                data-delay-in=""
                                            >
                                                
                                            </span>

                                                                                        <a
                                                    href="contact.html"
                                                    class="btn btn-primary btn-slider"
                                                    data-animation-in="fadeInUp"
                                                    data-delay-in=""
                                                    target="_self"
                                                >
                                                    Contact Us
                                                </a>
                                                                                </div>
                                    </div>
                                </div>
                                                        <div class="slide">
                                    <img src="assets/publics/storage/media/EGg2TgPh1xebIugmlrlpnw1dvHgRisNt1VDiZMyZ.jpg" data-animation-in="zoomInImage" class="slider-image animated">

                                    <div class="slide-content align-right">
                                        <div class="captions">
                                            <span
                                                class="caption caption-1"
                                                data-animation-in="fadeInUp"
                                                data-delay-in=""
                                            >
                                                
                                            </span>

                                            <span
                                                class="caption caption-2"
                                                data-animation-in="fadeInUp"
                                                data-delay-in=""
                                            >
                                                
                                            </span>

                                                                                        <a
                                                    href="contact.html"
                                                    class="btn btn-primary btn-slider"
                                                    data-animation-in="fadeInUp"
                                                    data-delay-in=""
                                                    target="_self"
                                                >
                                                    Contact Us
                                                </a>
                                                                                </div>
                                    </div>
                                </div>
                                                </div>
                

            <!-- banner code end here -->

        <!--    <img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/banner.jpg?v=2.0.3" class="img-fluid" alt="" />  -->
        </div>

        <div class="container-fluid lt-gray-bg pt-5 pb-5 ptm-0 pbm-0">
            <div class="container banner-icons only-desktop">
                <div class="row no-gutters">
                    <div class="col-lg-2 col-6 pl-2 pr-2 ptm-20px pbm-20px">
                        <img src="assets/themes/storefront/public/images/safe-shopping-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Trusted for <br/><label>4 Decades</label></span>
                    </div>
                    <div class="col-lg-2 col-6 pl-2 pr-2 ptm-20px pbm-20px">
                        <img src="assets/themes/storefront/public/images/lowest-price-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Highest Quality <br/><label>Lowest Price</label></span>
                    </div>
                    <div class="col-lg-2 col-6 pl-2 pr-2 ptm-20px">
                        <img src="assets/themes/storefront/public/images/guarantee-dispatch-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Fast Despatch <br/><label>Guaranteed</label></span>
                    </div>
                    <div class="col-lg-2 col-6 pl-2 pr-2 ptm-20px">
                        <img src="assets/themes/storefront/public/images/30-days-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Hassle Free Return <br/><label>Money Back Guarantee</label></span>
                    </div>
                    <div class="col-lg-2 col-6 pl-2 pr-2 ptm-20px">
                        <img src="assets/themes/storefront/public/images/safe-shopping-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Safe <br/><label>and Secure</label></span>
                    </div>
                    <div class="col-lg-2 col-6 pl-2 pr-2 ptm-20px pbm-20px">
                        <img src="assets/themes/storefront/public/images/verifiede8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>One Stop <br/><label>Solution</label></span>
                    </div>
                </div>
        </div>
        <div class="container banner-icons only-mobile no-gutters pt-3 pb-3">
                <div class="row no-gutters fs12">
                    <div class="col-6 pb-3 text-center">
                        <img src="assets/themes/storefront/public/images/safe-shopping-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Trusted for <br/><label>4 Decades</label></span>
                    </div>
                    <div class="col-6 pb-3 text-center">
                        <img src="assets/themes/storefront/public/images/lowest-price-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Highest Quality <br/><label>Lowest Price</label></span>
                    </div>
                    <div class="col-6 text-center">
                        <img src="assets/themes/storefront/public/images/guarantee-dispatch-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Fast Despatch <br/><label>Guaranteed</label></span>
                    </div>
                    <div class="col-6 text-center">
                        <img src="assets/themes/storefront/public/images/30-days-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Hassle Free Return <br/><label>Money Back Guarantee</label></span>
                    </div>
                    <div class="col-6 text-center">
                        <img src="assets/themes/storefront/public/images/safe-shopping-icone8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>Safe <br/><label>and Secure</label></span>
                    </div>
                    <div class="col-6 text-center">
                        <img src="assets/themes/storefront/public/images/verifiede8da.png?v=2.0.3" class="img-fluid float-left pr-2" alt="" />
                        <span>One Stop <br/><label>Solution</label></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shop by Industry Starts -->
        <div class="container pt-6">

            <h2 class="text-center text-uppercase org-brd-btm mb-5">
                <img src="assets/themes/storefront/public/images/shop-by-industry-icone8da.png?v=2.0.3" class="pr-3" />
                Shop by Industry
            </h2>

            <div class="row">

                <?php foreach($categories as $category): ?>

                    <div class="col-md-6 mb-4">

                        <div class="lt-gray-bg height-equal p-4">

                            <h3 class="head-org-bold">
                                <?= htmlspecialchars($category['name']) ?>
                            </h3>

                            <div class="row">

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

                                    <div class="col-6 col-md-6 text-center pb-4 product-name txt-black">

                                        <a href="product.php?slug=<?= $product['slug'] ?>">

                                            <img
                                                src="storage/medium/<?= $product['image'] ?>"
                                                class="img-fluid mb-3 shadow"
                                            >

                                        </a>

                                        <br/>

                                        <a href="product.php?slug=<?= $product['slug'] ?>">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </a>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
        <!-- Shop by Industry Ends -->
        
        <!-- Shop by Product Starts -->

        <div class="container pt-6 only-desktop">

            <h2 class="text-center text-uppercase org-brd-btm mb-5">
                <img src="assets/themes/storefront/public/images/shop-by-product-icone8da.png?v=2.0.3"
                    class="pr-3 pt-2" />

                Shop by Product
            </h2>

            <div class="row">

                <?php foreach($featuredCategories as $index => $category): ?>

                    <?php
                    $bgClass = ($index % 2 == 0)
                        ? 'org-bg'
                        : 'dk-gray-bg';
                    ?>

                    <div class="col-md-4 mb-4">

                        <div class="gray-brd-right-bottom">

                            <a href="category.php?slug=<?= $category['slug'] ?>">

                                <img
                                    src="storage/medium/<?= $category['image'] ?>"
                                    class="img-fluid"
                                    style="width:100%;"
                                >

                            </a>

                            <div class="<?= $bgClass ?> sb text-uppercase fs18 text-center p-2">

                                <a
                                    href="category.php?slug=<?= $category['slug'] ?>"
                                    class="link-block text-white"
                                >
                                    <?= htmlspecialchars($category['name']) ?>
                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

        <!-- MOBILE VERSION -->
        <div class="container pt-6 only-mobile">

            <h2 class="text-center text-uppercase org-brd-btm mb-5">

                <img
                    src="assets/themes/storefront/public/images/shop-by-product-icone8da.png?v=2.0.3"
                    class="pr-3 pt-2"
                />

                Shop by Product

            </h2>

            <div class="row">

                <div class="col-12">

                    <div id="carouselExampleControls"
                        class="carousel slide"
                        data-ride="carousel">

                        <div class="carousel-inner">

                            <?php foreach($featuredCategories as $index => $category): ?>

                                <?php
                                $bgClass = ($index % 2 == 0)
                                    ? 'org-bg'
                                    : 'dk-gray-bg';
                                ?>

                                <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">

                                    <img
                                        src="storage/medium/<?= $category['image'] ?>"
                                        class="d-block w-100"
                                    >

                                    <div class="<?= $bgClass ?> sb text-uppercase fs18 text-center p-2">

                                        <a
                                            href="category.php?slug=<?= $category['slug'] ?>"
                                            class="link-block text-white"
                                        >
                                            <?= htmlspecialchars($category['name']) ?>
                                        </a>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                        <a class="carousel-control-prev"
                        href="#carouselExampleControls"
                        role="button"
                        data-slide="prev">

                            <span class="carousel-control-prev-icon"></span>

                        </a>

                        <a class="carousel-control-next"
                        href="#carouselExampleControls"
                        role="button"
                        data-slide="next">

                            <span class="carousel-control-next-icon"></span>

                        </a>

                    </div>

                </div>

            </div>

        </div>

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

        <div class="container pt-6 pb-5">

            <h2 class="text-center text-uppercase org-brd-btm mb-5">
                <?= htmlspecialchars($category['section_title']) ?>
            </h2>

            <div class="row">

                <?php foreach($products as $product): ?>

                <div class="col-6 col-md-3 pb-4">

                    <div class="show-buy-now-btn position-relative">

                        <a href="product.php?slug=<?= urlencode($product['slug']) ?>">

                            <img src="<?= htmlspecialchars($product['image']) ?>"
                                class="img-fluid mb-3 shadow"
                                alt="<?= htmlspecialchars($product['name']) ?>" />

                            <button type="button" class="btn float-red-btn">
                                Buy Now
                            </button>

                        </a>

                    </div>

                    <div class="product-name">

                        <a href="product.php?slug=<?= urlencode($product['slug']) ?>"
                        class="txt-org">

                            <?= htmlspecialchars($product['name']) ?>

                        </a>

                        <br/>

                        <span class="txt-black">
                            ₹<?= number_format($product['price'], 2) ?>
                        </span>

                    </div>

                </div>

                <?php endforeach; ?>

            </div>

        </div>

        <?php endforeach; ?>
        <!-- Popular bottle Ends -->
        <!-- Stats Starts -->
        <div class="container-fluid lt-gray-bg text-center">
            <div class="container pt-5 only-desktop">
                <div class="row">
                    <div class="col pb-5">
                        <img src="assets/themes/storefront/public/images/stats-satisfied-customer-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">7379+</h3>
                        Satisfied Customers
                    </div>
                    <div class="col pb-5">
                        <img src="assets/themes/storefront/public/images/stats-bottle-choose-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">157+ Bottle</h3>
                        To Choose from
                    </div>
                    <div class="col pb-5">
                        <img src="assets/themes/storefront/public/images/stats-bottle-sold-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">3Billion +</h3>
                        Bottles Sold
                    </div>
                    <div class="col pb-5">
                        <img src="assets/themes/storefront/public/images/stats-experience-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">40+</h3>
                        Year Experience
                    </div>
                    <div class="col pb-5 text-center">
                        <img src="assets/themes/storefront/public/images/stats-revenue-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">96% REVENUE</h3>
                        From Repeat Customers
                    </div>
                </div>
        </div>
        <div class="container pt-5 only-mobile">
                <div class="row">
                    <div class="col-6 pb-3">
                        <img src="assets/themes/storefront/public/images/stats-satisfied-customer-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">7379+</h3>
                        Satisfied Customer
                    </div>
                    <div class="col-6 pb-3">
                        <img src="assets/themes/storefront/public/images/stats-bottle-choose-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">157+ Bottle</h3>
                        To Choose from
                    </div>
                    <div class="col-6 pb-3">
                        <img src="assets/themes/storefront/public/images/stats-bottle-sold-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">3Billion +</h3>
                        Bottles Sold
                    </div>
                    <div class="col-6 pb-3">
                        <img src="assets/themes/storefront/public/images/stats-experience-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">40+</h3>
                        Year Experience
                    </div>
                    <div class="col-12 pb-5 text-center">
                        <img src="assets/themes/storefront/public/images/stats-revenue-icone8da.png?v=2.0.3" alt="" />
                        <h3 class="txt-org font-weight-bold mb0 pt-2">96% REVENUE</h3>
                        From Repeat Customer
                    </div>
                </div>
            </div>
        </div>
        <!-- Stats Ends -->
        <!-- International Coverage Starts -->
        <div class="container pt-6">
            <h2 class="text-center text-uppercase org-brd-btm mb-5"><img src="assets/themes/storefront/public/images/international-coverage-icone8da.png?v=2.0.3" class="pr-3" />International coverage on Ajanta Bottle</h2>
            <div class="row">
                <div class="col-md-6 pb-4">
                    <div class="shadow-post lt-blue-bg bor-radius-25">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="bg-white bor-rad-lt-25 float-left w50p pt-2 pb-2"><a href="#"><img src="assets/themes/storefront/public/images/harward-logoe8da.jpg?v=2.0.3" class="img-fluid d-block m-auto" /></a></div>
                                <div class="lt-org-bg bor-rad-rt-25 float-right w50p mh110"><h3 class="text-white font-weight-bold text-uppercase pt-40px">Case Study</h3></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pt-3 pr-5 pb-4 pl-5 m-pl-5">
                                <p class="text-center fs18"><a href="#"><strong>AJANTA PACKAGING:</strong> Key Account Management</a></p>
                                <p class="pb-4">In the fall of 2017, Ajanta Packaging (Ajanta) was among the fastest 
                                    growing glass bottle-packaging companies in India. Although the 
                                    company had a large buyer base of 1,700 customers, buyer, S.F. 
                                    Foods (SF) which accounted for 15 per cent of Ajanta's revenue.
                                </p>
                                <div class="text-center"><a href="https://hbsp.harvard.edu/product/W18241-PDF-ENG"><button type="button" class="btn btn-org-1">View More &rsaquo;</button></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="shadow-post lt-blue-bg bor-radius-25">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="bg-white bor-rad-lt-25 float-left w50p pt-2 pb-2"><a href="#"><img src="assets/themes/storefront/public/images/harward-logoe8da.jpg?v=2.0.3" class="img-fluid d-block m-auto" /></a></div>
                                <div class="lt-org-bg bor-rad-rt-25 float-right w50p mh110"><h3 class="text-white font-weight-bold text-uppercase pt-40px">Case Study</h3></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pt-3 pr-5 pb-4 pl-5 m-pl-5">
                                <p class="text-center fs18"><a href="#"><strong>AJANTA PACKAGING</strong></a></p>
                                <p class="pb-4">The Indian packaging industry - represented by a mix of paperboard, 
                                    plastics, metals and glass - had seen great change leading up to 2013. 
                                    In 2012, Suppliers of glass bottles in India with an employee base of 
                                    more than 50 and net revenues of US$100 million.
                                </p>
                                <div class="text-center"><a href="https://hbsp.harvard.edu/product/W13599-PDF-ENG"><button type="button" class="btn btn-org-1">View More &rsaquo;</button></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- International Coverage Ends -->
        <!-- Latest Blog Starts -->

        <div class="container pt-6">

            <h2 class="text-center text-uppercase org-brd-btm mb-5"><!--<img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/latest-blog-icon.png?v=2.0.3" class="pr-3" />-->Latest Blogs</h2>

            <div class="row">

                <div class="col-md-12">

                    <div class="row">

                        
                            
                                <div class="col-md-3 col-6" style="margin-bottom: 15px;">

                                    <div class="latest-image-box">

                                        <a href="public/blog/vacuum-packaging-machine/index.html"><img src="blog/wp-content/uploads/2026/03/blog-Heading-12.png" class="img-fluid" alt="" /></a>

                                        <div><a href="public/blog/vacuum-packaging-machine/index.html">2026 Complete Vacuum Packaging Machine Guide for Better Freshness & Reduced Product Waste</a></div>

                                    </div>

                                </div>

                            
                                <div class="col-md-3 col-6" style="margin-bottom: 15px;">

                                    <div class="latest-image-box">

                                        <a href="public/blog/amber-glass-bottles/index.html"><img src="blog/wp-content/uploads/2026/02/blog-Heading-10.png" class="img-fluid" alt="" /></a>

                                        <div><a href="public/blog/amber-glass-bottles/index.html">High Impact Amber Glass Bottles For 2026: Uses, Benefits, Sizes, and How to Choose the Right One</a></div>

                                    </div>

                                </div>

                            
                                <div class="col-md-3 col-6" style="margin-bottom: 15px;">

                                    <div class="latest-image-box">

                                        <a href="public/blog/dropper-bottles/index.html"><img src="blog/wp-content/uploads/2026/02/blog-Heading-9.png" class="img-fluid" alt="" /></a>

                                        <div><a href="public/blog/dropper-bottles/index.html">5 Powerful Dropper Bottles Insights for Serums & Oils: Perfect Fit, Leak-Free Design & Costly Mistakes to Avoid</a></div>

                                    </div>

                                </div>

                            
                                <div class="col-md-3 col-6" style="margin-bottom: 15px;">

                                    <div class="latest-image-box">

                                        <a href="public/blog/liquid-filling-machine/index.html"><img src="blog/wp-content/uploads/2026/02/blog-Heading-7.png" class="img-fluid" alt="" /></a>

                                        <div><a href="public/blog/liquid-filling-machine/index.html">7 Key Tips To Select The Perfect Liquid Filling Machine For Your Business</a></div>

                                    </div>

                                </div>

                            
                        
                        <!--<div class="col-6">

                        <div class="latest-image-box">

                            <a href="#"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/latest-blog-img-1.jpg?v=2.0.3" class="img-fluid" alt="" /></a>

                            <div><a href="#">How to make a chocolate milkshake?</a></div>

                        </div>

                        </div>

                        <div class="col-6">

                        <div class="latest-image-box">

                            <a href="#"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/latest-blog-img-2.jpg?v=2.0.3" class="img-fluid" alt="" /></a>

                            <div><a href="#">Hershey'schocolate milkshake</a></div>

                        </div>

                        </div>-->

                    </div>

                    <div class="text-center pt-4 pb-3"><a href="blog/index.html" class="btn btn-org-1">More Blogs &rsaquo;</a></div>

                </div>

            <!--  <div class="col-md-6">

                    <iframe width="100%" height="300" src="https://www.youtube.com/embed/po2ooctLe-Y" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                </div> -->

            </div>

        </div>

        <!-- Latest Blog Ends -->
        <!-- Google Review Starts -->
        <div class="container pt-6">
            <h2 class="text-center text-uppercase org-brd-btm mb-5"><img src="assets/themes/storefront/public/images/google-reviews-icone8da.png?v=2.0.3" class="pr-3" />GOOGLE REVIEWS BY REAL CUSTOMERS</h2>
            <div class="row">
                <div class="col-md-4 pb-5 text-center google-company-details">
                    <h3 class="txt-333">Ajanta Bottle Pvt Ltd</h3>
                    <ul class="pb-4">
                        <li class="txt-gray fs32 pr-2 align-middle">4.8</li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" /></li>
                        <li><img src="assets/themes/storefront/public/images/google-star-bige8da.jpg?v=2.0.3" /></li>
                        <li class="txt-gray align-content-center">815 reviews</li>
                    </ul>
                    <button type="button" class="btn btn-org-1"><img src="assets/themes/storefront/public/images/vision-icone8da.png?v=2.0.3" class="pr-2" />See More Reviews</button> 
                </div>
                <div class="col-md-8 pb-5 google-reviews">
                    <div class="row">
                        <!-- <div class="col-md-1 col-1 text-center align-self-center"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-review-left-icon.gif?v=2.0.3" /></div> -->


                        
                        <div id="demo" class="carousel slide" data-ride="carousel">
                            <!-- <ul class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1"></li>
                            <li data-target="#demo" data-slide-to="2"></li>
                            </ul> -->
                            <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Pallavi Khemka</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">1 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>( March 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                Good collection and reasonable rates. Looking forward to getting more variety and awesome service as always. </div>
                                </div> 
                            </div>
                            <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Prithipal Singh</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">2 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>( March 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> Gurgaon</p><br>
                                It was a very warm experience while visiting your office. Everything was explained in detail and the quotation was provided immediately. Thanks for the courtesy extended during our visit. Overall good experience.<br>
                                Thanks</div>
                                </div>    
                            </div>
                            <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Anchal Srivastava</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">3 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>(March 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                It was excellent professional process of order and delivery of high quality Glass Jar at very reasonable price. which we ordered for using in pur processed food packing. And to Mention every query and request was handled by Mr Rahul Kashyap in a very professional approach. Thanks .. Would surely recommend to others and for sure going to continue for long term business.</div>
                                </div>   
                            </div>
                            <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Charu Mehta</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">4 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>(March 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                Very Good product, prompt delivery, good response by salers we got all d feedback about products delivery status etc.by Rahul</div>
                                </div>   
                            </div>
                            <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Asif Dar</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">5 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>(FEBRUARY 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                Best & authentic place to find any kind of glass bottles. Highly recommended.</div>
                                </div>   
                            </div>
                            <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">veluri neelima</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">5 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>(FEBRUARY 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                The team is really very polite. Excellent response. Their service is very commendable. I would recommend for the wide varieties available and also giving the exact timely delivery.</div>
                                </div>   
                            </div>
                        <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Javed Sabunwala</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">5 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>(FEBRUARY 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                It was good experience with Ajanta, Bhawna, she really helped me related to there products and send me the samples which I had demanded for, Thanks</div>
                                </div>   
                            </div>
                            <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Sinish Dominic</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">5 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>(FEBRUARY 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                Very good, awesome experience Appreciated to to the quick response</div>
                                </div>   
                            </div>
                            <div class="carousel-item">
                                <div class="border-review p-3 m-ml-12px">
                                <!-- <div class="float-left pr-2"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-profile-pic.jpg?v=2.0.3" /></div> -->
                                <div class="float-left"><span class="font-weight-bold txt-black pb-2">Sahil Sharma</span><br>
                                <ul>
                                    <!-- <li class="txt-a2a">5 reviews</li> -->
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li><img src="assets/themes/storefront/public/images/google-star-smalle8da.jpg?v=2.0.3" /></li>
                                    <li>(JAN 2022)</li>
                                </ul>
                                <p><b style="font-weight: 600;">Address:</b> New Delhi</p><br>
                                My self Ved.Sahil Sharma (Ayurvedacharya) my feedback regards ur product your service is awesome and quality is 100 out of 100 ● I personally satisfied with price, special quality,air tight keep shinning keep growing Near 1 month ago our college National college of ayurveda ,barwala,hisar. we had already purchased 12,00 jars of around ₹22k around stay blessed ur product rocks # I always suggest all my known doctors or frnds to use this rating full out of full in every aspect... By heart really ur company hard works is valuable and a great value of Money......Thanku so much again....Jai bharat I heartly support made in bharat all hard working souls for our country for our earth....i had use First time this company a month ago and now always every time I will definitely use ajanta products in future from my experience and Strongly Recommend to all spcl to those who want premium quality and satisfaction anywhere they sell their product packed in ajanta jars/bottles who receives it will definitely satisfied.....</div>
                                </div>   
                            </div>
                            </div>
                            
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"><img src="assets/themes/storefront/public/images/google-review-left-icone8da.gif?v=2.0.3" /></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"><img src="assets/themes/storefront/public/images/google-review-right-icone8da.gif?v=2.0.3" /></span>
                            </a>
                        </div>
                        
                        
                        <!-- <div class="col-md-1 col-1 text-center align-self-center"><img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/google-review-right-icon.gif?v=2.0.3" /></div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Google Review Ends -->
        <!-- Brands Starts -->
        <div class="container-fluid lt-gray-bg text-center">
            <div class="container p-5 pt-6 only-desktop">
                <h2 class="text-center text-uppercase org-brd-btm mb-5"><img src="assets/themes/storefront/public/images/brands-icone8da.png?v=2.0.3" class="pr-3" />BRANDS WHO TRUST US</h2>
                <div class="row pb-4">
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-1e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-2e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-3e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-4e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-5e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
            </div>
            <div class="row pb-4">
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-6e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <!--<div class="col align-self-center">
                        <img src="https://www.ajantabottle.com/assets/themes/storefront/public/images/brands-icon-7.png?v=2.0.3" class="img-fluid" alt="" />
                    </div> -->
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-18e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-8e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-9e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-10e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
            </div>
            <div class="row pb-4">
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-11e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-12e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-13e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-14e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-15e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                </div>
                <div class="row pb-4">
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-16e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-17e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-19e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/Keventers-13e8da.png?v=2.0.3" class="img-fluid" alt="" /> 
                    </div>
                    <div class="col align-self-center">
                        <img src="assets/themes/storefront/public/images/TRUEOILe8da.png?v=2.0.3" class="img-fluid" alt="" /> 
                    </div>
                </div>
                
                <div><h3 class="text-right">And many more</h3></div>
                
            </div>
            
            <div class="container p-5 m-pl-5 pr-5 only-mobile">
                <h2 class="text-center text-uppercase org-brd-btm mb-5"><img src="assets/themes/storefront/public/images/brands-icone8da.png?v=2.0.3" class="pr-3" />BRANDS WHO TRUST US</h2>
                <div class="row">
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-1e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-2e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-3e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-4e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-5e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-6e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-7e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-8e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-9e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-10e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-11e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-12e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-13e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-14e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-15e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-16e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-17e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-18e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                    <div class="col-6 col-md-3 pb-4 align-self-center">
                        <img src="assets/themes/storefront/public/images/brands-icon-19e8da.png?v=2.0.3" class="img-fluid" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Brands Ends -->
        <style>
            /* Buttons test */
            .btn-org {background: #f25c29; color: #fff; font-size: 14px; padding: 6px 30px; border-radius: 5px;}
            .btn-org:hover, .btn-org:focus{color: #fff; background: #ff4100;}
            .btn-org-1 {background: #f25c29; color: #fff; font-size: 14px; padding: 6px 20px; border-radius: 5px;}
            .btn-org-1:hover{color: #fff;}
            .btn-white-outline {background: #fff; color: #404040; border: 1px solid #cccccc; font-size: 14px; padding: 2px 16px;}
            .btm-colors {width: 100%; min-height: 25px;}
            .float-red-btn {position:absolute; width:50%; margin:0 auto; background: #f25c29; text-align:center; font-size: 14px; color: #fff; left: 26%; bottom: 18%; display:none;}
            
            div.show-buy-now-btn {position: relative;}
            div.show-buy-now-btn:hover button {display: block;}
        </style>

  
    </main>
   

<?php include 'includes/footer.php'; ?>