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
    
    $now = new DateTime;
    $tweetDate = new dateTime($row["date_created"]);
    $diff = $now->diff($tweetDate);
    
    
    echo '<div class="mainprofile">'. formatText($tweetFirstName, $tweetLastName,$tweetScreenName);
    echo '<br>' . $tweet . '<br>';
    echo formatTime($diff);
    echo '<BR><img class="smallicon" src="images/like.ico">' . '<img class="smallicon" src="images/retweet.png">' . '<BR><HR>';
    echo '</div>';
    //figure out dates
    }
    
    function formatText($tweetFirstName, $tweetLastName, $tweetScreenName){
    $formattedString = $tweetFirstName . ' ' . $tweetLastName . ' ' . '<strong>@' .$tweetScreenName . '</strong><br>';
    return $formattedString;
    }
    
    function formatTime($diff){
        if($diff->y>1) echo $diff->format("%y years") ." ago<BR>";
    elseif($diff->y >0) echo $diff->format("%y year") ." ago<BR>";
    elseif($diff->m >1) echo $diff->format("%m months") ." ago<BR>";
    elseif($diff->m >0) echo $diff->format("%m month") ." ago<BR>";
    elseif($diff->d >1) echo $diff->format("%d days") ." ago<BR>";
    elseif($diff->d >0) echo $diff->format("%d day") ." ago<BR>";
    elseif($diff->h >1) echo $diff->format("%h hours") ." ago<BR>";
    elseif($diff->h >0) echo $diff->format("%h h") ." ago<BR>";
    elseif($diff->i >1) echo $diff->format("%i minutes") ." ago<BR>";
    elseif($diff->i >0) echo $diff->format("%i minute") ." ago<BR>";
    elseif($diff->s >1) echo $diff->format("%s seconds") ." ago<BR>";
    elseif($diff->s >0) echo $diff->format("%s second") ." ago<BR>";
    }
    
        
        
    

?>

