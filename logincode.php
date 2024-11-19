<?php
session_start();
include('server/dbcon.php');

if(isset($_POST['login_btn'])) {

    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Query to fetch user by either email or username
        $login_query = "SELECT * FROM user WHERE email='$email' OR name='$email'";
        $login_query_run = mysqli_query($con, $login_query);

        // Check if a user is found
        if(mysqli_num_rows($login_query_run) > 0) {
            $row = mysqli_fetch_array($login_query_run);

            // Check if the user is verified
            if($row['verification_status'] == "1") {

                // Directly check the plain-text password
                if($password === $row['password']) {
                    // If password is correct, start the session and set session variables
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_email'] = $row['email'];
                    $_SESSION['user_name'] = $row['name'];  

                    // Redirect to the client-index.php page with a success message
                    $_SESSION['status'] = "You are logged in successfully!";
                    header("Location: client-index.php");
                    exit(0);
                } else {
                    // If password is incorrect
                    $_SESSION['status'] = "Invalid Email or Password";
                    header("Location: login.php");
                    exit(0);
                }
            } else {
                // If user is not verified
                $_SESSION['status'] = "Please verify your email!";
                header("Location: login.php");
                exit(0);
            }
        } else {
            // If no user found with the given email or username
            $_SESSION['status'] = "Invalid Email or Password";
            header("Location: login.php");
            exit(0);
        }
    } else {
        // If email or password is empty
        $_SESSION['status'] = "Please fill in both fields!";
        header("Location: login.php");
        exit(0);
    }
}
?>
























