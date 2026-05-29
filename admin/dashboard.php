<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| TOTAL PRODUCTS
|--------------------------------------------------------------------------
*/

$productCount = $pdo->query("
    SELECT COUNT(*) FROM products
")->fetchColumn();

/*
|--------------------------------------------------------------------------
| TOTAL CATEGORIES
|--------------------------------------------------------------------------
*/

$categoryCount = $pdo->query("
    SELECT COUNT(*) FROM categories
")->fetchColumn();

/*
|--------------------------------------------------------------------------
| TOTAL ORDERS
|--------------------------------------------------------------------------
*/

$orderCount = $pdo->query("
    SELECT COUNT(*) FROM orders
")->fetchColumn();

/*
|--------------------------------------------------------------------------
| TOTAL REVENUE
|--------------------------------------------------------------------------
*/

$revenue = $pdo->query("
    SELECT SUM(grand_total) FROM orders
")->fetchColumn();

?>

<h2 class="mb-4">
    Dashboard
</h2>

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card-box">

            <h5>Total Products</h5>

            <h2>
                <?= $productCount ?>
            </h2>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card-box">

            <h5>Total Categories</h5>

            <h2>
                <?= $categoryCount ?>
            </h2>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card-box">

            <h5>Total Orders</h5>

            <h2>
                <?= $orderCount ?>
            </h2>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card-box">

            <h5>Total Revenue</h5>

            <h2>
                
            ₹<?= number_format($revenue ?? 0, 2) ?>
            </h2>

        </div>

    </div>

</div>

</div>

</body>
</html>