<?php  
if(isset($_POST['update_details'])) {

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];

	$email_check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
	$row = mysqli_fetch_array($email_check);
	$matched_user = $row['username'];

	if($matched_user == "" || $matched_user == $userLoggedIn) {
		$message = "Details updated!<br><br>";

		$query = mysqli_query($con, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE username='$userLoggedIn'");
	}
	else 
		$message = "That email is already in use!<br><br>";
}
else 
	$message = "";


//**************************************************

if(isset($_POST['update_password'])) {

	$old_password = strip_tags($_POST['old_password']);
	$new_password_1 = strip_tags($_POST['new_password_1']);
	$new_password_2 = strip_tags($_POST['new_password_2']);

	$password_query = mysqli_query($con, "SELECT password FROM users WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($password_query);
	$db_password = $row['password'];

	if(md5($old_password) == $db_password) {

		if($new_password_1 == $new_password_2) {


			if(strlen($new_password_1) <= 4) {
				$password_message = "<div class='pswd-msg' style='background-color:red; width:250px; height:30px; border-radius: 7px; box-shadow:2px 1px lightblue;'>
					<center class='pswd-info-text' style='color:white;padding-top: 5px;font-weight: bolder;'>Sorry, your password must be greater than 4 characters</center>
					</div><br>";
			}	//Sorry, your password must be greater than 4 characters<br><br>
			else {
				$new_password_md5 = md5($new_password_1);
				$password_query = mysqli_query($con, "UPDATE users SET password='$new_password_md5' WHERE username='$userLoggedIn'");

				$password_message = "<div class='pswd-msg' style='background-color:green; width:250px; height:30px; border-radius: 7px; box-shadow:2px 1px lightblue;'>
					<center class='pswd-info-text' style='color:white;padding-top: 5px;font-weight: bolder;'>Password has been changed!</center>
					</div><br>";
			}


		}
		else {
			$password_message = "<div class='pswd-msg' style='background-color:red; width:300px; height:30px; border-radius: 7px; box-shadow:2px 1px lightblue;'>
					<center class='pswd-info-text' style='color:white;padding-top: 5px;font-weight: bolder;'>Your two new passwords need to match!</center>
					</div><br>";
		}      //Your two new passwords need to match!

	}
	else {
			$password_message = "<div class='pswd-msg' style='background-color:red; width:270px; height:30px; border-radius: 7px; box-shadow:2px 1px lightblue;'>
					<center class='pswd-info-text' style='color:white;padding-top: 5px;font-weight: bolder;'>The old password is incorrect! </center>
					</div><br>";
	}	//The old password is incorrect! <

}
else {
	$password_message = "";
}


if(isset($_POST['close_account'])) {
	header("Location: close_account.php");
}


?>