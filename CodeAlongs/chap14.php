<?php
//header() sends a raw HTTP header to the browser
function authenticate() {
    //this would be for hard-coded username/password, sometimes useful if you 
    //don't have a database
    //echo $_SERVER["PHP_AUTH_USER"] . "<BR>";
    if ((isset($_SERVER["PHP_AUTH_USER"]) && ($_SERVER['PHP_AUTH_USER'] == 'client') && //client is username
        isset($_SERVER['PHP_AUTH_PW']) && ($_SERVER["PHP_AUTH_PW"] == 'secret'))) { //secret is password
            header('HTTP/1.0 200 OK'); //all is good!
    }
    else {
        //don't let them in!
        header('WWW-Authenticate: Basic realm="Test Authentication System"');
        header('HTTP/1.0 401 Unauthorized');
        echo "You must enter a valid login ID and password to access this resource\n";
    }
    exit;//stop execution of the program so we don't get any more errors
}//end authenticate method
if(!isset($_SERVER["PHP_AUTH_USER"])){
    Authenticate();
}
else{
    
}
    ?>
    <p>
        Welcome, <?=$_SERVER["PHP_AUTH_USER"]?>
    
    <form action='' method='post'>
    <input type='hidden' name='SeenBefore' value='0' />
    <input type='text' name='OldAuth' value=""/>
    <input type='submit' value='Re Authenticate' />
    </form></p>
<?php
//hints for sprint #3
//imagine this on signup_proc.php
$myPassword = "hello";//$_POST["password"];
$myHash = password_hash($myPassword, PASSWORD_DEFAULT);



//this will go in login_proc
echo password_verify($myPassword, $myHash) . "<BR>";

?>
