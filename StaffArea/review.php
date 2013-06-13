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
			<?php
				require_once('../scripts/required/login.php');
				$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
				if (mysqli_connect_errno($con))
			   {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
			   }
				if (empty($_GET['reviewid']))
				{					//so he hasn't clicked on a article to review... hmmm... okay...
					
				   $query = mysqli_query($db, "SELECT * FROM Articles WHERE editorsTick=0");
					while ($row = mysqli_fetch_array($query))
					{
						$click = "<a class='article' href='?reviewid=".$row['id']."'>";
							$click .= $row['articletext'];
							$click .= "<span class='writer'>".$row['writer']."</span>";
						$click .= "</a>";
						echo $click;
					}
				}
				else
				{
				   $id = $_GET['reviewid'];
				   $query = mysqli_query($db, "SELECT * FROM Articles WHERE id=$id");
				   while ($row = mysqli_fetch_array($query))
					{
						$click = "<div class='article'>";
							$click .= $row['articletext'];
							$click .= "<span class='writer'>".$row['writer']."</span>";
						$click .= "</div>";
						echo $click;
					}
				}
			?>
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