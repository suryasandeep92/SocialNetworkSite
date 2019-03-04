<?php  
include("config/config.php"); //needs connection
include("includes/classes/User.php"); 
include("includes/classes/Post.php");
include("includes/classes/Notification.php");

$userLoggedIn = $_REQUEST['userLoggedIn'];
$commentBody = $_REQUEST['commentBody'];
$commentBody = mysqli_escape_string($con, $commentBody);
$postId = $_REQUEST['postId'];
//getting the post details
$postQuery = mysqli_query($con, "SELECT * FROM posts WHERE id = $postId");
$postQueryDetails = mysqli_fetch_array($postQuery);
$posted_to = $postQueryDetails['added_by'];

$date_time_now = date("Y-m-d H:i:s");
//inserting comment into the database
$insert_comment = mysqli_query($con, "INSERT INTO comments VALUES ('', '$commentBody', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$postId')");

$lastInsertedId = mysqli_insert_id($con);

$latestCommentDetails = mysqli_query($con, "SELECT * FROM comments WHERE id =$lastInsertedId");
//inserting the notification
if($posted_to != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($postId, $posted_to, "comment");
		}

 if($comment = mysqli_fetch_array($latestCommentDetails)) {

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
			$get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$postId'");
			$count = mysqli_num_rows($get_comments);
			?>
			<input type="hidden" id="commentcount<?php echo $postId;?>" value="<?php echo $count; ?>">
			<div class="comment_section">
				<a href=profile.php?profile_username="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic();?>" title="<?php echo $posted_by; ?>" style="float:left;" height="30"></a>
				<a href=profile.php?profile_username="<?php echo $posted_by?>" target="_parent"> <b> <?php echo $user_obj->getFirstAndLastName(); ?> </b></a>
				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message . "<br>" . $comment_body; ?> 
			</div>
			<hr>
		<?php
}
exit;
		?>