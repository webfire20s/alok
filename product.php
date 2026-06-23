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
?>

<div class="container pt-5 pb-5">

    <div class="row align-items-center">

        <div class="col-md-6 mb-4 text-center">
            <div style="background: #ffffff; border: 1px solid #eeeeee; padding: 20px; transition: border-color 0.3s ease;">
                <img
                    src="<?= htmlspecialchars($product['image']) ?>"
                    class="img-fluid"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    style="max-height: 480px; width: auto; object-fit: contain; vertical-align: middle;"
                >
            </div>
        </div>

        <div class="col-md-6">
            <?php
            $ratingStmt = $pdo->prepare("
                SELECT
                    COUNT(*) AS total_reviews,
                    AVG(rating) AS avg_rating
                FROM product_reviews
                WHERE product_id = ?
                AND is_approved = 1
            ");

            $ratingStmt->execute([$product['id']]);
            $ratingData = $ratingStmt->fetch();

            $totalReviews = (int)($ratingData['total_reviews'] ?? 0);
            $avgRating = round($ratingData['avg_rating'] ?? 0, 1);
            ?>

            <?php if($totalReviews > 0): ?>

                <div class="mb-4">
                    <div
                        style="
                            font-family: 'Montserrat', sans-serif;
                            font-size: 18px;
                            color: #f1b434; /* Balanced corporate gold/amber */
                            line-height: 1;
                            display: flex;
                            align-items: center;
                            gap: 4px;
                        "
                    >
                        <span>
                            <?php
                            $fullStars = floor($avgRating);
                            for($i=1; $i<=5; $i++):
                                if($i <= $fullStars):
                                    echo '★';
                                else:
                                    echo '☆';
                                endif;
                            endfor;
                            ?>
                        </span>

                        <span
                            style="
                                color: #666666;
                                font-size: 14px;
                                font-weight: 500;
                                margin-left: 6px;
                                letter-spacing: 0.02em;
                            "
                        >
                            <strong style="color: #111111;"><?= $avgRating ?></strong> 
                            (<?= $totalReviews ?> <?= $totalReviews === 1 ? 'Review' : 'Reviews' ?>)
                        </span>
                    </div>
                </div>

            <?php endif; ?>
            

            <h2 class="mb-3 text-uppercase" style="font-family: 'Montserrat', sans-serif; font-size: 28px; font-weight: 700; color: #111111; letter-spacing: -0.01em; line-height: 1.3;">
                <?= htmlspecialchars($product['name']) ?>
            </h2>

            <h3 class="mb-4" style="font-family: 'Montserrat', sans-serif; font-size: 24px; font-weight: 700; color: #111111; letter-spacing: -0.02em;">
                ₹<?= number_format($product['price'], 2) ?>
            </h3>

            <p class="mb-4 text-muted" style="font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.7; color: #555555 !important; font-weight: 400;">
                <?= nl2br(htmlspecialchars($product['short_description'])) ?>
            </p>

            <div class="mb-3" style="font-family: 'Montserrat', sans-serif; font-size: 14px; color: #333333;">
                <strong style="color: #111111; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; display: inline-block; width: 120px;">SKU:</strong>
                <span style="font-weight: 400; color: #666666;"><?= htmlspecialchars($product['sku']) ?></span>
            </div>

            <div class="mb-4" style="font-family: 'Montserrat', sans-serif; font-size: 14px; color: #333333;">
                <strong style="color: #111111; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; display: inline-block; width: 120px;">Availability:</strong>
                <?php if($product['stock'] > 0): ?>
                    <span class="text-success" style="font-weight: 600; letter-spacing: 0.02em;">
                        In Stock
                    </span>
                <?php else: ?>
                    <span class="text-danger" style="font-weight: 600; letter-spacing: 0.02em;">
                        Out of Stock
                    </span>
                <?php endif; ?>
            </div>

            <form action="add-to-cart.php" method="POST" style="font-family: 'Montserrat', sans-serif;">

                <input
                    type="hidden"
                    name="product_id"
                    value="<?= $product['id'] ?>"
                >

                <div class="mb-4">

                    <label class="d-block mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em;">
                        Purchase Type
                    </label>

                    <?php if($product['selling_type'] == 'both'): ?>

                        <select
                            name="order_unit"
                            class="form-control"
                            id="orderUnitSelect"
                            style="height: 46px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 500; color: #333333; box-shadow: none;"
                        >
                            <option value="piece">Buy Individual Pieces</option>
                            <option value="box">Buy Full Boxes</option>
                        </select>

                        <?php if($product['pieces_per_box']): ?>
                            <small class="text-muted d-block mt-2" style="font-size: 13px; font-weight: 400;">
                                <i class="fa-solid fa-box-open text-secondary me-1"></i> 1 Box = <?= $product['pieces_per_box'] ?> Pieces
                            </small>
                        <?php endif; ?>

                    <?php elseif($product['selling_type'] == 'box'): ?>

                        <input
                            type="hidden"
                            name="order_unit"
                            value="box"
                        >

                        <div class="alert alert-neutral" style="background-color: #f8f9fa; border: 1px solid #e4e6eb; color: #333333; font-size: 14px; border-radius: 4px; padding: 22px 265px;">
                            <strong style="color: #111111; font-weight: 600;">This product is sold only in boxes.</strong>
                            <?php if($product['pieces_per_box']): ?>
                                <div class="text-muted mt-1" style="font-size: 13px;">1 Box = <?= $product['pieces_per_box'] ?> Pieces</div>
                            <?php endif; ?>
                        </div>

                    <?php else: ?>

                        <input
                            type="hidden"
                            name="order_unit"
                            value="piece"
                        >

                        <div class="alert alert-neutral" style="background-color: #f8f9fa; border: 1px solid #e4e6eb; color: #555555; font-size: 14px; border-radius: 4px; padding: 12px 15px; font-weight: 500;">
                            Sold individually per piece.
                        </div>

                    <?php endif; ?>

                </div>

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