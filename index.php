<?php 
include("includes/header.php");       //Contains navigation header and details about the user who is loggedIn
//include("includes/classes/User.php"); //Contains User class, have methods to get information about the user
//include("includes/classes/Post.php"); //Contains Post class, have methods to post the data and retrieve data and so on


if(isset($_POST['post'])){
	$post = new Post($con, $userLoggedIn);
	$post->submitPost($_POST['post_text'], $userLoggedIn);
    header("Location: index.php");
}

//user Details Update query for the user details column
$userDetailObj = new User($con, $userLoggedIn);
$noofPosts = $userDetailObj->getNumPosts();
$userDetailUpdateQuery = mysqli_query($con, "UPDATE users SET num_posts = '$noofPosts' WHERE username = '$userLoggedIn'");
 ?>

	<div class="user_details column" style="height:210px;">
		<a href=profile.php?profile_username=<?php echo $userLoggedIn; ?>>  <img class="profile_picture" src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right" align="center">
			<a href=profile.php?profile_username=<?php echo $userLoggedIn; ?>>
			<?php 
			echo $user['first_name'] . " " . $user['last_name'];
    //Everything in the user_details_column is retrieved from the '$user', which we have created in the header.php file
			 ?>
			</a>
			<br>
			<?php echo "Posts: " . $noofPosts. "<br>"; 
			echo "Likes: " . $user['num_likes'];

			?>
        </div>
	</div>
   

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<img class="postform_profile_picture" src="<?php echo $user['profile_pic']; ?>">
			<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
			<input type="submit" name="post" id="post_button" value="Post">

			<hr>

		</form>
		

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif"> 
		<center><button id="showmorebtn" onclick="getData();">show more posts</button></center>
        <p id="endofposts" style='text-align: centre;'> No more posts to show! </p>


	</div>

	<?php require 'main_js.php'; ?>




	</div>
</body>
</html>