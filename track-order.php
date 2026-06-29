<?php

require 'includes/db.php';

include 'includes/header.php';

$order = null;

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $orderNumber =
    trim($_POST['order_number'] ?? '');

    $email =
    trim($_POST['customer_email'] ?? '');

    $stmt = $pdo->prepare("
        SELECT *
        FROM orders
        WHERE order_number = ?
        AND customer_email = ?
    ");

    $stmt->execute([
        $orderNumber,
        $email
    ]);

    $order = $stmt->fetch();

    if(!$order){

        $error =
        "Order not found.";

    }
}

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
            to { width: 60px; }
        }
        .animate-fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        .themed-tracking-card {
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
        .status-row-card {
            transition: transform 0.3s ease;
            background: rgba(200, 35, 44, 0.02); 
            border-left: 3px solid #c8232c;
        }
        .status-row-card:hover {
            transform: translateX(5px);
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-md-7">

            <!-- Order Tracking Input Card -->
            <div class="themed-tracking-card animate-fade-in" style="animation-delay: 0.1s;">
                
                <h2 class="mb-4 text-center text-uppercase" style="font-size: 26px; font-weight: 800; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 16px;">
                    Track Your Order
                    <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); animation: lineExpandCenter 1s cubic-bezier(0.25, 1, 0.5, 1) forwards; border-radius: 2px;"></span>
                </h2>

                <?php if($error): ?>
                    <div class="alert alert-neutral py-3 px-4 mb-4" style="background-color: #fff5f5; border-left: 4px solid #c8232c; color: #c8232c; font-size: 14px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(200, 35, 44, 0.05); animation: fadeInUp 0.4s ease;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; display: block; margin-bottom: 8px;">Order Number</label>
                        <input
                            type="text"
                            name="order_number"
                            class="form-control themed-input"
                            required
                        >
                    </div>

                    <div class="form-group mb-4">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; display: block; margin-bottom: 8px;">Email Address</label>
                        <input
                            type="email"
                            name="customer_email"
                            class="form-control themed-input"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="btn btn-animate text-uppercase w-100"
                    >
                        Track Order
                    </button>
                </form>

            </div>

            <!-- Tracking Response Metadata Display -->
            <?php if($order): ?>
                <div class="themed-tracking-card mt-4 animate-fade-in" style="animation-delay: 0.2s;">

                    <h4 class="mb-4 text-uppercase" style="font-size: 15px; font-weight: 800; color: #111111; letter-spacing: 0.08em; border-bottom: 2px solid #111111; padding-bottom: 8px; display: inline-block;">
                        Order Details
                    </h4>

                    <div class="mb-3 d-flex align-items-center p-3 status-row-card">
                        <div style="min-width: 140px; font-weight: 700; text-transform: uppercase; font-size: 11px; color: #c8232c; letter-spacing: 0.05em;">Order Number</div>
                        <div style="font-weight: 700; color: #111111; font-size: 14px;"><?= htmlspecialchars($order['order_number']) ?></div>
                    </div>

                    <div class="mb-3 d-flex align-items-center p-3 status-row-card" style="background: rgba(0, 0, 0, 0.01); border-left-color: #111111;">
                        <div style="min-width: 140px; font-weight: 700; text-transform: uppercase; font-size: 11px; color: #111111; letter-spacing: 0.05em;">Booking Date</div>
                        <div style="font-weight: 500; color: #555555; font-size: 14px;"><?= date('d M Y', strtotime($order['created_at'])) ?></div>
                    </div>

                    <div class="mb-3 d-flex align-items-center p-3 status-row-card">
                        <div style="min-width: 140px; font-weight: 700; text-transform: uppercase; font-size: 11px; color: #c8232c; letter-spacing: 0.05em;">Grand Total</div>
                        <div style="font-weight: 700; color: #111111; font-size: 14px;">₹<?= number_format($order['grand_total'], 2) ?></div>
                    </div>

                    <div class="mb-3 d-flex align-items-center p-3 status-row-card" style="background: rgba(0, 0, 0, 0.01); border-left-color: #111111;">
                        <div style="min-width: 140px; font-weight: 700; text-transform: uppercase; font-size: 11px; color: #111111; letter-spacing: 0.05em;">Freight/Shipping</div>
                        <div style="font-weight: 500; color: #555555; font-size: 14px;">₹<?= number_format($order['shipping_charge'], 2) ?></div>
                    </div>

                    <div class="mb-4 d-flex align-items-center p-3 status-row-card">
                        <div style="min-width: 140px; font-weight: 700; text-transform: uppercase; font-size: 11px; color: #c8232c; letter-spacing: 0.05em;">Current Status</div>
                        <div>
                            <span class="badge text-uppercase" style="background-color: rgba(200, 35, 44, 0.05); color: #c8232c; border: 1px solid #c8232c; font-size: 11px; font-weight: 700; letter-spacing: 0.06em; padding: 6px 14px; border-radius: 4px;">
                                <?= htmlspecialchars(ucfirst($order['order_status'])) ?>
                            </span>
                        </div>
                    </div>

                    <?php
                    $statusSteps = [
                        'pending'   => 1,
                        'confirmed' => 2,
                        'processing'=> 3,
                        'shipped'   => 4,
                        'delivered' => 5
                    ];
                    $currentStep = $statusSteps[$order['order_status']] ?? 1;
                    ?>

                    <!-- Visual Timeline Bar -->
                    <div class="tracking-wrapper mt-5" style="position: relative; display: flex; justify-content: space-between; align-items: center; width: 100%; padding-top: 20px;">
                        
                        <div class="track-line" style="position: absolute; top: 36px; left: 0; right: 0; height: 4px; background-color: #eeeeee; z-index: 1; border-radius: 2px;"></div>
                        
                        <div style="position: absolute; top: 36px; left: 0; width: <?= (($currentStep - 1) / 4) * 100 ?>%; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); z-index: 2; transition: width 0.6s cubic-bezier(0.25, 1, 0.5, 1); border-radius: 2px;"></div>

                        <?php
                        $labels = [
                            1 => 'Pending',
                            2 => 'Confirmed',
                            3 => 'Processing',
                            4 => 'Shipped',
                            5 => 'Delivered'
                        ];

                        foreach($labels as $step => $label):
                            $active = $step <= $currentStep;
                        ?>
                            <div class="step" style="position: relative; z-index: 3; text-align: center; display: flex; flex-direction: column; align-items: center; flex: 1;">
                                
                                <div class="circle text-center" style="
                                    width: 36px; 
                                    height: 36px; 
                                    line-height: 32px; 
                                    border-radius: 50%; 
                                    background-color: <?= $active ? '#c8232c' : '#ffffff' ?>; 
                                    color: <?= $active ? '#ffffff' : '#999999' ?>; 
                                    font-size: 12px; 
                                    font-weight: 700; 
                                    border: 2px solid <?= $active ? '#c8232c' : '#eeeeee' ?>;
                                    box-shadow: <?= $active ? '0 4px 12px rgba(200, 35, 44, 0.2)' : 'none' ?>;
                                    transition: all 0.4s ease;
                                ">
                                    <?= $step ?>
                                </div>

                                <div class="label mt-2" style="
                                    font-size: 10px; 
                                    font-weight: <?= $active ? '700' : '500' ?>; 
                                    color: <?= $active ? '#111111' : '#888888' ?>; 
                                    text-transform: uppercase; 
                                    letter-spacing: 0.05em;
                                    transition: color 0.4s ease;
                                ">
                                    <?= htmlspecialchars($label) ?>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>

                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- <style>
.tracking-wrapper{
    display:flex;
    justify-content:space-between;
    gap:10px;
    flex-wrap:wrap;
}
.tracking-step{
    text-align:center;
    flex:1;
}
.tracking-circle{
    width:50px;
    height:50px;
    border-radius:50%;
    background:#ddd;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    font-weight:bold;
    margin-bottom:10px;
}
.tracking-step.active .tracking-circle{
    background:#ff6a00;
}
.tracking-label{
    font-size:14px;
    font-weight:600;
}
</style>
<style>
    .tracking-wrapper{
        position:relative;
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        margin-top:40px;
    }
    .track-line{
        position:absolute;
        top:22px;
        left:0;
        right:0;
        height:4px;
        background:#ddd;
        z-index:1;
    }
    .step{
        position:relative;
        z-index:2;
        text-align:center;
        width:20%;
    }
    .circle{
        width:45px;
        height:45px;
        border-radius:50%;
        background:#ddd;
        color:#fff;
        margin:auto;
        line-height:45px;
        font-weight:bold;
    }
    .circle.active{
        background:#28a745;
    }
    .label{
        margin-top:10px;
        font-size:14px;
        font-weight:600;
    }
</style> -->
<?php include 'includes/footer.php'; ?>