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

<div class="d-flex justify-content-between mb-4">

    <h2>

        Contact Inquiries

    </h2>

</div>

<div class="card-box p-4">

    <div class="table-responsive">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
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

                            <?= htmlspecialchars($row['name']) ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['email']) ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['phone']) ?>

                        </td>

                        <td>

                            <?= date(
                                'd M Y',
                                strtotime($row['created_at'])
                            ) ?>

                        </td>

                        <td>

                            <a
                                href="view_inquiry.php?id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-primary"
                            >
                                View
                            </a>

                            <a
                                href="delete_inquiry.php?id=<?= $row['id'] ?>"
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