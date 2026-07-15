<?php include 'includes/header.php';?>
<!-- DEPENDENCIES FOR SCROLL ANIMATIONS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ==========================================================================
       FACTORY TOUR DESIGN SYSTEM BASE
       ========================================================================== */
    .tour-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: #ffffff;
        color: #111111;
        padding: 60px 0 100px 0;
    }

    /* Core Hero Banner Style */
    .tour-hero-header {
        max-width: 800px;
        margin: 0 auto 80px auto;
        text-align: center;
    }

    .tour-hero-header h1 {
        font-size: 36px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #111111;
        margin-bottom: 15px;
    }

    .tour-hero-header p {
        font-size: 15px;
        color: #666666;
        font-weight: 500;
        letter-spacing: 0.02em;
        line-height: 1.6;
    }

    /* ==========================================================================
       EDITORIAL ASYMMETRIC GRID SYSTEM
       ========================================================================== */
    .tour-section {
        margin-bottom: 120px;
        position: relative;
    }

    /* Segment Modern Headers */
    .tour-section-title {
        font-size: 22px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #161616;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .tour-section-title::after {
        content: '';
        flex-grow: 1;
        height: 1px;
        background: #eef0f2;
    }

    .tour-step-num {
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
        background-color: #c8232c; /* Alok Red */
        padding: 4px 10px;
        border-radius: 2px;
        letter-spacing: 0;
    }

    /* Master Layout Framework */
    .tour-grid {
        display: grid;
        grid-template-columns: repeat(12, 11fr);
        gap: 24px;
        align-items: stretch;
    }

    /* High-Performance Frame Elements */
    .tour-media-frame {
        position: relative;
        overflow: hidden;
        border-radius: 6px;
        background-color: #161616; /* Charcoal Base layer */
        border: 1px solid #eef0f2;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                    border-color 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                    box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .tour-media-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                    opacity 0.4s ease;
    }

    /* Interactive Overlay Text Info */
    .tour-frame-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 25px;
        background: linear-gradient(to top, rgba(17, 17, 17, 0.85) 0%, rgba(17, 17, 17, 0) 100%);
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        opacity: 0;
        transform: translateY(10px);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* HOVER INTERACTIVITY TRIGGERS */
    .tour-media-frame:hover {
        transform: translateY(-6px);
        border-color: #c8232c; /* Alok Red Anchor Focus */
        box-shadow: 0 20px 40px rgba(200, 35, 44, 0.1);
    }

    .tour-media-frame:hover img {
        transform: scale(1.04);
        opacity: 0.85;
    }

    .tour-media-frame:hover .tour-frame-caption {
        opacity: 1;
        transform: translateY(0);
    }

    /* ==========================================================================
       ASYMMETRIC DISTRIBUTION PATTERNS
       ========================================================================== */
    
    /* Layout Pattern A: Dominant Large Left, Two Stacked Right */
    .grid-pattern-a .feat-box { grid-column: span 7; aspect-ratio: 4 / 3; }
    .grid-pattern-a .side-box-1 { grid-column: span 5; aspect-ratio: 4 / 2.3; }
    .grid-pattern-a .side-box-2 { grid-column: span 5; aspect-ratio: 4 / 2.3; }

    /* Layout Pattern B: Three Columns, Center Dominant Column height */
    .grid-pattern-b .side-box-1 { grid-column: span 4; aspect-ratio: 3 / 4; }
    .grid-pattern-b .feat-box { grid-column: span 5; aspect-ratio: 4 / 5; }
    .grid-pattern-b .side-box-2 { grid-column: span 3; aspect-ratio: 3 / 5; }

    /* Layout Pattern C: Inverse Dominant Large Right, Two Stacked Left */
    .grid-pattern-c .side-box-1 { grid-column: span 5; aspect-ratio: 4 / 2.3; }
    .grid-pattern-c .side-box-2 { grid-column: span 5; aspect-ratio: 4 / 2.3; }
    .grid-pattern-c .feat-box { grid-column: span 7; aspect-ratio: 4 / 3; }

    /* ==========================================================================
       SCROLL-REVEAL HARDWARE ENHANCED ANIMATION STYLES
       ========================================================================== */
    .reveal-item {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform, opacity;
    }

    .reveal-item.revealed {
        opacity: 1;
        transform: translateY(0);
    }

    /* ==========================================================================
       RESPONSIVE MATRIX MEDIA BREAKPOINTS
       ========================================================================== */
    @media (max-width: 991.98px) {
        .tour-hero-header { margin-bottom: 50px; }
        .tour-hero-header h1 { font-size: 28px; }
        .tour-section { margin-bottom: 80px; }
        
        /* Fall back to standard beautifully balanced columns on tablets */
        .tour-grid { gap: 16px; }
        .grid-pattern-a .feat-box, .grid-pattern-c .feat-box { grid-column: span 12; aspect-ratio: 16 / 9; }
        .grid-pattern-a .side-box-1, .grid-pattern-a .side-box-2,
        .grid-pattern-c .side-box-1, .grid-pattern-c .side-box-2 { grid-column: span 6; aspect-ratio: 4 / 3; }

        .grid-pattern-b .side-box-1, .grid-pattern-b .side-box-2 { grid-column: span 6; aspect-ratio: 1 / 1; }
        .grid-pattern-b .feat-box { grid-column: span 12; aspect-ratio: 16 / 9; order: -1; }
    }

    @media (max-width: 575.98px) {
        .tour-grid { display: flex; flex-direction: column; gap: 16px; }
        .tour-media-frame { aspect-ratio: 4 / 3 !important; }
        .tour-section-title { font-size: 18px; }
        .tour-frame-caption { opacity: 1; transform: none; padding: 15px; font-size: 11px; }
    }
</style>

<!-- FACTORY TOUR CONTAINER MAIN FRAME -->
<div class="tour-wrapper">
    <div class="container">

        <!-- Master Section Title Unit -->
        <div class="tour-hero-header">
            <h1>Factory Showcase</h1>
            <p>Take an exclusive inside look at our advanced manufacturing infrastructure, raw processing spaces, and final quality control operations.</p>
        </div>

        <!-- STAGE 1: MAIN ENTRANCE (Pattern A Layout) -->
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">01</span> Factory Entrance & Corporate Showroom
            </h2>
            <div class="tour-grid grid-pattern-a">
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/entrance_main.png" alt="Main Infrastructure Gate Layout" loading="lazy">
                    <!-- <div class="tour-frame-caption">Primary Entrance Complex</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/entrance_lobby.jpg" alt="Visitor Reception Lobby" loading="lazy">
                    <!-- <div class="tour-frame-caption">Corporate Office Entrance</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/entrance_security.jpg" alt="Security Logistics Station" loading="lazy">
                    <!-- <div class="tour-frame-caption">Employee's Parking Space</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/entrance_security2.png" alt="Main Infrastructure Gate Layout" loading="lazy">
                    <!-- <div class="tour-frame-caption">24/7 Logistics & Security Hub</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/reception1.jpeg" alt="Visitor Reception Lobby" loading="lazy">
                    <!-- <div class="tour-frame-caption">Showroom and Discussions space</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/reception2.jpg" alt="Security Logistics Station" loading="lazy">
                    <!-- <div class="tour-frame-caption">Meeting Space</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/reception3.jpeg" alt="Main Infrastructure Gate Layout" loading="lazy">
                    <!-- <div class="tour-frame-caption">Showroom</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/reception4.jpg" alt="Visitor Reception Lobby" loading="lazy">
                    <!-- <div class="tour-frame-caption">Visitor Reception Facility</div> -->
                </div>
                
            </div>
        </div>

        <!-- STAGE 2: PROCESSING FLOORS (Pattern B Layout) -->
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">02</span> Advanced Processing Yards
            </h2>
            <div class="tour-grid grid-pattern-b">
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/proc1.jpg" alt="Raw Materials Sorting Unit" loading="lazy">
                    <!-- <div class="tour-frame-caption">Raw Materials Logistics Vault</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/proc2.jpg" alt="High Temperature Furnace Line" loading="lazy">
                    <!-- <div class="tour-frame-caption">Automated Precision Processing Line</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/proc3.jpg" alt="CNC Calibration Unit" loading="lazy">
                    <!-- <div class="tour-frame-caption">CNC Control Station</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/proc6.jpg" alt="CNC Calibration Unit" loading="lazy">
                    <!-- <div class="tour-frame-caption">CNC Control Station</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/proc4.jpg" alt="High Temperature Furnace Line" loading="lazy">
                    <!-- <div class="tour-frame-caption">Automated Precision Processing Line</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/proc5.jpg" alt="Raw Materials Sorting Unit" loading="lazy">
                    <!-- <div class="tour-frame-caption">Raw Materials Logistics Vault</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/proc7.jpg" alt="High Temperature Furnace Line" loading="lazy">
                    <!-- <div class="tour-frame-caption">Automated Precision Processing Line</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/proc8.jpg" alt="Raw Materials Sorting Unit" loading="lazy">
                    <!-- <div class="tour-frame-caption">Raw Materials Logistics Vault</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/proc9.jpg" alt="CNC Calibration Unit" loading="lazy">
                    <!-- <div class="tour-frame-caption">CNC Control Station</div> -->
                </div>
            </div>
        </div>

        <!--  STAGE 3: QUALITY ASSURANCE & PACKAGING (Pattern C Layout) -->
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">03</span> Dcnorations & Packaging
            </h2>
            <div class="tour-grid grid-pattern-c">
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec1.png" alt="Testing and Verification Lab" loading="lazy">
                    <!-- <div class="tour-frame-caption">Laser Calibration & Tolerance Testing</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec2.png" alt="Secure Shucking Containment Pack" loading="lazy">
                    <!-- <div class="tour-frame-caption">Protective Automated Packing Systems</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec3.png" alt="Heavy Cargo Logistics Bay" loading="lazy">
                    <!-- <div class="tour-frame-caption">Global Export Dispatch Deck</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec4.jpeg" alt="Testing and Verification Lab" loading="lazy">
                    <!-- <div class="tour-frame-caption">Laser Calibration & Tolerance Testing</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec6.jpeg" alt="Heavy Cargo Logistics Bay" loading="lazy">
                    <!-- <div class="tour-frame-caption">Global Export Dispatch Deck</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec5.jpg" alt="Secure Shucking Containment Pack" loading="lazy">
                    <!-- <div class="tour-frame-caption">Protective Automated Packing Systems</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec7.png" alt="Testing and Verification Lab" loading="lazy">
                    <!-- <div class="tour-frame-caption">Laser Calibration & Tolerance Testing</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec8.jpeg" alt="Secure Shucking Containment Pack" loading="lazy">
                    <!-- <div class="tour-frame-caption">Protective Automated Packing Systems</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec9.jpeg" alt="Heavy Cargo Logistics Bay" loading="lazy">
                    <!-- <div class="tour-frame-caption">Global Export Dispatch Deck</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec10.jpg" alt="Testing and Verification Lab" loading="lazy">
                    <!-- <div class="tour-frame-caption">Laser Calibration & Tolerance Testing</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec11.jpg" alt="Secure Shucking Containment Pack" loading="lazy">
                    <!-- <div class="tour-frame-caption">Protective Automated Packing Systems</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec12.png" alt="Heavy Cargo Logistics Bay" loading="lazy">
                    <!-- <div class="tour-frame-caption">Global Export Dispatch Deck</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec13.png" alt="Testing and Verification Lab" loading="lazy">
                    <!-- <div class="tour-frame-caption">Laser Calibration & Tolerance Testing</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec14.png" alt="Heavy Cargo Logistics Bay" loading="lazy">
                    <!-- <div class="tour-frame-caption">Global Export Dispatch Deck</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec15.png" alt="Secure Shucking Containment Pack" loading="lazy">
                    <!-- <div class="tour-frame-caption">Protective Automated Packing Systems</div> -->
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec16.png" alt="Testing and Verification Lab" loading="lazy">
                    <!-- <div class="tour-frame-caption">Laser Calibration & Tolerance Testing</div> -->
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec17.png" alt="Secure Shucking Containment Pack" loading="lazy">
                    <!-- <div class="tour-frame-caption">Protective Automated Packing Systems</div> -->
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec18.png" alt="Heavy Cargo Logistics Bay" loading="lazy">
                    <!-- <div class="tour-frame-caption">Global Export Dispatch Deck</div> -->
                </div>
            </div>
        </div>

    </div>
</div>
<!-- SCROLL-D6IVEN HIGH PERFORMANCE INTERSECTION CONTROLLER ENGINE -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
     const revealItems = document.querySelectorAll('.reveal-item');

        const revealOptions = {
            root: null,
            threshold: 0.12, // Section triggers when 12% enters the viewport canvas area
            rootMargin: "0px 0px -40px 0px"
        };

        const revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target); // Kill resource monitoring loops once drawn
                }
            });
        }, revealOptions);

        revealItems.forEach(item => {
            revealObserver.observe(item);
        });
    });
</script>
<?php include 'includes/footer.php';?>