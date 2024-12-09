<?php
session_start();
include('server/dbcon.php');
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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

    .navbar {
        z-index: 1030;
    }

    .cart-header {
        z-index: 1020; 
    }

    .modal-content {
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .btn-danger {
        background-color: #940202;
        border: none;
    }

    .btn-danger:hover {
        background-color: #7a0202;
    }

    .btn-light {
        border: 1px solid #ddd;
    }

    .modal-body h5 {
        font-weight: 500;
    }


    .cart-item1 {
        display: flex;
        align-items: center;
        padding: 20px;
    }

    .product-image-name {
        display: flex;
        align-items: center;
        width: 40%;
    }

    .product-image-name h5 {
        margin-left: 15px;
        font-size: 14px;
    }

    .price-quantity-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 60%;
    }

    .cart-item1 img {
        max-width: 100px;
        margin-right: 20px;
    }

    .quantity-controls1 {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .quantity-controls1 button {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .quantity-controls1 span {
        min-width: 30px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .cart-item1 {
            flex-direction: column;
            padding: 15px !important;
        }

        .product-image-name {
            width: 100%;
            flex-direction: column;
            text-align: center;
            margin-bottom: 15px;
        }

        .product-image-name h5 {
            margin-left: 0;
            margin-top: 10px;
        }

        .price-quantity-controls {
            width: 100%;
            flex-direction: column;
            align-items: center;
        }

        .cart-item1 img {
            max-width: 150px !important;
            margin: 0 auto 10px auto !important;
        }

        .quantity-controls1 {
            margin: 15px 0;
        }

        .cart-summary {
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f3f3f3;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            padding: 15px !important;
        }

        .cart-items {
            margin-bottom: 100px !important;
            padding: 10px;
        }

        .btn-danger {
            width: 100% !important;
            margin-top: 10px;
        }

        .edit-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    }

    @media (max-width: 480px) {
        .cart-item1 h5 {
            font-size: 16px;
        }

        .price-section {
            font-size: 14px;
            text-align: center;
        }

        .cart-summary .d-flex {
            flex-direction: column;
            align-items: stretch !important;
        }

        .total-section {
            margin-bottom: 10px;
            text-align: center;
        }

        #checkoutBtn {
            width: 100%;
        }
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
                    <a class="nav-link" href="aboutus.php">About</a>
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

<!-- Cart Header -->
<div class="cart-header py-3 fixed-top" style="top: 110px; background-color: #940202; border-bottom: 1px solid #ddd;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="client-index.php" class="btn btn-link text-black me-1 back-button" style="font-size: 1.25rem; color: black; margin-left: 10px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: white;">MY CART</h5>
        </div>
    </div>
</div>

<!-- Cart Section -->
<div class="cart-items" id="cartItemsContainer" style="margin-top: 150px;">
    <?php
    $user_id = $_SESSION['user_id'];
    $query = "SELECT 
            c.id,
            c.product_name,
            c.price,
            c.quantity,
            c.total,
            p.image_url  
          FROM cart c
          JOIN products p ON c.product_id = p.id  
          WHERE c.user_id = ?";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;


    if ($result->num_rows > 0) {
        while($item = $result->fetch_assoc()) {
            $total += $item['total'];
    ?>
    <div class="cart-item1 mb-3 p-4 border rounded d-flex align-items-center justify-content-between" id="cartItem-<?php echo $item['id']; ?>" data-item-id="<?php echo $item['id']; ?>">
        <div class="d-flex align-items-center" style="width: 40%;">
            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                 class="img-fluid me-4" 
                 style="max-width: 100px; height: auto;">
            <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($item['product_name']); ?></h5>
        </div>

        <div class="price-section me-4">
            <span class="fw-bold">₱<?php echo number_format($item['price'], 2); ?></span><br>
        </div>

        <div class="quantity-controls1 mx-4">
            <button class="btn btn-sm btn-outline-secondary decrease-button" id="decrease-<?php echo $item['id']; ?>" disabled onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease')">-</button>
            <span id="quantity-<?php echo $item['id']; ?>" class="mx-3 fw-bold">
                <input type="number" id="edit-quantity-<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" style="display: none;" min="1"/>
                <span id="display-quantity-<?php echo $item['id']; ?>" style="display: inline;"><?php echo $item['quantity']; ?></span>
            </span>
            <button class="btn btn-sm btn-outline-secondary increase-button" id="increase-<?php echo $item['id']; ?>" disabled onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase')">+</button>
        </div>

        <button class="btn btn-link edit-button" onclick="toggleEdit(<?php echo $item['id']; ?>)">
            <i class="bi bi-pencil-square ml-3"></i>
        </button>

        <button onclick="showDeleteConfirmation(<?php echo $item['id']; ?>)" class="btn btn-danger btn-sm d-flex justify-content-center align-items-center" style="width: 100px;">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>
    <?php } ?>
    <?php } else { ?>
        <div class="text-center p-5 font-weight-bold">
            <h4>Your cart is empty</h4>
        </div>
    <?php } ?>
</div>

<!-- Cart Summary Section -->
<div class="cart-summary py-4" style="background-color: #f3f3f3;">
    <div class="container-fluid">
        <div class="d-flex justify-content-end">
            <div class="d-flex align-items-right">
                <div class="total-section me-4">
                    <h5 class="mb-0" style="font-weight: bold;">Total: <span class="text-danger">₱<?php echo number_format($total, 2); ?></span></h5>
                </div>
                <button onclick="processPayment(<?php echo $total * 100; ?>)" class="btn px-4" id="checkoutBtn" 
                        style="background-color: #940202; color: white; border: none; font-weight: bold;"
                        <?php echo ($total <= 0) ? 'disabled' : ''; ?>>
                    Checkout (<?php
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
                    ?>)
                </button>
            </div>
        </div>
    </div>
</div> 

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <h5 class="mb-4">Are you sure you want to delete this item?</h5>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-danger px-4" id="confirmDelete" onclick="removeFromCart(<?php echo $item['id']; ?>)">Yes</button>
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">No</button>
                </div>
            </div>
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
function processPayment(amount) {
    const checkoutBtn = document.getElementById('checkoutBtn');
    checkoutBtn.disabled = true;
    checkoutBtn.innerHTML = 'Processing...';

    fetch('http/PaymentController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.checkout_url) {
            // Store current cart state in session storage
            sessionStorage.setItem('pendingPayment', 'true');
            window.location.href = data.checkout_url;
        } else {
            alert('Payment Error: ' + (data.error || 'Unknown error occurred'));
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = 'Checkout';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to process payment. Please try again.');
        checkoutBtn.disabled = false;
        checkoutBtn.innerHTML = 'Checkout';
    });
}
</script>


</body>
</html>


