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
    
    <!-- CSS Theme & Animations Wrapper -->
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes lineExpand {
            from { width: 0; }
            to { width: 60px; }
        }
        .animate-fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        .contact-info-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 12px;
        }
        .contact-info-card:hover {
            transform: translateX(5px);
        }
        .themed-input {
            height: 48px; 
            border-radius: 8px; 
            border: 1px solid #e0e0e0; 
            font-size: 14px; 
            font-weight: 400; 
            color: #222222; 
            box-shadow: none;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        .themed-input:focus {
            border-color: #c8232c !important;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(200, 35, 44, 0.1) !important;
        }
        .themed-textarea {
            border-radius: 8px; 
            border: 1px solid #e0e0e0; 
            font-size: 14px; 
            font-weight: 400; 
            color: #222222; 
            box-shadow: none; 
            resize: vertical;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        .themed-textarea:focus {
            border-color: #c8232c !important;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(200, 35, 44, 0.1) !important;
        }
        .btn-animate {
            background: linear-gradient(135deg, #111111 0%, #222222 100%);
            color: #ffffff; 
            font-size: 13px; 
            font-weight: 700; 
            letter-spacing: 0.08em; 
            padding: 14px 32px; 
            border-radius: 8px; 
            border: none; 
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: color 0.4s ease;
        }
        .btn-animate::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #c8232c 0%, #91131a 100%);
            z-index: -1;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            transform: scaleX(0);
            transform-origin: right;
        }
        .btn-animate:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        .btn-animate:hover {
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(200, 35, 44, 0.3);
        }
    </style>

    <div class="row align-items-center">

        <!-- Left Column: Branding & Info -->
        <div class="col-md-6 mb-5 pe-md-5 animate-fade-in" style="animation-delay: 0.1s;">

            <h2 class="mb-4 text-uppercase" style="font-size: 32px; font-weight: 800; color: #111111; letter-spacing: 0.03em; position: relative; padding-bottom: 16px;">
                Contact Us
                <span style="position: absolute; bottom: 0; left: 0; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); animation: lineExpand 1s cubic-bezier(0.25, 1, 0.5, 1) forwards; border-radius: 2px;"></span>
            </h2>

            <p class="mb-5" style="font-size: 16px; line-height: 1.7; color: #666666; font-weight: 400;">
                We'd love to hear from you. Get in touch with our team for orders, custom glass designs, or industrial business inquiries.
            </p>

            <!-- Phone Wrapper -->
            <div class="mb-4 d-flex align-items-center p-3 contact-info-card" style="background: rgba(200, 35, 44, 0.03); border-left: 3px solid #c8232c;">
                <div style="min-width: 100px;">
                    <strong style="color: #c8232c; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.08em; display: block;">Phone</strong>
                </div>
                <div style="font-weight: 600; color: #333333; font-size: 15px;">
                    +91 999-747-7289 <span style="color: #b3b3b3; margin: 0 6px; font-weight: 300;">|</span> +91 703-787-7289
                </div>
            </div>

            <!-- Email Wrapper -->
            <div class="mb-4 d-flex align-items-center p-3 contact-info-card" style="background: rgba(200, 35, 44, 0.03); border-left: 3px solid #c8232c;">
                <div style="min-width: 100px;">
                    <strong style="color: #c8232c; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.08em; display: block;">Email</strong>
                </div>
                <div style="font-weight: 600; color: #333333; font-size: 14px;">
                    alokglassworksfzd@gmail.com  | sales@alokglass.com
                </div>
            </div>

            <!-- Address Wrapper -->
            <div class="mb-4 d-flex align-items-start p-3 contact-info-card" style="background: rgba(0, 0, 0, 0.02); border-left: 3px solid #111111;">
                <div style="min-width: 100px; padding-top: 2px;">
                    <strong style="color: #111111; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.08em; display: block;">Address</strong>
                </div>
                <div style="font-weight: 500; color: #555555; line-height: 1.6; font-size: 14px;">
                    <strong style="color: #111111; font-weight: 700;">Alok Glass Works</strong><br />
                    Kia Showroom, Agra Road,<br />
                    Firozabad – 283203 (U.P.) India
                </div>
            </div>

        </div>

        <!-- Right Column: Animated Form Container -->
        <div class="col-md-6 animate-fade-in" style="animation-delay: 0.3s;">
            
            <?php if(!empty($success)): ?>
                <div class="alert alert-neutral py-3 px-4 mb-4" style="background-color: #fff5f5; border-left: 4px solid #c8232c; color: #c8232c; font-size: 14px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(200, 35, 44, 0.05); animation: fadeInUp 0.4s ease;">
                    Thank you! We will contact you shortly.
                </div>
            <?php endif; ?>

            <div style="background: #ffffff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0,0.05); border: 1px solid #eeeeee;">
                <form method="POST">

                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; display: block; margin-bottom: 8px;">Your Name</label>
                        <input 
                            type="text"
                            class="form-control themed-input"
                            name="name"
                            required
                        >
                    </div>

                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; display: block; margin-bottom: 8px;">Email Address</label>
                        <input 
                            type="email"
                            class="form-control themed-input"
                            name="email"
                            required
                        >
                    </div>

                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; display: block; margin-bottom: 8px;">Phone Number</label>
                        <input 
                            type="text"
                            class="form-control themed-input"
                            name="phone"
                        >
                    </div>

                    <div class="form-group mb-4">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #111111; letter-spacing: 0.08em; display: block; margin-bottom: 8px;">Message Details</label>
                        <textarea
                            class="form-control themed-textarea"
                            rows="4"
                            name="message"
                            required
                        ></textarea>
                    </div>

                    <button 
                        type="submit"
                        class="btn btn-animate text-uppercase w-100"
                    >
                        Send Inquiry
                    </button>

                </form>
            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>