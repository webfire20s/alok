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

</div>

<?php include 'includes/footer.php'; ?>