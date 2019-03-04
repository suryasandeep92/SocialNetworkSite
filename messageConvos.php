<?php 

include("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);
?>
<div class="user_details column">
		<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right" align="center">
			<a href=profile.php?profile_username=<?php echo $userLoggedIn; ?>>
			<?php 
			echo $user['first_name'] . " " . $user['last_name'];

			 ?>
			</a>
			<br>
			<?php echo "Posts: " . $user['num_posts']. "<br>"; 
			echo "Likes: " . $user['num_likes'];

			?>
		</div>
</div>
<div class="main_column column">
	<?php echo $message_obj->getConvosDropdown(); ?>
</div>