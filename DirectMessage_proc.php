<?php
include("includes/classes/user.php");
if(isset($_POST["button"])){
    $u=$_SESSION["USER_INFO"];
    $fromID = $u->userID;
    $screenName=$_POST["to"];
    $msgText=$_POST["message"];
}
$uMsg = User::GetUserByScreenName($screenName);
$toID = $uMsg->userID;
User::AreFollowing($fromID, $toID, $msgText);
