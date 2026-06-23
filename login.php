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

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif;">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                <div class="card-body p-4 p-md-5">

                    <h2 class="text-uppercase text-center mb-4" style="font-size: 22px; font-weight: 700; color: #111111; letter-spacing: 0.05em;">
                        Login
                    </h2>

                    <?php if($error): ?>
                        <div class="alert py-3 px-4 mb-4" style="background-color: #fdf3f3; border-left: 4px solid #c8232c; border-top: 1px solid #f8d7da; border-right: 1px solid #f8d7da; border-bottom: 1px solid #f8d7da; color: #721c24; font-size: 14px; font-weight: 500; border-radius: 4px;">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Email <span style="color: #c8232c;">*</span>
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Password <span style="color: #c8232c;">*</span>
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>

                        <button 
                            type="submit"
                            class="btn btn-block text-uppercase"
                            style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 14px 24px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out; box-shadow: none;"
                            onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                            onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
                        >
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-4" style="font-size: 14px; color: #555555; font-weight: 500;">
                        New customer? 
                        <a href="register.php" style="color: #111111; font-weight: 700; text-decoration: none; border-bottom: 1px solid #111111; transition: all 0.2s;" onmouseover="this.style.color='#c8232c'; this.style.borderColor='#c8232c';" onmouseout="this.style.color='#111111'; this.style.borderColor='#111111';">
                            Register
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>