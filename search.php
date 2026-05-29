<?php

require 'includes/db.php';
include 'includes/header.php';

$q =
    trim($_GET['q'] ?? '');

$categorySlug =
    trim($_GET['category'] ?? '');

$sql = "
    SELECT products.*
    FROM products
    LEFT JOIN categories
    ON products.category_id = categories.id
    WHERE (
        products.name LIKE :search
        OR products.sku LIKE :search
    )
";

$params = [

    ':search' => "%{$q}%"

];

if(!empty($categorySlug)){

    $sql .= "
        AND categories.slug = :category
    ";

    $params[':category'] =
        $categorySlug;
}

$sql .= "
    ORDER BY products.id DESC
";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$products = $stmt->fetchAll();

?>

<div class="container pt-5 pb-5">

    <h2 class="mb-5">

        Search Results for:
        "<?= htmlspecialchars($q) ?>"

    </h2>

    <?php if(empty($products)): ?>

        <div class="alert alert-warning">

            No products found.

        </div>

    <?php else: ?>

        <div class="row">

            <?php foreach($products as $product): ?>

                <div class="col-md-3 mb-4">

                    <div class="latest-image-box p-3 border h-100">

                        <a
                            href="product/<?= urlencode($product['slug']) ?>"
                        >

                            <img
                                src="<?= htmlspecialchars($product['image']) ?>"
                                class="img-fluid mb-3"
                                style="
                                    height:220px;
                                    width:100%;
                                    object-fit:contain;
                                "
                            >

                        </a>

                        <h6>

                            <a
                                href="product/<?= urlencode($product['slug']) ?>"
                                class="txt-org"
                            >
                                <?= htmlspecialchars($product['name']) ?>
                            </a>

                        </h6>

                        <p class="txt-org sb">

                            ₹<?= number_format($product['price'], 2) ?>

                        </p>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>