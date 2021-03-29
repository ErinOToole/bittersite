<?php
include("includes/connect.php");
session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Erin O'Toole
 */
class User {
    //properties
    private $userID;
    private $userName;
    private $password;
    private $firstName;
    private $lastName;
    private $address;
    private $province;
    private $postalCode;
    private $contactNo;
    private $email;
    private $dateAdded;
    private $profImage;
    private $location;
    private $description;
    private $url;
    
    //contruct function
    public function __construct($userID, $userName, $password, $firstName, $lastName, $address, $province, $postalCode, $contactNo, $email, $dateAdded, $profImage, $location, $description, $url){
        $this->userID = $userID;
        $this->userName = $userName;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->province = $province;
        $this->postalCode = $postalCode;
        $this->contactNo = $contactNo;
        $this->email = $email;
        $this->dateAdded = $dateAdded;
        $this->profImage = $profImage;
        $this->location = $location;
        $this->description = $description;
        $this->url = $url;
    }
    
    //destruct function
    public function __destruct(){
        
    }
    
    //function that gets any property
    public function __get($property){
        return $this->$property;
    }
    
    //function that sets any property
    public function __set($property, $value){
        $this->$property = $value;
    }
    
    //method to create a new user and insert them into the db
    public static function CreateUser($u){
          $sql = "INSERT INTO users
            (`first_name`,`last_name`,`screen_name`,`password`,`address`,`province`,`postal_code`,`contact_number`,`email`,`url`,`description`,`location`)
            VALUES('$u->firstName', '$u->lastName', '$u->userName', '$u->password', '$u->address', '$u->province', '$u->postalCode', '$u->contactNo', '$u->email', '$u->url', '$u->description', '$u->location')";
          mysqli_query($GLOBALS['con'], $sql);
          if(mysqli_affected_rows($GLOBALS['con']) == 1){
                $msg = "Account created successfully, please log in.";
                header("location: login.php?message=$msg");       
            }
            else{
                $msg = "Problem creating account, please try again.";
                header("location: signup.php");
            } 
    }//end CreateUser()
    
    //function that checks if a username already exists in the db
    public static function UsernameExists($u){
        $sql = "Select * FROM USERS WHERE screen_name = '$u->userName'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        if(mysqli_num_rows($result) > 0){
            $msg = "Oops! That username is unavailable, please try a different one";
            header("Location:signup.php?msg=$msg");
        }
        else{
            //if it doesn't exist, then it calles the CreateUser() function above
            Self::CreateUser($u);
        }        
    }//end UsernameExists()
    
    //method to authenticate user
    public static function AuthenticateLogin($userName, $enteredPassword){
        $sql = "SELECT * FROM USERS WHERE screen_name = '$userName'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        $u = new User($row["user_id"], $row["screen_name"], $row["password"], $row["first_name"], $row["last_name"], $row["address"], $row["province"], $row["postal_code"], $row["contact_number"], $row["email"], $row["date_created"], $row["profile_pic"], $row["location"], $row["description"], $row["url"]);
        $myHash = $u->password;
        if(password_verify($enteredPassword, $myHash)){
            //sets a single session variable as the user object if authentication is successfuly
            $_SESSION["USER_INFO"] = $u;
            header("location: index.php");
        }
        else{
            $msg = 'Authentication Error: Please try again';
            header("Location: login.php?message=$msg");
        }
    }//end authenticateLogin()
    
    //function that grabs the profile pics from the db for the user
    public static function GetProfilePic($u){
        $sql = "SELECT profile_pic FROM users where user_id = '$u->userID' AND profile_pic != ''"; 
        $result = mysqli_query($GLOBALS['con'], $sql);
        if(mysqli_num_rows($result) > 0){
            //if there is a picture saved, it fetches the extension and returns it
            $row = mysqli_fetch_array($result);
            return $row["profile_pic"];
        }
        else{
            //if there is none saved, returns the default image extension
            return "default.jfif";
        }
    }//end GetProfilePic()
        
    //method that gets the number of users a specific user is following
    //used on the index and userpage
    public static function GetNoOfFollowing($userID){
        $sql = "SELECT * FROM follows WHERE from_id = '$userID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $noFollowing = $result->num_rows;
        echo $noFollowing;
    }//end GetNoOfFollowing
    
    //Function that gets the number of followers a specific user has
    //used on the index and userpage
    public static function GetNoOfFollowers($userID){
        $sql = "SELECT * FROM follows WHERE to_id = '$userID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $noFollowers = $result->num_rows;
        echo $noFollowers;
    }//end GetNoOfFollowers()
    
    //Function that allows the logged in user to follow other users
    public static function Follow($fromID, $toID, $followedUser){
        $sql="INSERT INTO follows(`from_id`,`to_id`) VALUES('$fromID', '$toID')";
        mysqli_query($GLOBALS['con'], $sql);
        
        if(mysqli_affected_rows($GLOBALS['con']) == 1){
        //if the table is updated successfully, return success message and send user to index page
            $msg = "Succesfully followed user: " . '@' . $followedUser;
            header("location: index.php?message=$msg");       
        }
        else{
        //if table is not updated successfully, return failure message and send user to index page
            $msg = "Problem following user, please try again.";
            header("location: index.php?message=$msg");
        } 
    }//end Follow()
    
    //function that displays three random potential followers for the user to follow
    public static function DisplayFollowers($u){
        $sql = "SELECT user_id, first_name, last_name, screen_name FROM users WHERE user_id != '$u->userID' AND user_id NOT IN (SELECT from_id FROM follows WHERE from_id = user_id) ORDER BY RAND() LIMIT 3";
        $result = mysqli_query($GLOBALS['con'], $sql);
        while($rowFollowers = mysqli_fetch_array($result)){
            $firstName = $rowFollowers["first_name"];
            $lastName = $rowFollowers["last_name"];
            $userName = $rowFollowers["screen_name"];
            $accountID = $rowFollowers["user_id"];
            $pic = Self::GetFollowerPic($accountID);
        
            echo "<BR><a href='userpage.php?userID=$accountID'><img class='bannericons' img src= '$pic' ></a>"; //grab the profile picture for each user in the database
            //display the formatted follower info for each user in the follows
            echo $firstName . " " . $lastName . " " . "<a href='userpage.php?userID=$accountID'><strong>@" . $userName . "</strong></a><br>";
            //create a form to post to and then grab the followed account's ID and username for follower_proc.php
            //will display a follow button for each user that gets returned from the sql statement
            echo '<form action = "follow_proc.php" method= "GET">'
            . '<input class = "followbutton" type = "submit" value = "Follow" name = "Follow">'
            . '<input type="hidden" name="userID" value=' .$accountID.'>'
            . '<input type="hidden" name="userName" value=' .$userName.'></form>';
        }
    }// end DisplayFollowers()
    
    //function that gets the display picture of potential followers 
    public static function GetFollowerPic($accountID){
        $sqlPic = "SELECT profile_pic FROM users where user_id = '$accountID' AND profile_pic != ''"; 
    $resultPic = mysqli_query($GLOBALS['con'], $sqlPic);
        if(mysqli_num_rows($resultPic) > 0){ //if a row comes back, it means the user has a profile picture stored and it will be set as the session variable.
            $rowPic = mysqli_fetch_array($resultPic);
            $pic = "images/profilepics/" . $rowPic["profile_pic"];
        }
        else{
            $pic = "images/profilepics/default.jfif";
        }
        return $pic;
    }//end of GetFollowerPic()
    
    //function to get user information by their userID
    //mainly used on the userpage atm
    public static function FindUser($userID){
        $sql = "SELECT * FROM users WHERE user_id = $userID";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        $u= new User($row["user_id"], $row["screen_name"], $row["password"], $row["first_name"], $row["last_name"], $row["address"], $row["province"], $row["postal_code"], $row["contact_number"], $row["email"], $row["date_created"], $row["profile_pic"], $row["location"], $row["description"], $row["url"]);
        $_SESSION["USERPAGE_INFO"] = $u;       
    }//end FindUser()
    
    //function to change the profile picture of the logged in user
    public static function ChangeProfilePic(){
        if(empty($_FILES['pic']['name'])){ //if they try to upload nothing then get an error
        $msg = "Error! You must choose a file to upload!";
        header("Location: edit_photo.php?message=$msg");
        }
    
            $image = $_FILES['pic']['name'];
            $target = "images/profilepics/" .basename($image);
            $sql = "UPDATE USERS SET profile_pic = '$image' WHERE user_id = '$userID'"; //insert image into the database
            mysqli_query($GLOBALS['con'], $sql);
                
            if(move_uploaded_file($_FILES['pic']['tmp_name'], $target)){
                $msg = "Image Uploaded Successfully";
                header("Location: index.php?message=$msg");
            }
            else{
                unlink($_FILES['pic']['tmp_name']);
                $msg = "Error uploading picture, please try again!";
                header("Location: edit_photo.php?message=$msg");
         }
    }//end ChangeProfilePic()
    
    //function to find the original tweeter of a tweet by the tweetID
    public static function GetUserByTweetID($originalTweetID){
        $sql="SELECT user_id FROM tweets WHERE tweet_id = '$originalTweetID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        
        $sqlUser = "SELECT * FROM users where user_id =" . $row["user_id"];
        $resultUser = mysqli_query($GLOBALS['con'], $sqlUser);
        $rowUser = mysqli_fetch_array($resultUser);
        return $rowUser["first_name"] . " " . $rowUser["last_name"] . "<strong>(@" . $rowUser["screen_name"] .")</strong>'s tweet:";
    }//end GetUserByTweetID()
    
    public static function GetFollowersInCommon($loggedU, $viewingU){
        $sqlCount = "SELECT first_name, last_name, screen_name, user_id FROM users WHERE user_id NOT IN('$loggedU', '$viewingU') AND user_id IN
                (SELECT to_id FROM follows WHERE from_id = '$loggedU' AND to_id IN(SELECT to_id FROM follows WHERE from_id = '$viewingU')) ORDER BY RAND();";
        $resultCount = mysqli_query($GLOBALS['con'], $sqlCount);
        $noFollowing = $resultCount->num_rows;
        
        $sql = "SELECT first_name, last_name, screen_name, user_id FROM users WHERE user_id NOT IN('$loggedU', '$viewingU') AND user_id IN
                (SELECT to_id FROM follows WHERE from_id = '$loggedU' AND to_id IN(SELECT to_id FROM follows WHERE from_id = '$viewingU')) ORDER BY RAND() Limit 2;";
        $result = mysqli_query($GLOBALS['con'], $sql);
        
        echo "<div class='bold'>"; 
        echo $noFollowing . " Followers you know";
        echo "<BR></div>";
        while($rowFollowers = mysqli_fetch_array($result)){
            Self::formatFollowersInCommon($rowFollowers["first_name"], $rowFollowers["last_name"],$rowFollowers["screen_name"],$rowFollowers["user_id"], Self::GetFollowerPic($rowFollowers["user_id"])); 
        }
    }//end GetFollowersInCommon()
    public static function formatFollowersInCommon($firstName, $lastName, $userName, $accountID, $pic){
        echo "<BR><a href='userpage.php?userID=$accountID'><img class='bannericons' img src= '$pic' ></a>"; //grab the profile picture for each user in the database
            //display the formatted follower info for each user in the follows
            echo $firstName . " " . $lastName . " " . "<a href='userpage.php?userID=$accountID'><strong>@" . $userName . "</strong></a><br>";
            //create a form to post to and then grab the followed account's ID and username for follower_proc.php
            //will display a follow button for each user that gets returned from the sql statement
            echo '<form action = "follow_proc.php" method= "POST">'
            . '<input class = "followbutton" type = "submit" value = "Follow" name = "Follow">'
            . '<input type="hidden" name="userID" value=' .$accountID.'>'
            . '<input type="hidden" name="userName" value=' .$userName.'></form>';
    }//end formatFollowersInCommon()
    public static function searchUsers($searchContent){
        $sql= "SELECT * FROM users WHERE first_name LIKE '%$searchContent%' OR screen_name LIKE '%$searchContent%' OR last_name LIKE '%$searchContent'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        if($result->num_rows == 0){
            echo "<h4>No users found for " . "<b><i>$searchContent</i></b></h4>"; 
        }
        else{
            echo "<h4>Users found for " . "<b><i>" . $searchContent. "</i>.</b></h4>";
            while($row = mysqli_fetch_array($result)){
            //create new user object for the search result
            $u = new User($row["user_id"], $row["screen_name"], $row["password"], $row["first_name"], $row["last_name"], $row["address"], $row["province"], $row["postal_code"], $row["contact_number"], $row["email"], $row["date_created"], $row["profile_pic"], $row["location"], $row["description"], $row["url"]);
            
            $pic= Self::getFollowerPic($u->userID);
            Self::displaySearchResults($u->userID, $pic, $u->firstName, $u->lastName, $u->userName);
 
            }
        }
        
    }
    public static function displaySearchResults($userID, $pic, $firstName, $lastName, $userName){
        $u = $_SESSION["USER_INFO"];
        $sql2 = "SELECT * FROM follows WHERE to_id = '$u->userID' AND from_id= '$userID'";
        $result = mysqli_query($GLOBALS['con'], $sql2);
          if($result->num_rows != 0){
            $myString = "Does Not Follow You". " " . "| ";
        }
        else{
            $myString = "Follows You". " " . "| ";
        }
        $sql = "SELECT * FROM follows WHERE from_id = '$u->userID' AND to_id= '$userID'";
        $result2 = mysqli_query($GLOBALS['con'], $sql);
        if($result2->num_rows != 0){
            $myString2 = "Following";
        }
        else{
            $myString2 = "<a href='follow_proc.php?userID=$userID&userName=$userName'>Follow User</a>";
        }
        echo "<BR><a href='userpage.php?userID=$userID'><img class='bannericons' img src= '$pic' ></a>";
        echo $firstName . " " . $lastName . "(<a href='userpage.php?userID=$userID'><strong>@" . $userName . "</strong></a>)". " " . "<b>$myString$myString2</b><BR><HR>";
        
    }
    public static function GetAllMessages($u){
        $sql = "Select users.first_name, users.last_name, users.screen_name, users.user_id, messages.id, messages.from_id, messages.to_id, messages.message_text, messages.date_sent"
                . " FROM users INNER JOIN messages ON users.user_id = messages.from_id WHERE messages.to_id = '$u->userID' ORDER BY messages.date_sent DESC";
        $result = mysqli_query($GLOBALS['con'], $sql);
        date_default_timezone_set("America/Halifax");
        while($row = mysqli_fetch_array($result)){
            $now = new DateTime;
            $msgDate = new dateTime($row["date_sent"]);
            $diff = $now->diff($msgDate);
            Self::FormatMessages(User::GetFollowerPic($row["user_id"]), $row["screen_name"], $row["message_text"], $diff);  
        }//Two photos for like, if the tweet exists in the like table with a from id already from session user then can't like it and the picture is red
    }
    public static function FormatMessages($pic, $msgScreenName, $msg, $diff){
        $u = Self::GetUserByScreenName($msgScreenName);
          echo "<div class='container'>";
          echo "<a href='userpage.php?userID=$u->userID'><img class='bannericons' img src= '$pic' ></a>";
          echo "Message from " .$u->firstName . " " . $u->lastName . " " . "<a href='userpage.php?userID=$u->userID'><strong>@" . $u->userName . "</strong></a>";
          
          echo "<div class=\"tab\">";
          echo "<div class=\"bold\">";
          echo $msg . "<BR>";
          echo "</div>";
          echo "</div>";
          echo Tweet::FormatTweetTime($diff);
          echo "<BR>";
          echo "</div>";
    }
    public static function PopulateUsers($screenName){
        $sql="Select * FROM users WHERE screen_name LIKE '%$screenName%'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        while($row=mysqli_fetch_array($result)){
            
            $userList = array('username'=>$row["screen_name"]);
           
        $json_data=json_encode($userList);
        echo $json_data;
        
//                 
//            $userList += array('id'=>$row["user_id"], 'name'=>$row["first_name"], 'lastname'=>$row["last_name"], 'username'=>$row["screen_name"]);   
//        }
        
        
        //echo"Send message to: <input type='search' id='to' name='to' list='dlUsers' autocomplete='on'/><BR>";
        //echo"<datalist id='dlUsers'>";
            //while($row=mysqli_fetch_array($result)){
                //$username=$row["screen_name"];
                //echo"<option>$username</option>";
            //}
        //echo"</datalist>";
        }
    }
    public static function AreFollowing($fromID, $toID, $msgText){
        $sql = "Select * from follows WHERE from_id='$fromID' AND to_id='$toID'";
        $result=mysqli_query($GLOBALS['con'], $sql);
        if($result->num_rows == 0){
            $msg="You can only message users that you follow";
            header("location: DirectMessage.php?message=$msg");
        }   
        else{
            Self::InsertMessage($fromID, $toID, $msgText);
        }
        
    }
    
    public static function InsertMessage($fromID, $toID, $msgText){
        $sql="INSERT INTO messages (from_id, to_id, message_text)VALUES('$fromID', '$toID', '$msgText')";
        mysqli_query($GLOBALS['con'], $sql);
        
        if(mysqli_affected_rows($GLOBALS['con']) == 1){
        //if the table is updated successfully, return success message and send user to index page
        $msg = "Message sent successfully";
        header("location: DirectMessage.php?message=$msg");       
        }
        else{
        //if table is not updated successfully, return failure message and send user to index page
        $msg = "Problem sending message, please try again.";
        header("location: DirectMessage.php?message=$msg");
        } 
    }
    public static function GetUserByScreenName($screenName){
        $sql = "SELECT * FROM USERS where screen_name='$screenName'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        $u= new User($row["user_id"], $row["screen_name"], $row["password"], $row["first_name"], $row["last_name"], $row["address"], $row["province"], $row["postal_code"], $row["contact_number"], $row["email"], $row["date_created"], $row["profile_pic"], $row["location"], $row["description"], $row["url"]);
        return $u;
    }

    
}
