<?php
include("includes/header.php"); //Header 
?>

<div class="main_column column" id="main_column">

	<h4>Friend Requests</h4>

	<?php  

	$query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'");
	if(mysqli_num_rows($query) == 0)
		echo "You have no friend requests at this time!";
	else {

		while($row = mysqli_fetch_array($query)) {
			$user_from = $row['user_from'];
			$user_from_obj = new User($con, $user_from);

			echo $user_from_obj->getFirstAndLastName() . " sent you a friend request!";

			if(isset($_POST['accept_request' . $user_from ])) {
				$query = mysqli_query($con, "INSERT INTO friends VALUES ('', '$user_from', '$userLoggedIn')");
				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");

				header("Location: requests.php");
			}

			if(isset($_POST['ignore_request' . $user_from ])) {
				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
				
				header("Location: requests.php");
			}

			?>
			<form action="requests.php" method="POST">
				<input type="submit" class="btn-success" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="Accept">
				<input type="submit" class="btn-danger" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="Ignore">
			</form>
			<?php


		}

	}

	?>


</div>