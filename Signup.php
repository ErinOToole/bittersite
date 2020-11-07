<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Registration, signup page, new user, new account, new profile">
    <meta name="author" content="Erin O'Toole, erbear89@gmail.com">
    <link rel="icon" href="favicon.ico">
    
    <!--If the log in is not successful, will get a pop up and be redirected back to the signup page -->
     <?php
        session_start();
        //if there is a message set, then display it
        if (isset($_GET["message"])) {
            $message = $_GET["message"];
            echo "<script>alert('$message')</script>";
        }
        //checks to see if the member idea session variable is set, if it is then they're logged in and get redirected to index
        if(isset($_SESSION["SESS_MEMBER_ID"])){
            header("location: index.php");
        }
    ?>

    <title>Signup - Bitter</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	
    <script src="includes/bootstrap.min.js"></script>
    <script src ="includes/validation.js"></script>
    
       
	<script type="text/javascript">                 
                //chose to do an include because I thought it was too much JS on the HTML page...
	</script>
  </head>

  <body>

    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<a class="navbar-brand" href="index.html"><img src="images/logo.jpg" class="logo"></a>
                        <a class="navbar-brand" href="contactus.php"><img src="images/phone.png" class="logo"></a>
		
        
      </div>
    </nav>

	<BR><BR>
    <div class="container">
        <div id="divError"></div>
		<div class="row">
			
			<div class="main-login main-center">
				<h5>Sign up once and troll as many people as you like!</h5>
                                <div id="error"></div>
					<form method="post" id="registration_form" action="signup_proc.php" onsubmit="return ValidateForm()">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">First Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="firstname" id="firstname"  placeholder="Enter your First Name"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Last Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="lastname" id="lastname"  placeholder="Enter your Last Name"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Screen Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Screen Name"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Phone Number</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="phone" id="phone"  placeholder="Enter your Phone Number"/>
								</div>
                                                            <div id="phoneError"></div>
                                                                
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Address</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="address" id="address"  placeholder="Enter your Address"/>
								</div>
							</div>
						</div>
						
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Province</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<select name="province" id="province" class="textfield1" ><?php echo $vprovince; ?> 
										<option> </option>
										<option value="British Columbia">British Columbia</option>
										<option value="Alberta">Alberta</option>
										<option value="Saskatchewan">Saskatchewan</option>
										<option value="Manitoba">Manitoba</option>
										<option value="Ontario">Ontario</option>
										<option value="Quebec">Quebec</option>
										<option value="New Brunswick">New Brunswick</option>
										<option value="Prince Edward Island">Prince Edward Island</option>
										<option value="Nova Scotia">Nova Scotia</option>
										<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
										<option value="Northwest Territories">Northwest Territories</option>
										<option value="Nunavut">Nunavut</option>
										<option value="Yukon">Yukon</option>
									  </select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Postal Code</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="postalCode" id="postalCode"  placeholder="Enter your Postal Code"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Url</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="url" id="url"  placeholder="Enter your URL"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Description</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="desc" id="desc"  placeholder="Description of your profile"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Location</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="location" id="location"  placeholder="Enter your Location"/>
								</div>
							</div>
						</div>
						
						
						<div class="form-group ">
							<input type="submit" name="button" id="button" value="Register" class="btn btn-primary btn-lg btn-block login-button"/>
							
						</div>
						
					</form>
				</div>
			
		</div> <!-- end row -->
    </div><!-- /.container -->
  </body>
</html>