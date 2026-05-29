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

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="mb-0">
        Product Reviews
    </h2>

</div>

<div class="card-box p-4">

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="thead-dark">

                <tr>

                    <th width="80">
                        ID
                    </th>

                    <th>
                        Product
                    </th>

                    <th width="180">
                        Customer
                    </th>

                    <th width="120">
                        Rating
                    </th>

                    <th>
                        Review
                    </th>

                    <th width="140">
                        Status
                    </th>

                    <th width="220">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php if(empty($reviews)): ?>

                    <tr>

                        <td colspan="7" class="text-center">

                            No reviews found.

                        </td>

                    </tr>

                <?php endif; ?>

                <?php foreach($reviews as $review): ?>

                    <tr>

                        <td>

                            <?= $review['id'] ?>

                        </td>

                        <td>

                            <?= htmlspecialchars(
                                $review['product_name']
                            ) ?>

                        </td>

                        <td>

                            <strong>

                                <?= htmlspecialchars(
                                    $review['customer_name']
                                ) ?>

                            </strong>

                            <br>

                            <small class="text-muted">

                                <?= htmlspecialchars(
                                    $review['customer_email']
                                ) ?>

                            </small>

                        </td>

                        <td>

                            <?php for($i=1; $i<=5; $i++): ?>

                                <?php if($i <= $review['rating']): ?>

                                    <span style="color:#f5b301;">
                                        ★
                                    </span>

                                <?php else: ?>

                                    <span style="color:#ccc;">
                                        ★
                                    </span>

                                <?php endif; ?>

                            <?php endfor; ?>

                        </td>

                        <td style="min-width:250px;">

                            <?= nl2br(htmlspecialchars(
                                $review['review']
                            )) ?>

                        </td>

                        <td>

                            <?php if($review['is_approved']): ?>

                                <span class="badge badge-success p-2">

                                    Approved

                                </span>

                            <?php else: ?>

                                <span class="badge badge-warning p-2">

                                    Pending

                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if(!$review['is_approved']): ?>

                                <a
                                    href="reviews.php?approve=<?= $review['id'] ?>"
                                    class="btn btn-sm btn-success mb-2"
                                >
                                    Approve
                                </a>

                            <?php endif; ?>

                            <a
                                href="reviews.php?delete=<?= $review['id'] ?>"
                                class="btn btn-sm btn-danger mb-2"
                                onclick="return confirm('Delete this review?')"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</div>

</body>
</html>