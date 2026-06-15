<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Panel</title>

    <link
        rel="stylesheet"
        href="../assets/themes/storefront/public/css/bootstrap.mine8da.css"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        body{
            background: #0f1115; /* Deep, luxury industrial charcoal */
            color: #e2e8f0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.01em;
            overflow-x: hidden;
        }

        .admin-wrapper{
            display: flex;
            min-height: 100vh;
            flex-direction: column; /* Stacked layout by default on mobile devices */
        }

        @media (min-width: 992px) {
            .admin-wrapper {
                flex-direction: row; /* Returns to horizontal side-by-side layout on desktops */
            }
        }

        /* Responsive Mobile Master Bar */
        .mobile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #151922;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        .mobile-logo {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mobile-logo::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 14px;
            background: linear-gradient(180deg, #38bdf8, #0369a1);
            border-radius: 2px;
        }

        /* Native pure CSS sidebar toggle controller state switch mechanics */
        #sidebar-toggle {
            display: none;
        }

        .toggle-btn {
            cursor: pointer;
            padding: 8px;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
            z-index: 1060;
        }

        .toggle-btn span {
            display: block;
            width: 22px;
            height: 2px;
            background: #94a3b8;
            border-radius: 2px;
            transition: transform 0.3s ease, opacity 0.3s ease, background 0.3s ease;
        }

        /* Interactive Mobile Sidebar Overlay Drawer */
        .sidebar {
            width: 260px;
            background: #151922; /* Pure obsidian manufacturing slate */
            color: #94a3b8;
            position: fixed;
            top: 0;
            left: -260px; /* Off-canvas overlay positioning by default for touch screens */
            height: 100vh;
            z-index: 1040;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.4);
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        /* Desktop Mode Transformation Breakpoints */
        @media (min-width: 992px) {
            .mobile-header, .sidebar-backdrop {
                display: none !important;
            }
            .sidebar {
                position: relative;
                left: 0 !important;
                min-height: 100vh;
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }
        }

        /* CSS Architecture State Execution Selection Chains */
        #sidebar-toggle:checked ~ .sidebar {
            left: 0; /* Slides the responsive sidebar into active viewport frame */
        }

        #sidebar-toggle:checked ~ .toggle-btn span:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
            background: #ffffff;
        }

        #sidebar-toggle:checked ~ .toggle-btn span:nth-child(2) {
            opacity: 0;
        }

        #sidebar-toggle:checked ~ .toggle-btn span:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
            background: #ffffff;
        }

        /* Background blur veil underlay backdrop for running mobile overlay drawers */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 17, 21, 0.7);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1030;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #sidebar-toggle:checked ~ .sidebar-backdrop {
            display: block;
            opacity: 1;
        }

        .sidebar-title {
            padding: 30px 24px;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-title::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 18px;
            background: linear-gradient(180deg, #38bdf8, #0369a1);
            border-radius: 2px;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.5);
        }

        .sidebar a {
            color: #94a3b8;
            display: block;
            padding: 16px 24px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.02);
            transition: all 0.2s ease;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.03);
            color: #ffffff;
            text-decoration: none;
            padding-left: 28px; /* Smooth interactive slide */
            border-left: 3px solid #38bdf8;
        }

        .admin-content {
            flex: 1;
            padding: 20px 15px; /* Compact structural breathing gutters on small displays */
            background: radial-gradient(circle at top right, rgba(30, 41, 59, 0.3), transparent 45%);
            width: 100%;
        }

        @media (min-width: 576px) {
            .admin-content {
                padding: 30px;
            }
        }

        @media (min-width: 992px) {
            .admin-content {
                padding: 40px;
                width: calc(100% - 260px);
            }
        }

        /* Glassmorphic Industrial Cards with adaptive scaling padding */
        .card-box {
            background: rgba(21, 25, 34, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            color: #e2e8f0;
        }

        @media (min-width: 576px) {
            .card-box {
                padding: 30px;
            }
        }

        /* Global contextual overrides for internal pages to match this theme automatically */
        h1, h2, h3, h4, h5, h6 {
            color: #ffffff;
            font-weight: 600;
        }

        /* Responsive horizontal data sheet handling fixes */
        .table-responsive-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table {
            color: #e2e8f0;
            border-color: rgba(255, 255, 255, 0.05);
            margin-bottom: 0;
            min-width: 750px; /* Forces full display clarity inside the horizontal scroll wrapper on mobile */
        }

        .table th {
            background: rgba(255, 255, 255, 0.02);
            color: #64748b;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.05em;
            border-bottom: 2px solid rgba(255, 255, 255, 0.05);
            padding: 14px 16px;
        }

        .table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
            padding: 14px 16px;
        }

    </style>

</head>

<body>

<!-- Responsive Mobile Navigation Anchor Bar -->
<div class="mobile-header">
    <div class="mobile-logo">Admin Panel</div>
</div>

<div class="admin-wrapper">

    <!-- CSS State Selection Engine Inputs -->
    <input type="checkbox" id="sidebar-toggle">
    
    <!-- Mobile Hamburger Toggle Trigger Switch -->
    <label for="sidebar-toggle" class="toggle-btn d-lg-none" style="position: fixed; right: 20px; top: 16px; z-index: 1100;">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <!-- Tap backdrop veil zone target to close active mobile sidebar drawer -->
    <label for="sidebar-toggle" class="sidebar-backdrop"></label>