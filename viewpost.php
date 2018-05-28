<?php
    require_once('operations.php');	
	
	$objOpr = new Operations();
	
	$posts = $objOpr->getPosts();
	
	if($posts) {
		
		$post = $posts[0];
	
		echo '<div>';
			echo '<h1>'.$post['postSubject'].'</h1>';
			echo '<p>Posted on '.date('jS M Y', strtotime($post['postCreated'])).'</p>';
			echo '<p>'.$post['postContent'].'</p>';                
		echo '</div>';
		echo "<a href='index.php'>Back</a>";
	} else {
		
		echo '<p> There is no data available </p>';
	}
	