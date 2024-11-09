<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";  // Your MySQL password
$dbname = "qcu_merchmart";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error and success messages
$register_error = '';
$register_success = '';

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];

    // Validate the form data
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $register_error = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $register_error = "Passwords do not match!";
    } else {
        // Check if the email already exists in the database
        $sql_check = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            // Email already exists
            $register_error = "The email address is already in use!";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL query to insert the data into the database
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                $register_success = "New user registered successfully!";
                
                // Debugging: Checking if the email is sent
                echo "Attempting to send email to $email...<br>";

                // Send email after successful registration (hidden)
                require_once('emailjs.php');
                // Call emailjs but don't show any notification
                $email_sent = send_email_using_emailjs($email, "Registration Successful", "Hello $name, Welcome to QCU MerchMart!");

                if ($email_sent) {
                    // If the email was sent, debug message
                    echo "Email sent successfully!";
                } else {
                    // If email failed
                    echo "Error: Email not sent!";
                }

                // Set the success message and redirect
                $_SESSION['register_success'] = $register_success;
                header("Location: ../index.php");  // Redirect to index page or wherever you want
                exit();
            } else {
                // Output the error if the insert fails
                $register_error = "Error: " . $conn->error;
            }
        }
    }
}

// Close the connection
$conn->close();
?>







