
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
                    <a class="nav-link" href="#">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Daily Discoveries</a>
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
                <a href="login.html" class="login-icon" id="loginIcon">
                    <i class="bi bi-person"></i>
                </a>
                <a href="cart.html" class="cart-icon" id="CartIcon">
                    <i class="bi bi-bag-heart"></i>
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
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias molestias ex eaque voluptates, porro perferendis voluptatum harum, ipsum maiores maxime modi ad culpa autem reiciendis praesentium quae recusandae, accusantium inventore?</p>
        <button>Shop Now</button>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products mt-5">
    <h2>Featured Products</h2>
    <div class="product-list">
        <div class="product">
            <img src="product1.jpg" alt="Product 1">
            <h3>Product 1</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
        <div class="product">
            <img src="product2.jpg" alt="Product 2">
            <h3>Product 2</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
        <div class="product">
            <img src="product3.jpg" alt="Product 3">
            <h3>Product 3</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
        <div class="product">
            <img src="product4.jpg" alt="Product 4">
            <h3>Product 4</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="category my-5">
    <h2>Categories</h2>
    <div class="category-links">
        <a href="lanyard.html">Lanyards</a>
        <a href="#">Uniforms</a>
        <a href="#">Jackets</a>
        <a href="#">Umbrella</a>
        <a href="#">Tumbler</a>
        <a href="#">T-shirts</a>
        <a href="#">Accessories</a>
    </div>
</section>

<!-- Daily Dicoveries Section -->
<section class="dailydiscoveries-products">
    <h2>Daily Discoveries</h2>
    <div class="product-list1">
        <div class="product">
            <img src="product7.jpg" alt="Product 4">
            <h3>Product 1</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
        <div class="product">
            <img src="product8.jpg" alt="Product 5">
            <h3>Product 2</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
        <div class="product">
            <img src="product9.jpg" alt="Product 6">
            <h3>Product 3</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
        <div class="product">
            <img src="product10.jpg" alt="Product 4">
            <h3>Product 4</h3>
            <p>Category</p>
            <p>Price</p>
        </div>
    </div>
</section>




<!----FOOTER------>
<footer class="mt-5 py-5 footer">
    <div class="row">
        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">About us</h5>
            <p>Our company is committed to providing top-quality products and excellent customer service.</p>
        </div>
        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Contact Us</h5>
            <p>Our companu is committed, Feel free to reach out to us via email or phone for any inquiries.</p>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>
</body>
</html>