<?php

$fh = fopen("students.txt", "r"); //open a file as read-only
//suppress the errors - don't display/hide them. 
ini_set("Display_errors", 0); //modify the php.ini file, 0 equals false as in, turn them off.
error_reporting(E_ERROR); //or E_ALL. Dynamically change your php.ini file from your php code


try{
    if(!mysqli_connect("localhost", "username", "password", "schema")){
        throw new Exception("Error connecting to database");
    }
    
    $result = fwrite($fh, "I can't do this because it's read only"); //try to write to the file, returns boolean
    //echo $result . "<BR>"; //returns a 0 because it doesn't work.
    //echo $resulthshsh . "<BR>";
    if($result == 0) throw new Exception("Error writing to file");
    
} catch (Exception $ex) {
    error_log("ERROR IN FILE" . $ex->getFile() . " on line#" . $ex->getLine() . ": " . $ex->getMessage() . "<BR>");
    echo "error occured<BR>";
    exit; //stop execution of the program
}
finally{
    //this code is going to execute either way, exception or not.
    fclose($fh); //close the file
}

