<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

if($id > 0){

    $stmt = $pdo->prepare("
        DELETE FROM states
        WHERE id = ?
    ");

    $stmt->execute([$id]);

}

header("Location: states.php");
exit;