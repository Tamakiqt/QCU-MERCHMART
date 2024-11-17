<?php
session_start();
require_once('server/dbcon.php');

// Check if user is logged in
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

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
                <li class="nav-item">
                    <a class="nav-link" href="category-links">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="daily-discoveries">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Favorites</a>
                </li>
            </ul>

            <!-- Search Bar -->
            <form class="d-flex search-bar" role="search">
                <input type="search" class="form-control me-2" placeholder="Search" aria-label="Search">
                <i class="fas fa-search"></i>
            </form>

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





<!-- Cart Header -->
<div class="cart-header py-3 fixed-top" style="top: 110px; background-color: #940202; border-bottom: 1px solid #ddd;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Back Button and Title "My Cart" -->
        <div class="d-flex align-items-center">
            <a href="client-index.php" class="btn btn-link text-black me-1 back-button" style="font-size: 1.25rem;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: white;">MY CART</h5>
        </div>
        
        <!-- Edit Button with Icon -->
        <button class="btn btn-link edit-button" aria-label="Edit">
            <i class="bi bi-pencil-square"></i>
        </button>
        </button>
    </div>
</div>



 
<!-- Cart Section -->
<div class="cart-items" id="cartItemsContainer">
    <?php
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM cart WHERE user_id = ?";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;

    while($item = $result->fetch_assoc()) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        ?>
        <div class="cart-item mb-3 p-4 border rounded d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center" style="width: 60%;">
                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                     class="img-fluid me-4" 
                     style="max-width: 100px; height: auto;">
                
                <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($item['product_name']); ?></h5>
            </div>
            
            <div class="price-section me-4">
                <span class="fw-bold">₱<?php echo number_format($subtotal, 2); ?></span>
            </div>
            
            <div class="quantity-controls mx-4">
                <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease')" 
                        class="btn btn-sm btn-outline-secondary">-</button>
                <span class="mx-3 fw-bold"><?php echo $item['quantity']; ?></span>
                <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase')" 
                        class="btn btn-sm btn-outline-secondary">+</button>
            </div>
            
            <button onclick="removeFromCart(<?php echo $item['id']; ?>)" 
                    class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i> Remove
            </button>
        </div>
    <?php } ?>
</div>


    <!-- Cart Summary Section -->
        <div class="cart-summary py-4" style="background-color: #f3f3f3;">
            <div class="container-fluid">
            <div style="margin-right: 50px; display: flex; justify-content: flex-end;">
                    <div class="d-flex align-items-center">
                        <div class="total-section me-4">
                            <h5 class="mb-0" style="font-weight: bold;">Total: <span class="text-danger">₱<?php echo number_format($total, 2); ?></span></h5>
                        </div>
                        <button class="btn px-4" id="checkoutBtn" style="background-color: #940202; color: white; border: none; font-weight: bold;">
                            Checkout
                        </button>
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
</body>
</html>

