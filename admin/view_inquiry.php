<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM contact_inquiries
    WHERE id = ?
");

$stmt->execute([$id]);

$inquiry = $stmt->fetch();

if(!$inquiry){
    die("Inquiry not found");
}
?>

<div class="container-fluid py-4">

    <div class="mb-5">
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
            Inquiry Details
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Review incoming general contact details, user comments, and submission logs.
        </p>
    </div>

    <div class="card border-0 p-4" style="
        max-width: 900px;
        border-radius: 14px;
        background: rgba(21, 25, 34, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    ">
        
        <div class="row mb-4" style="color: #cbd5e1; font-size: 14px; row-gap: 20px;">
            <div class="col-sm-4">
                <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">
                    Sender Name
                </span>
                <span style="font-weight: 600; color: #ffffff; font-size: 15px;">
                    <?= htmlspecialchars($inquiry['name']) ?>
                </span>
            </div>
            
            <div class="col-sm-4">
                <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">
                    Email Address
                </span>
                <span style="color: #e2e8f0; font-weight: 500;">
                    <?= htmlspecialchars($inquiry['email']) ?>
                </span>
            </div>
            
            <div class="col-sm-4">
                <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">
                    Phone Contact
                </span>
                <span style="font-family: monospace; color: #94a3b8;">
                    <?= htmlspecialchars($inquiry['phone'] ?: '—') ?>
                </span>
            </div>
        </div>

        <hr style="border-top: 1px solid rgba(255, 255, 255, 0.06); margin: 24px 0;">

        <h5 class="mb-3" style="font-size: 14px; font-weight: 600; color: #ffffff; letter-spacing: -0.01em;">
            Submitted Message
        </h5>
        
        <div class="p-3" style="
            min-height: 140px;
            background: rgba(15, 17, 21, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            color: #e2e8f0;
            font-size: 14px;
            line-height: 1.6;
        ">
            <?= nl2br(htmlspecialchars($inquiry['message'])) ?>
        </div>

    </div>
</div>

</div>
</body>
</html>