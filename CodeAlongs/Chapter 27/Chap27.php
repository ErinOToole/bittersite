<!DOCTYPE html>
<html>
    <head></head>
    
    <body>
        <!--method="get" is the default -->
        <!--post means it's going via the http header-->
        <form method="post" action="Chap27_proc.php"> <!--Tells where it's going to go-->
            <label>Name:</label><input type="text" name="txtName"><br>
            <!--Name attribute is what php is going to look for-->
            <label>Email: </label><input type="email" name="txtEmail"><br>
            <input type="submit">
            <!--<button type="submit">Go</button>-->             
            
        </form>
        
    </body>
</html>
