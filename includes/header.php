<?php  
require 'config/config.php'; //database connection file
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

//if the session variable is set then user is loggedIn or else redirected to the register.php page
$_SESSION['username'] = 'bala_surya';

if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'"); //getting the information about the user
	$user = mysqli_fetch_array($user_details_query); //this will have all of the information about the user
}
else {
	header("Location: register.php");
}

?>

<html>
<head>
	<title>Welcome to Conestoga Student Connect</title>

	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/jquery.jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>
	<script src="assets/js/demo.js"></script>

	<!-- CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
</head>
<body>
	<div class="mobile_top_bar"> 

		<?php
				//Unread messages 
				$messages = new Message($con, $userLoggedIn);
				$num_messages = $messages->getUnreadNumber();

				//Unread notifications 
				$notifications = new Notification($con, $userLoggedIn);
				$num_notifications = $notifications->getUnreadNumber();

				//Unread notifications 
				$user_obj = new User($con, $userLoggedIn);
				$num_requests = $user_obj->getNumberOfFriendRequests();
			?>
		<div class="search" css="text-align:center">

			<form action="search.php" method="GET" name="search_form">
				<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">

				<div class="button_holder">
					<img src="assets/images/icons/magnifying_glass.png">
				</div>

			</form>

			<div class="search_results">
			</div>

			<div class="search_results_footer_empty">
			</div>

		</div>
		
		<div class="nav" align="center">
			<a href="index.php">
				<i class="fa fa-home fa-lg"></i>
			</a>
			<a href="messageConvos.php">
				<i class="fa fa-envelope fa-lg"></i>
				<?php
				if($num_messages > 0)
				 echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
			?>
			</a>
			
			<a href="notifications.php">
				<i class="fa fa-bell fa-lg"></i>
				<?php
				if($num_notifications > 0)
				 echo '<span class="notification_badge_likecomm" id="unread_notification">' . $num_notifications . '</span>';
			?>
			</a>
			
			<a href="requests.php">
				<i class="fa fa-users fa-lg"></i>
				<?php
				if($num_requests > 0)
				 echo '<span class="notification_badge_req" id="unread_notification">' . $num_requests . '</span>';
			?>
			</a>
			
			<a href="settings.php">
				<i class="fa fa-cog fa-lg"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i class="fa fa-sign-out-alt fa-lg"></i>
			</a>



		</div>

	</div>
	<div class="top_bar"> 

		<div class="logo" align="center">
			<a href="index.php">CSC!</a>
		</div>
		<?php
				//Unread messages 
				$messages = new Message($con, $userLoggedIn);
				$num_messages = $messages->getUnreadNumber();

				//Unread notifications 
				$notifications = new Notification($con, $userLoggedIn);
				$num_notifications = $notifications->getUnreadNumber();

				//Unread notifications 
				$user_obj = new User($con, $userLoggedIn);
				$num_requests = $user_obj->getNumberOfFriendRequests();
			?>
		<div class="search" align="center">

			<form action="search.php" method="GET" name="search_form">
				<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">

				<div class="button_holder">
					<img src="assets/images/icons/magnifying_glass.png">
				</div>

			</form>

			<div class="search_results">
			</div>

			<div class="search_results_footer_empty">
			</div>

		</div>
		
		<div class="nav" align="center">
			<a href="messageConvos.php">
				<i class="fa fa-envelope fa-lg"></i>
				<?php
				if($num_messages > 0)
				 echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
			?>
			</a>
			
			<a href="notifications.php">
				<i class="fa fa-bell fa-lg"></i>
				<?php
				if($num_notifications > 0)
				 echo '<span class="notification_badge_likecomm" id="unread_notification">' . $num_notifications . '</span>';
			?>
			</a>
			
			<a href="requests.php">
				<i class="fa fa-users fa-lg"></i>
				<?php
				if($num_requests > 0)
				 echo '<span class="notification_badge_req" id="unread_notification">' . $num_requests . '</span>';
			?>
			</a>
			
			<a href="settings.php">
				<i class="fa fa-cog fa-lg"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i class="fa fa-sign-out-alt fa-lg"></i>
			</a>

		</div>

	</div>


	<div class="wrapper">