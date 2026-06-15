<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT *
    FROM bulk_inquiries
    ORDER BY id DESC
");

$inquiries = $stmt->fetchAll();

?>

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

    /* Force the data grid layout to maintain clear structure on mobile panels */
    .premium-inquiry-table {
        min-width: 1000px !important;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 mb-md-5">
        <div>
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                Bulk Inquiries
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Manage commercial requests, enterprise leads, and high-volume product pricing queues.
            </p>
        </div>
    </div>

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
            
            <div class="table-responsive custom-table-scroll" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">

                <table class="table premium-inquiry-table align-middle mb-0" style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);">
                    
                    <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 80px;">ID</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Customer</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Company</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Product</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Quantity</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Phone</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Status</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Date</th>
                            <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 160px;">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($inquiries as $row): ?>
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03); background: transparent; transition: background 0.2s;" 
                                onmouseover="this.style.background='rgba(255,255,255,0.01)';" 
                                onmouseout="this.style.background='transparent';">
                                
                                <td class="px-4">
                                    <span style="font-size: 13px; font-family: monospace; color: #38bdf8; font-weight: 600;">
                                        #<?= $row['id'] ?>
                                    </span>
                                </td>

                                <td>
                                    <div style="font-weight: 600; font-size: 14px; color: #ffffff;">
                                        <?= htmlspecialchars($row['customer_name']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div style="font-size: 13.5px; color: #cbd5e1; font-weight: 500;">
                                        <?= htmlspecialchars($row['company_name']) ?>
                                    </div>
                                </td>

                                <td>
                                    <span style="color: #e2e8f0; font-size: 13.5px;">
                                        <?= htmlspecialchars($row['product_name']) ?>
                                    </span>
                                </td>

                                <td>
                                    <span style="font-weight: 600; font-size: 14px; color: #ffffff; font-family: system-ui, -apple-system, sans-serif;">
                                        <?= htmlspecialchars($row['quantity']) ?>
                                    </span>
                                </td>

                                <td>
                                    <span style="color: #94a3b8; font-size: 13px; font-family: monospace;">
                                        <?= htmlspecialchars($row['phone']) ?>
                                    </span>
                                </td>

                                <td>
                                    <?php
                                    // Custom style mappings based on original backend status keys
                                    if($row['status'] == 'new'){
                                        $bg = 'rgba(245, 158, 11, 0.1)';   $color = '#f59e0b';  $border = 'rgba(245, 158, 11, 0.15)';
                                    } elseif($row['status'] == 'contacted'){
                                        $bg = 'rgba(6, 182, 212, 0.1)';   $color = '#06b6d4';  $border = 'rgba(6, 182, 212, 0.15)';
                                    } elseif($row['status'] == 'quotation_sent'){
                                        $bg = 'rgba(59, 130, 246, 0.1)';   $color = '#3b82f6';  $border = 'rgba(59, 130, 246, 0.15)';
                                    } elseif($row['status'] == 'converted'){
                                        $bg = 'rgba(16, 185, 129, 0.1)';   $color = '#10b981';  $border = 'rgba(16, 185, 129, 0.15)';
                                    } else { // closed
                                        $bg = 'rgba(148, 163, 184, 0.1)';  $color = '#94a3b8';  $border = 'rgba(148, 163, 184, 0.15)';
                                    }
                                    ?>
                                    <span class="badge px-2.5 py-1.5" style="
                                        font-size: 11px;
                                        background: <?= $bg ?>;
                                        color: <?= $color ?>;
                                        border: 1px solid <?= $border ?>;
                                        font-weight: 500;
                                        border-radius: 6px;
                                        text-transform: uppercase;
                                        letter-spacing: 0.03em;
                                    ">
                                        <?= ucfirst(str_replace('_', ' ', $row['status'])) ?>
                                    </span>
                                </td>

                                <td>
                                    <span style="color: #64748b; font-size: 13px;">
                                        <?= date('d M Y', strtotime($row['created_at'])) ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="view_bulk_inquiry.php?id=<?= $row['id'] ?>" class="btn btn-sm px-2.5 py-1.5" style="
                                            background: rgba(255, 255, 255, 0.03);
                                            color: #e2e8f0;
                                            border: 1px solid rgba(255, 255, 255, 0.08);
                                            font-weight: 500;
                                            font-size: 12.5px;
                                            border-radius: 6px;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.color='#ffffff';"
                                        onmouseout="this.style.background='rgba(255, 255, 255, 0.03)'; this.style.color='#e2e8f0';">
                                            View
                                        </a>
                                        
                                        <a href="delete_bulk_inquiry.php?id=<?= $row['id'] ?>" class="btn btn-sm px-2.5 py-1.5" onclick="return confirm('Delete inquiry?')" style="
                                            background: rgba(239, 68, 68, 0.05);
                                            color: #f87171;
                                            border: 1px solid rgba(239, 68, 68, 0.15);
                                            font-weight: 500;
                                            font-size: 12.5px;
                                            border-radius: 6px;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.background='rgba(239, 68, 68, 0.15)'; this.style.color='#ef4444';"
                                        onmouseout="this.style.background='rgba(239, 68, 68, 0.05)'; this.style.color='#f87171';">
                                            Delete
                                        </a>
                                    </div>
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