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

        <div class="col-md-6 mb-4">

            <img
                src="<?= htmlspecialchars($product['image']) ?>"
                class="img-fluid shadow rounded"
                alt="<?= htmlspecialchars($product['name']) ?>"
            >

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

            $totalReviews =
            (int)($ratingData['total_reviews'] ?? 0);

            $avgRating =
            round($ratingData['avg_rating'] ?? 0, 1);

            ?>
            <?php if($totalReviews > 0): ?>

                <div class="mb-3">

                    <div
                        style="
                            font-size:20px;
                            color:#f5b301;
                            line-height:1;
                        "
                    >

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

                        <span
                            style="
                                color:#222;
                                font-size:15px;
                                margin-left:8px;
                                vertical-align:middle;
                            "
                        >

                            <?= $avgRating ?>

                            (<?= $totalReviews ?> Reviews)

                        </span>

                    </div>

                </div>

            <?php endif; ?>

            <h2 class="mb-3">
                <?= htmlspecialchars($product['name']) ?>
            </h2>

            <h3 class="txt-org mb-4">
                ₹<?= number_format($product['price'], 2) ?>
            </h3>

            <p class="mb-4 text-muted">

                <?= nl2br(htmlspecialchars($product['short_description'])) ?>

            </p>

            <div class="mb-4">

                <strong>SKU:</strong>
                <?= htmlspecialchars($product['sku']) ?>

            </div>

            <div class="mb-4">

                <strong>Availability:</strong>

                <?php if($product['stock'] > 0): ?>

                    <span class="text-success">
                        In Stock
                    </span>

                <?php else: ?>

                    <span class="text-danger">
                        Out of Stock
                    </span>

                <?php endif; ?>

            </div>

            <form action="add-to-cart.php" method="POST">

                <input
                    type="hidden"
                    name="product_id"
                    value="<?= $product['id'] ?>"
                >

                <!-- SELLING TYPE -->

                <!-- SELLING TYPE -->

                <div class="mb-4">

                    <label class="font-weight-bold d-block mb-2">
                        Purchase Type
                    </label>

                    <?php if($product['selling_type'] == 'both'): ?>

                        <select
                            name="order_unit"
                            class="form-control"
                            id="orderUnitSelect"
                        >
                            <option value="piece">
                                Buy Individual Pieces
                            </option>

                            <option value="box">
                                Buy Full Boxes
                            </option>
                        </select>

                        <?php if($product['pieces_per_box']): ?>

                            <small class="text-muted d-block mt-2">

                                1 Box =
                                <?= $product['pieces_per_box'] ?>
                                Pieces

                            </small>

                        <?php endif; ?>

                    <?php elseif($product['selling_type'] == 'box'): ?>

                        <input
                            type="hidden"
                            name="order_unit"
                            value="box"
                        >

                        <div class="alert alert-info">

                            <strong>
                                This product is sold only in boxes.
                            </strong>

                            <?php if($product['pieces_per_box']): ?>

                                <br>

                                1 Box =
                                <?= $product['pieces_per_box'] ?>
                                Pieces

                            <?php endif; ?>

                        </div>

                    <?php else: ?>

                        <input
                            type="hidden"
                            name="order_unit"
                            value="piece"
                        >

                        <div class="alert alert-secondary">

                            Sold individually per piece.

                        </div>

                    <?php endif; ?>

                </div>

                <!-- QUANTITY -->

                <div class="mb-3">

                    <label
                        class="font-weight-bold"
                        id="quantityLabel"
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
                    >

                </div>

                <!-- GST -->

                <p class="mb-3">

                    GST:
                    <?= $product['gst_percent'] ?>%

                </p>

                <!-- MOQ -->

                <p class="mb-4">

                    Minimum Order Quantity:
                    <?= $product['min_order_qty'] ?>

                </p>

                <button
                    type="submit"
                    class="btn btn-org btn-lg"
                >
                    Add to Cart
                </button>
                <a
                    href="bulk_inquiry.php?product_id=<?= $product['id'] ?>"
                    class="btn btn-outline-dark btn-lg ml-2"
                >
                    Request Bulk Quote
                </a>
                <script>

                    document.addEventListener("DOMContentLoaded", function(){

                        const orderSelect =
                            document.getElementById("orderUnitSelect");

                        const quantityLabel =
                            document.getElementById("quantityLabel");

                        function updateLabel(){

                            if(!orderSelect) return;

                            if(orderSelect.value === "box"){

                                quantityLabel.innerText =
                                    "Number of Boxes";

                            }else{

                                quantityLabel.innerText =
                                "Number of Pieces";
                                
                            }
                        }

                        updateLabel();

                        if(orderSelect){

                            orderSelect.addEventListener(
                                "change",
                                updateLabel
                            );

                        }

                    });

                    </script>

            </form>
            
            

        </div>
        


    </div>
    <hr class="mt-5 mb-5">
            
    <h4 class="mb-4">
        Customer Reviews
    </h4>
    
    <form action="submit_review.php" method="POST" class="mb-5">
    
        <input
            type="hidden"
            name="product_id"
            value="<?= $product['id'] ?>"
        >
    
        <div class="form-group">
    
            <label>Your Name</label>
    
            <input
                type="text"
                name="customer_name"
                class="form-control"
                required
            >
    
        </div>
    
        <div class="form-group">
    
            <label>Email</label>
    
            <input
                type="email"
                name="customer_email"
                class="form-control"
                required
            >
    
        </div>
    
        <div class="form-group">
    
            <label>Rating</label>
    
            <select
                name="rating"
                class="form-control"
                required
            >
    
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
    
            </select>
    
        </div>
    
        <div class="form-group">
    
            <label>Review</label>
    
            <textarea
                name="review"
                rows="5"
                class="form-control"
                required
            ></textarea>
    
        </div>
    
        <button class="btn btn-org">
    
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

    <?php if(empty($reviews)): ?>

        <div class="alert alert-light">

            No reviews yet.

        </div>

    <?php else: ?>

        <?php foreach($reviews as $review): ?>

            <div class="border rounded p-3 mb-3">

                <div class="d-flex justify-content-between mb-2">

                    <strong>

                        <?= htmlspecialchars($review['customer_name']) ?>

                    </strong>

                    <span>

                        <?= str_repeat('⭐', $review['rating']) ?>

                    </span>

                </div>

                <p class="mb-2">

                    <?= nl2br(htmlspecialchars($review['review'])) ?>

                </p>

                <small class="text-muted">

                    <?= date(
                        'd M Y',
                        strtotime($review['created_at'])
                    ) ?>

                </small>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>