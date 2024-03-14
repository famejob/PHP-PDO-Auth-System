<?php
require_once('config.php');
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $_SESSION['error'] = "Please enter email";
        header("Location:login.php");
    } elseif (empty($password)) {
        $_SESSION['error'] = "Please enter password";
        header("Location:login.php");
    } elseif (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
        $_SESSION['error'] = "Please enter email form";
        header("Location: login.php");
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $Userdata = $stmt->fetch();
        if ($Userdata && password_verify($password, $Userdata['password'])) {
            if ($Userdata['role'] == 0) {
                $_SESSION['user_id'] = $Userdata['id'];
                $_SESSION['user_role'] = $Userdata['role'];
                header("Location: user.php");
            } else {
                $_SESSION['user_id'] = $Userdata['id'];
                $_SESSION['user_role'] = $Userdata['role'];
                header("Location: admin.php");
            }
        } else {
            $_SESSION['error'] = "Email or password not correct";
            header("Location: login.php");
        }
    }
}
