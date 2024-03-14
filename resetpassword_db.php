<?php
require_once('config.php');
session_start();

if (isset($_POST['resetpw'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];

    if (empty($password)) {
        $_SESSION['error'] = "Please enter password";
        header("Location: resetpassword.php");
    } elseif ($cfpassword !== $password) {
        $_SESSION['error'] = "Password not match";
        header("Location: resetpassword.php");
    } else {
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ?  WHERE reset_token = ? ");
        $stmt->execute([$hash_password, $token]);
        $_SESSION['success'] = "Reset password Successfully.";
        header("Location: resetpassword.php");
    }
}
