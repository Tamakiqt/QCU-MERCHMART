<?php
session_start();
require_once 'dbcon.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT c.*, p.image_url 
              FROM cart c
              JOIN products p ON c.product_id = p.id
              WHERE c.user_id = ?";
              
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'items' => $items
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to get cart items: ' . $e->getMessage()
    ]);
}
?>