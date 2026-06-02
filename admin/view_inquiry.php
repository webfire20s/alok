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

<h2 class="mb-4">

    Inquiry Details

</h2>

<div class="card-box p-4">

    <p>

        <strong>Name:</strong>

        <?= htmlspecialchars($inquiry['name']) ?>

    </p>

    <p>

        <strong>Email:</strong>

        <?= htmlspecialchars($inquiry['email']) ?>

    </p>

    <p>

        <strong>Phone:</strong>

        <?= htmlspecialchars($inquiry['phone']) ?>

    </p>

    <p>

        <strong>Message:</strong>

    </p>

    <div class="border p-3 bg-light">

        <?= nl2br(
            htmlspecialchars(
                $inquiry['message']
            )
        ) ?>

    </div>

</div>

</div>
</body>
</html>