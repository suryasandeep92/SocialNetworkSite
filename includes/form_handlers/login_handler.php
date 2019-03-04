<?php  
$error_msg = '';
if(isset($_POST['login_button'])) {
    
    //Student ID
	$studentID = strip_tags($_POST['log_student_id']); //Remove html tags
	$studentID = str_replace(' ', '', $studentID); //remove spaces
	$_SESSION['log_student_id'] = $studentID; //Stores studentID into session variable
    
    $password = strip_tags($_POST['log_password']); //Remove html tags
	$password = md5($_POST['log_password']); //Get password

	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE student_id='$studentID' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);
	//checks the login, if one user is found login is successful
	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$username = $row['username']; //stores the username from database into the variable $username

		//if user is closed then it will make the user_closed to 'no'
		$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE student_id='$studentID' AND user_closed='yes'");
		if(mysqli_num_rows($user_closed_query) == 1) {
			$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE student_id='$studentID'");
		}

		//After the successful login, a session variable is created and stored, then redirected to the index.php page
		$_SESSION['username'] = $username;
		header("Location: index.php");
		exit();
	}
	else {
		$error_msg = "Email or password was incorrect";
	}


}

?>