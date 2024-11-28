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
    .favorite-header {
        z-index: 1020; 
    }
    
    .favorites-container {
        margin-top: 180px;
        padding: 0 20px;
        max-width: 1200px; /* Add max-width to control container width */
    }

    .favorites-row {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin: 0;
    }

    .favorites-row .col {
        width: 100%;
        padding: 0; /* Reset padding */
    }

    .favorites-row .product-card {
        background: #fff;
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .favorites-row .image-container {

        width: 200px;
        height: 200px;
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .favorites-row .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .favorites-row .favorite-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        z-index: 2;
        padding: 5px;
        cursor: pointer;
    }

    .favorites-row .favorite-btn i {
        color: #dc3545;
        font-size: 1.2rem;
    }

    .favorites-row .product-details {
        width: 100%;
        padding: 10px;
        text-align: center;
    }

    .favorites-row .product-name {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 5px 0;
        color: #333;
    }

    .favorites-row .product-category,
    .favorites-row .product-variant {
        font-size: 0.8rem;
        color: #666;
        margin: 0;
        line-height: 1.4;
    }

    .favorites-row .product-price {
        font-size: 0.9rem;
        font-weight: 600;
        color: #000;
        margin: 5px 0 0 0;
    }

    @media (max-width: 768px) {
        .favorites-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 992px) {
        .favorites-row {
            grid-template-columns: repeat(5, 1fr);
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
                    <a class="nav-link" href="category-links">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="daily-discoveries">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Favorites</a>
                </li>
            </ul>

            <div class="d-flex align-items-center" id="iconContainer"> 
                <a href="my-account.php" class="login-icon" id="loginIcon">
                    <i class="bi bi-person"></i>
                </a>
                <a href="cart.php" class="cart-icon" id="CartIcon">
                    <i class="bi bi-bag-heart"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Favorite Header -->
<div class="favorite-header py-3 fixed-top" style="top: 110px; background-color: #940202; border-bottom: 1px solid #ddd;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="client-index.php" class="btn btn-link text-black me-1 back-button" style="font-size: 1.25rem; color: black;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: white;">MY FAVORITES</h5>
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

<!-- Favorites Content -->
<div class="container favorites-container" style="margin-top: 180px;">
    <div class="row favorites-row">
        <?php
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM favorites WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
        ?>
            <div class="col">
                <div class="product-card">
                    <div class="image-container">
                        <img src="<?php echo $item['image_url']; ?>" 
                             alt="<?php echo $item['product_name']; ?>">
                        <button class="favorite-btn active">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                    </div>
                    <div class="product-details">
                        <h3 class="product-name"><?php echo $item['product_name']; ?></h3>
                        <p class="product-category">Categories</p>
                        <p class="product-variant">Variant</p>
                        <p class="product-price">₱<?php echo number_format($item['price'], 2); ?></p>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
        ?>
            <div class="col-12 text-center" style="margin-top: 50px;">
                <div class="no-favorites d-flex justify-content-center align-items-center flex-column">
                    <i class="bi bi-heart" style="font-size: 3rem; color: #6c757d;"></i>
                    <p class="mt-3 mb-2">No favorites yet</p>
                    <a href="client-shop.php" class="btn btn-primary">Go Shopping</a>
                </div>
            </div>
        <?php
        }
        ?>
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
<script src="assets/js/shop.js"></script>
</body>
</html>