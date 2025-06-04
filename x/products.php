<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"]) || !empty($_SESSION["is_admin"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
    $user_id = $_SESSION["user_id"];
    $order_items = array_filter($_POST['qty'], function($qty) { return $qty > 0; }); 
    if ($order_items) {
        
        $conn->query("INSERT INTO orders (user_id, order_date) VALUES ($user_id, NOW())");
        $order_id = $conn->insert_id;
        foreach ($order_items as $pid => $qty) {
            $pid = (int)$pid;
            $qty = (int)$qty;
            $conn->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $pid, $qty)");
            $conn->query("UPDATE products SET stock = stock - $qty WHERE id = $pid");
        }
        $success = "Order placed successfully!";
    } else {
        $error = "Please select a quantity for at least one product.";
    }
}

$result = $conn->query("SELECT * FROM products");
$uploads_dir = "uploads";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body {
            min-height: 100vh;
            width: 100%;
        }
        body {
            background: radial-gradient(circle at 40% 20%, #e0eafc 0%, #ffd95a 38%, #cfdef3 90%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        .container-main {
            max-width: 900px;
            margin: 45px auto 0 auto;
            background: linear-gradient(140deg, #fff 0%, #f7fafc 100%);
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(30,40,90,0.11);
            padding: 36px 32px 28px 32px;
        }
        .header {
            margin-bottom: 35px;
            border-bottom: 1.5px solid #e9ecef;
            padding-bottom: 10px;
        }
        .header h2 {
            font-weight: 700;
            color: #305279;
            letter-spacing: .03em;
        }
        .nav-links {
            margin-bottom: 0;
        }
        .product-list {
            margin: 0;
            padding: 0;
        }
        .product-row {
            list-style: none;
            padding: 22px 0 16px 0;
            border-bottom: 1.5px solid #f1f3f6;
            display: flex;
            align-items: center;
            transition: background 0.16s;
            gap: 18px;
            animation: fadeInRow 1.1s;
        }
        @keyframes fadeInRow {
            from { opacity: 0; transform: translateY(36px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .product-row:last-child {
            border-bottom: none;
        }
        .product-row:hover {
            background: #eaf1fc;
        }
        .product-img-wrap {
            width: 88px;
            min-width: 88px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f8f8;
            border-radius: 7px;
            border: 1.5px solid #ffc10750;
            margin-right: 16px;
            box-shadow: 0 2px 8px #ffc10719;
        }
        .product-img {
            max-width: 84px;
            max-height: 68px;
            border-radius: 6px;
            object-fit: cover;
            transition: transform 0.13s;
        }
        .product-row:hover .product-img {
            transform: scale(1.07) rotate(-2deg);
        }
        .product-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .product-name {
            font-size: 1.13rem;
            font-weight: 700;
            color: #ffc107;
            letter-spacing: 0.5px;
            display: flex;
            gap: 7px;
        }
        .product-name i {
            color: #7e98b5;
        }
        .product-meta {
            font-size: 1.01rem;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .product-price {
            color: #20b37a;
            font-weight: 600;
            background: #eaf7f1;
            border-radius: 7px;
            padding: 2px 9px;
            letter-spacing: .4px;
            font-size: 1.04em;
            margin-right: 6px;
            box-shadow: 0 1px 4px #2221;
            animation: blinkPrice 1.7s linear infinite;
        }
        @keyframes blinkPrice {
            35% { color: #28a745; background: #fff9d4; }
            70% { color: #1eae6a; background: #eaf7f1; }
        }
        .badge-stock {
            background: #232526;
            color: #ffc107 !important;
            border-radius: 5px;
            padding: 4px 10px;
            font-weight: 600;
            letter-spacing: .08em;
            animation: badgeBlink 1.8s infinite;
        }
        @keyframes badgeBlink {
            50% { background: #ffc107; color: #232526 !important; }
        }
        .product-desc {
            color: #4d5b6b;
            font-size: 0.97rem;
            margin-top: 4px;
        }
        .qty-input {
            min-width: 110px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .qty-input input[type="number"] {
            width: 70px;
            border-radius: 6px;
            border: 1.5px solid #ffc10750;
            padding: 4px 8px;
        }
        .order-btn {
            margin-top: 35px;
            font-size: 1.09rem;
            padding: 10px 36px;
            border-radius: 20px;
            background: linear-gradient(90deg, #ffc107 0%, #ffd95a 100%);
            color: #212529;
            font-weight: 700;
            box-shadow: 0 2px 8px #ffc10722;
            border: none;
            animation: btnPulse 1.3s infinite;
        }
        @keyframes btnPulse {
            0% { box-shadow: 0 0 0 0 #ffc10733; }
            50% { box-shadow: 0 0 8px 5px #ffc10755; }
            100% { box-shadow: 0 0 0 0 #ffc10733; }
        }
        .order-btn:hover {
            background: #232526;
            color: #ffc107;
            border: 1.5px solid #ffc107;
            box-shadow: 0 4px 12px #ffc10750;
            animation: none;
        }
        @media (max-width: 600px) {
            .container-main { padding: 15px 4px 10px 4px; }
            .product-row { flex-direction: column; align-items: flex-start; padding: 14px 0 10px 0; gap: 8px;}
            .product-img-wrap { margin-right: 0; margin-bottom: 8px;}
            .qty-input { margin-top: 10px; }
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container-main">
    <div class="header d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-box-seam"></i> Shop Products</h2>
        <div class="nav-links">
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
        </div>
    </div>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="products.php">
        <ul class="product-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()): ?>
                <li class="product-row">
                    <div class="product-img-wrap">
                        <?php if (!empty($row['image']) && file_exists($uploads_dir . "/" . $row['image'])): ?>
                            <img class="product-img" src="<?= $uploads_dir ?>/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                        <?php else: ?>
                            <img class="product-img" src="https://via.placeholder.com/84x68?text=No+Image" alt="No image">
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <span class="product-name"><i class="bi bi-box-seam"></i> <?= htmlspecialchars($row['name']) ?></span>
                        <div class="product-meta">
                            <span class="product-price"><?= htmlspecialchars(number_format($row['price'])) ?> UGX</span>
                            <span class="badge badge-stock"><?= htmlspecialchars($row['stock']) ?> in stock</span>
                        </div>
                        <?php if (!empty($row['description'])): ?>
                            <div class="product-desc"><?= htmlspecialchars($row['description']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="qty-input ms-auto">
                        <label for="qty-<?= $row['id'] ?>" class="me-1">Qty:</label>
                        <input id="qty-<?= $row['id'] ?>" type="number" name="qty[<?= $row['id'] ?>]" min="0" max="<?= $row['stock'] ?>" value="0" class="form-control form-control-sm">
                    </div>
                </li>
        <?php endwhile;
        } else {
            echo "<div class='alert alert-warning mt-4'>No products available.</div>";
        }
        ?>
        </ul>
        <div class="text-center">
            <button type="submit" class="btn order-btn"><i class="bi bi-cart-plus"></i> Order Selected</button>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>