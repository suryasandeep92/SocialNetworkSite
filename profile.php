<?php 
include("includes/header.php");       //Contains navigation header and details about the user who is loggedIn
 
if(isset($_GET['profile_username'])) {
	$username = $_GET['profile_username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	$user_array = mysqli_fetch_array($user_details_query);
    
    $prof_obj = new User($con, $username);
}

if(isset($_POST['remove_friend'])) {
	$user = new User($con, $userLoggedIn);
	$user->removeFriend($username);
	header("Location: profile.php?profile_username=$username");
}

if(isset($_POST['add_friend'])) {
	$user = new User($con, $userLoggedIn);
	$user->sendRequest($username);
	header("Location: profile.php?profile_username=$username");
}

if(isset($_POST['respond_request'])) {
	header("Location: requests.php");
}

 ?>
	<div class="user_details column" style="height:280px;">
		<img src="<?php echo $user_array['profile_pic']; ?>">

		<div class="user_details_left_right" align="center">
			
			<?php
            $num_frnds = $prof_obj->numFriends();
            $num_posts = $prof_obj->getNumPosts();

			echo $user_array['first_name'].' '.$user_array['last_name']."<br>";
            echo "Posts: " . $num_posts. "<br>"; 
			echo "Likes: " . $user_array['num_likes']. "<br>";
            echo "Friends: " . $num_frnds;
			?>
            
		</div>

		<form action="profile.php?profile_username=<?php echo $username; ?>" method="POST" style="display: block; padding-left: 50px;">
 			<?php 
 			$profile_user_obj = new User($con, $username); 
 			if($profile_user_obj->isClosed()) {
 				header("Location: user_closed.php");
 			}

 			$logged_in_user_obj = new User($con, $userLoggedIn); 

 			if($userLoggedIn != $username) {

 				if($logged_in_user_obj->isFriend($username)) {
 					echo '<input type="submit" name="remove_friend" class="btn btn-danger" value="Remove Friend"><br>';
 				}
 				else if ($logged_in_user_obj->didReceiveRequest($username)) {
 					echo '<input type="submit" name="respond_request" class="btn btn-warning" value="Respond to Request"><br>';
 				}
 				else if ($logged_in_user_obj->didSendRequest($username)) {
 					echo '<input type="submit" name="" class="btn btn-default" value="Request Sent" disabled><br>';
 				}
 				else 
 					echo '<input type="submit" name="add_friend" class="btn btn-success" value="Add Friend"><br>';

 			}


 			?>

 		</form>

	</div>

	<div class="main_column column">

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">
        <p id="endofposts" style='text-align: centre;'> No more posts to show! </p>

	</div>

	<script>
		
	//Declaring global variables
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';
	var username = '<?php echo $username; ?>'
	var start = 0; //will be used in the sql query
    var limit = 10;//will be used in the sql query 
    var reachedMax = false; //when it is true that means there are no posts to show

    $(document).ready(function () {		   
               getData(); // when the document is ready, will call this method
            });

	function getData() {

		if(reachedMax) // if "reachedMax is True" display the endofposts text and then return
		{
		$('#loading').hide();
		$('#endofposts').show();
		return;
		}
     
		$('#loading').show(); //show loading sign while making the call
		$('#endofposts').hide(); //hide the endofposts text
		//Original ajax request for loading first posts 
		$.ajax({
			url: "includes/handlers/ajax_load_user_posts.php", //data will be sent to this page
			type: "POST", //Type is post
			data: { //The data we are sending to the "includes/handlers/ajax_load_posts.php" can be retrieved using _REQUEST 
					   userLoggedIn: username ,
                       getData: 1,
                       start: start,
                       limit: limit
                   },
			cache:false,

			success: function(data) {	//if it receives any response then below code will be executed							
				if (data == "reachedMax"){ //if returned "data == reachedMax" then change the value to "true" and then show the "endofposts" text.
					reachedMax = true;
					$('#loading').hide();
					$('#endofposts').show();
				}
              	//if there is any data to show then it will append to the ".posts_area" class            
                    else{
                    		$('#loading').hide();
                            start += limit; //then increment the start index by limit that means -> start = start + limit -> example start = 0 + 10, this value will be used to query the database
                            $('.posts_area').append(data); // then append the data response to the ".posts_area"
                        }
			}
		});
	}	

	$(window).scroll(function() {
			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			//when scrolling reached to the bottom call the getData()
			if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight)) {
				getData();
			} //End if 

			return false;

		}); //End (window).scroll(function())
	//Comments toggle function
	function toggle(id){
							var postId = id;
							$(".post_comment"+postId).toggle(); 
						}

	function showcomments(id)
		{
								
				var postId = id;
				if ( $('#'+postId).children().length > 0 )
					return;
				else
					{	
						$.ajax({
							url: "load_comments.php",
							type: "POST",
							data: {  
									userLoggedIn: userLoggedIn,
						            postId: postId
						            },
							cache:false,

							success: function(data) {					
								if (data == "reachedMax"){ //if returned "data == reachedMax" then change the value to "true" and then show the "endofposts" text.
								}
						    else{
						        $('#'+postId).append(data);
						        }
						    }
				       });
			        }
		}						
	//Posting comments 
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

	function deletePost(post_id)
	{
		bootbox.confirm("Are you sure you want to delete this post?", function(result) {

		$.post("includes/form_handlers/delete_post.php?post_id="+post_id, {result:result});

		if(result)
			location.reload();
		});
	}
</script>
	
	</div>
</body>
</html>