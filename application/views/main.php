<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Registration</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>	

		<style type="text/css">
		*{
			font-family: sans-serif;
		}
		.login{
			padding: 20px;
			margin: 20px;
			width: 400px;
			border: 1px solid black;
		}
		.register{
			padding: 20px;
			margin: 20px;
			width: 400px;			
			border: 1px solid black;
		}
		.button{
			border: 1px solid black;
			background-color: white;
			padding: 3px;
			margin-left: 200px;
		}
		</style>
	</head>
	<body>
		<div class="container">

		<?php 
			  if($this->session->flashdata("errors")) 
			  {
			    echo $this->session->flashdata("errors");
			  }
		?>
			<div class="login">
				<h2>Log In</h2>
				<form action="logins/login" method="post">
					<p>Email: <input type="text" name="login_email"></input></p>
					<p>Password: <input type="password" name="password"></input></p>
					<p><input class="button" type="submit" name="submit" value="Submit"></input></p>
				</form>
			</div>	
			<div class="register">
				<h2>Register</h2>
				<form action="/logins/create" method="post">
					<p>Name: <input type="text" name="name"></input></p>
					<p>Alias: <input type="text" name="alias"></input></p>
					<p>Email: <input type="text" name="email"></input></p>
					<p>Password: <input type="password" name="password"></input></p>
					<p>Confirm Password: <input type="password" name="confirm_password"></input></p>
					<p>Date of Birth: 
					<input type="date" name="birthday"></input></p>
					<p><input class="button" type="submit" name="submit" value="Register"></input></p>
				</form>
			</div>

		</div>
	</body>
</html>