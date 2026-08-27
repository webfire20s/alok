<?php
include 'includes/header.php';
?>

<!-- ADVANCED MANUFACTURING & DECORATION SYSTEM STYLES -->
<style>
    /* Global Page Scoping & Typography */
    .alok-page-container {
        font-family: 'Montserrat', sans-serif;
        color: #333333;
        background-color: #ffffff;
    }

    /* Animations */
    @keyframes srvFadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes srvLineExpand {
        from { width: 0; }
        to { width: 50px; }
    }
    .srv-animate-fade {
        animation: srvFadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    /* Hero Banner Architecture */
    .about-hero {
        background-image: linear-gradient(to right, rgba(17, 17, 17, 0.92) 10%, rgba(0, 0, 0, 0.75) 50%), 
                          url('assets/themes/storefront/public/images/aboutherobanner.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: 0; 
        right: 0; 
        width: 50%; 
        height: 100%;
        background: radial-gradient(circle, rgba(200, 35, 44, 0.25) 0%, rgba(0, 0, 0, 0) 80%);
        pointer-events: none;
    }

    /* Reusable Interactive Buttons */
    .srv-btn-quote {
        background: linear-gradient(135deg, #c8232c 0%, #a81a21 100%);
        color: #ffffff !important; 
        font-size: 13px; 
        font-weight: 700; 
        letter-spacing: 0.08em; 
        padding: 15px 34px; 
        border: none; 
        border-radius: 6px; 
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: color 0.4s ease, box-shadow 0.4s ease, transform 0.3s ease;
        display: inline-block;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(200, 35, 44, 0.25);
    }
    .srv-btn-quote::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, #111111 0%, #222222 100%);
        z-index: -1;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        transform: scaleX(0);
        transform-origin: right;
    }
    .srv-btn-quote:hover::before {
        transform: scaleX(1);
        transform-origin: left;
    }
    .srv-btn-quote:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(200, 35, 44, 0.4);
    }

    /* Modern Responsive Layout Grid Systems */
    .custom-section-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }
    @media (min-width: 768px) {
        .custom-section-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .span-full-row {
            grid-column: span 2;
        }
    }
    @media (min-width: 992px) {
        .custom-section-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .span-full-row {
            grid-column: span 2;
        }
    }

    /* Media-Rich Feature Card Component (Redesigned for Full-Bleed Images) */
    .media-card {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        height: 100%;
    }
    .media-card:hover {
        transform: translateY(-6px);
        border-color: rgba(200, 35, 44, 0.3);
        box-shadow: 0 14px 30px rgba(0,0,0,0.08);
    }

    /* FLUID ASPECT RATIO CONTAINER: Prevents cropping and side spacing */
    .media-card-img-wrap {
        width: 100%;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        position: relative;
        background-color: #f4f5f7;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .span-full-row .media-card-img-wrap {
        aspect-ratio: 16= / 9;
    }

    /* SMART COVER IMAGE: Preserves natural proportion without stretching */
    .media-card-img {
        width: 100%;
        height: 100%;
        object-fit: fill;
        object-position: center;
        transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .media-card:hover .media-card-img {
        transform: scale(1.04);
    }

    .media-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        background: #ffffff;
    }
    .media-card-title {
        font-size: 17px;
        font-weight: 800;
        color: #111111;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        transition: color 0.3s ease;
    }
    .media-card:hover .media-card-title {
        color: #c8232c;
    }
    .media-card-text {
        font-size: 13.5px;
        line-height: 1.7;
        color: #555555;
        margin-bottom: 16px;
    }

    /* Tag Pills & Features Styling */
    .feature-tag-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        background: #c8232c;
        color: #ffffff;
        padding: 5px 12px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(200, 35, 44, 0.3);
        z-index: 2;
    }
    .highlight-box {
        background: #fdf2f2;
        border-left: 3px solid #c8232c;
        padding: 10px 14px;
        font-size: 12.5px;
        font-weight: 600;
        color: #c8232c;
        border-radius: 0 6px 6px 0;
        margin-bottom: 16px;
    }
    .card-footer-pills {
        border-top: 1px solid #f1f3f5;
        padding-top: 14px;
        margin-top: auto;
    }
    .pills-heading {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #888888;
        display: block;
        margin-bottom: 8px;
    }
    .pill-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 8px; /* Slightly increased gap to prevent floating pills from touching */
        padding: 4px 0;
    }

    .pill-chip {
        font-size: 11.5px;
        font-weight: 600;
        color: #c8232c;
        background: #ffffff;
        border: 1px solid rgba(200, 35, 44, 0.4);
        padding: 4px 10px;
        border-radius: 16px;
        display: inline-block;
        
        /* Continuous Red Glow Effect */
        box-shadow: 0 0 8px rgba(200, 35, 44, 0.25);
        
        /* Permanent Automatic Floating Animation */
        animation: floatGlowPill 3s ease-in-out infinite;
        will-change: transform, box-shadow;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }

    /* Stagger floating timing and phase so adjacent pills float independently */
    .pill-chip:nth-child(even) {
        animation-duration: 3.4s;
        animation-delay: -0.8s;
    }

    .pill-chip:nth-child(3n) {
        animation-duration: 2.7s;
        animation-delay: -1.5s;
    }

    .pill-chip:nth-child(4n) {
        animation-duration: 4.1s;
        animation-delay: -2.2s;
    }

    /* Hover Enhancements (optional slight scaling on mouse-over) */
    .pill-chip:hover {
        background: #fdf2f2;
        border-color: #c8232c;
    }

    /* Automatic Floating & Pulsing Glow Keyframes */
    @keyframes floatGlowPill {
        0%, 100% {
            transform: translateY(0px);
            box-shadow: 0 0 6px rgba(200, 35, 44, 0.2);
        }
        50% {
            transform: translateY(-9px);
            box-shadow: 0 6px 14px rgba(200, 35, 44, 0.45);
        }
    }
    .media-card:hover .pill-chip {
        background: #ffffff;
        border-color: #dce1e6;
    }

    /* Section Divider Visual */
    .section-title-wrapper {
        text-align: center;
        margin-bottom: 48px;
    }
    .section-title-main {
        font-size: 28px;
        font-weight: 800;
        color: #111111;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        position: relative;
        display: inline-block;
        padding-bottom: 14px;
    }
    .section-title-main::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 44px;
        height: 4px;
        background: linear-gradient(90deg, #c8232c, #e0535a);
        border-radius: 2px;
    }

    /* CTA Premium Styling */
    .cta-premium-bg {
        background: linear-gradient(135deg, #ffffff 40%, #ffffff 100%);
        color: #ffffff !important;
        position: relative;
    }
    .card-full-width {
        grid-column: 1 / -1 !important;
        height: 100%;
    }
</style>

<div class="alok-page-container">

    <!-- HEADER HERO BANNER SEGMENT -->
    <section class="py-5 about-hero">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="text-uppercase d-block mb-2" style="color: #c8232c; font-size: 13px; font-weight: 700; letter-spacing: 0.1em;">
                        Crafting Visual Identities Since 1998
                    </span>
                    <h1 class="text-uppercase mb-4" style="color: #c9a8a8 !important; font-size: 42px; font-weight: 900; letter-spacing: 0.02em; line-height: 1.2;">
                        Pioneers in Premium Glass Decoration
                    </h1>
                    <p class="mb-0" style="color: #ffff; font-size: 16px; line-height: 1.8; max-width: 620px;">
                        At Alok Glass, we combine state-of-the-art automated facilities with master craftsmanship to transform standard glass bottles and jars into iconic, shelf-ready brand experiences.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: IN-HOUSE DECORATION CAPABILITIES -->
    <section class="py-5" style="background-color: #ffffff;">
        <div class="container py-3">

            <div class="section-title-wrapper srv-animate-fade">
                <h2 class="section-title-main">In-House Decoration Capabilities</h2>
                <p class="text-muted" style="font-size: 14px; font-weight: 500; color: #777777 !important; margin-top: 6px;">
                    Precision surface styling, customized coating, and metallic finishes executed at scale.
                </p>
            </div>

            <div class="custom-section-grid">
                
                <!-- Card 1: Colour Coating (Featured Double Span) -->
                <article class="media-card span-full-row srv-animate-fade">
                    <!-- <span class="feature-tag-badge">9,000 Pcs / Hour</span> -->
                    <div class="media-card-img-wrap">
                        <img src="assets/images/colour coating.png" class="media-card-img" alt="Colour Coating on Glass">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Colour Coating on Glass</h3>
                        <p class="media-card-text">
                            Alok Glass Works operates two coating machines with a combined production capacity of approximately <strong>9,000 pieces per hour</strong>, depending on product design and coating specifications. We offer customised colour coatings matched to your brand identity, applied as a full-body finish or to selected areas.
                        </p>
                        <!-- <div class="highlight-box">
                            ✔ Dishwasher-Safe: Withstands 100–250 washing cycles based on finish parameters.
                        </div> -->
                        <div class="card-footer-pills">
                            <span class="pills-heading">Available Finishes</span>
                            <div class="pill-wrapper">
                                <span class="pill-chip">Matte</span>
                                <span class="pill-chip">Glossy</span>
                                <span class="pill-chip">Translucent</span>
                                <span class="pill-chip">Opaque</span>
                                <span class="pill-chip">Two-Tone</span>
                                <span class="pill-chip">Fade</span>
                                <span class="pill-chip">Bottom-Only Spray</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Colour Printing -->
                <article class="media-card srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/colour printing.png" class="media-card-img" alt="Colour Printing on Glass">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Colour Printing on Glass</h3>
                        <p class="media-card-text">
                            Alok Glass Works operates two six colour printing machines for applying colours, patterns, text and detailed artwork directly onto glass bottles and jars. Printing creates a durable, high-quality finish suitable for customised packaging across different product categories.
                        </p>
                        <div class="card-footer-pills">
                            <span class="pills-heading">Available Options</span>
                            <div class="pill-wrapper">
                                <span class="pill-chip">Single-Colour</span>
                                <span class="pill-chip">Multi-Colour</span>
                                <span class="pill-chip">Patterns</span>
                                <span class="pill-chip">Text</span>
                                <span class="pill-chip">Custom Artwork</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Foiling -->
                <article class="media-card srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/foiling.png" class="media-card-img" alt="Foiling on Glass">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Foiling on Glass</h3>
                        <p class="media-card-text">
                            Foiling applies reflective metallic details directly onto glass bottles and jars, creating a premium finish for logos, text, patterns and decorative artwork. Designs can be customised to complement the product’s shape and branding requirements.
                        </p>
                        <div class="card-footer-pills">
                            <span class="pills-heading">Available Finishes</span>
                            <div class="pill-wrapper">
                                <span class="pill-chip">Gold</span>
                                <span class="pill-chip">Copper</span>
                                <span class="pill-chip">Silver</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Card 4: Acid-Dipped Frosting -->
                <article class="media-card span-full-row srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/frosting.png" class="media-card-img" alt="Acid-Dipped Frosting">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Acid-Dipped Frosting</h3>
                        <p class="media-card-text">
                            Our acid-dipped frosting process chemically etches the glass surface to create a smooth, uniform and permanent frosted finish. The treatment softly diffuses light and gives bottles and jars an elegant, translucent appearance suitable for premium packaging.
                        </p>
                        <div class="card-footer-pills">
                            <span class="pills-heading">Available Finishes</span>
                            <div class="pill-wrapper">
                                <span class="pill-chip">Light Frost</span>
                                <span class="pill-chip">Deep Frost</span>
                                <span class="pill-chip">Full-Body Frosting</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Card 5: Metallization -->
                <article class="media-card card-full-width srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/Mettalization.png" class="media-card-img" alt="Glass Metallization">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Metallization</h3>
                        <p class="media-card-text">
                            Metallization gives glass bottles and jars a smooth, reflective metal-like appearance. It can be applied as a complete surface finish or to selected areas, creating distinctive packaging for premium and luxury products.
                        </p>
                        <div class="card-footer-pills">
                            <span class="pills-heading">Available Finishes</span>
                            <div class="pill-wrapper">
                                <span class="pill-chip">Gold</span>
                                <span class="pill-chip">Silver</span>
                                <span class="pill-chip">Bronze</span>
                                <span class="pill-chip">Full-Body</span>
                                <span class="pill-chip">Selected-Area</span>
                            </div>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- SECTION 2: IN-HOUSE MANUFACTURING FACILITIES -->
    <section class="py-5" style="background-color: #fafafa;">
        <div class="container py-4">

            <div class="section-title-wrapper srv-animate-fade">
                <h2 class="section-title-main">In-House Manufacturing Facilities</h2>
                <p class="text-muted" style="font-size: 14px; font-weight: 500; color: #777777 !important; margin-top: 6px;">
                    End-to-end production ecosystem from raw glass container design to logistics export packing.
                </p>
            </div>

            <div class="custom-section-grid">

                <!-- Facility 1: Flint Glass (Green Tint) - Featured Double Span -->
                <article class="media-card span-full-row srv-animate-fade">
                    <!-- <span class="feature-tag-badge">GM Glass Partner</span> -->
                    <div class="media-card-img-wrap">
                        <img src="assets/images/Flint Glass.png" class="media-card-img" alt="Flint Glass Manufacturing">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Flint Glass (Green Tint)</h3>
                        <p class="media-card-text">
                            Through our associated company, <strong>GM Glass</strong>, we also manufacture and supply flint glass with a characteristic light green tint. It is suitable for reliable and cost-effective packaging across food, beverage, and other product categories.
                        </p>
                        <div class="card-footer-pills">
                            <span class="pills-heading">Available Products</span>
                            <div class="pill-wrapper">
                                <span class="pill-chip">Bottles</span>
                                <span class="pill-chip">Jars</span>
                                <span class="pill-chip">Liquor Bottles</span>
                                <span class="pill-chip">Milk Bottles</span>
                                <span class="pill-chip">Custom Glass Solutions</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Facility 2: In-House Design & Development -->
                <article class="media-card srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/Mould Manufacturing and designing.png" class="media-card-img" alt="Product Development">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Design & Product Development</h3>
                        <p class="media-card-text">
                            Our experienced designers transform your container idea into a production-ready glass package that reflects your brand identity. We recommend ideal weight, MOQs, closure, and configuration balancing aesthetics with manufacturing feasibility.
                        </p>
                    </div>
                </article>

                <!-- Facility 3: Mould Workshop -->
                <article class="media-card srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/Mould Workshop.png" class="media-card-img" alt="Mould Workshop">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">In-House Mould Workshop</h3>
                        <p class="media-card-text">
                            Our workshop manufactures, modifies, and maintains moulds for custom glass bottles and jars. This ensures dimensional accuracy, faster sampling turnaround, and a smooth transition to full-scale commercial manufacturing.
                        </p>
                    </div>
                </article>

                <!-- Facility 4: Corrugated Carton Manufacturing -->
                <article class="media-card span-full-row srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/Corrugated Carton Manufacturing.png" class="media-card-img" alt="Corrugated Packaging">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Corrugated Carton Manufacturing</h3>
                        <p class="media-card-text">
                            We manufacture corrugated cartons in-house for safe storage and transit. Depending on the product dimensions and transport requirements, we produce customized heavy-duty corrugated box configurations.
                        </p>
                        <div class="card-footer-pills">
                            <span class="pills-heading">Ply Specs Offered</span>
                            <div class="pill-wrapper">
                                <span class="pill-chip">3-Ply Cartons</span>
                                <span class="pill-chip">5-Ply Cartons</span>
                                <span class="pill-chip">7-Ply Cartons</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Facility 6: Injection Moulding -->
                <article class="media-card span-full-row srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/injection moulding.png" class="media-card-img" alt="Injection Moulding">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">In-House Injection Moulding</h3>
                        <p class="media-card-text">
                            Our plastic injection unit produces custom plastic caps, airtight sealing rings for glass lids, and ancillary packaging components. This guarantees total closure compatibility and seal integrity.
                        </p>
                    </div>
                </article>

                <!-- Facility 5: Lug Cap Manufacturing -->
                <article class="media-card srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/Lug Cap Manufacturing.png" class="media-card-img" alt="Metal Lug Caps">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">In-House Lug Cap Manufacturing</h3>
                        <p class="media-card-text">
                            Our lug cap unit enables us to offer precision metal closures for food jars and glass containers. Metal caps are engineered in multiple sizes, custom colors, and protective liner finishes based on product requirements.
                        </p>
                    </div>
                </article>

                <!-- Facility 7: Shrink-Wrap & Tray Packing -->
                <article class="media-card srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="assets/images/Shrink-Wrap & Tray Packing.png" class="media-card-img" alt="Tray Packaging">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Shrink-Wrap & Tray Packing</h3>
                        <p class="media-card-text">
                            We offer shrink-wrapping and robust tray-packing setups tailored to order sizes and transit requirements. These options provide secure, practical, and economical packaging for bottles, jars, and tumblers.
                        </p>
                    </div>
                </article>

                <!-- Facility 8: Export Palletization -->
                <article class="media-card span-full-row srv-animate-fade">
                    <div class="media-card-img-wrap">
                        <img src="https://media.licdn.com/dms/image/v2/C4E12AQFs2DqAi7yneQ/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1520114423555?e=2147483647&v=beta&t=FzGNAvmLmzuCXMAvz9mI08PtKZWgdMcqjT3uW_3slu8" class="media-card-img" alt="Export Palletization">
                    </div>
                    <div class="media-card-body">
                        <h3 class="media-card-title">Export Palletization</h3>
                        <p class="media-card-text">
                            We provide heavy-duty wooden and plastic palletization for export orders to safeguard shipments during ocean or land transit. Configurations are engineered based on box dimensions and container loading parameters.
                        </p>
                    </div>
                </article>

            </div>

        </div>
    </section>

    <!-- CONVERSION-FOCUSED CLOSING CTA SEGMENT -->
    <section class="py-5 text-center cta-premium-bg">
        <div class="container py-4">
            <h2 class="mb-3 text-uppercase" style="font-size: 28px; font-weight: 800; letter-spacing: 0.04em;">
                Need Custom Decorated Packaging?
            </h2>

            <p class="mb-4 mx-auto" style="font-size: 15px; font-weight: 400; max-width: 620px; color: #c8232c; line-height: 1.7;">
                Get in touch with our team for customized glass bottle and jar decoration solutions.
            </p>

            <div class="mt-4 pt-2">
                <a href="bulk_inquiry.php" class="btn srv-btn-quote text-uppercase">
                    Request Bulk Quote
                </a>
            </div>
        </div>
    </section>

</div>

<?php include 'includes/footer.php'; ?>