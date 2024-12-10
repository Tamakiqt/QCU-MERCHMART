<?php
session_start();
require_once '../server/dbcon.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Determine if this is a direct purchase or cart purchase
if (isset($_SESSION['direct_purchase'])) {
    // Calculate total price if not set
    if (!isset($_SESSION['direct_purchase']['total_price'])) {
        $_SESSION['direct_purchase']['total_price'] = 
            floatval($_SESSION['direct_purchase']['price']) * 
            intval($_SESSION['direct_purchase']['quantity']);
    }
    $total = $_SESSION['direct_purchase']['total_price'];
} else {
    // Cart purchase - fetch cart total
    $total_query = "SELECT SUM(c.quantity * p.price) as total 
                    FROM cart c 
                    JOIN products p ON c.product_id = p.id 
                    WHERE c.user_id = ?";
    $stmt = $con->prepare($total_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc()['total'] ?? 0;
}

if (isset($_POST['payment_submit'])) {
    try {
        if (isset($_SESSION['direct_purchase'])) {
            // Process direct purchase
            $product = $_SESSION['direct_purchase'];
            
            // Insert order for direct purchase
            $order_query = "INSERT INTO orders (
                user_id, 
                product_id,
                product_name,
                price,
                quantity,
                total,
                image_url,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
            
            $stmt = $con->prepare($order_query);
            $stmt->bind_param(
                "iisdids",
                $user_id,
                $product['product_id'],
                $product['product_name'],
                $product['price'],
                $product['quantity'],
                $product['total_price'],
                $product['image_url']
            );
            $stmt->execute();
            
            // Clear direct purchase session
            unset($_SESSION['direct_purchase']);
        } else {
            // Process cart purchase
            // Your existing cart processing logic here
        }
        
        // If payment successful
        $_SESSION['payment_success'] = true;
        header("Location: payment-success.php");
        exit();
    } catch (Exception $e) {
        $error = "Payment failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - MerchMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
    .payment-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .order-summary {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f8f9fa;
    }

    .payment-method {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: #940202;
    }

    .payment-method.selected {
        border-color: #940202;
        background-color: #fff5f5;
    }

    .payment-details {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px 12px;
        margin-bottom: 10px;
    }

    .form-control:focus {
        border-color: #940202;
        box-shadow: 0 0 0 0.2rem rgba(148, 2, 2, 0.25);
    }

    .btn-pay {
        background-color: #940202;
        color: white;
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

    .btn-pay:hover {
        background-color: #7a0202;
        color: #fff;
    }

    /* Section headers */
    h3, h5 {
        color: #333;
        margin-bottom: 15px;
    }

    /* Payment method images */
    .payment-method img {
        height: 40px;
        object-fit: contain;
        margin-right: 15px;
    }

    /* Labels */
    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }
</style>

<div class="payment-container">
    <h3 class="mb-4">Payment Details</h3>
    
    <div class="order-summary">
        <h5>Order Summary</h5>
        <div class="d-flex justify-content-between">
            <span>Total Amount:</span>
            <span>₱<?php echo number_format($total, 2); ?></span>
        </div>
    </div>
    <form id="paymentForm" method="POST" onsubmit="return submitPayment(event)">
        <div class="mb-4">
            <h5>Select Payment Method</h5>
            
            <div class="payment-method" onclick="selectPayment('gcash')">
                <input type="radio" name="payment_method" value="gcash" id="gcash" class="d-none">
                <div class="d-flex align-items-center">
                    <img src="../assets/images/gkash.jpg" alt="GCash">
                    <span>GCash</span>
                </div>
            </div>

            <div class="payment-method" onclick="selectPayment('paymaya')">
                <input type="radio" name="payment_method" value="paymaya" id="paymaya" class="d-none">
                <div class="d-flex align-items-center">
                    <img src="../assets/images/maya.jpg" alt="PayMaya">
                    <span>PayMaya</span>
                </div>
            </div>
        </div>

        <div class="payment-details">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>

        <button type="submit" class="btn btn-pay">Pay ₱<?php echo number_format($total, 2); ?></button>
    </form>
</div>

<script>
function selectPayment(method) {
    // Remove selected class from all payment methods
    document.querySelectorAll('.payment-method').forEach(el => {
        el.classList.remove('selected');
    });
    
    // Add selected class to clicked payment method
    document.querySelector(`#${method}`).closest('.payment-method').classList.add('selected');
    
    // Check the radio button
    document.querySelector(`#${method}`).checked = true;
}

function submitPayment(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById('paymentForm'));

    fetch('process-payment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Payment processing failed. Please try again.');
    });

    return false;
}


// Add form validation if needed
document.getElementById('paymentForm').addEventListener('submit', function(event) {
    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (!selectedPayment) {
        alert('Please select a payment method');
        event.preventDefault();
    }
});

function processPayment(formData) {
    fetch('process-payment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing your payment');
    });
}


</script>

</body>
</html>