<?php
class User {
	//Declaring the class variables
	private $user;
	private $con;

	//Calling the constructor whenever object is created
	public function __construct($con, $user){
		$this->con = $con; // accessing the current class variable "private $con"
		// Getting the user information using the below query
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
		$this->user = mysqli_fetch_array($user_details_query); //accessing the current class variable "private $user"
	}

	public function getUsername() {
		return $this->user['username'];
	}

	public function getNumPosts() {
		
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT * FROM posts WHERE added_by='$username' and deleted = 'no'");
		return mysqli_num_rows($query);
	
	}

	public function getFirstAndLastName() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
	}

	public function isClosed() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);

		if($row['user_closed'] == 'yes')
			return true;
		else 
			return false;
	}

	public function getProfilePic() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT profile_pic FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['profile_pic'];
	}

	public function isFriend($username_to_check) {
		$usernamecheck = $username_to_check;
		$loggedInUser = $this->user['username'];

		$query = mysqli_query($this->con, "SELECT * FROM friends WHERE (request_made ='$loggedInUser' AND request_accepted ='$usernamecheck') OR (request_made ='$usernamecheck' AND request_accepted ='$loggedInUser')");

		if(mysqli_num_rows($query) === 1){
			return true;
        }
		else{
			return false;
        }

	}
    
    public function numFriends(){
        
            $friend = array();
            $username = $this->user['username'];
            $query = mysqli_query($this->con, "SELECT * FROM friends WHERE request_made = '$username' OR request_accepted='$username'");
            $count = 0;
            if(mysqli_num_rows($query) > 0)
            {
                while($row = mysqli_fetch_array($query))
                {
                    if($row['request_made'] != '$username')
                        array_push($friend,$row['request_made']);
                    else if($row['request_accepted'] != '$username')
                        array_push($friend,$row['request_accepted']);
                }

                $count = count($friend);
                return $count;
            }
            else
                return 0;
        }

    public function getNumberOfFriendRequests() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$username'");
		return mysqli_num_rows($query);
	}

    public function didReceiveRequest($user_from) {
		$user_to = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didSendRequest($user_to) {
		$user_from = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function removeFriend($user_to_remove) {
		$logged_in_user = $this->user['username']; 

		$query = mysqli_query($this->con, "SELECT * FROM friends
		where (request_made='$user_to_remove' AND request_accepted='$logged_in_user') OR 
			  (request_made='$logged_in_user' AND request_accepted='$user_to_remove')");

		if(mysqli_num_rows($query) == 1)
		{
			$delQuery = mysqli_query($this->con, "DELETE FROM friends
		where (request_made='$user_to_remove' AND request_accepted='$logged_in_user') OR 
			  (request_made='$logged_in_user' AND request_accepted='$user_to_remove')");
		}
		
	}

	public function sendRequest($user_to) {
		$user_from = $this->user['username'];
		$query = mysqli_query($this->con, "INSERT INTO friend_requests VALUES('', '$user_to', '$user_from')");
	}

}

?>