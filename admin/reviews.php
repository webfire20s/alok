<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| APPROVE REVIEW
|--------------------------------------------------------------------------
*/

if(isset($_GET['approve'])){

    $id = (int)$_GET['approve'];

    $approveStmt = $pdo->prepare("
        UPDATE product_reviews
        SET is_approved = 1
        WHERE id = ?
    ");

    $approveStmt->execute([$id]);

    header("Location: reviews.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| DELETE REVIEW
|--------------------------------------------------------------------------
*/

if(isset($_GET['delete'])){

    $id = (int)$_GET['delete'];

    $deleteStmt = $pdo->prepare("
        DELETE FROM product_reviews
        WHERE id = ?
    ");

    $deleteStmt->execute([$id]);

    header("Location: reviews.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH REVIEWS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT
        product_reviews.*,
        products.name AS product_name
    FROM product_reviews
    LEFT JOIN products
    ON product_reviews.product_id = products.id
    ORDER BY product_reviews.id DESC
");

$reviews = $stmt->fetchAll();

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
    .premium-reviews-table {
        min-width: 1050px !important;
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-4 mb-md-5">
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
            Product Reviews
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Moderate user-submitted feedback, audit star ratings, and toggle storefront display permissions.
        </p>
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

                <table class="table premium-reviews-table align-middle mb-0" style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);">
                    
                    <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 80px;">ID</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 200px;">Product</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 220px;">Customer</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 130px;">Rating</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Review</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 140px;">Status</th>
                            <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php if(empty($reviews)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5" style="color: #64748b; font-size: 14px;">
                                    No reviews found in the system.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach($reviews as $review): ?>
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03); background: transparent; transition: background 0.2s;" 
                                onmouseover="this.style.background='rgba(255,255,255,0.01)';" 
                                onmouseout="this.style.background='transparent';">
                                
                                <td class="px-4">
                                    <span style="font-size: 13px; font-family: monospace; color: #38bdf8; font-weight: 600;">
                                        #<?= $review['id'] ?>
                                    </span>
                                </td>

                                <td>
                                    <div style="font-weight: 600; font-size: 14px; color: #ffffff;">
                                        <?= htmlspecialchars($review['product_name']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div style="font-weight: 600; font-size: 14px; color: #e2e8f0; margin-bottom: 2px;">
                                        <?= htmlspecialchars($review['customer_name']) ?>
                                    </div>
                                    <div style="color: #64748b; font-size: 12px; font-family: monospace;">
                                        <?= htmlspecialchars($review['customer_email']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div style="font-size: 14px; letter-spacing: -0.05em; display: inline-flex; gap: 2px;">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <?php if($i <= $review['rating']): ?>
                                                <span style="color: #f5b301;">★</span>
                                            <?php else: ?>
                                                <span style="color: rgba(255, 255, 255, 0.15);">★</span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </td>

                                <td style="font-size: 13.5px; color: #cbd5e1; line-height: 1.5; padding-right: 20px;">
                                    <?= nl2br(htmlspecialchars($review['review'])) ?>
                                </td>

                                <td>
                                    <?php if($review['is_approved']): ?>
                                        <span class="badge px-2.5 py-1.5" style="
                                            font-size: 11px;
                                            background: rgba(16, 185, 129, 0.1);
                                            color: #10b981;
                                            border: 1px solid rgba(16, 185, 129, 0.15);
                                            font-weight: 500;
                                            border-radius: 6px;
                                            text-transform: uppercase;
                                            letter-spacing: 0.03em;
                                        ">
                                            Approved
                                        </span>
                                    <?php else: ?>
                                        <span class="badge px-2.5 py-1.5" style="
                                            font-size: 11px;
                                            background: rgba(245, 158, 11, 0.1);
                                            color: #f59e0b;
                                            border: 1px solid rgba(245, 158, 11, 0.15);
                                            font-weight: 500;
                                            border-radius: 6px;
                                            text-transform: uppercase;
                                            letter-spacing: 0.03em;
                                        ">
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                        <?php if(!$review['is_approved']): ?>
                                            <a href="reviews.php?approve=<?= $review['id'] ?>" class="btn btn-sm px-2.5 py-1.5" style="
                                                background: rgba(16, 185, 129, 0.06);
                                                color: #34d399;
                                                border: 1px solid rgba(16, 185, 129, 0.2);
                                                font-weight: 500;
                                                font-size: 12.5px;
                                                border-radius: 6px;
                                                transition: all 0.2s;
                                            "
                                            onmouseover="this.style.background='rgba(16, 185, 129, 0.18)'; this.style.color='#10b981';"
                                            onmouseout="this.style.background='rgba(16, 185, 129, 0.06)'; this.style.color='#34d399';">
                                                Approve
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="reviews.php?delete=<?= $review['id'] ?>" class="btn btn-sm px-2.5 py-1.5" onclick="return confirm('Delete this review?')" style="
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