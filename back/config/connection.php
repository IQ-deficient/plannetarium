<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$database = 'plannerdb';

// db variables
$con = new mysqli($server, $user, $pass, $database);

if (!$con->connect_error) {
    return true;
} else {
    die("Connection error" . $con->connect_error);
}