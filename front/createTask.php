<?php
session_start();
include('../back/config/connection.php');
global $con;

// redirections
if (!isset($_SESSION["UserId"])) {
    header('Location:index.php');
}
if ($_SESSION["Type"] == "worker") {
    header('Location:home.php');
}

$check = true;
// form submit post input validation
if (isset($_POST['submit'])) {
    if (!empty($_POST['name'])) {
        if (strlen($_POST['name']) > 4) {
            $name = $_POST['name'];
        } else {
            $check = false;
        }
    } else {
        $check = false;
    }
    if (!empty($_POST['description'])) {
        if (strlen($_POST['description']) > 4) {
            $description = $_POST['description'];
        } else {
            $check = false;
        }
    } else {
        $check = false;
    }
    // validation passed
    if ($check) {
        $query = 'INSERT INTO tasks(id, name, description, time, userId, status) 
            VALUES (NULL,"' . $name . '","' . $description . '","' . $_POST['date'] . '",' . $_POST['worker'] . ',2)';
        $execute = $con->query($query);
        //redirect
        header('Location:home.php');
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <title>Plannetarium</title>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <link href="css/submitBtn.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: black;">
    <a class="navbar-brand" href="home.php" style="margin-top: 10px">Plannetarium</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04"
            aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">

        </ul>
        <form class="form-inline my-2 my-md-0">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown" style="margin-right: 35px;: ">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown04" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"
                       style="padding: 10px; font-size: large"><?php echo $_SESSION["Username"] ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="home.php">Home</a>
                        <?php
                        if ($_SESSION["Type"] == "Admin") {
                            echo '<a class="dropdown-item" href="manage.php">Manage</a>';
                        }
                        ?>
                        <a class="dropdown-item" href="userSettings.php">Settings</a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModalCenter" href="#">Log
                            out</a>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Log out</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="logout.php" class="btn btn-primary"
                   style="background-color: #1AA2D5FF;     border-color: #1AA2D5FF;">Log out</a>
            </div>
        </div>
    </div>
</div>
<div class="text-center col-xs-12 col-sm-10 col-md-6" style="margin: auto; padding: 20px">
    <!-- Material form contact -->
    <div class="card">

        <h5 class="card-header info-color white-text text-center py-4" style="background-color: #1AA2D5FF">
            <strong>Create Task</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">
            <!-- Form -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="text-center" style="color: black;">

                <!-- Name -->
                <div class="md-form mt-3">
                    <input type="text" id="name" name="name" class="form-control">
                    <label for="name">Name</label>
                </div>

                <!-- E-mail -->
                <div class="md-form">
                    <input type="text" id="description" name="description" class="form-control">
                    <label for="description">Description</label>
                </div>

                <!-- Subject -->
                <span>Worker</span>
                <div class="row d-flex justify-content-center">
                    <select class="form-control" name="worker" style="width: 180px; align-self: center">
                        <?php
                        $query = "SELECT username,id FROM users WHERE type = 2";
                        $execute = $con->query($query);
                        while ($row = $execute->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <!--date -->
                <div class="md-form row d-flex justify-content-center">
                    <input type="text" name="date" id="date" class="form-control" style="width: 170px">
                </div>
                <label for="date">Deadline(YYYY-MM-DD)</label>
                <!-- Send button -->
                <button id="create" class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect"
                        disabled name="submit" type="submit">Send</button>

            </form>
            <!-- Form -->

        </div>
    </div>
    <!-- Material form contact -->
</div>
<script>
    // DATE validation
    $(document).ready(function () {
        $("#date").on('input', function () {
            function isValidDate() {
                var dateString = $("#date").val();
                var regEx = /^\d{4}-\d{2}-\d{2}$/;
                if (!dateString.match(regEx)) {     // Invalid format
                    return false;
                }
                var d = new Date(dateString);
                var dNum = d.getTime();
                if (!dNum && dNum !== 0) return false; // NaN value, Invalid date
                return d.toISOString().slice(0, 10) === dateString;
            }

            // validation passed -> enable creation
            if (isValidDate()) {
                $("#create").prop("disabled", false);
            } else {
                $("#create").prop("disabled", true);
            }
        });
    });
</script>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="jquery-3.6.0.js"></script>
</body>