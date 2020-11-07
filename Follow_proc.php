<?php include ("connect.php");?>

<?php
session_start();

//Grab the id and screen name of the user that the logged in user is following
if (isset($_POST["userID"])){
    $fromID = $_SESSION["SESS_MEMBER_ID"]; //this is the logged in user, or 'from_id'
    $toID = $_POST["userID"]; //the ID of the user that is being followed by our logged in user
    $followName = $_POST["userName"]; //the screen name of the user that is being followed by our logged in user
        
    //sql statement to insert follow record into the follow table
    $sql = "INSERT INTO follows(`from_id`,`to_id`) VALUES('$fromID', '$toID')";

    mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1){
        //if the table is updated successfully, return success message and send user to index page
        $msg = "Succesfully followed user: " . '@' . $followName;
        header("location: index.php?message=$msg");       
    }
    else{
        //if table is not updated successfully, return failure message and send user to index page
        $msg = "Problem following user, please try again.";
        header("location: index.php?message=$msg");
} 
}            

?>