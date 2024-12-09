<?php
include('server/dbcon.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    $query = "SELECT stock_quantity FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'success' => true,
            'stock_quantity' => (int)$row['stock_quantity']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Product not found'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No product ID provided'
    ]);
}
?>