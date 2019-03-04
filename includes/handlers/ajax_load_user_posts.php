<?php  
include("../../config/config.php"); //needs connection
include("../classes/User.php");		//needs user class
include("../classes/Post.php");		//needs post class

$posts = new Post($con, $_REQUEST['userLoggedIn']); //creating the posts object for the Post class with the parameters $con(database connection) and userLoggedIn.
 //_REQUEST method is used to access the data from the ajax call
$posts->loadPostsUser($_REQUEST); // calling the loadpostsFriends function to load the posts using the Object Oriented approach
?>