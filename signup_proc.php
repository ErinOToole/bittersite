
<?php
include("includes/classes/user.php");
//Checks to see if the user ID session variable is set. If it is, then they're logged in and get redirected to index.php
if(isset($_SESSION["SESS_MEMBER_ID"])){
    header("location: index.php");
}
if(isset($_POST["button"])){
$u = new User(null, strtolower($_POST["username"]), password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["firstname"], $_POST["lastname"], $_POST["address"], $_POST["province"], $_POST["postalCode"], $_POST["phone"], $_POST["email"], null, null, $_POST["location"], $_POST["desc"], $_POST["url"]);
User::UsernameExists($u);
}
?>