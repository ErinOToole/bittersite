<?php
//calls the DisplayTweets method from the Tweet class, using the object held in session variables
Tweet::DisplayTweets($_SESSION["USER_INFO"]);
?>

