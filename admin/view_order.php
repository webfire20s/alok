<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$orderId = (int)($_GET['id'] ?? 0);

/*
|--------------------------------------------------------------------------
| ORDER
|--------------------------------------------------------------------------
*/

$orderStmt = $pdo->prepare("
    SELECT *
    FROM orders
    WHERE id = ?
");

$orderStmt->execute([$orderId]);

$order = $orderStmt->fetch();

if(!$order){

    die("Order not found");

}

/*
|--------------------------------------------------------------------------
| ORDER ITEMS
|--------------------------------------------------------------------------
*/

$itemStmt = $pdo->prepare("
    SELECT *
    FROM order_items
    WHERE order_id = ?
");

$itemStmt->execute([$orderId]);

$items = $itemStmt->fetchAll();

/*
|--------------------------------------------------------------------------
| UPDATE STATUS
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $status =
        $_POST['order_status'];

    $updateStmt = $pdo->prepare("
        UPDATE orders
        SET order_status = ?
        WHERE id = ?
    ");

    $updateStmt->execute([
        $status,
        $orderId
    ]);

    header("Location: view_order.php?id=" . $orderId);
    exit;
}

?>

<h2 class="mb-4">
    Order #<?= $order['id'] ?>
</h2>

<a
    href="../invoice.php?order=<?= $order['id'] ?>"
    target="_blank"
    class="btn btn-dark mb-4"
>
    Download Invoice
</a>
<div class="row">

    <div class="col-md-8">

        <div class="card-box p-4 mb-4">

            <h4 class="mb-4">
                Customer Details
            </h4>

            <p>
                <strong>Name:</strong>
                <?= htmlspecialchars($order['customer_name']) ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?= htmlspecialchars($order['email'] ?? '') ?>
            </p>

            <p>
                <strong>Phone:</strong>
                <?= htmlspecialchars($order['phone'] ?? '') ?>
            </p>

            <p>
                <strong>Address:</strong>
                <?= nl2br(htmlspecialchars($order['address'] ?? '')) ?>
            </p>

            <p>
                <strong>City:</strong>
                <?= htmlspecialchars($order['city'] ?? '') ?>
            </p>

            <p>
                <strong>State:</strong>
                <?= htmlspecialchars($order['state'] ?? '') ?>
            </p>

            <p>
                <strong>Pincode:</strong>
                <?= htmlspecialchars($order['pincode'] ?? '') ?>
            </p>

        </div>

        <div class="card-box p-4">

            <h4 class="mb-4">
                Order Items
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
                            <th>Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($items as $item): ?>

                            <tr>

                                <td width="100">

                                    <?php

                                    $imagePath = $item['product_image'] ?? '';

                                    if(
                                        $imagePath &&
                                        !str_contains($imagePath, 'storage/')
                                    ){
                                        $imagePath =
                                            'storage/media/' . $imagePath;
                                    }

                                    ?>

                                    <img
                                        src="../<?= htmlspecialchars($imagePath) ?>"
                                        class="img-fluid rounded"
                                        style="
                                            width:80px;
                                            height:80px;
                                            object-fit:cover;
                                        "
                                    >

                                </td>

                                <td>

                                    <?= htmlspecialchars($item['product_name'] ?? '') ?>

                                </td>

                                <td>

                                    <?= $item['quantity'] ?>

                                </td>

                                <td>

                                    <?= ucfirst($item['purchase_type'] ?? '') ?>

                                </td>

                                <td>

                                    <?= $item['gst_percent'] ?>%

                                </td>

                                <td>

                                   <?php

                                    $itemSubtotal =
                                        $item['price'] * $item['quantity'];

                                    $itemGST =
                                        ($itemSubtotal * $item['gst_percent']) / 100;

                                    $itemTotal =
                                        $itemSubtotal + $itemGST;

                                    ?>

                                    ₹<?= number_format($itemTotal, 2) ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card-box p-4">

            <h4 class="mb-4">
                Order Summary
            </h4>

            <p>

                <strong>Subtotal:</strong><br>

                ₹<?= number_format($order['subtotal'], 2) ?>

            </p>

            <p>

                <strong>GST:</strong><br>

                ₹<?= number_format($order['gst_total'], 2) ?>

            </p>

            <p>

                <strong>Grand Total:</strong><br>

                ₹<?= number_format($order['grand_total'], 2) ?>

            </p>

            <hr>

            <form method="POST">

                <div class="form-group">

                    <label>
                        Order Status
                    </label>

                    <select
                        name="order_status"
                        class="form-control"
                    >

                        <?php

                        $statuses = [
                            'pending',
                            'confirmed',
                            'packed',
                            'shipped',
                            'delivered',
                            'cancelled'
                        ];

                        foreach($statuses as $status):

                        ?>

                            <option
                                value="<?= $status ?>"
                                <?= $order['order_status'] == $status ? 'selected' : '' ?>
                            >

                                <?= ucfirst($status) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <button class="btn btn-dark btn-block">

                    Update Status

                </button>

            </form>

        </div>

    </div>

</div>

</div>

</body>
</html>