<?php
session_start();
require_once 'server/dbcon.php';

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $con->begin_transaction();

    // Get cart items
    $cart_query = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $con->prepare($cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    if($cart_result->num_rows > 0) {
        while($cart_item = $cart_result->fetch_assoc()) {
            // Generate order number
            $order_number = 'ORD' . date('Ymd') . rand(1000, 9999);
            
            // Insert into orders
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
            $stmt->execute();
        }

        // Clear the cart
        $clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($clear_cart);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Commit transaction
        $con->commit();

        $_SESSION['message'] = "Order placed successfully!";
        echo "<script>
            alert('Payment successful! Your order has been placed.');
            window.location.href = 'my-account.php?tab=order-history';
        </script>";
        exit();
    } else {
        $_SESSION['message'] = "Your cart is empty!";
        header("Location: cart.php");
        exit();
    }
} catch (Exception $e) {
    // Rollback transaction on error
    $con->rollback();
    $_SESSION['message'] = "Error processing your order: " . $e->getMessage();
    header("Location: cart.php");
    exit();
}
?>