<?php
	
	/*
	* Author: Iftikhar Ahmed
	* 
	* Date: 25/05/2018
	*
	* @desc: This page shows available Posts.
	*
	* @required: operations.php. This is a business class which performds different opoerations with or without Database class like to fetch and send data to database. It also has some other functions.
	*
	
	*/
	
	require_once('operations.php');		
	
	$objOpr = new Operations();
	
	$path_info = getPath(); // getPath() is the key function in this project. It parses the url and returns array which contains path info.

	
	$path = $path_info['call_parts'][0]; 
	
	switch($path) {		
	
		case 'blog':
	
			if(isset($path_info['call_parts'][1])) {				
				viewPost($path_info['call_parts'][1]);
			} else
				include('posts.php');
		break;	
		
		case 'admin':
		
			switch($path_info['call_parts'][1]) {
				
				case 'getLogin':
					include("admin/adminLogin.php");
				break;
				
				case 'login':
										
					$username = trim($_POST['email']);

					$password = trim($_POST['password']);
					
					$objOpr->logIn($username, $password);
					
				break;
				
				case 'edit':															
					
					if(isset($path_info['call_parts'][2]) && $path_info['call_parts'][2] ==='edit') { // It is when user makes some changes and clicks update button to update.
						
						$postId	  = $_POST['id'];
					
						$postData = array(
					
							'postSubject' => strip_tags($_POST['postSubject']),
					
							'postContent' => strip_tags($_POST['postContent']),								 
									
						);
						
						$objOpr->updatePost($postData, $postId);
						
					} else						
						include("admin/editPost.php");		
																		
				break;
				
				case 'create':
					// When user clicks create new link to open create new page					 
					include("admin/editPost.php"); // editPost.php handles both cases, edit and create new															
					
				break;
				
				case 'save':
				
					$postData = array(
		
						'postSubject' => strip_tags($_POST['postSubject']),
				
						'postContent' => strip_tags($_POST['postContent']),

						'postCreated' => date("Y-m-d H:i:s")	
								
					);
					
					$objOpr->savePost($postData);
								
				break;
				
				case 'delete':
					
					$id = $path_info['call_parts'][2];
					
					$objOpr->deletePost($id);
				break;
				
				case 'logout':															
					
					$objOpr->logOut();
										
				break;
				
				default:
					
				break;
			}
			
		break;				
		
		default:
			if(isset($_SESSION['isLoggedIn'])){
		
				header("Location: posts.php");
				
			} 
			echo "<h1>Welcome to Jarral's blog</h1> <a href='blog'>Click here </a> to view posts";
		break;
	} 
	
	
	
	
	function getPath() {
	  $path = array();
	  if (isset($_SERVER['REQUEST_URI'])) {
		$request_path = explode('?', $_SERVER['REQUEST_URI']);

		$path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
		$path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
		$path['call'] = utf8_decode($path['call_utf8']);
		if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
		  $path['call'] = '';
		}
		$path['call_parts'] = explode('/', $path['call']);
		if(isset($request_path[1])) {
			$path['query_utf8'] = urldecode($request_path[1]);
			$path['query'] = utf8_decode(urldecode($request_path[1]));	
			$vars = explode('&', $path['query']);
			foreach ($vars as $var) {
			  $t = explode('=', $var);
			  $path['query_vars'][$t[0]] = $t[1];
			}
		}
		
		
	  }
	return $path;
	} 
	
	function viewPost($postId) {
		
		$objOpr = new Operations();
		
		$posts = $objOpr->getPost($postId);
	
		if($posts) {
			
			$post = $posts[0];
		
			echo '<div>';
				echo '<h1>'.$post['postSubject'].'</h1>';
				echo '<p>Posted on '.date('jS M Y', strtotime($post['postCreated'])).'</p>';
				echo '<p>'.$post['postContent'].'</p>';                
			echo '</div>';
			echo "<a href='../blog'>Back</a>";
		} else {
			
			include('404.html');
		}
		
	}