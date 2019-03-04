<?php  
include("includes/header.php");
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$postID = $id;
}
else {
	$id = 0;
}
if(isset($_GET['type'])){
	$type = $_GET['type'];
}

?>

<div class="user_details column" style="height:280px;">
		<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right" align="center">
			<a href="<?php echo $userLoggedIn; ?>">
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

	<div class="main_column column" id="main_column">

		<div class="posts_area">
			<?php 
				$post = new Post($con, $userLoggedIn);
				$post->getSinglePost($id,$type);
			

			$user = $userLoggedIn;
			$id = $postID;
			$post_details = mysqli_query($con, "SELECT * FROM posts WHERE id='$id'");
			$get_post_details = mysqli_fetch_array($post_details);
			$post_posted_by = $get_post_details['added_by'];
			?>

<div action="" id="comment_form" name="" method="POST">
		<textarea name="comment_body" id="comment_body<?php echo $id;?>"></textarea>
		<input type="hidden" name="commentID" value="<?php echo $id; ?>">
		<input type="button" name="" value="Post" onclick="postComment(<?php echo $id;?>);">
</div>
<div id="comment_section<?php echo $id; ?>">

</div>

<center><button onclick="getComments();">show more comments</button></center>
	 
	
	<script>
	//Posting comments
	var postid = <?php echo $postID; ?>;
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';
	var intialCount = 0;

	$(document).ready(function () {		   
               getComments(); // when the document is ready, will call this method
            });

	function getComments()
	{
		if($("#nocomment").is(":visible"))
		{
			return;
		}
		else
		{
		$.ajax({
					url: "more_comments.php", //data will be sent to this page
					type: "POST", //Type is post
					data: { //The data we are sending to the "includes/handlers/ajax_load_posts.php" can be retrieved using _REQUEST 
							   intialCount: intialCount,
		                       postId: postid
		                   },
					cache:false,

					success: function(data) {
						$("#comment_section"+postid).append(data);
						intialCount = intialCount + 5;
					}
				});
	    }
	}

	function postComment(postId)
	{
	  var postId = postId; 
	  var commentBody = document.getElementById("comment_body"+postId).value;

	  if(commentBody == '')
	  {
	  	alert('please enter something in the commnent box');
	  }
	  else
		{
			  $.ajax({
					url: "update_comments.php", //data will be sent to this page
					type: "POST", //Type is post
					data: { //The data we are sending to the "includes/handlers/ajax_load_posts.php" can be retrieved using _REQUEST 
							   userLoggedIn: userLoggedIn,
							   commentBody: commentBody,
		                       postId: postId
		                   },
					cache:false,

					success: function(data) {
							if($('#nocomment').is(":visible"))
							{
							$('#commentcount'+postId).remove();
							document.getElementById("comment_section"+postId).innerHTML=data;
							var commentcount = $('#commentcount'+postId).val();
							$('#cc'+postId).text(commentcount);
							document.getElementById("comment_body"+postId).value = '';
							$('#nocomment').hide();
							}
							else
							{	
							$('#commentcount'+postId).remove();
							document.getElementById("comment_section"+postId).innerHTML=data+document.getElementById("comment_section"+postId).innerHTML;
							var commentcount = $('#commentcount'+postId).val();
							$('#cc'+postId).text(commentcount);
							document.getElementById("comment_body"+postId).value = '';
							}
					}
				});
				
		}
	}

	//get likes
	function getlikes(post_id)
	{
		var action = '';
		if($('#like'+post_id).hasClass("far"))
		{
			action = 'like';
		}
		else
		{
			action = 'dislike';
		}
		//alert(action);
		var post_id = post_id;
		$.ajax({
			url: "like.php", //data will be sent to this page
			type: "POST", //Type is post
			data: {  
					   userLoggedIn: userLoggedIn,
                       post_id: post_id,
                       classname: action
                   },
			cache:false,

			success: function(data) {
				 //alert(data);
				 res = JSON.parse(data);
				$('#nooflikes'+post_id).text(res.totallikes);
				if(action == 'like')
				{
					$('#like'+post_id).removeClass("far fa-thumbs-up");
					$('#like'+post_id).addClass("fas fa-thumbs-up");
				}
				else if(action == 'dislike')
				{
					$('#like'+post_id).removeClass("fas fa-thumbs-up");
					$('#like'+post_id).addClass("far fa-thumbs-up");
				}

			}
		});
	}
	
	</script>