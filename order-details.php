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

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif;">

    <div class="mb-4">
        <a 
            href="my-account.php" 
            class="btn text-uppercase"
            style="background-color: #ffffff; color: #111111; font-size: 12px; font-weight: 700; letter-spacing: 0.05em; padding: 10px 20px; border-radius: 4px; border: 1px solid #cccccc; transition: all 0.2s ease-in-out; box-shadow: none;"
            onmouseover="this.style.backgroundColor='#111111'; this.style.color='#ffffff'; this.style.borderColor='#111111';"
            onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#111111'; this.style.borderColor='#cccccc';"
        >
            &larr; Back
        </a>
    </div>

    <div class="card mb-4" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">
        <div class="card-body p-4">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <h3 class="text-uppercase mb-3" style="font-size: 18px; font-weight: 700; color: #111111; letter-spacing: 0.03em; position: relative; padding-bottom: 8px;">
                        Order: <?= htmlspecialchars($order['order_number']) ?>
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background-color: #c8232c;"></span>
                    </h3>
                    
                    <p class="mb-2" style="font-size: 14px; color: #555555; font-weight: 500;">
                        <strong style="color: #111111; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 0.03em; display: inline-block; width: 90px;">Status:</strong> 
                        <span class="px-2 py-1" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; font-weight: 600; font-size: 13px; color: #111111;">
                            <?= ucfirst($order['order_status']) ?>
                        </span>
                    </p>
                    
                    <p class="mb-0" style="font-size: 14px; color: #555555; font-weight: 500;">
                        <strong style="color: #111111; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 0.03em; display: inline-block; width: 90px;">Payment:</strong> 
                        <?= ucfirst($order['payment_method']) ?>
                    </p>
                </div>

                <div class="col-md-6 text-md-right mt-3 mt-md-0">
                    <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #777777; letter-spacing: 0.05em; margin-bottom: 2px;">Grand Total</div>
                    <h4 style="font-size: 24px; font-weight: 700; color: #c8232c; margin: 0;">
                        ₹<?= number_format($order['grand_total'], 2) ?>
                    </h4>
                </div>

            </div>
        </div>
    </div>

    <div class="card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">
        <div class="card-body p-4">

            <h4 class="text-uppercase mb-4" style="font-size: 15px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 10px;">
                Ordered Products
                <span style="position: absolute; bottom: 0; left: 0; width: 30px; height: 2px; background-color: #c8232c;"></span>
            </h4>

            <div class="table-responsive">
                <table class="table align-middle mb-0" style="border: 1px solid #eeeeee;">
                    
                    <thead>
                        <tr style="background-color: #fafdff; border-bottom: 2px solid #111111;">
                            <th class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #111111; letter-spacing: 0.05em; padding: 14px; border: 1px solid #eeeeee;">Image</th>
                            <th class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #111111; letter-spacing: 0.05em; padding: 14px; border: 1px solid #eeeeee;">Product</th>
                            <th class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #111111; letter-spacing: 0.05em; padding: 14px; border: 1px solid #eeeeee;">Qty</th>
                            <th class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #111111; letter-spacing: 0.05em; padding: 14px; border: 1px solid #eeeeee;">Type</th>
                            <th class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #111111; letter-spacing: 0.05em; padding: 14px; border: 1px solid #eeeeee;">GST</th>
                            <th class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #111111; letter-spacing: 0.05em; padding: 14px; border: 1px solid #eeeeee;">Shipping</th>
                            <th class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #111111; letter-spacing: 0.05em; padding: 14px; border: 1px solid #eeeeee;">Total</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($items as $item): ?>
                            <tr style="transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#fafafa';" onmouseout="this.style.backgroundColor='transparent';">
                                
                                <td width="120" style="padding: 12px; border: 1px solid #eeeeee; text-align: center; background-color: #ffffff;">
                                    <img 
                                        src="<?= htmlspecialchars($item['product_image']) ?>" 
                                        class="img-fluid" 
                                        style="max-height: 60px; object-fit: contain; border-radius: 2px;"
                                    >
                                </td>
                                
                                <td style="padding: 14px; border: 1px solid #eeeeee; font-size: 14px; font-weight: 600; color: #111111;">
                                    <?= htmlspecialchars($item['product_name']) ?>
                                </td>
                                
                                <td style="padding: 14px; border: 1px solid #eeeeee; font-size: 14px; font-weight: 500; color: #555555;">
                                    <?= $item['quantity'] ?>
                                </td>
                                
                                <td style="padding: 14px; border: 1px solid #eeeeee; font-size: 13px; font-weight: 500; color: #555555;">
                                    <?= ucfirst($item['order_unit']) ?>
                                </td>
                                
                                <td style="padding: 14px; border: 1px solid #eeeeee; font-size: 14px; font-weight: 500; color: #555555;">
                                    <?= $item['gst_percent'] ?>%
                                </td>
                                
                                <td style="padding: 14px; border: 1px solid #eeeeee; font-size: 14px; font-weight: 500; color: #555555;">
                                    ₹<?= number_format($order['shipping_charge'], 2) ?>
                                </td>
                                
                                <td style="padding: 14px; border: 1px solid #eeeeee; font-size: 14px; font-weight: 700; color: #111111;">
                                    ₹<?= number_format($item['line_total'], 2) ?>
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