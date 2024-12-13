<?php
session_start();
require_once '../server/dbcon.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Initialize variables
$payment_ref = $_SESSION['payment_ref'] ?? null;
$order_number = $_SESSION['order_number'] ?? null;
$total_amount = $_SESSION['total_amount'] ?? 0;

// If essential variables are missing, redirect to cart
if (!$payment_ref || !$order_number || !$total_amount) {
    header('Location: ../cart.php');
    exit();
}

// Format total amount
$total_amount = number_format($total_amount, 2, '.', '');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway - MerchMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .gateway-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .payment-status {
            margin: 30px 0;
            padding: 20px;
            border-radius: 8px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        .timer {
            font-size: 24px;
            color: #940202;
            margin: 20px 0;
            font-weight: bold;
        }

        .qr-code {
            width: 200px;
            height: 200px;
            margin: 20px auto;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: white;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .payment-info {
            text-align: center;
            margin: 20px 0;
        }

        .payment-ref {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            margin: 10px 0;
        }

        .btn-action {
            width: 200px;
            margin: 5px;
        }

        .timer-container {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
            text-align: center;
            margin: 10px 0;
        }

        #timer {
            font-family: monospace;
        }
    </style>
</head>
<body>

<div class="gateway-container">
    <h3 class="text-center mb-4">Complete Your Payment</h3>
    
    <div class="payment-status">
        <div class="payment-info">
            <h5>Amount to Pay</h5>
            <h3 class="text-danger">₱<?php echo number_format($total_amount, 2); ?></h3>
            <p class="mb-2">Order Number: <span class="payment-ref"><?php echo $order_number; ?></span></p>
            <p>Payment Reference: <span class="payment-ref"><?php echo $payment_ref; ?></span></p>
        </div>

        <div class="text-center">
            <div class="timer" id="timer">15:00</div>
            
            <div class="qr-code">
                <img src="../assets/images/gkashko.jpg" alt="QR Code">
            </div>
            <p class="text-muted">Scan this QR code using your payment app</p>
        </div>
    </div>

    <div class="text-center mt-4">
    <button onclick="submitPayment(event)" class="btn btn-success btn-action">
    Simulate Payment
</button>
        <button onclick="cancelPayment()" class="btn btn-danger btn-action">
            Cancel Payment
        </button>
    </div>
</div>

<script>
function submitPayment(event) {
    event.preventDefault();
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = 'Processing...';

    // Create form data
    const formData = new FormData();
    formData.append('payment_ref', '<?php echo $payment_ref; ?>');
    formData.append('order_number', '<?php echo $order_number; ?>');
    formData.append('total_amount', '<?php echo $total_amount; ?>');

    // Send payment confirmation
    fetch('process-payment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'payment-success.php';  
        } else {
            throw new Error(data.message || 'Payment processing failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Payment processing failed. Please try again.');
        
        // Reset button state
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

function cancelPayment() {
    window.location.href = "../client-shop.php";  
}

function startTimer(duration) {
    let timer = duration;
    const timerDisplay = document.getElementById('timer');
    
    const countdown = setInterval(function () {
        const minutes = Math.floor(timer / 60);
        const seconds = timer % 60;

        // Add leading zeros if needed
        const displayMinutes = minutes < 10 ? "0" + minutes : minutes;
        const displaySeconds = seconds < 10 ? "0" + seconds : seconds;
        
        // Update the display
        timerDisplay.textContent = displayMinutes + ":" + displaySeconds;

        // Decrease timer
        if (--timer < 0) {
            clearInterval(countdown);
            window.location.href = 'payment.php'; 
        }
    }, 1000);
}

// Start the timer when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // 15 minutes = 15 * 60 seconds = 900 seconds
    startTimer(900);
});


</script>
</body>
</html>