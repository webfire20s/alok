<?php

session_start();

require 'includes/db.php';

include 'includes/header.php';

$sessionId = session_id();

/*
|--------------------------------------------------------------------------
| GET CART ITEMS
|--------------------------------------------------------------------------
*/

$userId = $_SESSION['user_id'] ?? null;

$sessionId = session_id();

if($userId){

    $stmt = $pdo->prepare("
        SELECT
            cart.*,
            products.name,
            products.image,
            products.slug,
            products.price
        FROM cart
        JOIN products
        ON cart.product_id = products.id
        WHERE cart.user_id = ?
        ORDER BY cart.id DESC
    ");

    $stmt->execute([$userId]);

}else{

    $stmt = $pdo->prepare("
        SELECT
            cart.*,
            products.name,
            products.image,
            products.slug,
            products.price
        FROM cart
        JOIN products
        ON cart.product_id = products.id
        WHERE cart.session_id = ?
        ORDER BY cart.id DESC
    ");

    $stmt->execute([$sessionId]);

}

$cartItems = $stmt->fetchAll();

if(empty($cartItems)){

    header("Location: cart.php");

    exit;
}

$subtotal = 0;

$totalGST = 0;

?>

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif;">

    <form action="place_order.php" method="POST">   
        
        <div class="row">

            <div class="col-md-7">

                <h3 class="text-uppercase mb-4" style="font-size: 18px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 12px;">
                    Billing Details
                    <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background-color: #c8232c;"></span>
                </h3>

                <div class="form-group mb-4">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Full Name <span style="color: #c8232c;">*</span>
                    </label>
                    <input
                        type="text"
                        name="customer_name"
                        class="form-control"
                        required
                        style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#111111';"
                        onblur="this.style.borderColor='#cccccc';"
                    >
                </div>

                <div class="form-group mb-4">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Email <span style="color: #c8232c;">*</span>
                    </label>
                    <input
                        type="email"
                        name="customer_email"
                        class="form-control"
                        required
                        style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#111111';"
                        onblur="this.style.borderColor='#cccccc';"
                    >
                </div>

                <div class="form-group mb-4">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Phone <span style="color: #c8232c;">*</span>
                    </label>
                    <input
                        type="text"
                        name="customer_phone"
                        class="form-control"
                        required
                        style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#111111';"
                        onblur="this.style.borderColor='#cccccc';"
                    >
                </div>

                <div class="form-group mb-4">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Company Name
                    </label>
                    <input
                        type="text"
                        name="customer_company"
                        class="form-control"
                        style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#111111';"
                        onblur="this.style.borderColor='#cccccc';"
                    >
                </div>

                <div class="form-group mb-4">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Address <span style="color: #c8232c;">*</span>
                    </label>
                    <textarea
                        name="customer_address"
                        class="form-control"
                        rows="4"
                        required
                        style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 12px 14px; box-shadow: none; transition: border-color 0.2s; resize: vertical;"
                        onfocus="this.style.borderColor='#111111';"
                        onblur="this.style.borderColor='#cccccc';"
                    ></textarea>
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                City <span style="color: #c8232c;">*</span>
                            </label>
                            <input
                                type="text"
                                name="customer_city"
                                class="form-control"
                                required
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                State <span style="color: #c8232c;">*</span>
                            </label>
                            <input
                                type="text"
                                name="customer_state"
                                class="form-control"
                                required
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Pincode <span style="color: #c8232c;">*</span>
                            </label>
                            <input
                                type="text"
                                name="customer_pincode"
                                class="form-control"
                                required
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>
                    </div>

                </div>

                        <div class="form-group mb-4">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                        Payment Method <span style="color: #c8232c;">*</span>
                    </label>
                    <select
                        name="payment_method"
                        class="form-control"
                        style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; appearance: none; -webkit-appearance: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#111111';"
                        onblur="this.style.borderColor='#cccccc';"
                    >
                        <option value="inquiry">Inquiry / Manual Payment</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                </div>

            </div>

            <div class="col-md-5">

                <div class="p-4 p-md-5" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff;">

                    <h4 class="text-uppercase mb-4" style="font-size: 15px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 10px;">
                        Order Summary
                        <span style="position: absolute; bottom: 0; left: 0; width: 30px; height: 2px; background-color: #c8232c;"></span>
                    </h4>

                    <?php foreach($cartItems as $item): ?>

                        <?php
                        $qty = $item['quantity'];
                        $price = $item['price'];
                        $gstPercent = $item['gst_percent'];
                        
                        $lineSubtotal = $price * $qty;
                        $gstAmount = ($lineSubtotal * $gstPercent) / 100;
                        $lineTotal = $lineSubtotal + $gstAmount;
                        
                        $subtotal += $lineSubtotal;
                        $totalGST += $gstAmount;
                        ?>

                        <div class="d-flex justify-content-between mb-3 pb-3" style="border-bottom: 1px dashed #eeeeee; font-size: 14px;">
                            
                            <div>
                                <span style="color: #111111; font-weight: 600; display: block; margin-bottom: 2px;">
                                    <?= htmlspecialchars($item['name']) ?>
                                </span>
                                <small style="color: #777777; font-weight: 500; font-size: 12px;">
                                    Qty: <?= $qty ?> (<?= ucfirst($item['order_unit']) ?>)
                                </small>
                            </div>

                            <div style="color: #111111; font-weight: 600; padding-top: 2px;">
                                ₹<?= number_format($lineTotal, 2) ?>
                            </div>

                        </div>

                    <?php endforeach; ?>

                    <?php
                    $grandTotal = $subtotal + $totalGST;
                    ?>

                    <div class="pt-2" style="font-size: 14px;">

                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #777777; font-weight: 500;">Subtotal</span>
                            <span style="color: #111111; font-weight: 600;">₹<?= number_format($subtotal, 2) ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span style="color: #777777; font-weight: 500;">GST</span>
                            <span style="color: #111111; font-weight: 600;">₹<?= number_format($totalGST, 2) ?></span>
                        </div>

                        <div class="d-flex justify-content-between pt-3 mb-4" style="border-top: 1px solid #eeeeee;">
                            <h5 class="text-uppercase" style="font-size: 14px; font-weight: 700; color: #111111; letter-spacing: 0.03em; margin: 0;">Grand Total</h5>
                            <h5 style="font-size: 16px; font-weight: 700; color: #c8232c; margin: 0;">₹<?= number_format($grandTotal, 2) ?></h5>
                        </div>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-block text-uppercase"
                        style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 14px 24px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out; box-shadow: none;"
                        onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                        onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
                    >
                        Place Order
                    </button>

                </div>

            </div>
                
        </div>

    </form>

</div>

<?php include 'includes/footer.php'; ?>