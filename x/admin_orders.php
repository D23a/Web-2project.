<?php
session_start();
include 'db.php';


if (!$_SESSION["is_admin"]) { die("Admins only."); }

$q = "SELECT o.id, o.order_date, u.username
      FROM orders o JOIN users u ON o.user_id = u.id
      ORDER BY o.order_date DESC";
$orders = $conn->query($q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Reports</title>
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
            max-width: 900px;
        }
        h2 {
            margin-bottom: 35px;
            color: #305279;
            font-weight: 900;
            letter-spacing: 1px;
        }
        .order-block {
            padding: 18px 0 12px 0;
            border-bottom: 1.5px solid #e3e3e3;
            background: #f6f9fb;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(30,40,90,0.06);
            margin-bottom: 16px;
        }
        .order-block:last-child {
            border-bottom: none;
        }
        .order-header {
            font-size: 1.1rem;
            font-weight: 600;
            color: #305279;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .order-header .bi {
            color: #ffc107;
            margin-right: 3px;
            font-size: 1.15em;
        }
        .order-items {
            margin-left: 18px;
            margin-bottom: 3px;
        }
        .order-items .text-success {
            color: #20b37a !important;
            font-weight: 600;
        }
        .order-items .badge {
            font-size: 0.96em;
            margin-left: 3px;
        }
        .back-link {
            margin-top: 32px;
            background: linear-gradient(90deg, #ffc107 0%, #ffd95a 100%);
            color: #212529;
            font-weight: 700;
            border: none;
            border-radius: 20px;
            box-shadow: 0 2px 8px #ffc10727;
            transition: background 0.18s, color 0.18s;
        }
        .back-link:hover {
            background: #232526;
            color: #ffc107;
            border: 1.5px solid #ffc107;
            box-shadow: 0 4px 12px #ffc10750;
        }
        .alert-warning {
            background: #a7c7f7;
            color: #305279;
            font-weight: 600;
            border: 0;
            border-radius: 8px;
        }
        @media (max-width: 700px) {
            .side-nav { width: 100vw; height: auto; flex-direction: row; box-shadow: none; position: static; }
            .side-nav a { border-left: none; border-top: 4px solid transparent; }
            .side-nav a.active, .side-nav a:hover { border-top: 4px solid #ffc107; border-left: none; }
            .container-main { margin-left: 0; padding-top: 100px;}
        }
    </style>
</head>
<body>
<div class="side-nav">
    <a href="admin_products.php"><i class="bi bi-box-seam"></i> Products</a>
    <a href="admin_orders.php" class="active"><i class="bi bi-file-earmark-bar-graph"></i> Order Reports</a>
    <a href="admin_register.php"><i class="bi bi-person-plus"></i> Register Admin</a>
    <a href="admin_users.php"><i class="bi bi-people"></i> All Users</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
<div class="container-main">
    <h2><i class="bi bi-file-earmark-bar-graph"></i> Order Reports</h2>
    <?php
    $found = false;
    while ($o = $orders->fetch_assoc()):
        $found = true;
    ?>
        <div class="order-block">
            <div class="order-header">
                <i class="bi bi-receipt-cutoff"></i>
                Order #<?= htmlspecialchars($o['id']) ?> by 
                <span class="badge bg-warning text-dark"><?= htmlspecialchars($o['username']) ?></span>
                <span class="text-muted" style="font-size:0.97em;">on <?= htmlspecialchars($o['order_date']) ?></span>
            </div>
            <div class="order-items">
                <?php
                $items = $conn->query("SELECT oi.quantity, p.name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id={$o['id']}");
                while ($i = $items->fetch_assoc()):
                ?>
                    <div>
                        <span class="text-success"><?= htmlspecialchars($i['name']) ?></span>:
                        <span class="badge bg-secondary"><?= htmlspecialchars($i['quantity']) ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile;
    if (!$found): ?>
        <div class="alert alert-warning">No orders found.</div>
    <?php endif; ?>
    <a href="admin_products.php" class="btn back-link"><i class="bi bi-arrow-left"></i> Back to Admin Dashboard</a>
</div>
</body>
</html>