<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCU MerchMart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

   


    
      <!---HEADER---->
      <div class="header py-3 text-white fixed-top">
        <h2 class="mb-0"><a href="index.php" class="text-white text-decoration-none">Sign Up</a></h2>
      </div>

 <!----Register----->

 <section class="my-10 py-10">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Sign Up</h2>

            
            
        
</div>
<div class="mx-auto container">
    
<form id="register-form" method="POST" action="server/register.php">
    <div class="form-group">
        <input type="text" class="form-control" id="register-name" name="name" placeholder="Username / Email" required>
    </div>
    <div class="form-group">
        <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required>
    </div>
    <div class="form-group">
        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
    </div>
    <div class="form-group">
        <input type="password" class="form-control" id="register-confirm-password" name="confirmpassword" placeholder="Confirm Password" required>
    </div>
    <div class="form-group">
        <input type="submit" class="btn" id="register-btn" value="Register">
    </div>
</form>




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
            <p class="terms-text">
                By signing up, you agree to MerchMart Terms of Service & Privacy Policy</a>.
            </p>
        </div>
        <div class="form-group"> 
            <a id="login-url" href="login.php" class="btn" >Already have an account? Log in Now</a>
        </div>
    </form>
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



    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!----EMAIL SENDER----->
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
</script>
<script type="text/javascript">
   (function(){
      emailjs.init({
        publicKey: "urk05-DC39haP5pMg",
      });
   })();
</script>

</body>
</html>