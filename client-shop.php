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

        /* Quantity controls */
        .quantity-controls {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
            height: 39px;
        }

        .quantity-btn {
            border: none;
            background: white;
            padding: 0 12px;
            font-size: 16px;
            height: 100%;
            color: #000;
        }

        .quantity-input {
            border: none;
            width: 60px;
            height: 100%;
            text-align: center;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-radius: 0;
            padding: 0;
        }

        /* Text styles */
        .text-muted {
            color: #6c757d !important;
            font-size: 14px;
        }

        /* Action buttons */
        .action-btn {
            height: 40px;
            border-radius: 4px;
            font-weight: normal;
        }

        .add-cart {
            border: 1px solid #dee2e6;
            background: white;
            color: black;
        }

        .buy-now {
            background: #dc3545;
            color: white;
            border: none;
        }

        .add-to-favorites {
            border: 1px solid #dee2e6;
            background: white;
            color: black;
        }

        .add-to-favorites:hover {
            background-color: #940202; 
            color: #fff; 
        }

        /* Remove spinners from number input */
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
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
    </div>
</nav>

<!-- Shop Section -->
<div class="container-fluid mt-5 pt-5">
    <div class="row">
        <!-- Categories Sidebar -->
        <div class="col-lg-2 col-md-3">
            <div class="shop-sidebar">
                <div class="categories-section">
                <h5 class="categories-header">
                    <a href="shop.php" style="text-decoration: none; color: inherit;">
                        <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                    </a>
                    All Categories
                </h5>
                    <ul class="category-menu">
                        <li class="category-item">
                            <a href="#" class="category-link" data-category="uniforms">School Uniforms</a>
                            <ul class="subcategory-menu">
                                <li><a href="#" data-category="lace">QCU Lanyards</a></li>
                                <li><a href="#" data-category="college">QCU School Uniform</a></li>
                                <li><a href="#" data-category="pe">QCU P.E Uniformm</a></li>
                                <li><a href="#" data-category="jackets">QCU Jackets</a></li>
                                <li><a href="#" data-category="department">Department Shirts</a></li>
                                <li><a href="#" data-category="shirts">QCU T-Shirts</a></li>
                                <li><a href="#" data-category="holder">QCU ID Holder</a></li>
                            </ul>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link" data-category="supplies">School Necessities</a>
                            <ul class="subcategory-menu">
                                <li><a href="#" data-category="clip">Hair Clips</a></li>
                                <li><a href="#" data-category="clutcher">Hair Clutchers</a></li>
                                <li><a href="#" data-category="tumblers">Tumblers</a></li>
                                <li><a href="#" data-category="tissue">Tissue Paper</a></li>
                                <li><a href="#" data-category="umbrella">Umbrella</a></li>
                                <li><a href="#" data-category="wipes">Wet Wipes</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- Filter Section -->
                <div class="filter-section mt-4">
                    <h5>SEARCH FILTER</h5>
                    <div class="price-range mt-3">
                        <h6>Price Range</h6>
                        <div class="price-inputs d-flex gap-2">
                            <input type="number" class="form-control" placeholder="Min">
                            <input type="number" class="form-control" placeholder="Max">
                        </div>
                        <button class="btn btn-outline-primary mt-2 w-100">APPLY</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Products Grid -->
        <div class="col-lg-10 col-md-9">
     

                    <!--Sort--->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="sort-section">
                    Sort by: 
                    <select id="sortSelect" class="form-select d-inline-block w-auto ms-2">
                        <option value="popular">Popular</option>
                        <option value="latest">Latest</option>
                        <option value="topSales">Top Sales</option>
                        <option value="priceLow">Price: Low to High</option>
                        <option value="priceHigh">Price: High to Low</option>
                    </select>
                </div>

                <!-- Search Bar -->
                <div class="shop-search-bar">
                    <input type="search" 
                     id="searchInput"
                        class="form-control" 
                        placeholder="Search" 
                        aria-label="Search">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <!-- Products Grid -->
<div class="row row-cols-md-3 row-cols-lg-5 g-3" id="products-container">
    <?php
    $query = "SELECT * FROM products";
    $result = $con->query($query);
    
    while($product = $result->fetch_assoc()) {
    ?>
        <div class="col">
            <div class="product-card">
                <div class="image-container">
                    <img src="<?php echo $product['image_url']; ?>" 
                         alt="<?php echo $product['product_name']; ?>">
                    <button class="favorite-btn" onclick="toggleFavorite(<?php echo $product['id']; ?>)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
                <div class="product-details">
                    <h3 class="product-name"><?php echo $product['product_name']; ?></h3>
                    <p class="product-price">₱<?php echo number_format($product['price'], 2); ?></p>
                    <button class="btn btn-primary add-cart-btn" 
                            onclick="addToCart(
                                <?php echo $product['id']; ?>, 
                                '<?php echo addslashes($product['product_name']); ?>', 
                                '₱<?php echo number_format($product['price'], 2); ?>', 
                                '<?php echo $product['image_url']; ?>'
                            )">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    <?php 
    }
    ?>
</div>
            </div>
        </div>
        </div>
    </div>
</div>


<!-- Product Preview Modal -->
<div class="modal fade" id="productPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Product View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-header-border" style="border-bottom: 1px solid #dee2e6; margin: 0 10px;"></div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Main Product Image -->
                        <div class="main-image-container mb-3">
                            <img id="modalProductImage" src="" alt="Product Image" class="img-fluid product-preview-image">
                            <button class="favorite-btn" onclick="toggleFavorite()">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 id="modalProductName" class="mb-3 text-danger"></h4>
                        <p id="modalProductDescription" class="text-muted small mb-3"></p>
                        <p id="modalProductPrice" class="text-danger fw-bold fs-4 mb-4"></p>
                        
                        <!-- Size Selection -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label class="mb-0" style="min-width: 45px;">Size</label>
                                <div class="size-options d-flex gap-2">
                                    <button class="size-btn">S</button>
                                    <button class="size-btn active">M</button>
                                    <button class="size-btn">L</button>
                                    <button class="size-btn">XL</button>
                                </div>
                            </div>
                        </div>

                        <!-- Variant Selection -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label class="mb-0" style="min-width: 60px;">Variant</label>
                                <select class="form-select w-auto">
                                    <option>Select</option>
                                </select>
                            </div>
                        </div>

                        <!-- Quantity Selection -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label class="mb-0" style="min-width: 60px;">Quantity</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="quantity-controls d-flex align-items-center">
                                        <button type="button" class="btn quantity-btn" onclick="decreaseQuantity()">-</button>
                                        <input type="number" id="productQuantity" class="form-control quantity-input" value="1" min="1">
                                        <button type="button" class="btn quantity-btn" onclick="increaseQuantity()">+</button>
                                    </div>
                                    <span class="text-muted">Stocks: <span id="modalProductStock">20</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <div class="d-flex gap-2 mb-2">
                                <!-- Replace the existing button with this -->
                                <button type="button" class="btn flex-grow-1 action-btn add-cart" 
                                    onclick='addToCart({
                                        id: document.getElementById("productPreviewModal").getAttribute("data-product-id"),
                                        name: document.getElementById("modalProductName").textContent,
                                        price: document.getElementById("modalProductPrice").textContent.replace("₱", "").trim(),
                                        image: document.getElementById("modalProductImage").src,
                                        quantity: parseInt(document.getElementById("productQuantity").value)
                                    })'>
                                Add to cart
                            </button>                                <button type="button" class="btn flex-grow-1 action-btn buy-now">Buy Now</button>
                            </div>
                            <button type="button" class="btn btn-outline-secondary add-to-favorites mt-2 w-100" onclick="addToFavorites()">
                                &#9829; Add to Favorites
                            </button>
                        </div>
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
<script src="assets/js/shop.js"></script>
</body>
</html>