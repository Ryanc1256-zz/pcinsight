<?php
	session_start();
	require_once('scripts/required/login.php');
	$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	if ($db->connect_error)
	{
		echo "Failed to connect to MySQL: ";
	}	
	
	if (isset($_GET['activate']))
	{
		//we hes trying to activate his account...			
		$querystring = "UPDATE users SET emailCheck=1 WHERE idGen='".$_GET['activate']."'";
		$query = $db->query($querystring) or die($db->error);
		header('location: index.php'); //just reloads the page.
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title> PC Insight</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script src="js/base.js"></script>
		<link rel="stylesheet" href="css/base.css" type="text/css"/>
		<link rel="stylesheet" href="css/print.css" type="text/css" media="print"/>
		<!-- Hello, love to see your looking at my source code -->
	</head>
	<body>
		<?php	
			unset($userquery);
			if (isset($_SESSION['UserID'])){
				$userid = $_SESSION['UserID'];	
				$query = "SELECT emailCheck FROM users WHERE UserID=1";	
				$userquery = $db->query($query) or die($db->error);		
				$result = $userquery->fetch_array();
				if ($result['emailCheck'] == '0'){
					echo '<div id="emailConfirm">
						<p> Please confirm your email address... Didnt get a email? click <a href="scripts/resendmail.php">here</a></p>
					</div>';
				}
			}
		?>
		<div id="topbar">
			<ul>
				<li><a href="index.php">Home</a></li>			
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
				<?php 
				if (isset($_SESSION['email'])){
					echo '<li><a href="logout.php">Logout</a></li>';
					if ($_SESSION['staff'] == '1')
					{						
						echo '<li><a href="StaffArea/">Staff Area</a></li>';
					}
				}
				?>					
			</ul>			
			<div id="searchHolder">
				<form action="search.php" method="POST">
					<label for="search">Search</label>
					<input type="text" name="search" id="search" placeholder="Search"/>
					<input type="submit" value="search" class="button"/>
				</form>
			</div>
		</div>
		<div id="topbarMobile">
			<ul>
				<li><a href="index.php">Home</a></li>			
				<li><a href="login.php">Articles</a></li>
				<li><a href="register.php">Articles</a></li>								
			</ul>
		</div>
		<h1 id="heading"> Welcome to PC Insight </h1>
		<div id="innerWrapper">
			<div id="articles">
				<div id="imageSlider">
					<div id="imageWrapper">
						<div class="image">
							<img src="http://images.anandtech.com/doci/6963/DSC02077_678x452.JPG" />
							<span>
								<h2>BenQ XL2720T Gaming Monitor Reviewed</h2>
								<p> Ryan Clough </p>
							</span>
						</div>
					</div>
					<div id="Controls">
					
					</div>			
				</div>
				<?php
					require_once('scripts/include/articles.php');
				?>	
			</div>
			<div id="news">
				<div id="newsHeader">
					<h2> News </h2>
				</div>
				<div id="newsHolder">
					<div class="news">
						<p> Battlefield 4 has been revealed! </p>
					</div>
				</div>
			</div>			
		</div>
		<div id="footer">
			<p> copyright &copy; <?php echo date('Y');?></p>
		</div>
	</body>
</html>