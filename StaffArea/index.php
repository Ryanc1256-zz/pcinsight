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
				<?php
					require_once('../scripts/required/login.php');						
					$db = @new mysqli($dbhost,$dbuser,$dbpass,$dbname);
					if (mysqli_connect_errno($db))
					{
						echo "<div id='NoArticles'>Database connection error...<span id='sadFace'>:(</span></div>";	
						exit;
					}
				?>
				<ul>
					<li><a href="../index.php"> To website </a></li>
					<li><a href="index.php"> Home </a></li>
					<li><a href="#"> Editors <span class="caret"></span></a>
						<ul	class="dropDown">	
							<li><a href="editors.php"> New Article </a></li>
							<li><a href="review.php"> Review Article </a></li>
						</ul>						
					</li>
					<?php						
						$id = $_SESSION['UserID'];
						$query = $db->query("SELECT admin FROM users WHERE UserID=$id");	
						$query = $query->fetch_array();
						mysqli_close($db);
						if ($query['admin'] == '1'){
						echo '<li><a href="#"> Moderators <span class="caret"></span></a>
							<ul	class="dropDown">	
								<li><a href="users.php"> Users </a></li>
								<li><a href="articles.php"> Articles </a></li>
							</ul>						
						</li>';
					}
					?>
				</ul>
			</div>
		</div>
		<div id="content">
			<h1> Welcome staff </h1>
			<div id="genralNotifications">
			
			</div>
			<div id="articles">
			
			</div>
			<div id="server">
				<p> Server Load </p>
				<div class="progressBar">
					<?php
						//just the progess bar
						$load = sys_getloadavg();	
						$load = (round($load[0]))."%";
						echo '<div class="progressInner" style="width:'.$load.'"><span>'.$load.'</span></div>';					
					?>
				</div>
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