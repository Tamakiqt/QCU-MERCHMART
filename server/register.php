<?php
session_start();


$servername = "localhost";
$username = "root";  // MySQL username
$password = "";  //  MySQL password
$dbname = "qcu_merchmart";  // database name


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$register_error = '';
$register_success = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];

   
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $register_error = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $register_error = "Passwords do not match!";
    } else {
        
        $sql_check = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
         
            $register_error = "The email address is already in use!";
        } else {
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                $register_success = "New user registered successfully!";
                
                
                echo "Attempting to send email to $email...<br>";

               
                require_once('emailjs.php');
               
                $email_sent = send_email_using_emailjs($email, "Registration Successful", "Hello $name, Welcome to QCU MerchMart!");

                if ($email_sent) {
                
                    echo "Email sent successfully!";
                } else {
               
                    echo "Error: Email not sent!";
                }

              
                $_SESSION['register_success'] = $register_success;
                header("Location: ../index.php");  
                exit();
            } else {
               
                $register_error = "Error: " . $conn->error;
            }
        }
    }
}


$conn->close();
?>







