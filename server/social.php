<?php
// Database connection
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "qcu_merchmart"; 

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the POST request contains email, social ID, and platform
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $social_id = $_POST['id'];
    $platform = $_POST['platform'];  // Google or Facebook

    // Check if the user already exists by email
    $check_user = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_user);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, login successfully
        echo "Success";
    } else {
        // User does not exist, create new account
        $create_user = "INSERT INTO users (email, social_id, platform) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($create_user);
        $stmt->bind_param("sss", $email, $social_id, $platform);
        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error creating user";
        }
    }
}

// Close the database connection
$conn->close();
?>
