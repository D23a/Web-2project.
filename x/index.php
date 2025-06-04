<?php
session_start();
include 'db.php';

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchTerm !== '') {
    $searchSql = $conn->real_escape_string($searchTerm);
    $products = $conn->query("SELECT * FROM products WHERE name LIKE '%$searchSql%' OR description LIKE '%$searchSql%'");
} else {
    $products = $conn->query("SELECT * FROM products");
}
$uploads_dir = "uploads";

include 'index.html';
?>