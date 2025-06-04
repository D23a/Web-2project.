<?php
session_start();
include 'db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, password, is_admin FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {

        if ($user['is_admin'] != 1) {
            $error = "You are not authorized as admin.";
        }
        elseif ($password === $user["password"]) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["is_admin"] = 1;
            header("Location: admin_products.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        
        $error = "Invalid username.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
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
        .login-container {
            max-width: 410px;
            margin: 80px auto;
            background: linear-gradient(140deg, #232526 0%, #414345 100%);
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(30,40,90,0.17);
            color: #fff;
        }
        .login-container h3 {
            color: #ffc107;
            font-weight: 900;
            letter-spacing: 1px;
        }
        .form-label {
            color: #ffc107;
            font-weight: 500;
        }
        .form-control {
            background: #f9fcfe;
            border-radius: 8px;
            border: 1.5px solid #ffc10750;
            font-weight: 600;
            color: #232526;
        }
        .form-control:focus {
            border: 1.5px solid #ffc107;
            box-shadow: 0 2px 10px #ffc10715;
        }
        .btn-primary {
            background: linear-gradient(90deg, #ffc107 0%, #ffd95a 100%);
            color: #212529;
            font-weight: 700;
            border: none;
            border-radius: 20px;
            box-shadow: 0 2px 8px #ffc10727;
            transition: background 0.18s, color 0.18s;
        }
        .btn-primary:hover {
            background: #232526;
            color: #ffc107;
            border: 1.5px solid #ffc107;
            box-shadow: 0 4px 12px #ffc10750;
        }
        .alert-danger {
            background: #ffc107;
            color: #232526;
            font-weight: 600;
            border: 0;
            border-radius: 8px;
        }
        .form-icon {
            font-size: 2.1rem;
            color: #ffc107;
            margin-bottom: 18px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="login-container">
    <div class="form-icon">
        <i class="bi bi-shield-lock"></i>
    </div>
    <h3 class="mb-4 text-center">Admin Login</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="admin_login.php">
        <div class="mb-3">
            <label class="form-label" for="username"><i class="bi bi-person"></i> Username</label>
            <input id="username" name="username" type="text" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label" for="password"><i class="bi bi-lock"></i> Password</label>
            <input id="password" name="password" type="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100 mt-2" type="submit"><i class="bi bi-box-arrow-in-right"></i> Login</button>
    </form>
</div>
</body>
</html>