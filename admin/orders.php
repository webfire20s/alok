<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT *
    FROM orders
    ORDER BY id DESC
");

$orders = $stmt->fetchAll();

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="mb-0">
        Orders
    </h2>

</div>

<div class="card-box p-4">

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="thead-dark">

                <tr>

                    <th>ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($orders as $order): ?>

                    <tr>

                        <td>
                            #<?= $order['id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($order['customer_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($order['phone'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($order['city'] ?? '') ?>
                        </td>

                        <td>

                            ₹<?= number_format($order['grand_total'], 2) ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($order['payment_method']) ?>

                        </td>

                        <td>

                            <?php

                            $status =
                                strtolower($order['order_status']);

                            ?>

                            <span class="badge badge-<?=
                                $status == 'pending' ? 'warning' :
                                ($status == 'confirmed' ? 'info' :
                                ($status == 'shipped' ? 'primary' :
                                ($status == 'delivered' ? 'success' :
                                'danger')))
                            ?> p-2">

                                <?= ucfirst($order['order_status']) ?>

                            </span>

                        </td>

                        <td>

                            <?= date(
                                "d M Y",
                                strtotime($order['created_at'])
                            ) ?>

                        </td>

                        <td>

                            <a
                                href="view_order.php?id=<?= $order['id'] ?>"
                                class="btn btn-sm btn-dark"
                            >
                                View
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</div>

</body>
</html>