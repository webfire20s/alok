<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Scope-isolated theme to ensure it never breaks your main code logic */
    .alok-industrial-footer {
        font-family: 'Montserrat', sans-serif !important;
        background: #000000 !important; /* Deep industrial slate black */
        color: #a3aab5 !important;
        font-size: 14px;
        line-height: 1.8;
        border-top: 1px solid #1f242e;
        position: relative;
        overflow: hidden;
    }

    /* Core Entrance Animation */
    @keyframes alokFadeUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Apply staggered entrance animations to columns on load */
    .alok-industrial-footer .footer-column {
        animation: alokFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    .alok-industrial-footer .footer-column:nth-child(1) { animation-delay: 0.1s; }
    .alok-industrial-footer .footer-column:nth-child(2) { animation-delay: 0.25s; }
    .alok-industrial-footer .footer-column:nth-child(3) { animation-delay: 0.4s; }

    .alok-industrial-footer h4 {
        font-family: 'Montserrat', sans-serif !important;
        color: #ffffff !important; /* Professional clean off-white */
        font-weight: 700 !important;
        font-size: 15px !important;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 24px;
        position: relative;
        display: inline-block;
    }

    /* Minimalist line under headings with scale-up hover trigger */
    .alok-industrial-footer h4::after {
        content: '';
        display: block;
        width: 35px;
        height: 2.5px;
        background: #c8232c; /* Crimson Red Accent Line */
        margin-top: 8px;
        transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .alok-industrial-footer .footer-column:hover h4::after {
        width: 60px; /* Dynamic reactive heading underlines on hovering columns */
    }

    .alok-industrial-footer ul {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .alok-industrial-footer ul li {
        margin-bottom: 14px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: transform 0.25s ease;
    }

    /* Smooth shifting animation on hover for list nodes */
    .alok-industrial-footer .contact-info-list li:hover {
        transform: translateX(4px);
    }

    /* Structured layout links with responsive micro-transitions */
    .alok-industrial-footer ul li a {
        color: #a3aab5 !important;
        text-decoration: none !important;
        font-weight: 400;
        display: inline-block;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.3s ease;
    }

    .alok-industrial-footer ul li a:hover {
        color: #c8232c !important;
        transform: translateX(6px); /* Clean sliding link interaction */
    }

    /* Elegant Contact block structure */
    .alok-industrial-footer .contact-info-list li {
        font-weight: 300;
    }
    
    .alok-industrial-footer .contact-info-list b {
        color: #ffffff !important; /* Standard clean white emphasis */
        font-weight: 600 !important;
    }

    .alok-industrial-footer .contact-info-list i {
        color: #c8232c; /* Structured crimson accent for core contact icons */
        margin-top: 5px;
        width: 16px;
        text-align: center;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .alok-industrial-footer .contact-info-list li:hover i {
        transform: scale(1.2); /* Pulsing icon effect */
    }

    /* Social handles modern layouts & physical-based 3D spring hover dynamics */
    .alok-social-wrapper {
        margin-top: 25px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .alok-social-wrapper a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 6px;
        color: #ffffff !important; 
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .alok-social-wrapper a svg {
        transition: all 0.4s ease;
    }

    .alok-social-wrapper a:hover {
        background: #c8232c !important; /* Premium branding crimson hover */
        border-color: #c8232c !important;
        transform: translateY(-6px) scale(1.08);
        box-shadow: 0 10px 20px -5px rgba(200, 35, 44, 0.45);
    }

    .alok-social-wrapper a:hover svg {
        transform: scale(1.1);
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
    }

    /* Premium Bottom Copyright Bar with subtle pulse */
    .alok-copyright-bar {
        font-family: 'Montserrat', sans-serif !important;
        background: #000000 !important;
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 400;
        border-top: 1px solid #161a22;
        padding: 18px 0;
    }

    .alok-copyright-bar ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .alok-copyright-bar li {
        transition: color 0.3s ease;
    }

    .alok-copyright-bar li:hover {
        color: #c8232c;
    }

    /* Responsive Mobile Overrides for fluid presentation */
    @media (max-width: 767.98px) {
        .alok-industrial-footer {
            text-align: center;
        }
        .alok-industrial-footer h4::after {
            margin: 8px auto 0 auto;
        }
        .alok-industrial-footer ul li {
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }
        .alok-industrial-footer .contact-info-list i {
            margin-top: 0;
        }
        .alok-social-wrapper {
            justify-content: center;
        }
        .alok-industrial-footer ul li a:hover {
            transform: translateY(-2px);
        }
    }
</style>

<footer class="lt-gray-bg mt-5 alok-industrial-footer">
    <div class="container">
        <div class="row justify-content-center">

            <!-- Contact Column -->
            <div class="col-md-4 footer-column contact pt-5 pb-5">
                <h4>Contact Us</h4>
                <ul class="contact-info-list">
                    <li class="pin">
                        <i class="fa-solid fa-location-dot"></i>
                        <div style="color: #dddddd;">
                            <b style="font-weight: bold;">Firozabad:</b> Alok Glass Works<br />
                            Kia Showroom, Agra Road,<br />
                            Firozabad – 283203 (U.P.) India
                        </div>
                    </li>                

                    <li class="email">
                        <i class="fa-solid fa-envelope"></i>
                        <div style="color: #dddddd;">Email: pranjal@alokglass.com | sales@alokglass.com</div>
                    </li>

                    <li class="phone">
                        <i class="fa-solid fa-phone"></i>
                        <div style="color: #dddddd;">Phone/Whatsapp: +91 999-747-7289 | +91 703-787-7289 (9:30-6:00 pm)</div>
                    </li>
                </ul>
            </div>

            <!-- Useful Links Column -->
            <div class="col-md-3 footer-column pt-5 pb-5">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="about.php" target="_blank">About Us</a></li>
                    <li><a href="infrastructure" target="_blank">Infrastructure</a></li> 
                    <!-- <li><a href="gallery" target="_blank">Gallery</a></li>  -->
                    <li><a href="blogs" target="_blank">Blog</a></li>
                    <li><a href="video.php" target="_blank">Videos</a></li>
                </ul>

                <div class="alok-social-wrapper">
                    <a href="https://www.facebook.com/profile.php?id=61573026120811" target="_blank" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="opacity:0.95;">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                        </svg>
                    </a>
                    
                    <a href="https://www.linkedin.com/feed/?trk=guest_homepage-basic_google-one-tap-submit" target="_blank" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="opacity:0.95;">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v-.925H6.12c.03.679 0 7.225 0 7.225z"/>
                        </svg>
                    </a>
                    
                    <a href="https://www.youtube.com/@AlokGlassWorks/featured" target="_blank" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="opacity:0.95;">
                            <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.055-.075 1.969l-.009.104-.022.259-.01.104c-.048.519-.119 1.023-.22 1.402a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/>
                        </svg>
                    </a>
                    
                    <a href="https://www.instagram.com/official_alokglassworks/?hl=en" target="_blank" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="opacity:0.95;">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.704-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Let Us Help You Column -->
            <div class="col-md-3 footer-column pt-5 pb-5">
                <h4>Let Us Help You</h4>
                <ul>
                    <li><a href="login" target="_blank">My Account</a></li>
                    <li><a href="privacy.php" target="_blank">Privacy Policy</a></li>
                    <li><a href="terms.php" target="_blank">Terms and Conditions</a></li> 
                    <li><a href="contact" target="_blank">Contact Us</a></li>
                    <li><a href="tour.php" target="_blank">Factory Tour</a></li>
                </ul>
            </div>

        </div>
    </div>
</footer>

<div class="container-fluid text-center p-3 alok-copyright-bar">
    <ul class="footer-copyright">
        <li>&copy; <?php echo date("Y"); ?> Alok Glass Works. All Rights Reserved.</li>
    </ul>
</div>
<script>

function googleTranslateElementInit() {

    new google.translate.TranslateElement({

        pageLanguage: 'en',

        includedLanguages: 'en,hi,bn,te,mr,ta,ur,gu,kn,ml,or,pa,as,doi,kok,ks,ma,mni,ne,san,sat,sd,zh-CN,zh-TW,es,fr,de,it,pt,ru,ja,ko,ar,nl,tr,vi,th,id,pl,uk,fa,sv,no,fi,da,he,ms,tl,ro,el,cs,hu',

        autoDisplay: false,

        layout: google.translate.TranslateElement.InlineLayout.SIMPLE

    }, 'google_translate_element');

    new google.translate.TranslateElement({

        pageLanguage: 'en',

        includedLanguages: 'en,hi,bn,te,mr,ta,ur,gu,kn,ml,or,pa,as,doi,kok,ks,ma,mni,ne,san,sat,sd,zh-CN,zh-TW,es,fr,de,it,pt,ru,ja,ko,ar,nl,tr,vi,th,id,pl,uk,fa,sv,no,fi,da,he,ms,tl,ro,el,cs,hu',

        autoDisplay: false,

        layout: google.translate.TranslateElement.InlineLayout.SIMPLE

    }, 'google_translate_element_mobile');

}

</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!-- Bootstrap 5 JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body> 
</html>




<!-- <script src="assets/themes/storefront/public/js/appe8da.js?v=2.0.3"></script> -->

<!-- <script src="assets/themes/storefront/public/js/jquery-3.5.1.slim.min.js?v=2.0.3"></script> -->
<!-- <script src="assets/themes/storefront/public/js/popper.min.js?v=2.0.3"></script> -->
<!-- <script src="assets/themes/storefront/public/js/bootstrap.mine8da.js?v=2.0.3"></script> -->
        
         

<!-- // <sidebar-cart inline-template>
//     <aside class="sidebar-cart-wrap">
//         <div class="sidebar-cart-top">
//             <h3 class="title"> Shopping Cart</h3>

//             <div class="sidebar-cart-close">
//                 <i class="las la-times"></i>
//             </div>
//         </div>

//         <div class="sidebar-cart-middle" :class="{ 'custom-scrollbar': cartIsNotEmpty, empty: cartIsEmpty }">
//             <div class="sidebar-cart-items-wrap">
//                 <sidebar-cart-item
//                     v-for="cartItem in cart.items"
//                     :key="cartItem.id"
//                     :cart-item="cartItem"
//                 >
//                 </sidebar-cart-item>
//             </div>

//             <div class="empty-message" v-if="cartIsEmpty">
//                 <svg version="1.1"
//                 xmlns="http://www.w3.org/2000/svg"
//                 viewBox="0 0 500 500"
//                 preserveAspectRatio="xMidYMid meet">
//                 <g>
//                 <path d="M477.52,135.43c3.72-20.13-6.84-37.6-26.3-43.52c-90.6-27.43-180.44-54.64-267.05-80.8
//                     c-5.18-1.57-10.17-2.36-14.82-2.36c-15.49,0-27.41,8.74-34.46,25.26l-22.12,51.7c-12.92,30.19-25.82,60.37-38.74,90.56
//                     c-0.44,1.04-0.92,2.06-1.46,3.14l-3.03-0.9c-3.42-1.04-6.68-2.03-9.92-2.98c-2.89-0.86-5.59-1.29-8-1.29
//                     c-8.27,0-13.96,4.97-16.94,14.77c-3.79,12.5-7.58,25.03-11.33,37.54c-4.35,14.4-0.09,22.37,14.17,26.7l27.25,8.25
//                     c52.7,15.97,107.2,32.47,160.77,48.86c1.8,0.53,3.95,2.33,4.9,4.07c8.71,15.9,17.4,32.15,25.79,47.87
//                     c2.66,4.95,5.29,9.89,7.93,14.84l13.61,25.42c12.37,23.11,25.17,47.03,37.81,70.54c6.12,11.37,16.85,18.17,28.68,18.17
//                     c2.15,0,4.32-0.21,6.45-0.67c10.38-2.17,18.79-8.69,23.09-17.89c4.41-9.41,3.98-20.36-1.2-30.07
//                     c-19.28-36.24-38.99-73.04-58.04-108.61l-10.82-20.18c-0.23-0.44-0.44-0.88-0.67-1.32c-1.34-2.75-3.21-6.49-7.56-6.49
//                     c-1.13,0-2.33,0.28-3.68,0.83c-1.99,0.86-3.33,2.15-3.93,3.84c-0.9,2.54-0.18,5.69,2.4,10.49l17.75,33.19
//                     c16.99,31.71,33.95,63.4,50.89,95.13c5.11,9.57,2.5,19.65-6.33,24.52c-2.57,1.41-5.25,2.1-8.02,2.1c-6.4,0-12.32-3.88-15.83-10.42
//                     c-32.06-59.82-63.33-118.29-92.96-173.81c-4.95-9.29-2.91-17.66,5.73-23.6c6.1-4.16,5.22-8.44,3.42-11.28
//                     c-1.9-2.94-4.32-3.56-6.03-3.56c-1.8,0-3.74,0.67-5.8,2.03c-10.42,6.86-15.44,16.48-14.93,28.57c0.12,2.8,0.67,5.55,1.2,8.21
//                     c0.02,0.12,0.05,0.23,0.07,0.35c-18.95-5.76-37.91-11.53-56.86-17.29c-40.93-12.46-81.87-24.92-122.82-37.35
//                     c-1.39-0.42-2.27-0.97-2.61-1.59c-0.39-0.74-0.3-1.99,0.28-3.84c2.45-7.93,4.88-16.02,7.21-23.85c1.32-4.39,2.63-8.78,3.95-13.17
//                     c1.78-5.85,2.22-6.08,3.14-6.08c1.23,0,3.35,0.62,6.01,1.43l29.58,8.97c40.66,12.32,81.29,24.64,121.94,36.93
//                     c3.04,0.92,6.09,1.85,9.13,2.77c3.06,0.93,6.11,1.85,9.17,2.78c3.06,0.93,6.11,1.85,9.17,2.78c3.06,0.93,6.11,1.85,9.17,2.78
//                     c3.06,0.93,6.12,1.85,9.17,2.78c1.13,0.34,2.28,0.65,3.39,1.03c-0.8-0.32-1.58-0.33-2.41-0.07c-1.3,0.42-2.39,1.28-3.42,2.14
//                     c-0.94,0.78-1.86,1.68-2.22,2.88c-0.11,0.37-0.16,0.75-0.15,1.14c0.05,2.98,2.08,7.12,4.9,8.32c5.2,2.2,8.85,5.73,11.46,11.09
//                     c0.32,0.62,0.62,1.27,0.92,1.92c1.53,3.21,3.1,6.52,5.45,9.29c1.59,1.87,4.67,2.7,6.98,2.7c0.95,0,1.78-0.14,2.5-0.39
//                     c1.18-0.42,2.15-1.53,2.89-3.31c0.25-0.62,1.5-3.84,0.46-6.08c-3.19-6.91-6.7-13.2-10.45-18.74c-3.1-4.55-7.56-7.84-13.59-9.92
//                     c36.22,11,72.46,21.96,108.68,32.94l85.08,25.75c1.62,0.51,4.62,1.41,5.06,2.24c0.44,0.86-0.49,3.91-0.97,5.57
//                     c-1.55,5.11-3.07,10.24-4.62,15.37c-2.1,7.05-4.23,14.12-6.36,21.17c-1.48,4.9-2.03,4.9-2.89,4.9c-1.09,0-2.87-0.49-4.6-1.02
//                     l-13.54-4.09c-31.36-9.48-62.73-18.95-94.07-28.45c-1.8-0.55-3.24-0.81-4.51-0.81c-3.4,0-5.82,1.87-6.86,5.29
//                     c-2.17,7.21,4.74,9.31,7.03,9.98c15.37,4.65,30.74,9.31,46.11,13.98c21.31,6.45,42.62,12.92,63.95,19.35
//                     c2.2,0.67,4.37,0.99,6.43,0.99c7.9,0,14.15-4.95,16.73-13.22c3.79-12.3,7.81-25.63,12.62-42.02c3.14-10.77-1.55-19.58-12.25-23.02
//                     c-3.58-1.13-7.17-2.22-10.93-3.37c-1.16-0.35-2.33-0.69-3.54-1.06c0.02-0.37,0.05-0.69,0.09-0.95
//                     C458.17,239.95,467.83,187.66,477.52,135.43z M438.92,261.3l-4.78,25.86c-0.09,0.53-0.25,1.06-0.46,1.66l-200.41-60.72
//                     L87.39,183.92c0.28-0.76,0.55-1.48,0.86-2.17l6.73-15.72c18.07-42.37,36.15-84.71,54.25-127.05c4.25-9.94,11.33-15.21,20.5-15.21
//                     c2.8,0,5.82,0.49,8.97,1.46c88.85,26.86,177.67,53.76,266.49,80.69c14.03,4.23,19.81,13.68,17.17,28.04
//                     C454.61,176.41,446.64,219.56,438.92,261.3z"/>
//                 <path d="M193,311.18c0-2.33,0.02-9.41-7.47-9.64h-0.35c-3.63,0-5.41,1.8-6.24,3.33c-1.04,1.87-1.16,4.21-1.16,6.03
//                     c0.02,27,0.02,53.97,0,80.94c0,1.83,0.12,4.18,1.18,6.06c0.83,1.53,2.61,3.33,6.24,3.33h0.32c7.49-0.21,7.47-7.3,7.47-9.64
//                     c-0.02-9.75-0.02-19.51-0.02-29.26v-22.07C192.97,330.57,192.97,320.86,193,311.18z"/>
//                 <path d="M125.84,370.79c-0.07-1.02-0.16-2.05-0.27-3.07c-0.3-2.78-0.93-5.86-3.24-7.43c-2.42-1.64-6.8-1.21-9.02,0.6
//                     c-2.46,2.02-2.74,5.1-2.73,8.11c0.03,6.85,0.06,13.7,0.1,20.55c0.04,7.64-0.06,15.77-4.21,22.18c-3.96,6.14-11.15,9.67-18.39,10.62
//                     c-2.53,0.33-5.31,0.47-7.18,2.21c-1.47,1.36-2.05,3.47-2.03,5.47c0.02,2.01,0.63,4.1,2.08,5.48c1.85,1.76,4.64,2.05,7.19,1.98
//                     c7.61-0.2,15.14-2.74,21.3-7.2c6.17-4.46,10.94-10.81,13.51-17.97c2.32-6.47,2.85-13.43,3.08-20.3c0.15-4.48,0.19-8.95,0.11-13.43
//                     C126.11,375.99,126.02,373.38,125.84,370.79z"/>
//                 <path d="M220.11,462.08c-1.62,0-3.33,0.51-5.59,1.62c-2.43,1.2-4.9,1.8-7.35,1.8c-8.07,0-13.98-6.4-14.1-15.25
//                     c-0.07-5.69-0.07-11.74,0-18.51c0.07-7.81-4.62-9.11-7.44-9.18l-0.3-0.02c-2.2,0-3.95,0.67-5.25,1.99
//                     c-1.53,1.55-2.24,3.84-2.2,6.96c0.05,2.47,0.05,5.02,0.02,7.47v5.62h0.02v0.95c-0.02,2.33-0.05,4.76,0.05,7.16
//                     c0.67,15.81,13.73,28.17,29.75,28.17c4.74,0,9.27-1.13,13.52-3.35c2.08-1.11,8.41-4.44,5.11-11.12
//                     C224.59,462.85,221.98,462.08,220.11,462.08z"/>
//                 <path d="M447.44,404.04c-0.56-0.14-1.12-0.2-1.68-0.18c-2.22,0.05-4.44,1.14-6.63,1.81
//                     c-4.65,1.44-10.07,0.9-13.83-2.18c-3.13-2.57-4.8-6.58-5.3-10.6c-0.29-2.29-0.27-4.73-1.46-6.71c-1.17-1.93-3.41-3.1-5.66-3.21
//                     c-1.81-0.08-3.61,0.47-5.15,1.42c-0.38,0.23-0.75,0.48-1.09,0.77c-0.29,0.24-0.48,0.7-0.65,1.04c-0.4,0.77-0.71,1.59-0.93,2.44
//                     c-0.44,1.72-0.54,3.51-0.43,5.27c0.04,0.68,0.12,1.36,0.22,2.04c0.97,6.45,4.08,12.56,8.68,17.18c4.6,4.63,10.66,7.77,17.09,8.92
//                     c1.36,0.24,2.75,0.4,4.12,0.25c0.96-0.11,1.9-0.37,2.84-0.63c1.94-0.54,3.89-1.08,5.83-1.62c1.83-0.51,3.67-1.02,5.32-1.95
//                     c1.65-0.93,3.11-2.33,3.73-4.13c0.54-1.57,0.38-3.32-0.15-4.89C451.53,406.77,449.8,404.64,447.44,404.04z"/>
//                 <path d="M153.01,332.44h-0.07c-4.78,0-7.65,3.14-7.67,8.39c-0.05,9.18-0.05,18.84,0,30.39
//                     c0.02,5.36,2.77,8.48,7.56,8.53h0.14c4.69,0,7.53-3.12,7.58-8.39c0.05-3.54,0.05-7.1,0.02-10.63v-9.08
//                     c0.02-3.56,0.02-7.12-0.02-10.68C160.48,333.3,155.25,332.44,153.01,332.44z"/>
//                 <path d="M111.69,315.61c0.79,1.52,2.01,2.79,3.43,3.74c0.81,0.54,1.72,1,2.7,1.02c1.06,0.03,2.07-0.46,3-0.96
//                     c1.32-0.71,2.65-1.51,3.51-2.74c0.9-1.3,1.18-2.92,1.33-4.49c0.27-2.84,0.21-5.7,0.21-8.55c0-2.36,0.02-4.79-0.85-6.98
//                     c-0.8-2.01-2.38-3.73-4.39-4.54c-2.03-0.82-4.58-0.68-6.28,0.74c-1.83,1.53-2.95,3.38-3.44,5.73c-0.48,2.28-0.39,4.64-0.43,6.97
//                     c-0.05,2.83-0.26,5.79,0.56,8.44C111.21,314.55,111.42,315.09,111.69,315.61z"/>
//                 <g>
//                     <path d="M244.57,72.74c-8.33-2.49-17.13,2.25-19.62,10.58l-29.95,100.01c-2.49,8.33,2.25,17.13,10.58,19.62
//                         c8.33,2.49,17.13-2.25,19.62-10.58l29.95-100.01C257.64,84.03,252.89,75.23,244.57,72.74z M213.7,188.93
//                         c-0.6,1.99-2.7,3.12-4.69,2.53s-3.12-2.7-2.53-4.69l29.95-100.01c0.6-1.99,2.7-3.12,4.69-2.53c1.99,0.6,3.12,2.7,2.53,4.69
//                         L213.7,188.93z"/>
//                     <path d="M303.62,90.42c-8.33-2.49-17.13,2.25-19.62,10.58l-29.95,100.01c-2.49,8.33,2.25,17.13,10.58,19.62
//                         c8.33,2.49,17.13-2.25,19.62-10.58l29.95-100.01C316.69,101.72,311.95,92.92,303.62,90.42z M272.75,206.62
//                         c-0.6,1.99-2.7,3.12-4.69,2.53c-1.99-0.6-3.12-2.7-2.53-4.69l29.95-100.01c0.6-1.99,2.7-3.12,4.69-2.53s3.12,2.7,2.53,4.69
//                         L272.75,206.62z"/>
//                     <path d="M362.67,108.11c-8.33-2.49-17.13,2.25-19.62,10.58L313.09,218.7c-2.49,8.33,2.25,17.13,10.58,19.62
//                         s17.13-2.25,19.62-10.58l29.95-100.01C375.74,119.4,371,110.6,362.67,108.11z M331.8,224.3c-0.6,1.99-2.7,3.12-4.69,2.53
//                         c-1.99-0.6-3.12-2.7-2.53-4.69l29.95-100.01c0.6-1.99,2.7-3.12,4.69-2.53c1.99,0.6,3.12,2.7,2.53,4.69L331.8,224.3z"/>
//                     <path d="M421.72,125.79c-8.33-2.49-17.13,2.25-19.62,10.58l-29.95,100.01c-2.49,8.33,2.25,17.13,10.58,19.62
//                         c8.33,2.49,17.13-2.25,19.62-10.58l29.95-100.01C434.79,137.09,430.05,128.29,421.72,125.79z M390.85,241.98
//                         c-0.6,1.99-2.7,3.12-4.69,2.53s-3.12-2.7-2.53-4.69l29.95-100.01c0.6-1.99,2.7-3.12,4.69-2.53c1.99,0.6,3.12,2.7,2.53,4.69
//                         L390.85,241.98z"/>
//                     <path d="M185.52,55.05c-8.33-2.49-17.13,2.25-19.62,10.58l-29.95,100.01c-2.49,8.33,2.25,17.13,10.58,19.62
//                         c8.33,2.49,17.13-2.25,19.62-10.58L196.1,74.68C198.59,66.35,193.84,57.55,185.52,55.05z M154.65,171.25
//                         c-0.6,1.99-2.7,3.12-4.69,2.53s-3.12-2.7-2.53-4.69l29.95-100.01c0.6-1.99,2.7-3.12,4.69-2.53c1.99,0.6,3.12,2.7,2.53,4.69
//                         L154.65,171.25z"/>
//                 </g>
//             </g>
//         </svg>

//                         <h4>Your cart is empty</h4>
//                     </div>
//                 </div>

//                 <div class="sidebar-cart-bottom" v-if="cartIsNotEmpty">
//                     <h5 class="sidebar-cart-subtotal">
//                         Subtotal
//                         <span v-html="cart.subTotal.inCurrentCurrency.formatted"></span>
//                     </h5>

//                     <div class="sidebar-cart-actions">
//                         <a href="cart.html" class="btn btn-default btn-view-cart">
//                             VIEW CART
//                         </a> -->

//                     <!-- <a href="https://www.ajantabottle.com/checkout" class="btn btn-primary btn-checkout">
//                             CHECKOUT
//                         </a> -->
<!-- //                     </div>
//                 </div>
//     </aside>
// </sidebar-cart>
// <cookie-bar inline-template>
//     <div class="cookie-bar-wrap" :class="{ show: show }">
//         <div class="container d-flex justify-content-center">
//             <div class="col-xl-10 col-lg-12">
//                 <div class="row justify-content-center">
//                     <div class="cookie-bar">
//                         <div class="cookie-bar-text">
//                             The website uses cookies to ensure you get the best experience on our website.
//                         </div>

//                         <div class="cookie-bar-action">
//                             <button class="btn btn-primary btn-accept" @click="accept">
//                                 GOT IT!
//                             </button>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     </div>
// </cookie-bar>
// </div> -->