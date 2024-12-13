<?php
session_start();
require_once '../server/dbcon.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

if (!isset($_SESSION['payment_success'])) {
    header("Location: payment.php");
    exit();
}

$order_number = $_SESSION['order_number'] ?? '';

// Clear session variables
unset($_SESSION['payment_success']);
unset($_SESSION['order_number']);

// Fetch user's name and email from session or database if needed
$user_name = $_SESSION['user_name'] ?? '';  
$user_email = $_SESSION['user_email'] ?? '';  

// Fetch order details from the database
$query = "SELECT product_name, price, quantity, image_url, total 
          FROM orders 
          WHERE order_number = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $order_number);
$stmt->execute();
$result = $stmt->get_result();

// Initialize a variable to store product details
$products_html = '';

// Fetch product details and format them
while ($row = $result->fetch_assoc()) {
    $products_html .= "<tr>
                        <td>{$row['product_name']}</td>
                        <td>₱" . number_format($row['price'], 2) . "</td>
                        <td>{$row['quantity']}</td>
                        <td>₱" . number_format($row['total'], 2) . "</td>
                        <td><img src='" . $row['image_url'] . "' alt='{$row['product_name']}' width='50' /></td>
                      </tr>";
}

// Function to send the payment receipt email
function sendPaymentReceipt($name, $email, $order_number, $total_amount, $products_html) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;  
        $mail->Username = 'qcumerchmart@gmail.com'; 
        $mail->Password = 'dfjo ldol zadv wpkf';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('qcumerchmart@gmail.com', 'QCUMerchMart'); 
        $mail->addAddress($email, $name);  

        // Email Content
        $mail->isHTML(true);  
        $mail->Subject = 'Your Payment Receipt - MerchMart';

        // HTML email body
$mail->Body = "
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fc;
            color: #333;
        }
        .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #940202;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            color: white;
            font-size: 24px;
        }
        .content {
            margin-top: 30px;
        }
        .content h2 {
            font-size: 18px;
            color: #333;
        }
        .content p {
            font-size: 14px;
            line-height: 1.5;
            color: #555;
        }
        .amount {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
        }
        .details-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 10px;
            text-align: left;
        }
        .details-table th {
            background-color: #f1f1f1;
            color: #333;
        }
        .details-table td {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
        .footer img {
            max-width: 100px; /* Adjust logo size */
            margin-bottom: 10px;
        }
        .footer p {
            margin: 5px 0;
        }
        .product-image {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Your receipt from QCU MERCHMART</h1>
            <p>Order number #$order_number</p>
        </div>

        <div class='content'>
            <h2>Hi $name,</h2>
            <p>Thank you for your payment. Here's a copy of your receipt:</p>

            <p class='amount'>₱" . number_format($total_amount, 2) . "</p>

            <table class='details-table'>
                <tr>
                    <th>Amount paid</th>
                    <td>₱" . number_format($total_amount, 2) . "</td>
                </tr>
                <tr>
                    <th>Transaction description</th>
                    <td>Payment for order</td>
                </tr>
                <tr>
                    <th>Billed to</th>
                    <td>$name</td>
                </tr>
                <tr>
                    <th>Payment method</th>
                    <td>GCash</td>
                </tr>
                <tr>
                    <th>Date paid</th>
                    <td>" . date('F d, Y') . "</td>
                </tr>
            </table>

            <h3>Purchased Products</h3>
            <p>Here are the items you bought:</p>
            <table class='details-table'>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Image</th>
                </tr>
                $products_html
            </table>

            <p>If you have any questions about this payment, contact QCU MERCHMART at <a href='mailto:qcumerchmart@gmail.com'>qcumerchmart@gmail.com</a>.</p>
        </div>

        <div class='footer'>
            <img src='https://i.imgur.com/4mdyHNQ.png' alt='QCU MerchMart Logo' />
            <p>&copy; " . date('Y') . " QCU MerchMart. All rights reserved.</p>
            <p>Follow us on <a href='https://www.instagram.com/qcumerchmart' target='_blank'>Instagram</a> and <a href='https://www.facebook.com/qcumerchmart' target='_blank'>Facebook</a>.</p>
        </div>
    </div>
</body>
</html>";


        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Fetch total amount for the order
$total_amount_query = "SELECT SUM(total) as total_amount FROM orders WHERE order_number = ?";
$total_stmt = $con->prepare($total_amount_query);
$total_stmt->bind_param("s", $order_number);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_amount = 0;
if ($total_row = $total_result->fetch_assoc()) {
    $total_amount = $total_row['total_amount'];
}

// Send the payment receipt email
sendPaymentReceipt($user_name, $user_email, $order_number, $total_amount, $products_html);

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