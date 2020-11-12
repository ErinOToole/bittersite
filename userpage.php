<?php
include("includes/classes/user.php");
include("includes/classes/tweet.php");
if(isset($_GET["userID"])){
    User::FindUser($_GET["userID"]);
    $up = $_SESSION["USERPAGE_INFO"];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="user profile, profile page, user account, my profile">
    <meta name="author" content="Erin O'Toole, erbear89@gmail.com">
    <link rel="icon" href="favicon.ico">

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
	
	
  </head>

  <body>
      <?php include("Includes/header.php");?>
      <BR><BR>
    <div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="mainprofile img-rounded">
				<div class="bold">
				<img class="bannericons" src=<?php echo "images/profilepics/" . User::GetProfilePic($up->userID) ?>>
				<?php echo $up->firstName . " " . $up->lastName?><BR></div>
				<table>
				<tr><td>
				tweets</td><td>following</td><td>followers</td></tr>
				<tr><td><?php Tweet::GetNoOfTweets($up->userID) ?></td><td><?php User::GetNoOfFollowing($up->userID)?></td><td><?php User::GetNoOfFollowers($up->userID) ?></td>
				</tr></table>
				<img class="icon" src="images/location_icon.jpg"><?php echo $up->location?>
				<div class="bold">Member Since:</div>
				<div><?php $date = date_create($up->dateAdded); echo date_format($date, "m/d/Y") ?></div>
				</div><BR><BR>
				
				<div class="trending img-rounded">
				<div class="bold">0 &nbsp;Followers you know<BR>
				
				</div>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="img-rounded">
					
				</div>
				<div class="img-rounded">
				
				</div>
			</div>
			<div class="col-md-3">
				<div class="whoToTroll img-rounded">
				<div class="bold">Who to Troll?<BR></div>
								
				
				</div><BR>
				
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
