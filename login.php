<!doctype html>
<html lang="en">
	<head>
		<title> PC insight </title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script src="https://apis.google.com/js/plusone.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/base.js"></script>		
		<link rel="stylesheet" type="text/css" href="css/base.css" />			 
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
			<span id="signinButton">
				  <span
					class="g-signin"
					data-callback="loginFinishedCallback"
					data-approvalprompt="force"
					data-clientid="498017223743.apps.googleusercontent.com"
					data-cookiepolicy="single_host_origin"
					data-requestvisibleactions="http://schemas.google.com/AddActivity"
					data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email">
				  </span>
			</span>
		</div>	
		<div id="footer">
			<ul>
				<li><a href="#">About</a></li>
				<li><a href="#">Copyright</a></li>
			</ul>
			<p> Copyright &copy; 2013 </p>
		</div>
		 <script src="https://apis.google.com/js/client.js"></script>
	</body>
</html>