<?php

require 'includes/auth.php';
require '../includes/db.php';

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $stateId = (int)$_POST['state_id'];
    $methodId = (int)$_POST['shipping_method_id'];
    $charge = (float)$_POST['charge'];
    $status = isset($_POST['status']) ? 1 : 0;

    $check = $pdo->prepare("
        SELECT id
        FROM shipping_rates
        WHERE state_id = ?
        AND shipping_method_id = ?
    ");

    $check->execute([
        $stateId,
        $methodId
    ]);

    if($check->fetch()){

        $message = '
            <div class="alert alert-danger">
                Shipping rate already exists for this State & Shipping Method.
            </div>';

    }else{

        $stmt = $pdo->prepare("
            INSERT INTO shipping_rates
            (
                state_id,
                shipping_method_id,
                charge,
                status
            )
            VALUES
            (
                ?,?,?,?
            )
        ");

        $stmt->execute([
            $stateId,
            $methodId,
            $charge,
            $status
        ]);

        header("Location: shipping_charge.php");
        exit;

    }

}

$states = $pdo->query("
    SELECT *
    FROM states
    WHERE status = 1
    ORDER BY sort_order,name
")->fetchAll();

$methods = $pdo->query("
    SELECT *
    FROM shipping_methods
    WHERE status = 1
    ORDER BY sort_order,name
")->fetchAll();

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

<div class="row justify-content-center">

<div class="col-lg-7">

<div class="card border-0"
style="
background:#1b2230;
border-radius:12px;
">

<div class="card-header bg-transparent">

<h3 class="text-white mb-0">

Add State-wise Shipping Charge

</h3>

</div>

<div class="card-body">

<?= $message ?>

<form method="POST">

<div class="mb-3">

<label class="form-label text-white">

State

</label>

<select
name="state_id"
class="form-control"
required>

<option value="">

Select State

</option>

<?php foreach($states as $state): ?>

<option value="<?= $state['id'] ?>">

<?= htmlspecialchars($state['name']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label class="form-label text-white">

Shipping Method

</label>

<select name="shipping_method_id" class="form-control" required>

<option value="">

Select Method

</option>

<?php foreach($methods as $method): ?>

<option value="<?= $method['id'] ?>">

<?= htmlspecialchars($method['name']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label class="form-label text-white">

Shipping Charge (Before GST) (₹)

</label>

<input type="number" step="0.01" min="0" name="charge" class="form-control" required>

</div>

<div class="form-check mb-4">

<input class="form-check-input" type="checkbox" checked name="status" id="status">

<label class="form-check-label text-white" for="status">

Active

</label>

</div>

<button
class="btn btn-primary">

Save Shipping Charge

</button>

<a
href="shipping_charge.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>