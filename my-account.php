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

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif; background-color: #fafafa; border-radius: 16px;">

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dash-animate-fade {
            animation: fadeInUp 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        .dash-card {
            border: 1px solid #eeeeee; 
            border-radius: 12px; 
            background-color: #ffffff; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        .dash-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-color: #e2e2e2;
        }
        .dash-sidebar-link {
            font-size: 13px;
            color: #555555; 
            font-weight: 600; 
            text-decoration: none; 
            transition: all 0.3s ease;
            display: block;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 4px;
        }
        .dash-sidebar-link:hover, .dash-sidebar-link.active {
            color: #c8232c;
            background-color: rgba(200, 35, 44, 0.04);
            padding-left: 22px;
            text-decoration: none;
        }
        .dash-title {
            font-size: 16px; 
            font-weight: 800; 
            color: #111111; 
            letter-spacing: 0.06em; 
            position: relative; 
            padding-bottom: 12px;
        }
        .dash-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 3px;
            background: linear-gradient(90deg, #c8232c, #e0535a);
            border-radius: 2px;
        }
        .profile-field-label {
            font-weight: 700; 
            text-transform: uppercase; 
            font-size: 11px; 
            color: #888888; 
            letter-spacing: 0.08em; 
            margin-bottom: 6px;
        }
        .profile-field-value {
            color: #111111; 
            font-weight: 500; 
            border-bottom: 1px dashed #e5e5e5; 
            padding-bottom: 10px;
            font-size: 14px;
        }
        .dash-table-container {
            border: 1px solid #eeeeee; 
            border-radius: 8px; 
            background-color: #ffffff;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.01);
        }
        .dash-table th {
            background-color: #111111; 
            color: #ffffff;
            padding: 16px; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 0.08em; 
            border: 0; 
            font-size: 11px;
        }
        .dash-table td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f5f5f5;
        }
        .dash-table tr:last-child td {
            border-bottom: 0;
        }
        .btn-dash-action {
            font-size: 11px; 
            font-weight: 700; 
            padding: 8px 16px; 
            border-radius: 6px; 
            letter-spacing: 0.05em; 
            transition: all 0.2s ease-in-out; 
            text-decoration: none; 
            display: inline-block;
        }
        .btn-dash-primary {
            background-color: #111111; 
            color: #ffffff;
            border: 1px solid #111111;
        }
        .btn-dash-primary:hover {
            background-color: #c8232c;
            border-color: #c8232c;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(200, 35, 44, 0.2);
            text-decoration: none;
        }
        .btn-dash-outline {
            background-color: transparent; 
            border: 1px solid #222222; 
            color: #222222;
        }
        .btn-dash-outline:hover {
            background-color: #111111;
            color: #ffffff;
            border-color: #111111;
            text-decoration: none;
        }
    </style>

    <div class="row">

        <div class="col-md-3 mb-4 dash-animate-fade" style="animation-delay: 0.05s;">
            <div class="card dash-card">
                <div class="card-body p-4">
                    <h4 class="text-uppercase mb-4 dash-title" style="font-size: 14px;">
                        My Account
                    </h4>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="my-account.php" class="dash-sidebar-link active">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="logout.php" class="dash-sidebar-link" style="color: #999999;">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9 dash-animate-fade" style="animation-delay: 0.15s;">

            <div class="card dash-card mb-4">
                <div class="card-body p-4 p-md-5">
                    <h4 class="text-uppercase mb-4 dash-title">
                        Profile Details
                    </h4>
                    <div class="row pt-3">
                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span class="profile-field-label">Name:</span>
                            <span class="profile-field-value"><?= htmlspecialchars($user['full_name']) ?></span>
                        </div>
                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span class="profile-field-label">Email Address:</span>
                            <span class="profile-field-value"><?= htmlspecialchars($user['email']) ?></span>
                        </div>
                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span class="profile-field-label">Phone:</span>
                            <span class="profile-field-value"><?= htmlspecialchars($user['phone']) ?></span>
                        </div>
                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span class="profile-field-label">Account Created:</span>
                            <span class="profile-field-value"><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card dash-card">
                <div class="card-body p-4 p-md-5">
                    <h4 class="text-uppercase mb-4 dash-title">
                        My Orders
                    </h4>

                    <?php if(empty($orders)): ?>
                        <div class="alert py-3 px-4 mb-0" style="background-color: #fffdf0; border-left: 4px solid #f0ad4e; color: #8a6d3b; font-size: 14px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(240, 173, 78, 0.04);">
                            No orders found under this account profile registry index node.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive dash-table-container">
                            <table class="table dash-table align-middle mb-0" style="color: #444444;">
                                <thead>
                                    <tr>
                                        <th scope="col">Order No</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Shipping</th>
                                        <th scope="col">Total</th>
                                        <th scope="col" style="text-align: right;" width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td style="font-weight: 700; color: #111111; font-size: 13.5px;">
                                                <?= htmlspecialchars($order['order_number']) ?>
                                            </td>
                                            <td style="font-weight: 500; color: #666666; font-size: 13px;">
                                                <?= date('d M Y', strtotime($order['created_at'])) ?>
                                            </td>
                                            <td>
                                                <span class="badge text-uppercase" style="background-color: #f8f9fa; color: #111111; border: 1px solid #dddddd; font-size: 10px; font-weight: 700; letter-spacing: 0.05em; padding: 6px 12px; border-radius: 20px;">
                                                    <?= htmlspecialchars(ucfirst($order['order_status'])) ?>
                                                </span>
                                            </td>
                                            <td style="font-weight: 500; color: #666666; font-size: 13px;">
                                                ₹<?= number_format($order['shipping_charge'], 2) ?>
                                            </td>
                                            <td style="font-weight: 700; color: #111111; font-size: 13.5px;">
                                                ₹<?= number_format($order['grand_total'], 2) ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <div class="d-inline-flex gap-2">
                                                    <a href="order-details.php?id=<?= $order['id'] ?>" class="btn-dash-action btn-dash-primary me-2">
                                                        View
                                                    </a>
                                                    <a href="invoice.php?order=<?= $order['id'] ?>" target="_blank" class="btn-dash-action btn-dash-outline">
                                                        Invoice
                                                    </a>
                                                </div>
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