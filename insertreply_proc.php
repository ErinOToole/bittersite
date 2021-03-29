<?php
//form that is displayed on reply_proc leads here when the submit button is pressed
include("includes/classes/user.php");
include("includes/classes/tweet.php");
$u = $_SESSION["USER_INFO"];

if(isset($_POST["replybutton"])){ //if the button is pressed
    $replyTweet = $_POST["replytweet"]; //grabs the reply that user entered

    $originalTweetID = $_POST["originalTweetID"]; //original tweet, now the "reply_to_tweet_id
    $originalTweet = $_POST["originaltweet"]; //the original tweet that user is replying to
    $userID = $u->userID; //logged in user's id grabbed from object in session variables
    
    $t=new Tweet(null, null, $replyTweet, $originalTweetID, $userID, null);
    Tweet::CreateNewReplyTweet($t);
}
?>