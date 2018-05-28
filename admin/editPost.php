<?php
	/*
	* Author: Iftikhar Ahmed
	* 
	* Date: 26/05/2018
	*
	* @desc: This page is used to edit a post and create new as well. 
	*
	* @required: operations.php, to fetch posts from database 
	*
	* @methods: NULL
	
	*/
	//require_once('../operations.php');
	
	//$objOpr = new Operations();
	
	if(!isset($_SESSION['isLoggedIn'])){ //If not login then redirect to login page.
		
		header("Location: login");
    }     		
	
	$path = $path_info['call_parts'][0]; 
	
	$action = $path_info['call_parts'][1];
	
	if($action ==='edit') {
		
		$id = $path_info['call_parts'][2];
		
		$posts = $objOpr->getPost($id);	
	
		$post = $posts[0];	
		
	} else
		$action ='save'
		
	
	// If its on edit mode then fill the input fields with respective post values.
?>

<form action='<?php echo $action; ?>' method='post'>
    <input type='hidden' name='id' value='<?php if(isset($post)) { echo $post['id']; } ?>'>
	<input type='hidden' name='action' value='<?php if(isset($post)) { echo 'updatePost'; } else { echo 'savePost'; } ?>'>
    <p><label>Subject</label><br />
    <input type='text' name='postSubject' value='<?php if(isset($post)) { echo $post['postSubject']; } ?>'></p>

    <p><label>Description</label><br />
    <textarea name='postContent' cols='60' posts='10'><?php if(isset($post)) { echo $post['postContent']; } ?></textarea></p>

    <p><input type='submit' name='submit' value='<?php if(isset($post)) { echo 'Update'; } else { echo 'Save'; } ?>'></p>
	<?php 
		if($action == 'edit')
			echo "<a href='../posts'> Back </a>";
		else
			echo "<a href='posts'> Back </a>";	
	?>
	

</form>

