<?php
session_start();
require_once '../server/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stockQuantity = $_POST['stock_quantity'];

    // Handle file upload
    $targetDir = "../assets/images/products/";
    $fileName = basename($_FILES["product_picture"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $imageUrl = "assets/images/products/" . $fileName;
    
    // Check if image file is valid
    $imageFileType = strtolower(pathinfo($targetFilePath,PATHINFO_EXTENSION));
    $allowTypes = array('jpg','png','jpeg');
    
    if(in_array($imageFileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["product_picture"]["tmp_name"], $targetFilePath)){
            // Insert into database
            $query = "INSERT INTO products (product_name, description, price, category, stock_quantity, image_url) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssdsss", $productName, $description, $price, $category, $stockQuantity, $imageUrl);
            
            if($stmt->execute()){
                $_SESSION['message'] = "Product added successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Error adding product.";
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Error uploading image.";
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Invalid file type. Only JPG, JPEG & PNG files are allowed.";
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: admin-index.php?section=products");
    exit();
}
?>