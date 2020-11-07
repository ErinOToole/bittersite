<?php include ("connect.php");?>
<?php 
session_start();
$userID = $_SESSION["SESS_MEMBER_ID"];
//grab the tweet from the form and the userID from the session variable
if(isset($_POST["button"])){
    $tweet = $_POST["myTweet"];
    
    
    $msg="";
    
    $sql = "INSERT INTO tweets (tweet_text, user_id) VALUES ('$tweet', '$userID')";
    
    if($tweet != " "){
        mysqli_query($con, $sql); //only want to put tweets in the db that are not blank
        
        if(mysqli_affected_rows($con)==1){
            $msg="Tweet Successfully saved";
            header("Location: index.php?message=$msg");
        }
        else{
            $msg="Something went wrong, please try again later";
            header("Location: index.php?message=$msg");
        }
    
    }
    else{
        $msg = "You must tweet actual words";
        header("Location: index.php?message=$msg");
        exit();
    }
    
    
    

}

?>