<!doctype html>
<html lang="en">
	<head>
		<title> PC insight </title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>		
		<script type="text/javascript" src="js/base.js"></script>		
		<link rel="stylesheet" type="text/css" href="css/login.css" />			 
	</head>
	<body>
		<a href="index.php" id="nav"> Home </a>
		<div id="login">
			<h3> Login </h3>
			<form action="login.php" method="POST">
				<input type="text" name="email" placeholder="Email"/>
				<input type="password" name="password" placeholder="Password"/>
				<input type="submit" value="Login" />
				<a href="register.php" id="register"> Register </a>
				<span id="loader"></span>
			</form>				
		</div>	
		<div id="footer">
			<ul>
				<li><a href="#">About</a></li>
				<li><a href="#">Copyright</a></li>
			</ul>
			<p> Copyright &copy; 2013 </p>
		</div>		
	</body>
</html>