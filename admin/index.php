<?php 
				
	require_once('../operations.php');	
	
	if(!isset($_SESSION['isLoggedIn'])) { 
		
		header("Location: getLogin");		
		
	} else {
		
		header("Location: posts");
	}
	
	