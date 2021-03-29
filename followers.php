
<?php
//displays potential followers using the DisplayFollowers function of the user class
//takes in the user object of currently logged in user
User::DisplayFollowers($_SESSION["USER_INFO"]);
?>
