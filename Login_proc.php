<?php include ("connect.php");?>
<?php 
session_start();
//verify the user's login credentials. if they are valid redirect them to index.php/
//if they are invalid send them back to login.php

//Get user input from form
//putting username to lowercase to make comparisons easier
$userName = strtolower($_POST["username"]);
$passWord = $_POST["password"];

//grab the password from the database that matches the username
$sql = "SELECT user_id, first_name, last_name, screen_name, password FROM USERS WHERE screen_name = '$userName'";

$result = mysqli_query($con, $sql);
//return array to variable
$rowUser = mysqli_fetch_array($result);
$myHash = $rowUser["password"];

//compare the password in the database to the password entered by the user
if(password_verify($passWord, $myHash)){
    //if the passwords match then set session variables and direct to index.php
    $_SESSION["SESS_FIRST_NAME"] = $rowUser["first_name"];
    $_SESSION["SESS_LAST_NAME"] = $rowUser["last_name"];
    $_SESSION["SESS_MEMBER_ID"] = $rowUser["user_id"];
    //If succesfuly, redirect to index 
    header("location: index.php");
}
else{
    //if unsuccessful then display error message and direct back to Login.php
    $msg = 'Authentication Error: Please try again';
    header("Location: login.php?message=$msg");
}


?>