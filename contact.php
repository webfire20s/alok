<?php
require 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name =
        trim($_POST['name']);

    $email =
        trim($_POST['email']);

    $phone =
        trim($_POST['phone']);

    $message =
        trim($_POST['message']);

    $stmt = $pdo->prepare("
        INSERT INTO contact_inquiries (

            name,
            email,
            phone,
            message

        ) VALUES (

            ?, ?, ?, ?

        )
    ");

    $stmt->execute([

        $name,
        $email,
        $phone,
        $message

    ]);

    $success = true;
}
include 'includes/header.php';
?>

<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">

    <div class="row">

        <div class="col-md-6 mb-5 pe-md-5">

            <h2 class="mb-4 text-uppercase" style="font-size: 28px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 14px;">
                Contact Us
                <span style="position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background-color: #c8232c;"></span>
            </h2>

            <p class="text-muted mb-5" style="font-size: 15px; line-height: 1.6; color: #555555 !important;">
                We'd love to hear from you. Get in touch with our team for orders, customizations, or business inquiries.
            </p>

            <div class="mb-4 d-flex align-items-start" style="font-size: 14px; color: #333333;">
                <div style="min-width: 120px;">
                    <strong style="color: #111111; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; display: block;">Phone:</strong>
                </div>
                <div style="font-weight: 500; color: #555555; line-height: 1.6;">
                    +91 999-747-7289 <span style="color: #cccccc; margin: 0 4px;">|</span> +91 703-787-7289
                </div>
            </div>

            <div class="mb-4 d-flex align-items-start" style="font-size: 14px; color: #333333;">
                <div style="min-width: 120px;">
                    <strong style="color: #111111; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; display: block;">Email:</strong>
                </div>
                <div style="font-weight: 500; color: #555555; line-height: 1.6;">
                    pranjal@alokglass.com <span style="color: #cccccc; margin: 0 4px;">|</span> sales@alokglass.com
                </div>
            </div>

            <div class="mb-4 d-flex align-items-start" style="font-size: 14px; color: #333333;">
                <div style="min-width: 120px;">
                    <strong style="color: #111111; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; display: block;">Address:</strong>
                </div>
                <div style="font-weight: 400; color: #555555; line-height: 1.7;">
                    <strong style="color: #111111; font-weight: 600;">Alok Glass Works</strong><br />
                    Kia Showroom, Agra Road,<br />
                    Firozabad – 283203 (U.P.) India
                </div>
            </div>

        </div>

        <div class="col-md-6">
            
            <?php if(!empty($success)): ?>
                <div class="alert alert-neutral py-3 px-4 mb-4" style="background-color: #f8f9fa; border-left: 4px solid #c8232c; border-top: 1px solid #e4e6eb; border-right: 1px solid #e4e6eb; border-bottom: 1px solid #e4e6eb; color: #111111; font-size: 14px; font-weight: 500; border-radius: 0 4px 4px 0;">
                    Thank you. We will contact you shortly.
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group mb-3">
                    <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Name</label>
                    <input 
                        type="text"
                        class="form-control"
                        name="name"
                        style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none;"
                    >
                </div>

                <div class="form-group mb-3">
                    <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Email</label>
                    <input 
                        type="email"
                        class="form-control"
                        name="email"
                        style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none;"
                    >
                </div>

                <div class="form-group mb-3">
                    <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Phone</label>
                    <input 
                        type="text"
                        class="form-control"
                        name="phone"
                        style="height: 44px; border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none;"
                    >
                </div>

                <div class="form-group mb-4">
                    <label style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #111111; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Message</label>
                    <textarea
                        class="form-control"
                        rows="5"
                        name="message"
                        style="border-radius: 4px; border: 1px solid #cccccc; font-size: 14px; font-weight: 400; color: #333333; box-shadow: none; resize: vertical;"
                    ></textarea>
                </div>

                <button 
                    type="submit"
                    class="btn text-uppercase"
                    style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 12px 28px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out;"
                    onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                    onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
                >
                    Send Inquiry
                </button>

            </form>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>