<?php
//sessions-chapter 17
//internet is stateless - each request is separates and knows nothing about any other requests.

session_start(); //use this every time you want to use session variables
$_SESSION["name"] = "Erin"; //this is similar ot what you will put on login_proc page
//default session timeout is 20 minutes, but you can change it - default is good enough for now

echo "My session ID is: " . session_id(). "<BR>";
echo "All my session variables: " . session_encode() . "<BR>"; //good for debugging

echo $_SESSION["name"] . "<BR>";

//logout.php will look like this
session_unset(); // removes all session variables from memory
//session is still active but all the session variables are gone form memory
session_destroy(); // kills the session completely

//use both on logout page to be safe but probably only need session_destroy()
//redirect them back to the login page with the header(location)thing
echo "All my session variables Now: " . session_encode() . "<BR>";
    
