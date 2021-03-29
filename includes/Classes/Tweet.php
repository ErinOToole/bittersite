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
    
    //insert new tweets into db
    public static function CreateNewTweet($t){
        $sql = "INSERT INTO TWEETS (tweet_text, user_id) VALUES ('$t->tweetText', '$t->userID')";
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
    }//end CreateNewTweet()
    
    //function that displays tweets on page load
    public static function DisplayTweets($u){
        $sql = "SELECT users.first_name, users.last_name, users.screen_name, users.user_id, tweets.tweet_id, tweets.tweet_text, tweets.original_tweet_id, tweets.reply_to_tweet_id, tweets.date_created "
        . "FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id "
        . "WHERE tweets.user_id = '$u->userID' OR tweets.user_id IN (SELECT to_id FROM FOLLOWS WHERE from_id = '$u->userID')"
        . " ORDER BY tweets.date_created DESC LIMIT 15";
        $result = mysqli_query($GLOBALS['con'], $sql);
        date_default_timezone_set("America/Halifax");
        while($row = mysqli_fetch_array($result)){
            $now = new DateTime;
            $tweetDate = new dateTime($row["date_created"]);
            $diff = $now->diff($tweetDate);
            Self::FormatDisplayTweets(User::GetFollowerPic($row["user_id"]), $row["first_name"], $row["last_name"], $row["screen_name"], $row["tweet_text"], $diff, $row["user_id"], $row["tweet_id"], $u->userID);  
        }
    } //end DisplayTweets()  
    
    //Formats how the tweets are displayed
    public static function FormatDisplayTweets($pic, $tweetFirstName, $tweetLastName, $tweetScreenName, $tweet, $diff, $userTweetID, $tweetID, $userID){
          echo "<div class='container'>";
          echo "<a href='userpage.php?userID=$userTweetID'><img class='bannericons' img src= '$pic' ></a>" . " " . $tweetFirstName . " " . $tweetLastName . " " . "<a href='userpage.php?userID=$userTweetID'><strong>@" . $tweetScreenName . "</strong></a>" . " " . Self::IsOriginal($tweetID) . Self::IsAReply($tweetID). "<HR>";
          echo "<div class=\"tab\">";
          echo "<div class=\"bold\">";
          echo "<BR>" . $tweet . "<BR>";
          echo Self::FormatTweetTime($diff) . "<HR>";
          echo "<a href='liketweet.php?tweet=$tweetID'><img class='smallicon' src='".Self::LikeImage($tweetID, $userID) ."'></a>" . "<a href='retweet_proc.php?tweetID=$tweetID'><img class='smallicon' src='images/retweet.png'></a>" . "<a href='reply_proc.php?tweet=$tweetID'><img class='smallicon' src='images/reply.png'></a>";
          echo "</div>";
          echo "</div>";
          echo "<BR>";
          echo "</div>";
    }//end FormatDisplayTweets()
    
    //Function that checks if the tweet being displayed is an original or a retweet
    public static function IsOriginal($tweetID){
        $myString = "";
        $sql= "SELECT original_tweet_id FROM TWEETS WHERE tweet_id = $tweetID";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        if($row["original_tweet_id"] > 0){
            
            $myString = " <b>retweeted</b> " . " " .User::GetUserByTweetID($row["original_tweet_id"]);
        }
        return $myString;
    }//end IsOriginal();
    
    //function that checks if the tweet being displayed is a reply to another tweet
    public static function IsAReply($tweetID){
        $myString = "";
        $sql = "SELECT reply_to_tweet_id FROM TWEETS WHERE tweet_id = $tweetID";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        if($row["reply_to_tweet_id"] > 0){
            $sql2 = "SELECT tweet_id, tweet_text, user_id FROM tweets WHERE tweet_id =". $row["reply_to_tweet_id"];
            $result2 = mysqli_query($GLOBALS['con'], $sql2);
            $row2 = mysqli_fetch_array($result2);
            
            $user = User::GetUserByTweetID($row2["tweet_id"]);
            $myString = "<b>replied to </b>" . $user . "<BR>" . $row2["tweet_text"];
        }
        return $myString;
    }//End IsAReply()
    
    //Formats the time stamps on the tweets
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
    }//end FormatTweetTime()
    
    //gets number of tweets, used on the index page and userpage
    public static function GetNoOfTweets($userID){
        $sql = "SELECT * FROM TWEETS WHERE user_id = '$userID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $noTweets = $result->num_rows;
        echo $noTweets;
    }//end GetNoOfTweets()
    
    //function that inserts a retweet into the db
     public static function ReTweet($tweetID, $userID){
        $sql = "SELECT tweet_id, tweet_text, user_id, original_tweet_id FROM TWEETS WHERE tweet_id = '$tweetID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
            $tweetText= $row["tweet_text"];
        
        $sqlRetweet = "INSERT INTO TWEETS(tweet_text, user_id, original_tweet_id) VALUES('$tweetText', '$userID', '$tweetID')";
        mysqli_query($GLOBALS['con'], $sqlRetweet);
        
        if(mysqli_affected_rows($GLOBALS['con'])==1){
            $msg="Tweet successfully retweeted!";
            header("location: index.php?message=$msg");
        }
        else{
            $msg="Error Occured";
            header("location: index.php?message=$msg");
        }
     }//end ReTweet()
     
     //function that finds a tweet by it's tweet_id value
     public static function FindTweetByID($tweetID){
         $sql = "SELECT tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created FROM TWEETS WHERE tweet_id = '$tweetID'";
         $result = mysqli_query($GLOBALS['con'], $sql);
         $row = mysqli_fetch_array($result);
         $t = new Tweet(null, $row["original_tweet_id"], $row["tweet_text"], null, null, null);
         return $t;
     }//end FindTweetByID()
    
     //function that creates a new Reply tweet and inserts it into the db
     public static function CreateNewReplyTweet($t){
        $sql = "INSERT INTO TWEETS (tweet_text, user_id, reply_to_tweet_id) VALUES ('$t->tweetText', '$t->userID', '$t->replyToTweetID')";
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
    }//end CreateNewReplyTweet()
    public static function GetTweetsByUser($u){
        $sql = "SELECT users.first_name, users.last_name, users.screen_name, users.user_id, tweets.tweet_id, tweets.tweet_text, tweets.original_tweet_id, "
                . "tweets.reply_to_tweet_id, tweets.date_created FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id "
                . "WHERE users.user_id = '$u->userID'"
                . "ORDER BY tweets.date_created DESC LIMIT 8";
        $result = mysqli_query($GLOBALS['con'], $sql);
        date_default_timezone_set("America/Halifax");
        if($result->num_rows == 0){
            echo "<div class=\"tab\">" . $u->firstName . " " . $u->lastName . "(<a href='userpage.php?userID=$u->userID'><strong>@" .$u->userName. ")</strong></a> has not tweeted yet.</div>";
        }
        while($row = mysqli_fetch_array($result)){
            $now = new DateTime;
            $tweetDate = new dateTime($row["date_created"]);
            $diff = $now->diff($tweetDate);
            Self::FormatDisplayTweets(User::GetFollowerPic($row["user_id"]), $row["first_name"], $row["last_name"], $row["screen_name"], $row["tweet_text"], $diff, $row["user_id"], $row["tweet_id"]);

        }
    }//end GetTweetsByUser()
     public static function searchTweets($searchContent){
        $sql= "SELECT * FROM USERS WHERE first_name LIKE '%$searchContent%' OR screen_name LIKE '%$searchContent%' OR last_name LIKE '%$searchContent'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        if($result->num_rows ==0){
            echo "<h4>No tweets found for " . "<b><i>$searchContent</i></b></h4>"; 
        }
        else{
            echo "<h4>Tweets found for " . "<b><i>" . $searchContent. "</i>.</b></h4>";
            while($row = mysqli_fetch_array($result)){
            //create new user object for the search result
            $u = new User($row["user_id"], $row["screen_name"], $row["password"], $row["first_name"], $row["last_name"], $row["address"], $row["province"], $row["postal_code"], $row["contact_number"], $row["email"], $row["date_created"], $row["profile_pic"], $row["location"], $row["description"], $row["url"]);
            echo "<BR>";
            
            echo "<div class =\"tab\">";
            Tweet::GetTweetsByUser($u);
            echo "</div>";   
            }
        }
    }
    public static function likeImage($tweetID, $userID){
        $img = "";
        if(Self::LikeExists($tweetID, $userID)){
           $img = "images/liked.jpg";
        }
        else{
            $img="images/like.ico";
        }
        return $img;
    }
    public static function LikeExists($tweetID, $userID){
        $sql="SELECT * FROM LIKES WHERE tweet_id = '$tweetID' AND user_id='$userID'";
        $result=mysqli_query($GLOBALS['con'], $sql);
        if(mysqli_affected_rows($GLOBALS['con'])==0){
            return false; //like doesn't exist
        }
        else{
            return true; //like exists
        }
    }
    public static function InsertLike($tweetID, $userID){
        if(!Self::LikeExists($tweetID, $userID)){ //if like doesn't exist
            $sql = "INSERT INTO LIKES (tweet_id, user_id) VALUES ('$tweetID', '$userID')"; //insert it
            mysqli_query($GLOBALS['con'], $sql);
            if(mysqli_affected_rows($GLOBALS['con'])==1){
                header("Location: index.php");
            }
            else{
                $msg="Something went wrong, please try liking that tweet again later";
                header("Location:index.php?message=$msg");
            }
        }
        else{
            $sql = "DELETE FROM LIKES WHERE tweet_id = '$tweetID' AND user_id='$userID'"; //delete likes from the table when the image is clicked on again
            mysqli_query($GLOBALS['con'], $sql);
            header("Location:index.php");
        }
        
    }
    public static function FormatNotifications($userID, $firstname, $lastname, $screenname, $diff, $tweet, $tweetID, $myString){
                echo "<div class='container'>";
                echo "<a href='userpage.php?userID=$userID'><img class='bannericons' img src= '" .User::GetFollowerPic($userID) ."' ></a>" . " " . $firstname . " " . $lastname . " " . "<a href='userpage.php?userID='" . $userID ."'><strong>@" . $screenname . "</strong></a>" .$myString ;
                echo "<div class=\"tab\"><div class=\"bold\">";
                echo "<BR>" . $tweet. "<BR>";
                echo "<a href='liketweet.php?tweet='" .$tweetID ."><img class='smallicon' src='".Self::LikeImage($tweetID, $userID) ."'></a>" . "<a href='retweet_proc.php?tweetID='" . $tweetID . "'><img class='smallicon' src='images/retweet.png'></a>" . "<a href='reply_proc.php?tweet=" . $tweetID . "'><img class='smallicon' src='images/reply.png'></a>";
                echo Self::FormatTweetTime($diff) . "<HR>"; 
                echo "</div></div><BR></div>";
    }
    public static function GetNotifications($userID){
        Self::GetLikeNotif($userID);
        Self::GetRetweetNotif($userID);
        Self::GetReplyNotif($userID);
    }
    public static function GetLikeNotif($userID){
        $sql = "SELECT likes.tweet_id, likes.user_id, likes.date_created, tweets.tweet_id, tweets.tweet_text FROM LIKES INNER JOIN TWEETS ON likes.tweet_id=tweets.tweet_id WHERE tweets.user_id ='$userID'ORDER BY date_created DESC";
        $result=mysqli_query($GLOBALS['con'], $sql);
        echo "<h4><b><i>Recently Liked Tweets: </i></b></h4><BR/>";
        while($row = mysqli_fetch_array($result)){
           $lUserID = $row["user_id"];
           $sql2 = "Select first_name, last_name, screen_name FROM USERS where user_id='$lUserID'";
           $result2=mysqli_query($GLOBALS['con'], $sql2);
           while($row2=mysqli_fetch_array($result2)){
                $now = new DateTime;
                $tweetDate = new dateTime($row["date_created"]);
                $diff = $now->diff($tweetDate);
                $myString = " liked your tweet";
                Self::FormatNotifications($row["user_id"], $row2["first_name"], $row2["last_name"], $row2["screen_name"], $diff, $row["tweet_text"], $row["tweet_id"], $myString);
           }
        }        
    }
    public static function GetRetweetNotif($userID){
        $sql = "SELECT tweet_id FROM TWEETS where user_id = '$userID'";
        $result=mysqli_query($GLOBALS['con'], $sql);
        echo "<h4><b><i>Your Followers are Retweeting:</i></b></h4><BR/>";
        while($row = mysqli_fetch_array($result)){
            $originalTweetID = $row["tweet_id"];
            $sql2="SELECT users.user_id, users.first_name, users.last_name, users.screen_name, tweets.original_tweet_id, tweets.tweet_id, tweets.tweet_text, tweets.date_created "
                    . " FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.original_tweet_id ='$originalTweetID'";
            $result2 = mysqli_query($GLOBALS['con'], $sql2);
            while($row2=mysqli_fetch_array($result2)){
                $now = new DateTime;
                $tweetDate = new dateTime($row2["date_created"]);
                $diff = $now->diff($tweetDate);
                $myString = " retweeted your tweet";
                Self::FormatNotifications($row2["user_id"], $row2["first_name"], $row2["last_name"], $row2["screen_name"], $diff, $row2["tweet_text"], $row["tweet_id"], $myString);
            }
            
        }
    }
    public static function GetReplyNotif($userID){
        $sql = "SELECT tweet_id FROM TWEETS WHERE user_id = '$userID'";
        $result=mysqli_query($GLOBALS['con'], $sql);
        echo "<h4><b><i>Replies to Your Recent Tweets: </i></b></h4><BR/>";
        while($row= mysqli_fetch_array($result)){
            $originalTweetID = $row["tweet_id"];
            $sql2 = "SELECT users.user_id, users.first_name, users.last_name, users.screen_name, tweets.original_tweet_id, tweets.tweet_id, tweets.tweet_text, tweets.date_created "
                    . "FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.reply_to_tweet_id='$originalTweetID' ORDER BY date_created DESC";
            $result2 = mysqli_query($GLOBALS['con'], $sql2);
            while($row2=mysqli_fetch_array($result2)){
                $now = new DateTime;
                $tweetDate = new dateTime($row2["date_created"]);
                $diff = $now->diff($tweetDate);
                $myString = " replied to your tweet";
                Self::FormatNotifications($row2["user_id"], $row2["first_name"], $row2["last_name"], $row2["screen_name"], $diff, $row2["tweet_text"], $row["tweet_id"], $myString);
            }
        }
    }
}


