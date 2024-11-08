<?php
// Database connection
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password
$dbname = "qcu_merchmart"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $name = $_POST['name']; // Correctly retrieving the name from the form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists
        $check_email = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_email);
        $stmt->bind_param("s", $email); // Check email for duplicates
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Username or Email already exists!";
        } else {
            // Insert the new user
            $insert_user = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_user);
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>



