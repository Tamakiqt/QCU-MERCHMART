<?php
session_start();
require_once 'server/dbcon.php';

// Add this code to fetch user data
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM user WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500&display=swap" rel="stylesheet">
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

                        .myaccount-header {
                        z-index: 1020; 
                        }

                        /* Main layout styles */
                body {
                    margin: 0;
                    padding: 0;
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                }

                /* Header styles */
                .myaccount-header {
                    position: fixed;
                    top: 110px;
                    width: 100%;
                    z-index: 100;
                    background-color: #940202;
                }

                /* Main content wrapper */
                .account-wrapper {
                    display: flex;
                    margin-top: 180px;
                    min-height: calc(100vh - 180px - 250px); 
                    flex: 1;
                }

                /* Sidebar styles */
                .account-sidebar {
                    width: 250px;
                    background-color: #f8ecec;
                    padding: 30px;
                    font-weight: bold;
                }

                .sidebar-menu {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .sidebar-menu li {
                    margin-bottom: 15px;
                }

                .sidebar-menu a {
                    text-decoration: none;
                    color: #000;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 8px 12px;
                    transition: all 0.3s ease;
                }

                .sidebar-menu a:hover {
                    color: #940202;
                }

                /* Main content area */
                .account-content {
                    width: 100%;
                    background-color: white;
                    padding: 30px;
                    padding-bottom: 150px;
                }

                /* Form styles */
                .profile-form {
                    width: 411px;  
                    margin: 0 auto;
                    margin-top: 50px;
                }

                .profile-form input {
                    width: 411px;
                    height: 43px;  /* Changed from 35px to 43px */
                    margin-bottom: 15px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 0 12px;
                    font-size: 14px;
                }

                .profile-form button {
                    width: 411px;
                    height: 43px; 
                    background-color: #dc3545;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    font-size: 14px;
                    cursor: pointer;
                }

                .mt-5{
                    margin-top: 3rem !important;
                }



                /* Mobile responsive styles */
                @media screen and (max-width: 768px) {
                    /* Main container */
                    .account-wrapper {
                        flex-direction: column;
                        margin-top: 120px;
                        padding: 15px;
                    }

                    /* Sidebar */
                    .account-sidebar {
                        width: 100%;
                        background-color: #f8ecec;
                        padding: 15px;
                        margin-bottom: 20px;
                    }

                    /* Content area */
                    .account-content {
                        width: 100%;
                        padding: 15px;
                    }

                    /* Form adjustments */
                    .profile-form {
                        width: 100%;
                        padding: 0 15px;
                    }

                    .profile-form input,
                    .profile-form button {
                        width: 100%;
                        height: 43px;
                        margin-bottom: 15px;
                    }

                    /* Header adjustments */
                    .myaccount-header {
                        top: 0;
                    }

                    /* Footer adjustments */
                    footer {
                        padding: 15px;
                    }

                    /* Adjust text sizes */
                    h4 {
                        font-size: 18px;
                    }

                    p {
                        font-size: 13px;
                    }
                }

                .menu-item {
                    transition: color 0.3s ease;
                    text-decoration: none;
                    display: block;
                    padding: 8px 0;
                }

                .content-section {
                    display: none;
                }

                .content-section.active {
                    display: block;
                }

                .orders-container {
                    padding: 20px;
                }

                .order-item {
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    margin-bottom: 20px;
                    background-color: #fff;
                }

                .order-header {
                    padding: 15px;
                    border-bottom: 1px solid #ddd;
                }

                .order-number {
                    font-weight: bold;
                }

                .order-content {
                    padding: 15px;
                    display: flex;
                    align-items: center;
                    gap: 20px;
                }

                .order-image img {
                    border: 1px solid #ddd;
                    padding: 5px;
                }

                .order-details {
                    flex: 1;
                }

                .order-dates {
                    margin-bottom: 10px;
                    color: #666;
                }

                .date-separator {
                    margin: 0 10px;
                    color: #999;
                }

                .order-status {
                    margin-bottom: 10px;
                }

                .view-details {
                    color: #0066cc;
                    text-decoration: none;
                    font-size: 14px;
                }

                .view-details:hover {
                    text-decoration: underline;
                }

                .no-orders {
                    text-align: center;
                    padding: 40px 20px;
                }

                .shop-now-btn {
                    display: inline-block;
                    margin-top: 15px;
                    padding: 10px 20px;
                    background-color: #940202;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                }

                .shop-now-btn:hover {
                    background-color: #7a0202;
                }

                .password-requirements {
                    font-size: 12px;
                    color: #666;
                    margin-top: 5px;
                }

                .password-requirements ul {
                    margin: 5px 0;
                    padding-left: 20px;
                }

                .form-group {
                    margin-bottom: 15px;
                }

                .notification-container {
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 9999;
                    display: none;
                }

                .notification-content {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-color: #940202;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 8px;
                    margin: 10px auto;
                    width: fit-content;
                    font-weight: bold;
                    text-align: center;
                }

                .notification-content i {
                    margin-right: 10px;
                }

                .modal-content {
                    border-radius: 10px;
                    border: 1px solid #ddd;
                }

                .btn-danger {
                    background-color: #940202;
                    border: none;
                }

                .btn-danger:hover {
                    background-color: #7a0202;
                }

                .btn-light {
                    border: 1px solid #ddd;
                }

                .modal-body h5 {
                    font-weight: 500;
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
                    <a class="nav-link" href="client-favorites.php">Favorites</a>
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

<!-- My Account Header -->
<div class="myaccount-header py-3 fixed-top" style="top: 110px; background-color: #940202; border-bottom: 1px solid #ddd;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="client-index.php" class="btn btn-link text-black me-1 back-button" style="font-size: 1.25rem; color: black;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: white;">User Account Menu</h5>
        </div>
    </div>
</div>





<!-- Account Section -->
<div class="account-wrapper">
    <!-- Left Sidebar -->
    <div class="account-sidebar">
        <h5 style="font-size: 16px; margin-bottom: 20px; font-weight: bold;">My Account</h5>
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="menu-item active" data-content="profile">Profile</a>
            </li>
            <li>
                <a href="#" class="menu-item" data-content="account-setting">Account Setting</a>
            </li>
            <li>
                <a href="#" class="menu-item" data-content="order-history">Order History</a>
            </li>
            <li>
                <a href="#" class="menu-item" data-bs-toggle="modal" data-bs-target="#logoutModal">Log Out</a>
            </li>
        </ul>
    </div>

    <!-- Right Content Area -->
    <div class="account-content">
        <!-- Profile Content -->
        <div id="profile" class="content-section active">
            <h4 style="font-size: 20px; margin-bottom: 5px; font-weight: bold;">My Profile</h4>
            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Manage and protect your account</p>
            <hr style="margin: 0; border-top: 3px solid #000;">
            <div style="display: flex; justify-content: center;">
                <form class="profile-form" action="profile-update/profile-update.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                    <button type="submit" name="update_profile" style="background-color: #940202; color: white; border: none; font-weight: bold;">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Account Setting Content -->
        <div id="account-setting" class="content-section">
            <h4 style="font-size: 20px; margin-bottom: 5px; font-weight: bold;">Account Setting</h4>
            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Manage your account settings</p>
            <hr style="margin: 0; border-top: 3px solid #000;">
            <div style="display: flex; justify-content: center;">
                <form class="profile-form" action="account-setting/update-password.php" method="POST">
                    <h5 style="font-size: 24px; margin-bottom: 30px; font-weight: bold; text-align: center;">Change Password</h5>
                    <div class="form-group">
                        <input type="password" name="current_password" placeholder="Current Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="new_password" placeholder="New Password" required>
                        <small class="password-requirements">
                            Password must:
                            <ul>
                                <li>Be at least 8 characters long</li>
                                <li>Include at least one special character (!@#$%^&*)</li>
                                <li>Include at least one number</li>
                                <li>Include at least one uppercase letter</li>
                            </ul>
                        </small>
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                    </div>
                    <button type="submit" style="background-color: #940202; color: white; border: none; font-weight: bold;">Update Password</button>
                </form>
            </div>
        </div>

        <!-- Order History Content -->
        <div id="order-history" class="content-section">
            <h3 style="font-size: 20px; margin-bottom: 5px; font-weight: bold;">Order History</h3>
            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">View your order details in this page</p>
            <hr style="margin: 0; border-top: 3px solid #000;">
            <div class="orders-container">
                <?php
                // Get user's orders
                $order_query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
                $stmt = $con->prepare($order_query);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($order = $result->fetch_assoc()) {
                        ?>
                        <div class="order-item">
                            <div class="order-header">
                                <div class="order-number">Order Number: <?php echo htmlspecialchars($order['order_number']); ?></div>
                            </div>
                            <div class="order-content">
                                <div class="order-image">
                                    <img src="<?php echo htmlspecialchars($order['image_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($order['product_name']); ?>" 
                                         width="100">
                                </div>
                                <div class="order-details">
                                    <div class="product-name"><?php echo htmlspecialchars($order['product_name']); ?></div>
                                    <div class="order-dates">
                                        <span>Order Date: <?php echo date('m/d/Y', strtotime($order['order_date'])); ?></span>
                                        <span class="date-separator">|</span>
                                        <span>Status: <?php echo htmlspecialchars($order['status']); ?></span>
                                    </div>
                                    <div class="order-total">
                                        <span>Quantity: <?php echo htmlspecialchars($order['quantity']); ?></span>
                                        <span class="date-separator">|</span>
                                        <span>Total: ₱<?php echo number_format($order['total'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="no-orders">
                        <p>No orders found. Start shopping to see your order history!</p>
                        <a href="client-shop.php" class="shop-now-btn">Shop Now</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Custom Notification -->
<div id="custom-notification" class="notification-container" style="display: none;">
    <div class="notification-content">
        <i class="bi bi-exclamation-circle"></i>
        <span id="notification-message"></span>
    </div>
</div>

<!-- Custom Notification -->
<?php
if(isset($_SESSION['status'])) {
    ?>
    <script>
        // Function to show notification
        function showNotification(message) {
            const notification = document.getElementById('custom-notification');
            const notificationMessage = document.getElementById('notification-message');
            
            notificationMessage.textContent = message;
            notification.style.display = 'block';
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        // Show notification when page loads
        document.addEventListener('DOMContentLoaded', function() {
            showNotification('<?php echo $_SESSION['status']; ?>');
        });
    </script>
    <?php
    unset($_SESSION['status']);
}
?>


<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <h5 class="mb-4">Are you sure you want to logout?</h5>
                <div class="d-flex justify-content-center gap-3">
                    <a href="logout.php?redirect=index.php" class="btn btn-danger px-4">Yes</a>
                    <button type="button" href="my-account.php" class="btn btn-light px-4" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</div>






    



<!----FOOTER------>
<footer class="py-5">
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
    const menuItems = document.querySelectorAll('.menu-item');
    
    // Function to update menu item appearance
    function updateMenuItems() {
        menuItems.forEach(item => {
            if (item.classList.contains('active')) {
                item.style.color = '#940202';
                if (!item.textContent.includes('→')) {
                    item.textContent = '→ ' + item.textContent;
                }
            } else {
                item.style.color = '#000';
                item.textContent = item.textContent.replace('→ ', '');
            }
        });
    }

    // Function to show content section
    function showContent(contentId) {
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });
        
        const contentSection = document.getElementById(contentId);
        if (contentSection) {
            contentSection.classList.add('active');
        }
    }

    // Initial setup
    updateMenuItems();

    // Add event listeners
    menuItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            if (!item.classList.contains('active')) {
                item.style.color = '#940202';
                item.textContent = '→ ' + item.textContent.replace('→ ', '');
            }
        });

        item.addEventListener('mouseleave', () => {
            if (!item.classList.contains('active')) {
                item.style.color = '#000';
                item.textContent = item.textContent.replace('→ ', '');
            }
        });

        // Updated click handler
        item.addEventListener('click', (e) => {
            e.preventDefault();
            
            menuItems.forEach(menuItem => {
                menuItem.classList.remove('active');
                menuItem.style.color = '#000';
                menuItem.textContent = menuItem.textContent.replace('→ ', '');
            });
            
            item.classList.add('active');
            item.style.color = '#940202';
            if (!item.textContent.includes('→')) {
                item.textContent = '→ ' + item.textContent;
            }

            const contentId = item.getAttribute('data-content');
            if (contentId) {
                showContent(contentId);
                // Update URL without tab parameter for profile, with parameter for others
                if (contentId === 'profile') {
                    history.pushState({}, '', 'my-account.php');
                } else {
                    history.pushState({}, '', `my-account.php?tab=${contentId}`);
                }
            }
        });
    });

    // Handle initial page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        
        if (tab) {
            const menuItem = document.querySelector(`[data-content="${tab}"]`);
            if (menuItem) {
                menuItem.click();
            }
        } else {
            const profileItem = document.querySelector('[data-content="profile"]');
            if (profileItem) {
                profileItem.click();
            }
        }
    });
</script>


</body>
</html>
