<?php
require_once('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to PHPMailer autoload.php

session_start();
// Create a new PHPMailer instance
$mail = new PHPMailer(true);
function generateToken($length = 32)
{
    return bin2hex(random_bytes($length));
}
if (isset($_POST['fgpass'])) {
    $email = $_POST['email'];

    if (empty($email)) {
        $_SESSION['error'] = "Please enter email";
        header("Location: forgotpassword.php");
    } else {
        $checkEmail = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        $countEmail = $checkEmail->fetchColumn();
        if ($countEmail > 0) {
            $token = generateToken();
            $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $stmt = $conn->prepare("UPDATE users SET reset_token = ? , reset_expiration=? WHERE email = ? ");
            $stmt->execute([$token, $expiration, $email]);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'wmail8376@gmail.com';
                $mail->Password = 'zcaa each buse zxbw';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Recipients
                $mail->setFrom('wmail8376@gmail.com');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(false);
                $mail->Subject = 'Reset Password';
                $mail->Body = "http://localhost/php-auth/resetpassword.php?token=$token";

                $mail->send();
                $_SESSION['success'] =  "Reset password email sent successfully!";
                header("Location: forgotpassword.php");
            } catch (Exception $e) {
                $_SESSION['error'] = "Email sending failed. Error.";
                echo "Email sending failed. Error: {$mail->ErrorInfo}";
                header("Location: forgotpassword.php");
            }
        } else {
            $_SESSION['error'] = "Email address not found.";
            header("Location: forgotpassword.php");
        }
    }
}
