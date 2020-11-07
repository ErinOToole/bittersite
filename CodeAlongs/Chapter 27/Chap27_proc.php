<?php include ("../connect.php");?>
<?php
if (isset($_POST["txtName"])) {
    //isset checks to see if the variable is set, if it is it will return true. If not, false.
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    //Need a host, username, password and database name to connect to the database.
    //localhost, root, "", productsdemo
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    echo ($name . " ". $email . "<BR>");
    
    $sql = "Select * from products";
    
    if($result = mysqli_query($con, $sql)){
        while($row= mysqli_fetch_array($result)){
            echo $row["ID"] . " " . $row["Category"] . " " . $row["Description"] . "<BR>"; //associative array --> indexes are strings instead of numbers
        }
    }
    //insert statement
    $prodId = 999; //$_POST["Whatever"];
    $desc = $name;
    $price = 19.99;
    $sql = "INSERT INTO `productsdemo`.`products`(`ID`,`Category`,`Description`,`Image`,`Price`)VALUES($prodId, 'Tools', '$desc',' ',$price);";
    mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1){
        echo "INSERT SUCCESSFUL";
    }
    else{
        echo "error on insert<BR>";
    }
    
    //update statement
    $desc = "hammer";
    $sql = "update products set Description = '$desc' where ID = 999";
    mysqli_query($con, $sql);
     if(mysqli_affected_rows($con) == 1){
        echo "update SUCCESSFUL";
    }
    else{
        echo "error on update<BR>";
    }
    
}
    ?>

