<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT products.*, categories.name AS category_name
    FROM products
    LEFT JOIN categories
    ON products.category_id = categories.id
    ORDER BY products.id DESC
");

$products = $stmt->fetchAll();

?>

<div class="container-fluid py-4">

    <!-- PAGE HEADER -->

    <div
        class="d-flex flex-wrap justify-content-between align-items-center mb-4"
    >

        <div>

            <h2
                class="mb-1"
                style="
                    font-weight: 700;
                "
            >
                Products
            </h2>

            <p class="text-muted mb-0">
                Manage all ecommerce products
            </p>

        </div>

        <a
            href="add_product.php"
            class="btn btn-dark px-4 py-2"
        >
            + Add Product
        </a>

    </div>

    <!-- CARD -->

    <div
        class="card border-0 shadow-sm"
        style="
            border-radius: 14px;
        "
    >

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table align-middle mb-0"
                >

                    <thead
                        style="
                            background: #f8f9fa;
                        "
                    >

                        <tr>

                            <th class="px-4 py-3">
                                ID
                            </th>

                            <th class="py-3">
                                Image
                            </th>

                            <th class="py-3">
                                Product
                            </th>

                            <th class="py-3">
                                Category
                            </th>

                            <th class="py-3">
                                Price
                            </th>

                            <th class="py-3">
                                Stock
                            </th>

                            <th class="text-center py-3">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($products as $product): ?>

                            <tr>

                                <!-- ID -->

                                <td class="px-4">

                                    <strong>
                                        #<?= $product['id'] ?>
                                    </strong>

                                </td>

                                <!-- IMAGE -->

                                <td width="110">

                                    <div
                                        style="
                                            width: 70px;
                                            height: 70px;
                                            overflow: hidden;
                                            border-radius: 10px;
                                            border: 1px solid #eee;
                                            background: #fff;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        "
                                    >

                                        <img
                                            src="../<?= htmlspecialchars($product['image']) ?>"
                                            class="product-thumb"
                                            alt="<?= htmlspecialchars($product['name']) ?>"
                                            style="
                                                width: 100%;
                                                height: 100%;
                                                object-fit: contain;
                                            "
                                        >

                                    </div>

                                </td>

                                <!-- PRODUCT NAME -->

                                <td>

                                    <div
                                        style="
                                            font-weight: 600;
                                            line-height: 1.5;
                                        "
                                    >

                                        <?= htmlspecialchars($product['name']) ?>

                                    </div>

                                    <?php if(!empty($product['sku'])): ?>

                                        <small class="text-muted">

                                            SKU:
                                            <?= htmlspecialchars($product['sku']) ?>

                                        </small>

                                    <?php endif; ?>

                                </td>

                                <!-- CATEGORY -->

                                <td>

                                    <span
                                        class="badge badge-light px-3 py-2"
                                        style="
                                            font-size: 13px;
                                        "
                                    >

                                        <?= htmlspecialchars($product['category_name']) ?>

                                    </span>

                                </td>

                                <!-- PRICE -->

                                <td>

                                    <strong
                                        style="
                                            font-size: 16px;
                                        "
                                    >

                                        ₹<?= number_format($product['price'], 2) ?>

                                    </strong>

                                </td>

                                <!-- STOCK -->

                                <td>

                                    <?php if($product['stock'] > 0): ?>

                                        <span
                                            class="badge badge-success px-3 py-2"
                                        >
                                            <?= $product['stock'] ?> In Stock
                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="badge badge-danger px-3 py-2"
                                        >
                                            Out of Stock
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- ACTIONS -->

                                <td class="text-center">

                                    <div
                                        class="d-flex justify-content-center flex-wrap"
                                        style="
                                            gap: 8px;
                                        "
                                    >

                                        <a
                                            href="edit_product.php?id=<?= $product['id'] ?>"
                                            class="btn btn-sm btn-primary px-3"
                                        >
                                            Edit
                                        </a>

                                        <a
                                            href="delete_product.php?id=<?= $product['id'] ?>"
                                            class="btn btn-sm btn-danger px-3"
                                            onclick="return confirm('Delete this product?')"
                                        >
                                            Delete
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>