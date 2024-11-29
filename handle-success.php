<?php
session_start();
require_once 'server/dbcon.php';

if(isset($_SESSION['user_id']) && isset($_SESSION['pending_payment'])) {
    $user_id = $_SESSION['user_id'];
    
    try {
        $con->begin_transaction();

        // Get cart items
        $cart_query = "SELECT * FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($cart_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Move items to orders
        while($cart_item = $result->fetch_assoc()) {
            $order_number = 'ORD' . date('Ymd') . rand(1000, 9999);
            
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

        // Clear cart
        $clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($clear_cart);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $con->commit();

        // Clear session variables
        unset($_SESSION['pending_payment']);
        unset($_SESSION['payment_amount']);

        // Set success message and redirect
        $_SESSION['message'] = "Payment successful! Your order has been placed.";
        
        // JavaScript redirect with alert
        echo "<script>
            alert('Payment successful! Your order has been placed.');
            window.location.href = 'my-account.php?tab=order-history';
        </script>";
        exit();

    } catch (Exception $e) {
        $con->rollback();
        $_SESSION['error'] = "Error processing order: " . $e->getMessage();
        echo "<script>
            alert('Error processing order. Please try again.');
            window.location.href = 'cart.php';
        </script>";
        exit();
    }
} else {
    header("Location: cart.php");
    exit();
}
?>