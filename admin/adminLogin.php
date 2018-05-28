
<form action="login" method="post">
<input type='hidden' name='action' value='login'>
<p><label>Username</label><input type="text" name="email" value=""  /></p>
<p><label>Password</label><input type="password" name="password" value=""  /></p>
<p><label></label><input type="submit" name="submit" value="Login"  /></p>

<?php 
	if(isset($_GET['error'])) {
		echo "<p> Wrong username or Password </p>";
	}
?>
</form>
