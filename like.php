<?php 
	require 'config/config.php';
	include("includes/classes/User.php");
	include("includes/classes/Post.php");
	include("includes/classes/Notification.php");
	
	$userLoggedIn = $_REQUEST['userLoggedIn'];
	$post_id = $_REQUEST['post_id'];
	$type = $_REQUEST['classname'];
	//likes for the posts
	$get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($get_likes);
	$total_likes = $row['likes']; 
	$user_liked = $row['added_by'];
	//likes for the user
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
	$row = mysqli_fetch_array($user_details_query);
	$total_user_likes = $row['num_likes'];


	switch ($type) {
	case 'like':
		$total_likes++;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes++;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
		$insert_user = mysqli_query($con, "INSERT INTO likes VALUES('', '$userLoggedIn', '$post_id')");

		//Insert Notification
		if($user_liked != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id, $user_liked, "like");
		}
		break;
	case 'dislike':
		$total_likes--;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes--;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
		$insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
		break;
	}

echo getlikes($post_id,$con);

function getlikes($post_id,$con)
{
	$query = mysqli_query($con, "SELECT * FROM posts where id = $post_id");
	$row = mysqli_fetch_array($query);
	$nooflikes = $row['likes'];
	$likes['totallikes'] = $nooflikes; 
	return json_encode($likes);
}

 ?>
