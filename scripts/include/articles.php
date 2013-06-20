<?php
	
	if ($_SERVER['SCRIPT_NAME'] == '/pcinsight/index.php')
	{
		require_once('scripts/required/login.php');	
	}
	else
	{
		require_once('../required/login.php');	
		header("Access-Control-Allow-Origin: *");
	}
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
		$writersEmail = $row['writer'];			
		$staffEmailQuery = mysqli_query($db, "SELECT * FROM users WHERE staff = 1");	
		while ($staffrows = mysqli_fetch_array($staffEmailQuery))
		{
			if ($staffrows['email'] == $writersEmail)
			{
				$writer = $staffrows['username'];
			}
		}			
		$articletext = "<p>".strip_tags(MaxWordCount($row['articletext'], 200))."</p>";
		$article = "<div class='article'>";
			$article .= "<div class='innerArticle sponsor'>";
				$article .= '<h3 class="articleHeading"><a href="article.php?articleid='.$row['id'].'">'.$row['title'].'</a></h3>';
				$article .= "<span class='writer'>By <a href='mailto:".$writersEmail."' target='_blank'>".$writer."</a></span>";
				$article .= "<a href='index.php?type=article&id=".$row['id']."'><img src='http://linuxuser.heliohost.org/pcinsight/images/editorsUploader/ASUSM6HTop678x452.jpg' width='100'/></a>";
				$article .= $articletext;	
				$article .= "</div>";			
				$article .= "<div class='tagsHolder'>";
				$exp = explode(',', $row['tags']);	
				if (strlen($row['tags']) > 1)
				{
					if (count($exp) > 0)
					{					
						foreach ($exp as $index)
						{
							$article .="<a href='?tags=$index'>$index</a>";
						}
					}
				}	
				else
				{
					$article .="<a href='?tags=notags'>notags</a>";
				}
			$article .= "</div>";
		$article .= "</div>";
		echo $article;
	}
	echo "</div>";	
	
	function MaxWordCount($text, $length)
	{
		if(strlen($text) > $length) {
			$text = substr($text, 0, strpos($text, ' ', $length));
		}

		return $text;
	}	
?>				