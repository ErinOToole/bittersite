<?php
include("includes/classes/user.php");
User::AuthenticateLogin(strtolower($_POST["username"]), $_POST["password"]); 
?>