<?php
class Post {
	private $user_obj;
	private $con;

	//Calling the constructor whenever object is created
	public function __construct($con, $user){
		$this->con = $con; //current class variable, store the database connection
		$this->user_obj = new User($con, $user); //current class variable, creates an object for the User class
	}

	public function submitPost($body, $added_by) {
		$body = strip_tags($body); //removes html tags 
		$body = mysqli_real_escape_string($this->con, $body);
		$check_empty = preg_replace('/\s+/', '', $body); //Deltes all spaces 
      
		if($check_empty != "") {


			//Current date and time
			$date_added = date("Y-m-d H:i:s");
			//Get username
			//$posted_by = $this->user_obj->getUsername();
			$posted_by = $added_by;

			//insert post 
			$query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$posted_by', '$date_added', 'no', 'no', '0')");
			$returned_id = mysqli_insert_id($this->con);

			//Insert notification 

			//Update post count for user 
			$num_posts = $this->user_obj->getNumPosts();

			$update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$posted_by'");
            
            $body = "";

		}
	}

	//this method will be called from the ajax_load_posts.php file
	public function loadPostsFriends($data) {
	//this $data(array) parameter contains information about userLoggedIn: userLoggedIn,getData: 1, start: start and limit: limit from the ajax call from the index.php page
                                      
		$start = $data['start'];
		$limit = $data['limit'];
        $userLogged = $data['userLoggedIn'];
		//calling the getUsername() from the User class with the object that we have created "$this->user_obj".
		$userLoggedIn = $this->user_obj->getUsername();


		$str = ""; //String to return 
		$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC LIMIT $start,$limit");

		if(mysqli_num_rows($data_query) > 0) {

		while($row = mysqli_fetch_array($data_query)) {
				$id = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by']; //this variable holds the username who posted the post
				$date_time = $row['date_added'];

				//Check if user who posted, has their account closed
				$added_by_obj = new User($this->con, $added_by);
				if($added_by_obj->isClosed()) {
					continue;//which will go to the start of the loop and runs the next iteration
				}

				//Creating the object who has loggedIn successfully
				$user_logged_obj = new User($this->con, $userLoggedIn);

				if($user_logged_obj->isFriend($added_by) OR $added_by == $userLogged)
				//now checking whether the post is added by friend or not
				{

					$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];
					//comments
					$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);
					//likes
					$likes_query = mysqli_query($this->con,"SELECT * FROM posts WHERE id = '$id'");
					$row_likes = mysqli_fetch_array($likes_query);
					$total_likes = $row_likes['likes'];
					//check whether userloggedIn liked or not
					$like_check_query = mysqli_query($this->con, "SELECT * FROM likes WHERE post_id = '$id' AND username = '$userLogged'");
					if(mysqli_num_rows($like_check_query) > 0)
						$likeclass = 'fas fa-thumbs-up';
					else
						$likeclass = 'far fa-thumbs-up';
					//PostDeleteButton
					if($added_by == $userLogged)
						$delete_button = "<button class='delete_button btn-danger' onClick='deletePost($id);'>X</button>";
					else
						$delete_button = "";

					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval-> m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$str .= "<div class='status_post'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href=profile.php?profile_username=$added_by> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;&nbsp;$time_message
									$delete_button
								</div>
								<div id='post_body'>
									$body
									<br>
								</div>
								<br>
								<br>

								<div class='newsfeedPostOptions'>
									<button class='btn btn-primary' id='btn$id' onClick='showcomments($id); toggle($id);'>Comments <b id=cc$id class='cc'>$comments_check_num</b></button>&nbsp;&nbsp;&nbsp;&nbsp;
									<i class='$likeclass' id='like$id' style='font-size:24px' onclick='getlikes($id);'></i>
									<b><span class='like_value' id='nooflikes$id'>$total_likes
									</span></b>
								</div>
							</div>
							<div class='post_comment$id' id='$id' style='display:none;'>
							</div>
							<hr>";
				}
			} //End while loop
			exit($str);
		}
		else
			exit('reachedMax');
	}
    
    
    public function loadPostsUser($data) {
	//this $data(array) parameter contains information about userLoggedIn: userLoggedIn,getData: 1, start: start and limit: limit from the ajax call from the index.php page
                                      
		$start = $data['start'];
		$limit = $data['limit'];
        $username = $data['userLoggedIn'];
		//calling the getUsername() from the User class with the object that we have created "$this->user_obj".
		$userLoggedIn = $this->user_obj->getUsername();

		$str = ""; //String to return 
		$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' and added_by ='$username' ORDER BY id DESC LIMIT $start,$limit");

		if(mysqli_num_rows($data_query) > 0) {

		while($row = mysqli_fetch_array($data_query)) {
				$id = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by']; //this variable holds the username who posted the post
				$date_time = $row['date_added'];
				

					$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$username'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];

					$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);

					//likes
					$likes_query = mysqli_query($this->con,"SELECT * FROM posts WHERE id = '$id'");
					$row_likes = mysqli_fetch_array($likes_query);
					$total_likes = $row_likes['likes'];
					//check whether userloggedIn liked or not
					$like_check_query = mysqli_query($this->con, "SELECT * FROM likes WHERE post_id = '$id' AND username = '$userLoggedIn'");
					if(mysqli_num_rows($like_check_query) > 0)
						$likeclass = 'fas fa-thumbs-up';
					else
						$likeclass = 'far fa-thumbs-up';

					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval-> m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$str .= "<div class='status_post'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href=profile.php?profile_username=$added_by> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;&nbsp;$time_message
								</div>
								<div id='post_body'>
									$body
									<br>
								</div>
								<br>
								<br>

								<div class='newsfeedPostOptions'>
									<button class='btn btn-primary' id='btn$id' onClick='showcomments($id); toggle($id);'>Comments <b id=cc$id class='cc'>$comments_check_num</b></button>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<i class='$likeclass' id='like$id' style='font-size:24px' onclick='getlikes($id);'></i>
									<b><span class='like_value' id='nooflikes$id'>$total_likes
									</span></b>
								</div>
							</div>
							<div class='post_comment$id' id='$id' style='display:none;'>
							</div>
							<hr>";
				
				
			} //End while loop
			exit($str);
		}
		else
			exit('reachedMax');
	}

public function getSinglePost($post_id,$type) {

		$userLoggedIn = $this->user_obj->getUsername();
		
		if($type == 0){
		$opened_query = mysqli_query($this->con, "UPDATE notifications SET opened='yes' WHERE user_to='$userLoggedIn' AND link LIKE '%=$post_id&type=$type'");
		}

		$str = ""; //String to return 
		$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' AND id='$post_id'");

		if(mysqli_num_rows($data_query) > 0) {


			$row = mysqli_fetch_array($data_query); 
				$id = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				$date_time = $row['date_added'];

				//Check if user who posted, has their account closed
				$added_by_obj = new User($this->con, $added_by);
				if($added_by_obj->isClosed()) {
					return;
				}

				$user_logged_obj = new User($this->con, $userLoggedIn);
				if($user_logged_obj->isFriend($added_by)  OR $added_by == $userLoggedIn){

					/*
					if($userLoggedIn == $added_by)
						$delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
					else 
						$delete_button = "";
					*/

					$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];

					$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);

					//likes
					$likes_query = mysqli_query($this->con,"SELECT * FROM posts WHERE id = '$id'");
					$row_likes = mysqli_fetch_array($likes_query);
					$total_likes = $row_likes['likes'];
					//check whether userloggedIn liked or not
					$like_check_query = mysqli_query($this->con, "SELECT * FROM likes WHERE post_id = '$id' AND username = '$userLoggedIn'");
					if(mysqli_num_rows($like_check_query) > 0)
						$likeclass = 'fas fa-thumbs-up';
					else
						$likeclass = 'far fa-thumbs-up';

					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
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
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$str .= "<div class='status_post'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href=profile.php?profile_username=$added_by> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;&nbsp;$time_message
								</div>
								<div id='post_body'>
									$body
									<br>
								</div>
								<br>
								<br>

								<div class='newsfeedPostOptions'>
									<button class='btn btn-primary' id='btn$id' onClick=''>Comments <b id=cc$id class='cc'>$comments_check_num</b></button>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<i class='$likeclass' id='like$id' style='font-size:24px' onclick='getlikes($id);'></i>
									<b><span class='like_value' id='nooflikes$id'>$total_likes
									</span></b>
								</div>
							</div>
							<div class='post_comment$id' id='$id' style='display:none;'>
							</div>
							";
				}
				else {
					echo "<p>You cannot see this post because you are not friends with this user.</p>";
					return;
				}
		}
		else {
			echo "<p>No post found. If you clicked a link, it may be broken.</p>";
					return;
		}

		echo $str;
	}


}

?>