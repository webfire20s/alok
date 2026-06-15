<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM bulk_inquiries
    WHERE id = ?
");

$stmt->execute([$id]);

$inquiry = $stmt->fetch();

if(!$inquiry){

    die('Inquiry not found');

}

/*
|--------------------------------------------------------------------------
| UPDATE STATUS
|--------------------------------------------------------------------------
*/

if(
    $_SERVER['REQUEST_METHOD'] === 'POST'
){
    $status =
        trim($_POST['status']);

    $allowed = [

        'new',
        'contacted',
        'quotation_sent',
        'converted',
        'closed'

    ];

    if(in_array($status, $allowed)){

        $update = $pdo->prepare("
            UPDATE bulk_inquiries
            SET status = ?
            WHERE id = ?
        ");

        $update->execute([
            $status,
            $id
        ]);

        header(
            "Location:view_bulk_inquiry.php?id=".$id
        );

        exit;
    }
}

?>

<style>
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

    <div class="mb-5">
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
            Bulk Inquiry Details
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Review deep-dive customer requirements, corporate profiles, and cycle pipeline milestones.
        </p>
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
                
                <div class="row mb-4" style="color: #cbd5e1; font-size: 14px; row-gap: 20px;">
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">Customer</span>
                        <span style="font-weight: 600; color: #ffffff; font-size: 15px;"><?= htmlspecialchars($inquiry['customer_name']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">Company</span>
                        <span style="font-weight: 500; color: #e2e8f0;"><?= htmlspecialchars($inquiry['company_name']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">Email Address</span>
                        <span style="color: #cbd5e1;"><?= htmlspecialchars($inquiry['email']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">Phone Number</span>
                        <span style="font-family: monospace; color: #94a3b8;"><?= htmlspecialchars($inquiry['phone']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">Requested Product</span>
                        <span style="color: #38bdf8; font-weight: 500;"><?= htmlspecialchars($inquiry['product_name']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <span style="color: #64748b; display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px;">Volume Target</span>
                        <span style="font-weight: 600; color: #ffffff;"><?= htmlspecialchars($inquiry['quantity']) ?> units</span>
                    </div>
                </div>

                <hr style="border-top: 1px solid rgba(255,255,255,0.06); margin: 24px 0;">

                <h5 class="mb-3" style="font-size: 14px; font-weight: 600; color: #ffffff; letter-spacing: -0.01em;">
                    Requirements & Notes
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

        <div class="col-md-4">
            <div class="card border-0 p-4" style="
                border-radius: 14px;
                background: rgba(21, 25, 34, 0.6);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            ">
                
                <form method="POST">
                    <div class="form-group mb-4">
                        <label style="color: #94a3b8; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 8px; display: block;">
                            Inquiry Status
                        </label>
                        <select name="status" class="form-control glass-input-control" style="cursor: pointer;">
                            <?php
                            $statuses = ['new', 'contacted', 'quotation_sent', 'converted', 'closed'];
                            foreach($statuses as $status):
                            ?>
                                <option value="<?= $status ?>" <?= $inquiry['status'] == $status ? 'selected' : '' ?> style="background: #1e293b; color: #ffffff;">
                                    <?= ucfirst(str_replace('_', ' ', $status)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button class="btn btn-block py-2" style="
                        background: linear-gradient(135deg, #38bdf8, #0284c7); 
                        border: none; 
                        color: #ffffff; 
                        font-size: 14px; 
                        font-weight: 600; 
                        border-radius: 6px; 
                        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.15); 
                        transition: transform 0.2s, box-shadow 0.2s;
                    "
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.3)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.15)';">
                        Update Status
                    </button>
                </form>

            </div>
        </div>

    </div>

</div>

</div>
</body>
</html>