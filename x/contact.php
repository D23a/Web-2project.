<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | Shop</title>
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
        .contact-container {
            max-width: 700px;
            margin: 50px auto;
            background: linear-gradient(140deg, #232526 0%, #414345 100%);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(30,40,90,0.10);
            padding: 40px 35px 35px 35px;
            color: #fff;
        }
        .contact-container h2 {
            color: #ffc107;
            font-weight: 900;
            letter-spacing: 1px;
        }
        .contact-container li {
            margin-bottom: 12px;
            font-size: 1.08rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .contact-container a {
            color: #ffc107;
            font-weight: 600;
            text-decoration: underline;
            transition: color 0.18s;
        }
        .contact-container a:hover {
            color: #fff;
            text-decoration: none;
        }
        .contact-icon {
            color: #ffc107;
            font-size: 1.3em;
            margin-right: 6px;
        }
        @media (max-width: 800px) {
            .contact-container { padding: 25px 8px; }
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="contact-container">
    <h2><i class="bi bi-envelope-paper"></i> Contact Us</h2>
    <p>Have questions or feedback? Reach out below:</p>
    <ul>
        <li><span class="contact-icon"><i class="bi bi-envelope-at"></i></span>Email: <a href="mailto:support@shop.com">shopease@shop.com</a></li>
        <li><span class="contact-icon"><i class="bi bi-telephone"></i></span>Phone: <span style="color:#ffc107;">+44332211</span></li>
        <li><span class="contact-icon"><i class="bi bi-geo-alt"></i></span>Address: <span style="color:#ffc107;">123 Main Street, Jinja City, Uganda</span></li>
    </ul>
    <p>Or fill out our <a href="mailto:support@shop.com">contact form</a> <span class="text-secondary">(coming soon!)</span></p>
</div>
</body>
</html>