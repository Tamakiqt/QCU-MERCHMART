<?php
session_start();
include('dbcon.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

try {
    $user_id = $_SESSION['user_id'];
    
    // Start transaction
    $con->begin_transaction();
    
    // Get cart items
    $cart_query = "SELECT c.*, p.price 
                   FROM cart c 
                   JOIN products p ON c.product_id = p.id 
                   WHERE c.user_id = ?";
    $stmt = $con->prepare($cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Calculate total
    $total = 0;
    foreach ($cart_items as $item) {
        $total += $item['quantity'] * $item['price'];
    }
    
    // Create order
    $order_query = "INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')";
    $stmt = $con->prepare($order_query);
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $con->insert_id;
    
    // Insert order items
    $order_items_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($order_items_query);
    
    foreach ($cart_items as $item) {
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }
    
    // Clear cart
    $clear_cart = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $con->prepare($clear_cart);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Commit transaction
    $con->commit();
    
    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'total' => $total
    ]);
    
} catch (Exception $e) {
    $con->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Error creating order: ' . $e->getMessage()
    ]);
}

$con->close();
?>