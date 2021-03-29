<?php
include("includes/classes/user.php");
include("includes/classes/tweet.php");
$u = $_SESSION["USER_INFO"];
if(isset($_GET["tweetID"])){
    Tweet::Retweet($_GET["tweetID"], $u->userID);
}

?>
