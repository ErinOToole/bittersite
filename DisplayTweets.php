<?php
include ("connect.php");
$userID = $_SESSION["SESS_MEMBER_ID"];

//refactored code, got rid of while loops and used an inner join for sql statement. 
//fixed issue where all user's tweets were showing up.
$sql = "Select users.first_name, users.last_name, users.screen_name, users.user_id, tweets.tweet_id, tweets.tweet_text, tweets.original_tweet_id, tweets.reply_to_tweet_id, tweets.date_created "
        . "FROM users INNER JOIN tweets ON users.user_id = tweets.user_id "
        . "WHERE tweets.user_id = '$userID' OR tweets.user_id IN (SELECT to_id FROM follows WHERE from_id = '$userID')"
        . " ORDER BY tweets.date_created DESC";
$result = mysqli_query($con, $sql);
date_default_timezone_set("America/Halifax"); //set the date and timezone

while($row = mysqli_fetch_array($result)){
    //put all user information into variables
    $userTweetID = $row["user_id"];
    $tweetFirstName = $row["first_name"];
    $tweetLastName = $row["last_name"];
    $tweetScreenName = $row["screen_name"];
    $tweet = $row["tweet_text"];
    $tweetDate = new dateTime($row["date_created"]);
    
    echo '<div style="color: blue">'. $tweetFirstName . '' . $tweetLastName . " @" . $tweetScreenName . '</div>';
    echo '<br>' . $tweet . '<br>';
    echo '<BR><img class="smallicon" src="images/like.ico">' . '<img class="smallicon" src="images/retweet.png">' . '<BR><HR>';
    //figure out dates
    }
    
    function time_elapsed($date){
        $now = new DateTime;
        $ago = new DateTime($date);
        $diff = $now->diff($ago);
        
    }

?>

