<?php
	session_start();
?>
<!doctype html>
<html lang="en">
	<head>
		<title> PC Insight</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<style type="text/css">
			html, body
			{
				margin: 0;
				padding: 0;				
			}
			
			#topbar
			{
				background: #646472;
				width: 100%;
				height: 47px;
			}
			
			#topbar ul
			{
				list-style: none;
				padding: 0;
				margin: 12px;
				float: left;
			}
			
			#topbar li
			{
				float: left;
			}
			
			#topbar a
			{
				color: #fff;
				background: rgba(0,0,0,0.25);
				padding: 5px 10px;
				border-radius: 6px;
				-webkit-transition: .1s linear;
				-moz-transition: .1s linear;	
				transition: .1s linear;
				margin: 0 5px;
			}
			
			#topbar a:hover
			{
				background: none;
			}
		
			#articleHolder
			{
				max-width: 900px;
				margin: 0 auto;
			}
			
			#heading
			{
				text-align: center;
			}
			
			blockquote
			{
				font-style: italic;
				font-family: Georgia, Times, "Times New Roman", serif;
				padding: 2px 0;
				border-style: solid;
				border-color: #ccc;
				border-width: 0;
				padding-left: 20px;
				padding-right: 8px;
				border-left-width: 5px;
			}
			
			.writer
			{
				background: #9696E6;
				padding: 5px 10px;
				border-radius: 6px;
				color: #fff;
			}
			
			#footer
			{
				text-align: center;
			}
			
			#tagsHolder a
			{
				color: #3E6D8E;
				background-color: #E0EAF1;
				border-bottom: 1px solid #B3CEE1;
				border-right: 1px solid #B3CEE1;
				padding: 3px 4px 3px 4px;
				margin: 2px 2px 2px 0;
				text-decoration: none;
				font-size: 90%;
				line-height: 2.4;
				white-space: nowrap;
			}
			
			#tagsHolder, .writer 
			{
				display: inline-block;
			}	

			.writer 
			{
				float: right;
			}
			
			.article
			{
				border-bottom: 1px solid rgba(0,0,0,0.25);
			}
		</style>
	</head>
	<body>
		<div id="topbar">
			<ul>
				<li><a href="index.php">Home</a></li>			
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
				<?php 
				if ($_SESSION['email']){
					echo '<li><a href="logout.php">Logout</a></li>';
					if ($_SESSION['staff'] == '1')
					{						
						echo '<li><a href="StaffArea/">Staff Area</a></li>';
					}
				}
				?>					
			</ul>
			
		</div>
		<h1 id="heading"> Welcome to PC Insight </h1>
		<?php
			require_once('scripts/include/articles.php');
		?>	
		<div id="footer">
			<p> copyright &copy; 2013 </p>
		</div>
	</body>
</html>