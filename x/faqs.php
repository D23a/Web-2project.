<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FAQs | Shop</title>
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
        .faq-container {
            max-width: 700px;
            margin: 50px auto;
            background: linear-gradient(140deg, #232526 0%, #414345 100%);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(30,40,90,0.10);
            padding: 40px 35px 35px 35px;
            color: #fff;
        }
        .faq-container h2 {
            color: #ffc107;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .faq-q {
            font-weight: 600;
            margin-top: 18px;
            color: #ffc107;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .faq-q i {
            font-size: 1.15em;
        }
        .faq-a {
            margin-left: 20px;
            margin-bottom: 8px;
            color: #e9ecef;
        }
        a {
            color: #ffc107;
            text-decoration: underline;
            font-weight: 600;
        }
        a:hover {
            color: #fff;
            text-decoration: none;
        }
        @media (max-width: 800px) {
            .faq-container { padding: 25px 8px; }
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="faq-container">
    <h2><i class="bi bi-question-circle"></i> Frequently Asked Questions</h2>
    <div>
        <div class="faq-q"><i class="bi bi-box-seam"></i> How do I order a product?</div>
        <div class="faq-a">Click on "View &amp; Order" on any product. You'll be asked to log in or create an account, then you can place your order easily.</div>
        <div class="faq-q"><i class="bi bi-person-plus"></i> Can I register as a new user?</div>
        <div class="faq-a">Yes! Use the "Register" button in the navigation bar to create your account.</div>
        <div class="faq-q"><i class="bi bi-headset"></i> How do I contact support?</div>
        <div class="faq-a">Visit our <a href="contact.php">Contact Us</a> page for email and phone details.</div>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>