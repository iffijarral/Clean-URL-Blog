<?php 
	
	/*
	* Author: Iftikhar Ahmed
	* 
	* Date: 25/05/2018
	*
	* @desc: This page shows available Posts along with edit and delete options.
	*
	* @required: operations.php.
	*	
	*/
	
	require_once('../operations.php');
	
	$objOpr = new Operations();
	
	if(!isset($_SESSION['isLoggedIn'])){
		
		header("Location: login");
        
    } 
	
	$posts = $objOpr->getPosts();

?>
<table>
<tr>
    <th>Title</th>
    <th>Date</th>
    <th>Action</th>
</tr>
<?php
    
	if(isset($posts)) {
		
		foreach($posts as $post) {
	
			echo "<tr>";
				echo "<td>".$post['postSubject']."</td>";
				echo "<td>".date('jS M Y', strtotime($post['postCreated']))."</td>";				
				echo "<td>";
				echo "<a href='edit/". $post['id']."'>Edit</a> | ";
				echo "<a href='delete/". $post['id']."'>Delete</a>";
				echo "</td>";
		
			echo "</tr>";

		}   	
		
	} else {
		
		echo "<tr>";
		echo "<td colspan='3' style='text-align: center'> No Record Available</td>";
		echo "</tr>";
	}
?>	
	<tr>
		<td colspan='3'>
			<a href="create">Create New</a> | <a href="logout">logOut</a> 
		</td>
	</tr>
	
</table>