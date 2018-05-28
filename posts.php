<?php
	
	require_once('operations.php');
	
	$objOpr = new Operations();
	
	$posts = $objOpr->getPosts();
	if($posts) {
	
		foreach($posts as $post) {
	
			echo '<div>';
					echo '<h2><a href="blog/'.$post['id'].'">'.$post['postSubject'].'</a></h2>';
					echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($post['postCreated'])).'</p>';                
					echo '<p><a href="blog/'.$post['id'].'">Read More</a></p>';                
			echo '</div>';
		}		
	} else 
		echo "<p>There is No post available</p>";