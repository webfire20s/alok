<?php
include 'includes/header.php';
?>

<link
rel="stylesheet"
href="https://unpkg.com/aos@2.3.4/dist/aos.css"
/>

<style>

.infra-hero{
    position:relative;
    height:100vh;
    overflow:hidden;
}

.infra-hero video{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    object-fit:cover;
    
}

.infra-overlay{
    position:absolute;
    inset:0;
    background:rgba(39, 39, 39, 0.55);
    display:flex;
    align-items:center;
    z-index:100;
}

.hero-content{
    width:100%;
    color:#fff !important;
}

.hero-content h1{
    font-size:4rem;
    font-weight:700;
}

.hero-content p{
    max-width:800px;
    margin:auto;
}

@media(max-width:768px){

    .hero-content h1{
        font-size:2.5rem;
    }

}
.facility-scroll{

    display:flex;
    overflow-x:auto;
    gap:25px;
    padding-bottom:20px;
}

.facility-card{

    min-width:350px;
    border-radius:12px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.facility-card img{

    width:100%;
    height:220px;
    object-fit:cover;
}
</style>

<!-- HERO -->

<section class="infra-hero" >

    <video
        autoplay
        muted
        loop
        playsinline
    >

        <source
            src="assets/videos/infrastructure-hero.mp4"
            type="video/mp4"
        >

    </video>

    <div class="infra-overlay">

        <div class="container hero-content text-center text-darks">

            <h5
                class="text-uppercase mb-3"
                data-aos="fade-down"
            >
                Manufacturing Excellence
            </h5>

            <h1 style="color:white;"
                data-aos="zoom-in"
            >
                World-Class Infrastructure
            </h1>

            <p
                class="lead mt-4"
                data-aos="fade-up"
            >

                Advanced manufacturing facilities,
                precision engineering, modern quality systems
                and large-scale production capabilities that
                power Alok Glass Works.

            </p>

            <a
                href="contact.php"
                class="btn btn-light btn-lg mt-4"
                data-aos="fade-up"
            >
                Request Information
            </a>

        </div>

    </div>

</section>

<section class="py-5 bg-dark text-white">

    <div class="container">

        <div class="row text-center">

            <div
                class="col-md-3 mb-4"
                data-aos="fade-up"
            >

                <h1 class="display-4 font-weight-bold">

                    500+

                </h1>

                <p>
                    Metric Tonnes Packed Daily
                </p>

            </div>

            <div
                class="col-md-3 mb-4"
                data-aos="fade-up"
                data-aos-delay="100"
            >

                <h1 class="display-4 font-weight-bold">

                    24+

                </h1>

                <p>
                    Years Of Industry Experience
                </p>

            </div>

            <div
                class="col-md-3 mb-4"
                data-aos="fade-up"
                data-aos-delay="200"
            >

                <h1 class="display-4 font-weight-bold">

                    1000+

                </h1>

                <p>
                    Business Customers Served
                </p>

            </div>

            <div
                class="col-md-3 mb-4"
                data-aos="fade-up"
                data-aos-delay="300"
            >

                <h1 class="display-4 font-weight-bold">

                    Global

                </h1>

                <p>
                    Supply Network
                </p>

            </div>

        </div>

    </div>

</section>

<section class="py-5">

    <div class="container">

        <div class="row align-items-center">

            <div
                class="col-lg-6"
                data-aos="fade-right"
            >

                <img
                    src="assets/images/infrastructure/factory.jpg"
                    class="img-fluid rounded shadow"
                >

            </div>

            <div
                class="col-lg-6"
                data-aos="fade-left"
            >

                <h2 class="mb-4">

                    Modern Manufacturing Facility

                </h2>

                <p>

                    Alok Glass Works operates advanced
                    manufacturing infrastructure designed
                    to meet the packaging requirements
                    of food, beverage, pharmaceutical,
                    cosmetic and industrial sectors.

                </p>

                <p>

                    Our facilities are equipped with
                    high-capacity production systems,
                    modern inspection procedures and
                    streamlined logistics operations.

                </p>

                <p>

                    Continuous investment in machinery,
                    automation and quality systems enables
                    us to maintain consistency even at scale.

                </p>

            </div>

        </div>

    </div>

</section>

<section class="py-5 bg-light">

    <div class="container">

        <div class="text-center mb-5">

            <h2 data-aos="fade-up">

                Infrastructure Highlights

            </h2>

        </div>

        <div
            class="facility-scroll"
            data-aos="fade-up"
        >

            <div class="facility-card">

                <img
                    src="assets/images/infrastructure/manufacturing.jpg"
                >

                <div class="p-4">

                    <h4>
                        Manufacturing Unit
                    </h4>

                </div>

            </div>

            <div class="facility-card">

                <img
                    src="assets/images/infrastructure/warehouse.jpg"
                >

                <div class="p-4">

                    <h4>
                        Warehousing
                    </h4>

                </div>

            </div>

            <div class="facility-card">

                <img
                    src="assets/images/infrastructure/quality.jpg"
                >

                <div class="p-4">

                    <h4>
                        Quality Laboratory
                    </h4>

                </div>

            </div>

            <div class="facility-card">

                <img
                    src="assets/images/infrastructure/dispatch.jpg"
                >

                <div class="p-4">

                    <h4>
                        Dispatch Center
                    </h4>

                </div>

            </div>

        </div>

    </div>

</section>