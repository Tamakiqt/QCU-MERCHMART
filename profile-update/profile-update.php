<?php
session_start();
require_once '../server/dbcon.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validate if fields are empty
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        $_SESSION['status'] = "All fields are required!";
        header("Location: ../my-account.php");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid email format!";
        header("Location: ../my-account.php");
        exit();
    }

    // Validate phone number (basic format)
    if (!preg_match("/^[0-9]{11}$/", $phone)) {
        $_SESSION['status'] = "Phone number must be 11 digits!";
        header("Location: ../my-account.php");
        exit();
    }

    try {
        // Check if email already exists for another user
        $check_email_stmt = $con->prepare("SELECT id FROM user WHERE email = ? AND id != ?");
        $check_email_stmt->bind_param("si", $email, $user_id);
        $check_email_stmt->execute();
        $email_result = $check_email_stmt->get_result();

        if ($email_result->num_rows > 0) {
            $_SESSION['status'] = "Email already exists!";
            header("Location: ../my-account.php");
            exit();
        }

        // Update user information
        $update_stmt = $con->prepare("UPDATE user SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
        $update_stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $user_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            $_SESSION['status'] = "Profile updated successfully!";
        } else {
            $_SESSION['status'] = "No changes made to profile.";
        }

    } catch (Exception $e) {
        $_SESSION['status'] = "Error updating profile: " . $e->getMessage();
    }

    header("Location: ../my-account.php");
    exit();
}
?>