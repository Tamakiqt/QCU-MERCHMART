<?php
session_start();
include('server/dbcon.php');

// Redirect user to login page if not logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check for payment status from PayMongo
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status === 'success') {
    $paymentMessage = "Your payment was successful. Thank you for your purchase!";
} else {
    $paymentMessage = "There was an issue with your payment. Please try again later.";
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



            

<!-- Banner Section -->
<section class="banner">
    <div class="banner-content">
        <h1>Gear Up <br> Stand Out</h1>
    </div>
    <div class="banner-text">
        <p>Welcome to Merchmart! Your one-stop online destination for all your Quezon City University essentials. From official merchandise like lanyards, uniforms, and foundation shirts to other must-have items, Merchmart is designed to make your shopping experience seamless and hassle-free. With a user-friendly platform, convenient checkout options, and real-time order tracking, we bring campus pride and accessibility to your fingertips. Thank you for choosing Merchmart—where convenience meets university spirit!</p>
        <a href="client-shop.php"><button>Shop Now</button></a>
    </div>
</section>

<!---Featured Products---->

<section class="featured-products mt-5">
    <h2>Featured Products</h2>
    <div class="product-list">
        <div class="product" onclick="showProductPreview(1, 'QCU Lanyard', '70.00', 'assets/images/IMG_0052.PNG')">
            <div class="product-image">
                <img src="assets/images/IMG_0052.PNG" alt="QCU Lanyard">
            </div>
            <hr>
            <p class="price">₱70</p>
            <p class="product-name-first">QCU Lanyard</p>
        </div>

        <div class="product" onclick="showProductPreview(2, 'Tumblers', '280.00', 'assets/images/tumblers.PNG')">
            <div class="product-image">
                <img src="assets/images/tumblers.PNG" alt="Tumblers">
            </div>
            <hr>
            <p class="price">₱280</p>
            <p class="product-name-first">Tumblers</p>
        </div>

        <div class="product" onclick="showProductPreview(3, 'Clips', '40.00', 'assets/images/clip.png')">
            <div class="product-image">
                <img src="assets/images/clip.png" alt="Clips">
            </div>
            <hr>
            <p class="price">₱40</p>
            <p class="product-name-first">Clips</p>
        </div>

        <div class="product" onclick="showProductPreview(4, 'T - Shirts', '250.00', 'assets/images/t-shirt.png')">
            <div class="product-image">
                <img src="assets/images/t-shirt.png" alt="T-Shirts">
            </div>
            <hr>
            <p class="price">₱250</p>
            <p class="product-name-first">T - Shirts</p>
        </div>
    </div>
</section>



<!-- Product Preview Modal -->
<div class="modal fade" id="productPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Item Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <img id="modalProductImage" src="" alt="Product Image" class="img-fluid product-preview-image" style="width: 100%; height: 300px; object-fit: contain; border-radius: 8px;">
        </div>
        <div class="col-md-6">
            <h4 id="modalProductName"></h4>
            <p id="modalProductPrice" class="text-danger fw-bold"></p>
            <div class="quantity-controls d-flex justify-content-center align-items-center mb-3">
                <button type="button" class="quantity-btn" onclick="decreaseQuantity()">-</button>
                <input type="number" id="productQuantity" class="quantity-input" value="1" min="1">
                <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
            </div>
            <button type="button" id="addToCartButton" class="btn btn-danger w-100" onclick="addToCart()">Add to Cart</button>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- Custom Notification -->
<div id="custom-notification" class="notification-container" style="display: none;">
    <div class="notification-content">
        <i class="bi bi-cart"></i>
        <span id="notification-message"></span>
    </div>
</div>




<!-- Daily Discoveries Section -->
<section id="product-list1" class="dailydiscoveries-products mt-5">
    <h2>Daily Discoveries</h2>
    <div class="product-list1">
        <div class="product" onclick="showProductPreview(5, 'QCU ID Lace', '50.00', 'assets/images/bcs.PNG')">
            <div class="product-image">
                <img src="assets/images/IMG_0052.PNG" alt="Product 1">
            </div>
            <hr>
            <p class="price">₱50</p>
            <p class="product-name">QCU ID Lace</p>
        </div>

        <div class="product" onclick="showProductPreview(6, 'QCU PE Uniform', '450.00', 'assets/images/beced.PNG')">
            <div class="product-image">
                <img src="assets/images/beced.PNG" alt="Product 2">
            </div>
            <hr>
            <p class="price">₱450</p>
            <p class="product-name">QCU PE Uniform</p>
        </div>

        <div class="product" onclick="showProductPreview(7, 'QCU Cap', '199.00', 'assets/images/bis.PNG')">
            <div class="product-image">
                <img src="assets/images/bis.PNG" alt="Product 3">
            </div>
            <hr>
            <p class="price">₱199</p>
            <p class="product-name">QCU Cap</p>
        </div>

        <div class="product" onclick="showProductPreview(8, 'QCU Mug', '149.00', 'assets/images/bsa.PNG')">
            <div class="product-image">
                <img src="assets/images/bsa.PNG" alt="Product 4">
            </div>
            <hr>
            <p class="price">₱149</p>
            <p class="product-name">QCU Mug</p>
        </div>
    </div>
</section>






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
                 <img src="assets/images/mayaa.png" alt="Payment Icon" class="img-fluid" style="text-align: center;">
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

function showProductPreview(productId, name, price, image) {
    const modal = document.getElementById('productPreviewModal');
    modal.setAttribute('data-product-id', productId); // Store ID on modal itself
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductPrice').textContent = '₱' + price;
    document.getElementById('modalProductImage').src = image;
    document.getElementById('productQuantity').value = 1;
    
    new bootstrap.Modal(modal).show();
}

function addToCart() {
    const modal = document.getElementById('productPreviewModal');
    const productId = modal.getAttribute('data-product-id'); // Get ID from modal
    const quantity = document.getElementById('productQuantity').value;
    const productName = document.getElementById('modalProductName').textContent;
    const productPrice = document.getElementById('modalProductPrice').textContent.replace('₱', '').trim();
    const productImage = document.getElementById('modalProductImage').src;

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('product_name', productName);
    formData.append('price', productPrice);
    formData.append('quantity', quantity);
    formData.append('image_url', productImage);

    fetch('add-to-cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showNotification(`Added ${quantity} ${productName}(s) to cart`);
        bootstrap.Modal.getInstance(modal).hide();
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to cart');
    });
}

</script>

</body>
</html>