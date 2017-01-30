<!DOCTYPE html>
<html>
<head>
	<title>Login/Registration</title>
</head>
<body>
	<div id="container">
		<h1 id="welcome">Welcome!</h1>
		<div id="register">
			<form action="/users/register" method="post">
				<h3>Register</h3>
				Name: <input type="text" name="name"><br>
				Alias: <input type="text" name="alias"><br>
				Email: <input type="text" name="email"><br>
				Password: <input type="password" name="password"><br>
				<small>*Passwords must be at least 8 characters</small><br>
				Confirm PW: <input type="password" name="confirm_password"><br>
				Date of Birth: <input type="date" name="dob"><br>
				<input type="submit" value="Register!">
			</form>	
		</div>
		<div id="login">
			<form action="/users/login" method="post">
				<h3>Login</h3>
				Email: <input type="text" name="email"><br>
				Password: <input type="password" name="password"><br>
				<input type="submit" value="Login!">
			</form>
		</div>
<?php 		
			if($this->session->flashdata("errors"))
			{
				echo $this->session->flashdata("errors");
			}
?>
	</div>
</body>
</html>