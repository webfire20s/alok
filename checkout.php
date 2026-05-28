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

<div class="container pt-5 pb-5">

    <form action="place_order.php" method="POST">   
        <div class="row">

            <!-- BILLING FORM -->

            <div class="col-md-7">

                <h3 class="mb-4">
                    Billing Details
                </h3>


                        <div class="form-group">
                            <label>Full Name</label>

                            <input
                                type="text"
                                name="customer_name"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Email</label>

                            <input
                                type="email"
                                name="customer_email"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Phone</label>

                            <input
                                type="text"
                                name="customer_phone"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Company Name</label>

                            <input
                                type="text"
                                name="customer_company"
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label>Address</label>

                            <textarea
                                name="customer_address"
                                class="form-control"
                                rows="4"
                                required
                            ></textarea>
                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>City</label>

                                    <input
                                        type="text"
                                        name="customer_city"
                                        class="form-control"
                                        required
                                    >

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>State</label>

                                    <input
                                        type="text"
                                        name="customer_state"
                                        class="form-control"
                                        required
                                    >

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Pincode</label>

                                    <input
                                        type="text"
                                        name="customer_pincode"
                                        class="form-control"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <label>
                                Payment Method
                            </label>

                            <select
                                name="payment_method"
                                class="form-control"
                            >

                                <option value="inquiry">
                                    Inquiry / Manual Payment
                                </option>

                                <option value="cod">
                                    Cash on Delivery
                                </option>

                            </select>

                        </div>

                </div>

                <!-- ORDER SUMMARY -->

                <div class="col-md-5">

                    <div class="border p-4 shadow-sm">

                        <h4 class="mb-4">
                            Order Summary
                        </h4>

                        <?php foreach($cartItems as $item): ?>

                            <?php

                            $qty = $item['quantity'];

                            $price = $item['price'];

                            $gstPercent = $item['gst_percent'];

                            $lineSubtotal =
                            $price * $qty;

                            $gstAmount =
                            ($lineSubtotal * $gstPercent) / 100;

                            $lineTotal =
                            $lineSubtotal + $gstAmount;

                            $subtotal += $lineSubtotal;

                            $totalGST += $gstAmount;

                            ?>

                            <div class="d-flex justify-content-between mb-3">

                                <div>

                                    <?= htmlspecialchars($item['name']) ?>

                                    <br>

                                    <small>

                                        Qty:
                                        <?= $qty ?>

                                        (
                                        <?= ucfirst($item['order_unit']) ?>
                                        )

                                    </small>

                                </div>

                                <div>

                                    ₹<?= number_format($lineTotal, 2) ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                        <?php

                        $grandTotal =
                        $subtotal + $totalGST;

                        ?>

                        <hr>

                        <div class="d-flex justify-content-between">

                            <strong>
                                Subtotal
                            </strong>

                            <strong>
                                ₹<?= number_format($subtotal, 2) ?>
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mt-2">

                            <strong>
                                GST
                            </strong>

                            <strong>
                                ₹<?= number_format($totalGST, 2) ?>
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mt-3">

                            <h5>
                                Grand Total
                            </h5>

                            <h5>
                                ₹<?= number_format($grandTotal, 2) ?>
                            </h5>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-org btn-block mt-4"
                        >
                            Place Order
                        </button>

                    </div>

                    
                </div>
                
        </div>
    </form>

</div>

<?php include 'includes/footer.php'; ?>