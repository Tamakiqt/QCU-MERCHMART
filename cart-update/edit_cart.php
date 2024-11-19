<?php
session_start();
// cart-update/update_quantity.php
require_once('../server/dbcon.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$item_id = $_POST['item_id'];
$new_quantity = $_POST['quantity'];

if (is_numeric($new_quantity) && $new_quantity > 0) {
    $query = "UPDATE cart SET quantity = ?, total = (price * ?) WHERE id = ? AND user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iiii", $new_quantity, $new_quantity, $item_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update quantity']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quantity']);
}

?>