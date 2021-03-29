

<!-- comment --><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bitter login, bitter account">
    <meta name="author" content="Erin O'Toole, erbear89@gmail.com">
    <link rel="icon" href="favicon.ico">
    
    <!--If user's login attempt was successfully then they're redirected here and get a pop up message-->
    <?php
        session_start();
        //if there is a message set, then display it.
        if (isset($_GET["message"])) {
            $message = $_GET["message"];
            echo "<script>alert('$message')</script>";
        }
        //Checks to see if the user ID session variable is set. If it is, then they're logged in and get redirected to index.php
        if(isset($_SESSION["SESS_MEMBER_ID"])){
            header("location: index.php");
        }
        
    ?>

    <title>Login - Bitter</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/styletemplate.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	
    <script src="includes/bootstrap.min.js"></script>
    
	
  </head>

  <body>

    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<a class="navbar-brand" href="index.html"><img src="images/logo.jpg" class="logo"></a>
                        <!--Add contact us button to login page -->
                        <a class="navbar-brand" href="contactus.php"><img src="images/phone.png" class="logo"></a>
		
        
      </div>
    </nav>

	<BR><BR>
    <div class="container">
		<div class="row">
			<div class="main-center  mainprofile">
				<h1>Bitter</h1>
				<p class="lead">Bitter - Social Media for Trolls, Narcissists, Bullies and United States Presidents.<br></p>
			</div>
			<div class="main-center  mainprofile">
				<h1>Don't have a Bitter Account?</h1>
				<p class="lead"><a href="signup.php">Click Here</a> to begin trolling your friends, family, politicians and celebrities.<br></p>
			</div>
			<div class="main-center  mainprofile">
				<h5>Please Login Here!</h5>
					<form method="post" id="login_form" action="login_proc.php">
						
						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Screen Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="username" id="username"  placeholder="Enter your Screen Name"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" required name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>
						
						<div class="form-group ">
							<input type="submit" name="button" id="button" value="Login" class="btn btn-primary btn-lg btn-block login-button"/>
							
						</div>
						
					</form>
				</div>
			
		</div> <!-- end row -->
    </div><!-- /.container -->
    
  </body>
</html>