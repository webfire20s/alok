<?php
include 'includes/header.php';
?>
<style>
 /* --- ADVANCED CINEMATIC / BRUTALIST ARCHITECTURE --- */
    @font-face {
        font-display: swap;
    }

    /* Dynamic Scroll Mask Reveal Effect */
    .mask-reveal {
        view-timeline-name: --section-reveal;
        view-timeline-axis: block;
        animation: clipReveal linear both;
        animation-timeline: --section-reveal;
        animation-range: entry 5% cover 35%;
    }

    @keyframes clipReveal {
        from {
            opacity: 0;
            clip-path: inset(40% 0 40% 0);
            transform: scale(0.95) translateY(70px);
        }
        to {
            opacity: 1;
            clip-path: inset(0% 0 0% 0);
            transform: scale(1) translateY(0);
        }
    }

    /* Staggered text delays for the brand narrative columns */
    .split-text-reveal > * {
        view-timeline-name: --text-reveal;
        view-timeline-axis: block;
        animation: slideUpFade linear both;
        animation-timeline: --text-reveal;
        animation-range: entry 10% cover 30%;
    }

    @keyframes slideUpFade {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Premium Balanced Grid Layout */
    .metric-grid-premium {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        width: 100%;
    }

    .metric-cell-premium {
        padding: 40px 20px;
        border-right: 1px solid #222222;
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        position: relative;
        overflow: hidden;
    }

    .metric-cell-premium:last-child {
        border-right: none;
    }

    .metric-cell-premium::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 3px;
        background-color: #c8232c;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .metric-cell-premium:hover::before {
        transform: scaleX(1);
    }

    .metric-cell-premium:hover {
        background: #16191f;
    }

    /* Responsiveness overrides */
    @media (max-width: 991px) {
        .metric-grid-premium { grid-template-columns: repeat(2, 1fr); }
        .metric-cell-premium { border-bottom: 1px solid #222222; }
        .metric-cell-premium:nth-child(2n) { border-right: none; }
    }
    @media (max-width: 576px) {
        .metric-grid-premium { grid-template-columns: 1fr; }
        .metric-cell-premium { border-right: none; }
    }

    /* --- LUXURY BENTO & MATRICES LAYOUT FRAMEWORK --- */
    .scroll-reveal-stagger {
        view-timeline-name: --grid-stagger;
        view-timeline-axis: block;
        animation: luxuriousFadeUp linear both;
        animation-timeline: --grid-stagger;
        animation-range: entry 5% cover 22%;
    }

    @keyframes luxuriousFadeUp {
        from {
            opacity: 0;
            transform: translateY(50px) scale(0.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Value Cards Monolithic Matrix */
    .value-matrix-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-top: 1px solid #eeeeee;
        border-left: 1px solid #eeeeee;
        width: 100%;
    }

    .value-matrix-cell {
        background-color: #ffffff;
        border-right: 1px solid #eeeeee;
        border-bottom: 1px solid #eeeeee;
        padding: 50px 30px;
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        position: relative;
        z-index: 1;
    }

    .value-matrix-cell::after {
        content: '';
        position: absolute;
        left: 0; bottom: 0; width: 100%; height: 0%;
        background-color: #111111;
        z-index: -1;
        transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Certifications Showcase */
    .cert-flex-layout {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 16px;
        width: 100%;
    }

    /* Responsive Structural Breakdowns */
    @media (max-width: 1199px) {
        .cert-flex-layout { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 991px) {
        .value-matrix-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .value-matrix-grid { grid-template-columns: 1fr; }
        .cert-flex-layout { grid-template-columns: repeat(2, 1fr); }
    }

    /* --- LUXURY EDITORIAL & LEADERSHIP LAYOUTS --- */
    .scroll-reveal-final {
        view-timeline-name: --final-reveal;
        view-timeline-axis: block;
        animation: luxuriousSlideUp linear both;
        animation-timeline: --final-reveal;
        animation-range: entry 8% cover 24%;
    }

    @keyframes luxuriousSlideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Monolithic Leadership Grid Architecture */
    .leadership-matrix {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-top: 1px solid #eeeeee;
        width: 100%;
    }

    .leadership-cell {
        background-color: #ffffff;
        padding: 60px 40px;
        border-right: 1px solid #eeeeee;
        border-bottom: 1px solid #eeeeee;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .leadership-cell:nth-child(3n) {
        border-right: none;
    }

    .leadership-cell::after {
        content: '';
        position: absolute;
        left: 0; top: 0; width: 3px; height: 0%;
        background-color: #c8232c;
        transition: height 0.4s ease;
    }

    .leadership-cell:hover::after {
        height: 100%;
    }

    .leadership-cell:hover {
        background-color: #fafafa;
        transform: translateY(-4px);
    }

    /* Responsiveness overrides */
    @media (max-width: 991px) {
        .leadership-matrix { grid-template-columns: 1fr; }
        .leadership-cell { border-right: none !important; padding: 45px 25px; }
    }
</style>

<section class="py-5 text-white d-flex align-items-center"
    style="
    background: linear-gradient(rgba(11, 13, 16, 0.75), rgba(11, 13, 16, 0.9)), url('storage/media/about-hero.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed; /* Parallax Base Layer Effect */
    min-height: 80vh;
    font-family: 'Montserrat', sans-serif;
    position: relative;
    ">

    <div class="container py-5 text-center">

        <h5 class="text-uppercase mb-3" style="font-size: 11px; font-weight: 700; letter-spacing: 0.3em; color: #c8232c;">
            Leading Glass Bottle Manufacturer In India
        </h5>

        <h1 class="font-weight-bold mb-4 text-uppercase" style="font-size: clamp(32px, 5vw, 56px); font-weight: 900; letter-spacing: 0.03em; max-width: 1000px; margin: 0 auto; line-height: 1.15;">
            Crafting Excellence<br><span style="font-weight: 300; color: #eeeeee;">With Integrity & Purpose</span>
        </h1>

        <div style="width: 60px; height: 1px; background-color: rgba(255,255,255,0.2); margin: 30px auto;"></div>

        <p class="lead mx-auto mb-5" style="max-width: 680px; font-size: 15px; color: #cccccc; font-weight: 400; line-height: 1.8; letter-spacing: 0.03em;">
            Premium glass bottles, jars and packaging solutions trusted by food, beverage, pharmaceutical and cosmetic brands across India and global markets.
        </p>

        <div class="d-sm-flex justify-content-center align-items-center">
            <a href="products.php" class="btn text-uppercase m-2" style="background-color: #ffffff; color: #111111; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; padding: 18px 38px; border-radius: 0px; border: 1px solid #ffffff; transition: all 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='transparent'; this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#111111';">
                Explore Products
            </a>

            <a href="contact.php" class="btn text-uppercase m-2" style="background-color: transparent; color: #ffffff; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; padding: 18px 38px; border-radius: 0px; border: 1px solid #ffffff; transition: all 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#ffffff';">
                Contact Us
            </a>
        </div>

    </div>
</section>

<section class="py-5 mask-reveal" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif; overflow: hidden;">
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-4 mb-5 mb-lg-0" style="position: relative;">
                <div style="position: sticky; top: 100px;">
                    <span style="font-size: 11px; font-weight: 700; color: #c8232c; letter-spacing: 0.2em; text-transform: uppercase; display: block; margin-bottom: 10px;">01 / HISTORICAL TRACK</span>
                    <h2 class="text-uppercase m-0" style="font-size: 38px; font-weight: 900; color: #111111; letter-spacing: 0.02em; line-height: 1.1;">
                        Our<br>Journey
                    </h2>
                    <div style="width: 40px; height: 4px; background-color: #c8232c; margin-top: 20px;"></div>
                </div>
            </div>

            <div class="col-lg-4 mb-5 mb-lg-0">
                <div style="position: relative; padding-right: 15px;">
                    <div style="position: absolute; bottom: -20px; left: -20px; width: 140px; height: 140px; background-color: #fafafa; z-index: 1; border: 1px solid #eeeeee;"></div>
                    <div style="border: 1px solid #111111; padding: 0; background-color: #ffffff; position: relative; z-index: 2;">
                        <img
                            src="storage/media/about-banner.jpg"
                            class="img-fluid"
                            style="width: 100%; display: block; filter: grayscale(20%); transition: all 0.5s ease;"
                            onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.02)';"
                            onmouseout="this.style.filter='grayscale(20%)'; this.style.transform='scale(1.0)';"
                        >
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex flex-column justify-content-center split-text-reveal" style="padding-left: 25px;">
                <p style="font-size: 15px; line-height: 1.8; color: #111111; font-weight: 600; margin-bottom: 24px; letter-spacing: 0.01em;">
                    What started with manually packing just 500 kilograms of glass daily has grown into one of India's trusted packaging manufacturers.
                </p>

                <p style="font-size: 14px; line-height: 1.8; color: #333333; font-weight: 500; margin-bottom: 24px; letter-spacing: 0.01em;">
                    Today Alok Glass packs approximately 500 metric tonnes daily while serving businesses across multiple industries.
                </p>

                <p style="font-size: 14px; line-height: 1.8; color: #666666; font-weight: 400; margin-bottom: 0; letter-spacing: 0.01em; border-left: 2px solid #eeeeee; padding-left: 15px;">
                    Through decades of dedication, innovation and customer trust, we have transformed into a leading packaging partner for brands across India and international markets.
                </p>
            </div>

        </div>
    </div>
</section>

<section class="mask-reveal" style="background-color: #111111; color: #ffffff; font-family: 'Montserrat', sans-serif; border-top: 1px solid #222222; border-bottom: 1px solid #222222;">
    <div class="container-fluid p-0">

        <div class="metric-grid-premium text-center">

            <div class="metric-cell-premium">
                <h1 style="font-size: 56px; font-weight: 900; color: #c8232c; margin-bottom: 10px; letter-spacing: -0.03em; line-height: 1;">
                    500+
                </h1>
                <p class="text-uppercase" style="font-size: 10px; font-weight: 700; color: #888888; letter-spacing: 0.15em; margin: 0; line-height: 1.5;">
                    Metric Tonnes Packed Daily
                </p>
            </div>

            <div class="metric-cell-premium">
                <h1 style="font-size: 56px; font-weight: 900; color: #c8232c; margin-bottom: 10px; letter-spacing: -0.03em; line-height: 1;">
                    24+
                </h1>
                <p class="text-uppercase" style="font-size: 10px; font-weight: 700; color: #888888; letter-spacing: 0.15em; margin: 0; line-height: 1.5;">
                    Years Leadership Experience
                </p>
            </div>

            <div class="metric-cell-premium">
                <h1 style="font-size: 56px; font-weight: 900; color: #c8232c; margin-bottom: 10px; letter-spacing: -0.03em; line-height: 1;">
                    1000+
                </h1>
                <p class="text-uppercase" style="font-size: 10px; font-weight: 700; color: #888888; letter-spacing: 0.15em; margin: 0; line-height: 1.5;">
                    Business Customers
                </p>
            </div>

            <div class="metric-cell-premium">
                <h1 style="font-size: 56px; font-weight: 900; color: #c8232c; margin-bottom: 10px; letter-spacing: 0.02em; text-transform: uppercase; line-height: 1;">
                    Global
                </h1>
                <p class="text-uppercase" style="font-size: 10px; font-weight: 700; color: #888888; letter-spacing: 0.15em; margin: 0; line-height: 1.5;">
                    Market Presence
                </p>
            </div>

        </div>

    </div>
</section>

<!-- VALUE PROPOSITIONS: Minimalist Architectural Matrix Layout -->
<section class="py-5 scroll-reveal-stagger" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-5">

        <div class="mb-5" style="position: relative;">
            <span style="font-size: 11px; font-weight: 700; color: #c8232c; letter-spacing: 0.25em; text-transform: uppercase; display: block; margin-bottom: 8px;">
                Operational Pillars
            </span>
            <h2 class="text-uppercase m-0" style="font-size: 32px; font-weight: 800; color: #111111; letter-spacing: 0.02em;">
                Why Businesses Choose Alok Glass
            </h2>
            <div style="width: 50px; height: 2px; background-color: #c8232c; margin-top: 15px;"></div>
        </div>

        <div class="value-matrix-grid">

            <!-- Card 01 -->
            <div class="value-matrix-cell" 
                 onmouseover="this.style.color='#ffffff'; this.querySelector('p').style.color='#cccccc'; this.querySelector('.icon-box').style.backgroundColor='#222222'; this.style.transform='translateY(-4px)';" 
                 onmouseout="this.style.color='#111111'; this.querySelector('p').style.color='#555555'; this.querySelector('.icon-box').style.backgroundColor='#fafafa'; this.style.transform='translateY(0)';">
                <style>.value-matrix-cell:hover::after { height: 100%; }</style>
                
                <div class="icon-box mb-4 d-inline-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background-color: #fafafa; border: 1px solid rgba(0,0,0,0.05); border-radius: 4px; font-size: 22px; transition: background-color 0.3s ease;">
                    🏭
                </div>
                <h5 class="text-uppercase mb-3" style="font-size: 14px; font-weight: 800; letter-spacing: 0.04em; color: inherit;">
                    Large Scale Manufacturing
                </h5>
                <p class="mb-0" style="font-size: 13px; color: #555555; line-height: 1.7; font-weight: 400; transition: color 0.3s ease;">
                    Reliable production capacity for bulk orders.
                </p>
            </div>

            <!-- Card 02 -->
            <div class="value-matrix-cell" 
                 onmouseover="this.style.color='#ffffff'; this.querySelector('p').style.color='#cccccc'; this.querySelector('.icon-box').style.backgroundColor='#222222'; this.style.transform='translateY(-4px)';" 
                 onmouseout="this.style.color='#111111'; this.querySelector('p').style.color='#555555'; this.querySelector('.icon-box').style.backgroundColor='#fafafa'; this.style.transform='translateY(0)';">
                
                <div class="icon-box mb-4 d-inline-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background-color: #fafafa; border: 1px solid rgba(0,0,0,0.05); border-radius: 4px; font-size: 22px; transition: background-color 0.3s ease;">
                    🧪
                </div>
                <h5 class="text-uppercase mb-3" style="font-size: 14px; font-weight: 800; letter-spacing: 0.04em; color: inherit;">
                    Quality Assurance
                </h5>
                <p class="mb-0" style="font-size: 13px; color: #555555; line-height: 1.7; font-weight: 400; transition: color 0.3s ease;">
                    Strict quality control throughout production.
                </p>
            </div>

            <!-- Card 03 -->
            <div class="value-matrix-cell" 
                 onmouseover="this.style.color='#ffffff'; this.querySelector('p').style.color='#cccccc'; this.querySelector('.icon-box').style.backgroundColor='#222222'; this.style.transform='translateY(-4px)';" 
                 onmouseout="this.style.color='#111111'; this.querySelector('p').style.color='#555555'; this.querySelector('.icon-box').style.backgroundColor='#fafafa'; this.style.transform='translateY(0)';">
                
                <div class="icon-box mb-4 d-inline-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background-color: #fafafa; border: 1px solid rgba(0,0,0,0.05); border-radius: 4px; font-size: 22px; transition: background-color 0.3s ease;">
                    🎨
                </div>
                <h5 class="text-uppercase mb-3" style="font-size: 14px; font-weight: 800; letter-spacing: 0.04em; color: inherit;">
                    Custom Packaging
                </h5>
                <p class="mb-0" style="font-size: 13px; color: #555555; line-height: 1.7; font-weight: 400; transition: color 0.3s ease;">
                    Tailored solutions for unique brands.
                </p>
            </div>

            <!-- Card 04 -->
            <div class="value-matrix-cell" 
                 onmouseover="this.style.color='#ffffff'; this.querySelector('p').style.color='#cccccc'; this.querySelector('.icon-box').style.backgroundColor='#222222'; this.style.transform='translateY(-4px)';" 
                 onmouseout="this.style.color='#111111'; this.querySelector('p').style.color='#555555'; this.querySelector('.icon-box').style.backgroundColor='#fafafa'; this.style.transform='translateY(0)';">
                
                <div class="icon-box mb-4 d-inline-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background-color: #fafafa; border: 1px solid rgba(0,0,0,0.05); border-radius: 4px; font-size: 22px; transition: background-color 0.3s ease;">
                    🌎
                </div>
                <h5 class="text-uppercase mb-3" style="font-size: 14px; font-weight: 800; letter-spacing: 0.04em; color: inherit;">
                    Global Reach
                </h5>
                <p class="mb-0" style="font-size: 13px; color: #555555; line-height: 1.7; font-weight: 400; transition: color 0.3s ease;">
                    Trusted by customers worldwide.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- CERTIFICATIONS: Minimalist Premium Ribbon Display -->
<section class="py-5 scroll-reveal-stagger" style="background-color: #fafafa; font-family: 'Montserrat', sans-serif; border-top: 1px solid #eeeeee; border-bottom: 1px solid #eeeeee;">
    <div class="container py-4">

        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-2" style="font-size: 22px; font-weight: 800; color: #111111; letter-spacing: 0.06em;">
                Certifications & Memberships
            </h2>
            <div style="width: 35px; height: 3px; background-color: #c8232c; margin: 12px auto 0 auto;"></div>
        </div>

        <div class="cert-flex-layout">

            <div style="background-color: #ffffff; border: 1px solid #e8e8e8; padding: 25px 15px; min-height: 90px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease-in-out;" 
                 onmouseover="this.style.borderColor='#111111'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.02)';" 
                 onmouseout="this.style.borderColor='#e8e8e8'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <span style="font-size: 13px; font-weight: 700; color: #111111; letter-spacing: 0.08em;">FSSC 22000</span>
            </div>

            <div style="background-color: #ffffff; border: 1px solid #e8e8e8; padding: 25px 15px; min-height: 90px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease-in-out;" 
                 onmouseover="this.style.borderColor='#111111'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.02)';" 
                 onmouseout="this.style.borderColor='#e8e8e8'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <span style="font-size: 13px; font-weight: 700; color: #111111; letter-spacing: 0.08em;">ISO 9001</span>
            </div>

            <div style="background-color: #ffffff; border: 1px solid #e8e8e8; padding: 25px 15px; min-height: 90px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease-in-out;" 
                 onmouseover="this.style.borderColor='#111111'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.02)';" 
                 onmouseout="this.style.borderColor='#e8e8e8'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <span style="font-size: 13px; font-weight: 700; color: #111111; letter-spacing: 0.08em;">ISO 14001</span>
            </div>

            <div style="background-color: #ffffff; border: 1px solid #e8e8e8; padding: 25px 15px; min-height: 90px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease-in-out;" 
                 onmouseover="this.style.borderColor='#111111'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.02)';" 
                 onmouseout="this.style.borderColor='#e8e8e8'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <span style="font-size: 13px; font-weight: 700; color: #111111; letter-spacing: 0.08em;">UPGMS</span>
            </div>

            <div style="background-color: #ffffff; border: 1px solid #e8e8e8; padding: 25px 15px; min-height: 90px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease-in-out;" 
                 onmouseover="this.style.borderColor='#111111'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.02)';" 
                 onmouseout="this.style.borderColor='#e8e8e8'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <span style="font-size: 13px; font-weight: 700; color: #111111; letter-spacing: 0.08em;">AIGMS</span>
            </div>

            <div style="background-color: #ffffff; border: 1px solid #e8e8e8; padding: 25px 15px; min-height: 90px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease-in-out;" 
                 onmouseover="this.style.borderColor='#111111'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.02)';" 
                 onmouseout="this.style.borderColor='#e8e8e8'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <span style="font-size: 13px; font-weight: 700; color: #111111; letter-spacing: 0.08em;">MSME</span>
            </div>

        </div>
    </div>
</section>




<!-- CSR SECTION: Asymmetric Editorial Layout -->
<section class="py-5 scroll-reveal-final" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-5">
        <div class="row align-items-center">

            <!-- Imagery Layout with Offset Shadow Backdrop -->
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div style="position: relative; padding: 0 20px 20px 0;">
                    <div style="position: absolute; right: 0; bottom: 0; width: calc(100% - 20px); height: calc(100% - 20px); background-color: #fafafa; border: 1px solid #eeeeee; z-index: 1;"></div>
                    <div style="position: relative; z-index: 2; border: 1px solid #111111; overflow: hidden; background: #ffffff;">
                        <img
                            src="storage/media/csr.png"
                            class="img-fluid"
                            style="width: 100%; display: block; filter: grayscale(10%); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);"
                            onmouseover="this.style.transform='scale(1.03)';"
                            onmouseout="this.style.transform='scale(1.0)';"
                        >
                    </div>
                </div>
            </div>

            <!-- Narrative Typography Column -->
            <div class="col-lg-6 style-pl-override" style="padding-left: 50px;">
                <span style="font-size: 11px; font-weight: 700; color: #c8232c; letter-spacing: 0.25em; text-transform: uppercase; display: block; margin-bottom: 10px;">
                    02 / SOCIAL RESPONSIBILITY
                </span>
                
                <h2 class="text-uppercase mb-4" style="font-size: 36px; font-weight: 900; color: #111111; letter-spacing: 0.01em; line-height: 1.15;">
                    Giving Back<br>To Society
                </h2>
                
                <div style="width: 40px; height: 1px; background-color: #111111; margin-bottom: 30px;"></div>

                <p style="font-size: 15px; line-height: 1.8; color: #111111; font-weight: 600; margin-bottom: 20px; letter-spacing: 0.01em;">
                    In 2015, Alok Glass Works donated <strong style="color: #c8232c; font-weight: 700;">&#8377;25 Lakhs</strong> to support a charitable trust associated with a renowned Trauma Centre in Uttar Pradesh.
                </p>

                <p style="font-size: 14px; line-height: 1.8; color: #666666; font-weight: 400; margin-bottom: 0; border-left: 2px solid #eeeeee; padding-left: 20px;">
                    We hold a core conviction that corporate development should directly manifest as measurable, positive social impact for communities.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- LEADERSHIP ARCHITECTURE: Minimalist Line-Drawn Grid -->
<section class="py-5 scroll-reveal-final" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-5">

        <div class="text-center mb-5">
            <span style="font-size: 11px; font-weight: 700; color: #c8232c; letter-spacing: 0.25em; text-transform: uppercase; display: block; margin-bottom: 8px;">
                Corporate Vision
            </span>
            <h2 class="text-uppercase m-0" style="font-size: 32px; font-weight: 800; color: #111111; letter-spacing: 0.02em;">
                Leadership Messages
            </h2>
            <div style="width: 50px; height: 2px; background-color: #c8232c; margin: 15px auto 0 auto;"></div>
        </div>

        <div class="leadership-matrix">

            <!-- Card 01: Mohit Mohan Agarwal -->
            <div class="leadership-cell">
                <span style="font-size: 10px; font-weight: 700; color: #c8232c; letter-spacing: 0.15em; display: block; margin-bottom: 12px; text-transform: uppercase;">01 / FOUNDATION</span>
                
                <h4 style="font-size: 18px; font-weight: 800; color: #111111; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.02em;">
                    Mohit Mohan Agarwal
                </h4>
                
                <h6 class="text-uppercase mb-4" style="font-size: 11px; font-weight: 600; color: #888888; letter-spacing: 0.05em;">
                    Chairman
                </h6>

                <p style="font-size: 13px; line-height: 1.75; color: #333333; font-weight: 500; margin-bottom: 16px;">
                    "I started this journey at the age of 16, packing just 500 kg of glass daily with my own hands. Today we pack 500 metric tonnes every day."
                </p>

                <p style="font-size: 13px; line-height: 1.75; color: #666666; font-weight: 400; margin-bottom: 0;">
                    Our foundational principles remain pristine and completely unchanged: absolute integrity, constant innovation, and execution excellence.
                </p>
            </div>

            <!-- Card 02: Pranjal Agarwal -->
            <div class="leadership-cell">
                <span style="font-size: 10px; font-weight: 700; color: #c8232c; letter-spacing: 0.15em; display: block; margin-bottom: 12px; text-transform: uppercase;">02 / MODERNIZATION</span>
                
                <h4 style="font-size: 18px; font-weight: 800; color: #111111; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.02em;">
                    Pranjal Agarwal
                </h4>
                
                <h6 class="text-uppercase mb-4" style="font-size: 11px; font-weight: 600; color: #888888; letter-spacing: 0.05em;">
                    Director
                </h6>

                <p style="font-size: 13px; line-height: 1.75; color: #333333; font-weight: 500; margin-bottom: 0;">
                    "We continue modernizing operations across every vertical—embracing heavy automation and expanding globally while delivering industry-defining premium packaging solutions."
                </p>
            </div>

            <!-- Card 03: Global Operations -->
            <div class="leadership-cell">
                <span style="font-size: 10px; font-weight: 700; color: #111111; letter-spacing: 0.15em; display: block; margin-bottom: 12px; text-transform: uppercase;">03 / SCALING</span>
                
                <h4 style="font-size: 18px; font-weight: 800; color: #111111; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.02em;">
                    Global Operations
                </h4>
                
                <h6 class="text-uppercase mb-4" style="font-size: 11px; font-weight: 600; color: #888888; letter-spacing: 0.05em;">
                    International Expansion
                </h6>

                <p style="font-size: 13px; line-height: 1.75; color: #333333; font-weight: 500; margin-bottom: 0;">
                    "Our international division continues constructing core strategic partnerships, driving logistics optimization, and introducing the Alok Glass ecosystem to new cross-border enterprises."
                </p>
            </div>

        </div>
    </div>
</section>

<!-- CALL TO ACTION: High-Contrast Monolithic Canvas -->
<section class="py-5 text-white text-center scroll-reveal-final"
    style="
    background: #0b0d10;
    font-family: 'Montserrat', sans-serif;
    position: relative;
    overflow: hidden;
    ">
    
    <!-- Fine-line grid background detail -->
    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 100px 100px; pointer-events: none;"></div>

    <div class="container py-5" style="position: relative; z-index: 2;">

        <h2 class="text-uppercase mb-3" style="font-size: clamp(22px, 4vw, 36px); font-weight: 900; letter-spacing: 0.04em; color: #ffffff; line-height: 1.2;">
            We Don't Just Manufacture Glass
        </h2>

        <h4 class="text-uppercase mb-4" style="font-size: 13px; font-weight: 700; letter-spacing: 0.25em; color: #c8232c;">
            We Craft Trust. We Build Relationships.
        </h4>

        <div style="width: 40px; height: 1px; background-color: rgba(255,255,255,0.15); margin: 25px auto;"></div>

        <p class="mx-auto mb-5" style="max-width: 600px; font-size: 14px; color: #aaaaaa; font-weight: 400; line-height: 1.8; letter-spacing: 0.02em;">
            Partner with Alok Glass to secure a resilient global supply chain and high-precision packaging solutions engineered perfectly to scale alongside your enterprise.
        </p>

        <a 
            href="contact.php" 
            class="btn text-uppercase"
            style="background-color: #ffffff; color: #111111; font-size: 11px; font-weight: 700; letter-spacing: 0.2em; padding: 18px 42px; border-radius: 0px; border: 1px solid #ffffff; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: none;"
            onmouseover="this.style.backgroundColor='transparent'; this.style.borderColor='#c8232c'; this.style.color='#ffffff';"
            onmouseout="this.style.backgroundColor='#ffffff'; this.style.borderColor='#ffffff'; this.style.color='#111111';"
        >
            Contact Our Engineers
        </a>

    </div>
</section>
<?php
include 'includes/footer.php';
?>