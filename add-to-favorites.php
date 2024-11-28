<?php
session_start();
include('server/dbcon.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];
$product_id = $data['product_id'];
$product_name = $data['product_name'];
$price = $data['price'];
$image_url = $data['image_url'];

// Check if already in favorites
$check_query = "SELECT id FROM favorites WHERE user_id = ? AND product_id = ?";
$check_stmt = $con->prepare($check_query);  // Changed from $conn to $con
$check_stmt->bind_param("ii", $user_id, $product_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Already in favorites']);
    exit;
}

// Add to favorites
$query = "INSERT INTO favorites (user_id, product_id, product_name, price, image_url) VALUES (?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);  // Changed from $conn to $con
$stmt->bind_param("iisds", $user_id, $product_id, $product_name, $price, $image_url);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Added to favorites']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding to favorites']);
}
?>