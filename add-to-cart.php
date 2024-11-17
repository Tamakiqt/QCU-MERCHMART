<?php
session_start();
include('server/dbcon.php');


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']); // Convert to integer
    $product_name = $_POST['product_name'];
    $unit_price = floatval(str_replace(',', '', $_POST['price'])); // Convert to float
    $quantity = intval($_POST['quantity']);
    $total_price = $unit_price * $quantity; // Calculate total price
    $image_url = $_POST['image_url'];

    $query = "INSERT INTO cart (user_id, product_id, product_name, price, quantity, image_url) 
              VALUES ($user_id, $product_id, '$product_name', $total_price, $quantity, '$image_url')";
    
    if(mysqli_query($con, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($con)]);
    }
}
?>


