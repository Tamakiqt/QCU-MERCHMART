<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qcumerchmart_db";

$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize error variable
if (!isset($_SESSION['error'])) {
    $_SESSION['error'] = ""; // Initialize error session variable
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Prepare and bind
    $stmt = $con->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    // Check if the username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($storedPassword);
        $stmt->fetch();

        // Verify the password (plain text comparison)
        if ($inputPassword === $storedPassword) {
            // Successful login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $inputUsername;

            // Update last login time
            $updateStmt = $con->prepare("UPDATE admin SET last_login = NOW() WHERE username = ?");
            $updateStmt->bind_param("s", $inputUsername);
            $updateStmt->execute();

            // Clear the error message
            unset($_SESSION['error']);

            // Redirect to admin dashboard
            header("Location: admin-index.php?section=dashboard");
            exit();
        } else {
            // Invalid password
            $_SESSION['error'] = "Invalid username or password.";
        }
    } else {
        // Invalid username
        $_SESSION['error'] = "Invalid username or password.";
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
            font-family: 'Poppins', sans-serif;
        }

        .header {
            width: 100%;
            height: 37px;
            background-color: black;
            color: #b6b6b6;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }

        .header p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
       
        .header + .content {
            margin-top: 37px; 
        }

        .login-container {
            padding: 40px;
            border: 2px solid black; 
            border-radius: 8px;
            background: #ffffff;
            text-align: center;
        }
        .login-container h3 {
            font-size: 32px;
            margin: 20px 0 50px;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            width: 544px;
            height: 65px;
            margin: 20px auto;
            border-radius: 12px;
            font-size: 18px;
            border: 2px solid #b6b6b6;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: black;
        }
        .btn-dark {
            width: 544px;
            height: 65px;
            margin-top: 20px;
            margin-bottom: 40px;
            border-radius: 10px;
            border: 8px;
            background-color: black;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Top Header -->
<div class="header">
    <p class="mb-0">QCU Coop Online Shopping Site</p>
</div>
        
<!-- Login Form -->
<div class="login-container">
    <!-- Login Title -->
    <h3>Log In</h3>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <!-- Username/Email Input -->
        <input type="text" class="form-control" name="username" placeholder="Username" required>
        <!-- Password Input -->
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <!-- Login Button -->
        <button type="submit" class="btn btn-dark">Log In</button>
    </form>
</div>





<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>