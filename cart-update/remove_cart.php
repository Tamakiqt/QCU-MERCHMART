<?php
session_start();
require_once('../server/dbcon.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

if (isset($_POST['item_id'])) {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];

    // Ensure item_id and user_id are integers to prevent SQL injection
    $item_id = intval($item_id);
    $user_id = intval($user_id);

    $query = "DELETE FROM cart WHERE user_id = ? AND id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $user_id, $item_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Item removed"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to remove item"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
