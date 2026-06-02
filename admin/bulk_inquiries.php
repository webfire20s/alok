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

<div class="d-flex justify-content-between mb-4">

    <h2>

        Bulk Inquiries

    </h2>

</div>

<div class="card-box p-4">

    <div class="table-responsive">

        <table class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Customer</th>
                    <th>Company</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($inquiries as $row): ?>

                    <tr>

                        <td>
                            <?= $row['id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['customer_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['company_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['product_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['quantity']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['phone']) ?>
                        </td>

                        <td>

                            <?php

                            $badge = 'secondary';

                            if($row['status'] == 'new'){
                                $badge = 'warning';
                            }

                            if($row['status'] == 'contacted'){
                                $badge = 'info';
                            }

                            if($row['status'] == 'quotation_sent'){
                                $badge = 'primary';
                            }

                            if($row['status'] == 'converted'){
                                $badge = 'success';
                            }

                            if($row['status'] == 'closed'){
                                $badge = 'dark';
                            }

                            ?>

                            <span class="badge badge-<?= $badge ?> p-2">

                                <?= ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $row['status']
                                    )
                                ) ?>

                            </span>

                        </td>

                        <td>

                            <?= date(
                                'd M Y',
                                strtotime($row['created_at'])
                            ) ?>

                        </td>

                        <td>

                            <a
                                href="view_bulk_inquiry.php?id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-primary"
                            >
                                View
                            </a>

                            <a
                                href="delete_bulk_inquiry.php?id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete inquiry?')"
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