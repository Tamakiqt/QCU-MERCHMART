<?php
session_start();
include('server/dbcon.php');  // Ensure session is started at the beginning
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
           
        .row>* {
            padding-left: 0;
 
        }   
        .nav-link {
            margin-bottom: 5px;
            text-align: left;
        }

       /*Arrow with style and hover */

        .nav-link-arrow {
            position: relative;
            padding-left: 20px; 
            cursor: pointer;
            color: #000;  
            transition: color 0.3s ease;  
        }

       
        .nav-link-arrow::before {
            content: "";
            position: absolute;
            left: 5px; 
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid #940202; 
            opacity: 0;  
            transition: opacity 0.3s ease;  
        }

       
        .nav-link-arrow:hover::before {
            opacity: 1; 
        }

     
        .nav-link-arrow:hover {
            color: #940202 !important;  
        }



        .mb-5 {
             margin-bottom: 0 !important; */
           }

        .btn-danger.custom-hover:hover {
        background-color: #940202 !important; 
         }

         .p-5 {
             padding: 0 !important; */
            }
 

            @media (min-width: 768px) {
            .col-md-3 {
                flex: 0 0 auto;
                width: 25%;
            }
        }
        </style>

</head>
<body>

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
                <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Daily Discoveries</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Favorites</a></li>
            </ul>
            <form class="d-flex search-bar" role="search">
                <input type="search" class="form-control me-2" placeholder="Search" aria-label="Search">
                <i class="fas fa-search"></i>
            </form>
            <div class="d-flex align-items-center" id="iconContainer"> 
                <a href="login.html" class="login-icon" id="loginIcon"><i class="bi bi-person"></i></a>
                <a href="cart.html" class="cart-icon" id="CartIcon">
                    <i class="bi bi-bag-heart"></i>
                </a>
            </div>
        </div>
    </div>
</nav>


<!-- My account Header -->
<div class="myaccount-header py-3 fixed-top" style="top: 110px; background-color: #940202; border-bottom: 1px solid #ddd;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Back Button and Title "My Cart" -->
        <div class="d-flex align-items-center">
            <a href="client-index.php" class="btn btn-link text-black me-1 back-button" style="font-size: 1.25rem;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: white;">Edit Profile</h5>
        </div>
    </div>
</div>          

        <!-- My Account Section -->
<div class="container-fluid mt-5 pt-5" style="margin-top: 160px; ">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3" style="background-color: #F1E8E8;padding: 30px;">
            <h6 class="fw-bold mb-4" style="font-family: 'Poppins', sans-serif;">My Account</h6>
            <ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link active text-dark nav-link-arrow" href="my-account.php" style="font-size: 1.1rem;">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark nav-link-arrow" href="account-setting.php" style="font-size: 1.1rem;">Account Setting</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark nav-link-arrow" href="notification-preference.php" style="font-size: 1.1rem;">Notification Preference</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark nav-link-arrow" href="order-history.php" style="font-size: 1.1rem;">Order History</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark nav-link-arrow" href="login.php" style="font-size: 1.1rem;">Log Out</a>
    </li>
</ul>

        </div>

        <!-- Profile Content -->
        <div class="col-md-9">
            <div class="card border-0">
                <div class="card-header text-black text-left py-4">
                <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; color: black; font-weight: bold; text-align: left;">My Profile</h5>
                    <small>Manage and protect your account</small>
                </div>
                <div class="card-body p-10 m-2 ">
    <div class="text-center mb-4">
        <label for="file-upload" class="profile-icon" style="cursor: pointer; position: relative; display: inline-block;">
            <!-- Default Profile Icon -->
            <i id="default-icon" class="bi bi-person-circle" style="font-size: 5rem; color: #6c757d;"></i>

            <!-- Upload Image File (Hidden) -->
            <input type="file" id="file-upload" style="display:none" accept="image/*" onchange="updateProfileImage(event)">
            
            <!-- Image will be positioned directly on top of the icon -->
            <img id="profile-image" src="" alt="Profile Picture" style="display:none;  top: 0; left: 0; width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
        </label>
    </div>
</div>


                        <form class="text-center">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Full name" 
                                style="border-radius: 10px; border-width: 1px; border-color: #fffff; width: 50%; margin: 0 auto;">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email" 
                                style="border-radius: 10px; border-width: 1px; border-color: #fffff; width: 50%; margin: 0 auto;">
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control" placeholder="Phone" 
                                style="border-radius: 10px; border-width: 1px; border-color: #fffff; width: 50%; margin: 0 auto;">
                        </div>
                        <button type="submit" class="btn btn-danger custom-hover" 
                                style="border-radius: 10px; width: 50%; margin: 0 auto;">Save Changes</button>
                    </form>
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
             <ul class="list-unstyled d-flex gap-2">
                <li><a href="#" class="footer-link text-white-50"><i class="bi bi-facebook"></i></a></li>
                <li><a href="#" class="footer-link text-white-50"><i class="bi bi-twitter"></i></a></li>
                <li><a href="#" class="footer-link text-white-50"><i class="bi bi-instagram"></i></a></li>
             </ul>   
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
// Check if the user is logged in by checking the PHP session
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
        
        function showNotification(message) {
            const notification = document.getElementById('custom-notification');
            const messageElement = document.getElementById('notification-message');
            messageElement.textContent = message;
            notification.style.display = 'block';
            
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        function addToCart() {
            if (!isLoggedIn) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('productPreviewModal'));
                modal.hide();
                
                showNotification('Please login to add items to cart');
                
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
                return;
            }

            const quantity = document.getElementById('productQuantity').value;
            const productName = document.getElementById('modalProductName').textContent;

            showNotification(`Added ${quantity} ${productName}(s) to cart`);
            const modal = bootstrap.Modal.getInstance(document.getElementById('productPreviewModal'));
            modal.hide();
        }

        function showProductPreview(productId, name, price, imageUrl) {
            const modal = new bootstrap.Modal(document.getElementById('productPreviewModal'));
            
            document.getElementById('modalProductName').textContent = name;
            document.getElementById('modalProductPrice').textContent = `₱${price}`;
            document.getElementById('modalProductImage').src = imageUrl;
            document.getElementById('productQuantity').value = 1;
            
            modal.show();
        }

        function increaseQuantity() {
            const quantityInput = document.getElementById('productQuantity');
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('productQuantity');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        }
    </script>
</body>
</html>



