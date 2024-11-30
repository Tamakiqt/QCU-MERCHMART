<?php
session_start();
include('server/dbcon.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug log
    error_log("Received POST data: " . print_r($_POST, true));
    
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $product_name = $_POST['product_name'];
    $unit_price = floatval(str_replace(['₱', ','], '', $_POST['price']));
    $quantity = intval($_POST['quantity']);
    $total = $unit_price * $quantity;
    $image_url = $_POST['image_url'];

    // Debug log
    error_log("Processed data: product_id=$product_id, name=$product_name, price=$unit_price, quantity=$quantity");

    // First, check current cart total quantity
    $check_total_query = "SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?";
    $check_total_stmt = $con->prepare($check_total_query);
    $check_total_stmt->bind_param("i", $user_id);
    $check_total_stmt->execute();
    $total_result = $check_total_stmt->get_result();
    $current_total = $total_result->fetch_assoc()['total_items'] ?? 0;
    
    // Calculate if this would exceed the limit
    if (($current_total + $quantity) > 60) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Cart limit exceeded! Maximum 60 items allowed. Current items: ' . $current_total,
            'current_total' => $current_total
        ]);
        exit;
    }

    // Check if product exists in cart
    $check_query = "SELECT id, quantity, total FROM cart WHERE user_id = ? AND product_id = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Product exists, update quantity and total
        $cart_item = $result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + $quantity;
        $new_total = $unit_price * $new_quantity;

        $update_query = "UPDATE cart 
                        SET quantity = ?, 
                            total = ? 
                        WHERE user_id = ? AND product_id = ?";
        
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("idii", $new_quantity, $new_total, $user_id, $product_id);
    } else {
        // New product, insert
        $insert_query = "INSERT INTO cart (user_id, product_id, product_name, price, quantity, total, image_url) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $con->prepare($insert_query);
        $stmt->bind_param("iisdiis", $user_id, $product_id, $product_name, $unit_price, $quantity, $total, $image_url);
    }
    
    if($stmt->execute()) {
        echo json_encode([
            'status' => 'success', 
            'message' => 'Product added to cart!',
            'quantity' => $quantity,
            'price' => $unit_price,
            'total' => $total
        ]);
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Database error: ' . $stmt->error,
            'debug' => [
                'product_id' => $product_id,
                'product_name' => $product_name,
                'price' => $unit_price,
                'quantity' => $quantity,
                'image_url' => $image_url
            ]
        ]);
    }
    
    $check_stmt->close();
    $stmt->close();
}
?>
