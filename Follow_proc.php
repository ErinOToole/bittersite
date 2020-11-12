<?php
include("includes/classes/user.php");
$u=$_SESSION["USER_INFO"];

//Grab the id and screen name of the user that the logged in user is following
if (isset($_POST["userID"])){
    User::Follow($u->userID, trim($_POST["userID"]), trim($_POST["userName"]));            
}
?>