    <?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    DELETE FROM closure_options
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: closure_options.php");
exit;