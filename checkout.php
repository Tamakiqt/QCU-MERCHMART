<?php
session_start();
include('server/dbcon.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// Fetch user information
$user_id = $_SESSION['user_id'];
$user_query = "SELECT first_name, last_name, email, phone FROM user WHERE id = ?";
$stmt = $con->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();

// Fetch product details from the database
$product_id = $_GET['product_id'];
$product_query = "SELECT product_name, price, image_url FROM products WHERE id = ?";
$stmt = $con->prepare($product_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_data = $stmt->get_result()->fetch_assoc();

error_log('Product data fetched: ' . print_r($product_data, true)); // Debugging log

if (!$product_data) {
    $_SESSION['message'] = "Product not found";
    header("Location: client-shop.php");
    exit();
}

$product = [
    'id' => $product_id,
    'product_name' => $product_data['product_name'],
    'price' => $product_data['price'],
    'image_url' => $product_data['image_url']
];

$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
$total_amount = floatval($product['price']) * $quantity;

// Set the pending order in the session before processing payment
$_SESSION['pending_order'] = [
    'order_number' => uniqid(),
    'user_id' => $user_id,
    'product_id' => $product['id'],
    'product_name' => $product['product_name'],
    'price' => $product['price'],
    'quantity' => $quantity,
    'total' => $total_amount,
    'image_url' => $product['image_url'],
    'status' => 'pending'
];

// Debugging log
error_log('Pending order set: ' . print_r($_SESSION['pending_order'], true));
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCU Merchmart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<style>
        html {
            scroll-behavior: smooth;
        }

        .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border: 3px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .btn-loading {
        position: relative;
        cursor: not-allowed;
        opacity: 0.8;
    }

    hr {
        border: none;
        height: 1px;
        background-color: #dee2e6;  /* Bootstrap's default border color */
        opacity: 1;
        margin: 1.5rem 0;
        width: 100%;
        display: block;
    }

    /* If you want a stronger line */
    hr.strong {
        height: 3px;
        background-color: #000;
    }


    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border: 3px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .btn-loading {
        position: relative;
        cursor: not-allowed;
        opacity: 0.8;
    }


    </style>


<!-- Top Header -->
<div class="top-header py-2 text-white bg-back text-center fixed-top">
    <p class="mb-0">QCU Coop Online Shopping Site</p>
</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-2 fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-text">
                <span class="text-blue">M</span><span class="text-black">ERCH</span><span class="text-red">M</span><span class="text-yellow">ART</span>
            </span>
        </a>

        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav-links">
                <li class="nav-item">
                    <a class="nav-link" href="client-index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-favorite.php">Favorites</a>
                </li>
            </ul>

            <div class="d-flex align-items-center" id="iconContainer"> 
                <a href="my-account.php" class="login-icon" id="loginIcon">
                    <i class="bi bi-person"></i>
                </a>
                <a href="cart.php" class="cart-icon position-relative" id="CartIcon">
                    <i class="bi bi-bag-heart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                        <?php
                        if(isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            $count_query = "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?";
                            $stmt = $con->prepare($count_query);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $count = $result->fetch_assoc()['total'] ?? 0;
                            echo $count;
                        } else {
                            echo "0";
                        }
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content with Top Margin -->
<div class="container-fluid" style="margin-top: 180px; margin-bottom: 50px; max-width: 1200px; padding: 0 30px;">
        <div class="card shadow">
            <div class="card-body p-5">
                <!-- Order Summary Section -->
                <h5 class="card-title mb-4 fs-4">Order Summary</h5>
                <hr class="strong">
                <div class="row align-items-center mb-4">
                    <div class="col-md-3">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>" 
                             class="img-fluid" style="max-width: 150px;">
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2 fs-5"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                            </div>
                            <div class="text-end">
                                    <p class="mb-2">Quantity: <?php echo $quantity; ?></p>
                                    <p class="mb-1">Price per item: ₱<?php echo number_format($product['price'], 2); ?></p>
                                    <p class="mb-0">Item Subtotal: ₱<?php echo number_format($total_amount, 2); ?></p>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="strong">

                 <!-- Billing Information Section -->
                 <h5 class="card-title mb-4 fs-4">Billing Information</h5>
                <div class="mb-4 ps-3">
                    <p class="mb-3"><strong>Full Name:</strong> <?php echo htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']); ?></p>
                    <p class="mb-3"><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
                    <p class="mb-0"><strong>Phone:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></p>
                </div>
                <hr class="strong">

                      <!-- Payment Information Section -->
                      <h5 class="card-title mb-4 fs-4">Payment Information</h5>
                <div class="mb-4 ps-3">
                    <p class="mb-3"><strong>Payment Method:</strong> PayMongo (GCash/Maya)</p>
                    <p class="mb-0"><strong>Total to Pay:</strong> ₱<?php echo number_format($total_amount, 2); ?></p>
                </div>
                <hr class="strong">

                <!-- Total and Place Order Button -->
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <h5 class="mb-0 fs-4">Total Amount: ₱<?php echo number_format($total_amount, 2); ?></h5>
                    <button onclick="processPayment()" class="btn btn-danger btn-lg px-5" id="paymentButton">
                        PROCEED TO PAYMENT
                    </button>

                
                    
                    <!-- Thank You Message -->
                    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                        <div class="alert alert-success mt-3">
                            Thank you for your purchase! Your order has been successfully processed.
                        </div>
                    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'failure'): ?>
                        <div class="alert alert-danger mt-3">
                            There was an issue processing your payment. Please try again.
                        </div>
                    <?php endif; ?>
                </div>

                

                </div>
            </div>
        </div>
    </div>



<!-- Checkout Header -->
<div class="checkout-header py-3 fixed-top" style="top: 110px; background-color: #940202; border-bottom: 1px solid #ddd;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="client-index.php" class="btn btn-link text-black me-1 back-button" style="font-size: 1.25rem; color: black; margin-left: 10px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: white;">ORDER REVIEW & CHECKOUT</h5>
        </div>
    </div>
</div>

<!----FOOTER------>
<footer class="mt-5 py-5">
    <div class="row">
    <div class="footer-one col-lg-3 col-md-6 col-sm-12">
    <h5 class="pb-2">CUSTOMER SERVICE</h5>
    <ul class="list-unstyled">
        <li><a href="help-center.html">Help Center</a></li>
        <li><a href="payment-method.html">Payment Method</a></li>
    </ul>    
</div>


        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">ABOUT MerchMart</h5>
          <ul class="list-unstyled">
             <li><a href="#">About us</a></li>
             <li><a href="#">Privacy Policy</a></li>
          </ul>    
        </div>

        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
         <h5 class="pb-2">PAYMENT</h5>
            <ul class="list-unstyled">
                <li>
                 <img src="assets/images/gkash.jpg" alt="Payment Icon" class="img-fluid" style="text-align: center;">
                </li>
            </ul>   
        </div>

        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">FOLLOW US</h5>
        <div class="social-icons">
        <a href="https://www.facebook.com" target="_blank">
            <img src="assets/images/facebook.png" alt="Facebook" class="social-icon">
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <img src="assets/images/instagram.png" alt="Instagram" class="social-icon">
        </a>
        <a href="https://www.twitter.com" target="_blank">
            <img src="assets/images/twitter.png" alt="Twitter" class="social-icon">
        </a>
    </div>   
        </div>

        <hr class="footer-hr">
            <div class="text-center py-3">
                <p class="mb-0 text-white-50">&copy; MERCHMART ALL RIGHTS RESERVED 2024</p>
            </div>

    </div>
</footer>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>

<script>


function processPayment() {
    const paymentButton = document.getElementById('paymentButton');
    paymentButton.disabled = true;
    paymentButton.classList.add('btn-loading');
    paymentButton.innerHTML = '<span class="spinner"></span>Processing Payment...';

    const amount = <?php echo $total_amount * 100; ?>; // Amount in cents

    fetch('http://localhost:8000/http/PaymentController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ amount })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.checkout_url) {
            window.open(data.checkout_url, '_blank');
        } else {
            throw new Error('Payment initiation failed: ' + (data.error || 'Unknown error'));
        }
    })

    .catch(error => {
        console.error('Payment error:', error);
        alert('Error processing payment: ' + error.message);
        paymentButton.disabled = false;
        paymentButton.classList.remove('btn-loading');
        paymentButton.innerHTML = 'PROCEED TO PAYMENT';
    });

    
}




</script>


</body>
</html>