<?php
include("includes/classes/user.php");
include("includes/classes/tweet.php");
$u = $_SESSION["USER_INFO"];

if(!isset($_SESSION["USER_INFO"])){
  header("Location: index.php");
//one session variable that is a user object of the user who is logged in  
}
//If there is a message set, then display it
if (isset($_GET["message"])) {
    $message = $_GET["message"];
    echo "<script>alert('$message')</script>";
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
 

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/styletemplate.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
        
<script src="https://code.jquery.com/jquery-1.10.2.js" ></script>        
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(document).ready(function() {
    //hide the submit button on page load
    $("#button").hide();
    $("#message_form").submit(function() {
        //alert("submit form");
        $("#button").hide();
    });
    $("#message").focus( function() {
        this.attributes["rows"].nodeValue = 5;
        $("#button").show();
    });//end of click event

    $("#to").keyup(//key up event for the user name textbox
        function(e) {
            if (e.keyCode === 13) {
            //don't do anything if the user types the enter key, it might try to submit the form
                return false;
            }
            jQuery.get(
                "UserSearch_AJAX.php",
                $("#message_form").serializeArray(),
                function(data) {//anonymous function
                    //uncomment this alert for debugging the directMessage_proc.php page
                    //alert(data);
                    //clear the users datalist
                    $("#dlUsers").empty();
                    if (typeof(data.users) === "undefined") {
                        $("#dlUsers").append("<option value='NO USERS FOUND' label='NO USERS FOUND'></option>");};
                        $.each(data.users, function(index, element) {
                            //this will loop through the JSON array of users and add them to the select box
                            $("#dlUsers").append("<option value='" + element.username + "' label='" + element.username +
                            "'></option>");
                            //alert(element.id + " " + element.name);
                        });
 
                    },
                    //change this to "html" for debugging the UserSearch_AJAX.php page
                    "html"
                     );
                     //make sure the focus stays on the textbox so the user can keep typing
                    $("#to").focus();
                    return false;
                }
            );
        });//end of ready event handler
</script>
<head>

  <body>
      <?php include("includes/header.php");?>
      <BR><BR>
    <div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="mainprofile img-rounded">
				<div class="bold">
				<img class="bannericons" src=<?php echo "images/profilepics/" . User::GetProfilePic($u) ?>>
                                
				<a href="userpage.php?user_id="><?php echo '<a href="index.php">' . $u->firstName. " " . $u->lastName . '</a>'?></a><BR></div>
				<table>
				<tr><td>
				tweets</td><td>following</td><td>followers</td></tr>
				<tr><td><?php Tweet::GetNoOfTweets($u->userID) ?></td><td><?php User::GetNoOfFollowing($u->userID) ?></td><td><?php User::GetNoOfFollowers($u->userID) ?></td>
				</tr></table><BR><BR><BR><BR><BR>
				</div><BR><BR>
				<div class="trending img-rounded">
				<div class="bold">Trending</div>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="img-rounded">
					<form method="post" id="message_form" action="DirectMessage_proc.php">
					<div class="form-group">
                                                Send message to: <input type="text" id="to" name="to" list="dlUsers" autocomplete="off"><br>
                                                <datalist id="dlUsers">
                                                    
                                                </datalist>
                                                <!--<input type="hidden" name="userID" value="<?//=$userId?>">-->
						<textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter your message here"></textarea>
						<input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
						
					</div>
					</form>
				</div>
				<div class="img-rounded">
				<?php User::GetAllMessages($u) ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="whoToTroll img-rounded">
				<div class="bold">Who to Troll?<BR></div>
                                <!--Include file that dynamically echos out the users to follow -->
                                <?php include ("followers.php");?>
                                <BR>                                                         	
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
    <script src="includes/bootstrap.min.js"></script>
    
  </body>
</html>
