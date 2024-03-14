<?php
session_start();
if (!isset($_GET['token'])) {
    header("Location: forgotpassword.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="sign-in.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<body>
    <div class="container">
        <!-- Nav Start -->
        <?php include('nav.php') ?>
        <!-- Nav End -->
    </div>
    <main class="form-signin w-100 m-auto">
        <form action="resetpassword_db.php" method="post">
            <?php if (isset($_GET['token'])) {
                $token = $_GET['token'];
            }
            ?>
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            <h1 class="h3 mb-3 fw-normal">Resetpassword</h1>
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <div class="form-floating">
                <input type="password" class="form-control my-3" name="password" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control my-3" name="cfpassword" id="floatingPassword" placeholder="ConfirmPassword">
                <label for="floatingPassword">Confirm Password</label>
            </div>
            <button class="btn btn-primary w-100 py-2" name="resetpw" type="submit">Sign up</button>
        </form>
    </main>
    <div class="container">
        <!-- Footer Start -->
        <?php include('footer.php'); ?>
        <!-- Footer End -->
    </div>
</body>

</html>