<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
      
 <!-----NOTIFICATION------>
 <?php
        session_start();
        if (isset($_SESSION['status'])) {
            echo '<div id="error-message" style="display: flex; justify-content: center; align-items: center; background-color: #940202; color: white; padding: 10px 20px; border-radius: 8px; margin: 10px auto; width: fit-content; font-weight: bold; text-align: center;">' . $_SESSION['status'] . '</div>'; 
            unset($_SESSION['status']);  
        }    
        ?>


    <!-- Header -->
    <div class="header py-3 text-white fixed-top" style="background-color: #940202;">
        <h2 class="mb-0 text-left">Change Password</h2>
    </div>

   <!-- Reset Password Form -->
<section class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="container text-center">
        <h2 class="form-weight-bold mb-3">Change Password</h2>
        
        <div class="mx-auto" style="max-width: 400px;">
            <div style="border: 1px solid #940202; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <form id="change-password-form" method="POST" action="reset-password-code.php">
            <input type="hidden" name="password_token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">

                <div class="form-group">
                    <input type="email" class="form-control"  name="email" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];} ?>" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control"  name="new_password" placeholder="New Password" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control"  name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <button type="submit" name="update-password" class="btn w-100" style="background-color: #940202; color: white; font-weight: bold; border: 1px; border-radius: 8px;">
                            Reset Password
                        </button>

                    </div>
                </form>
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

    <!-- Bootstrap JS and custom script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>

</body>
</html>


