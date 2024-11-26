
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
                    <a class="nav-link" href="category-links">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="daily-discoveries">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
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
                <!-- Products will be dynamically inserted here -->
            </div>
        </div>
        </div>
    </div>
</div>


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