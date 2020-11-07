<?php include ("connect.php");?>
<?php
$userID = $_SESSION["SESS_MEMBER_ID"];

$sql = "Select first_name, last_name, screen_name, user_id FROM users"; //grab the first, last and screenname of everyone
$result = mysqli_query($con, $sql);
date_default_timezone_set("America/Halifax"); //set the date and timezone

while($row = mysqli_fetch_array($result)){ //get everyone's tweets using their userIDs
    $profileID = $row["user_id"];
    $sqltweets = "SELECT tweet_text, date_created FROM TWEETS WHERE user_id = '$profileID'";
    $resulttweets = mysqli_query($con, $sqltweets);
    
    //if the date stuff looks similar to Aude's it's because she helped me! 
    while($rowPrint = mysqli_fetch_array($resulttweets)){ //echo out the tweets to the homepage
        $date = new dateTime($rowPrint['date_created']);
        $today = new dateTime("now");
        $interval = $date->diff($today);
        echo '<div style="color: blue">'.$row["first_name"] . '' . $row["last_name"] . " @" . $row["screen_name"]. '</div>';
        echo '<i>'.$interval->format("%a days ago").'</i>';
        echo '<br>' . $rowPrint["tweet_text"] . '<br>';
        echo '<BR><img class="smallicon" src="images/like.ico">' . '<img class="smallicon" src="images/retweet.png">' . '<BR><HR>';
    }
}
?>

