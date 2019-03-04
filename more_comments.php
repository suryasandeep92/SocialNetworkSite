<?php  
include("config/config.php"); //needs connection
include("includes/classes/User.php"); 
include("includes/classes/Post.php");

$intialCount = $_REQUEST['intialCount'];
$id = $_REQUEST['postId'];
?>

	<?php  
	$get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$id' limit $intialCount,5");
	$count = mysqli_num_rows($get_comments);
	?>
	<?php

	if($count != 0) {

		while($comment = mysqli_fetch_array($get_comments)) {

			$comment_body = $comment['post_body'];
			$posted_to = $comment['posted_to'];
			$posted_by = $comment['posted_by'];
			$date_added = $comment['date_added'];
			$removed = $comment['removed'];

			//Timeframe
			$date_time_now = date("Y-m-d H:i:s");
			$start_date = new DateTime($date_added); //Time of post
			$end_date = new DateTime($date_time_now); //Current time
			$interval = $start_date->diff($end_date); //Difference between dates 
			if($interval->y >= 1) {
				if($interval == 1)
					$time_message = $interval->y . " year ago"; //1 year ago
				else 
					$time_message = $interval->y . " years ago"; //1+ year ago
			}
			else if ($interval->m >= 1) {
				if($interval->d == 0) {
					$days = " ago ";
				}
				else if($interval->d == 1) {
					$days = $interval->d . " day ago ";
				}
				else {
					$days = $interval->d . " days ago ";
				}


				if($interval->m == 1) {
					$time_message = $interval->m . " month ". $days;
				}
				else {
					$time_message = $interval->m . " months ". $days;
				}

			}
			else if($interval->d >= 1) {
				if($interval->d == 1) {
					$time_message = "Yesterday";
				}
				else {
					$time_message = $interval->d . " days ago ";
				}
			}
			else if($interval->h >= 1) {
				if($interval->h == 1) {
					$time_message = $interval->h . " hour ago ";
				}
				else {
					$time_message = $interval->h . " hours ago ";
				}
			}
			else if($interval->i >= 1) {
				if($interval->i == 1) {
					$time_message = $interval->i . " minute ago ";
				}
				else {
					$time_message = $interval->i . " minutes ago ";
				}
			}
			else {
				if($interval->s < 30) {
					$time_message = "Just now";
				}
				else {
					$time_message = $interval->s . " seconds ago ";
				}
			}

			$user_obj = new User($con, $posted_by);
			?>

			<div class="comment_section">
				<a href=profile.php?profile_username="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic();?>" title="<?php echo $posted_by; ?>" style="float:left;" height="30"></a>
				<a href=profile.php?profile_username="<?php echo $posted_by?>" target="_parent"> <b> <?php echo $user_obj->getFirstAndLastName(); ?> </b></a>
				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message . "<br>" . $comment_body; ?> 
			</div>
			<hr>
			<?php

		}
		?>
		</div>
		<?php 
	}
	else {
		echo "<center id='nocomment'>No Comments to Show!</center>";
		//echo "reachedMax";
	}

	?>

