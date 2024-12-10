<?php
session_start();
require_once '../server/dbcon.php';

if (!isset($_SESSION['payment_success'])) {
    header("Location: payment.php");
    exit();
}

$order_number = $_SESSION['order_number'] ?? '';

// Clear session variables
unset($_SESSION['payment_success']);
unset($_SESSION['order_number']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success - MerchMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container text-center py-5">
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h2 class="text-success mb-4">Payment Successful!</h2>
                <p>Your order number: <?php echo htmlspecialchars($order_number); ?></p>
                <p>Your order is now ready for pickup!</p>
                <a href="../my-account.php?tab=order-history" class="btn btn-primary">View Orders</a>
            </div>
        </div>
    </div>
</body>
</html>