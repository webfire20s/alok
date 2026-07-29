<?php

/*
|--------------------------------------------------------------------------
| PAYMENT MODE
|--------------------------------------------------------------------------
|
| test = Razorpay Test Keys
| live = Razorpay Live Keys
|
*/

define('PAYMENT_MODE', 'live'); // change to live when going production

/*
|--------------------------------------------------------------------------
| TEST KEYS
|--------------------------------------------------------------------------
*/

define('RAZORPAY_TEST_KEY_ID', 'rzp_live_TIVZpFeF3SCu8f');

define('RAZORPAY_TEST_KEY_SECRET', 'b2Mb1ZaYET6bxxlEsbOfUIAG');

/*
|--------------------------------------------------------------------------
| LIVE KEYS
|--------------------------------------------------------------------------
*/

define('RAZORPAY_LIVE_KEY_ID', 'rzp_live_TIVZpFeF3SCu8f');

define('RAZORPAY_LIVE_KEY_SECRET', 'b2Mb1ZaYET6bxxlEsbOfUIAG');

/*
|--------------------------------------------------------------------------
| AUTO SELECT
|--------------------------------------------------------------------------
*/

if (PAYMENT_MODE === 'live') {

    define('RAZORPAY_KEY_ID', RAZORPAY_LIVE_KEY_ID);

    define('RAZORPAY_KEY_SECRET', RAZORPAY_LIVE_KEY_SECRET);

} else {

    define('RAZORPAY_KEY_ID', RAZORPAY_TEST_KEY_ID);

    define('RAZORPAY_KEY_SECRET', RAZORPAY_TEST_KEY_SECRET);

}