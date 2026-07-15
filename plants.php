<?php include 'includes/header.php'; ?>

<!-- DEPENDENCIES FOR SCROLL EFFECTS & ICONS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ==========================================================================
       PLANTS SECTION DESIGN SYSTEM BASE
       ========================================================================== */
    .plants-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: #ffffff;
        padding: 80px 0;
    }

    /* Core Intro Section Block */
    .plants-intro-panel {
        max-width: 800px;
        margin: 0 auto 70px auto;
        text-align: center;
    }

    .plants-pretitle {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        color: #c8232c; /* Alok Red */
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-bottom: 12px;
    }

    .plants-main-title {
        font-size: 32px;
        font-weight: 800;
        color: #111111; /* Charcoal Main */
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 20px;
    }

    .plants-lead-text {
        font-size: 15px;
        color: #555555;
        line-height: 1.7;
        font-weight: 500;
    }

    /* ==========================================================================
       ALTERNATING INFRASTRUCTURE ROW BLOCKS
       ========================================================================== */
    .plant-row-item {
        margin-bottom: 90px;
    }
    .plant-row-item:last-child {
        margin-bottom: 0;
    }

    /* Media Box Canvas Container */
    .plant-media-frame {
        width: 50%;
        aspect-ratio: 16 / 7; /* Elegant widescreen format matching the screenshot structure */
        background-color: #161616; /* Charcoal Black background mask */
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eef0f2;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        margin-bottom: 24px;
        position: relative;
    }

    .plant-media-frame img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Interactive focal hover effect on images */
    .plant-row-item:hover .plant-media-frame img {
        transform: scale(1.03);
    }

    /* Typographic Content Container Block */
    .plant-info-block {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .plant-heading-group {
        border-bottom: 2px solid #eef0f2;
        padding-bottom: 12px;
        margin-bottom: 20px;
        position: relative;
    }

    .plant-heading-group::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 80px;
        height: 2px;
        background-color: #c8232c; /* Red structural accent accentuator */
    }

    .plant-name {
        font-size: 24px;
        font-weight: 800;
        color: #161616;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin: 0;
    }

    /* Body Text Layout Grid Column Splitter */
    .plant-description-grid {
        display: flex;
        /* grid-template-columns: repeat(2, 1fr); */
        gap: 40px;
    }

    .plant-desc-text {
        font-size: 14.5px;
        color: #444444;
        line-height: 1.65;
        font-weight: 500;
        text-align: justify;
        margin: 0;
    }

    /* ==========================================================================
       HARDWARE-ACCELERATED TRANSITION TIMINGS
       ========================================================================== */
    .plant-reveal {
        opacity: 0;
        transform: translateY(35px);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform, opacity;
    }

    .plant-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ==========================================================================
       RESPONSIVE MATRIX BREAKPOINTS
       ========================================================================== */
    @media (max-width: 991.98px) {
        .plants-main-title { font-size: 26px; }
        .plant-media-frame { aspect-ratio: 16 / 9; } /* Gives better framing depth on medium viewports */
        .plant-description-grid { grid-template-columns: 1fr; gap: 20px; }
        .plant-name { font-size: 20px; }
    }

    @media (max-width: 575.98px) {
        .plants-wrapper { padding: 50px 0; }
        .plants-main-title { font-size: 22px; }
        .plant-row-item { margin-bottom: 60px; }
        .plant-media-frame { margin-bottom: 16px; }
        .plant-desc-text { font-size: 13.5px; text-align: left; }
    }
</style>
<style>
    /* ==========================================================================
    INFINITE ASSOCIATE MARQUEE SYSTEM
    ========================================================================== */
    .marquee-section {
        background-color: #161616; /* Premium Charcoal Black Base */
        padding: 40px 0;
        overflow: hidden;
        border-top: 1px solid #262626;
        border-bottom: 1px solid #262626;
        position: relative;
    }

    /* Subtle industrial framing gradient overlays to fade logos at edges */
    .marquee-section::before,
    .marquee-section::after {
        content: "";
        position: absolute;
        top: 0;
        width: 150px;
        height: 100%;
        z-index: 2;
        pointer-events: none;
    }
    .marquee-section::before {
        left: 0;
        background: linear-gradient(to right, #161616 0%, rgba(22, 22, 22, 0) 100%);
    }
    .marquee-section::after {
        right: 0;
        background: linear-gradient(to left, #161616 0%, rgba(22, 22, 22, 0) 100%);
    }

    /* Flex container housing the track wrapper */
    .marquee-viewport {
        display: flex;
        width: 100%;
    }

    /* The moving track containing duplicated lists for a perfect infinite loop */
    .marquee-track {
        display: flex;
        gap: 60px; /* Uniform spatial distancing between logos */
        padding-right: 60px;
        animation: premiumMarqueeLoop 25s linear infinite;
        will-change: transform;
    }

    /* Pause on hover mechanism for premium interactive control */
    .marquee-viewport:hover .marquee-track {
        animation-play-state: paused;
    }

    /* Individual Logo Item Architecture */
    .marquee-logo-item {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        width: 140px;
        flex-shrink: 0;
    }

    .marquee-logo-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: grayscale(0%) brightness(1) invert(0); /* Forces logos to clean White */
        opacity: 1;
        transition: opacity 0.3s ease, filter 0.3s ease;
    }

    /* Interactive logo activation highlights on individual focus */
    .marquee-logo-item img:hover {
        opacity: 1;
        filter: grayscale(0%) brightness(1) invert(0); /* Restores brand color or fully pops image */
    }

    /* ==========================================================================
    HARDWARE-ACCELERATED CSS TRACK TRANSLATION KEYFRAMES
    ========================================================================== */
    @keyframes premiumMarqueeLoop {
        0% {
            transform: translate3d(0, 0, 0);
        }
        100% {
            transform: translate3d(-100%, 0, 0);
        }
    }

    /* RESPONSIVE CONTROL MATRIX */
    @media (max-width: 767.98px) {
        .marquee-section { padding: 30px 0; }
        .marquee-track { gap: 40px; padding-right: 40px; animation-duration: 18s; } /* Slightly faster speed adjustment on small viewports */
        .marquee-logo-item { width: 110px; height: 40px; }
        .marquee-section::before, .marquee-section::after { width: 60px; }
    }
</style>

<!-- MAIN PLANTS SHOWCASE BLOCK -->

<div class="marquee-section">
    <div class="marquee-viewport">
        
        <!-- TRACK SET A: Primary sequence element loop -->
        <div class="marquee-track">
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_01.png" alt="Associate Brand One" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_02.png" alt="Associate Brand Two" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_03.png" alt="Associate Brand Three" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_04.png" alt="Associate Brand Four" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_05.png" alt="Associate Brand Five" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_06.png" alt="Associate Brand Six" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_07.png" alt="Associate Brand Seven" loading="lazy"></div>
        </div>

        <!-- TRACK SET B: Exact clone sequence element to prevent visual popping/gaps at loop boundaries -->
        <div class="marquee-track" aria-hidden="true">
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_01.png" alt="Associate Brand One" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_02.png" alt="Associate Brand Two" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_03.png" alt="Associate Brand Three" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_04.png" alt="Associate Brand Four" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_05.png" alt="Associate Brand Five" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_06.png" alt="Associate Brand Six" loading="lazy"></div>
            <div class="marquee-logo-item"><img src="assets/images/plants/plant_07.png" alt="Associate Brand Seven" loading="lazy"></div>
        </div>

    </div>
</div>
<div class="plants-wrapper">
    <div class="container">

        <!-- Introductory Header Unit -->
        <div class="plants-intro-panel plant-reveal">
            <span class="plants-pretitle">Infrastructure</span>
            <h2 class="plants-main-title">Crafting Excellence Across Our Plants</h2>
            <p class="plants-lead-text">
                The precision of our glassmaking begins with the power of our plants, combining heavy industrial execution with automated calculation lines to deliver top-tier container production capacity.
            </p>
        </div>

        <!-- PLANT FACILITY BLOCK 01 -->
        <div class="plant-row-item plant-reveal">
            <div class="plant-media-frame">
                    <img src="assets/images/plants/plant_01.png" alt="Primary Glass Manufacturing Plant Floor" loading="lazy">
            </div>
            <div class="plant-info-block">
                <div class="plant-heading-group">
                    <h3 class="plant-name">Mathur Glass Industries – A Legacy of Craftsmanship in Glass Bangles</h3>
                </div>
                <div class="plant-description-grid">
                    <p class="plant-desc-text">
                        Founded in 1985 by Mr. Nannumal Agarwal Ji, Mathur Glass Industries holds a special place in our group’s heritage, representing the vision and dedication of our esteemed founder. Under the leadership of our chairman, Mr. Mohit Mohan Agarwal Ji, the company has grown from a humble 500kg pot furnace to a state-of-the-art 20-tonne glass bangle manufacturing unit, making it the largest producer of glass bangles in Firozabad.
                    </p>
                    <!-- <p class="plant-desc-text">
                        We specialize in high-output runs for standard glass containers, operating alongside automatic batching lines to ensure consistent raw material mixtures. Every single product passing down this line is monitored by optoelectronic verification machinery to maintain absolute quality control metrics.
                    </p> -->
                </div>
            </div>
        </div>

        <!-- PLANT FACILITY BLOCK 02 -->
        <div class="plant-row-item plant-reveal">
            <div class="plant-media-frame">
                <img src="assets/images/plants/plant_02.png" alt="Advanced Processing Facility" loading="lazy">
            </div>
            <div class="plant-info-block">
                <div class="plant-heading-group">
                    <h3 class="plant-name">Pioneer Glass Industries – Excellence in Press Glass & Vacuum Thermos Manufacturing</h3>
                </div>
                <div class="plant-description-grid">
                    <p class="plant-desc-text">
                        Established in 1994, Pioneer Glass Industries is a leading manufacturer of high-quality tumblers and bowls in a distinctive greenish hue, specially crafted for decorative and functional purposes. With a strong foundation in precision press glass production and advanced vacuum thermos technology, we cater to both domestic and international markets with unmatched expertise.
                    </p>
                </div>
            </div>
        </div>
        <!-- PLANT FACILITY BLOCK 03 -->
        <div class="plant-row-item plant-reveal">
            <div class="plant-media-frame">
                <img src="assets/images/plants/plant_03.png" alt="Advanced Processing Facility" loading="lazy">
            </div>
            <div class="plant-info-block">
                <div class="plant-heading-group">
                    <h3 class="plant-name">Firozabad Block Glass Enterprises – A Legacy of Innovation in Glass Manufacturing</h3>
                </div>
                <div class="plant-description-grid">
                    <p class="plant-desc-text">
                        Established in 1989, Firozabad Block Glass Enterprises has evolved through decades of transformation, adapting to the ever-changing demands of the glass industry. From bangles to glass marbles, to mouth-blown glass, and now specializing in scientific glassware, we have continuously reinvented ourselves to stay at the forefront of glass manufacturing.
                    </p>
                </div>
            </div>
        </div>
        <!-- PLANT FACILITY BLOCK 04 -->
        <div class="plant-row-item plant-reveal">
            <div class="plant-media-frame">
                <img src="assets/images/plants/plant_04.png" alt="Advanced Processing Facility" loading="lazy">
            </div>
            <div class="plant-info-block">
                <div class="plant-heading-group">
                    <h3 class="plant-name">Crystal Glass Industries – Excellence in Mouth-Blown & Pressed Glass</h3>
                </div>
                <div class="plant-description-grid">
                    <p class="plant-desc-text">
                        Founded in 2002, Crystal Glass Industries has evolved through decades of innovation and craftsmanship. From our humble beginnings in marble (kanche) and glass button (chagrin) production, we have transformed into a leading manufacturer of mouth-blown and single-press glassware, delivering timeless elegance and superior quality.
                    </p>
                </div>
            </div>
        </div>
        <!-- PLANT FACILITY BLOCK 05 -->
        <div class="plant-row-item plant-reveal">
            <div class="plant-media-frame">
                <img src="assets/images/plants/plant_05.png" alt="Advanced Processing Facility" loading="lazy">
            </div>
            <div class="plant-info-block">
                <div class="plant-heading-group">
                    <h3 class="plant-name">M/S Girdhari Lal Manohar Lal Glass Works No.2 (GM Glass Works) – A Trusted Name in Liquor Glass Manufacturing</h3>
                </div>
                <div class="plant-description-grid">
                    <p class="plant-desc-text">
                        GM Glass Works is a prominent leader in the glass industry, specializing in manufacturing high-quality glass bottles for India’s top liquor brands. With an impressive furnace capacity of 200 metric tonnes, we ensure consistent, large-scale production to meet the growing demands of the beverage sector.
                    </p>
                </div>
            </div>
        </div>
        <!-- PLANT FACILITY BLOCK 06 -->
        <div class="plant-row-item plant-reveal">
            <div class="plant-media-frame">
                <img src="assets/images/plants/plant_06.png" alt="Advanced Processing Facility" loading="lazy">
            </div>
            <div class="plant-info-block">
                <div class="plant-heading-group">
                    <h3 class="plant-name">Emaar Glass Industries – A Leading Name in Glass Trading & Lug Cap Manufacturing</h3>
                </div>
                <div class="plant-description-grid">
                    <p class="plant-desc-text">
                        Established in 2018, Emaar Glass Industries is a premier glass trading company, sourcing high-quality glass from top manufacturers and supplying it to several renowned Indian brands. With an impressive turnover of $20 million USD, our expertise in the glass trading sector has positioned us as a trusted partner for businesses across the country.
                    </p>
                </div>
            </div>
        </div>
        <!-- PLANT FACILITY BLOCK 07 -->
        <div class="plant-row-item plant-reveal">
            <div class="plant-media-frame">
                <img src="assets/images/plants/plant_07.png" alt="Advanced Processing Facility" loading="lazy">
            </div>
            <div class="plant-info-block">
                <div class="plant-heading-group">
                    <h3 class="plant-name">Neon Business India Pvt. Ltd. – Excellence in Glass Decoration & Value Addition</h3>
                </div>
                <div class="plant-description-grid">
                    <p class="plant-desc-text">
                        Established in 2019, Neon Business India Pvt. Ltd. is a leader in glass decoration and value addition, equipped with state-of-the-art machinery to deliver premium-quality finishing solutions. We specialize in high-precision printing, coating, frosting, hot stamping, and decal applications, ensuring that every glass product meets the highest standards of craftsmanship and durability.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- SCROLL ENGINE INITIALIZER INTERSECTION OBSERVER -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const plantItems = document.querySelectorAll('.plant-reveal');

        const observerOptions = {
            root: null,
            threshold: 0.1, // Element triggers into visible state when 10% occupies the viewport space
            rootMargin: "0px 0px -20px 0px"
        };

        const plantsObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target); // Release memory monitoring bindings once loaded
                }
            });
        }, observerOptions);

        plantItems.forEach(item => {
            plantsObserver.observe(item);
        });
    });
</script>
<?php include 'includes/footer.php'; ?>