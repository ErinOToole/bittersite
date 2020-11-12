<?php include("includes/classes/user.php");
if(isset($_POST["submit"])){
    User::ChangeProfilePic($_SESSION["USER_INFO"]);
}







?>