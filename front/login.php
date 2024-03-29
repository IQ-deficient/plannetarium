<?php
session_start();
include('../back/config/connection.php');
// already logged in check and redirect
if (isset($_SESSION["UserId"])) {
    header('Location:home.php');
}
global $con;

$username = $password = $msg = "";
$check = true;

if (isset($_POST['submit'])) {
    // input data (username & password) validation
    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $msg = "Username is empty";
        $check = false;
    }
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $msg = "Password is empty";
        $check = false;
    }

    // validation passed
    if ($check) {
        $query = 'SELECT u.id AS UserId, u.username AS Username, u.password AS Password,
            t.name AS Type FROM users u,usertype t WHERE t.id=u.type';
        $execute = $con->query($query);
        while ($row = $execute->fetch_assoc()) {
            if ($row['Username'] == $username && $row['Password'] == $password) {
                // populate session variables with query data
                $_SESSION["Username"] = $username;
                $_SESSION["Type"] = $row['Type'];
                $_SESSION["UserId"] = $row['UserId'];
                // redirect
                header('Location:home.php');
            } else {
                $msg = 'Credentials do not match our records';
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Plannetarium</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="css/login.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>
<div class="wrapper fadeInDown">

    <div id="formContent">
        <!-- Icon -->
        <div class="fadeIn first">
            <img src="img/login.png" id="icon" alt="User Icon"/>
        </div>
        <!-- Login Form -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <input type="text" id="username" class="fadeIn second" value="<?php echo $username ?>" name="username"
                   placeholder="username">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            <br>
            <span style="color:red"><?php echo $msg ?></span>
            <br>
            <input type="submit" name="submit" disabled class="fadeIn fourth" value="Log In" id="login">
            <div id="error"></div>
        </form>
        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="register.php">Register?</a>
        </div>

    </div>
</div>
</body>
</html>
<script>
    // username input must be longer than 4 characters
    $(document).ready(function () {
        $('#username').on('input', function (e) {
            var user = $('#username').val();
            if (user.length >= 4) {
                $("#login").prop("disabled", false);
            } else {
                $("#login").prop("disabled", true);
            }
        });
    });
</script>
