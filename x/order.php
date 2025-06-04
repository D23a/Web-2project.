<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }

$qtys = $_POST['qty'];
$user_id = $_SESSION["user_id"];

$order_items = [];
foreach ($qtys as $pid => $qty) {
    if ($qty > 0) $order_items[$pid] = (int)$qty;
}

if ($order_items) {
    $conn->query("INSERT INTO orders (user_id) VALUES ($user_id)");
    $order_id = $conn->insert_id;
    foreach ($order_items as $pid => $qty) {
        $conn->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $pid, $qty)");
        $conn->query("UPDATE products SET stock = stock - $qty WHERE id = $pid");
    }
    echo "Order placed successfully! <a href='products.php'>Back to products</a>";
} else {
    echo "No products selected.<a href='products.php'>Back</a>";
}
?>