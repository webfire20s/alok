<?php

session_start();

require 'includes/db.php';

/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit;

}

include 'includes/header.php';

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

$userId = $_SESSION['user_id'];

$userStmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$userStmt->execute([$userId]);

$user = $userStmt->fetch();

/*
|--------------------------------------------------------------------------
| ORDERS
|--------------------------------------------------------------------------
*/

$orderStmt = $pdo->prepare("
    SELECT *
    FROM orders
    WHERE user_id = ?
    ORDER BY id DESC
");

$orderStmt->execute([$userId]);

$orders = $orderStmt->fetchAll();

?>

<div class="container pt-5 pb-5">

    <div class="row">

        <!-- SIDEBAR -->

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h4 class="mb-4">
                        My Account
                    </h4>

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">

                            <a href="my-account.php">

                                Dashboard

                            </a>

                        </li>

                        <li class="list-group-item">

                            <a href="logout.php">

                                Logout

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- CONTENT -->

        <div class="col-md-9">

            <!-- PROFILE -->

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-body">

                    <h4 class="mb-4">
                        Profile Details
                    </h4>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <strong>Name:</strong>

                            <br>

                            <?= htmlspecialchars($user['full_name']) ?>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Email:</strong>

                            <br>

                            <?= htmlspecialchars($user['email']) ?>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Phone:</strong>

                            <br>

                            <?= htmlspecialchars($user['phone']) ?>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Account Created:</strong>

                            <br>

                            <?= date(
                                'd M Y',
                                strtotime($user['created_at'])
                            ) ?>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ORDERS -->

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h4 class="mb-4">
                        My Orders
                    </h4>

                    <?php if(empty($orders)): ?>

                        <div class="alert alert-warning">

                            No orders found.

                        </div>

                    <?php else: ?>

                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <thead>

                                    <tr>

                                        <th>Order No</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Shipping</th>
                                        <th>Total</th>
                                        <th width="220">Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach($orders as $order): ?>

                                        <tr>

                                            <td>

                                                <?= htmlspecialchars(
                                                    $order['order_number']
                                                ) ?>

                                            </td>

                                            <td>

                                                <?= date(
                                                    'd M Y',
                                                    strtotime($order['created_at'])
                                                ) ?>

                                            </td>

                                            <td>

                                                <span class="badge badge-info p-2">

                                                    <?= ucfirst(
                                                        $order['order_status']
                                                    ) ?>

                                                </span>

                                            </td>
                                            <td>

                                                ₹<?= number_format($order['shipping_charge'], 2) ?>

                                            </td>


                                            <td>

                                                <a
                                                    href="order-details.php?id=<?= $order['id'] ?>"
                                                    class="btn btn-sm btn-dark mr-2"
                                                >
                                                    View
                                                </a>

                                                <a
                                                    href="invoice.php?order=<?= $order['id'] ?>"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-primary"
                                                >
                                                    Invoice
                                                </a>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>