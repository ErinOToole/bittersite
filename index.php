
<?php session_start();?>
<?php
if(!isset($_SESSION["SESS_MEMBER_ID"])){
  header("Location: index.php");  
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bitter, homepage, landingpage">
    <meta name="author" content="Erin O'Toole, erbear89@gmail.com">
    <link rel="icon" href="favicon.ico">
    <?php
    //If there is a message set, then display it
    if (isset($_GET["message"])) {
            $message = $_GET["message"];
            echo "<script>alert('$message')</script>";
        }
    ?>

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
	
	<script>
	//just a little jquery to make the textbox appear/disappear like the real Twitter website does
	$(document).ready(function() {
		//hide the submit button on page load
		$("#button").hide();
		$("#tweet_form").submit(function() {
			
			$("#button").hide();
		});
		$("#myTweet").click( function() {			
			this.attributes["rows"].nodeValue = 5;
			$("#button").show();
			
		});//end of click event
		$("#myTweet").blur( function() {			
			this.attributes["rows"].nodeValue = 1;
                        //$("#button").hide();

		});//end of click event
	});//end of ready event handler
    
	</script>
  </head>

  <body>
      <?php include("Includes/header.php");?>
      <BR><BR>
    <div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="mainprofile img-rounded">
				<div class="bold">
				<img class="bannericons" src="">
				<a href="userpage.php?user_id=">Jimmy Jones</a><BR></div>
				<table>
				<tr><td>
				tweets</td><td>following</td><td>followers</td></tr>
				<tr><td>0</td><td>0</td><td>0</td>
				</tr></table><BR><BR><BR><BR><BR>
				</div><BR><BR>
				<div class="trending img-rounded">
				<div class="bold">Trending</div>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="img-rounded">
					<form method="post" id="tweet_form" action="tweet_proc.php">
					<div class="form-group">
						<textarea class="form-control" name="myTweet" id="myTweet" rows="1" placeholder="What are you bitter about today?"></textarea>
						<input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
						
					</div>
					</form>
				</div>
				<div class="img-rounded">
				<?php include ("displaytweets.php");?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="whoToTroll img-rounded">
				<div class="bold">Who to Troll?<BR></div>
                                <!--Include file that dynamically echos out the users to follow -->
                                <?php include ("followers.php");?>
                                                                                           	
				</div>
				<!--don't need this div for now 
				<div class="trending img-rounded">
				© 2018 Bitter
				</div>-->
			</div>
		</div> <!-- end row -->
    </div><!-- /.container -->

	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="includes/bootstrap.min.js"></script>
    
  </body>
</html>
