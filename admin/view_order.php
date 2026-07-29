<?php

require 'includes/auth.php';
require '../includes/db.php';


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

if(
    $_SERVER['REQUEST_METHOD'] === 'POST'
    &&
    isset($_POST['update_status'])
){

    $status =
        trim($_POST['order_status']);

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

/*
|--------------------------------------------------------------------------
| UPDATE SHIPPING
|--------------------------------------------------------------------------
*/

?>

<?php 
// Existing backend processing layers are preserved identically above this layout block
include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';
?>

<style>
    .custom-table-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .custom-table-scroll::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
    }
    .custom-table-scroll::-webkit-scrollbar-thumb {
        background: rgba(56, 189, 248, 0.2);
        border-radius: 10px;
    }
    .custom-table-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(56, 189, 248, 0.4);
    }
    .glass-input-control {
        background: rgba(15, 17, 21, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 8px !important;
        color: #ffffff !important;
        font-size: 14px !important;
        transition: all 0.2s ease-in-out !important;
    }
    .glass-input-control:focus {
        background: rgba(15, 17, 21, 0.6) !important;
        border-color: rgba(56, 189, 248, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15) !important;
    }
</style>

<div class="container-fluid py-4">

    <?php if($order['subtotal'] < 15000): ?>
        <div class="alert border-0 mb-4 d-flex align-items-center" style="
            background: rgba(245, 158, 11, 0.06); 
            border: 1px solid rgba(245, 158, 11, 0.15) !important; 
            color: #f59e0b; 
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
        ">
            <span class="mr-2" style="font-size: 16px;">⚠️</span> Order below ₹15,000. Shipping charges recommended.
        </div>
    <?php else: ?>
        <div class="alert border-0 mb-4 d-flex align-items-center" style="
            background: rgba(16, 185, 129, 0.06); 
            border: 1px solid rgba(16, 185, 129, 0.15) !important; 
            color: #10b981; 
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
        ">
            <span class="mr-2" style="font-size: 16px;">✨</span> Order above ₹15,000. Eligible for free shipping if approved.
        </div>
    <?php endif; ?>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 mb-md-5">
        <div>
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                Order #<?= $order['id'] ?>
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Review comprehensive logistics files, breakdown statements, and adjust shipping.
            </p>
        </div>
        <a href="../invoice.php?order=<?= $order['id'] ?>" target="_blank" class="btn px-4 py-2" style="
            background: rgba(255, 255, 255, 0.03);
            color: #e2e8f0;
            font-weight: 600;
            font-size: 13.5px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            transition: all 0.2s;
        " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#ffffff';"
          onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.color='#e2e8f0';">
            Download Invoice
        </a>
    </div>

    <div class="row">

        <div class="col-md-8">

            <div class="card border-0 p-4 mb-4" style="
                border-radius: 14px;
                background: rgba(21, 25, 34, 0.6);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            ">
                <h4 class="mb-4" style="font-size: 16px; font-weight: 600; color: #ffffff; letter-spacing: -0.01em;">
                    Customer Details
                </h4>

                <div class="row style-details-grid" style="color: #cbd5e1; font-size: 14px; row-gap: 14px;">
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 2px;">Name</span>
                        <span style="font-weight: 500; color: #ffffff;"><?= htmlspecialchars($order['customer_name']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 2px;">Email</span>
                        <span><?= htmlspecialchars($order['customer_email'] ?? '—') ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 2px;">Phone</span>
                        <span style="font-family: monospace; color: #94a3b8;"><?= htmlspecialchars($order['customer_phone'] ?? '—') ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 2px;">Location Metrics</span>
                        <span><?= htmlspecialchars($order['customer_city'] ?? '') ?>, <?= htmlspecialchars($order['customer_state'] ?? '') ?> (<?= htmlspecialchars($order['customer_pincode'] ?? '') ?>)</span>
                    </div>
                    <div class="col-12">
                        <span style="color: #64748b; display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 2px;">Full Address</span>
                        <span style="line-height: 1.5; color: #e2e8f0;"><?= nl2br(htmlspecialchars($order['customer_address'] ?? '—')) ?></span>
                    </div>
                </div>
            </div>

            <div class="card border-0 p-4" style="
                border-radius: 14px;
                background: rgba(21, 25, 34, 0.6);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            ">
                <h4 class="mb-4" style="font-size: 16px; font-weight: 600; color: #ffffff; letter-spacing: -0.01em;">
                    Order Items
                </h4>

                <div class="table-responsive custom-table-scroll">
                    <table class="table align-middle mb-0" style="color: #cbd5e1; border-color: rgba(255, 255, 255, 0.03); min-width: 600px;">
                        <thead style="background: rgba(255, 255, 255, 0.01); border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                            <tr>
                                <th class="py-2" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Image</th>
                                <th class="py-2" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Product</th>
                                <th class="py-2" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Qty</th>
                                <th class="py-2" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Type</th>
                                <th class="py-2" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">GST</th>
                                <th class="py-2 text-end" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $item): ?>
                                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.02);">
                                    <td style="width: 70px; padding: 12px 0;">
                                        <?php
                                            $imagePath = $item['product_image'] ?? '';
                                            if($imagePath && !str_contains($imagePath, 'storage/')){
                                                $imagePath = 'storage/media/' . $imagePath;
                                            }
                                        ?>
                                        <div style="width: 54px; height: 54px; border-radius: 6px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06); background: rgba(0,0,0,0.2);">
                                            <?php if(!empty($imagePath)): ?>
                                                <img src="../<?= htmlspecialchars($imagePath) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <?php

                                        $productPrice = (float)$item['price'];          // Already includes closure
                                        $closurePrice = (float)($item['closure_option_price'] ?? 0);

                                        $baseProductPrice = $productPrice - $closurePrice;

                                        $effectivePrice = $productPrice;

                                        $itemSubtotal = $effectivePrice * $item['quantity'];

                                        $itemGST = ($itemSubtotal * $item['gst_percent']) / 100;

                                        $itemTotal = $itemSubtotal + $itemGST;

                                        ?>

                                        <div style="font-weight:600;color:#ffffff;font-size:13.5px;">
                                            <?= htmlspecialchars($item['product_name']) ?>
                                        </div>

                                        <?php if(!empty($item['closure_option_name'])): ?>

                                            <div style="
                                                margin-top:6px;
                                                display:inline-block;
                                                padding:4px 8px;
                                                border-radius:5px;
                                                background:rgba(56,189,248,.08);
                                                border:1px solid rgba(56,189,248,.18);
                                                color:#7dd3fc;
                                                font-size:11px;
                                            ">
                                                Closure :
                                                <strong>
                                                    <?= htmlspecialchars($item['closure_option_name']) ?>
                                                </strong>
                                            </div>

                                        <?php endif; ?>


                                        <!-- INSERT IT HERE -->

                                        <div style="
                                            margin-top:6px;
                                            color:#94a3b8;
                                            font-size:11px;
                                            line-height:1.6;
                                        ">

                                            Product :
                                            ₹<?= number_format($baseProductPrice,2) ?>

                                            <?php if($closurePrice > 0): ?>

                                            <br>

                                            Closure :
                                            ₹<?= number_format($closurePrice,2) ?>

                                            <br>

                                            <strong style="color:#38bdf8;">
                                            Unit Price :
                                            ₹<?= number_format($effectivePrice,2) ?>
                                            </strong>

                                            <?php endif; ?>

                                        </div>

                                    </td>
                                    
                                    <td><span style="font-weight: 500; color: #f1f5f9;"><?= $item['quantity'] ?></span></td>
                                    
                                    <td>
                                        <span style="font-size: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); padding: 2px 6px; border-radius: 4px; color: #94a3b8;">
                                            <?= ucfirst($item['order_unit']) ?>
                                        </span>
                                    </td>
                                    
                                    <td><span style="color: #94a3b8; font-size: 13px;"><?= $item['gst_percent'] ?>%</span></td>
                                    
                                    <td class="text-end">
                                        
                                        <span style="font-weight: 600; font-family: monospace; color: #ffffff;">
                                            ₹<?= number_format($itemTotal, 2) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 p-4" style="
                border-radius: 14px;
                background: rgba(21, 25, 34, 0.6);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            ">
                <h4 class="mb-4" style="font-size: 16px; font-weight: 600; color: #ffffff; letter-spacing: -0.01em;">
                    Order Summary
                </h4>

                <div class="d-flex justify-content-between mb-3" style="font-size:14px;">
                    <span style="color:#94a3b8;">Subtotal</span>
                    <span style="color:#ffffff;font-family:monospace;">
                        ₹<?= number_format($order['subtotal'],2) ?>
                    </span>
                </div>

                <div class="d-flex justify-content-between mb-3" style="font-size:14px;">
                    <span style="color:#94a3b8;">GST</span>
                    <span style="color:#ffffff;font-family:monospace;">
                        ₹<?= number_format($order['gst_total'],2) ?>
                    </span>
                </div>

                <div class="d-flex justify-content-between mb-3" style="font-size:14px;">
                    <span style="color:#94a3b8;">Shipping Method</span>
                    <span style="color:#ffffff;text-align:right;">
                        <?= htmlspecialchars($order['shipping_method']) ?>
                    </span>
                </div>

                <div class="d-flex justify-content-between mb-3" style="font-size:14px;">
                    <span style="color:#94a3b8;">Shipping Charge</span>
                    <span style="color:#ffffff;font-family:monospace;">
                        ₹<?= number_format($order['shipping_charge'],2) ?>
                    </span>
                </div>

                <div class="d-flex justify-content-between mb-3" style="font-size:14px;">
                    <span style="color:#94a3b8;">
                        Shipping GST
                        (<?= number_format($order['shipping_gst_percent'],0) ?>%)
                    </span>

                    <span style="color:#ffffff;font-family:monospace;">
                        ₹<?= number_format($order['shipping_gst'],2) ?>
                    </span>
                </div>

                <div class="d-flex justify-content-between mb-4" style="font-size:14px;">
                    <span style="color:#94a3b8;">Total Shipping</span>

                    <span style="color:#38bdf8;font-family:monospace;font-weight:600;">
                        ₹<?= number_format($order['shipping_charge']+$order['shipping_gst'],2) ?>
                    </span>
                </div>

                <div style=" border-top:1px solid rgba(255,255,255,.08); padding-top:18px; " class="d-flex justify-content-between align-items-center">

                    <span style=" color:#ffffff; font-size:15px; font-weight:700; ">
                        Grand Total
                    </span>

                    <span style=" color:#10b981; font-size:22px; font-weight:700; font-family:monospace; ">
                        ₹<?= number_format($order['grand_total'],2) ?>
                    </span>

                </div>

                <hr style="border-top: 1px solid rgba(255,255,255,0.08); margin: 24px 0;">

                <?php 
                // Execution handler blocks run internally here unchanged when processing state updates
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
                    $newStatus = trim($_POST['order_status'] ?? '');
                    $allowedStatuses = ['pending', 'confirmed', 'packed', 'shipped', 'delivered', 'cancelled'];
                    if (in_array($newStatus, $allowedStatuses)) {
                        $updateStmt = $pdo->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
                        $updateStmt->execute([$newStatus, $order['id']]);
                        
                        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
                        $stmt->execute([$order['id']]);
                        $order = $stmt->fetch();
                    }
                }
                ?>

                <form method="POST" class="mb-4">
                    <input type="hidden" name="update_status" value="1">
                    <div class="form-group mb-3">
                        <label style="color: #94a3b8; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; display: block;">
                            Order Status
                        </label>
                        <select name="order_status" class="form-control glass-input-control" style="cursor: pointer;">
                            <?php 
                            $statuses = ['pending', 'confirmed', 'packed', 'shipped', 'delivered', 'cancelled'];
                            foreach($statuses as $status): 
                            ?>
                                <option value="<?= $status ?>" <?= $order['order_status'] == $status ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">
                                    <?= ucfirst($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-block py-2" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); color: #ffffff; font-size: 13.5px; font-weight: 600; border-radius: 6px; transition: background 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.08)';" onmouseout="this.style.background='rgba(255,255,255,0.04)';">
                        Update Status
                    </button>
                </form>
                <hr style="border-top:1px solid rgba(255,255,255,.06);margin:22px 0;">

                <h5 class="mb-3" style=" font-size:14px; font-weight:600; color:#ffffff; "> Shipping Information </h5>

                <div style=" background:rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.05); border-radius:8px; padding:15px; ">

                    <div class="mb-2">

                        <small style="color:#64748b;">
                            Shipping Method
                        </small>

                        <div style=" color:#ffffff; font-weight:600; ">
                            <?= htmlspecialchars($order['shipping_method']) ?>
                        </div>

                    </div>

                    <div class="mb-2">

                        <small style="color:#64748b;">
                            Shipping Charge
                        </small>

                        <div style="color:#38bdf8;">
                            ₹<?= number_format($order['shipping_charge'],2) ?>
                        </div>

                    </div>

                    <div class="mb-2">

                        <small style="color:#64748b;">
                            Shipping GST
                        </small>

                        <div style="color:#38bdf8;">
                            ₹<?= number_format($order['shipping_gst'],2) ?>
                        </div>

                    </div>

                    <div>

                        <small style="color:#64748b;">
                            Total Shipping
                        </small>

                        <div style=" color:#10b981; font-weight:700; ">
                            ₹<?= number_format($order['shipping_charge']+$order['shipping_gst'],2) ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

</body>
</html>