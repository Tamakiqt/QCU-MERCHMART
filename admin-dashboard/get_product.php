<?php
session_start();
require_once '../server/dbcon.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
    exit;
}

$productId = $_GET['id'];

$query = "SELECT * FROM products WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo json_encode($product);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
}

$stmt->close();
$con->close();