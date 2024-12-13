<?php
session_start();
require_once '../server/dbcon.php';

// Prevent any output before headers
ob_start();

// Set JSON header
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['from_cart'])) {
    try {
        $con->begin_transaction();
        $user_id = $_SESSION['user_id'];
        
        // Get cart items first
        $cart_query = "SELECT c.*, p.product_name, p.price, p.image_url 
                      FROM cart c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.user_id = ?";
        $stmt = $con->prepare($cart_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($cart_items)) {
            throw new Exception('Cart is empty');
        }

        // Generate references
        $payment_ref = 'PAY' . time() . rand(1000, 9999);
        $order_number = 'ORD' . date('Ymd') . rand(1000, 9999);

        // Create orders for each cart item
        foreach ($cart_items as $item) {
            $item_total = $item['quantity'] * $item['price'];
            
            // Insert into orders
            $order_query = "INSERT INTO orders (
                order_number,
                user_id,
                product_id,
                product_name,
                price,
                quantity,
                total,
                image_url,
                payment_id,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

            $stmt = $con->prepare($order_query);
            $stmt->bind_param(
                "siisdiiss",
                $order_number,
                $user_id,
                $item['product_id'],
                $item['product_name'],
                $item['price'],
                $item['quantity'],
                $item_total,
                $item['image_url'],
                $payment_ref
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to create order for: " . $item['product_name']);
            }
        }

        // Store in session
        $_SESSION['payment_ref'] = $payment_ref;
        $_SESSION['order_number'] = $order_number;
        $_SESSION['total_amount'] = $_POST['total_amount'];

        // Commit transaction
        $con->commit();
            
        echo json_encode([
            'success' => true,
            'payment_ref' => $payment_ref,
            'order_number' => $order_number
        ]);
        exit();

    } catch (Exception $e) {
        $con->rollback();
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit();
    }
}



// Handle payment simulation
if (isset($_POST['payment_ref']) && isset($_POST['order_number'])) {
    try {
        $con->begin_transaction();

        // First get the order details
        $order_query = "SELECT product_id, quantity FROM orders WHERE order_number = ?";
        $stmt = $con->prepare($order_query);
        $stmt->bind_param("s", $_POST['order_number']);
        $stmt->execute();
        $order_result = $stmt->get_result();
        $order = $order_result->fetch_assoc();

        if (!$order) {
            throw new Exception('Order not found');
        }

        $clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($clear_cart);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();


        // Update product stock
        $update_stock = "UPDATE products 
                        SET stock_quantity = stock_quantity - ? 
                        WHERE id = ? AND stock_quantity >= ?";
        $stmt = $con->prepare($update_stock);
        $stmt->bind_param("iii", 
            $order['quantity'], 
            $order['product_id'], 
            $order['quantity']
        );
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception('Insufficient stock');
        }

        // Update order status to 'Paid'
        $update_query = "UPDATE orders SET status = 'Paid' WHERE order_number = ? AND payment_id = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("ss", $_POST['order_number'], $_POST['payment_ref']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $con->commit();
            $_SESSION['payment_success'] = true;
            echo json_encode([
                'success' => true,
                'redirect' => 'payment-success.php'
            ]);
        } else {
            throw new Exception('Failed to update order status');
        }
        
    } catch (Exception $e) {
        $con->rollback();
        echo json_encode([
            'success' => false,
            'message' => 'Payment processing failed: ' . $e->getMessage()
        ]);
    }
    exit();
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

// At the beginning of your direct purchase processing
if (isset($data['product_id'])) {
    try {
        $con->begin_transaction();
        
        $total_price = floatval($data['price']) * intval($data['quantity']);
        $order_number = 'ORD' . uniqid();
        $payment_ref = 'PAY' . date('YmdHis') . rand(1000, 9999);
        
        // Check for duplicate order number
        $check_order_query = "SELECT order_number FROM orders WHERE order_number = ?";
        $stmt = $con->prepare($check_order_query);
        $stmt->bind_param("s", $order_number);
        $stmt->execute();
        $existing_order = $stmt->get_result()->fetch_assoc();

        if ($existing_order) {
            throw new Exception('Duplicate order detected');
        }

        // Create the order immediately
        $order_query = "INSERT INTO orders (
            order_number,
            user_id,
            product_id,
            product_name,
            price,
            quantity,
            total,
            image_url,
            payment_id,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
        
        $stmt = $con->prepare($order_query);
        $stmt->bind_param("siisdiiss",
            $order_number,
            $_SESSION['user_id'],
            $data['product_id'],
            $data['product_name'],
            $data['price'],
            $data['quantity'],
            $total_price,
            $data['image_url'],
            $payment_ref
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to create order: " . $stmt->error);
        }

        // Store in session
        $_SESSION['direct_purchase'] = [
            'id' => $data['product_id'],
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'image_url' => $data['image_url'],
            'total_price' => $total_price
        ];
        
        $_SESSION['payment_success'] = true;
        $_SESSION['order_number'] = $order_number;
        $_SESSION['payment_ref'] = $payment_ref;
        $_SESSION['total_amount'] = $total_price;

        $con->commit();

        echo json_encode([
            'success' => true,
            'redirect' => 'payment-gateway.php',
            'order_number' => $order_number,
            'payment_ref' => $payment_ref
        ]);
        exit();
        
    } catch (Exception $e) {
        $con->rollback();
        echo json_encode([
            'success' => false,
            'message' => 'Failed to process order: ' . $e->getMessage()
        ]);
        exit();
    }
}



$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment_method'];
$name = htmlspecialchars(trim($_POST['name']));
$phone = htmlspecialchars(trim($_POST['phone']));
$email = htmlspecialchars(trim($_POST['email']));

try {
    // Start transaction
    $con->begin_transaction();

    // Function to generate a unique order number
    function generateUniqueOrderNumber($con) {
        $maxAttempts = 10;
        $attempts = 0;
        $orderNumberGenerated = false;
    
        do {
            $timestamp = microtime(true);
            $date = date('YmdHis', $timestamp);
            $micro = sprintf("%06d", ($timestamp - floor($timestamp)) * 1000000);
            $random = mt_rand(1000, 9999);
            $order_number = sprintf('ORD%s%s%s', $date, $micro, $random);
    
            
            $check_query = "SELECT order_number FROM orders WHERE order_number = ?";
            $stmt = $con->prepare($check_query);
            $stmt->bind_param("s", $order_number);
            $stmt->execute();
    
            if ($stmt->get_result()->num_rows === 0) {
                $orderNumberGenerated = true;
            }
    
            $attempts++;
        } while (!$orderNumberGenerated && $attempts < $maxAttempts);
    
        if (!$orderNumberGenerated) {
            throw new Exception("Failed to generate unique order number after {$maxAttempts} attempts");
        }
    
        return $order_number;
    }

    $order_number = generateUniqueOrderNumber($con);
    $payment_ref = 'PAY' . date('YmdHis') . rand(1000, 9999);

    
    // Check if it's a direct purchase or cart purchase
    if (isset($_SESSION['direct_purchase'])) {
        // Direct purchase processing
        $product = $_SESSION['direct_purchase'];
        $item_total = $product['price'] * $product['quantity'];
        
        $order_query = "INSERT INTO orders (
            order_number, 
            user_id, 
            product_id, 
            product_name,
            price,
            quantity,
            total,
            image_url,
            payment_id,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
        
        $stmt = $con->prepare($order_query);
        $stmt->bind_param("siisdiiss", 
            $order_number,
            $user_id,
            $product['id'],
            $product['product_name'],
            $product['price'],
            $product['quantity'],
            $item_total,
            $product['image_url'],
            $payment_ref
        );
        $stmt->execute();

        // Update product stock
        $update_stock = "UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?";
        $stmt = $con->prepare($update_stock);
        $stmt->bind_param("ii", $product['quantity'], $product['id']);
        $stmt->execute();

        $total_amount = $item_total;
        
    } else {
        // Cart purchase processing
        $cart_query = "SELECT c.*, p.price, p.product_name, p.image_url 
                      FROM cart c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.user_id = ?";
        $stmt = $con->prepare($cart_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_items = $stmt->get_result();

        $total_amount = 0;
        while ($item = $cart_items->fetch_assoc()) {
            $total_amount += ($item['price'] * $item['quantity']);
        }

        // Process cart items
        $cart_items->data_seek(0);
            while ($item = $cart_items->fetch_assoc()) {
                $item_total = $item['price'] * $item['quantity'];
                
                // Insert into orders
                $order_query = "INSERT INTO orders (
                    order_number,
                    user_id,
                    product_id,
                    product_name,
                    price,
                    quantity,
                    total,
                    image_url,
                    payment_id,
                    status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

                $stmt = $con->prepare($order_query);
                $stmt->bind_param(
                    "siisdiiss",
                    $order_number,
                    $user_id,
                    $item['product_id'],
                    $item['product_name'],
                    $item['price'],
                    $item['quantity'],
                    $item_total,
                    $item['image_url'],
                    $payment_ref
                );
                
                if (!$stmt->execute()) {
                    throw new Exception("Failed to create order for product: " . $item['product_name']);
                }

                // Update product stock
                $update_stock = "UPDATE products 
                                SET stock_quantity = stock_quantity - ? 
                                WHERE id = ? AND stock_quantity >= ?";
                $stmt = $con->prepare($update_stock);
                $stmt->bind_param("iii", 
                    $item['quantity'], 
                    $item['product_id'], 
                    $item['quantity']
                );
                
                if (!$stmt->execute()) {
                    throw new Exception("Insufficient stock for product: " . $item['product_name']);
                }
            }
        // Clear cart
        $clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($clear_cart);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    // Insert payment method record
    $payment_method_query = "INSERT INTO payment_methods (user_id, payment_type, payment_number) 
                           VALUES (?, ?, ?) 
                           ON DUPLICATE KEY UPDATE payment_type = VALUES(payment_type)";
    $stmt = $con->prepare($payment_method_query);
    $stmt->bind_param("iss", $user_id, $payment_method, $payment_number);
    $stmt->execute();

    // Commit transaction
    $con->commit();

    // Store payment reference in session
    $_SESSION['payment_ref'] = $payment_ref;
    $_SESSION['order_number'] = $order_number;
    $_SESSION['total_amount'] = $total_amount;

    // Clear direct purchase session if exists
    if (isset($_SESSION['direct_purchase'])) {
        unset($_SESSION['direct_purchase']);
    }

    // Return success response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'redirect' => 'payment-gateway.php',
        'payment_ref' => $payment_ref,
        'order_number' => $order_number
    ]);
    exit();

} catch (Exception $e) {
    // Rollback transaction on error
    $con->rollback();
    
    // Return error response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => "Payment processing failed: " . $e->getMessage()
    ]);
    exit();
}
?>
    