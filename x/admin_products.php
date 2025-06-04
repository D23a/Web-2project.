<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"]) || empty($_SESSION["is_admin"])) {
    header("Location: admin_login.php");
    exit;
}

$uploads_dir = "uploads";
if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0777, true);

if ($_POST && isset($_POST['action']) && in_array($_POST['action'], ['add','edit'])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $desc = $conn->real_escape_string($_POST["description"]);
    $price = (float)$_POST["price"];
    $stock = (int)$_POST["stock"];
    $image_sql = "";

    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $image_name = uniqid("prod_",true).".".$ext;
            move_uploaded_file($tmp_name, "$uploads_dir/$image_name");
        }
    }

    if ($_POST['action'] === "add") {
        $image_sql = $image_name ? "'$image_name'" : "NULL";
        $conn->query("INSERT INTO products (name, description, price, stock, image) VALUES ('$name', '$desc', $price, $stock, $image_sql)");
    } elseif ($_POST['action'] === "edit") {
        $id = (int)$_POST["id"];
        if ($image_name) {
            $old = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
            if ($old && $old['image'] && file_exists("$uploads_dir/" . $old['image'])) unlink("$uploads_dir/" . $old['image']);
            $image_sql = ", image='$image_name'";
        }
        $conn->query("UPDATE products SET name='$name', description='$desc', price=$price, stock=$stock $image_sql WHERE id=$id");
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $check = $conn->query("SELECT 1 FROM order_items WHERE product_id=$id LIMIT 1");
    if ($check->num_rows > 0) {
        $error = "Cannot delete: This product has existing orders.";
    } else {
        $old = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
        if ($old && $old['image'] && file_exists("$uploads_dir/" . $old['image'])) unlink("$uploads_dir/" . $old['image']);
        $conn->query("DELETE FROM products WHERE id=$id");
    }
}

if (isset($_GET['delete_image'])) {
    $id = (int)$_GET['delete_image'];
    $old = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
    if ($old && $old['image'] && file_exists("$uploads_dir/" . $old['image'])) {
        unlink("$uploads_dir/" . $old['image']);
        $conn->query("UPDATE products SET image=NULL WHERE id=$id");
    }
}

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchTerm !== '') {
    $searchSql = $conn->real_escape_string($searchTerm);
    $products = $conn->query("SELECT * FROM products WHERE name LIKE '%$searchSql%' OR description LIKE '%$searchSql%'");
} else {
    $products = $conn->query("SELECT * FROM products");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
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
            max-width: 1100px;
        }
        h2 {
            margin-bottom: 30px;
            letter-spacing: 1px;
            color: #305279;
            font-weight: 900;
        }
        .product-table {
            width: 100%;
            background: #fafdff;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(30,40,90,0.08);
            margin-bottom: 32px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
        }
        .product-table th, .product-table td {
            vertical-align: middle !important;
            padding: 10px 12px;
            text-align: center;
        }
        .product-table th {
            background: linear-gradient(90deg, #e9ecef 0%, #f8f9fa 100%);
            letter-spacing: .04em;
            font-size: 1.05rem;
            color: #305279;
            font-weight: 700;
        }
        .product-table tr {
            transition: box-shadow 0.22s, background 0.18s;
        }
        .product-table tr:not(:first-child):hover {
            background: #eaf1fc !important;
            box-shadow: 0 2px 12px rgba(0,80,180,0.03);
        }
        .product-table tbody tr:nth-child(odd) {
            background: #f6f9fb;
        }
        .product-table tbody tr:nth-child(even) {
            background: #e9eef5;
        }
        .add-form {
            margin-bottom: 36px;
            border-left: 4px solid #ffc107;
            background: linear-gradient(140deg, #232526 0%, #414345 100%);
            padding: 18px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            color: #fff;
        }
        .add-form input[type="text"],
        .add-form input[type="number"] {
            width: 155px;
            background: #f8fcff;
            border-radius: 6px;
            border: 1px solid #dde6ef;
        }
        .add-form input[type="file"] {
            width: 180px;
        }
        .add-form button {
            min-width: 90px;
            background: linear-gradient(90deg, #ffc107 55%, #ffe066 100%);
            border: none;
            color: #232526;
            font-weight: 700;
            border-radius: 20px;
            transition: background 0.18s, color 0.18s;
        }
        .add-form button:hover {
            background: #232526;
            color: #ffc107;
            border: 1.5px solid #ffc107;
            box-shadow: 0 2px 8px #ffc10730;
        }
        .search-bar-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            background: linear-gradient(140deg, #232526 0%, #414345 100%);
            padding: 10px 18px 10px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            max-width: 420px;
            color: #fff;
        }
        .search-bar-form input[type="text"] {
            flex: 1;
            border-radius: 5px;
            border: 1px solid #ffc107;
            padding: 5px 12px;
            background: #f9fcfe;
        }
        .search-bar-form button {
            min-width: 80px;
            background: #ffc107;
            color: #232526;
            border-radius: 5px;
            border: none;
            font-weight: 700;
        }
        .search-bar-form button:hover {
            background: #232526;
            color: #ffc107;
            border: 1.5px solid #ffc107;
        }
        .search-bar-form .btn-outline-secondary {
            border-color: #ffc107;
            color: #ffc107;
        }
        .search-bar-form .btn-outline-secondary:hover {
            background: #ffc107;
            color: #232526;
        }
        .back-link {
            margin-top: 25px;
            display: inline-block;
        }
        .product-image-thumb {
            width: 80px; height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-bottom: 4px;
            transition: transform 0.17s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(50,60,100,0.08);
            background: #fff;
            cursor: pointer;
        }
        .product-image-thumb:hover {
            transform: scale(1.13);
            box-shadow: 0 4px 22px rgba(0,123,255,0.18);
            z-index: 3;
        }
        .img-actions {
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: center;
        }
        .product-price {
            font-weight: 600;
            color: #087cfc;
            font-size: 1.08em;
            margin-top: 3px;
            display: block;
            letter-spacing: 0.04em;
        }
        .product-table input[type="number"] {
            width: 70px;
            background: #f7fafc;
            border-radius: 6px;
            border: 1px solid #dde6ef;
            text-align: center;
        }
        .product-table input[type="text"] {
            width: 130px;
            background: #f7fafc;
            border-radius: 6px;
            border: 1px solid #dde6ef;
        }
        .product-table input[type="file"] {
            width: 100%;
            font-size: 0.98rem;
            padding: 2px 3px;
        }
        .product-table .btn-success {
            margin-right: 4px;
            box-shadow: 0 2px 8px rgba(0,230,90,0.04);
            background: linear-gradient(90deg, #ffc107 55%, #ffe066 100%);
            color: #232526;
            font-weight: 700;
            border-radius: 20px;
            transition: background 0.18s, color 0.18s;
            border: none;
        }
        .product-table .btn-success:hover {
            background: #232526;
            color: #ffc107;
            border: 1.5px solid #ffc107;
        }
        .product-table .btn-link.text-danger {
            font-weight: 500;
            text-decoration: underline;
            color: #df2424 !important;
            padding-left: 0;
            padding-right: 0;
        }
        .product-table .btn-link.text-danger:hover {
            color: #b10c0c !important;
            background: #fbe9e9 !important;
        }
        .product-table .btn-outline-danger {
            padding: 3px 6px;
            font-size: 0.93rem;
            border-radius: 5px;
            border-width: 2px;
        }
        .product-table .btn-outline-danger:hover {
            background: #ffeaea;
            color: #a70000;
        }
        .product-table td {
            vertical-align: middle;
        }
        .product-table form {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 7px;
            margin-bottom: 0;
        }
        .product-table td input, 
        .product-table td .product-price {
            margin: 0 auto;
            display: block;
        }
        .product-table td .product-price {
            margin-top: 2px;
        }
        .product-table td:last-child {
            min-width: 175px;
        }
        .alert-danger {
            background: #ffc107;
            color: #232526;
            font-weight: 600;
            border: 0;
            border-radius: 8px;
        }
        @media (max-width: 700px) {
            .side-nav { width: 100vw; height: auto; flex-direction: row; box-shadow: none; position: static; }
            .side-nav a { border-left: none; border-top: 4px solid transparent; }
            .side-nav a.active, .side-nav a:hover { border-top: 4px solid #ffc107; border-left: none; }
            .container-main { margin-left: 0; padding-top: 100px;}
            .product-table th, .product-table td { font-size: 0.93rem; }
            .product-table { font-size: 0.96rem; }
            .add-form { flex-direction: column; align-items: stretch; }
            .search-bar-form { max-width: 100%; }
        }
    </style>
</head>
<body>
<div class="side-nav">
    <a href="admin_products.php" class="active"><i class="bi bi-box-seam"></i> Products</a>
    <a href="admin_orders.php"><i class="bi bi-file-earmark-bar-graph"></i> Order Reports</a>
    <a href="admin_register.php"><i class="bi bi-person-plus"></i> Register Admin</a>
    <a href="admin_users.php"><i class="bi bi-people"></i> All Users</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
<div class="container-main">
    <h2><i class="bi bi-box-seam"></i> Manage Products</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Search Bar -->
    <form class="search-bar-form" method="get" action="admin_products.php" autocomplete="off">
        <input type="text" name="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Search product by name or description..." class="form-control form-control-sm">
        <?php if ($searchTerm !== ''): ?>
            <a href="admin_products.php" class="btn btn-outline-secondary btn-sm" style="min-width:60px;">Clear</a>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary btn-sm">Search</button>
    </form>

    <form method="POST" class="add-form" enctype="multipart/form-data">
        <input name="name" placeholder="Name" required class="form-control form-control-sm">
        <input name="description" placeholder="Description" class="form-control form-control-sm">
        <input name="price" placeholder="Price" type="number" step="0.01" required class="form-control form-control-sm">
        <input name="stock" placeholder="Stock" type="number" required class="form-control form-control-sm">
        <input type="file" name="image" accept="image/*" class="form-control form-control-sm">
        <input type="hidden" name="action" value="add">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Add Product</button>
    </form>
    <table class="product-table table table-bordered align-middle">
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th style="width:120px;">Image</th>
                <th style="width:160px;">Name</th>
                <th>Description</th>
                <th style="width:90px;">Price</th>
                <th style="width:70px;">Stock</th>
                <th style="width:175px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $products->data_seek(0);
        while ($p = $products->fetch_assoc()): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td>
                    <?php if (!empty($p['image']) && file_exists("$uploads_dir/{$p['image']}")): ?>
                        <img src="<?= $uploads_dir ?>/<?= htmlspecialchars($p['image']) ?>" class="product-image-thumb mb-1"><br>
                        <div class="img-actions">
                            <a href="?delete_image=<?= htmlspecialchars($p['id']) ?>" class="btn btn-outline-danger btn-sm btn-block" onclick="return confirm('Remove image?')">Delete</a>
                        </div>
                    <?php else: ?>
                        <span class="text-muted small">No image</span>
                    <?php endif; ?>
                </td>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                    <td>
                        <input name="name" value="<?= htmlspecialchars($p['name']) ?>" required class="form-control form-control-sm">
                    </td>
                    <td>
                        <input name="description" value="<?= htmlspecialchars($p['description']) ?>" class="form-control form-control-sm">
                    </td>
                    <td>
                        <input name="price" value="<?= htmlspecialchars($p['price']) ?>" required type="number" step="0.01" class="form-control form-control-sm">
                        <span class="product-price">UGX<?= htmlspecialchars(number_format($p['price'])) ?> </span>
                    </td>
                    <td>
                        <input name="stock" value="<?= htmlspecialchars($p['stock']) ?>" required type="number" class="form-control form-control-sm">
                    </td>
                    <td>
                        <input type="file" name="image" accept="image/*" class="form-control form-control-sm mb-1">
                        <input type="hidden" name="action" value="edit">
                        <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                        <a href="?delete=<?= htmlspecialchars($p['id']) ?>" class="btn btn-link btn-sm text-danger" onclick="return confirm('Delete this product?')"><i class="bi bi-trash"></i> Delete</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="products.php" class="back-link btn btn-secondary btn-sm">&larr; Back to public shop</a>
</div>
</body>
</html>