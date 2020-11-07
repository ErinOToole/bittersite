<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
        session_start();
        //if there is a message set, then display it
        if (isset($_GET["message"])) {
            $message = $_GET["message"];
            echo "<script>alert('$message')</script>";
        }
?>

<html>
    <head>
        <title>Upload A Profile Picture</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <!--Really simple HTML form-->
        <form action="edit_photo_proc.php" method="post" enctype="multipart/form-data">
	Select your image (Must be under 1MB in size): 
	<input type="file" accept="image/*" name="pic" required><br><br> <!--get a file upload field-->
	<input id="button" type="submit" name="submit" value="Submit">
</form>

    </body>
</html>





