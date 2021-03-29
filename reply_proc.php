<?php
include("includes/classes/user.php");
include("includes/classes/tweet.php");
if(isset($_GET["tweet"])){
  $tweetID = $_GET["tweet"];
  $userInfo = User::GetUserByTweetID($tweetID);
  $tweet = Tweet::FindTweetByID($tweetID); //tweet object created by FindTweetByID function
}

echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link href=\"includes/style.css\" rel=\"stylesheet\">
    </head>
    <body>
            <div>
        <div class=\"bg-modal\">
            <div class=\"modal-content\">
                <div class=\"close\">+</div>
                    <form method = \"POST\" action=\"insertreply_proc.php\">
                        Replying to: $userInfo<BR>
                        $tweet->tweetText
                        <HR>
                        <div class=\"form-group\">
                            <input type=\"text\" class=\"form-control\" name=\"replytweet\" id=\"replyweet\" placeholder=\"Reply here\">
                            <input type=\"hidden\" name=\"originaltweet\" value=\"\">
                        </div>
                        <div class=\"form-group\">
                            <input type=\"submit\" value=\"Reply\" name=\"replybutton\" id=\"replybutton\" class=\"btn btn-primary btn-lg btn-block login-button\">
                            <input type=\"hidden\" name=\"originalTweetID\" value=\"$tweetID\"> 
                            <input type=\"hidden\" name=\"originaltweet\" value=\"$tweet->tweetText\">     
                        </div>
                    </form>
            </div>
            
        </div>
    </div>
    </body>
</html>";