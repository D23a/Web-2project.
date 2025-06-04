<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow" style="background: linear-gradient(90deg, #232526 0%, #414345 100%);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php" style="font-size:2rem; font-weight:900; letter-spacing:2px;">
            <img src="imga.png" alt="Logo" width="36" height="36" class="d-inline-block align-top me-2">
            ShopEase
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF'])=='index.php'?' active':'' ?>" href="index.php">
                        <i class="bi bi-house-fill"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF'])=='about.php'?' active':'' ?>" href="about.php">
                        <i class="bi bi-info-circle"></i> About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF'])=='contact.php'?' active':'' ?>" href="contact.php">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF'])=='faqs.php'?' active':'' ?>" href="faqs.php">
                        <i class="bi bi-envelope"></i> FAQs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF'])=='login.php'?' active':'' ?>" href="login.php">
                        <i class="bi bi-person-circle"></i> Login
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a href="admin_login.php" class="btn btn-outline-warning btn-sm px-3 fw-bold" style="border-radius:20px;">
                        Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .navbar {
        background: linear-gradient(90deg, #232526 0%, #414345 100%) !important;
        box-shadow: 0 4px 18px rgba(30,40,90,0.13);
    }
    .navbar-brand, .navbar-nav .nav-link {
        color:whitesmoke !important;
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
    @media (max-width: 767px) {
        .navbar-brand { font-size: 1.3rem; }
        .navbar-nav .nav-link { font-size: 1rem; }
    }
</style>