<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us | Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            background-attachment: fixed;
        }
        .navbar {
            background: linear-gradient(90deg, #232526 0%, #414345 100%) !important;
            box-shadow: 0 4px 18px rgba(30,40,90,0.13);
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #f8f9fa !important;
            transition: color 0.18s;
            font-weight: 600;
        }
        .navbar-brand:hover, .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: #ffc107 !important;
            text-shadow: 0 2px 12px #2224;
        }
        .navbar .btn-outline-warning {
            transition: background 0.18s, color 0.18s, box-shadow 0.18s;
            border-width: 2px;
        }
        .navbar .btn-outline-warning:hover {
            background: #ffc107;
            color: #232526;
            box-shadow: 0 2px 8px #ffc10755;
        }
        .about-container {
            max-width: 700px;
            margin: 50px auto;
            background: linear-gradient(140deg, #232526 0%, #414345 100%);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(30,40,90,0.10);
            padding: 40px 35px 35px 35px;
            color: #fff;
        }
        .about-container h2 {
            color: #ffc107;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .about-container p {
            font-size: 1.13rem;
            color: #e9ecef;
        }
        @media (max-width: 800px) {
            .about-container { padding: 25px 8px; }
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="about-container">
    <h2><i class="bi bi-info-circle"></i> About Us</h2>
    <p>
        Welcome to our online shop! We are dedicated to offering our customers the best products at great prices.
        Our mission is to create a seamless shopping experience, backed by excellent customer support and a wide range of products.
    </p>
    <p>
        Thank you for visiting and shopping with us!
    </p>
</div>
</body>
</html>