<?php
	require_once('scripts/required/login.php');
	$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}		
	$id = $_GET['reviewid'];
	$query = mysqli_query($db, "SELECT * FROM Articles WHERE editorsTick=1 ORDER BY id DESC");	
	echo '<div id="articleHolder">';
	
	while ($row = mysqli_fetch_array($query))
	{	
		$article = "<div class='article'>";
			$article .= "<div class='innerArticle'>";
				$article .= $row['articletext'];	
				$article .= "</div>";			
				$article .= "<div id='tagsHolder'>";
				$exp = explode(',', $row['tags']);						
				foreach ($exp as $index)
				{
					$article .="<a href='?tags=$index'>$index</a>";
				}
				$article .= "</div>";
			$writersEmail = $row['writer'];			
			$staffEmailQuery = mysqli_query($db, "SELECT * FROM users WHERE staff = 1");	
			while ($staffrows = mysqli_fetch_array($staffEmailQuery))
			{
				if ($staffrows['email'] == $writersEmail)
				{
					$writer = $staffrows['username'];
				}
			}			
			$article .= "<span class='writer'>Writer: ".$writer."</span>";
		$article .= "</div>";
		echo $article;
	}
	echo "</div>";		
?>				