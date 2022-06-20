<?php
session_start();
include('../back/config/connection.php');
global $con;

if (!isset($_SESSION["UserId"])) {
    header('Location:index.php');
}

if (isset($_POST['submitComplete'])) {
    $id = $_POST['id'];
    $query = "UPDATE tasks SET status=1 WHERE id=" . $id;
    $execute = $con->query($query);
    header('Location:taskDetails.php?id=' . $id);
}
if (isset($_POST['submitCancel'])) {
    $id = $_POST['id'];
    $query = "UPDATE tasks SET status=3 WHERE id=" . $id;
    $execute = $con->query($query);
    header('Location:taskDetails.php?id=' . $id);
}

// fill the $id variable only if current userId matches the userId of requested Task
$currentUserId = $_SESSION["UserId"];
$currentTaskId = $_GET["id"];
$query = "SELECT t.userId FROM tasks t WHERE t.id =" . $currentTaskId . " AND t.userId=" . $currentUserId;
$result = $con->query($query);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
//        echo "nesto: " . $row["userId"] . "<br>";
        if ($row["userId"] == $currentUserId) {
            $id = $currentTaskId;
        }
    }
} else if ($_SESSION["Type"] == "Admin" || $_SESSION["Type"] == "Manager") {
    $id = $currentTaskId;
} else {
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
    // temporary solution
//    echo "0 results";
}
// also fill if user type
if ($_SESSION["Type"] == "Admin" || $_SESSION["Type"] == "Manager") {
    $id = $currentTaskId;
}

//if (isset($_GET['id'])) {
//    $id = $_GET['id'];
//}
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
                        if ($_SESSION["Type"] == "Admin" || $_SESSION["Type"] == "Manager") {
                            echo '<a class="dropdown-item" href="createTask.php">Create Task</a>';
                        }
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
<div class="text-center" style="width: 70%; margin: auto; padding: 20px">
    <h1 id="title"></h1>
    <div id="status"></div>
    <div id="description" class="card col-xs-12 col-md-8" style="width: 100%;margin: auto">
    </div>
    <br><br>
    <h2>Deadline:</h2>
    <div id="deadline" class="card" style="margin: auto;width: 200px;padding: 12px">
    </div>
</div>
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
                   style="background-color: #5fbae9;     border-color: #5fbae9;">Log out</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "../back/controllers/readFor/readForId.php",
            data: {id: "<?php echo $id?>"},
            dataType: "JSON",
            success: function (data) {
                // console.log(data)
                $("#title").text(data[0].Name);
                if (data[0].Status == "completed") {
                    $("#status").append("<h3 style='color: darkgreen'>" + data[0].Status.toUpperCase() + "</h3>");
                } else if (data[0].Status == "active") {
                    $("#status").append("<h3 style='color: #5fbae9'>" + data[0].Status.toUpperCase() + "</h3>");
                    $("#status").append("<form method='post' action='taskDetails.php'>" +
                        "<input type='hidden' name='id' value='" + data[0].TaskId + "'><a id='completeTask'>" +
                        "<input type='submit' class='btn btn-primary' " +
                        "style='background-color:#5fbae9;border-color:#5fbae9;' name='submitComplete' " +
                        "value='Complete Task'></form></a><br>");
                    if ("<?php echo $_SESSION["Type"]?>" == "Admin" || "<?php echo $_SESSION["Type"]?>" == "Manager") {
                        $("#status").append("<form method='post' action='taskDetails.php'>" +
                            "<input type='hidden' name='id' value='" + data[0].TaskId + "'>" +
                            "<a id='cancelTask'><input type='submit' class='btn btn-primary' " +
                            "style='background-color:#5fbae9;border-color:#5fbae9;' name='submitCancel' " +
                            "value='Cancel Task'></form></a><br><br>");
                    }
                } else if (data[0].Status == "canceled") {
                    $("#status").append("<h3 style='color: darkred'>" + data[0].Status.toUpperCase() + "</h3>");
                }
                $("#description").text(data[0].Description);
                $("#deadline").text(data[0].Time);
            }, error: function (request) {
                console.log(request.responseText);
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
</html>
