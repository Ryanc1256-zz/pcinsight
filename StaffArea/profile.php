<?php
	session_start();	
	if (!(empty($_SESSION['email'])))
	{		
		if ($_SESSION['staff'] != "1")
		{
			//so hes not a stalf member so why should he be here? 
			//so ill send him to the index page...
			header('location: ../index.php');
		}		
	}
	else
	{
			header('location: ../index.php');
	}
	
	require_once('../scripts/required/login.php');
	$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	$id = $_SESSION['UserID'];
	$accountDetails = mysqli_query($db, "SELECT email, username, userProfile FROM users WHERE UserID=$id");
	while ($row = mysqli_fetch_array($accountDetails))
	{
		$username = $row['username'];
		$email = $row['email'];
		$userProfile = $row['userProfile'];
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title> PC Insight Staff Area</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script src="../js/staffArea.js"></script>
		<script src="../ckeditor/ckeditor.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/staffArea.css" />		
	</head>
	<body>
		<div id="top">
			<div id="TopRight">
				<span id="Notif"></span>
				<ul>
					<li>
						<a id="logout" href="#"><?php echo $_SESSION['email'];?><span class="caret"></span></a>
						<ul	class="dropDown">	
							<li><a href="profile.php"> Edit Profile </a></li>
							<li><a href="../logout.php"> Logout </a></li>
						</ul>						
					</li>
				</ul>
			</div>
			<div id="TopLeft">
				<ul>
					<li><a href="../index.php"> To website </a></li>
					<li><a href="index.php"> Home </a></li>
					<li><a href="#"> Editors <span class="caret"></span></a>
						<ul	class="dropDown">	
							<li><a href="editors.php"> New Article </a></li>
							<li><a href="review.php"> Review Article </a></li>
						</ul>						
					</li>					
				</ul>
			</div>
		</div>
		<div id="content">
			<h1> Welcome staff </h1>
			<span id="error"></span>
			<div id="contentWrapper">
					<div id="changeImg">
						<img src="<?php echo $userProfile; ?>" width="200" height="267"/>
						<span id="hoveruserimg"> Click to change </span>
					</div>
					<div id="infoContent">
						<form>
							<label for="InfoUserName">Username:</label>
							<input type="text" name="username" id="InfoUserName" value="<?php echo $username ?>"/>
							<br />
							<label for="InfoEmail" id="EmailLabelContent">Email:</label>
							<input type="text" name="email" id="InfoEmail" value="<?php echo $email ?>"/>							
						</form>
					</div>
			</div>
		</div>
		<span id="loader"></span>
		<div id="Notifications">
			<div id="NotificationsTop">
				<h3> Notifications </h3>
				<a href="#"> View all Notifications </a>
			</div>
			<ul id="notificationInsert">
				
			</ul>
		</div>
	</body>
</html>