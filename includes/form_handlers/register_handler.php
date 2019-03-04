<?php
//Declaring variables to prevent errors
$fname = ""; //First name
$lname = ""; //Last name
$em = ""; //email
$studentID = "";//student ID
$studentID2 = "";//student ID2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date 
$error_array = array(); //Holds error messages

if(isset($_POST['register_button'])){

	//Registration form values

	//First name
	$fname = strip_tags($_POST['reg_fname']); //Remove html tags
	$fname = str_replace(' ', '', $fname); //remove spaces
	$fname = ucfirst(strtolower($fname)); //Uppercase first letter
	$_SESSION['reg_fname'] = $fname; //Stores first name into session variable

	//Last name
	$lname = strip_tags($_POST['reg_lname']); //Remove html tags
	$lname = str_replace(' ', '', $lname); //remove spaces
	$lname = ucfirst(strtolower($lname)); //Uppercase first letter
	$_SESSION['reg_lname'] = $lname; //Stores last name into session variable

	//email
	$em = strip_tags($_POST['reg_email']); //Remove html tags
	$em = str_replace(' ', '', $em); //remove spaces
	$em = ucfirst(strtolower($em)); //Uppercase first letter
	$_SESSION['reg_email'] = $em; //Stores email into session variable
    
    //Student ID
	$studentID = strip_tags($_POST['student_id']); //Remove html tags
	$studentID = str_replace(' ', '', $studentID); //remove spaces
	$_SESSION['student_id'] = $studentID; //Stores studentID into session variable

	//Student ID 2
	$studentID2 = strip_tags($_POST['student_id2']); //Remove html tags
	$studentID2 = str_replace(' ', '', $studentID2); //remove spaces
	$_SESSION['student_id2'] = $studentID2; //Stores studentID into session variable

	//Password
	$password = strip_tags($_POST['reg_password']); //Remove html tags
	$password2 = strip_tags($_POST['reg_password2']); //Remove html tags

	$date = date("Y-m-d"); //Current date

	
	//Check if email is in valid format 
	if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			if(preg_match('/^[A-Za-z0-9]{9,25}@conestogac.on.ca$/', $em))
			{
				//Check if email already exists 
				$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

				//Count the number of rows returned
				$num_rows = mysqli_num_rows($e_check);

				if($num_rows > 0) {
					array_push($error_array, "Email already in use<br>");
				}
			}
			else
			{
				array_push($error_array, "Please enter a valid conestoga email<br>");
			}

		}
		else {
			array_push($error_array, "Invalid email format<br>");
		}

	//check for valid student ID
    if($studentID == $studentID2) {
		//Check if studentID is in valid format 
		if(preg_match('/^[0-9]{7}$/', $studentID)) {

			//Check if studentID already exists 
			$s_check = mysqli_query($con, "SELECT student_id FROM users WHERE student_id='$studentID'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($s_check);

			if($num_rows > 0) {
				array_push($error_array, "studentID already in use<br>");
			}
		}
		else {
			array_push($error_array, "Invalid studentID<br>");
		}
	}
	else {
		array_push($error_array, "Student ID's don't match<br>");
	}



	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}

	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
	}

	if($password != $password2) {
		array_push($error_array,  "Your passwords do not match<br>");
	}
	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

	if(strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
	}


	if(empty($error_array)) {
		$password = md5($password); //Encrypt password before sending to database

		//Generate username by concatenating first name and last name
		$username = strtolower($fname . "_" . $lname);
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");


		$i = 0; 
		//if username exists add number to username
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++; //Add 1 to i
			$username = $username . "_" . $i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
		}

		//Profile picture assignment
		$rand = rand(1, 2); //Random number between 1 and 2

		if($rand == 1)
			$profile_pic = "assets/images/profile_pics/defaults/head_1.png";
		else if($rand == 2)
			$profile_pic = "assets/images/profile_pics/defaults/head_2.png";


		$query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em','$studentID', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

		array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");

		//Clear session variables 
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
        $_SESSION['student_id'] = "";
        $_SESSION['student_id2'] = "";
	}

}
?>