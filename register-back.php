<?php
session_start();

include('server/dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';  // Use ../ if register-back.php is inside a subfolder


function sendemail_verify($name, $email,$verify_token)
{

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail's server
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = 'qcumerchmart@gmail.com';  // Gmail email address
        $mail->Password = 'dfjo ldol zadv wpkf';  // Gmail password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port = 587;  // Use port 587 for TLS

        //Recipients
        $mail->setFrom('qcumerchmart@gmail.com', 'QCUMerchMart');  // Set sender email and name
        // Correct the order: first email, then name
$mail->addAddress($email, $name);  // $email should be the second argument
// Add recipient's email and name

        //Email Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Welcome to QCUMerchMart - Confirm Your Email Address';
        
        // HTML email body (registration confirmation with verification link)
        $verificationLink = "http://localhost:8000/verify-email.php?token=$verify_token";
            
        
        $mail->Body = "
       <html>
    <body>
        <h2>Welcome to QCU MerchMart, $name!</h2>
        <p>Thank you for registering with us. To complete your registration, please verify your email address by clicking the link below:</p>
        <div style='text-align: center; margin-top: 15px;'>
            <a href='$verificationLink' style='background-color: #940202; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-size: 16px; font-weight: bold; color: white !important;'>Verify Email</a>
        </div>
        <br>
        <p>If you did not register for an account, please ignore this email.</p>
        <p>Regards,</p>
        <p>The QCU MerchMart Team</p>
    </body>
</html>";

        // Plain text fallback for email clients that do not support HTML
        $mail->AltBody = 'Thank you for registering. Please verify your email address: ' . $verificationLink;

        // Send email
        $mail->send();
        // echo 'Verification email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


if(isset($_POST['register_btn']))

{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $verify_token = md5(rand());

    // Email exist or not

    $check_email_query = "SELECT email FROM user WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0 ){

        $_SESSION['status'] = 'Email is already Exists';
        header("Location: register.php");

    }

    else{ 

                // Registered user data
            $query = "INSERT INTO user (name, email, password, verify_token) VALUES ('$name', '$email', '$password', '$verify_token')";
            $query_run = mysqli_query($con, $query);
                

        if($query_run)
        {
            sendemail_verify("$name", "$email","$verify_token");
            $_SESSION['status'] = 'Registration Succesfull. Please verify your Email Address.';
            header("Location: register.php");
        }

        else
        {
            $_SESSION['status'] = 'Email is already Exists';
            header("Location: register.php");   
        }

    }



}





?>






