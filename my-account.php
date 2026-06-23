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

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif;">

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                <div class="card-body p-4">

                    <h4 class="text-uppercase mb-4" style="font-size: 15px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 10px;">
                        My Account
                        <span style="position: absolute; bottom: 0; left: 0; width: 30px; height: 2px; background-color: #c8232c;"></span>
                    </h4>

                    <ul class="list-unstyled mb-0" style="font-size: 13px;">

                        <li style="border-bottom: 1px solid #eeeeee;">
                            <a href="my-account.php" class="d-block py-2" style="color: #111111; font-weight: 600; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#c8232c'" onmouseout="this.style.color='#111111'">
                                Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="logout.php" class="d-block py-2" style="color: #777777; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#c8232c'" onmouseout="this.style.color='#777777'">
                                Logout
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <div class="col-md-9">

            <div class="card mb-4" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                <div class="card-body p-4 p-md-5">

                    <h4 class="text-uppercase mb-4" style="font-size: 16px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 12px;">
                        Profile Details
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background-color: #c8232c;"></span>
                    </h4>

                    <div class="row pt-2" style="font-size: 14px;">

                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span style="font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em; margin-bottom: 4px;">Name:</span>
                            <span style="color: #111111; font-weight: 500; border-bottom: 1px dashed #eeeeee; padding-bottom: 8px;"><?= htmlspecialchars($user['full_name']) ?></span>
                        </div>

                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span style="font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em; margin-bottom: 4px;">Email:</span>
                            <span style="color: #111111; font-weight: 500; border-bottom: 1px dashed #eeeeee; padding-bottom: 8px;"><?= htmlspecialchars($user['email']) ?></span>
                        </div>

                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span style="font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em; margin-bottom: 4px;">Phone:</span>
                            <span style="color: #111111; font-weight: 500; border-bottom: 1px dashed #eeeeee; padding-bottom: 8px;"><?= htmlspecialchars($user['phone']) ?></span>
                        </div>

                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <span style="font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em; margin-bottom: 4px;">Account Created:</span>
                            <span style="color: #111111; font-weight: 500; border-bottom: 1px dashed #eeeeee; padding-bottom: 8px;"><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                <div class="card-body p-4 p-md-5">

                    <h4 class="text-uppercase mb-4" style="font-size: 16px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 12px;">
                        My Orders
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background-color: #c8232c;"></span>
                    </h4>

                    <?php if(empty($orders)): ?>
                        
                        <div class="alert py-3 px-4 mb-0" style="background-color: #fffdf0; border-left: 4px solid #f0ad4e; border-top: 1px solid #faebcc; border-right: 1px solid #faebcc; border-bottom: 1px solid #faebcc; color: #8a6d3b; font-size: 14px; font-weight: 500; border-radius: 4px;">
                            No orders found.
                        </div>

                    <?php else: ?>

                        <div class="table-responsive" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff;">
                            <table class="table align-middle mb-0" style="font-size: 13px; color: #333333;">
                                
                                <thead>
                                    <tr style="background-color: #111111; color: #ffffff;">
                                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Order No</th>
                                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Date</th>
                                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Status</th>
                                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Shipping</th>
                                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Total</th>
                                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px; text-align: right;" width="220">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($orders as $order): ?>
                                        <tr style="border-bottom: 1px solid #eeeeee;">
                                            
                                            <td style="padding: 16px; font-weight: 700; color: #111111;">
                                                <?= htmlspecialchars($order['order_number']) ?>
                                            </td>
                                            
                                            <td style="padding: 16px; font-weight: 500; color: #555555;">
                                                <?= date('d M Y', strtotime($order['created_at'])) ?>
                                            </td>
                                            
                                            <td style="padding: 16px;">
                                                <span class="badge text-uppercase" style="background-color: #f4f6f8; color: #111111; border: 1px solid #cccccc; font-size: 10px; font-weight: 700; letter-spacing: 0.03em; padding: 5px 10px; border-radius: 4px;">
                                                    <?= htmlspecialchars(ucfirst($order['order_status'])) ?>
                                                </span>
                                            </td>

                                            <td style="padding: 16px; font-weight: 500; color: #555555;">
                                                ₹<?= number_format($order['shipping_charge'], 2) ?>
                                            </td>

                                            <td style="padding: 16px; font-weight: 700; color: #111111;">
                                                ₹<?= number_format($order['grand_total'], 2) ?>
                                            </td>
                                            
                                            <td style="padding: 16px; text-align: right;">
                                                
                                                <a href="order-details.php?id=<?= $order['id'] ?>" class="btn text-uppercase mr-2" style="background-color: #111111; color: #ffffff; font-size: 11px; font-weight: 700; padding: 6px 14px; border-radius: 4px; letter-spacing: 0.05em; transition: all 0.2s ease-in-out; text-decoration: none; display: inline-block;" onmouseover="this.style.backgroundColor='#c8232c';" onmouseout="this.style.backgroundColor='#111111';">
                                                    View
                                                </a>

                                                <a href="invoice.php?order=<?= $order['id'] ?>" target="_blank" class="btn text-uppercase" style="background-color: transparent; border: 1px solid #111111; color: #111111; font-size: 11px; font-weight: 700; padding: 6px 14px; border-radius: 4px; letter-spacing: 0.05em; transition: all 0.2s ease-in-out; text-decoration: none; display: inline-block;" onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#111111'; this.style.color='#111111';">
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