<?php include ("connect.php");?>
<?php
session_start();
//Checks to see if the user ID session variable is set. If it is, then they're logged in and get redirected to index.php
if(isset($_SESSION["SESS_MEMBER_ID"])){
            header("location: index.php");
        }

if (isset($_POST["firstname"])) {
//insert the user's data into the users table of the DB
//if everything is successful, redirect them to the login page.
//if there is an error, redirect back to the signup page with a friendly message
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    //converting user input to lowercase to make comparison easier later - usernames are not case sensitive as they're all changed to lowercase anyway
    $username = strtolower($_POST["username"]);
    $password = $_POST["password"];
    $myHash = password_hash($password, PASSWORD_DEFAULT); //hashes the password before storing it in the db
    $confirmPassword = $_POST["confirm"];
    $phoneNum = $_POST["phone"];
    $address = $_POST["address"];
    $province = $_POST["province"];
    $postalCode = $_POST["postalCode"];
    $url = $_POST["url"];
    $description = $_POST["desc"];
    $location = $_POST["location"];

    $checkSQL = "Select * FROM USERS WHERE screen_name = '$username'";
    $msg = "";
    $result = mysqli_query($con, $checkSQL);
        if(mysqli_num_rows($result) > 0){
            $msg = "Oops! That username is unavailable, please try a different one";
            header("Location: signup.php?message=$msg");
        }
        else{
            $sql = "INSERT INTO users
            (`first_name`,`last_name`,`screen_name`,`password`,`address`,`province`,`postal_code`,`contact_number`,`email`,`url`,`description`,`location`,`profile_pic`)
            VALUES('$firstName', '$lastName', '$username', '$myHash', '$address', '$province', '$postalCode', '$phoneNum', '$email', '$url', '$description', '$location', ' ')";
            
            $msg = "";
            mysqli_query($con, $sql);
            
            if(mysqli_affected_rows($con) == 1){
                $msg = "Account created successfully, please log in.";
                header("location: login.php?message=$msg");       
            }
            else{
                $msg = "Problem creating account, please try again.";
                header("location: signup.php");
            } 
            
        }
    }
    

?>