<?php

session_start();

require 'includes/db.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /*
    |--------------------------------------------------------------------------
    | FIND USER
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT *
        FROM users
        WHERE email = ?
    ");

    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if(!$user){

        $error = "Invalid email.";

    }elseif(!password_verify($password, $user['password'])){

        $error = "Invalid password.";

    }else{

        /*
        |--------------------------------------------------------------------------
        | LOGIN SESSION
        |--------------------------------------------------------------------------
        */

        $_SESSION['user_id'] =
            $user['id'];
        $sessionId = session_id();

        $mergeStmt = $pdo->prepare("
            UPDATE cart
            SET user_id = ?
            WHERE session_id = ?
        ");

        $mergeStmt->execute([
            $user['id'],
            $sessionId
        ]);

        $_SESSION['user_name'] =
            $user['full_name'];

        $_SESSION['user_email'] =
            $user['email'];

        header("Location: index.php");
        exit;

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
                        Login
                    </h2>

                    <?php if($error): ?>

                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required
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

                            Login

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        New customer?

                        <a href="register.php">
                            Register
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>