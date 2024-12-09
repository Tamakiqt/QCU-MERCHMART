<?php
session_start();
session_unset();
session_destroy();

// Check if there's a redirect parameter
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'login.php';

// Redirect to the specified page
header("Location: " . $redirect);
exit();
?>