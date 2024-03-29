<?php
// redirect
session_start();
if (isset($_SESSION["UserId"])) {
    header('Location:home.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/front.css" rel="stylesheet">
    <title>Plannetarium</title>
</head>
<body class="body">
<section class="jumbotron text-center">
    <div class="container">
        <div class = "right-side">
            <a href="login.php" ><span>Log in</span></a>
            <a href="register.php"><span>Register</span></a>
        </div>
        <h1 class="main-Text">Plannetarium</h1>
        <p class="lead text-muted" id="header-text">Plan out your business with our simple app, less is more!</p>
<!--        <p>-->
<!--            <a href="login.php" class="btn btn-primary ">Log in</a>-->
<!--            <a href="register.php" class="btn btn-secondary">Register</a>-->
<!--        </p>-->
    </div>
</section>
<div class="album text-muted">
    <div class="container">
        <div class="row">
            <div class="card col-xs-12 col-md-5">
                <img data-src="holder.js/100px280/thumb" alt="pic1" style="height: 280px; width: 100%; display: block;"
                     src="img/left.jpg" data-holder-rendered="true">
                <p class="card-text">Add participants to your project and assign them tasks with time limits and
                    locations!</p>
            </div>
            <div class="col-xs-12 col-md-2">
            </div>
            <div class="card col-xs-12 col-md-5" >
                <img data-src="holder.js/100px280/thumb" alt="pic2" src="img/right.jpg"
                     data-holder-rendered="true" style="height: 280px; width: 100%; display: block;">
                <p class="card-text">Manage users and change their permisions!</p>
            </div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>