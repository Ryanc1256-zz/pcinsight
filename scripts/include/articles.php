<?php
	
	if (!str_endsWith($_SERVER['SCRIPT_NAME'], '/index.php'))
	{
		exit;
		//hmmm somethings going on... 
	}
	
	
	$id = isset($_GET['reviewid']);
	$query = $db->query("SELECT * FROM Articles WHERE editorsTick=1 ORDER BY id DESC");
	
	echo '<div id="articleHolder">';
	while ($row = $query->fetch_array())
	{	
		$writersEmail = $row['writer'];
		$email = mysqli_real_escape_string($db, $writersEmail);
		$staffEmailQuery = $db->query("SELECT username FROM users WHERE email='$email'") or die('error');	
		while ($staffrows = $staffEmailQuery->fetch_array())
		{
			$writer = $staffrows['username'];
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