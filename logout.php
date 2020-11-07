<?php

//unset the session variables and "log out" the user
session_start();
session_unset();
session_destroy();
//redirect them to the login page
header("location: login.php");
?>
