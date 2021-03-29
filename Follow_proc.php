<?php
include("includes/classes/user.php");
$u=$_SESSION["USER_INFO"];

//Grab the id and screen name of the user that the logged in user is following
    User::Follow($u->userID, $_GET["userID"], $_GET["userName"]);
?>