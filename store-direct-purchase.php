<?php
session_start();
require_once 'server/dbcon.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Get JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
    exit();
}

try {
    // Store purchase information in session
    $_SESSION['direct_purchase'] = [
        'product_id' => $data['product_id'],
        'product_name' => $data['product_name'],
        'price' => $data['price'],
        'quantity' => $data['quantity'],
        'total_price' => $data['total_price'],
        'image_url' => $data['image_url']
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Purchase data stored successfully'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error storing purchase data: ' . $e->getMessage()
    ]);
}
?>