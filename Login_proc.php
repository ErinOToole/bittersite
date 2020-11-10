<?php
include ("connect.php");
session_start();

//Get user input from form
$userName = strtolower($_POST["username"]); //putting username to lowercase to make comparisons easier
$passWord = $_POST["password"];

//grab the password from the database that matches the username
$sql = "SELECT user_id, first_name, last_name, screen_name, password FROM USERS WHERE screen_name = '$userName'";

$result = mysqli_query($con, $sql);
//return array to variable
$rowUser = mysqli_fetch_array($result);
//put returned password into a variable to check it
$myHash = $rowUser["password"]; 

//compare the password in the database to the password entered by the user
if(password_verify($passWord, $myHash)){
    //if the passwords match then set session variables and direct to index.php
    $_SESSION["SESS_FIRST_NAME"] = $rowUser["first_name"];
    $_SESSION["SESS_LAST_NAME"] = $rowUser["last_name"];
    $_SESSION["SESS_MEMBER_ID"] = $rowUser["user_id"];
    $userID = $_SESSION["SESS_MEMBER_ID"]; //putting the user_id into a variable so it is easier to concatenate in the sql string
    
    //check to see if the profile picture field for the user is empty in the database
    $sqlPic = "SELECT profile_pic FROM users where user_id = '$userID' AND profile_pic != ''"; 
    
    $resultPic = mysqli_query($con, $sqlPic);
    
    if(mysqli_num_rows($resultPic) > 0){ //if a row comes back, it means the user has a profile picture stored and it will be set as the session variable.
        $rowPic = mysqli_fetch_array($resultPic);
        $_SESSION["SESS_PROFILE_PIC"] = $rowPic["profile_pic"];
    }
    //If user is successfully authenticated, they are redirected to the index page 
    header("location: index.php");
}
else{
    //if unsuccessful then display error message and direct back to Login.php
    $msg = 'Authentication Error: Please try again';
    header("Location: login.php?message=$msg");
}
?>