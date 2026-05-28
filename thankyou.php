<?php include 'includes/header.php'; ?>

<div class="container pt-5 pb-5 text-center">

    <h2 class="mb-4 text-success">
        Order Placed Successfully
    </h2>

    <p class="lead">
        Thank you for your order.
    </p>

    <p>
        Your Order Number:
        <strong>
            <?= htmlspecialchars($_GET['order'] ?? '') ?>
        </strong>
    </p>

    <a href="index.php" class="btn btn-org mt-3">
        Continue Shopping
    </a>

</div>

<?php include 'includes/footer.php'; ?>