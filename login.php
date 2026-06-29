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

    <!-- Integrated Corporate Theme Styles & Keyframes -->
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes lineExpandCenter {
            from { width: 0; }
            to { width: 45px; }
        }
        .animate-fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        .themed-auth-card {
            background: #ffffff; 
            padding: 40px; 
            border-radius: 16px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.05); 
            border: 1px solid #eeeeee;
        }
        .themed-input {
            height: 48px; 
            border-radius: 8px; 
            border: 1px solid #e0e0e0; 
            font-size: 14px; 
            font-weight: 400; 
            color: #222222; 
            box-shadow: none;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        .themed-input:focus {
            border-color: #c8232c !important;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(200, 35, 44, 0.1) !important;
        }
        .btn-animate {
            background: linear-gradient(135deg, #111111 0%, #222222 100%);
            color: #ffffff; 
            font-size: 13px; 
            font-weight: 700; 
            letter-spacing: 0.08em; 
            padding: 14px 32px; 
            border-radius: 8px; 
            border: none; 
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: color 0.4s ease;
        }
        .btn-animate::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #c8232c 0%, #91131a 100%);
            z-index: -1;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            transform: scaleX(0);
            transform-origin: right;
        }
        .btn-animate:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        .btn-animate:hover {
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(200, 35, 44, 0.3);
        }
        .themed-link {
            color: #111111;
            font-weight: 700;
            text-decoration: none;
            border-bottom: 2px solid #111111;
            transition: all 0.3s ease;
            padding-bottom: 1px;
        }
        .themed-link:hover {
            color: #c8232c;
            border-bottom-color: #c8232c;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-md-5">

            <!-- Premium Identity Access Portal Card -->
            <div class="themed-auth-card animate-fade-in" style="animation-delay: 0.1s;">

                <h2 class="text-uppercase text-center mb-4" style="font-size: 24px; font-weight: 800; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 16px;">
                    Login
                    <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); animation: lineExpandCenter 1s cubic-bezier(0.25, 1, 0.5, 1) forwards; border-radius: 2px;"></span>
                </h2>

                <?php if($error): ?>
                    <div class="alert py-3 px-4 mb-4" style="background-color: #fff5f5; border-left: 4px solid #c8232c; color: #c8232c; font-size: 14px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(200, 35, 44, 0.05); animation: fadeInUp 0.4s ease;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; margin-bottom: 8px; display: block;">
                            Email Address <span style="color: #c8232c;">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            class="form-control themed-input"
                            required
                        >
                    </div>

                    <div class="form-group mb-4">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; margin-bottom: 8px; display: block;">
                            Password <span style="color: #c8232c;">*</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="form-control themed-input"
                            required
                        >
                    </div>

                    <button 
                        type="submit"
                        class="btn btn-animate text-uppercase w-100"
                    >
                        Login
                    </button>

                </form>

                <div class="text-center mt-4" style="font-size: 13px; color: #666666; font-weight: 500; letter-spacing: 0.02em;">
                    New customer? 
                    <a href="register.php" class="themed-link text-uppercase" style="font-size: 12px;">
                        Register
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>