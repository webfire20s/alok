<?php include 'includes/header.php';?>
<!-- PERFORMANCE DEPENDENCIES -->
<!-- Load heavy icon fonts asynchronously so they don't block layout paint -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="tourstyle.css">
<style>
    /* Content visibility hint prevents browser layout thrashing on long image pages */
    .tour-section {
        content-visibility: auto;
        contain-intrinsic-size: 1000px;
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
                    <img src="assets/images/tour/entrance_main.png" alt="Main Infrastructure Gate Layout" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/entrance_lobby.jpg" alt="Visitor Reception Lobby" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/entrance_security2.png" alt="Main Infrastructure Gate Layout" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/entrance_security.jpg" alt="Security Logistics Station" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/reception1.jpeg" alt="Visitor Reception Lobby" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/reception2.jpg" alt="Security Logistics Station" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/reception3.jpeg" alt="Main Infrastructure Gate Layout" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/reception4.jpg" alt="Visitor Reception Lobby" loading="lazy" decoding="async">
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
                    <img src="assets/images/tour/proc1.jpg" alt="Raw Materials Sorting Unit" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/proc2.jpg" alt="High Temperature Furnace Line" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/proc3.jpg" alt="CNC Calibration Unit" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/proc6.jpg" alt="CNC Calibration Unit" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/proc4.jpg" alt="High Temperature Furnace Line" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/proc5.jpg" alt="Raw Materials Sorting Unit" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/proc7.jpg" alt="High Temperature Furnace Line" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/proc8.jpg" alt="Raw Materials Sorting Unit" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/proc9.jpg" alt="CNC Calibration Unit" loading="lazy" decoding="async">
                </div>
            </div>
        </div>

        <!-- STAGE 3: QUALITY ASSURANCE & PACKAGING (Pattern C Layout) -->
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">03</span> Dcnorations & Packaging
            </h2>
            <div class="tour-grid grid-pattern-c">
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec1.png" alt="Testing and Verification Lab" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec2.png" alt="Secure Shucking Containment Pack" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec3.png" alt="Heavy Cargo Logistics Bay" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec4.jpeg" alt="Testing and Verification Lab" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec6.jpeg" alt="Heavy Cargo Logistics Bay" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec5.jpg" alt="Secure Shucking Containment Pack" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec7.png" alt="Testing and Verification Lab" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec8.jpeg" alt="Secure Shucking Containment Pack" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec9.jpeg" alt="Heavy Cargo Logistics Bay" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec10.jpg" alt="Testing and Verification Lab" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec11.jpg" alt="Secure Shucking Containment Pack" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec12.png" alt="Heavy Cargo Logistics Bay" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec13.png" alt="Testing and Verification Lab" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec14.png" alt="Heavy Cargo Logistics Bay" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec15.png" alt="Secure Shucking Containment Pack" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-1">
                    <img src="assets/images/tour/dec16.png" alt="Testing and Verification Lab" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame side-box-2">
                    <img src="assets/images/tour/dec17.png" alt="Secure Shucking Containment Pack" loading="lazy" decoding="async">
                </div>
                <div class="tour-media-frame feat-box">
                    <img src="assets/images/tour/dec18.png" alt="Heavy Cargo Logistics Bay" loading="lazy" decoding="async">
                </div>
            </div>
        </div>

    </div>
</div>

<!-- HIGH PERFORMANCE INTERSECTION CONTROLLER ENGINE -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const revealItems = document.querySelectorAll('.reveal-item');
        
        const revealOptions = {
            root: null,
            threshold: 0.05, // Dropped to 5% so rendering triggers quickly and smoothly before the user hits the section empty space
            rootMargin: "0px 0px 100px 0px" // Trigger loading slightly before it scrolls into frame
        };

        const revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target); 
                }
            });
        }, revealOptions);

        revealItems.forEach(item => {
            revealObserver.observe(item);
        });
    });
</script>
<?php include 'includes/footer.php';?>