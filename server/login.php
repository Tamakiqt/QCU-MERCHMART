<?php
// Database connection
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password
$dbname = "qcu_merchmart"; // Update with your database name

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'email_or_name' and 'password' are set
    if (isset($_POST['email_or_name']) && isset($_POST['password'])) {
        $email_or_name = trim($_POST['email_or_name']); // Get email/username from the input
        $password = $_POST['password']; // Get the password

        // Check if email/username exists in the database
        $check_user = "SELECT * FROM users WHERE email = ? OR name = ?";
        $stmt = $conn->prepare($check_user);
        $stmt->bind_param("ss", $email_or_name, $email_or_name);
        $stmt->execute();
        $result = $stmt->get_result();

        // If email/username exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, login successful
                echo "Login successful!";
                // Redirect to dashboard or home page
                header("Location: index.html"); // Redirect to dashboard
                exit();
            } else {
                // Invalid password
                echo "Invalid password.";
            }
        } else {
            // Email/username does not exist
            echo "No account found with that email or username.";
        }
    } else {
        echo "Please fill out both fields.";
    }
}

// Close the database connection
$conn->close();
?>






