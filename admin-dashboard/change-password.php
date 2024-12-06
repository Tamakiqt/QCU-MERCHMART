<?php
session_start();
require_once '../server/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password !== $confirm_password) {
        $_SESSION['password_message'] = "New passwords do not match!";
        header("Location: admin-index.php?section=settings");
        exit();
    }

    $query = "SELECT password FROM admin WHERE id = ?";
    $stmt = $con->prepare($query);
    $admin_id = $_SESSION['user_id'];
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if ($current_password === $row['password']) {
            $update_query = "UPDATE admin SET password = ? WHERE id = ?";
            $update_stmt = $con->prepare($update_query);
            $update_stmt->bind_param("si", $new_password, $admin_id);
            
            if ($update_stmt->execute()) {
                $_SESSION['password_message'] = "Password successfully updated!";
            } else {
                $_SESSION['password_message'] = "Error updating password. Please try again.";
            }
        } else {
            $_SESSION['password_message'] = "Current password is incorrect!";
        }
    } else {
        $_SESSION['password_message'] = "Admin account not found!";
    }
    
    header("Location: admin-index.php?section=settings");
    exit();
}
?>