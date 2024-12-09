<?php
session_start();
include('server/dbcon.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['favorite_id'])) {
    echo json_encode(['success' => false, 'message' => 'No favorite ID provided']);
    exit;
}

$favorite_id = $data['favorite_id'];
$user_id = $_SESSION['user_id'];

// Make sure the favorite belongs to the current user
$query = "DELETE FROM favorites WHERE id = ? AND user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $favorite_id, $user_id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Favorite removed successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error removing favorite'
    ]);
}
?>