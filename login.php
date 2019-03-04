<?php  
require 'config/config.php';//contains database connection
//require 'includes/form_handlers/register_handler.php';//contains the registration form handler code for the registration
require 'includes/form_handlers/login_handler.php';//contains the login form handler code for the login
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
			<div id="first">

				<form action="login.php" method="POST">
					<input type="number" name="log_student_id" placeholder="Student ID" value="<?php 
					if(isset($_SESSION['log_student_id'])) { //Sticky form -- Remembers the login ID
						echo $_SESSION['log_student_id'];
					} 
					?>" required>
					<br>
					<input type="password" name="log_password" placeholder="Password">
					<br>
					<?php if(empty($error_msg)) 
							echo "";
						  else
						  	echo "<span style='color: #990000;'>$error_msg</span><br>";
							 ?>
					<input type="submit" name="login_button" value="Login">
					<br>
					<a href="register.php" id="signup" class="signup">Need and account? Register here!</a>

				</form>

			</div>

	</div>


</body>
</html>