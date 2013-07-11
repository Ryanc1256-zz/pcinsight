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
				<table>
					<tr>
						<td> Username </td>
						<td> Email </td>
						<td> Staff </td>					
					</tr>
				<?php
					require_once('../scripts/required/login.php');
					$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
					if (mysqli_connect_errno($con))
					{
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}					
					$query = mysqli_query($db, "SELECT * FROM users");						
					while ($row = mysqli_fetch_array($query))
					{
						$username = $row['username'];
						$email = $row['email'];
						$staff = $row['staff'];
						if ($staff == "1")
							$staff = "yes";
						else
							$staff = "No";
						if ($row['emailCheck'] == "1")
							$emailCheck = "yes";
						else
							$emailCheck = "no";
							
						$data = '<tr>';						
							$data .= "<td>".$username."</td>";
							$data .= "<td>".$email."</td>";
							$data .= "<td>".$staff."</td>";
							$data .= "<td>".$emailCheck."</td>";
							$data .= "<td><a href='editusers.php?userID=".$row['UserID']."' class='button'>Edit User</a></td>";
							$data .= "<td><a href='#' class='button red'><span class='label'>Delete Users</span></a></td>";
						$data .= '</tr>';
						
						echo $data;
					}
					mysqli_close($db);
				?>
				</table>
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