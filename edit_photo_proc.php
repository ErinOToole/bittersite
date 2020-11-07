<?php include('connect.php');?>
<?php
session_start();
if(isset($_POST["submit"])){
    $msg = "";
    $userID = $_SESSION["SESS_MEMBER_ID"];
    if(empty($_FILES['pic']['name'])){ //if they try to upload nothing then get an error
        $msg = "Error! You must choose a file to upload!";
        header("Location: edit_photo.php?message=$msg");
    }
    
        $image = $_FILES['pic']['name'];
        $target = "images/profilepics/" .basename($image);
        $sql = "UPDATE USERS SET profile_pic = '$image' WHERE user_id = '$userID'"; //insert image into the database
        mysqli_query($con, $sql);
                
        if(move_uploaded_file($_FILES['pic']['tmp_name'], $target)){
            $msg = "Image Uploaded Successfully";
            header("Location: index.php?message=$msg");
        }
        else{
            unlink($_FILES['pic']['tmp_name']);
            $msg = "Error uploading picture, please try again!";
            header("Location: edit_photo.php?message=$msg");
        }
    //grabs the photos, creates a file for the photo in images/profile pics
        //I tried to use mkdir to create a new folder with the user's ID name but it was all awful and I couldn't get it to work.
}







?>