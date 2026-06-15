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

<!-- Custom Premium Scrollbar & Badge Overrides -->
<style>
    /* Styling the container scrollbar for a sleek dark mode look */
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

    /* Force the extensive layout table to retain layout structure on tiny screens */
    .premium-table {
        min-width: 950px !important;
    }
</style>

<div class="container-fluid py-4">

    <!-- HEADER NAVIGATION STRIP -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 mb-md-5">
        <div>
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                Orders
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Monitor production queues, customer assignments, and glass shipment statuses.
            </p>
        </div>
    </div>

    <!-- GLASS DATA INTERFACE WRAPPER -->
    <div class="card border-0" style="
        border-radius: 14px;
        background: rgba(21, 25, 34, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        overflow: hidden;
    ">
        <div class="card-body p-0">
            
            <!-- HORIZONTAL SCROLL CONTAINER -->
            <div class="table-responsive custom-table-scroll" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">

                <table class="table premium-table align-middle mb-0" style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);">
                    
                    <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">ID</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Customer</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Phone</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">City</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Total</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Payment</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Status</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Date</th>
                            <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($orders as $order): ?>
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03);">
                                
                                <!-- ORDER ID -->
                                <td class="px-4">
                                    <span style="font-size: 13px; font-family: monospace; color: #38bdf8; font-weight: 600;">
                                        #<?= $order['id'] ?>
                                    </span>
                                </td>

                                <!-- CUSTOMER NAME -->
                                <td>
                                    <div style="font-weight: 600; font-size: 14px; color: #ffffff;">
                                        <?= htmlspecialchars($order['customer_name']) ?>
                                    </div>
                                </td>

                                <!-- PHONE NUMBER -->
                                <td>
                                    <span style="color: #94a3b8; font-size: 13.5px;">
                                        <?= htmlspecialchars($order['phone'] ?? '—') ?>
                                    </span>
                                </td>

                                <!-- LOCATION CITY -->
                                <td>
                                    <span style="color: #e2e8f0; font-size: 13.5px; font-weight: 500;">
                                        <?= htmlspecialchars($order['city'] ?? '—') ?>
                                    </span>
                                </td>

                                <!-- GRAND TOTAL -->
                                <td>
                                    <span style="font-weight: 700; font-size: 14px; color: #f8fafc; font-family: system-ui, -apple-system, sans-serif;">
                                        ₹<?= number_format($order['grand_total'], 2) ?>
                                    </span>
                                </td>

                                <!-- PAYMENT METHOD -->
                                <td>
                                    <span style="font-size: 12px; background: rgba(255,255,255,0.03); padding: 3px 8px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.05); color: #cbd5e1;">
                                        <?= htmlspecialchars($order['payment_method']) ?>
                                    </span>
                                </td>

                                <!-- DYNAMIC STATUS BADGES -->
                                <td>
                                    <?php 
                                        $status = strtolower($order['order_status']);
                                        
                                        // Configure inline custom variables for specific fulfillment state hues
                                        if ($status == 'pending') {
                                            $bg = 'rgba(245, 158, 11, 0.1)';   $color = '#f59e0b';  $border = 'rgba(245, 158, 11, 0.15)';
                                        } elseif ($status == 'confirmed') {
                                            $bg = 'rgba(6, 182, 212, 0.1)';   $color = '#06b6d4';  $border = 'rgba(6, 182, 212, 0.15)';
                                        } elseif ($status == 'shipped') {
                                            $bg = 'rgba(59, 130, 246, 0.1)';   $color = '#3b82f6';  $border = 'rgba(59, 130, 246, 0.15)';
                                        } elseif ($status == 'delivered') {
                                            $bg = 'rgba(16, 185, 129, 0.1)';   $color = '#10b981';  $border = 'rgba(16, 185, 129, 0.15)';
                                        } else { // cancelled / failed
                                            $bg = 'rgba(239, 68, 68, 0.1)';    $color = '#ef4444';  $border = 'rgba(239, 68, 68, 0.15)';
                                        }
                                    ?>
                                    <span class="badge px-2.5 py-1.5" style="
                                        font-size: 11.5px;
                                        background: <?= $bg ?>;
                                        color: <?= $color ?>;
                                        border: 1px solid <?= $border ?>;
                                        font-weight: 500;
                                        border-radius: 6px;
                                        text-transform: uppercase;
                                        letter-spacing: 0.02em;
                                    ">
                                        <?= ucfirst($order['order_status']) ?>
                                    </span>
                                </td>

                                <!-- CREATION DATE -->
                                <td>
                                    <span style="color: #64748b; font-size: 13px;">
                                        <?= date("d M Y", strtotime($order['created_at'])) ?>
                                    </span>
                                </td>

                                <!-- ROW CONTROL ACTIONS -->
                                <td class="text-center">
                                    <a href="view_order.php?id=<?= $order['id'] ?>" class="btn btn-sm px-3 py-1.5" style="
                                        background: rgba(255,255,255,0.03);
                                        color: #e2e8f0;
                                        border: 1px solid rgba(255,255,255,0.08);
                                        font-weight: 500;
                                        font-size: 13px;
                                        border-radius: 6px;
                                        transition: all 0.2s;
                                    "
                                    onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#ffffff';"
                                    onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.color='#e2e8f0';">
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

</div>

</body>
</html>