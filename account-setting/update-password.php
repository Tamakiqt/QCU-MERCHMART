<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../server/dbcon.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];

    // Updated password pattern - removed maximum length restriction
    $password_pattern = "/^(?=.*[!@#$%^&*])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,}$/";
    
    if (!preg_match($password_pattern, $new_password)) {
        $_SESSION['status'] = "Password must be at least 8 characters long and contain at least one special character (!@#$%^&*), one number, and one uppercase letter!";
        header("Location: ../my-account.php?tab=account-setting");
        exit();
    }

    // Verify that new password matches confirmation
    if ($new_password !== $confirm_password) {
        $_SESSION['status'] = "New passwords do not match!";
        header("Location: ../my-account.php?tab=account-setting");
        exit();
    }

    try {
        // Get current password from database
        $stmt = $con->prepare("SELECT password FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify current password
        if ($current_password !== $user['password']) {
            $_SESSION['status'] = "Current password is incorrect!";
            header("Location: ../my-account.php?tab=account-setting");
            exit();
        }

        // Update password in database
        $update_stmt = $con->prepare("UPDATE user SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_password, $user_id);
        $update_stmt->execute();

        $_SESSION['status'] = "Password updated successfully!";
        header("Location: ../my-account.php?tab=account-setting");
        exit();

    } catch (Exception $e) {
        $_SESSION['status'] = "Error updating password: " . $e->getMessage();
        header("Location: ../my-account.php?tab=account-setting");
        exit();
    }
}
?>
