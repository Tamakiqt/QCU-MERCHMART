<?php
session_start();
require_once '../server/dbcon.php';

error_log("Session status on login page: " . print_r($_SESSION, true));

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin-index.php?section=dashboard");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    $stmt = $con->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($inputPassword === $row['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $inputUsername;

            $updateStmt = $con->prepare("UPDATE admin SET last_login = NOW() WHERE id = ?");
            $updateStmt->bind_param("i", $row['id']);
            $updateStmt->execute();
            
            error_log("Login successful for user: " . $inputUsername);
            
            header("Location: admin-index.php?section=products");
            exit();
        }
    }
    $_SESSION['error'] = "Invalid username or password.";
}
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