<?php
include 'includes/header.php';
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Scope-Isolated Framework matching your site design signature */
    .alok-terms-wrapper {
        font-family: 'Montserrat', sans-serif !important;
        background-color: #ffffff !important; /* Kept clean white per instruction */
        color: #444444 !important;
        line-height: 1.8;
        font-size: 14px;
        letter-spacing: 0.02em;
    }

    /* Minimalist Light Technical Hero Panel Layout */
    .terms-hero-panel {
        background: #fafafa !important; 
        border-bottom: 1px solid #eeeeee;
        padding: 80px 0;
        color: #111111;
    }

    .terms-hero-panel h1 {
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
    .terms-hero-panel h1::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #c8232c; /* Crimson Red */
    }

    .terms-meta-date {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #777777;
        font-weight: 600;
    }

    /* Sticky Navigation Sidebar Panel */
    .terms-sidebar-nav {
        position: sticky;
        top: 40px;
        border-left: 1px solid #eeeeee;
        padding-left: 20px;
    }

    .terms-sidebar-nav ul {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .terms-sidebar-nav ul li {
        margin-bottom: 14px;
    }

    .terms-sidebar-nav ul li a {
        color: #777777 !important;
        text-decoration: none !important;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        transition: all 0.25s ease-in-out;
        display: block;
    }

    .terms-sidebar-nav ul li a:hover {
        color: #c8232c !important; /* Crimson red accent color change on interaction */
        padding-left: 5px;
    }

    /* Structural Content Body Blocks */
    .terms-content-stream {
        padding-right: 20px;
    }

    .terms-section-node {
        margin-bottom: 45px;
        scroll-margin-top: 40px; /* Aligns target anchor spacing clean */
    }

    .terms-section-node h3 {
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
    .terms-section-node h3::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 2px;
        background-color: #c8232c; /* Crimson Red Node Pointer */
    }

    .terms-section-node p {
        color: #555555 !important;
        font-weight: 400;
        margin-bottom: 16px;
    }

    /* Premium contact info display card */
    .terms-contact-card {
        background: #fafafa !important;
        border: 1px solid #eeeeee;
        border-left: 3px solid #c8232c !important; /* Crimson accent line */
        padding: 24px;
        border-radius: 4px;
        margin-top: 20px;
    }

    /* Responsive mobile breakpoint stack shifts */
    @media (max-width: 991px) {
        .terms-sidebar-nav {
            display: none !important; /* Hides sticky tracker elements on small screens for clean viewport */
        }
        .terms-content-stream {
            padding-right: 0px;
        }
    }
</style>

<div class="alok-terms-wrapper">

    <!-- HERO PANEL BLOCK SECTION -->
    <section class="terms-hero-panel">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <span class="terms-meta-date">Corporate Compliance Statement</span>
                    <h1 class="mt-2 d-block">Terms & Conditions</h1>
                    <div class="terms-meta-date" style="color: #777777; margin-top: 5px;">Last Updated: <?= date('d M Y') ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN SYSTEM CONTENT PORTAL GRID SECTION -->
    <section class="py-5">
        <div class="container py-3">
            <div class="row">

                <!-- Left Content Stream Segment Node -->
                <div class="col-lg-9 col-12">
                    <div class="terms-content-stream">

                        <!-- Section 1 -->
                        <div class="terms-section-node" id="sec-1">
                            <h3>1. Introduction</h3>
                            <p>
                                Welcome to Alok Glass Works. By accessing or using this website, you agree to comply with and be bound by these Terms & Conditions. If you do not agree with any part of these terms, please do not use our website.
                            </p>
                        </div>

                        <!-- Section 2 -->
                        <div class="terms-section-node" id="sec-2">
                            <h3>2. Products & Services</h3>
                            <p>
                                Alok Glass Works manufactures and supplies glass bottles, jars, containers and packaging products for various industries, including food, beverage, pharmaceutical and cosmetic sectors.
                            </p>
                            <p>
                                Product images displayed on the website are for reference purposes only and may vary slightly from actual products.
                            </p>
                        </div>

                        <!-- Section 3 -->
                        <div class="terms-section-node" id="sec-3">
                            <h3>3. Pricing</h3>
                            <p>
                                All prices displayed on this website are subject to change without prior notice.
                            </p>
                            <p>
                                Applicable GST, shipping charges and other taxes may be added during checkout where applicable.
                            </p>
                        </div>

                        <!-- Section 4 -->
                        <div class="terms-section-node" id="sec-4">
                            <h3>4. Orders</h3>
                            <p>
                                Submission of an order does not guarantee acceptance. Alok Glass Works reserves the right to accept, reject, cancel or modify any order at its sole discretion.
                            </p>
                        </div>

                        <!-- Section 5 -->
                        <div class="terms-section-node" id="sec-5">
                            <h3>5. Payments</h3>
                            <p>
                                Payments may be accepted through approved payment gateways, bank transfers or other authorized payment methods.
                            </p>
                            <p>
                                Orders may remain on hold until payment verification is completed successfully.
                            </p>
                        </div>

                        <!-- Section 6 -->
                        <div class="terms-section-node" id="sec-6">
                            <h3>6. Shipping & Delivery</h3>
                            <p>
                                Delivery timelines are estimates and may vary depending on location, product availability, production schedules and logistics conditions.
                            </p>
                            <p>
                                Alok Glass Works shall not be held liable for delays caused by transport agencies, natural events or circumstances beyond our control.
                            </p>
                        </div>

                        <!-- Section 7 -->
                        <div class="terms-section-node" id="sec-7">
                            <h3>7. Intellectual Property</h3>
                            <p>
                                All website content including logos, text, images, graphics, designs and documents are the property of Alok Glass Works unless otherwise stated.
                            </p>
                            <p>
                                Unauthorized reproduction or distribution is prohibited.
                            </p>
                        </div>

                        <!-- Section 8 -->
                        <div class="terms-section-node" id="sec-8">
                            <h3>8. User Responsibilities</h3>
                            <p>
                                Users agree not to misuse the website, attempt unauthorized access, distribute malicious software or engage in activities that may disrupt website operations.
                            </p>
                        </div>

                        <!-- Section 9 -->
                        <div class="terms-section-node" id="sec-9">
                            <h3>9. Limitation of Liability</h3>
                            <p>
                                Alok Glass Works shall not be liable for any indirect, incidental, consequential or special damages arising from the use of this website or its products.
                            </p>
                        </div>

                        <!-- Section 10 -->
                        <div class="terms-section-node" id="sec-10">
                            <h3>10. Third-Party Links</h3>
                            <p>
                                This website may contain links to third-party websites. We are not responsible for the content, policies or practices of such external websites.
                            </p>
                        </div>

                        <!-- Section 11 -->
                        <div class="terms-section-node" id="sec-11">
                            <h3>11. Changes To Terms</h3>
                            <p>
                                Alok Glass Works reserves the right to modify these Terms & Conditions at any time without prior notice.
                            </p>
                        </div>

                        <!-- Section 12 -->
                        <div class="terms-section-node" id="sec-12">
                            <h3>12. Governing Law</h3>
                            <p>
                                These Terms & Conditions shall be governed by the laws of India. Any disputes shall be subject to the jurisdiction of courts located in Uttar Pradesh, India.
                            </p>
                        </div>

                        <!-- Section 13 -->
                        <div class="terms-section-node" id="sec-13">
                            <h3>13. Contact Information</h3>
                            <div class="terms-contact-card">
                                <strong style="font-weight: 700; color: #111111; text-transform: uppercase; font-size: 13px; letter-spacing: 0.05em; display: block; margin-bottom: 8px;">Alok Glass Works</strong>
                                <span style="display: block; margin-bottom: 4px;"><strong>Email:</strong> pranjal@alokglass.com</span>
                                <span style="display: block;"><strong>Phone:</strong> +91 999-747-7289</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Sidebar Navigation Panel Index Column Block -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="terms-sidebar-nav">
                        <h4 style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #111111; margin-bottom: 22px;">Index</h4>
                        <ul>
                            <li><a href="#sec-1">1. Introduction</a></li>
                            <li><a href="#sec-2">2. Products & Services</a></li>
                            <li><a href="#sec-3">3. Pricing Setup</a></li>
                            <li><a href="#sec-4">4. Order System</a></li>
                            <li><a href="#sec-5">5. Payments</a></li>
                            <li><a href="#sec-6">6. Shipping Rules</a></li>
                            <li><a href="#sec-7">7. Intellectual Prop</a></li>
                            <li><a href="#sec-8">8. User Duty</a></li>
                            <li><a href="#sec-9">9. Liability Limit</a></li>
                            <li><a href="#sec-10">10. External Links</a></li>
                            <li><a href="#sec-11">11. Changes Info</a></li>
                            <li><a href="#sec-12">12. Governing Law</a></li>
                            <li><a href="#sec-13">13. Contact Info</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<?php
include 'includes/footer.php';
?>  