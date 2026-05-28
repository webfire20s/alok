<?php

session_start();

require '../includes/db.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("
        SELECT *
        FROM admins
        WHERE username = ?
    ");

    $stmt->execute([$username]);

    $admin = $stmt->fetch();

    if(!$admin){

        $error = "Invalid username";

    }elseif(!password_verify($password, $admin['password'])){

        $error = "Invalid password";

    }else{

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Login</title>

    <link
        rel="stylesheet"
        href="../assets/themes/storefront/public/css/bootstrap.min.css"
    >

</head>

<body style="background:#f5f5f5;">

<div class="container pt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="mb-4 text-center">
                        Admin Login
                    </h3>

                    <?php if(!empty($error)): ?>

                        <div class="alert alert-danger">

                            <?= htmlspecialchars($error) ?>

                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group">

                            <label>Username</label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="form-group">

                            <label>Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>

                        <button class="btn btn-dark btn-block">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>