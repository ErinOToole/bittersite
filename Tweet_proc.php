<?php 
include("includes/classes/tweet.php");
include("includes/classes/user.php");
$u = $_SESSION["USER_INFO"];
if(isset($_POST["button"])){
    $t = new Tweet(null, null, $_POST["myTweet"], null, $u->userID, null);
    Tweet::CreateNewTweet($t);   
}
?>