<?php
include 'includes/header.php';
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- <style>
    /* Scope-Isolated Framework matching your site design signature */
    .alok-privacy-wrapper {
        font-family: 'Montserrat', sans-serif !important;
        background-color: #ffffff !important; /* Kept clean white per instruction */
        color: #444444 !important;
        line-height: 1.8;
        font-size: 14px;
        letter-spacing: 0.02em;
    }

    /* Minimalist Light Technical Hero Panel Layout */
    .privacy-hero-panel {
        background: #fafafa !important; 
        border-bottom: 1px solid #eeeeee;
        padding: 80px 0;
        color: #111111;
    }

    .privacy-hero-panel h1 {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 12px;
        position: relative;
        display: inline-block;
        padding-bottom: 14px;
        color: #111111;
    }

    /* Crimson Red Underline Indicator */
    .privacy-hero-panel h1::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #c8232c; /* Crimson Red */
    }

    .privacy-meta-date {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #777777;
        font-weight: 600;
    }

    /* Sticky Navigation Sidebar Panel */
    .privacy-sidebar-nav {
        position: sticky;
        top: 40px;
        border-left: 1px solid #eeeeee;
        padding-left: 20px;
    }

    .privacy-sidebar-nav ul {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .privacy-sidebar-nav ul li {
        margin-bottom: 14px;
    }

    .privacy-sidebar-nav ul li a {
        color: #777777 !important;
        text-decoration: none !important;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        transition: all 0.25s ease-in-out;
        display: block;
    }

    .privacy-sidebar-nav ul li a:hover {
        color: #c8232c !important; /* Crimson red accent color change on interaction */
        padding-left: 5px;
    }

    /* Structural Content Body Blocks */
    .privacy-content-stream {
        padding-right: 20px;
    }

    .privacy-section-node {
        margin-bottom: 45px;
        scroll-margin-top: 40px; /* Aligns target anchor spacing clean */
    }

    .privacy-section-node h3 {
        font-size: 15px;
        font-weight: 700;
        color: #111111 !important; 
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Clean geometric horizontal crimson icon block line markers */
    .privacy-section-node h3::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 2px;
        background-color: #c8232c; /* Crimson Red Node Pointer */
    }

    .privacy-section-node p {
        color: #555555 !important;
        font-weight: 400;
        margin-bottom: 16px;
    }

    .privacy-section-node ul {
        list-style: none !important;
        padding-left: 0 !important;
        margin-bottom: 16px;
    }

    .privacy-section-node ul li {
        position: relative;
        padding-left: 22px;
        margin-bottom: 10px;
        color: #555555;
        font-weight: 400;
    }

    /* Structured crimson square subitem indicators */
    .privacy-section-node ul li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 10px;
        width: 4px;
        height: 4px;
        background: #c8232c; /* Crimson item markers */
    }

    /* Premium contact info display card */
    .privacy-contact-card {
        background: #fafafa !important;
        border: 1px solid #eeeeee;
        border-left: 3px solid #c8232c !important; /* Crimson accent line */
        padding: 24px;
        border-radius: 4px;
        margin-top: 20px;
    }

    /* Responsive mobile breakpoint stack shifts */
    @media (max-width: 991px) {
        .privacy-sidebar-nav {
            display: none !important; /* Hides sticky tracker elements on small screens for clean viewport */
        }
        .privacy-content-stream {
            padding-right: 0px;
        }
    }
</style> -->

<div class="alok-privacy-wrapper" style="font-family: 'Montserrat', sans-serif; background: #fafafa; color: #444444;">

    <!-- Integrated Corporate Theme Styles & Keyframes -->
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes lineExpandLeft {
            from { width: 0; }
            to { width: 50px; }
        }
        .animate-fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        .privacy-hero-panel {
            background: linear-gradient(135deg, #111111 0%, #1a1a1a 100%);
            padding: 80px 0;
            color: #ffffff;
            border-bottom: 4px solid #c8232c;
        }
        .privacy-meta-date {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .privacy-section-node {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid #eeeeee;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        .privacy-section-node:hover {
            border-color: #e0e0e0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .privacy-section-node h3 {
            font-size: 18px;
            font-weight: 800;
            color: #111111;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 12px;
        }
        .privacy-section-node h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 35px;
            background: #c8232c;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .privacy-section-node:hover h3::after {
            width: 55px;
        }
        .privacy-section-node p {
            font-size: 14.5px;
            line-height: 1.75;
            color: #555555;
            margin-bottom: 15px;
        }
        .privacy-section-node p:last-child {
            margin-bottom: 0;
        }
        .privacy-section-node ul {
            list-style: none;
            padding-left: 0;
            margin-top: 15px;
            margin-bottom: 0;
        }
        .privacy-section-node ul li {
            font-size: 14px;
            line-height: 1.6;
            color: #555555;
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
        }
        .privacy-section-node ul li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 8px;
            width: 6px;
            height: 6px;
            background: #c8232c;
            border-radius: 50%;
        }
        .privacy-sidebar-nav {
            position: sticky;
            top: 40px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #eeeeee;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }
        .privacy-sidebar-nav ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .privacy-sidebar-nav li {
            margin-bottom: 12px;
        }
        .privacy-sidebar-nav li:last-child {
            margin-bottom: 0;
        }
        .privacy-sidebar-nav a {
            font-size: 12px;
            font-weight: 600;
            color: #666666;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            display: block;
            padding: 4px 0 4px 12px;
            border-left: 2px solid #eeeeee;
            transition: all 0.3s ease;
        }
        .privacy-sidebar-nav a:hover {
            color: #c8232c;
            border-left-color: #c8232c;
            padding-left: 16px;
            background: rgba(200, 35, 44, 0.02);
        }
        .privacy-contact-card {
            background: #fafafa;
            border-left: 4px solid #c8232c;
            padding: 24px;
            border-radius: 0 8px 8px 0;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>

    <!-- HERO PANEL BLOCK SECTION -->
    <section class="privacy-hero-panel">
        <div class="container">
            <div class="row">
                <div class="col-12 class animate-fade-in" style="animation-delay: 0.1s;">
                    <span class="privacy-meta-date" style="color: #c8232c;">Corporate Compliance Statement</span>
                    <h1 class="mt-2 d-block text-uppercase" style="font-size: 38px; font-weight: 800; letter-spacing: 0.05em; color: var(--light-bg) !important;">Privacy Policy</h1>
                    <div class="privacy-meta-date" style="color: #aaaaaa; margin-top: 10px;">Last Updated: <?= date('d M Y') ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN SYSTEM CONTENT PORTAL GRID SECTION -->
    <section class="py-5">
        <div class="container py-3">
            <div class="row">

                <!-- Left Content Stream Segment Node -->
                <div class="col-lg-9 col-12 segments-wrapper animate-fade-in" style="animation-delay: 0.2s;">
                    <div class="privacy-content-stream">

                        <!-- Section 1 -->
                        <div class="privacy-section-node" id="sec-1">
                            <h3>1. Introduction</h3>
                            <p>
                                Alok Glass Works respects your privacy and is committed to protecting your personal information.
                            </p>
                            <p>
                                This Privacy Policy explains how we collect, use, disclose and protect your information when you use our website.
                            </p>
                        </div>

                        <!-- Section 2 -->
                        <div class="privacy-section-node" id="sec-2">
                            <h3>2. Information We Collect</h3>
                            <p>
                                We may collect the following information:
                            </p>
                            <ul>
                                <li>Name</li>
                                <li>Email Address</li>
                                <li>Phone Number</li>
                                <li>Company Name</li>
                                <li>Billing Address</li>
                                <li>Shipping Address</li>
                                <li>Order Information</li>
                                <li>Payment Information (processed securely through payment gateways)</li>
                            </ul>
                        </div>

                        <!-- Section 3 -->
                        <div class="privacy-section-node" id="sec-3">
                            <h3>3. How We Use Information</h3>
                            <p>
                                Information collected may be used for:
                            </p>
                            <ul>
                                <li>Processing orders</li>
                                <li>Providing customer support</li>
                                <li>Sending order updates</li>
                                <li>Improving website services</li>
                                <li>Legal compliance</li>
                                <li>Marketing communications (with consent where applicable)</li>
                            </ul>
                        </div>

                        <!-- Section 4 -->
                        <div class="privacy-section-node" id="sec-4">
                            <h3>4. Payment Security</h3>
                            <p>
                                We do not store complete credit card, debit card or payment credentials on our servers.
                            </p>
                            <p>
                                Payments are processed through secure and authorized payment service providers.
                            </p>
                        </div>

                        <!-- Section 5 -->
                        <div class="privacy-section-node" id="sec-5">
                            <h3>5. Cookies</h3>
                            <p>
                                Our website may use cookies and similar technologies to improve user experience and website functionality.
                            </p>
                        </div>

                        <!-- Section 6 -->
                        <div class="privacy-section-node" id="sec-6">
                            <h3>6. Information Sharing</h3>
                            <p>
                                We do not sell, rent or trade personal information to third parties.
                            </p>
                            <p>
                                Information may be shared with logistics partners, payment gateways and legal authorities when necessary for business operations or legal compliance.
                            </p>
                        </div>

                        <!-- Section 7 -->
                        <div class="privacy-section-node" id="sec-7">
                            <h3>7. Data Security</h3>
                            <p>
                                We implement reasonable technical and organizational measures to protect personal information against unauthorized access, loss or misuse.
                            </p>
                        </div>

                        <!-- Section 8 -->
                        <div class="privacy-section-node" id="sec-8">
                            <h3>8. User Rights</h3>
                            <p>
                                Users may request access, correction or deletion of personal information by contacting us.
                            </p>
                        </div>

                        <!-- Section 9 -->
                        <div class="privacy-section-node" id="sec-9">
                            <h3>9. Third-Party Services</h3>
                            <p>
                                Our website may integrate third-party services including payment gateways, analytics tools and logistics providers.
                            </p>
                            <p>
                                Their use is governed by their respective privacy policies.
                            </p>
                        </div>

                        <!-- Section 10 -->
                        <div class="privacy-section-node" id="sec-10">
                            <h3>10. Children's Privacy</h3>
                            <p>
                                Our website is intended for business and commercial use and is not directed toward children under the age of 18.
                            </p>
                        </div>

                        <!-- Section 11 -->
                        <div class="privacy-section-node" id="sec-11">
                            <h3>11. Changes To This Policy</h3>
                            <p>
                                We may update this Privacy Policy from time to time. Updated versions will be posted on this page.
                            </p>
                        </div>

                        <!-- Section 12 -->
                        <div class="privacy-section-node" id="sec-12">
                            <h3>12. Contact Us</h3>
                            <div class="privacy-contact-card">
                                <strong style="font-weight: 800; color: #111111; text-transform: uppercase; font-size: 13px; letter-spacing: 0.05em; display: block; margin-bottom: 10px;">Alok Glass Works</strong>
                                <span style="display: block; margin-bottom: 6px; color: #555555;"><strong>Email: </strong>  alokglassworksfzd@gmail.com | sales@alokglass.com</span>
                                <span style="display: block; color: #555555;"><strong>Phone:</strong> +91 999-747-7289</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Sidebar Navigation Panel Index Column Block
                <div class="col-lg-3 d-none d-lg-block animate-fade-in" style="animation-delay: 0.3s;">
                    <div class="privacy-sidebar-nav">
                        <h4 style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #111111; margin-bottom: 22px; position: relative; padding-bottom: 8px;">
                            Index System
                            <span style="position: absolute; bottom: 0; left: 0; height: 2px; width: 25px; background-color: #c8232c; animation: lineExpandLeft 0.8s ease forwards;"></span>
                        </h4>
                        <ul>
                            <li><a href="#sec-1">1. Introduction</a></li>
                            <li><a href="#sec-2">2. Information Collect</a></li>
                            <li><a href="#sec-3">3. Info Usage</a></li>
                            <li><a href="#sec-4">4. Payment Security</a></li>
                            <li><a href="#sec-5">5. Cookies</a></li>
                            <li><a href="#sec-6">6. Info Sharing</a></li>
                            <li><a href="#sec-7">7. Data Security</a></li>
                            <li><a href="#sec-8">8. User Rights</a></li>
                            <li><a href="#sec-9">9. Third-Party</a></li>
                            <li><a href="#sec-10">10. Children's Privacy</a></li>
                            <li><a href="#sec-11">11. Policy Changes</a></li>
                            <li><a href="#sec-12">12. Contact Us</a></li>
                        </ul>
                    </div>
                </div> -->

            </div>
        </div>
    </section>

</div>
<?php
include 'includes/footer.php';
?>