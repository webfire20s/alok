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

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                <div class="card-body p-4 p-md-5">

                    <h2 class="mb-4 text-center text-uppercase" style="font-size: 24px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 12px;">
                        Track Your Order
                        <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background-color: #c8232c;"></span>
                    </h2>

                    <?php if($error): ?>
                        <div class="alert py-3 px-4 mb-4" style="background-color: #fff5f5; border-left: 4px solid #c8232c; border-top: 1px solid #f8d7da; border-right: 1px solid #f8d7da; border-bottom: 1px solid #f8d7da; color: #c8232c; font-size: 14px; font-weight: 500; border-radius: 0 4px 4px 0;">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Order Number</label>
                            <input
                                type="text"
                                name="order_number"
                                class="form-control"
                                required
                                style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none;"
                            >
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Email Address</label>
                            <input
                                type="email"
                                name="customer_email"
                                class="form-control"
                                required
                                style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none;"
                            >
                        </div>

                        <button
                            type="submit"
                            class="btn text-uppercase w-100"
                            style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 12px 24px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out;"
                            onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                            onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
                        >
                            Track Order
                        </button>

                    </form>

                </div>

            </div>

            <?php if($order): ?>

                <div class="card style-meta-response mt-4" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                    <div class="card-body p-4 p-md-5">

                        <h4 class="mb-4 text-uppercase" style="font-size: 16px; font-weight: 700; color: #111111; letter-spacing: 0.05em;">
                            Order Status
                        </h4>

                        <div class="mb-3 d-flex align-items-center" style="font-size: 14px; color: #333333; border-bottom: 1px dashed #eeeeee; padding-bottom: 12px;">
                            <div style="min-width: 140px; font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em;">Order Number:</div>
                            <div style="font-weight: 600; color: #111111;"><?= htmlspecialchars($order['order_number']) ?></div>
                        </div>

                        <div class="mb-3 d-flex align-items-center" style="font-size: 14px; color: #333333; border-bottom: 1px dashed #eeeeee; padding-bottom: 12px;">
                            <div style="min-width: 140px; font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em;">Date:</div>
                            <div style="font-weight: 500; color: #555555;"><?= date('d M Y', strtotime($order['created_at'])) ?></div>
                        </div>

                        <div class="mb-3 d-flex align-items-center" style="font-size: 14px; color: #333333; border-bottom: 1px dashed #eeeeee; padding-bottom: 12px;">
                            <div style="min-width: 140px; font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em;">Grand Total:</div>
                            <div style="font-weight: 600; color: #111111;">₹<?= number_format($order['grand_total'], 2) ?></div>
                        </div>

                        <div class="mb-3 d-flex align-items-center" style="font-size: 14px; color: #333333; border-bottom: 1px dashed #eeeeee; padding-bottom: 12px;">
                            <div style="min-width: 140px; font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em;">Shipping:</div>
                            <div style="font-weight: 500; color: #555555;">₹<?= number_format($order['shipping_charge'], 2) ?></div>
                        </div>

                        <div class="mb-4 d-flex align-items-center" style="font-size: 14px; color: #333333; padding-bottom: 4px;">
                            <div style="min-width: 140px; font-weight: 600; text-transform: uppercase; font-size: 11px; color: #777777; letter-spacing: 0.05em;">Current Status:</div>
                            <div>
                                <span class="badge text-uppercase" style="background-color: #f4f6f8; color: #c8232c; border: 1px solid #c8232c; font-size: 11px; font-weight: 700; letter-spacing: 0.05em; padding: 6px 14px; border-radius: 4px;">
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

                        <div class="tracking-wrapper mt-5" style="position: relative; display: flex; justify-content: space-between; align-items: center; width: 100%; padding-top: 20px;">
                            
                            <div class="track-line" style="position: absolute; top: 36px; left: 0; right: 0; height: 3px; background-color: #eeeeee; z-index: 1;"></div>
                            
                            <div style="position: absolute; top: 36px; left: 0; width: <?= (($currentStep - 1) / 4) * 100 ?>%; height: 3px; background-color: #c8232c; z-index: 2; transition: width 0.4s ease;"></div>

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
                                        width: 34px; 
                                        height: 34px; 
                                        line-height: 32px; 
                                        border-radius: 50%; 
                                        background-color: <?= $active ? '#c8232c' : '#ffffff' ?>; 
                                        color: <?= $active ? '#ffffff' : '#999999' ?>; 
                                        font-size: 12px; 
                                        font-weight: 700; 
                                        border: 2px solid <?= $active ? '#c8232c' : '#eeeeee' ?>;
                                        transition: all 0.3s ease;
                                    ">
                                        <?= $step ?>
                                    </div>

                                    <div class="label mt-2" style="
                                        font-size: 11px; 
                                        font-weight: <?= $active ? '700' : '500' ?>; 
                                        color: <?= $active ? '#111111' : '#888888' ?>; 
                                        text-transform: uppercase; 
                                        letter-spacing: 0.02em;
                                    ">
                                        <?= htmlspecialchars($label) ?>
                                    </div>

                                </div>
                            <?php endforeach; ?>

                        </div>

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