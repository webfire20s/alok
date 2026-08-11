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
    /* Floating WhatsApp Button */
    .whatsapp-float {
        position: fixed;
        right: 25px;
        bottom: 25px;
        width: 65px;
        height: 65px;
        color: #fff;
        background: #25D366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 10px 30px rgba(37, 211, 102, .35);
        z-index: 99999;
        transition: transform .3s ease, box-shadow .3s ease;
        animation: whatsappPulse 2s infinite;
    }

    .whatsapp-float:hover {
        transform: translateY(-5px) scale(1.08);
        box-shadow: 0 15px 40px rgba(37, 211, 102, .5);
    }

    @keyframes whatsappPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, .55);
        }
        70% {
            box-shadow: 0 0 0 18px rgba(37, 211, 102, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
        }
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .whatsapp-float {
            width: 58px;
            height: 58px;
            right: 15px;
            bottom: 15px;
        }

        .whatsapp-float svg {
            width: 28px;
            height: 28px;
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
                        <div style="color: #dddddd;">Email: alokglassworksfzd@gmail.com</div>
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
                    <li><a href="blogs" target="_blank">Blog</a></li>
                    <li><a href="video.php" target="_blank">Videos</a></li>
                    <li><a href="catalog.php" target="_blank">Catalogs</a></li> 
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
<!-- Floating WhatsApp Button -->
<a href="https://wa.me/917037677289"
   class="whatsapp-float"
   target="_blank"
   aria-label="Chat on WhatsApp">

    <svg xmlns="http://www.w3.org/2000/svg"
         width="32"
         height="32"
         viewBox="0 0 32 32"
         fill="white">  

        <!-- Centered Inner Phone Handle -->
        <path d="M20.96 17.71c-.29-.15-1.72-.85-1.99-.95-.27-.1-.47-.15-.67.15-.2.29-.77.95-.94 1.14-.17.2-.35.22-.64.07-.29-.15-1.23-.45-2.34-1.43-.86-.77-1.44-1.71-1.61-2-.17-.29-.02-.44.13-.59.13-.13.29-.35.44-.52.15-.17.2-.29.3-.49.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.29-1.03 1.01-1.03 2.46 0 1.45 1.05 2.86 1.2 3.05.15.2 2.07 3.17 5.02 4.45.7.3 1.25.48 1.67.62.7.22 1.34.19 1.84.12.56-.08 1.72-.7 1.96-1.37.24-.67.24-1.25.17-1.37-.07-.12-.27-.2-.56-.35z"/>
        
        <!-- Outer Speech Bubble Chassis -->
        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 3C8.82 3 3 8.82 3 16c0 2.54.75 5.01 2.16 7.12L3.5 28.5l5.52-1.62A12.92 12.92 0 0 0 16 29c7.18 0 13-5.82 13-13S23.18 3 16 3zm0 23.6c-2.06 0-4.08-.56-5.84-1.63l-.42-.25-3.27.96.97-3.19-.28-.44A10.55 10.55 0 0 1 5.4 16C5.4 10.15 10.15 5.4 16 5.4S26.6 10.15 26.6 16 21.85 26.6 16 26.6z"/>
    </svg>

</a>
</body> 
</html>




