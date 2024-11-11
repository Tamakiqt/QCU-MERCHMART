<?php
session_start();
include('server/dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'qcumerchmart@gmail.com';
        $mail->Password = 'dfjo ldol zadv wpkf'; // Use actual password or app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('qcumerchmart@gmail.com', 'QCUMerchMart');
        $mail->addAddress($get_email, $get_name);

        //Email Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password - QCUMerchMart';

        // Password reset link
        $resetLink = "http://localhost:8000/change-password.php?token=$token&email=$get_email";

        // HTML email body for password reset
        $mail->Body = "
        <html>
        <body>
            <h2>Password Reset Request</h2>
            <p>Hello $get_name,</p>
            <p>We received a request to reset your password. You can reset your password by clicking the button below:</p>
            <div style='text-align: center; margin-top: 15px;'>
                <a href='$resetLink' style='background-color: #940202; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-size: 16px; font-weight: bold; color: white !important;'>Reset Password</a>
            </div>
            <br>
            <p>If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>
            <p>Regards,</p>
            <p>The QCU MerchMart Team</p>
        </body>
        </html>";

        // Plain text fallback
        $mail->AltBody = 'To reset your password, click this link: ' . $resetLink;

        // Send email
        $mail->send();
        echo 'Password reset email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if(isset($_POST['password-reset-link']))
{
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT name, email FROM user WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);

    if(mysqli_num_rows($check_email_run) > 0)
    {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE user SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if($update_token_run){
            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = "We've emailed you a link to reset your password. Please follow the instructions in the email to proceed.";
            header("Location: reset-password.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Something went wrong. #1";
            header("Location: reset-password.php");
            exit(0);
        }
    }
    else {
        $_SESSION['status'] = "No email found!";
        header("Location: reset-password.php");
        exit(0);
    }
}

if (isset($_POST['update-password'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);    
    $token = mysqli_real_escape_string($con, $_POST['password_token']); 

    if (!empty($token)) {

        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {

            // Check if the token is valid
            $check_token = "SELECT verify_token FROM user WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {

                if ($new_password == $confirm_password) {
                    $update_password = "UPDATE user SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($con, $update_password);

                    if ($update_password_run) {
                        $_SESSION['status'] = "New password successfully updated!";
                        header("Location: login.php");
                        exit(0);

                    } else {
                        $_SESSION['status'] = "Did not update password. Something went wrong!";
                        header("Location: change-password.php?token=$token&email=$email");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Password and confirm password do not match!";
                    header("Location: change-password.php?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid token!";
                header("Location: change-password.php?token=$token&email=$email");
                exit(0);
            }

        } else {
            $_SESSION['status'] = "All fields are mandatory";
            header("Location: change-password.php?token=$token&email=$email");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No token available";
        header("Location: change-password.php");
        exit(0);
    }
}



?>

