<?php
	session_start();
	if (!(empty($_SESSION['email'])))
	{
		if (!(empty($_SESSION['staff'])))
		{
			//so hes not a stalf member so why should he be here? 
			//so ill send him to the index page...
			header('location: index.php');
		}
		else if ($_SESSION['staff'] == "true")
		{
			header('location: StaffArea/index.php');
		}
	}

?>
<!doctype html>
<html lang="en">
	<head>
		<title> PC insight </title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>	
		<script type="text/javascript" src="js/base.js"></script>		
		<link rel="stylesheet" type="text/css" href="css/login.css" />			 
	</head>
	<body>
		<ul id="navigation">
			<li><a href="index.php"> Home </a></li>
			<li><a href="login.php"> Login </a></li>
		</ul>
		<div id="login">
			<h3> Register </h3>
			<?php 
			if (isset($_GET['error'])) {
			  echo '<div id="error">';
			  echo $_GET['error'];
			  echo '</div>';
			}
			?>
			<form action="scripts/RegisterBackend.php" method="POST">
				<input type="text" name="username" placeholder="Username" <?php if (isset($_GET['username'])) echo "value=\"{$_GET['username']}\"" ?> />
				<input type="text" name="email" placeholder="Email" <?php if (isset($_GET['email'])) echo "value=\"{$_GET['email']}\"" ?>/>
				<input type="password" name="password" placeholder="Password"/>
				<input type="password" name="repassword" placeholder="Redo Password"/>
				<span id="errorMessage"></span>
				<input type="submit" value="Register" />
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