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

<div class="d-flex align-items-center justify-content-between mb-5">
    <div>
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em;">Business Overview</h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">Real-time manufacturing demand, inventory status, and revenue statistics.</p>
    </div>
    <div style="font-size: 12px; background: rgba(255,255,255,0.02); padding: 8px 16px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.05); color: #64748b;">
        Live Production Node
    </div>
</div>

<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card-box h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin: 0;">Total Catalog Items</h5>
                <div style="background: rgba(56, 189, 248, 0.1); padding: 8px; border-radius: 8px; color: #38bdf8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
            </div>
            <h2 style="font-size: 32px; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.03em;">
                <?= $productCount ?>
            </h2>
            <div style="margin-top: 15px; font-size: 11px; color: #475569; display: flex; align-items: center; gap: 5px;">
                <span style="color: #38bdf8;">●</span> Active Glass Moulds
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card-box h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin: 0;">Product Line Segments</h5>
                <div style="background: rgba(168, 85, 247, 0.1); padding: 8px; border-radius: 8px; color: #a855f7;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </div>
            </div>
            <h2 style="font-size: 32px; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.03em;">
                <?= $categoryCount ?>
            </h2>
            <div style="margin-top: 15px; font-size: 11px; color: #475569; display: flex; align-items: center; gap: 5px;">
                <span style="color: #a855f7;">●</span> Configured Classifications
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card-box h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin: 0;">B2B & Retail Orders</h5>
                <div style="background: rgba(234, 179, 8, 0.1); padding: 8px; border-radius: 8px; color: #eab308;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </div>
            </div>
            <h2 style="font-size: 32px; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.03em;">
                <?= $orderCount ?>
            </h2>
            <div style="margin-top: 15px; font-size: 11px; color: #475569; display: flex; align-items: center; gap: 5px;">
                <span style="color: #eab308;">●</span> Placed Batches
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card-box h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, rgba(21, 25, 34, 0.8), rgba(6, 78, 59, 0.2)); border: 1px solid rgba(16, 185, 129, 0.15);">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #a7f3d0; margin: 0;">Gross Turnover</h5>
                <div style="background: rgba(16, 185, 129, 0.15); padding: 8px; border-radius: 8px; color: #10b981;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17  5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
            </div>
            <h2 style="font-size: 32px; font-weight: 700; color: #10b981; margin: 0; letter-spacing: -0.02em;">
                ₹<?= number_format($revenue ?? 0, 2) ?>
            </h2>
            <div style="margin-top: 15px; font-size: 11px; color: #65a30d; display: flex; align-items: center; gap: 5px;">
                <span style="color: #10b981;">●</span> Total Capital Volume
            </div>
        </div>
    </div>

</div>

</div> </div> </body>
</html>