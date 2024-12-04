<?php
session_start();
include('server/dbcon.php');

// Initialize login attempts if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Check if the user is locked out
if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    $remaining_time = $_SESSION['lockout_time'] - time();
    $remaining_minutes = floor($remaining_time / 60);
    $remaining_seconds = $remaining_time % 60;

    // Construct the lockout message
    if ($remaining_minutes > 0) {
        $_SESSION['status'] = "Login Locked! Please try again after " . $remaining_minutes . " minute(s) and " . $remaining_seconds . " second(s).";
    } else {
        $_SESSION['status'] = "Login Locked! Please try again after " . $remaining_seconds . " second(s).";
    }

    header("Location: login.php");
    exit();
}

if (isset($_POST['login_btn'])) {
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Query to fetch user by either email or username
        $login_query = "SELECT * FROM user WHERE email='$email' OR name='$email'";
        $login_query_run = mysqli_query($con, $login_query);

        // Check if a user is found
        if (mysqli_num_rows($login_query_run) > 0) {
            $row = mysqli_fetch_array($login_query_run);

            // Check if the user is verified
            if ($row['verification_status'] == "1") {
                // Directly check the plain-text password
                if ($password === $row['password']) {
                    // If password is correct, start the session and set session variables
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_email'] = $row['email'];
                    $_SESSION['user_name'] = $row['name'];

                    // Reset login attempts on successful login
                    $_SESSION['login_attempts'] = 0;

                    // Redirect to the client-index.php page with a success message
                    $_SESSION['status'] = "You are logged in successfully!";
                    header("Location: client-index.php");
                    exit(0);
                } else {
                    // If password is incorrect
                    $_SESSION['login_attempts']++;
                    if ($_SESSION['login_attempts'] >= 5) {
                        $_SESSION['lockout_time'] = time() + 120; // Lock for 2 minutes
                        $_SESSION['status'] = "Login Locked! Too many login attempts! Please try again after 2 minutes.";
                    } else {
                        $_SESSION['status'] = "Invalid Email or Password. Attempt " . $_SESSION['login_attempts'] . " ";
                    }
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
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 5) {
                $_SESSION['lockout_time'] = time() + 120; // Lock for 2 minutes
                $_SESSION['status'] = "Login Locked! Too many login attempts! Please try again after 2 minutes.";
            } else {
                $_SESSION['status'] = "Invalid Email or Password. Attempt " . $_SESSION['login_attempts'] . " of 5.";
            }
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























