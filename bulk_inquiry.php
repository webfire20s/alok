<?php

require 'includes/db.php';

$productId =
    (int)($_GET['product_id'] ?? 0);

$product = null;

if($productId){

    $stmt = $pdo->prepare("
        SELECT *
        FROM products
        WHERE id = ?
    ");

    $stmt->execute([$productId]);

    $product = $stmt->fetch();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $productId =
        $_POST['product_id'];

    $productName =
        trim($_POST['product_name']);

    $customerName =
        trim($_POST['customer_name']);

    $companyName =
        trim($_POST['company_name']);

    $email =
        trim($_POST['email']);

    $phone =
        trim($_POST['phone']);

    $quantity =
        trim($_POST['quantity']);

    $message =
        trim($_POST['message']);

    $stmt = $pdo->prepare("
        INSERT INTO bulk_inquiries(

            product_id,
            product_name,
            customer_name,
            company_name,
            email,
            phone,
            quantity,
            message

        ) VALUES(

            ?,?,?,?,?,?,?,?

        )
    ");

    $stmt->execute([

        $productId,
        $productName,
        $customerName,
        $companyName,
        $email,
        $phone,
        $quantity,
        $message

    ]);

    $success = true;
}

include 'includes/header.php';

?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="mb-4">

                        Request Bulk Quote

                    </h2>

                    <?php if(!empty($success)): ?>

                        <div class="alert alert-success">

                            Thank you.

                            Our team will contact you shortly.

                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= $product['id'] ?? '' ?>"
                        >

                        <div class="form-group">

                            <label>

                                Product

                            </label>

                            <input
                                type="text"
                                name="product_name"
                                class="form-control"
                                value="<?= htmlspecialchars($product['name'] ?? '') ?>"
                                readonly
                            >

                        </div>

                        <div class="form-group">

                            <label>

                                Full Name

                            </label>

                            <input
                                type="text"
                                name="customer_name"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="form-group">

                            <label>

                                Company Name

                            </label>

                            <input
                                type="text"
                                name="company_name"
                                class="form-control"
                            >

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Email</label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        required
                                    >

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Phone</label>

                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <label>

                                Required Quantity

                            </label>

                            <input
                                type="text"
                                name="quantity"
                                class="form-control"
                                placeholder="Example: 100 Boxes"
                                required
                            >

                        </div>

                        <div class="form-group">

                            <label>

                                Additional Requirements

                            </label>

                            <textarea
                                name="message"
                                rows="5"
                                class="form-control"
                            ></textarea>

                        </div>

                        <button
                            class="btn btn-org btn-lg"
                        >

                            Submit Inquiry

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>