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

$productStmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE category_id = ?
");

$productStmt->execute([$category['id']]);

$products = $productStmt->fetchAll();

?>

<div class="container pt-5 pb-5">

    <h2 class="mb-5">
        <?= htmlspecialchars($category['name']) ?>
    </h2>

    <div class="row">

        <?php if(count($products) > 0): ?>

            <?php foreach($products as $product): ?>

                <div class="col-6 col-md-3 mb-4">

                    <div class="latest-image-box">

                        <a href="product/<?= urlencode($product['slug']) ?>">

                            <img
                                src="storage/media/<?= basename($product['image']) ?>"
                                class="img-fluid shadow"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                            >

                        </a>

                        <div class="mt-3">

                            <a href="product/<?= urlencode($product['slug']) ?>">

                                <?= htmlspecialchars($product['name']) ?>

                            </a>

                        </div>

                        <p class="txt-org sb mt-2">

                            ₹<?= number_format($product['price'], 2) ?>

                        </p>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="col-12 text-center">

                <h4>No products found.</h4>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>