<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    DELETE FROM bulk_inquiries
    WHERE id = ?
");

$stmt->execute([$id]);

header(
    "Location: bulk_inquiries.php"
);

exit;