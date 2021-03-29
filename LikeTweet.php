<?php
include("includes/classes/user.php");
include("includes/classes/tweet.php");
$u = $_SESSION["USER_INFO"];
$tweetID = $_GET["tweet"];
Tweet::InsertLike($tweetID, $u->userID);




?>