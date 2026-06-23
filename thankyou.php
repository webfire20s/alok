<?php include 'includes/header.php'; ?>

<div class="container pt-5 pb-5 text-center" style="font-family: 'Montserrat', sans-serif;">

    <div class="mb-4 d-inline-flex align-items-center justify-content-center" style="width: 64px; height: 64px; border-radius: 50%; background-color: #f4faf7; border: 1px solid #d4edda;">
        <span style="color: #28a745; font-size: 28px; font-weight: 400; line-height: 1;">&checkmark;</span>
    </div>

    <h2 class="text-uppercase mb-3" style="font-size: 24px; font-weight: 700; color: #111111; letter-spacing: 0.05em;">
        Order Placed Successfully
    </h2>

    <p class="lead mb-4" style="font-size: 16px; color: #555555; font-weight: 500;">
        Thank you for your order.
    </p>

    <div class="d-inline-block p-4 mb-4" style="background-color: #ffffff; border: 1px solid #eeeeee; border-radius: 4px; min-width: 280px;">
        <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #777777; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">
            Your Order Number
        </span>
        <strong style="font-size: 18px; font-weight: 700; color: #111111; letter-spacing: 0.02em;">
            <?= htmlspecialchars($_GET['order'] ?? '') ?>
        </strong>
    </div>

    <br>

    <a 
        href="index.php" 
        class="btn text-uppercase mt-2"
        style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 14px 32px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out; box-shadow: none;"
        onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
        onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
    >
        Continue Shopping
    </a>

</div>

<?php include 'includes/footer.php'; ?>