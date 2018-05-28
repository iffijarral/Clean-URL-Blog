<?php
	
	/*
	* Author: Iftikhar Ahmed
	* 
	* Date: 25/05/2018
	*
	* @desc: This class is a middle layer and performs different operations with the help of Database class. This class is called or required in front layer or pages
	*
	* @required: database.php. This class deals directly with database to fetch and send data. It represents third layer.
	*
	* @methods: getPost(), getPosts(), updatePost(), savePost(), deletePost(), logIn(), logOut() .
	
	*/
	
	require_once('database.php');	

class Operations{
	
	private $objDB; // Database class object 
	
	// Constructor 
	public function __construct() {
		
		$this->objDB = new Database();	// Object instantiation of Database class. 
	
	}	
	
	/*
	* Name: getPosts()
	*
	* @desc: This function doesn't take any parameter, but it sends two parameters to getRows() database class method. First parameter is an empty array...
			 which means there is no condition and fetch all available posts. The second parameter is the database table name.
	*		 
	* Parameters: NULL
	* 			  
	* Returns: This function returns an array of all available posts.	
	*/	
	public function getPosts() {
		
		return $this->objDB->getRows(array(''),'posts');
				
	}
	
	/*
	* Name: getPost()
	*
	* @desc: It gets postId as parameter and returns information of that specific post.
	*
	* Parameters: postId
	*
	* Returns: This function returns info of given postId.	
	*/
	
	public function getPost($id) {
		return $this->objDB->getRows(array('id'=>$id),'posts');	
	}
	
	/*
	* Name: updatePost()
	*
	* @desc: This function updates post of given postId. It takes two parameters an array of fields to be updated and postId. It calls updateRow method of database... 
	*        class and passes 3 parameters, 1.array of fields to update 2. postId 3. database table name. Depending on return value, redirects to respective page.
	*
	* Parameters: Array of postFields and postId
	*
	* Returns: It returns true on successful operation and false otherwise.	
	*/
	
	public function updatePost($postData, $id) {
		
		if($this->objDB->updateRow($postData, $id, 'posts')) 				
			header("Location: ../posts.php");				
		else
			header("Location: editPost.php?msg=Record couldn't be updated&&id=".$id);
	}
	
	/*
	* Name: savePost()
	*
	* @desc: This function saves new post. It takes an array of fields and returns true after successful operation otherwise false. It calls saveRow method of database... 
	*        class and passes 2 parameters, 1.array of fields 2. database table name. Depending on return value, redirects to respective page.
	*
	* Parameters: Array of postFields
	*
	* Returns: It returns true on successful operation and false otherwise.	
	*/
	
	public function savePost($postData) {
		
		if($this->objDB->saveRow($postData,'posts')) 				
			header("Location: posts.php");				
		else
			header("Location: editPost.php?msg=Record couldn't be saved");
	}
	
	
	/*
	* Name: deletePost()
	*
	* @desc: This function deletes post of given postId. It takes postId as parameter and calls deleteRow method of database class.
	*	     Depending on return value, redirects to respective page.
	*
	* Parameters: postId
	*
	* Returns: It returns true on successful operation and false otherwise.	
	*/
	
	public function deletePost($id) {
		
		if($this->objDB->deleteRow($id, 'posts')) 
			header("Location: ../posts.php");	
		else
			header("Location: ../posts.php?msg=Record couldn't be updated");
		
	}
	
	/*
	* Name: logIn()
	*
	* @desc: This function calls getRow method of database class to authenticate given user. Its takes two parameters 'username' and 'password' and passes them... 
	*        ... to getRow method. And if there is valid user, then it sets session variables and redirects to respective page. If the user is not valid ...
	*		 ... it redires to login page with an error message.
 	*
	* Parameters: 'username' and 'password'
	*
	* Returns: Redirects to respective pages depending on the result it receives.	
	*/
	
	public function logIn($username, $password) {
		
		$con['conditions'] = array(
						
			'email' => $username,
		
			//'password' => md5($this->input->post('password')),
			'password' => $password					
								
		);
		
		$checkLogin = $this->objDB->getRows($con, 'users');
		
		if($checkLogin) {
			
			$_SESSION['isLoggedIn'] = true;
		
			$_SESSION['username'] = $username;	
			
			header("Location: posts"); //By sending to posts page saves alot of processing and time otherwise we could also send it back to index and it will go to posts page after all above checks.
		} else {
			
			header("Location: adminLogin.php?error=true");
		}
	}
	
	/*
	* Name: logOut()
	*
	* @desc: This function logs the user out, unsets the session variables and destroys the session.	
	*
	* Parameters: NULL
	*
	* Returns: Nothing
	*/
	
	public function logOut() {
		unset($_SESSION['isLoggedIn']);
		unset($_SESSION['username']);
		session_destroy();
		header("Location: ../");
	}
}

