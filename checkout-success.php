<?php
session_start();
require_once 'server/dbcon.php';

// Debug log
error_log('Checkout success page hit');

if (!isset($_SESSION['pending_order'])) {
    error_log('No pending order found');
    header("Location: client-shop.php");
    exit();
}

try {
    $order = $_SESSION['pending_order'];
    
    // Insert into orders table
    $query = "INSERT INTO orders (
        order_number, 
        user_id, 
        product_id, 
        product_name, 
        price, 
        quantity, 
        total, 
        image_url, 
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("siisdiiss", 
        $order['order_number'],
        $order['user_id'],
        $order['product_id'],
        $order['product_name'],
        $order['price'],
        $order['quantity'],
        $order['total'],
        $order['image_url'],
        $order['status']
    );
    
    if ($stmt->execute()) {
        // Clear session data
        unset($_SESSION['pending_order']);
        
        // Set success message
        $_SESSION['success_message'] = "Payment successful! Your order has been placed.";
        header("Location: my-account.php?tab=order-history");
    } else {
        throw new Exception("Failed to save order");
    }
    
} catch (Exception $e) {
    error_log('Error processing order: ' . $e->getMessage());
    $_SESSION['error_message'] = "Error processing order: " . $e->getMessage();
    header("Location: client-index.php");
}
exit();
?>