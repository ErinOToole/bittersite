
<?php
//get the logged in user's id from session variables
$userID = $_SESSION["SESS_MEMBER_ID"];
//sql statement that gets three random users that aren't the currently logged in user and that the user has not followed
//I got this sql statement in-class from Tracey. It was posted in the chat to use
$sql = "SELECT user_id, first_name, last_name, screen_name FROM users WHERE user_id <> " . $userID . " AND user_id NOT IN (SELECT to_id FROM follows WHERE user_id = to_id) ORDER BY RAND() LIMIT 3";
$result = mysqli_query($con, $sql);
 
//while records are returned, grab each record's first name, last name, username and id
while($rowFollowers = mysqli_fetch_array($result)){
    $firstName = $rowFollowers["first_name"];
    $lastName = $rowFollowers["last_name"];
    $userName = $rowFollowers["screen_name"];
    $accountID = $rowFollowers["user_id"];
    
    //sql statement to get the account's associated profile picture
    $sqlPic = "SELECT profile_pic FROM users where user_id = '$accountID' AND profile_pic != ''"; 
    $resultPic = mysqli_query($con, $sqlPic);
    if(mysqli_num_rows($resultPic) > 0){ //if a row comes back, it means the user has a profile picture stored and it will be set as the session variable.
        $rowPic = mysqli_fetch_array($resultPic);
        $pic = "images/profilepics/" . $rowPic["profile_pic"];
    }
    else{
        $pic = "images/profilepics/default.jfif";
    }
    
    //use function to create a formatted string with the first name, last name and username
    $followInfo = formatText($firstName, $lastName, $userName);
    //display either default photo or stored photo for each record
    echo "<BR><img class='bannericons' img src= '$pic' >"; //grab the profile picture for each user in the database
    //display the formatted follower info for each user in the follows
    echo $followInfo;
    //create a form to post to and then grab the followed account's ID and username for follower_proc.php
    //will display a follow button for each user that gets returned from the sql statement
    echo '<form action = "follow_proc.php" method= "Post">'
    . '<input class = "followbutton" type = "submit" value = "Follow" name = "Follow">'
            . '<input type="hidden" name="userID" value=' .$accountID.'>'
            . '<input type="hidden" name="userName" value=' .$userName.'></form>';
  
    
}

//function to format first name, last name and username
function formatText($firstName, $lastName, $userName){
    $formattedString = $firstName . ' ' . $lastName . ' ' . '<strong>@' .$userName . '</strong><br>';
    return $formattedString;
}