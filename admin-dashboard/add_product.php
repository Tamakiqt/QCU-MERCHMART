<?php
session_start();
require_once '../server/dbcon.php';

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 5 * 1024 * 1024; // 5MB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stockQuantity = $_POST['stock_quantity'];
    
    if (isset($_FILES['product_picture'])) {
        $file = $_FILES['product_picture'];
        
        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['error_message'] = "Invalid file type. Please upload JPG, PNG or GIF files only.";
            header("Location: admin-index.php?section=products");
            exit();
        }
        
        if ($file['size'] > $maxFileSize) {
            $_SESSION['error_message'] = "File is too large. Maximum size is 5MB.";
            header("Location: admin-index.php?section=products");
            exit();
        }
    }
    
    if (isset($_FILES['product_picture']) && $_FILES['product_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../uploads/";
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileExtension = pathinfo($_FILES['product_picture']['name'], PATHINFO_EXTENSION);
        $uniqueFilename = uniqid('product_', true) . '.' . $fileExtension;
        $targetFile = $uploadDir . $uniqueFilename;
        
        if (move_uploaded_file($_FILES['product_picture']['tmp_name'], $targetFile)) {
            // Insert into database
            $stmt = $con->prepare("INSERT INTO products (product_name, image_url, description, price, category, stock_quantity, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $imageUrl = $targetFile;
            $stmt->bind_param("sssdsi", $productName, $imageUrl, $description, $price, $category, $stockQuantity);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Product added successfully!";
            } else {
                $_SESSION['error_message'] = "Error adding product to database.";
            }
        } else {
            $_SESSION['error_message'] = "Error uploading file.";
        }
    } else {
        $_SESSION['error_message'] = "No file uploaded or file upload error.";
    }
    
    header("Location: admin-index.php?section=products");
    exit();
}
?>