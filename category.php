<?php

require 'includes/db.php';
include 'includes/header.php';

$slug = $_GET['slug'] ?? '';

$stmt = $pdo->prepare("
    SELECT *
    FROM categories
    WHERE slug = ?
");

$stmt->execute([$slug]);

$category = $stmt->fetch();

if(!$category){
    die("Category not found");
}
/*
|--------------------------------------------------------------------------
| SIDEBAR CATEGORIES
|--------------------------------------------------------------------------
*/

$sidebarCatStmt = $pdo->query("
    SELECT
        id,
        name,
        slug
    FROM categories
    ORDER BY name ASC
");

$sidebarCategories = $sidebarCatStmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| SIDEBAR SUBCATEGORIES
|--------------------------------------------------------------------------
*/

$sidebarSubStmt = $pdo->query("
    SELECT
        id,
        category_id,
        name
    FROM subcategories
    WHERE status = 1
    ORDER BY category_id, display_order, name
");

$sidebarSubcategories = [];

while($row = $sidebarSubStmt->fetch(PDO::FETCH_ASSOC)){

    $sidebarSubcategories[$row['category_id']][] = $row;

}
/*
|--------------------------------------------------------------------------
| SUBCATEGORIES
|--------------------------------------------------------------------------
*/

$selectedSubcategory = (int)($_GET['sub'] ?? 0);

$subStmt = $pdo->prepare("
    SELECT *
    FROM subcategories
    WHERE category_id = ?
    AND status = 1
    ORDER BY display_order ASC, name ASC
");

$subStmt->execute([$category['id']]);

$subcategories = $subStmt->fetchAll();

/*
|--------------------------------------------------------------------------
| PRODUCTS
|--------------------------------------------------------------------------
*/

if($selectedSubcategory > 0){

    $productStmt = $pdo->prepare("
        SELECT *
        FROM products
        WHERE category_id = ?
        AND subcategory_id = ?
        ORDER BY display_order ASC, id ASC
    ");

    $productStmt->execute([
        $category['id'],
        $selectedSubcategory
    ]);

}else{

    $productStmt = $pdo->prepare("
        SELECT *
        FROM products
        WHERE category_id = ?
        ORDER BY display_order ASC, id ASC
    ");

    $productStmt->execute([
        $category['id']
    ]);

}

$products = $productStmt->fetchAll();


?>

<div class="container pt-5 pb-5" style="font-family:'Montserrat',sans-serif;">

    <!-- CSS Theme & Grid Animations Wrapper -->
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes lineExpand {
            from { width: 0; }
            to { width: 60px; }
        }
        .animate-grid-in {
            animation: fadeInUp 0.7s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        .premium-product-card {
            display: flex; 
            flex-direction: column; 
            background: #ffffff; 
            padding: 16px; 
            border: 1px solid #eeeeee; 
            border-radius: 12px;
            transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            position: relative;
        }
        .premium-product-card:hover {
            transform: translateY(-6px);
            border-color: rgba(200, 35, 44, 0.2);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
        }
        .product-img-wrapper {
            background: #fbfbfb;
            border-radius: 8px;
            overflow: hidden;
            display: block;
            text-center;
            position: relative;
        }
        .product-img-wrapper img {
            max-height: 240px; 
            width: 100%; 
            object-fit: contain; 
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1); 
            vertical-align: middle;
            horizontal-align: middle;
        }
        .premium-product-card:hover .product-img-wrapper img {
            transform: scale(1.06);
        }
        .product-title-link {
            font-weight: 600; 
            font-size: 14px; 
            color: #222222; 
            text-decoration: none; 
            display: -webkit-box; 
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical; 
            overflow: hidden; 
            height: 42px; 
            line-height: 1.5; 
            transition: color 0.2s ease;
        }
        .premium-product-card:hover .product-title-link {
            color: #c8232c !important;
        }
        .price-tag {
            font-weight: 700; 
            font-size: 17px; 
            color: #111111; 
            letter-spacing: -0.01em;
            transition: color 0.2s ease;
        }
        .premium-product-card:hover .price-tag {
            color: #c8232c;
        }

        .category-nav{
            width:100%;
            background:#232434;
            border-radius:10px;
            display:flex;
            justify-content:center;
            margin-bottom:40px;
            box-shadow:0 8px 20px rgba(0,0,0,.08);
        }

        .category-nav ul{
            list-style:none;
            margin:0;
            padding:0;
            display:flex;
            flex-wrap:wrap;
            width:100%;
        }

        .category-nav ul li{
            position:relative;
            flex:1;
            min-width:220px;
        }

        .category-nav ul li>a{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:18px 22px;
            color:#fff;
            text-decoration:none;
            font-weight:600;
            transition:.25s;
        }

        .category-nav ul li:hover>a,
        .category-nav ul li.active>a{
            background:#c8232c;
        }

        .category-dropdown{
            position:absolute;
            top:100%;
            left:0;
            min-width:260px;
            background:#fff;
            border-radius:0 0 10px 10px;
            box-shadow:0 10px 30px rgba(0,0,0,.12);
            display:none;
            z-index:999;
        }

        .category-nav ul li:hover>.category-dropdown{
            display:block;
        }

        .category-dropdown a{
            display:block;
            padding:12px 20px;
            color:#333;
            text-decoration:none;
            border-bottom:1px solid #f2f2f2;
        }

        .category-dropdown a:hover,
        .category-dropdown a.active{
            background:#f8f8f8;
            color:#c8232c;
        }
    </style>

    <!-- Section Heading -->
    <h2 class="mb-5 text-uppercase animate-grid-in" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.03em; position: relative; padding-bottom: 16px;">
        <?= htmlspecialchars($category['name']) ?>
        <span style="position: absolute; bottom: 0; left: 0; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); animation: lineExpand 1s cubic-bezier(0.25, 1, 0.5, 1) forwards; border-radius: 2px;"></span>
    </h2>
    

    <div class="row mt-4">

        <div class="col-12">

            <div class="category-nav">

                <ul>

                    <?php foreach($sidebarCategories as $cat): ?>

                        <?php
                        $subs = $sidebarSubcategories[$cat['id']] ?? [];
                        $active = ($category['id'] == $cat['id']);
                        ?>

                        <li class="<?= $active ? 'active' : '' ?>">

                            <a href="category/<?= urlencode($cat['slug']) ?>">
                                <?= htmlspecialchars($cat['name']) ?>

                                <?php if(!empty($subs)): ?>
                                    ▼
                                <?php endif; ?>
                            </a>

                            <?php if(!empty($subs)): ?>

                                <div class="category-dropdown">

                                    <a
                                        href="category/<?= urlencode($cat['slug']) ?>"
                                        class="<?= $active && $selectedSubcategory==0 ? 'active' : '' ?>"
                                    >
                                        All Products
                                    </a>

                                    <?php foreach($subs as $sub): ?>

                                        <a
                                            href="category/<?= urlencode($cat['slug']) ?>?sub=<?= $sub['id'] ?>"
                                            class="<?= ($active && $selectedSubcategory==$sub['id']) ? 'active' : '' ?>"
                                        >
                                            <?= htmlspecialchars($sub['name']) ?>
                                        </a>

                                    <?php endforeach; ?>

                                </div>

                            <?php endif; ?>

                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

    </div>

    <!-- Product Grid -->

    <div class="row mt-5">

        <?php if(count($products) > 0): ?>
            <?php $delay = 0.1; ?>
            <?php foreach($products as $product): ?>

                <div class="col-6 col-md-4 mb-4 d-flex align-items-stretch animate-grid-in" style="animation-delay: <?= $delay; ?>s;">

                    <div class="premium-product-card w-100">

                        <!-- Image Wrapper -->
                        <a href="product/<?= urlencode($product['slug']) ?>" class="product-img-wrapper py-3">
                            <img
                                src="storage/media/<?= basename($product['image']) ?>"
                                class="img-fluid"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                            >
                        </a>

                        <!-- Details Body -->
                        <div class="mt-3 d-flex flex-column" style="flex-grow: 1;">
                            <a href="product/<?= urlencode($product['slug']) ?>" class="product-title-link">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                            
                            <!-- Price Tag Layout -->
                            <div class="mt-auto pt-2 d-flex align-items-center justify-content-between">
                                <p class="price-tag mb-0">
                                    ₹<?= number_format($product['price'], 2) ?>
                                </p>
                                <span style="font-size: 18px; color: #b3b3b3; transition: transform 0.3s ease, color 0.3s ease;" class="card-arrow-icon">→</span>
                            </div>
                        </div>

                    </div>

                </div>
                
                <?php $delay += 0.05; // Stagger effect for loading layout beautifully ?>
            <?php endforeach; ?>

        <?php else: ?>

            <!-- Empty State Display -->
            <div class="col-12 text-center py-5 animate-grid-in" style="animation-delay: 0.2s;">
                <div class="py-4" style="background: rgba(0, 0, 0, 0.02); border-radius: 12px; border: 1px dashed #dddddd; max-width: 500px; margin: 0 auto;">
                    <h4 class="mb-0" style="font-weight: 500; color: #777777; font-size: 15px; letter-spacing: 0.5px;">No products found in this category.</h4>
                </div>
            </div>

        <?php endif; ?>

    </div>
        
</div>

<?php include 'includes/footer.php'; ?>