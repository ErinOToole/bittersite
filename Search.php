<?php
//grab the content from the search
include("includes/classes/user.php");
include("includes/classes/tweet.php");
include("includes/header.php");

$content = $_POST["search"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bitter, homepage, landingpage">
    <meta name="author" content="Erin O'Toole, erbear89@gmail.com">
    <link rel="icon" href="favicon.ico">
    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/styletemplate.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
    </head>

  <body>
      
      <?php include("includes/header.php");?>
      <BR><BR>
    <div class="container">
        
        
        <?php User::searchUsers($content);?>
        <BR>
        <?php Tweet::searchTweets($content);?>
        
        
    </div><!-- /.container -->
 
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="includes/bootstrap.min.js"></script>
    
  </body>
</html>