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
				<a id="logout" href="../logout.php">Logout</a>
			</div>
			<div id="TopLeft">
				<ul>
					<li><a href="index.php"> Home </a></li>
					<li><a href="#"> Editors </a>
							<ul class="dropDown">	
								<li><a href="editors.php"> New Article </a></li>
							<li><a href="review.php"> Review Article </a></li>
							</ul>						
					</li>
				</ul>
			</div>
		</div>
		<div id="content">
			<h1> Welcome staff </h1>
			<div id="genralNotifications">
			
			</div>
			<div id="articles">
			
			</div>
		</div>
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