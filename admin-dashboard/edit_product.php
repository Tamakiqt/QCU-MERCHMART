<?php
session_start();
require_once '../server/dbcon.php';

// Set JSON content type header
header('Content-Type: application/json');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Check if product ID is provided
if (!isset($_POST['product_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Product ID is required']);
    exit();
}

// Get form data
$productId = $_POST['product_id'];
$productName = $_POST['product_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category = $_POST['category'];
$stockQuantity = $_POST['stock_quantity'];

// Start transaction
$con->begin_transaction();

try {
    // Check if new image was uploaded
    if (isset($_FILES['product_picture']) && $_FILES['product_picture']['size'] > 0) {
        $targetDir = "../uploads/";
        
        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($_FILES["product_picture"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        // Allow certain file formats
        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["product_picture"]["tmp_name"], $targetFilePath)) {
                // Update product with new image
                $query = "UPDATE products SET 
                         product_name = ?, 
                         description = ?, 
                         price = ?, 
                         category = ?, 
                         stock_quantity = ?,
                         image_url = ?
                         WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ssdsisi", 
                    $productName, 
                    $description, 
                    $price, 
                    $category, 
                    $stockQuantity, 
                    $targetFilePath, 
                    $productId
                );
            } else {
                throw new Exception("Failed to upload image.");
            }
        } else {
            throw new Exception("Invalid file format. Allowed formats: " . implode(', ', $allowTypes));
        }
    } else {
        // Update product without changing the image
        $query = "UPDATE products SET 
                 product_name = ?, 
                 description = ?, 
                 price = ?, 
                 category = ?, 
                 stock_quantity = ?
                 WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssdsii", 
            $productName, 
            $description, 
            $price, 
            $category, 
            $stockQuantity, 
            $productId
        );
    }

    // Execute the update query
    if (!$stmt->execute()) {
        throw new Exception("Error executing query: " . $stmt->error);
    }
    
    // Commit transaction
    $con->commit();
    
    // Return success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Product updated successfully'
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $con->rollback();
    
    // Return error response
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

// Close database connection
$stmt->close();
$con->close();