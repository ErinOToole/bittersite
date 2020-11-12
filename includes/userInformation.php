<?php
session_start();
include("includes/connect.php");
$userID = $_SESSION["SESS_MEMBER_ID"];

if(isset($_SESSION["SESS_PROFILE_PIC"])){
    $picture = "images/profilepics/" . $_SESSION["SESS_PROFILE_PIC"]; //if the profile picture session variable is set, then it will be displayed
}
else{
    $picture = "images/profilepics/default.jfif"; //if it is not set, then the default image will display
}
//get the logged in user's first and last name
if(isset($_SESSION["SESS_FIRST_NAME"])){
    $firstName = $_SESSION["SESS_FIRST_NAME"];
    $lastName = $_SESSION["SESS_LAST_NAME"];
}



$sqlFollowing = "SELECT * FROM follows WHERE from_id = '$userID'";
$resultFollowing = mysqli_query($con, $sqlFollowing);
$noFollows = $resultFollowing->num_rows;

$sqlFollowers = "SELECT * FROM follows WHERE to_id = '$userID'";
$resultFollowers = mysqli_query($con, $sqlFollowers);
$noFollowers = $resultFollowers->num_rows;
?>