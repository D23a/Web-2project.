<?php
session_start();
include 'db.php';

if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header("Location: admin_login.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm  = $_POST["confirm_password"] ?? "";

    if (strlen($username) < 3) {
        $error = "Username must be at least 3 characters.";
    } elseif (strlen($password) < 5) {
        $error = "Password must be at least 5 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            $insert = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 1)");
            $insert->bind_param("ss", $username, $password);

            if ($insert->execute()) {
                $success = "Admin registered successfully!";
            } else {
                $error = "Error registering admin.";
            }
            $insert->close();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            background-attachment: fixed;
        }
        .register-container {
            max-width: 410px;
            margin: 80px auto;
            background: linear-gradient(140deg, #232526 0%, #414345 100%);
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(30,40,90,0.17);
            color: #fff;
        }
        .register-container h3 {
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
        .alert-danger, .alert-success {
            background: #ffc107;
            color: #232526;
            font-weight: 600;
            border: 0;
            border-radius: 8px;
        }
        .alert-success {
            background: #20b37a;
            color: #fff;
        }
        .back-link {
            color: #ffc107;
            font-weight: 600;
            text-decoration: underline;
            transition: color 0.18s;
        }
        .back-link:hover {
            color: #fff;
            text-decoration: none;
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
<div class="register-container">
    <div class="form-icon">
        <i class="bi bi-person-plus"></i>
    </div>
    <h3 class="mb-4 text-center">Register Admin</h3>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label" for="username"><i class="bi bi-person"></i> Username</label>
            <input id="username" name="username" type="text" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label" for="password"><i class="bi bi-lock"></i> Password</label>
            <input id="password" name="password" type="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="confirm_password"><i class="bi bi-lock-fill"></i> Confirm Password</label>
            <input id="confirm_password" name="confirm_password" type="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-person-plus"></i> Register Admin</button>
    </form>
    <div class="mt-3 text-center">
        <a href="admin_products.php" class="back-link"><i class="bi bi-arrow-left"></i> Back to Admin Dashboard</a>
    </div>
</div>
</body>
</html>