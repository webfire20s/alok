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

    <style>

        body{
            background:#f5f5f5;
        }

        .admin-wrapper{
            display:flex;
            min-height:100vh;
        }

        .admin-content{
            flex:1;
            padding:30px;
        }

        .sidebar{
            width:260px;
            background:#1f2937;
            color:white;
            min-height:100vh;
        }

        .sidebar a{
            color:white;
            display:block;
            padding:14px 20px;
            text-decoration:none;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }

        .sidebar a:hover{
            background:#374151;
            text-decoration:none;
        }

        .sidebar-title{
            padding:20px;
            font-size:22px;
            font-weight:bold;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }

        .card-box{
            background:white;
            border-radius:10px;
            padding:25px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

    </style>

</head>

<body>

<div class="admin-wrapper">