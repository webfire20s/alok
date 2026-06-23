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

    <h2 class="mb-5 text-uppercase" style="font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 14px;">
        <?= htmlspecialchars($category['name']) ?>
        <span style="position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background-color: #c8232c;"></span>
    </h2>

    <div class="row">

        <?php if(count($products) > 0): ?>

            <?php foreach($products as $product): ?>

                <div class="col-6 col-md-3 mb-4 d-flex align-items-stretch">

                    <div class="latest-image-box w-100" style="display: flex; flex-direction: column; background: #ffffff; padding: 12px; border: 1px solid #eeeeee; transition: all 0.3s ease;">

                        <a href="product/<?= urlencode($product['slug']) ?>" class="d-block overflow-hidden text-center" style="background: #fdfdfd;">
                            <img
                                src="storage/media/<?= basename($product['image']) ?>"
                                class="img-fluid"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                style="max-height: 240px; width: auto; object-fit: contain; transition: transform 0.3s ease; vertical-align: middle;"
                                onmouseover="this.style.transform='scale(1.03)'"
                                onmouseout="this.style.transform='scale(1.0)'"
                            >
                        </a>

                        <div class="mt-3" style="flex-grow: 1;">
                            <a href="product/<?= urlencode($product['slug']) ?>" style="font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; color: #333333; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 42px; line-height: 1.5; transition: color 0.2s ease;" onmouseover="this.style.color='#c8232c'" onmouseout="this.style.color='#333333'">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                        </div>

                        <p class="txt-org sb mt-2 mb-0" style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 16px; color: #111111; letter-spacing: -0.02em;">
                            ₹<?= number_format($product['price'], 2) ?>
                        </p>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="col-12 text-center py-5">
                <h4 style="font-family: 'Montserrat', sans-serif; font-weight: 500; color: #888888; font-size: 16px; letter-spacing: 0.5px;">No products found in this category.</h4>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>