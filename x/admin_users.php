<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"]) || empty($_SESSION["is_admin"])) {
    header("Location: admin_login.php");
    exit;
}

$users = $conn->query("SELECT username, is_admin, last_login FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - All Registered Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            background-attachment: fixed;
        }
        .side-nav {
            position: fixed;
            top: 0; left: 0; height: 100vh;
            width: 200px;
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
            padding-top: 40px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            z-index: 100;
            box-shadow: 2px 0 12px rgba(0,0,0,0.07);
        }
        .side-nav a {
            color: #f8f9fa;
            padding: 15px 24px;
            margin: 0 0 6px 0;
            text-decoration: none;
            font-size: 1.08rem;
            transition: background 0.18s, color 0.18s;
            border-left: 4px solid transparent;
            font-weight: 600;
            letter-spacing: .03em;
        }
        .side-nav a.active, .side-nav a:hover {
            background: #1d2124;
            border-left: 4px solid #ffc107;
            color: #ffc107;
        }
        .container-main {
            margin-left: 220px;
            padding: 40px 20px 20px 20px;
            max-width: 950px;
        }
        h2 {
            margin-bottom: 30px;
            letter-spacing: 1px;
            color: #305279;
            font-weight: 900;
        }
        .users-table {
            width: 100%;
            background: #fafdff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(30,40,90,0.07);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .users-table th, .users-table td {
            vertical-align: middle !important;
            padding: 10px 12px;
            text-align: center;
        }
        .users-table th {
            background: linear-gradient(90deg, #e9ecef 0%, #f8f9fa 100%);
            font-size: 1.04rem;
            color: #305279;
            font-weight: 700;
            letter-spacing: .04em;
        }
        .users-table tbody tr:nth-child(odd) {
            background: #f6f9fb;
        }
        .users-table tbody tr:nth-child(even) {
            background: #e9eef5;
        }
        .users-table tr:not(:first-child):hover {
            background: #eaf1fc !important;
            box-shadow: 0 1px 6px rgba(100,120,160,0.05);
        }
        .badge-admin {
            background: #ffc107;
            color: #232526;
            font-weight: 600;
            font-size: 0.99em;
            border-radius: 7px;
            padding: 5px 14px;
            letter-spacing: .03em;
            box-shadow: 0 1px 4px #ffc10730;
        }
        .badge-user {
            background: #6c757d;
            color: #fff;
            font-weight: 600;
            font-size: 0.99em;
            border-radius: 7px;
            padding: 5px 14px;
            letter-spacing: .03em;
        }
        @media (max-width: 700px) {
            .side-nav { width: 100vw; height: auto; flex-direction: row; box-shadow: none; position: static; }
            .side-nav a { border-left: none; border-top: 4px solid transparent; }
            .side-nav a.active, .side-nav a:hover { border-top: 4px solid #ffc107; border-left: none; }
            .container-main { margin-left: 0; padding-top: 100px;}
            .users-table th, .users-table td { font-size: 0.9rem; }
        }
    </style>
</head>
<body>
<div class="side-nav">
    <a href="admin_products.php"><i class="bi bi-box-seam"></i> Products</a>
    <a href="admin_orders.php"><i class="bi bi-file-earmark-bar-graph"></i> Order Reports</a>
    <a href="admin_register.php"><i class="bi bi-person-plus"></i> Register Admin</a>
    <a href="admin_users.php" class="active"><i class="bi bi-people"></i> All Users</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
<div class="container-main">
    <h2><i class="bi bi-people"></i> All Registered Users</h2>
    <table class="users-table table table-bordered align-middle">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Last Login</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($users->num_rows > 0): ?>
            <?php while($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                    <?php if ($user['is_admin']): ?>
                        <span class="badge badge-admin"><i class="bi bi-shield-lock"></i> Admin</span>
                    <?php else: ?>
                        <span class="badge badge-user"><i class="bi bi-person"></i> User</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?= isset($user['last_login']) && $user['last_login'] ? htmlspecialchars($user['last_login']) : 'Never' ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-muted">No users found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>