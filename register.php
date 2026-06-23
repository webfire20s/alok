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

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif;">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                <div class="card-body p-4 p-md-5">

                    <h2 class="text-uppercase text-center mb-4" style="font-size: 22px; font-weight: 700; color: #111111; letter-spacing: 0.05em;">
                        Register
                    </h2>

                    <?php if(!empty($error)): ?>
                        <div class="alert py-3 px-4 mb-4" style="background-color: #fdf3f3; border-left: 4px solid #c8232c; border-top: 1px solid #f8d7da; border-right: 1px solid #f8d7da; border-bottom: 1px solid #f8d7da; color: #721c24; font-size: 14px; font-weight: 500; border-radius: 4px;">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($success)): ?>
                        <div class="alert py-3 px-4 mb-4" style="background-color: #f4faf7; border-left: 4px solid #28a745; border-top: 1px solid #d4edda; border-right: 1px solid #d4edda; border-bottom: 1px solid #d4edda; color: #155724; font-size: 14px; font-weight: 500; border-radius: 4px;">
                            <?= $success ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Full Name <span style="color: #c8232c;">*</span>
                            </label>
                            <input
                                type="text"
                                name="full_name"
                                class="form-control"
                                required
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>

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

                        <div class="form-group mb-3">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Phone
                            </label>
                            <input
                                type="text"
                                name="phone"
                                class="form-control"
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
                            Create Account
                        </button>

                    </form>
 
                    <div class="text-center mt-4" style="font-size: 14px; color: #555555; font-weight: 500;">
                        Already have account? 
                        <a href="login.php" style="color: #111111; font-weight: 700; text-decoration: none; border-bottom: 1px solid #111111; transition: all 0.2s;" onmouseover="this.style.color='#c8232c'; this.style.borderColor='#c8232c';" onmouseout="this.style.color='#111111'; this.style.borderColor='#111111';">
                            Login
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<?php include 'includes/footer.php'; ?>