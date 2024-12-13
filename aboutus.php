<?php
session_start();
require_once 'server/dbcon.php';  // Make sure this path is correct

// Simple session check
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
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
                    <a class="nav-link" href="client-favorites.php">Favorites</a>
                </li>
            </ul>



            <div class="d-flex align-items-center" id="iconContainer"> 
                <a href="login.php" class="login-icon" id="loginIcon">
                    <i class="bi bi-person"></i>
                </a>
            </div>
        </div>
    </div>
</nav>


<div class="about-header" style="background-color: #940202;">
    <h3 class="text-center text-white letter-spaced">LEARN   ABOUT  OUR  GROUP</h3>
    </div>
    <div class="container2">
        <h2 class="text-center">About us</h2>
        <p class="text-center about-text">
            Welcome to MerchMart! Your online source for all school supplies! We provide a wide range of quality items for teachers, students, and <br>faculty. MerchMart was created to support education by providing easy access to school supplies. We're proud to serve students, <br> teachers, and faculty members, ensuring you have the things you need.
        </p>
        <hr class="about-divider">
    </div> 
</section>




<section class="team-section container my-2"></section>
    <h2 class="text-center mb-5" style="font-weight: bold;">Meet the team</h2>
    
    <div class="row justify-content-center">
        <!-- Team Member 1 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/alcaide.jpeg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">ALCAIDE, FRANC</h5>
                <p class="member-position">UI Designer & Programmer</p>
            </div>
        </div>

        <!-- Team Member 2 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/galile.jpeg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">CAMINO, GAILEE</h5>
                <p class="member-position">Researcher & Treasurer</p>
            </div>
        </div>

         <!-- Team Member 3 -->
         <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/dom.jpg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">DOMINGO, JOSHUA</h5>
                <p class="member-position">UI Designer & Researcher</p>
            </div>
        </div>

         <!-- Team Member 4 -->
         <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/lawi.jpg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">LAWI, ALNOR</h5>
                <p class="member-position">Database & Documatation</p>
            </div>
        </div>

        <!-- Team Member 5 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/me.png" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">NUEVO, ADAM</h5>
                <p class="member-position">Programmer & Database Holder</p>
            </div>
        </div>


        <!-- Team Member 6 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/genrev.jpeg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">ORDONIO, GENREV</h5>
                <p class="member-position">Programmer 2</p>
            </div>
        </div>

        <!-- Team Member 7 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/panes.jpg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">PANES, ANGELO</h5>
                <p class="member-position">Database Holder</p>
            </div>
        </div>

        <!-- Team Member 8 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/paraiso.png" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">PARAISO, MARY FAYE</h5>
                <p class="member-position">Project Manager</p>
            </div>
        </div>

        <!-- Team Member 9 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/sabudin.jpeg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">SABUDIN, HANNAH</h5>
                <p class="member-position">Secretary & Documatation</p>
            </div>
        </div>

        <!-- Team Member 10 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/ryan.jpg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">SUMNDAD, MOHAMMAD</h5>
                <p class="member-position">Database & Researcher</p>
            </div>
        </div>

        <!-- Team Member 11 -->
        <div class="col-md-2 text-center">
            <div class="team-member">
                <img src="assets/images/torio.jpeg" class="rounded-circle img-fluid mb-3" alt="Team Member">
                <h5 class="member-name">TORIO, LORD VINCENT</h5>
                <p class="member-position">Programmer</p>
            </div>
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
</body>
</html>


