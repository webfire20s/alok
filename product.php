<?php
require 'includes/db.php';
include 'includes/header.php';

$slug = $_GET['slug'] ?? '';

$stmt = $pdo->prepare("
    SELECT * FROM products
    WHERE slug = ?
");

$stmt->execute([$slug]);

$product = $stmt->fetch();

if(!$product){
    die("Product not found");
}

/*
|--------------------------------------------------------------------------
| PRODUCT CLOSURE OPTIONS
|--------------------------------------------------------------------------
*/

$closureOptions = [];

if($product['has_closure_options']){

    $closureStmt = $pdo->prepare("
        SELECT
            co.*
        FROM product_closure_options pco
        INNER JOIN closure_options co
            ON co.id = pco.closure_option_id
        WHERE
            pco.product_id = ?
            AND co.status = 1
        ORDER BY
            co.sort_order ASC,
            co.name ASC
    ");

    $closureStmt->execute([$product['id']]);

    $closureOptions = $closureStmt->fetchAll();

}
?>

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif;">
    <style>
        .product-hero-card {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: transform 0.4s ease;
        }
        .product-hero-card:hover { transform: translateY(-5px); }
        
        .rating-star { color: #f1b434; font-size: 18px; }
        
        .purchase-alert {
            background: rgba(200, 35, 44, 0.05) !important;
            border: 1px solid rgba(200, 35, 44, 0.1) !important;
            color: #111111 !important;
            border-radius: 8px;
            padding: 16px !important;
        }
        
        .custom-select-theme {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background-color: #fdfdfd;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .custom-select-theme:focus {
            border-color: #c8232c;
            box-shadow: 0 0 0 4px rgba(200, 35, 44, 0.1);
        }
    </style>

    <div class="row align-items-center">

        <!-- Left: Product Image -->
        <div class="col-md-6 mb-5 text-center">
            <div class="product-hero-card">
                <img src="<?= htmlspecialchars($product['image']) ?>" 
                     class="img-fluid" 
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     style="max-height: 480px; width: auto; object-fit: contain;">
            </div>
        </div>

        <!-- Right: Product Details -->
        <div class="col-md-6">
            <?php
            $ratingStmt = $pdo->prepare("SELECT COUNT(*) AS total_reviews, AVG(rating) AS avg_rating FROM product_reviews WHERE product_id = ? AND is_approved = 1");
            $ratingStmt->execute([$product['id']]);
            $ratingData = $ratingStmt->fetch();
            $totalReviews = (int)($ratingData['total_reviews'] ?? 0);
            $avgRating = round($ratingData['avg_rating'] ?? 0, 1);
            ?>

            <?php if($totalReviews > 0): ?>
                <div class="mb-3 d-flex align-items-center gap-2">
                    <span class="rating-star">
                        <?php 
                        $fullStars = floor($avgRating);
                        for($i=1; $i<=5; $i++) echo ($i <= $fullStars) ? '★' : '☆';
                        ?>
                    </span>
                    <span style="color: #666; font-size: 14px; font-weight: 500;">
                        <strong style="color: #111;"><?= $avgRating ?></strong> (<?= $totalReviews ?> Reviews)
                    </span>
                </div>
            <?php endif; ?>

            <h2 class="mb-3 text-uppercase" style="font-size: 32px; font-weight: 800; color: #111; letter-spacing: -0.02em;">
                <?= htmlspecialchars($product['name']) ?>
            </h2>

            <h3 class="mb-4" style="font-size: 28px; font-weight: 700; color: #c8232c;">
                ₹<?= number_format($product['price'], 2) ?>
            </h3>

            <p class="mb-4" style="font-size: 15px; line-height: 1.8; color: #666;">
                <?= nl2br(htmlspecialchars($product['short_description'])) ?>
            </p>

            <div class="d-flex mb-4 gap-4">
                <div>
                    <span style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #999; margin-bottom: 4px;">SKU</span>
                    <span style="font-weight: 600; color: #333;"><?= htmlspecialchars($product['sku']) ?></span>
                </div>
                <div>
                    <span style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #999; margin-bottom: 4px;">Availability</span>
                    <span style="font-weight: 600; padding: 0 15px; color: <?= $product['stock'] > 0 ? '#28a745' : '#c8232c' ?>;">
                        <?= $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                    </span>
                </div>
            </div>

            <form action="add-to-cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="mb-4">
                    <label class="d-block mb-2" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111; letter-spacing: 0.05em;">Purchase Type</label>
                    
                    <?php if($product['selling_type'] == 'both'): ?>
                        <select name="order_unit" class="form-control custom-select-theme">
                            <option value="piece">Buy Individual Pieces</option>
                            <option value="box">Buy Full Boxes</option>
                        </select>
                        <?php if($product['pieces_per_box']): ?>
                            <small class="d-block mt-2" style="color: #888;">📦 1 Box = <?= $product['pieces_per_box'] ?> Pieces</small>
                        <?php endif; ?>

                    <?php elseif($product['selling_type'] == 'box'): ?>
                        <input type="hidden" name="order_unit" value="box">
                        <div class="purchase-alert">
                            <strong>Sold only in boxes.</strong><br>
                            <span style="font-size: 13px; color: #666;">1 Box = <?= $product['pieces_per_box'] ?> Pieces</span>
                        </div>

                    <?php else: ?>
                        <input type="hidden" name="order_unit" value="piece">
                        <div class="purchase-alert">Sold individually per piece.</div>
                    <?php endif; ?>
                </div>

                <?php if($product['has_closure_options'] && !empty($closureOptions)): ?>

                <div class="mb-4">

                    <label
                        class="d-block mb-2"
                        style="
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            color:#111;
                            letter-spacing:.05em;
                        ">

                        Closure Options for this Glass Bottle

                    </label>

                    <select
                        name="closure_option_id"
                        class="form-control custom-select-theme"
                        required>

                        <option value="">
                            Select Closure Option
                        </option>

                        <?php foreach($closureOptions as $closure): ?>

                            <option value="<?= $closure['id'] ?>">

                                <?= htmlspecialchars($closure['name']) ?>

                                <?php if($closure['price'] > 0): ?>

                                    (+₹<?= number_format($closure['price'],2) ?>)

                                <?php endif; ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <?php endif; ?>

                <div class="mb-4">

                    <label
                        class="d-block mb-2"
                        id="quantityLabel"
                        style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em;"
                    >
                        Quantity
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        class="form-control"
                        min="<?= $product['min_order_qty'] ?>"
                        value="<?= $product['min_order_qty'] ?>"
                        required
                        style="height: 46px; max-width: 160px; border-radius: 4px; border: 1px solid #cccccc; font-size: 15px; font-weight: 600; color: #111111; text-align: center; box-shadow: none;"
                    >

                </div>

                <div class="py-3 border-top border-bottom mb-4" style="border-color: #eeeeee !important; font-size: 14px;">
                    <div class="mb-2">
                        <span style="font-weight: 600; color: #111111; display: inline-block; width: 200px;">GST Requirement:</span>
                        <span style="color: #555555;"><?= $product['gst_percent'] ?>%</span>
                    </div>
                    <div>
                        <span style="font-weight: 600; color: #111111; display: inline-block; width: 200px;">Minimum Order Quantity:</span>
                        <span style="color: #555555; font-weight: 600;"><?= $product['min_order_qty'] ?></span>
                    </div>
                </div>

                <div class="d-flex align-items-center flex-wrap gap-2 mt-4">
                    <button
                        type="submit"
                        class="btn btn-lg text-uppercase"
                        style="background-color: #c8232c; color: #ffffff; font-size: 14px; font-weight: 700; letter-spacing: 0.05em; padding: 12px 30px; border: 1px solid #c8232c; border-radius: 4px; transition: all 0.2s ease-in-out;"
                        onmouseover="this.style.backgroundColor='#b01d24'; this.style.borderColor='#b01d24';"
                        onmouseout="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                    >
                        Add to Cart
                    </button>
                    
                    <a
                        href="bulk_inquiry.php?product_id=<?= $product['id'] ?>"
                        class="btn btn-lg btn-outline-dark text-uppercase ms-md-2"
                        style="font-size: 14px; font-weight: 600; letter-spacing: 0.05em; padding: 12px 25px; border-radius: 4px; transition: all 0.2s ease-in-out;"
                    >
                        Request Bulk Quote
                    </a>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function(){
                        const orderSelect = document.getElementById("orderUnitSelect");
                        const quantityLabel = document.getElementById("quantityLabel");

                        function updateLabel(){
                            if(!orderSelect) return;
                            if(orderSelect.value === "box"){
                                quantityLabel.innerText = "Number of Boxes";
                            }else{
                                quantityLabel.innerText = "Number of Pieces";
                            }
                        }

                        updateLabel();

                        if(orderSelect){
                            orderSelect.addEventListener("change", updateLabel);
                        }
                    });
                </script>

            </form>
            
        </div>
        
    </div>

    <hr class="mt-5 mb-5" style="border-color: #eeeeee;">
        
    <h4 class="mb-4 text-uppercase" style="font-family: 'Montserrat', sans-serif; font-size: 18px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 10px;">
        Customer Reviews
        <span style="position: absolute; bottom: 0; left: 0; width: 35px; height: 2px; background-color: #c8232c;"></span>
    </h4>
    
    <form action="submit_review.php" method="POST" class="mb-5" style="font-family: 'Montserrat', sans-serif; max-width: 700px;">
    
        <input
            type="hidden"
            name="product_id"
            value="<?= $product['id'] ?>"
        >
    
        <div class="form-group mb-3">
            <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Your Name</label>
            <input
                type="text"
                name="customer_name"
                class="form-control"
                required
                style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none;"
            >
        </div>
    
        <div class="form-group mb-3">
            <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Email</label>
            <input
                type="email"
                name="customer_email"
                class="form-control"
                required
                style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none;"
            >
        </div>
    
        <div class="form-group mb-3">
            <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Rating</label>
            <select
                name="rating"
                class="form-control"
                required
                style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 500; color: #333333; box-shadow: none;"
            >
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
        </div>
    
        <div class="form-group mb-4">
            <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Review</label>
            <textarea
                name="review"
                rows="5"
                class="form-control"
                required
                style="border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none; resize: vertical;"
            ></textarea>
        </div>
    
        <button 
            type="submit" 
            class="btn text-uppercase"
            style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 12px 28px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out;"
            onmouseover="this.style.backgroundColor='#333333'; this.style.borderColor='#333333';"
            onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
        >
            Submit Review
        </button>
    
    </form>

    <?php
    $reviewStmt = $pdo->prepare("
        SELECT *
        FROM product_reviews
        WHERE product_id = ?
        AND is_approved = 1
        ORDER BY id DESC
    ");
    $reviewStmt->execute([$product['id']]);
    $reviews = $reviewStmt->fetchAll();
    ?>

    <div style="font-family: 'Montserrat', sans-serif; max-width: 700px;">
        <?php if(empty($reviews)): ?>

            <div class="alert alert-neutral py-9 text-center" style="background-color: #f8f9fa; border: 1px solid #e4e6eb; color: #777777; font-size: 12px; border-radius: 9px; font-weight: 500;">
                No reviews yet for this item.
            </div>

        <?php else: ?>

            <?php foreach($reviews as $review): ?>

                <div class="p-3 mb-3" style="background-color: #ffffff; border: 1px solid #e4e6eb; border-radius: 4px;">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong style="font-size: 14px; font-weight: 600; color: #111111;">
                            <?= htmlspecialchars($review['customer_name']) ?>
                        </strong>
                        <span style="font-size: 14px; letter-spacing: 2px;">
                            <?= str_repeat('⭐', $review['rating']) ?>
                        </span>
                    </div>

                    <p class="mb-2" style="font-size: 14px; line-height: 1.6; color: #444444; font-weight: 400;">
                        <?= nl2br(htmlspecialchars($review['review'])) ?>
                    </p>

                    <small class="text-muted d-block" style="font-size: 12px; font-weight: 400; color: #888888 !important;">
                        <i class="fa-regular fa-calendar me-1" style="font-size: 11px;"></i> <?= date('d M Y', strtotime($review['created_at'])) ?>
                    </small>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</div>

<?php include 'includes/footer.php'; ?>