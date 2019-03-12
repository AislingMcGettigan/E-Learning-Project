<!-- include the session page -->
<?php include('session.php') ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
		<!-- include the websites style sheet -->
		<link rel="stylesheet" type="text/css" href="styleSheet.css">
	</head>
	<body>
		<div class="header">
			<h2>Login Page</h2>
		</div>
		
		<form method="post" action="Login.php">
			<!-- include the error loop which will output any issues with the users login attempt -->
			<?php include('errorLoop.php'); ?>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" >
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password">
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="loginUser">Login</button>
			</div>
			<p>
				<!-- link for the user to go to the Reg page instead -->
				Not yet a member? <a href="Registration.php">Sign up</a>
			</p>
		</form>
	</body>
</html>