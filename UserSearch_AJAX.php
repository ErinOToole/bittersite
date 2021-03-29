<?php
include("includes/classes/user.php");
//When this page is run in a browser on it's own, I can see my array of usernames. The datalist isn't populating with them.
//$screenName = "mpond"; //this is returning {"username":"mpond"}, so I know my echoed output is right. 
//Update: It's giving me a dropdown now but I have a fun new error!
$screenName=$_GET["to"];
echo User::PopulateUsers($screenName);
//header("location:DirectMessage.php");


?>