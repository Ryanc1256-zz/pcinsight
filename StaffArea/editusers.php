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
	
	if (isset($_POST['username']))
	{
		if (isset($_POST['email']) && isset($_POST['staff']) && isset($_POST['emailcheck']))
		{
			//hmmm so he must of submitted the edit, maybe we should do something with the data...
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				//his email address is premium :) ...
				
			}
			else
			{
				//emails wrong...
				$emailIsWrong = true;
			}			
		}
	}
	
	require_once('../scripts/required/login.php');
	$db = @mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($con))
	{
		$dbError = true;		
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
					<li><a href="#"> Moderators <span class="caret"></span></a>
						<ul	class="dropDown">	
							<li><a href="users.php"> Users </a></li>
							<li><a href="articles.php"> Articles </a></li>
						</ul>						
					</li>	
				</ul>
			</div>
		</div>
		<div id="content">
			<h1> Welcome Moderators </h1>
			<div id="users">			
				<?php
					if ($dbError == true)
					{
						echo "<div id='NoArticles'>Database connection error...<span id='sadFace'>:(</span></div>";	
						exit;
					}
					
					if ($emailIsWrong == true)
					{
						echo "<div id='NoArticles'>You type in a incorrect email...<span id='sadFace'>:(</span></div>";
					}
					
					if (isset($_GET['userID'])){
					$id = $_GET['userID'];
					$query = mysqli_query($db, "SELECT * FROM users where UserID=$id");						
						while ($row = mysqli_fetch_array($query))
						{
							$username = $row['username'];
							$email = $row['email'];
							$staff = $row['staff'];
							if ($staff == "1")
								$staff = "true";
							else
								$staff = "false";
								
							if ($row['emailCheck'] == "1")
								$emailCheck = "true";
							else
								$emailCheck = "false";
								
							$data = '<form action="#" method="POST" id="edituserForm">';	
								$data .= "<label for='username'>Username</label>";
								$data .= "<input type='text' id='username' name='username' value='".$username."' /><br />";
								$data .= "<label for='email'>Email</label>";
								$data .= "<input type='text' id='email' name='email' value='".$email."' /><br />";
								$data .= "<label for='password'>Change password</label>";
								$data .= "<input type='password' id='password' name='password' /><br />";
								$data .= "<label for='password2'>Confirm password</label>";
								$data .= "<input type='password' id='password2' name='password2' /><br />";
								$data .= "<label for='emailCheck'>Email verified</label>";
								$data .= "<input type='checkbox' id='emailCheck' name='emailcheck' value='t' checked='".$emailCheck."' /><br />";
								$data .= "<label for='staffCheck'>Staff</label>";
								$data .= "<input type='checkbox' id='staffCheck' name='staff' value='t' checked='".$staff."' /><br />";
								$data .= "<button class='button blue'><span class='label'>Submit</span></button><br />";
								$data .= "<a href='#' class='button red'><span class='label'>Delete User</span></a>";
							$data .= '</form>';
							
							echo $data;
						}
						mysqli_close($db);
					}
					else
					{
						echo "<div id='NoArticles'>You selected no users... <span id='sadFace'>:(</span></div>";
					}
				?>			
			</div>
		</div>
		<div id="Notifications">
			<div id="NotificationsTop">
				<h3> Notifications </h3>
				<a href="#"> View all Notifications </a>
			</div>
			<ul id="notificationInsert">
				<!-- javascript will add stuff here -->				
			</ul>
		</div>
	</body>
</html>