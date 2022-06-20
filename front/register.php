<?php
// session variables
session_start();
include('../back/config/connection.php');
global $con;

// already logged in check and redirect
if (isset($_SESSION["UserId"])) {
    header('Location:home.php');
}

$username = $password = $usernameErr = $passwordErr = "";
$check = true;

if (isset($_POST['submit'])) {
    // input data (username & password) validation
    if (!empty($_POST['username'])) {
        if (strlen($_POST['username']) <= 20) {
            $username = $_POST['username'];
        } else {
            $usernameErr = "Username is too long";
            $check = false;
        }
    } else {
        $usernameErr = "Username is empty";
        $check = false;
    }
    if (!empty($_POST['password'])) {
        if (strlen($_POST['password']) <= 20) {
            $password = $_POST['password'];
        } else {
            $passwordErr = "Password is too long";
            $check = false;
        }
    } else {
        $passwordErr = "Password is empty";
        $check = false;
    }
    // validation passed
    if ($check) {

        // user already exists check
        $check1 = true;
        $query = "SELECT username FROM users";
        $execute = $con->query($query);
        while ($row = $execute->fetch_assoc()) {
            if (strtolower($username) == strtolower($row['username'])) {
                $check1 = false;
                $usernameErr = "User with that name already exists";
                break;
            }
        }
        // passed validation
        if ($check1) {
            // registers the user
            $query = "INSERT INTO users(id, username, password, type) VALUES (NULL,'" . $username . "','" . $password . "',2)";
            $execute = $con->query($query);

            $query1 = 'SELECT u.id AS UserId, u.username AS Username, u.password AS Password,
                t.name AS Type FROM users u,usertype t WHERE t.id=u.type AND u.username=' . '"' . $username . '"';
            $execute = $con->query($query1);
            $row = $execute->fetch_assoc();
            // populate session variables with query data
            $_SESSION["Username"] = $username;
            $_SESSION["Type"] = $row['Type'];
            $_SESSION["UserId"] = $row['UserId'];
            // redirect
            header('Location:home.php');
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
            <input type="text" id="username" class="fadeIn second" name="username" placeholder="username">
            <br>
            <span style="color: red;"><?php echo $usernameErr ?></span>
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            <br>
            <span style="color: red;"><?php echo $passwordErr ?></span>
            <br>
            <input type="submit" name="submit" disabled class="fadeIn fourth" value="Register" id="login">
        </form>
        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="login.php">Already registered? Login in!</a>
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
