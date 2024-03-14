<?php
require_once('config.php');
session_start();

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];

    if (empty($username)) {
        $_SESSION['error'] = "Please enter username";
        header("Location: register.php");
    } elseif (empty($email)) {
        $_SESSION['error'] = "Please enter email";
        header("Location: register.php");
    } elseif (empty($password)) {
        $_SESSION['error'] = "Please enter password";
        header("Location: register.php");
    } elseif (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
        $_SESSION['error'] = "Please enter email form";
        header("Location: register.php");
    } elseif ($cfpassword !== $password) {
        $_SESSION['error'] = "Password not match";
        header("Location: register.php");
    } else {
        try {
            $role = 0;
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $checkUsernameUnique = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $checkUsernameUnique->execute([$username]);
            $countUsername = $checkUsernameUnique->fetchColumn();

            $checkEmailUnique = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $checkEmailUnique->execute([$email]);
            $countEmail = $checkEmailUnique->fetchColumn();

            if ($countUsername > 0) {
                $_SESSION['error'] = "Username is already exist";
                header("Location: register.php");
            } elseif ($countEmail > 0) {
                $_SESSION['error'] = "Email is already exist";
                header("Location: register.php");
            } else {
                $stmt = $conn->prepare("INSERT INTO users(username,email,password,role) VALUE (?,?,?,?)");
                $stmt->execute([$username, $email, $hash_password, $role]);
                $_SESSION['success'] = "Register Successfully.";
                header("Location: register.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Have Something Error";
            echo "Error:" . $e->getMessage();
            header("Location: register.php");
        }
    }
}
