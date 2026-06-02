<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    DELETE FROM contact_inquiries
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: contact_inquiries.php");

exit;