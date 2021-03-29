<?php
include("includes/classes/user.php");
//grabs the username and password entered by the user and authenticates them using the AuthenticateLogin function
User::AuthenticateLogin(strtolower($_POST["username"]), $_POST["password"]); 
?>