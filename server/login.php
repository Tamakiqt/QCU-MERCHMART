<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qcu_merchmart";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email_or_name']) || empty($_POST['password'])) {
        $_SESSION['login_error'] = "Please fill in both fields.";
    } else {
        $email_or_name = trim($_POST['email_or_name']);
        $password = $_POST['password'];

        // Query to check if email or username exists
        $check_user = "SELECT * FROM users WHERE email = ? OR name = ?";
        $stmt = $conn->prepare($check_user);
        $stmt->bind_param("ss", $email_or_name, $email_or_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Store user data and success message in session
                $_SESSION['user_id'] = $user['id'];
                header("Location: ../index.php");  // Redirect to the homepage
                exit();
            } else {
                $_SESSION['login_error'] = "Invalid password.";
            }
        } else {
            $_SESSION['login_error'] = "No account found with that email or username.";
        }
    }

    // Redirect back to the login page if there's an error
    header("Location: ../login.php");
    exit();
}
?>


















