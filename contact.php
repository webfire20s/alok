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

<div class="container py-5">

    <div class="row">

        <div class="col-md-6">

            <h2 class="mb-4">Contact Us</h2>

            <p>
                We'd love to hear from you.
            </p>

            <div class="mb-3">
                <strong>Phone:</strong><br>
                +91 999-747-7289 | +91 703-787-7289
            </div>

            <div class="mb-3">
                <strong>Email:</strong><br>
                pranjal@alokglass.com | sales@alokglass.com
            </div>

            <div class="mb-3">
                <strong>Address:</strong><br>
                Firozabad:</b> Alok Glass Works<br />Kia Showroom,    Agra Road,<br />
                                            Firozabad – 283203 (U.P.) India<br />
            </div>

        </div>

        <div class="col-md-6">
                <?php if(!empty($success)): ?>

                    <div class="alert alert-success">

                        Thank you.
                        We will contact you shortly.

                    </div>

                <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text"
                           class="form-control"
                           name="name">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                           class="form-control"
                           name="email">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text"
                           class="form-control"
                           name="phone">
                </div>

                <div class="form-group">
                    <label>Message</label>

                    <textarea
                        class="form-control"
                        rows="5"
                        name="message"></textarea>

                </div>

                <button class="btn btn-dark">
                    Send Inquiry
                </button>

            </form>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>