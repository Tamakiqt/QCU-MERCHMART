<?php
session_start();
require_once 'server/dbcon.php';

// Clear any pending payment session
if(isset($_SESSION['pending_payment'])) {
    unset($_SESSION['pending_payment']);
}

// Set error message
$_SESSION['message'] = "Payment was cancelled or failed. Please try again.";

// Redirect back to cart
header("Location: cart.php");
exit();
?>