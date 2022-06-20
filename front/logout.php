<?php
session_start();
// ends the current session
session_unset();
session_destroy();
// redirects the user to home page
header('Location: index.php');