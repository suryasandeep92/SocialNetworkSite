
	<script>
	//Declaring global variables
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';
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
			url: "includes/handlers/ajax_load_posts.php", //data will be sent to this page
			type: "POST", //Type is post
			data: { //The data we are sending to the "includes/handlers/ajax_load_posts.php" can be retrieved using _REQUEST 
					   userLoggedIn: userLoggedIn,
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
					$('#showmorebtn').hide();
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
	/*
	$(window).scroll(function() {
			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			//when scrolling reached to the bottom call the getData()
			if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight)) {
				getData();
			} //End if 

			return false;

		}); //End (window).scroll(function())
	*/
	
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
	
 