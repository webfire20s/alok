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

<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none;">

                <div class="card-body p-4 p-md-5">

                    <h2 class="text-uppercase mb-4" style="font-size: 22px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 12px;">
                        Request Bulk Quote
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background-color: #c8232c;"></span>
                    </h2>

                    <?php if(!empty($success)): ?>
                        <div class="alert py-3 px-4 mb-4" style="background-color: #f4faf7; border-left: 4px solid #28a745; border-top: 1px solid #d4edda; border-right: 1px solid #d4edda; border-bottom: 1px solid #d4edda; color: #155724; font-size: 14px; font-weight: 500; border-radius: 4px;">
                            Thank you. Our team will contact you shortly.
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= $product['id'] ?? '' ?>"
                        >

                        <div class="form-group mb-4">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Product
                            </label>
                            <input
                                type="text"
                                name="product_name"
                                class="form-control"
                                value="<?= htmlspecialchars($product['name'] ?? '') ?>"
                                readonly
                                style="background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 4px; color: #666666; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none;"
                            >
                        </div>

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
                                Company Name
                            </label>
                            <input
                                type="text"
                                name="company_name"
                                class="form-control"
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>

                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                        Email <span style="color: #c8232c;">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        required
                                        style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='#111111';"
                                        onblur="this.style.borderColor='#cccccc';"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                        Phone <span style="color: #c8232c;">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="phone"
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
                                Required Quantity <span style="color: #c8232c;">*</span>
                            </label>
                            <input
                                type="text"
                                name="quantity"
                                class="form-control"
                                placeholder="Example: 100 Boxes"
                                required
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 10px 14px; height: 44px; box-shadow: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            >
                        </div>

                        <div class="form-group mb-5">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">
                                Additional Requirements
                            </label>
                            <textarea
                                name="message"
                                rows="5"
                                class="form-control"
                                style="background-color: #ffffff; border: 1px solid #cccccc; border-radius: 4px; color: #111111; font-size: 14px; font-weight: 500; padding: 12px 14px; box-shadow: none; transition: border-color 0.2s; resize: vertical;"
                                onfocus="this.style.borderColor='#111111';"
                                onblur="this.style.borderColor='#cccccc';"
                            ></textarea>
                        </div>

                        <button
                            class="btn text-uppercase"
                            style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 14px 32px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out;"
                            onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                            onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
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