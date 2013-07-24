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
		<link rel="stylesheet" type="text/css" href="../ckeditor/contents.css" />
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
					<li><a href="../index.php"> To website. </a></li>
					<li><a href="index.php"> Home </a></li>
					<li><a href="#"> Editors <span class="caret"></span></a>
						<ul	class="dropDown">	
							<li><a href="editors.php"> New Article </a></li>
							<li><a href="review.php"> Review Article </a></li>
						</ul>						
					</li>	
					<?php
						require_once('../scripts/required/login.php');
						$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
						if (mysqli_connect_errno($con))
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
						}
						$id = $_SESSION['UserID'];
						$query = mysqli_query($db, "SELECT admin FROM users WHERE UserID=$id");	
						$query = mysqli_fetch_array($query);
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
			<span id="error"></span>
			<?php
				require_once('../scripts/required/login.php');
				$db = @mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
				if (mysqli_connect_errno($db))
				{
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				if (empty($_GET['reviewid']))
				{					//so he hasn't clicked on a article to review... hmmm... okay...
					
				   $query = mysqli_query($db, "SELECT * FROM Articles WHERE editorsTick=0");
				   $num = mysqli_num_rows($query);
				   if ($num < 1)
				   {
						echo "<div id='NoArticles'>There are no articles for you to review yet <span id='sadFace'>:(</span></div>";
				   }
					while ($row = mysqli_fetch_array($query))
					{
						$click = "<a class='article' href='?reviewid=".$row['id']."'>";
							$click .= '<h3>'. $row['title'] . '</h3>';
							$click .=  urldecode($row['articletext']);
							$click .= "<span class='writer'>".$row['writer']."</span>";
						$click .= "</a>";
						echo $click;
					}
				}
				else
				{
				   $id = $_GET['reviewid'];
				   $query = mysqli_query($db, "SELECT * FROM Articles WHERE id=$id");	
				   echo '<div id="acticleHolder">';
				
				   while ($row = mysqli_fetch_array($query))
					{
						$message = urldecode($row['articletext']);
						$click = '<h3 contenteditable="true" id="editorsTitle">'. $row['title'] . '</h3>';
						$click .= "<div class='article' id='editor' contenteditable='true'>";
						$click .= $message;							
						$click .= "</div>";
						$click .= "<div id='tagsHolder'>";
						$exp = explode(',', $row['tags']);	
						if (strlen($row['tags']) > 1)
						{
							if (count($exp) > 0)
							{					
								foreach ($exp as $index)
								{
									$click .="<div>$index<span class='TagClose'>x</span></div>";
								}
							}
						}
						else
						{							
							$click .="<span id='NoTag'>No Tags</span>";
						}
						$click .= "</div>";
						$click .= "<div class='writer'>";
						$click .= "<p>".$row['writer']."</p>";
						$click .= "</div>";
						echo $click;
					}
					
				echo '<button id="reviewSubmit">Submit</button></div>';
				}
			?>
			
		</div>
		<script type="text/javascript">
			CKEDITOR.disableAutoInline = false;
			CKEDITOR.inline(document.getElementById('editor'));
			CKEDITOR.inline(document.getElementById('editorsTitle'));
		</script>
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