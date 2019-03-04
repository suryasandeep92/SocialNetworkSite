<?php  
require 'config/config.php';//contains database connection
require 'includes/form_handlers/register_handler.php';//contains the registration form handler code for the registration
//require 'includes/form_handlers/login_handler.php';//contains the login form handler code for the login
?>


<html>
<head>
	<title>Welcome to Conestoga Student Connect!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
    
	<div class="wrapper">

		<div class="login_box">

			<div class="login_header">
				<h1>Conestoga Student Connect!</h1>
				Login or sign up below!
			</div>
			<br>

			<div id="second">

				<form action="register.php" method="POST">
					<input type="text" name="reg_fname" placeholder="First Name" value="<?php 
					if(isset($_SESSION['reg_fname'])) { //Sticky form -- Remembers the first name
						echo $_SESSION['reg_fname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "<span style='color: #990000;'>Your first name must be between 2 and 25 characters</span><br>"; ?>
					
					


					<input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
					if(isset($_SESSION['reg_lname'])) { //Sticky form -- Remembers the last name
						echo $_SESSION['reg_lname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "<span style='color: #990000;'>Your last name must be between 2 and 25 characters</span><br>"; ?>

					<input type="email" name="reg_email" placeholder="Email" value="<?php 
					if(isset($_SESSION['reg_email'])) { //Sticky form -- Remembers the email
						echo $_SESSION['reg_email'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Email already in use<br>", $error_array)) echo "<span style='color: #990000;'>Email already in use</span><br>";
					//displays the appropriate error, applicable to each and every field
					else if(in_array("Please enter a valid conestoga email<br>", $error_array)) echo "<span style='color: #990000;'>Please enter a valid conestoga email</span><br>";
					else if(in_array("Invalid email format<br>", $error_array)) echo "<span style='color: #990000;'>Invalid email format</span><br>"; ?>

					<input type="number" name="student_id" placeholder="Your Student ID" value="<?php 
					if(isset($_SESSION['student_id'])) { //Sticky form -- Remembers the student_id
						echo $_SESSION['student_id'];
					} 
					?>" required>
					<br>

					<input type="number" name="student_id2" placeholder="Confirm Your Student ID" value="<?php 
					if(isset($_SESSION['student_id2'])) { //Sticky form -- Remembers the student_id
						echo $_SESSION['student_id2'];
					} 
					?>" required>
					<br>
					<?php if(in_array("studentID already in use<br>", $error_array)) echo "<span style='color: #990000;'>studentID already in use</span><br>";
					//displays the appropriate error, applicable to each and every field
					else if(in_array("Invalid studentID<br>", $error_array)) echo "<span style='color: #990000;'>Invalid studentID</span><br>";
					else if(in_array("Student ID's don't match<br>", $error_array)) echo "<span style='color: #990000;'>Student ID's don't match</span><br>"; ?>


					<input type="password" name="reg_password" placeholder="Password" required>
					<br>
					<input type="password" name="reg_password2" placeholder="Confirm Password" required>
					<br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "<span style='color: #990000;'>Your passwords do not match</span><br>"; 
					//displays the appropriate error, applicable to each and every field
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "<span style='color: #990000;'>Your password can only contain english characters or numbers</span><br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "<span style='color: #990000;'>Your password must be betwen 5 and 30 characters</span><br>"; ?>


					<input type="submit" name="register_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>", $error_array)) echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>"; ?>
					<a href="login.php" id="signin" class="signin">Already have an account? Sign in here!</a>
				</form>
			</div>

		</div>

	</div>


</body>
</html>