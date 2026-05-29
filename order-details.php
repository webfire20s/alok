<?php

session_start();

require 'includes/db.php';

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit;

}

include 'includes/header.php';

$orderId = (int)($_GET['id'] ?? 0);

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| ORDER
|--------------------------------------------------------------------------
*/

$orderStmt = $pdo->prepare("
    SELECT *
    FROM orders
    WHERE id = ?
    AND user_id = ?
");

$orderStmt->execute([
    $orderId,
    $userId
]);

$order = $orderStmt->fetch();

if(!$order){

    die("Order not found");

}

/*
|--------------------------------------------------------------------------
| ITEMS
|--------------------------------------------------------------------------
*/

$itemStmt = $pdo->prepare("
    SELECT *
    FROM order_items
    WHERE order_id = ?
");

$itemStmt->execute([$orderId]);

$items = $itemStmt->fetchAll();

?>

<div class="container pt-5 pb-5">

    <div class="mb-4">

        <a
            href="my-account.php"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <h3 class="mb-3">

                        Order:
                        <?= htmlspecialchars($order['order_number']) ?>

                    </h3>

                    <p>

                        <strong>Status:</strong>

                        <?= ucfirst($order['order_status']) ?>

                    </p>

                    <p>

                        <strong>Payment:</strong>

                        <?= ucfirst($order['payment_method']) ?>

                    </p>

                </div>

                <div class="col-md-6 text-md-right">

                    <h4>

                        ₹<?= number_format(
                            $order['grand_total'],
                            2
                        ) ?>

                    </h4>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <h4 class="mb-4">
                Ordered Products
            </h4>

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>

                        <tr>

                            <th>Image</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Type</th>
                            <th>GST</th>
                            <th>Shipping</th>
                            <th>Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($items as $item): ?>

                            <tr>

                                <td width="120">

                                    <img
                                        src="<?= htmlspecialchars($item['product_image']) ?>"
                                        class="img-fluid"
                                    >

                                </td>

                                <td>

                                    <?= htmlspecialchars(
                                        $item['product_name']
                                    ) ?>

                                </td>

                                <td>

                                    <?= $item['quantity'] ?>

                                </td>

                                <td>

                                    <?= ucfirst(
                                        $item['order_unit']
                                    ) ?>

                                </td>

                                <td>

                                    <?= $item['gst_percent'] ?>%

                                </td>

                                <td>

                                    ₹<?= number_format($order['shipping_charge'], 2) ?>

                                </td>
                                <td>

                                    ₹<?= number_format(
                                        $item['line_total'],
                                        2
                                    ) ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>