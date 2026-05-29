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

<div class="container pt-5 pb-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <h2 class="mb-4 text-center">

                        Track Your Order

                    </h2>

                    <?php if($error): ?>

                        <div class="alert alert-danger">

                            <?= $error ?>

                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group">

                            <label>
                                Order Number
                            </label>

                            <input
                                type="text"
                                name="order_number"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="form-group">

                            <label>
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="customer_email"
                                class="form-control"
                                required
                            >

                        </div>

                        <button
                            class="btn btn-org btn-block"
                        >

                            Track Order

                        </button>

                    </form>

                </div>

            </div>

            <?php if($order): ?>

                <div class="card shadow-sm border-0 mt-4">

                    <div class="card-body p-4">

                        <h4 class="mb-4">

                            Order Status

                        </h4>

                        <div class="mb-3">

                            <strong>
                                Order Number:
                            </strong>

                            <?= htmlspecialchars(
                                $order['order_number']
                            ) ?>

                        </div>

                        <div class="mb-3">

                            <strong>
                                Date:
                            </strong>

                            <?= date(
                                'd M Y',
                                strtotime($order['created_at'])
                            ) ?>

                        </div>

                        <div class="mb-3">

                            <strong>
                                Grand Total:
                            </strong>

                            ₹<?= number_format(
                                $order['grand_total'],
                                2
                            ) ?>

                        </div>
                        <div class="mb-3">

                            <strong>
                                Shipping:
                            </strong>

                            ₹<?= number_format($order['shipping_charge'], 2) ?>

                        </div>

                        <div class="mb-4">

                            <strong>
                                Current Status:
                            </strong>

                            <span
                                class="badge badge-info p-2"
                            >

                                <?= ucfirst(
                                    $order['order_status']
                                ) ?>

                            </span>

                        </div>

                        <?php

                        $statusSteps = [
                            'pending'   => 1,
                            'confirmed' => 2,
                            'processing'=> 3,
                            'shipped'   => 4,
                            'delivered' => 5
                        ];

                        $currentStep =
                        $statusSteps[$order['order_status']] ?? 1;

                        ?>

                        <div class="tracking-wrapper mt-5">

                            <div class="track-line"></div>

                            <?php

                            $labels = [
                                1 => 'Pending',
                                2 => 'Confirmed',
                                3 => 'Processing',
                                4 => 'Shipped',
                                5 => 'Delivered'
                            ];

                            foreach($labels as $step => $label):

                                $active =
                                $step <= $currentStep;

                            ?>

                                <div class="step">

                                    <div class="circle <?= $active ? 'active' : '' ?>">

                                        <?= $step ?>

                                    </div>

                                    <div class="label">

                                        <?= $label ?>

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
<style>

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

</style>



<?php include 'includes/footer.php'; ?>