<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCU Merchant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php
    session_start();
    if (isset($_SESSION['status'])) {
        echo '<div id="error-message" style="display: flex; justify-content: center; align-items: center; background-color: #940202; color: white; padding: 10px 20px; border-radius: 8px; margin: 10px auto; width: fit-content; font-weight: bold; text-align: center;">' . $_SESSION['status'] . '</div>'; 
        unset($_SESSION['status']);  
    }
    ?>



    
    <!---HEADER---->
    <div class="header py-3 text-white fixed-top">
        <div class="header py-3 text-white fixed-top">
            <h2 class="mb-0"><a href="index.php" class="text-white text-decoration-none">Login</a></h2>
        </div>
        
      </div>

 <!----LOGIn----->

 <section class="my-10 py-10">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Login</h2>

           


        
</div>
<div class="mx-auto container">
<div class="mx-auto" style="max-width: 400px;">
<div style="border: 1px solid #940202;  padding: 30px;  border-radius: 12px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
    <form method="POST" action="logincode.php">
        <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Email or Username" required>
        </div>
    
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
    
        <div class="form-group">
            <input type="submit" class="btn" name="login_btn" id="login-btn" value="Login">
        </div>
    </form>
    
                <div class="form-group">
                <a id="forgot-password" href="reset-password.php" class="text-decoration-none text-center" style="padding: 10px;">
                    Forgot Password?
                </a>
            </div>  


        <div class="form-group my-3 text-center">
            <div class="line-container">
                <div class="line"></div>
                <p class="or-text">Or login with</p>
                <div class="line"></div>
            </div>
        
            <!-- Button container with border -->
            <div class="social-buttons border p-3 d-flex justify-content-between">
                <a href="https://www.facebook.com" class="btn btn-outline-primary">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="https://accounts.google.com/v3/signin/identifier?continue=https%3A%2F%2Faccounts.google.com%2F&followup=https%3A%2F%2Faccounts.google.com%2F&ifkv=AcMMx-fjQw_jxvUphPD_1cxipQEHpBf3lTZisz533VNNikOGJGrlz8NKLeBPfr_bbzlWXvsyNgPdfw&passive=1209600&flowName=GlifWebSignIn&flowEntry=ServiceLogin&dsh=S-2094142429%3A1730534745302032&ddm=1" class="btn btn-outline-danger">
                    <i class="fab fa-google"></i> Google
                </a>
            </div>
        </div>
        
        
        
        <div class="form-group">
            <a id="register-url" href="register.php" class="btn">Don't have an account? Sign up</a>
          </div>
          
    </form>
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


 <script src="/assets/js/script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
