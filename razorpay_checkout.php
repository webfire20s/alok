<?php

session_start();

require 'vendor/autoload.php';
require 'includes/payment_config.php';

use Razorpay\Api\Api;

/*
|--------------------------------------------------------------------------
| PENDING ORDER CHECK
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['pending_order'])) {

    header("Location: checkout.php");
    exit;

}

$order = $_SESSION['pending_order'];

/*
|--------------------------------------------------------------------------
| CREATE API INSTANCE
|--------------------------------------------------------------------------
*/

$api = new Api(
    RAZORPAY_KEY_ID,
    RAZORPAY_KEY_SECRET
);

/*
|--------------------------------------------------------------------------
| CREATE RAZORPAY ORDER
|--------------------------------------------------------------------------
*/

$receipt = $order['order_number'];

$razorpayOrder = $api->order->create([

    'receipt'         => $receipt,

    'amount'          => round($order['grand_total'] * 100),

    'currency'        => 'INR',

    'payment_capture' => 1

]);

/*
|--------------------------------------------------------------------------
| SAVE ORDER ID
|--------------------------------------------------------------------------
*/

$_SESSION['pending_order']['razorpay_order_id'] = $razorpayOrder['id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Secure Payment</title>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

</head>

<body>

<script>

var options = {

    key: "<?= RAZORPAY_KEY_ID ?>",

    amount: "<?= $razorpayOrder['amount'] ?>",

    currency: "INR",

    name: "Alok Glass",

    description: "Order Payment",

    image: "assets/images/logo.png",

    order_id: "<?= $razorpayOrder['id'] ?>",

    handler: function (response) {

        var form = document.createElement("form");

        form.method = "POST";

        form.action = "razorpay_verify.php";

        form.innerHTML =
            '<input type="hidden" name="razorpay_payment_id" value="' + response.razorpay_payment_id + '">' +
            '<input type="hidden" name="razorpay_order_id" value="' + response.razorpay_order_id + '">' +
            '<input type="hidden" name="razorpay_signature" value="' + response.razorpay_signature + '">';

        document.body.appendChild(form);

        form.submit();

    },

    prefill: {

        name: "<?= htmlspecialchars($order['customer_name'], ENT_QUOTES) ?>",

        email: "<?= htmlspecialchars($order['customer_email'], ENT_QUOTES) ?>",

        contact: "<?= htmlspecialchars($order['customer_phone'], ENT_QUOTES) ?>"

    },

    modal: {

        escape: false,

        ondismiss: function () {

            window.location = "checkout.php";

        }

    },

    retry: {

        enabled: true,

        max_count: 3

    },

    theme: {

        color: "#c8232c"

    }

};

var rzp = new Razorpay(options);

rzp.open();

</script>

</body>

</html>