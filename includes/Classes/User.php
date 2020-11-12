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
    }
    
    public static function UsernameExists($u){
        $sql = "Select * FROM USERS WHERE screen_name = '$u->userName'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        if(mysqli_num_rows($result) > 0){
            $msg = "Oops! That username is unavailable, please try a different one";
            header("Location:signup.php?msg=$msg");
        }
        else{
            Self::CreateUser($u);
        }        
    }
    
    public static function AuthenticateLogin($userName, $enteredPassword){
        $sql = "SELECT * FROM USERS WHERE screen_name = '$userName'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        $u = new User($row["user_id"], $row["screen_name"], $row["password"], $row["first_name"], $row["last_name"], $row["address"], $row["province"], $row["postal_code"], $row["contact_number"], $row["email"], $row["date_created"], $row["profile_pic"], $row["location"], $row["description"], $row["url"]);
        $myHash = $u->password;
        if(password_verify($enteredPassword, $myHash)){
            $_SESSION["USER_INFO"] = $u;
//            $_SESSION["SESS_FIRST_NAME"] = $row["first_name"];
//            $_SESSION["SESS_LAST_NAME"] = $row["last_name"];
//            $_SESSION["SESS_MEMBER_ID"] = $row["user_id"];
            header("location: index.php");
        }
        else{
            $msg = 'Authentication Error: Please try again';
            header("Location: login.php?message=$msg");
        }
        
    }
    
    public static function GetProfilePic($userID){
        $sql = "SELECT profile_pic FROM users where user_id = '$userID' AND profile_pic != ''"; 
        $result = mysqli_query($GLOBALS['con'], $sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            return $row["profile_pic"];
        }
        else{
            return "default.jfif";
        }
    }
        
    public static function GetNoOfFollowing($userID){
        $sql = "SELECT * FROM follows WHERE from_id = '$userID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $noFollowing = $result->num_rows;
        echo $noFollowing;
    }
    
    public static function GetNoOfFollowers($userID){
        $sql = "SELECT * FROM follows WHERE to_id = '$userID'";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $noFollowers = $result->num_rows;
        echo $noFollowers;
    }
    
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
    }
    public static function DisplayFollowers($u){
        $sql = "SELECT user_id, first_name, last_name, screen_name FROM users "
                . "WHERE user_id <> " . $u->userID . " "
                . "AND user_id NOT IN "
                . "(SELECT to_id FROM follows WHERE user_id = to_id)"
                . " ORDER BY RAND()"
                . " LIMIT 3";
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
            echo '<form action = "follow_proc.php" method= "POST">'
            . '<input class = "followbutton" type = "submit" value = "Follow" name = "Follow">'
            . '<input type="hidden" name="userID" value=' .$accountID.'>'
            . '<input type="hidden" name="userName" value=' .$userName.'></form>';
        }
    }
    
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
    }
    
    public static function FindUser($userID){
        $sql = "SELECT * FROM users WHERE user_id = $userID";
        $result = mysqli_query($GLOBALS['con'], $sql);
        $row = mysqli_fetch_array($result);
        $u= new User($row["user_id"], $row["screen_name"], $row["password"], $row["first_name"], $row["last_name"], $row["address"], $row["province"], $row["postal_code"], $row["contact_number"], $row["email"], $row["date_created"], $row["profile_pic"], $row["location"], $row["description"], $row["url"]);
        $_SESSION["USERPAGE_INFO"] = $u;       
    }
    
    public static function ChangeProfilePic($u){
        if(empty($_FILES['pic']['name'])){ //if they try to upload nothing then get an error
        $msg = "Error! You must choose a file to upload!";
        header("Location: edit_photo.php?message=$msg");
        }
            $image = $_FILES['pic']['name'];
            $target = "images/profilepics/" .basename($image);
            $sql = "UPDATE USERS SET profile_pic = '$image' WHERE user_id = '$u->userID'"; //insert image into the database
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
    }
}
