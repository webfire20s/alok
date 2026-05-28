<?php

session_start();

require 'includes/db.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    /*
    |--------------------------------------------------------------------------
    | CHECK EXISTING EMAIL
    |--------------------------------------------------------------------------
    */

    $checkStmt = $pdo->prepare("
        SELECT id
        FROM users
        WHERE email = ?
    ");

    $checkStmt->execute([$email]);

    if($checkStmt->fetch()){

        $error = "Email already registered.";

    }else{

        /*
        |--------------------------------------------------------------------------
        | HASH PASSWORD
        |--------------------------------------------------------------------------
        */

        $hashedPassword =
            password_hash($password, PASSWORD_BCRYPT);

        /*
        |--------------------------------------------------------------------------
        | INSERT USER
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->prepare("
            INSERT INTO users (

                full_name,
                email,
                phone,
                password

            ) VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $fullName,
            $email,
            $phone,
            $hashedPassword
        ]);

        $success = "Registration successful.";

    }

}

include 'includes/header.php';

?>

<div class="container pt-5 pb-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <h2 class="mb-4 text-center">
                        Register
                    </h2>

                    <?php if($error): ?>

                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>

                    <?php endif; ?>

                    <?php if($success): ?>

                        <div class="alert alert-success">
                            <?= $success ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">

                            <label>Full Name</label>

                            <input
                                type="text"
                                name="full_name"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="form-group mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="form-group mb-3">

                            <label>Phone</label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                            >

                        </div>

                        <div class="form-group mb-4">

                            <label>Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>

                        <button class="btn btn-dark btn-block">

                            Create Account

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        Already have account?

                        <a href="login.php">
                            Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>