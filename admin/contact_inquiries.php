<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT *
    FROM contact_inquiries
    ORDER BY id DESC
");

$inquiries = $stmt->fetchAll();

?>

<!-- Custom Premium UI Scrollbar Styles -->
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
    .premium-contact-table {
        min-width: 850px !important;
    }
</style>

<div class="container-fluid py-4">

    <!-- HEADER TITLE NAVIGATION STRIP -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 mb-md-5">
        <div>
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                Contact Inquiries
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Monitor general consumer feedback, public support tickets, and inbound site queries.
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
            
            <!-- HORIZONTAL SCROLL RUNNER CONTAINER -->
            <div class="table-responsive custom-table-scroll" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">

                <table class="table premium-contact-table align-middle mb-0" style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);">
                    
                    <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 90px;">ID</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Name</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Email</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Phone</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Date</th>
                            <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 160px;">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($inquiries as $row): ?>
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03); background: transparent; transition: background 0.2s;" 
                                onmouseover="this.style.background='rgba(255,255,255,0.01)';" 
                                onmouseout="this.style.background='transparent';">
                                
                                <!-- INQUIRY ID -->
                                <td class="px-4">
                                    <span style="font-size: 13px; font-family: monospace; color: #38bdf8; font-weight: 600;">
                                        #<?= $row['id'] ?>
                                    </span>
                                </td>

                                <!-- USER SENDER NAME -->
                                <td>
                                    <div style="font-weight: 600; font-size: 14px; color: #ffffff;">
                                        <?= htmlspecialchars($row['name']) ?>
                                    </div>
                                </td>

                                <!-- EMAIL ROUTE -->
                                <td>
                                    <span style="font-size: 13.5px; color: #cbd5e1;">
                                        <?= htmlspecialchars($row['email']) ?>
                                    </span>
                                </td>

                                <!-- PHONE TELEMETRY -->
                                <td>
                                    <span style="color: #94a3b8; font-size: 13px; font-family: monospace;">
                                        <?= htmlspecialchars($row['phone'] ?: '—') ?>
                                    </span>
                                </td>

                                <!-- RECORD TIMESTAMP -->
                                <td>
                                    <span style="color: #64748b; font-size: 13px;">
                                        <?= date('d M Y', strtotime($row['created_at'])) ?>
                                    </span>
                                </td>

                                <!-- MANAGEMENT ACTIONS -->
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="view_inquiry.php?id=<?= $row['id'] ?>" class="btn btn-sm px-2.5 py-1.5" style="
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
                                        
                                        <a href="delete_inquiry.php?id=<?= $row['id'] ?>" class="btn btn-sm px-2.5 py-1.5" onclick="return confirm('Delete inquiry?')" style="
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