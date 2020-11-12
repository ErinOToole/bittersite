<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tweet
 *
 * @author Erin O'Toole
 */
class Tweet {
    private $tweetID;
    private $originalTweetID;
    private $tweetText;
    private $replyToTweetID;
    private $userID;
    private $dateAdded;
    
    public function __construct($tweetID, $originalTweetID, $tweetText, $replyToTweetID, $userID, $dateAdded){
        $this->tweetID=$tweetID;
        $this->originalTweetID=$originalTweetID;
        $this->replyToTweetID=$replyToTweetID;
        $this->tweetText=$tweetText;
        $this->replyToTweetID=$replyToTweetID;
        $this->userID=$userID;
        $this->dateAdded=$dateAdded;
    }
    
    public function __destruct(){
        
    }
    
    public function __get($property){
        return $this->$property;
    }
    
    public function __set($property, $value){
        $this->$property=$value;
    }
    
    public static function CreateNewTweet($t){
        $sql = "INSERT INTO tweets (tweet_text, user_id) VALUES ('$t->tweetText', '$t->userID')";
        if(!empty($t->tweetText)){ 
            mysqli_query($GLOBALS['con'], $sql); //only want to put tweets in the db that are not blank
        
            if(mysqli_affected_rows($GLOBALS['con'])==1){
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
    
    public static function DisplayTweets($u){
        $sql = "Select users.first_name, users.last_name, users.screen_name, users.user_id, tweets.tweet_id, tweets.tweet_text, tweets.original_tweet_id, tweets.reply_to_tweet_id, tweets.date_created "
        . "FROM users INNER JOIN tweets ON users.user_id = tweets.user_id "
        . "WHERE tweets.user_id = '$u->userID' OR tweets.user_id IN (SELECT to_id FROM follows WHERE from_id = '$u->userID')"
        . " ORDER BY tweets.date_created DESC";
        $result = mysqli_query($GLOBALS['con'], $sql);
        date_default_timezone_set("America/Halifax");
        while($row = mysqli_fetch_array($result)){
            $userTweetID = $row["user_id"];
            $tweetFirstName = $row["first_name"];
            $tweetLastName = $row["last_name"];
            $tweetScreenName = $row["screen_name"];
            $tweet = $row["tweet_text"];
            $pic = User::GetFollowerPic($userTweetID);
            $now = new DateTime;
            $tweetDate = new dateTime($row["date_created"]);
            $diff = $now->diff($tweetDate);
            Self::FormatDisplayTweets($pic, $tweetFirstName, $tweetLastName, $tweetScreenName, $tweet, $diff, $userTweetID);  
        }
    }   
    
    public static function FormatDisplayTweets($pic, $tweetFirstName, $tweetLastName, $tweetScreenName, $tweet, $diff, $userTweetID){
        echo "<div class='mainprofile'>";
            echo "<a href='userpage.php?userID=$userTweetID'><img class='bannericons' img src= '$pic' ></a>" . " " . $tweetFirstName . " " . $tweetLastName . " " . "<a href='userpage.php?userID=$userTweetID'><strong>@" . $tweetScreenName . "</strong></a><br>";
            echo "<br>" . $tweet . "<br>";
            echo Self::FormatTweetTime($diff);
            echo "<img class='smallicon' src='images/like.ico'>" . "<img class='smallicon' src='images/retweet.png'>" . "<BR><HR>";
            echo "</div>";
    }
    
    public static function FormatTweetTime($diff){
        if($diff->y>1) echo "<BR>" . $diff->format("%y years") ." ago<BR>";
        elseif($diff->y >0) echo "<BR>" . $diff->format("%y year") ." ago<BR>";
        elseif($diff->m >1) echo "<BR>" . $diff->format("%m months") ." ago<BR>";
        elseif($diff->m >0) echo "<BR>" . $diff->format("%m month") ." ago<BR>";
        elseif($diff->d >1) echo "<BR>" . $diff->format("%d days") ." ago<BR>";
        elseif($diff->d >0) echo "<BR>" . $diff->format("%d day") ." ago<BR>";
        elseif($diff->h >1) echo "<BR>" . $diff->format("%h hours") ." ago<BR>";
        elseif($diff->h >0) echo "<BR>" . $diff->format("%h h") ." ago<BR>";
        elseif($diff->i >1) echo "<BR>" . $diff->format("%i minutes") ." ago<BR>";
        elseif($diff->i >0) echo "<BR>" . $diff->format("%i minute") ." ago<BR>";
        elseif($diff->s >1) echo "<BR>" . $diff->format("%s seconds") ." ago<BR>";
        elseif($diff->s >0) echo "<BR>" . $diff->format("%s second") ." ago<BR>";
    }
    
    public static function GetNoOfTweets($userID){
        $sql = "SELECT * FROM tweets WHERE user_id = '$userID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $noTweets = $result->num_rows;
        echo $noTweets;
    }
}
