<?php
session_start();
require_once 'server/dbcon.php';

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_log("Payment success page accessed");

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    try {
        error_log("Processing payment for user: " . $user_id);
        $con->begin_transaction();

        // Get cart items
        $cart_query = "SELECT * FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($cart_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_result = $stmt->get_result();
        
        error_log("Found " . $cart_result->num_rows . " items in cart");

        while($cart_item = $cart_result->fetch_assoc()) {
            $order_number = 'ORD' . date('Ymd') . rand(1000, 9999);
            
            error_log("Creating order: " . $order_number);
            
            $insert_order = "INSERT INTO orders (
                order_number, 
                user_id, 
                product_id,
                product_name, 
                price, 
                quantity, 
                total, 
                image_url,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Ready for pickup')";
            
            $stmt = $con->prepare($insert_order);
            $stmt->bind_param("siisdiis", 
                $order_number,
                $user_id,
                $cart_item['product_id'],
                $cart_item['product_name'],
                $cart_item['price'],
                $cart_item['quantity'],
                $cart_item['total'],
                $cart_item['image_url']
            );
            
            if(!$stmt->execute()) {
                throw new Exception("Failed to create order: " . $stmt->error);
            }
            error_log("Order created successfully: " . $order_number);
        }

        // Clear the cart
        error_log("Clearing cart for user: " . $user_id);
        $clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($clear_cart);
        $stmt->bind_param("i", $user_id);
        
        if(!$stmt->execute()) {
            throw new Exception("Failed to clear cart: " . $stmt->error);
        }

        $con->commit();
        error_log("Transaction committed successfully");
        
        $_SESSION['message'] = "Payment successful! Your order has been placed.";
        
        // Use JavaScript for redirection
        echo "<script>
            alert('Payment successful! Your order has been placed.');
            window.location.href = 'my-account.php?tab=order-history';
        </script>";
        exit();

    } catch (Exception $e) {
        $con->rollback();
        error_log("Payment Error: " . $e->getMessage());
        
        echo "<script>
            alert('Error processing payment: " . addslashes($e->getMessage()) . "');
            window.location.href = 'cart.php';
        </script>";
        exit();
    }
} else {
    error_log("No user ID found in session");
    header("Location: login.php");
    exit();
}
?>