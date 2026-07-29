<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

/*
|--------------------------------------------------------------------------
| GET STATE
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM states
    WHERE id = ?
");

$stmt->execute([$id]);

$state = $stmt->fetch();

if(!$state){

    die("State not found.");

}

/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = trim($_POST['name']);
    $code = strtoupper(trim($_POST['code']));
    $status = (int)$_POST['status'];

    if($name == '' || $code == ''){

        $error = "Please fill all required fields.";

    }else{

        $update = $pdo->prepare("
            UPDATE states
            SET
                name = ?,
                code = ?,
                status = ?
            WHERE id = ?
        ");

        $update->execute([
            $name,
            $code,
            $status,
            $id
        ]);

        header("Location: states.php");

        exit;

    }

}

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

<div class="row justify-content-center">

<div class="col-lg-7">

<div class="card border-0" style=" background:rgba(21,25,34,.60); backdrop-filter:blur(12px); border-radius:14px; border:1px solid rgba(255,255,255,.05); ">

<div class="card-body p-4">

<h2 class="mb-4" style=" color:#fff; font-weight:700; " > Edit Stat </h2>

<?php if(!empty($error)): ?>

<div class="alert alert-danger">

<?= $error ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-4">
    <label class="form-label" style=" color:#94a3b8; font-size:12px; text-transform:uppercase; " > State Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($state['name']) ?>" required class="form-control" style=" background:rgba(15,17,21,.6); border:1px solid rgba(255,255,255,.08); color:#fff; height:46px; " >
</div>

<div class="mb-4">

<label class="form-label" style=" color:#94a3b8; font-size:12px; text-transform:uppercase; " >

State Code

</label>

<input type="text" name="code" maxlength="10" value="<?= htmlspecialchars($state['code']) ?>" required class="form-control" style=" background:rgba(15,17,21,.6); border:1px solid rgba(255,255,255,.08); color:#fff; height:46px; " >

<small style="color:#64748b;"> Examples: DL, PB, RJ, HR</small>

</div>

<div class="mb-4">

<label class="form-label" style=" color:#94a3b8; font-size:12px; text-transform:uppercase; " > Status </label>

<select name="status" class="form-control" style=" background:rgba(15,17,21,.6); border:1px solid rgba(255,255,255,.08); color:#fff; height:46px; " >
    <option value="1" <?= $state['status']==1 ? 'selected' : '' ?> > Active </option>
    <option value="0" <?= $state['status']==0 ? 'selected' : '' ?> > Inactive </option>
</select>

</div>

<div class="d-flex justify-content-between">

<a
href="states.php"
class="btn btn-secondary px-4"
>

Cancel

</a>

<button
type="submit"
class="btn px-4"
style="
background:linear-gradient(135deg,#38bdf8,#0284c7);
color:#fff;
"
>

Update State

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>