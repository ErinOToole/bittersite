<?php
//chapter 15 processing page
if(isset($_POST["submit"])){
    //attempt to load the file
    if(empty($_FILES['pic']['name'])){
        echo "Error you must select a file";
        exit;
        
    }
    echo "The file size is " . $_FILES['pic']['size'] . "<BR>";
    echo "File name is " . $_FILES['pic']['tmp_name'] . "<BR>";
    print_r($_FILES['pic']);
    $MAX_FILE_SIZE = 10*1024*1024;
    if($_FILES['pic']['size'] > $MAX_FILE_SIZE){
        unlink($_FILES['pic']['tmp_name']);//delete the temporary file 
        echo "File must be less than 10MB";
    }
    else{
        $destFile = "../images/profilepics" . $_FILES['pic']['name'];
        if(move_uploaded_file($_FILES['pic']['tmp_name'], $destFile)){
            echo "Successful<BR>";        
        }    
        else{
            unlink($_FILES['pic']['tmp_name']);
            echo "ERROR<BR>";
        }
    }
}

?>