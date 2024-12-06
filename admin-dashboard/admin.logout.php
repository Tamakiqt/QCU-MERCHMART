<?php
session_start();
session_destroy();

// Check if there's a redirect parameter
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'admin-login.php';

// Redirect to the specified page
header("Location: " . $redirect);
exit();
?>