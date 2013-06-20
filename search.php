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
			
			#footer
			{
				text-align: center;
				clear: both;
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
				display: block;
			}	

			.article
			{
				border-bottom: 1px solid rgba(0,0,0,0.25);
			}
			
			#imageWrapper span
			{
				background: rgba(0, 0, 0, 0.6);
				width: 100%;
				height: 80px;
				top: 213px;
				position: absolute;		
				color: #fff;
			}
			
			#imageSlider
			{			
				width: 680px;
				height: 291px;
				padding: 1px;		
				position: relative;
				overflow: hidden;
				margin-bottom: 15px;
			}
			
			.image h2
			{
				margin: 5px 10px;
				padding: 0;
			}
			
			.image p
			{
				margin: 5px 10px;			
			}
			
			#innerWrapper
			{
				width: 1032px;
				margin: 0 auto;
			}
			
			#news, #articles
			{
				float: left;
			}
			
			#news
			{
				text-align: center;
				margin-left: 55px;
				background: #EEE;
				padding: 5px 20px;
			}
			
			#newsHeader
			{
				background: #272727;
				color: #FFF;
			}
			
			#articles
			{
				width: 680px;
			}
			
			h3 a
			{
				color: #1f85bd;
				text-decoration: none
			}
			
			.writer
			{
				font-size: 13px;
				color: #8B8B8B;
				font-weight: 400;
				font-family: 'Arimo', sans-serif;
			}
			
			.writer a
			{
				text-decoration: none;
				color: #2295AB;
			}
			
			.sponsor h3 a
			{
				color: #f25f1e;
				text-decoration: none;
			}
			
			
			#searchHolder
			{
				float: right;
				margin: 10px;
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
			<div id="searchHolder">
				<form action="search.php" method="POST">
					<label for="search">Search</label>
					<input type="text" id="search" />
					<input type="submit" value="search" />
				</form>
			</div>
		</div>
		<h1 id="heading"> Welcome to PC Insight </h1>
		<div id="innerWrapper">
			<div id="articles">			
				<?php
					//search
					echo $_POST['search'];
				?>	
			</div>				
		</div>
		<div id="footer">
			<p> copyright &copy; <?php echo date(Y);?></p>
		</div>
	</body>
</html>