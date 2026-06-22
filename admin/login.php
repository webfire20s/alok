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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/themes/storefront/public/css/bootstrap.mine8da.css">
    
    <style>
        body {
            background-color: #0b0f17;
            background-image: 
                radial-gradient(at 0% 0%, rgba(56, 189, 248, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(2, 132, 199, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .glass-login-card {
            border-radius: 16px;
            background: rgba(21, 25, 34, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .glass-input-field {
            background: rgba(15, 17, 21, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 8px !important;
            color: #ffffff !important;
            font-size: 14px !important;
            padding: 11px 14px !important;
            transition: all 0.2s ease-in-out !important;
        }
        .glass-input-field:focus {
            background: rgba(15, 17, 21, 0.6) !important;
            border-color: rgba(56, 189, 248, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15) !important;
        }
        .glass-label {
            color: #94a3b8; 
            font-size: 11px; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
            margin-bottom: 8px; 
            display: block;
        }
        .glass-alert {
            background: rgba(239, 68, 68, 0.08) !important;
            border: 1px solid rgba(239, 68, 68, 0.2) !important;
            color: #f87171 !important;
            font-size: 13.5px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center w-100 m-0">
        <div class="col-md-5 col-lg-4 p-0">

            <div class="card glass-login-card shadow-lg">
                <div class="card-body p-4 p-sm-5">

                    <div class="text-center mb-4">
                        <h3 style="font-weight: 700; letter-spacing: -0.03em; color: #ffffff; margin-bottom: 6px;">
                            Admin Login
                        </h3>
                        <p style="color: #64748b; font-size: 13px; margin: 0;">
                            Secure control panel gateway infrastructure.
                        </p>
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert glass-alert mb-4">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-4">
                            <label class="glass-label">Username</label>
                            <input
                                type="text"
                                name="username"
                                class="form-control glass-input-field"
                                autocomplete="username"
                                required
                            >
                        </div>

                        <div class="form-group mb-4">
                            <label class="glass-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control glass-input-field"
                                autocomplete="current-password"
                                required
                            >
                        </div>

                        <div class="pt-2">
                            <button class="btn btn-block py-2.5" style="
                                background: linear-gradient(135deg, #38bdf8, #0284c7);
                                color: #ffffff;
                                font-size: 14px;
                                font-weight: 600;
                                border-radius: 8px;
                                border: none;
                                box-shadow: 0 4px 12px rgba(56, 189, 248, 0.15);
                                transition: all 0.2s ease-in-out;
                            "
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.3)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.15)';"
                            >
                                Login
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