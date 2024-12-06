<?php
session_start();
require_once '../server/dbcon.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Set JSON header

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    if (!isset($_POST['product_id'])) {
        throw new Exception('Product ID not provided');
    }

    $product_id = (int)$_POST['product_id'];
    
    // Log the received product ID
    error_log("Attempting to delete product ID: " . $product_id);

    // First get the image URL
    $stmt = $con->prepare("SELECT image_url FROM products WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("i", $product_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if (!empty($row['image_url']) && file_exists($row['image_url'])) {
            if (!unlink($row['image_url'])) {
                error_log("Failed to delete image file: " . $row['image_url']);
            }
        }
    }

    // Delete the product from database
    $stmt = $con->prepare("DELETE FROM products WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare delete failed: " . $con->error);
    }

    $stmt->bind_param("i", $product_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Delete failed: " . $stmt->error);
    }

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }

} catch (Exception $e) {
    error_log("Delete product error: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>