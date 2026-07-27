<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/db.php';
/* Optimized query to only fetch required index columns instead of SELECT * */
$navStmt = $pdo->prepare("
SELECT id, name 
    FROM categories
    ORDER BY name ASC
");
$navStmt->execute();
$navCategories = $navStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>Alok Glass Works</title>

    <meta name="title" content="Buy Wholesale Glass Bottles &amp; Jars | Online &amp; Offline Shopping – Alok Glass Works">
    <meta name="description" content="India’s top supplier of glass bottles &amp; jars for perfumes, food &amp; cosmetics. Bulk &amp; custom orders. Worldwide shipping. Order now">

    <!-- Preconnect Optimization hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Asynchronous fonts & icon loading prevents render blocking -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">

    <!-- Main Stylesheets -->
    <link rel="stylesheet" href="assets/themes/storefront/public/css/bootstrap.mine8da.css?v=2.0.3">
    <link rel="stylesheet" href="assets/themes/storefront/public/css/stylee8da.css?v=2.0.3"> 
    
    <!-- Premium Smooth Scroll Integration (Lenis Engine Deferred) -->
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.42/dist/lenis.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Lenis !== 'undefined') {
                const lenis = new Lenis({
                    duration: 1.2,
                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    direction: 'vertical',
                    gestureDirection: 'vertical',
                    smooth: true,
                    mouseMultiplier: 1,
                    smoothTouch: false,
                    touchMultiplier: 2,
                    infinite: false,
                });

                function raf(time) {
                    lenis.raf(time);
                    requestAnimationFrame(raf);
                }
                requestAnimationFrame(raf);
            }
        });
    </script>

    <style>
        /* Modern Architectural Custom Scrollbar */
        html {
            scroll-behavior: initial; /* Required override for Lenis Engine */
        }
        
        /* Modern CSS Variables for System-wide Consistency */
        :root {
            --primary-accent: #c8232c;
            --primary-accent-rgb: 200, 35, 44;
            --dark-industrial: #11141a;
            --slate-gray: #1f242e;
            --light-bg: #f8f9fa;
            --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            --transition-bounce: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #ffffff;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--dark-industrial);
            border: 2px solid #ffffff;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-accent);
        }

        /* Forces premium structural fonts and removes standard serif fallbacks */
        body, html, p, a, li, span, label, input, button, select, textarea {
            font-family: 'Montserrat', sans-serif !important;
            letter-spacing: -0.01em;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700 !important;
            color: var(--dark-industrial) !important;
            letter-spacing: -0.02em;
        }

        /* Refined primary elements & anchors transition */
        a {
            transition: var(--transition-smooth);
        }

        /* Refined primary button layout to match corporate branding with hover effects */
        .btn-primary, .btn-main, .custom-submit-btn {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.8px !important;
            background-color: var(--primary-accent) !important;
            border-color: var(--primary-accent) !important;
            color: #ffffff !important;
            border-radius: 5px !important;
            padding: 12px 28px !important;
            font-size: 13px !important;
            position: relative;
            overflow: hidden;
            z-index: 1;
            box-shadow: 0 4px 12px rgba(200, 35, 44, 0.15) !important;
            transition: var(--transition-bounce) !important;
        }

        .btn-primary::before, .btn-main::before, .custom-submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--dark-industrial);
            z-index: -1;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-primary:hover, .btn-main:hover, .custom-submit-btn:hover {
            border-color: var(--dark-industrial) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(17, 20, 26, 0.25) !important;
            color: #ffffff !important;
        }

        .btn-primary:hover::before, .btn-main:hover::before, .custom-submit-btn:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Secondary/Outline Button styling with brand integration */
        .btn-outline-dark, .btn-secondary {
            border: 2px solid var(--dark-industrial) !important;
            background: transparent !important;
            color: var(--dark-industrial) !important;
            font-weight: 600 !important;
            border-radius: 5px !important;
            transition: var(--transition-smooth) !important;
        }

        .btn-outline-dark:hover, .btn-secondary:hover {
            background: var(--primary-accent) !important;
            border-color: var(--primary-accent) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        /* Modernized Interactive Form Inputs styling */
        input[type="text"], input[type="email"], input[type="tel"], input[type="password"], select, textarea {
            border: 1.5px solid #e1e5eb !important;
            border-radius: 6px !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            background-color: #ffffff !important;
            color: var(--dark-industrial) !important;
            transition: var(--transition-smooth) !important;
            box-shadow: none !important;
        }

        input:focus, select:focus, textarea:focus {
            outline: none !important;
            border-color: var(--primary-accent) !important;
            box-shadow: 0 0 0 4px rgba(200, 35, 44, 0.08) !important;
            background-color: #ffffff !important;
        }

        /* --- GLOBAL NATIVE VIEWPORT SCROLL REVEALS --- */
        @supports (animation-timeline: view()) {
            .reveal-on-scroll {
                animation: fadeUpReveal linear both;
                animation-timeline: view();
                animation-range: entry 10% cover 30%;
            }
            @keyframes fadeUpReveal {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
    </style>

    <style>
        /* Interactive Brand Accents & Mobile Toggle Animations */
        .announcement-text {
            animation: textPulse 3s infinite ease-in-out;
            display: inline-block;
        }

        @keyframes textPulse {
            0%, 100% { opacity: 0.9; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.015); letter-spacing: 0.04em; }
        }

        /* Hover animation for structural corporate logos */
        .header-logo-link {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
        }
        .header-logo-link:hover {
            transform: scale(1.03) translateY(-1px);
            opacity: 1 !important;
        }

        /* Smooth animated line for divider bar */
        .header-logo-divider {
            height: 50px; 
            width: 1px; 
            background: linear-gradient(180deg, rgba(226,228,232,0) 0%, #e2e4e8 50%, rgba(226,228,232,0) 100%);
            position: relative;
            overflow: hidden;
        }
        .header-logo-divider::after {
            content: '';
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, transparent, var(--primary-accent, #c8232c), transparent);
            animation: dividerGlow 3.5s infinite linear;
        }
        @keyframes dividerGlow {
            0% { top: -100%; }
            100% { top: 100%; }
        }

        /* Sophisticated dropdown slide transitions */
        .navbar-nav .dropdown-menu {
            display: block !important;
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px) scale(0.98);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border-top: 3.5px solid var(--primary-accent, #c8232c) !important;
            box-shadow: 0 15px 35px rgba(17, 20, 26, 0.08) !important;
        }

        .navbar-nav .dropdown:hover .dropdown-menu,
        .navbar-nav .dropdown.show .dropdown-menu {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) scale(1) !important;
        }

        /* Micro-interactions for dropdown links */
        .navbar-nav .dropdown-item {
            position: relative;
            padding-left: 15px !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .navbar-nav .dropdown-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleX(0);
            width: 4px;
            height: 60%;
            background-color: var(--primary-accent, #c8232c);
            transform-origin: left;
            transition: transform 0.25s ease;
            border-radius: 0 4px 4px 0;
        }
        .navbar-nav .dropdown-item:hover {
            color: var(--primary-accent, #c8232c) !important;
            padding-left: 22px !important;
            background-color: rgba(200, 35, 44, 0.02) !important;
        }
        .navbar-nav .dropdown-item:hover::before {
            transform: translateY(-50%) scaleX(1);
        }

        /* Mobile Navbar customization */
        .navbar-toggler {
            transition: transform 0.3s ease;
        }
        .navbar-toggler:active {
            transform: scale(0.92);
        }
        #google_translate_element,
        #google_translate_element_mobile{
            font-size:11px;
        }

        .goog-te-gadget{
            font-family:inherit!important;
            color:transparent!important;
        }

        .goog-te-gadget img{
            display:none!important;
        }

        .goog-te-gadget-simple{
            background:#fff!important;
            border:1px solid #ddd!important;
            border-radius:80px!important;
            padding:3px 6px!important;
            box-shadow:none!important;
        }

        .goog-te-gadget-simple span{
            color:#333!important;
            font-size:10px!important;
        }

        .goog-logo-link{
            display:none!important;
        }

        .goog-te-banner-frame.skiptranslate{
            display:none!important;
        }

        body{
            top:0!important;
        }
    </style>

        <style>/* Critical Path CSS Generated by Pegasaas Accelerator at https://pegasaas.com/ for htt*/
            @font-face{font-family:'Rubik';font-style:normal;font-weight:300;font-display:swap;src:url(https://fonts.gstatic.com/s/rubik/v12/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-WYiFV0Uw.ttf) format('truetype')}@font-face{font-family:'Rubik';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/rubik/v12/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-B4iFV0Uw.ttf) format('truetype')}@font-face{font-family:'Rubik';font-style:normal;font-weight:500;font-display:swap;src:url(https://fonts.gstatic.com/s/rubik/v12/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-NYiFV0Uw.ttf) format('truetype')}:root{--blue:#007bff;--indigo:#6610f2;--purple:#6f42c1;--pink:#e83e8c;--red:#dc3545;--orange:#fd7e14;--yellow:#ffc107;--green:#28a745;--teal:#20c997;--cyan:#17a2b8;--white:#fff;--gray:#6c757d;--gray-dark:#343a40;--primary:#007bff;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--breakpoint-xs:0;--breakpoint-sm:576px;--breakpoint-md:768px;--breakpoint-lg:992px;--breakpoint-xl:1200px;--font-family-sans-serif:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%}aside,footer,header,main,nav{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff}h2,h3,h4{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}strong{font-weight:bolder}a{color:#007bff;text-decoration:none;background-color:transparent}img{vertical-align:middle;border-style:none}svg{overflow:hidden;vertical-align:middle}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button{overflow:visible}button{text-transform:none}[type=button],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h2,h3,h4{margin-bottom:.5rem;font-weight:500;line-height:1.2}h2{font-size:2rem}h3{font-size:1.75rem}h4{font-size:1.5rem}.img-fluid{max-width:100%;height:auto}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.row{display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.no-gutters{margin-right:0;margin-left:0}.no-gutters>[class*=col-]{padding-right:0;padding-left:0}.col,.col-12,.col-3,.col-6,.col-lg-12,.col-lg-2,.col-md-12,.col-md-3,.col-md-4,.col-md-6,.col-md-8,.col-xl-10{position:relative;width:100%;padding-right:15px;padding-left:15px}.col{-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;min-width:0;max-width:100%}.col-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}/*.col-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}*/.col-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}@media (min-width:768px){.col-md-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.col-md-4{-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.col-md-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}.col-md-8{-ms-flex:0 0 66.666667%;flex:0 0 66.666667%;max-width:66.666667%}.col-md-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}}@media (min-width:992px){.col-lg-2{-ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%}.col-lg-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}}@media (min-width:1200px){.col-xl-10{-ms-flex:0 0 83.333333%;flex:0 0 83.333333%;max-width:83.333333%}}.btn{display:inline-block;font-weight:400;color:#212529;text-align:center;vertical-align:middle;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem}@media (prefers-reduced-motion:reduce){}.btn-primary{color:#fff;background-color:#007bff;border-color:#007bff}.collapse:not(.show){display:none}.dropdown{position:relative}.dropdown-toggle{white-space:nowrap}.dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:.25rem}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:center;align-items:center;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar-brand{display:inline-block;padding-top:.3125rem;padding-bottom:.3125rem;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:flex;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-nav .dropdown-menu{position:static;float:none}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-ms-flex-positive:1;flex-grow:1;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:no-repeat center center;background-size:100% 100%}@media (min-width:992px){.navbar-expand-lg{-ms-flex-flow:row nowrap;flex-flow:row nowrap;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg .navbar-collapse{display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.navbar-light .navbar-brand{color:rgba(0,0,0,.9)}.navbar-light .navbar-nav .nav-link{color:rgba(0,0,0,.5)}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280,0,0,0.5%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.5%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")}.carousel{position:relative}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner::after{display:block;clear:both;content:""}.carousel-item{position:relative;display:none;float:left;width:100%;margin-right:-100%;-webkit-backface-visibility:hidden;backface-visibility:hidden}@media (prefers-reduced-motion:reduce){}.carousel-item.active{display:block}.carousel-control-next,.carousel-control-prev{position:absolute;top:0;bottom:0;z-index:1;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;width:15%;color:#fff;text-align:center;opacity:.5}@media (prefers-reduced-motion:reduce){}.carousel-control-prev{left:0}.carousel-control-next{right:0}.carousel-control-next-icon,.carousel-control-prev-icon{display:inline-block;width:20px;height:20px;background:no-repeat 50%/100% 100%}.carousel-control-prev-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3e%3c/svg%3e")}.carousel-control-next-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z'/%3e%3c/svg%3e")}.align-middle{vertical-align:middle!important}.bg-light{background-color:#f8f9fa!important}.bg-dark{background-color:#343a40!important}.bg-white{background-color:#fff!important}.d-block{display:block!important}.d-flex{display:flex!important}.justify-content-center{-ms-flex-pack:center!important;justify-content:center!important}.align-content-center{-ms-flex-line-pack:center!important;align-content:center!important}.align-self-center{-ms-flex-item-align:center!important;align-self:center!important}@media (min-width:768px){.justify-content-md-center{-ms-flex-pack:center!important;justify-content:center!important}}.float-left{float:left!important}.float-right{float:right!important}.position-relative{position:relative!important}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.shadow{box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important}.w-100{width:100%!important}.mb-3{margin-bottom:1rem!important}.mt-5{margin-top:3rem!important}.mb-5{margin-bottom:3rem!important}.p-2{padding:.5rem!important}.pt-2{padding-top:.5rem!important}.pr-2{padding-right:.5rem!important}.pb-2{padding-bottom:.5rem!important}.pl-2{padding-left:.5rem!important}.p-3{padding:1rem!important}.pt-3{padding-top:1rem!important}.pr-3{padding-right:1rem!important}.pb-3{padding-bottom:1rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.p-5{padding:3rem!important}.pt-5{padding-top:3rem!important}.pr-5{padding-right:3rem!important}.pb-5{padding-bottom:3rem!important}.pl-5{padding-left:3rem!important}.m-auto{margin:auto!important}.text-left{text-align:left!important}.text-right{text-align:right!important}.text-center{text-align:center!important}.text-uppercase{text-transform:uppercase!important}.font-weight-bold{font-weight:700!important}.text-white{color:#fff!important}ul{margin-bottom:1rem}ul{margin-top:0}strong{font-weight:bolder}a{color:#007bff;text-decoration:none;background-color:transparent}img{border-style:none}img,svg{vertical-align:middle}svg{overflow:hidden}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button{overflow:visible}button{text-transform:none}[type=button],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}.img-fluid{max-width:100%;height:auto}.no-gutters{margin-right:0;margin-left:0}.no-gutters>[class*=col-]{padding-right:0;padding-left:0}@media (min-width:1200px){.col-xl-10{-webkit-box-flex:0;flex:0 0 55.5555555556%;max-width:55.5555555556%}}.btn{display:inline-block;font-weight:400;color:#212529;text-align:center;vertical-align:middle;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem}@media (prefers-reduced-motion:reduce){}.btn-primary{background-color:#007bff;border-color:#007bff}.collapse:not(.show){display:none}.dropdown{position:relative}.dropdown-toggle{white-space:nowrap}.dropdown-toggle:after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:.25rem}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;padding:.5rem 1rem}.carousel{position:relative}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner:after{display:block;clear:both;content:""}.carousel-item{position:relative;display:none;float:left;width:100%;margin-right:-100%;-webkit-backface-visibility:hidden;backface-visibility:hidden}@media (prefers-reduced-motion:reduce){}.carousel-item.active{display:block}.carousel-control-next,.carousel-control-prev{position:absolute;top:0;bottom:0;z-index:1;display:flex;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;width:15%;color:#fff;text-align:center;opacity:.5}@media (prefers-reduced-motion:reduce){}.carousel-control-prev{left:0}.carousel-control-next{right:0}.carousel-control-next-icon,.carousel-control-prev-icon{display:inline-block;width:20px;height:20px;background:no-repeat 50%/100% 100%}.carousel-control-prev-icon{background-image:url("data:image/svg+xmlPEGASAAS_URL_SEMICOLONcharset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3E%3C/svg%3E")}.carousel-control-next-icon{background-image:url("data:image/svg+xmlPEGASAAS_URL_SEMICOLONcharset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8'%3E%3Cpath d='M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z'/%3E%3C/svg%3E")}.align-middle{vertical-align:middle!important}.bg-light{background-color:#f8f9fa!important}.bg-dark{background-color:#343a40!important}.bg-white{background-color:#fff!important}.d-block{display:block!important}.d-flex{display:flex!important}.border-review{border:1px solid #dee2e6!important;width:80%;margin:0 auto;float:inherit;margin-left:10% !important}.justify-content-center{-webkit-box-pack:center!important;justify-content:center!important}.align-content-center{align-content:center!important}.align-self-center{align-self:center!important}@media (min-width:768px){.justify-content-md-center{-webkit-box-pack:center!important;justify-content:center!important}}.float-left{float:left!important}.float-right{float:right!important}.position-relative{position:relative!important}.sr-only{white-space:nowrap}.shadow{box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important}.w-100{width:100%!important}.mb-3{margin-bottom:1rem!important}.mt-5{margin-top:3rem!important}.mb-5{margin-bottom:3rem!important}.p-2{padding:.5rem!important}.pt-2{padding-top:.5rem!important}.pr-2{padding-right:.5rem!important}.pb-2{padding-bottom:.5rem!important}.pl-2{padding-left:.5rem!important}.p-3{padding:1rem!important}.pt-3{padding-top:1rem!important}.pr-3{padding-right:1rem!important}.pb-3{padding-bottom:1rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.p-5{padding:3rem!important}.pt-5{padding-top:3rem!important}.pr-5{padding-right:3rem!important}.pb-5{padding-bottom:3rem!important}.pl-5{padding-left:3rem!important}.m-auto{margin:auto!important}.text-left{text-align:left!important}.text-right{text-align:right!important}.text-center{text-align:center!important}.text-uppercase{text-transform:uppercase!important}.font-weight-bold{font-weight:700!important}.text-white{color:#fff!important}.las{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:inline-block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1}@font-face{font-family:Line Awesome Free;font-style:normal;font-weight:400;font-display:auto;src:url('../assets/assets/themes/storefront/public/fonts/la-regular-400.eot');src:url('../assets/assets/themes/storefront/public/fonts/la-regular-400.eot') format('embedded-opentype'),url('../assets/assets/themes/storefront/public/fonts/la-regular-400.woff2') format('woff2'),url('../assets/assets/themes/storefront/public/fonts/la-regular-400.woff') format('woff'),url('../assets/assets/themes/storefront/public/fonts/la-regular-400.ttf') format('truetype'),url('../assets/assets/themes/storefront/public/fonts/la-regular-400.woff2') format('svg')}@font-face{font-family:Line Awesome Free;font-style:normal;font-weight:900;font-display:auto;src:url('../assets/assets/themes/storefront/public/fonts/la-solid-900.eot');src:url('../assets/assets/themes/storefront/public/fonts/la-solid-900.eot') format('embedded-opentype'),url('../assets/assets/themes/storefront/public/fonts/la-solid-900.woff2') format('woff2'),url('../assets/assets/themes/storefront/public/fonts/la-solid-900.woff') format('woff'),url('../assets/assets/themes/storefront/public/fonts/la-solid-900.ttf') format('truetype'),url('../assets/assets/themes/storefront/public/fonts/la-solid-900.woff2') format('svg')}.las{font-family:Line Awesome Free}.las{font-weight:900}.la-times:before{content:"\F00D"}.sr-only{border:0;clip:rect(0,0,0,0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px}@-webkit-keyframes fadeInUp{0%{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}to{opacity:1;-webkit-transform:translateZ(0);transform:translateZ(0)}}.animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}@media (prefers-reduced-motion:reduce),(print){.animated{-webkit-animation-duration:1ms!important;animation-duration:1ms!important;-webkit-animation-iteration-count:1!important;animation-iteration-count:1!important}}.slick-slider{box-sizing:border-box;-webkit-touch-callout:none;touch-action:pan-y}.slick-list,.slick-slider{position:relative;display:block}.slick-list{overflow:hidden;margin:0;padding:0}.slick-slider .slick-list,.slick-slider .slick-track{-webkit-transform:translateZ(0);transform:translateZ(0)}.slick-track{position:relative;left:0;top:0;display:block;margin-left:auto;margin-right:auto}.slick-track:after,.slick-track:before{content:"";display:table}.slick-track:after{clear:both}.slick-slide{float:left;height:100%;min-height:1px;display:none}.slick-slide img{display:block}.slick-initialized .slick-slide{display:block}.footer-copyright{padding-left:0px}.footer-copyright li{display:inline-block;width:49%;text-align:left}.footer-copyright li:last-child{text-align:right}.wrapper{position:relative;background:#fff}body{direction:ltr;font-size:15px;font-weight:400;font-style:normal;min-width:320px;overflow-x:hidden}body,h2,h3,h4{color:#191919}h2,h3,h4,li,p,ul{margin:0;padding:0}a:visited,button:visited,div:visited{outline:0}strong{font-weight:500}.slick-list .slick-track{float:left}.btn{font-family:Rubik,Arial,Helvetica,sans-serif;font-size:15px;line-height:26px;position:relative;border:none;padding:7px 24px;border-radius:2px}.btn-primary{font-weight:500;color:#fff;background:#0068e1;background:var(--color-primary)}::-webkit-input-placeholder{color:#a6a6a6!important;opacity:1}::-moz-placeholder{color:#a6a6a6!important;opacity:1}:-ms-input-placeholder{opacity:1}::-ms-input-placeholder{opacity:1}::placeholder{color:#a6a6a6!important;opacity:1}:-ms-input-placeholder{color:#a6a6a6!important}::-ms-input-placeholder{color:#a6a6a6!important}@keyframes  fadeInUp{0%{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}to{opacity:1;-webkit-transform:none;transform:none}}.fadeInUp{-webkit-animation-name:fadeInUp;animation-name:fadeInUp}.sidebar-cart-top{display:flex;padding:15px 30px;-webkit-box-align:center;align-items:center;-webkit-box-pack:justify;justify-content:space-between;background:#0068e1;background:var(--color-primary)}.sidebar-cart-top .title{font-weight:400;color:#fff}.sidebar-cart-top .sidebar-cart-close{display:flex;opacity:.8}.sidebar-cart-top .sidebar-cart-close>i{font-size:18px;color:#fff}.sidebar-cart-middle{position:absolute;left:0;right:0;top:70px;bottom:155px;padding:0 30px}.sidebar-cart-middle.empty{bottom:0;overflow:visible}.sidebar-cart-items-wrap{padding:5px 0;background:#fff}.sidebar-cart-wrap{position:fixed;top:0;right:-200px;bottom:0;height:100%;width:400px;background:#fff;box-shadow:2.5px 4.33px 40px 5px rgba(12,31,46,.1);opacity:0;visibility:hidden;z-index:200}.sidebar-cart-wrap .empty-message{position:absolute;left:0;top:0;height:100%;width:100%;display:flex;padding:40px 0;-webkit-box-pack:center;justify-content:center;-webkit-box-align:center;align-items:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;flex-direction:column;text-align:center}.sidebar-cart-wrap .empty-message svg{height:100px;width:100px;margin-bottom:22px}.sidebar-cart-wrap .empty-message svg g{fill:#0068e1;fill:var(--color-primary)}@media  screen and (max-width:420px){.sidebar-cart-wrap{right:-180px;width:360px}}@media  screen and (max-width:380px){.sidebar-cart-wrap{right:-165px;width:330px}}@media  screen and (max-width:350px){.sidebar-cart-wrap{right:-150px;width:300px}}.cookie-bar-wrap{position:fixed;left:0;right:0;bottom:-200px;background:#3b4045;box-shadow:0 -1px 3px rgba(0,0,0,.1);opacity:0;visibility:hidden;-webkit-transform:translateY(0);transform:translateY(0);z-index:50}.cookie-bar-wrap.show{opacity:1;visibility:visible;-webkit-transform:translateY(-200px);transform:translateY(-200px)}.cookie-bar{display:flex;flex-wrap:nowrap;-webkit-box-pack:center;justify-content:center;-webkit-box-align:center;align-items:center;padding:15px 0}.cookie-bar .cookie-bar-text{font-size:14px;margin-right:100px;color:#f9f9f9}.cookie-bar .cookie-bar-action{display:flex;white-space:nowrap}.cookie-bar .cookie-bar-action .btn-accept{padding:5px 24px}@media  screen and (max-width:991px){.cookie-bar{-webkit-box-orient:vertical;-webkit-box-direction:normal;flex-direction:column;padding:16px 0 20px}.cookie-bar .cookie-bar-text{margin:0 0 14px;text-align:center}}.home-slider{border-radius:2px;overflow:hidden}.home-slider.slick-initialized .slide .slide-content .caption{display:block}.home-slider .slide{position:relative;overflow:hidden;border-radius:2px}.home-slider .slide .slider-image{width:100%;height:auto;opacity:1!important;-webkit-animation-duration:3s;animation-duration:3s}.home-slider .slide-content{position:absolute;top:0;display:flex;height:100%;width:100%;-webkit-box-align:center;align-items:center}.home-slider .slide-content.align-left{left:0;-webkit-box-pack:start;justify-content:flex-start}.home-slider .slide-content.align-left .captions{margin-left:100px;text-align:left}.home-slider .slide-content.align-left .captions .caption-2{margin-right:90px}.home-slider .slide-content .captions{width:400px}.home-slider .slide-content .caption{display:none}.home-slider .slide-content .caption-1{font-size:48px;font-weight:300;line-height:48px;color:#191919}.home-slider .slide-content .caption-2{font-size:16px;line-height:26px;color:#6e6e6e;margin-top:16px}@media  screen and (max-width:767px){.home-slider .slide-content.align-left .captions{margin-left:80px}.home-slider .slide-content.align-left .captions .caption-2{margin-right:60px}.home-slider .slide-content .captions{width:550px}.home-slider .slide-content .caption-1{font-size:38px;line-height:38px}.home-slider .slide-content .caption-2{font-size:15px;line-height:25px;margin-top:13px}}@media  screen and (max-width:576px){.home-slider .slide-content.align-left .captions{margin:0 50px 0 40px}.home-slider .slide-content.align-left .captions .caption-2{margin-right:0}.home-slider .slide-content .caption-1{font-size:28px;line-height:28px}.home-slider .slide-content .caption-2{font-size:14px;line-height:24px;margin-top:10px}}@media  screen and (max-width:450px){.home-slider .slide-content.align-left .captions{margin:0 35px}}.zoomInImage{-webkit-animation-name:zoomInImage;animation-name:zoomInImage}@-webkit-keyframes zoomInImage{0%{-webkit-transform:scaleX(1);transform:scaleX(1)}to{-webkit-transform:scale3d(1.05,1.05,1.05);transform:scale3d(1.05,1.05,1.05)}}@keyframes  zoomInImage{0%{-webkit-transform:scaleX(1);transform:scaleX(1)}to{-webkit-transform:scale3d(1.05,1.05,1.05);transform:scale3d(1.05,1.05,1.05)}}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFUZ0bbck.woff2) format('woff2');unicode-range:U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFWZ0bbck.woff2) format('woff2');unicode-range:U+1F00-1FFF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFVp0bbck.woff2) format('woff2');unicode-range:U+0370-03FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFWp0bbck.woff2) format('woff2');unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+1EA0-1EF9,U+20AB}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFW50bbck.woff2) format('woff2');unicode-range:U+0100-024F,U+0259,U+1E00-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFVZ0b.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UNirkOX-hpOqc.woff2) format('woff2');unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UNirkOVuhpOqc.woff2) format('woff2');unicode-range:U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UNirkOXuhpOqc.woff2) format('woff2');unicode-range:U+1F00-1FFF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UNirkOUehpOqc.woff2) format('woff2');unicode-range:U+0370-03FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UNirkOXehpOqc.woff2) format('woff2');unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+1EA0-1EF9,U+20AB}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UNirkOXOhpOqc.woff2) format('woff2');unicode-range:U+0100-024F,U+0259,U+1E00-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UNirkOUuhp.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UN7rgOX-hpOqc.woff2) format('woff2');unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UN7rgOVuhpOqc.woff2) format('woff2');unicode-range:U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UN7rgOXuhpOqc.woff2) format('woff2');unicode-range:U+1F00-1FFF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UN7rgOUehpOqc.woff2) format('woff2');unicode-range:U+0370-03FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UN7rgOXehpOqc.woff2) format('woff2');unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+1EA0-1EF9,U+20AB}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UN7rgOXOhpOqc.woff2) format('woff2');unicode-range:U+0100-024F,U+0259,U+1E00-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/opensans/v18/mem5YaGs126MiZpBA-UN7rgOUuhp.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}body{font-family:'Open Sans',sans-serif;font-weight:400;font-size:14px;color:#606060}a{color:#353535}header{padding:10px 0}header ul{margin:0;padding:0}header ul li{display:inline;font-weight:700;font-size:15px;line-height:22px}header ul li.sign-in{background:url('../assets/assets/themes/storefront/public/images/sign-in-icon.png') no-repeat left;padding:2px 0 2px 25px;margin:0 30px}header ul li.cart{background:url('../assets/assets/themes/storefront/public/images/cart-icon.png') no-repeat left;padding:2px 0 2px 35px;position:relative}.bg-dark{background:#232f3e !important;font-weight:600;padding:0}.navbar-dark .navbar-nav .nav-link{color:#fff}.navbar-dark li{padding:8px 20px;border-right:1px solid #464f5a}.banner-icons{font-size:15px;color:#5f5f5f}.banner-icons img{width:42px}.banner-icons span{font-weight:700;color:#313131;text-align:left;display:block;padding-left:50px}.banner-icons span label{font-size:16px;font-weight:400;color:#777}.head-org-bold{color:#f25c29;font-weight:700;font-size:24px;padding-bottom:10px;letter-spacing:0.5px}.product-name{font-size:16px;font-weight:600}.latest-image-box{background:#fff;border:1px solid #f1ebe2;border-radius:5px;box-shadow:0px 3px 9.2px 0.8px rgba(35,31,32,0.08);padding:9px;height:100%}.latest-image-box div{font-weight:600;font-size:16px;padding:10px 0 5px 10px}.latest-image-box div a{color:#f25c29}.google-company-details ul{margin:0;padding:0}.google-company-details ul li{list-style:none;display:inline;padding-right:2px}.google-reviews ul{margin:0;padding:0}.google-reviews ul li{list-style:none;display:inline;padding-right:2px}footer .contact-bg{background:#f9f9f9}footer h4{background:url('../assets/assets/themes/storefront/public/images/org-footer-title.gif') no-repeat left bottom;text-transform:uppercase;font-size:16px;font-weight:600;color:#353535;padding-bottom:15px;margin-bottom:15px}footer ul{margin:0;padding:0}footer ul li{color:#606060;list-style:none;padding-bottom:10px;background:url('../assets/assets/themes/storefront/public/images/bull.png') no-repeat 0 8px;padding-left:24px;font-size:15px}footer ul li.pin{background:url('../assets/assets/themes/storefront/public/images/pin-icon.png') no-repeat 0 5px;padding:0 0 10px 30px}footer ul li.email{background:url('../assets/assets/themes/storefront/public/images/email-icon.png') no-repeat 0 5px;padding:0 0 10px 30px}footer ul li.phone{background:url('../assets/assets/themes/storefront/public/images/phone-icon.png') no-repeat 0 5px;padding:0 0 10px 30px}footer ul li.landline{background:url('../assets/assets/themes/storefront/public/images/landline-icon.png') no-repeat 0 5px;padding:0 0 10px 30px}footer ul li a{color:#606060}h2{color:#222222;font-weight:700}h2 img{vertical-align:top}.btn-org{background:#f25c29;color:#fff;font-size:14px;padding:6px 30px;border-radius:5px}.btn-org-1{background:#f25c29;color:#fff;font-size:14px;padding:6px 20px;border-radius:5px}.float-red-btn{position:absolute;width:50%;margin:0 auto;background:#f25c29;text-align:center;font-size:14px;color:#fff;left:26%;bottom:18%;display:none}div.show-buy-now-btn{position:relative}.lt-gray-bg{background:#f6f6f6}.lt-org-bg{background:#e4730d}.org-bg{background:#f25c29}.dk-gray-bg{background:#2c2d2d}.lt-blue-bg{background:#f6f9ff}.txt-black{color:#000}.txt-org{color:#f25c29}.txt-gray{color:#777777}.txt-333{color:#333333}.fs12{font-size:12px}.fs18{font-size:18px}.fs32{font-size:32px}.sb{font-weight:600}.mb0{margin-bottom:0}.pt-40px{padding-top:40px}.org-brd-btm{background:url('../assets/assets/themes/storefront/public/images/org-brd-btm.gif') no-repeat bottom center;padding-bottom:10px}.org-brd-left{background:url('../assets/assets/themes/storefront/public/images/org-brd-btm.gif') no-repeat bottom left;padding-bottom:10px}.gray-brd-right-bottom{border-right:3px solid #f6f6f6;border-bottom:3px solid #f6f6f6}.shadow{box-shadow:0px 3px 14px 2px rgba(35,31,32,0.08)}.shadow-post{box-shadow:0px 3px 38.7px 4.3px rgba(35,31,32,0.16)}.bor-radius-25{border-radius:25px}.bor-rad-lt-25{border-top-left-radius:25px}.bor-rad-rt-25{border-top-right-radius:25px}.w50p{width:50%}.mh110{min-height:110px}.link-block{display:block}.only-desktop{display:block}.only-mobile{display:none}@media  only screen and (max-width:768px){.txtm-center{text-align:center !important}.ptm-0{padding-top:0 !important}.pbm-0{padding-bottom:0 !important}.ptm-20px{padding-top:20px}.pbm-20px{padding-bottom:20px}.bg-dark{padding:8px}.navbar-dark li{padding:0;border:none}.pl-5{padding-left:0 !important}h2{font-size:24px}h2 img{height:24px}.col{flex-basis:unset}.latest-image-box div{font-size:12px}.w50p img{height:65px}.w50p h3{font-size:20px}.mh110{min-height:82px}.pt-40px{padding-top:30px}.m-pl-5{padding-left:3rem!important}.product-name{font-size:14px}.m-pt-15{padding-top:15px}.m-pl-5{padding-left:3rem!important}.only-desktop{display:none}.only-mobile{display:block}.float-red-btn{width:80%;font-size:12px;left:10%;bottom:20%}.m-ml-12px{margin-left:12px}h3{font-size:1.2rem}}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}
        </style>

        <link rel="shortcut icon" href="publics/storage/media/SKOJbrQ5uV29DZIphnyl4crnB6WtDxrwUscNVZNE.png" type="image/x-icon"> 
        
        <script src="../cdn-in.pagesense.io/js/ajanta554/cb001e9408d448dd933e196a37e4a85b.js"></script>
        <script type="text/javascript">
        </script>
        
</head>

    <body
    class="page-template ltr"
    data-theme-color="#11141a"
    style="--color-primary: #11141a;
            --color-primary-hover: #2c323e;
            --color-primary-transparent: rgba(17, 20, 26, 0.8);
            --color-primary-transparent-lite: rgba(17, 20, 26, 0.15);"
    onload="titleMarquee()"
>
    <div class="wrapper" id="app">
          
    <!-- Header Start -->
    <!-- Enhanced announcement layout with a sophisticated, subtle cream background and high-contrast typography -->
    <div class="head-inform-bar" style="background: linear-gradient(90deg, #fdf8f4 0%, #f7d3b5 50%, #fdf8f4 100%); border-bottom: 1px solid rgba(200, 35, 44, 0.12); padding: 11px 0; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <p class="announcement-text" style="color: #c8232c; font-weight: 700; margin: 0; font-size: 13px; letter-spacing: 0.03em; text-transform: uppercase;">
            The minimum order value is only Rs 15,000/- now!
        </p>
        <div id="google_translate_element"
            style="margin-left:18px; min-width:160px;">
        </div>
    </div>

    <header style="background-color: #ffffff; padding: 12px 0; border-bottom: 1px solid #f1f3f5; box-shadow: 0 4px 20px rgba(0,0,0,0.01);">
        <div class="container">
            <div class="row" style="align-items: center;">
                <div class="col-md-4 txtm-center only-desktop">
                    <div style="display:flex; align-items:center; gap:24px; flex-wrap:wrap;">
                        <a href="index.php" class="header-logo-link" style="display: inline-block;">
                            <img
                                src="assets/themes/storefront/public/images/logo.jpeg?v=2.0.3"
                                alt="Alok Glass"
                                style="
                                    height: 90px;
                                    width: auto;
                                    object-fit: contain;
                                    display: block;
                                "
                            >
                        </a>

                        <!-- Fine divider to separate the structural logos professionally with custom background flow -->
                        <div class="header-logo-divider"></div>

                        <a href="index.php" class="header-logo-link" style="display: inline-block; filter: grayscale(1) contrast(1.15); opacity: 0.8;">
                            <img
                                src="assets/themes/storefront/public/images/40-years-trust2e8da.png?v=2.0.3"
                                alt="40 Years Trust"
                                style="
                                    height: 60px;
                                    width: auto;
                                    object-fit: contain;
                                    display: block;
                                "
                            >
                        </a>
                    </div>
                </div>
                
                <div class="col-12 text-left only-mobile">
                    
                    <!-- Navigation Start -->
                    <nav class="navbar navbar-expand-lg navbar-light" style="padding: 10px 0; background: #ffffff;">
                        
                        <!-- Flex layout container for responsive brand balancing -->
                        <div class="d-flex align-items-center" style="gap: 12px; max-width: 70%;">
                            <a class="navbar-brand header-logo-link" href="index.php" style="margin: 0; padding: 0;">
                                <img src="assets/themes/storefront/public/images/logo.jpeg?v=2.0.3" alt="Alok Glass Works" style="height: 45px; width: auto; object-fit: contain;" />
                            </a>
                            <div style="height: 25px; width: 1px; background-color: #e2e4e8;"></div>
                            <a href="index.php" class="header-logo-link" style="display: inline-block; filter: grayscale(1) contrast(1.1); opacity: 0.85;">
                                <img src="assets/themes/storefront/public/images/40-years-trust2e8da.png?v=2.0.3" alt="40 Years Trust" style="height: 35px; width: auto; object-fit: contain;" />
                            </a>
                            <div id="google_translate_element"
                                style="margin-left:18px; min-width:160px;">
                            </div>
                        </div>

                        <div id="google_translate_element_mobile"
                            style="margin-left:auto; margin-right:12px;">
                        </div>
                        
                        <!-- Fixed Toggler Button: Changed data-toggle and data-target to data-bs-toggle and data-bs-target -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation" style="border: none; background: transparent; padding: 4px 0; outline: none !important;">
                            <span style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 11px; letter-spacing: 0.05em; margin-right: 4px; color: #11141a; vertical-align: middle;">MENU</span>
                            <span class="navbar-toggler-icon" style="width: 20px; height: 20px; vertical-align: middle;"></span>
                        </button>

                        <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
                            <ul class="navbar-nav" style="padding-top: 15px;">

                                <!-- Fixed Dropdown Link: Changed data-toggle to data-bs-toggle -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="dropdown08" href="javascript:void(0);" aria-haspopup="true" aria-expanded="false" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;"> Shop By Industry </a>
                                        
                                    <?php
                                    $navCategories = $pdo->query("
                                        SELECT name, slug
                                        FROM categories
                                        ORDER BY name ASC
                                    ")->fetchAll();
                                    ?>

                                    <div class="dropdown-menu" aria-labelledby="dropdown08" style="border: none; background-color: #f8f9fa; border-radius: 6px; padding: 10px 15px;">
                                        <?php foreach($navCategories as $cat): ?>
                                            <a class="dropdown-item" href="category/<?= urlencode($cat['slug']) ?>" style="font-size: 14px; padding: 10px 0; color: #2c323e; font-weight: 500;">
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            
                                <!-- Fixed Dropdown Link: Changed data-toggle to data-bs-toggle -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="dropdown08_prod" href="javascript:void(0);" aria-haspopup="true" aria-expanded="false" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;"> Shop By Product </a>
                                        
                                    <div class="dropdown-menu" aria-labelledby="dropdown08_prod" style="border: none; background-color: #f8f9fa; border-radius: 6px; padding: 10px 15px;">
                                        <?php foreach($navCategories as $cat): ?>
                                            <a class="dropdown-item" href="category/<?= urlencode($cat['slug']) ?>" style="font-size: 14px; padding: 10px 0; color: #2c323e; font-weight: 500;">
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="decoration-services.php" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;">
                                        Our Associates
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="decoration-services.php" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;">
                                        Decoration Services
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="about.php" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;">
                                        About Us
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="blogs.php" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;">
                                        Blogs and Videos
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="contact.php" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;">
                                        Contact Us
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="track-order.php" style="font-weight: 600; color: #11141a; transition: color 0.25s ease;">
                                        Track Order
                                    </a>
                                </li>

                            </ul> 
                        </div>


                    </nav>
                    <!-- Navigation Ends -->
                    
                </div>
                
                <div class="col-md-4 search-wrap-update">

                    <form
                    method="GET"
                    action="search.php"
                        style="margin: 0;"
                    >

                        <div class="input-group" style="display: flex; align-items: center; border: 1px solid #e2e4e8; border-radius: 4px; overflow: hidden; background-color: #ffffff; transition: border-color 0.2s ease;">

                            <!-- SEARCH INPUT -->
                            <input
                                type="text"
                                name="q"
                                class="form-control"
                                placeholder="Search bottles, jars, caps..."
                                required
                                style="border: none; font-size: 14px; padding: 10px 14px; height: auto; box-shadow: none; background: transparent; flex-grow: 1;"
                            >

                            <!-- SLEEK FIELD DIVIDER -->
                            <div style="width: 1px; height: 24px; background-color: #e2e4e8; flex-shrink: 0;"></div>

                            <!-- CATEGORY FILTER -->
                            <select
                                name="category"
                                class="form-control"
                                style="max-width: 160px; border: none; font-size: 13px; font-weight: 500; color: #c8232c; padding: 10px 12px; height: auto; box-shadow: none; background: transparent; cursor: pointer; -webkit-appearance: none; -moz-appearance: none;"
                            >
                                <option value="">
                                    All Categories
                                </option>

                                <?php foreach($navCategories as $cat): ?>
                                    <option
                                        value="<?= htmlspecialchars($cat['slug']) ?>"
                                        >
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <!-- BUTTON -->
                            <div class="input-group-append" style="margin: 0;">
                                <button
                                    class="btn btn-dark"
                                    type="submit"
                                    style="border: none; border-radius: 0; background-color: #c8232c; color: #ffffff; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; padding: 12px 20px; height: auto; transition: background-color 0.2s ease;"
                                    onmouseover="this.style.backgroundColor='#2c323e'"
                                    onmouseout="this.style.backgroundColor='#c8232c'"
                                >
                                    Search
                                </button>
                            </div>

                        </div>

                    </form>
                    

                </div>

                <div class="col-md-4 text-right txtm-center menu-bar-new" style="display: flex; align-items: center; justify-content: flex-end;">

                    <?php
                    $cartCount = 0;
                    if(!empty($_SESSION['cart'])){
                        foreach($_SESSION['cart'] as $cartItem){
                            $cartCount += $cartItem['quantity'];
                        }
                    }
                    ?>

                    <ul class="list-inline mb-0" style="padding-left: 0; margin: 0; display: flex; align-items: center; gap: 20px; list-style: none;">

                        <?php if(isset($_SESSION['user_id'])): ?>

                            <li class="list-inline-item" style="margin: 0;">
                                <a href="my-account" style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #11141a; text-decoration: none; transition: color 0.2s ease;">
                                    Hello, <?= htmlspecialchars($_SESSION['user_name']) ?>
                                </a>
                            </li>

                            <li class="list-inline-item" style="margin: 0;">
                                <a href="logout.php" style="font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; color: #5a6578; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#11141a'" onmouseout="this.style.color='#5a6578'">
                                    Logout
                                </a>
                            </li>

                        <?php else: ?>

                            <li class="list-inline-item" style="margin: 0;">
                                <a href="login" style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #11141a; text-decoration: none; transition: color 0.2s ease;">
                                    Login
                                </a>
                            </li>

                            <li class="list-inline-item" style="margin: 0;">
                                <a href="register" style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #11141a; text-decoration: none; transition: color 0.2s ease;">
                                    Register
                                </a>
                            </li>

                        <?php endif; ?>

                        <!-- Premium isolated visual break line -->
                        <div style="width: 1px; height: 16px; background-color: #e2e4e8;"></div>

                        <li class="list-inline-item" style="margin: 0;">
                            <a
                                href="cart"
                                class="position-relative"
                                style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #11141a; text-decoration: none; display: flex; align-items: center; gap: 6px;"
                            >
                                <i class="fa-solid fa-bag-shopping" style="font-size: 14px;"></i>
                                <span>Cart</span>

                                <?php if($cartCount > 0): ?>
                                    <span
                                        style="
                                            background: #11141a;
                                            color: #ffffff;
                                            border-radius: 50%;
                                            width: 18px;
                                            height: 18px;
                                            font-size: 10px;
                                            font-weight: 700;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            margin-left: 2px;
                                        "
                                    >
                                        <?= $cartCount ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                    </ul>

                </div>
                

            </div>
            

        </div>

    </header>

<!-- Header Ends -->

<!-- Desktop Navigation Bar -->
    <nav class="navbar navbar-expand-lg only-desktop" style="background-color: var(--dark-industrial); padding: 0; border-bottom: 3.5px solid var(--primary-accent); box-shadow: 0 4px 20px rgba(0,0,0,0.15); z-index: 999;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-md-center ss2" id="navbarsExample08">
                <ul class="navbar-nav" style="gap: 4px; padding: 0; margin: 0; align-items: center; width: 100%; justify-content: space-between;">

                    <!-- Shop By Industry (Dynamic Dropdown) -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            Home
                        </a>
                    </li>

                    <!-- Shop By Product (Dynamic Dropdown) -->
                    <li class="nav-item dropdown" style="position: relative;">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            Shop By Product
                        </a>
                        
                        <div class="dropdown-menu">
                            <?php foreach($navCategories as $cat): ?>
                                <a
                                    class="dropdown-item"
                                    href="category/<?= urlencode($cat['slug']) ?>"
                                    style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 500; color: #2c323e; padding: 12px 24px;"
                                >
                                    <?= htmlspecialchars($cat['name']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>                
                    </li>

                    <!-- Decoration Services -->
                    <li class="nav-item">
                        <a class="nav-link" href="plants.php" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            Our Associates
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="decoration-services.php" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            Decoration Services
                        </a>
                    </li>

                    <!-- Colour Cosmetics Packaging -->
                    <li class="nav-item">
                        <a class="nav-link" href="about.php" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            About Us
                        </a>
                    </li>

                    <!-- Blogs and Videos -->
                    <li class="nav-item">
                        <a class="nav-link" href="resources.php" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            Blogs &amp; Videos
                        </a>
                    </li>

                    <!-- Contact Us -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            Contact Us
                        </a>
                    </li>

                    <!-- Track Order -->
                    <li class="nav-item">
                        <a class="nav-link" href="track-order.php" style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; padding: 20px 22px; display: inline-block;">
                            Track Order
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
<!-- Desktop Navigation Bar Ends -->



<script type="text/javascript">



<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");
    
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};
    
    function scrollFunction() {
      if ((document.body.scrollTop > 1070 || document.documentElement.scrollTop > 1070) && window.screen.width < 767) {
        // mybutton.style.display = "block";
        jQuery("#myBtn").css('display', 'block');
      } else {
        jQuery("#myBtn").css('display', 'none');
      }
    }
    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
      document.body.scrollTop = 500;
      document.documentElement.scrollTop = 500;
    }
        // if (window.screen.width < 767) {
        //     jQuery("#myBtn").css('display', 'none');
        // } else {
        //     jQuery("#myBtn").css('display', 'block');
        // }

    

    
</script>

