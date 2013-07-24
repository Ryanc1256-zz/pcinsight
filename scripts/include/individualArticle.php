<?php	
	require_once('scripts/required/login.php');
	$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}	

	
	$id = $_GET['articleid'];
	if (isset($_POST['commentSubmit']))
	{
		//add comment to db...
		if ($_POST['comment'])
		{
			$comment = $_POST['comment'];
			$userID = $_SESSION['UserID'];	
			$qry = "INSERT INTO comments (articleID, message, userID) VALUES ('$id', '$comment', '$userID')";
			$db->query($qry) or die($db->error);
		}	
	}
	

	if (count($id) > 0){
	$query = $db->query("SELECT * FROM Articles WHERE id=$id");	
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
			$message = $row['articletext'];	
			$article = "<div class='article'>";
				$article .= "<div class='innerArticle sponsor'>";
					$article .= '<h3 class="articleHeading"><a href="article.php?articleid='.$row['id'].'">'.$row['title'].'</a></h3>';
					$article .= "<span class='writer'>By <a href='mailto:".$writersEmail."' target='_blank'>".$writer."</a></span>";					
					$article .= $message;	
					$article .= "</div>";			
					$article .= "<div id='tagsHolder' class='tagsHolder'>";
					$exp = explode(',', $row['tags']);	
					if (strlen($row['tags']) > 1)
					{
						if (count($exp) > 0)
						{					
							foreach ($exp as $index)
							{
								$article .="<a href='index.php?tags=$index'>$index</a>";
							}
						}
					}	
					else
					{
						$article .="<a href='index.php?tags=notags'>notags</a>";
					}
				$article .= "</div>";
			$article .= "</div>";
			echo $article;
		}
		//comment section...
		if (isset($_SESSION['email']))
		{
			//well hes logged in and add a comment	
			$html = "<script type='text/javascript' src='ckeditor/ckeditor.js'></script>";
			$html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">';
				$html .= '<textarea name="comment" class="ckeditor"></textarea>';
				$html .= '<input type="submit" name="commentSubmit"/>';
			$html .= '</form>';
			echo $html;
		}
		//display comments
		$commentHTML = '<div id="comments">';
			$CommentQuery = $db->query("SELECT * FROM comments WHERE articleID = $id ORDER BY commentID DESC");
			while ($row = $CommentQuery->fetch_array())
			{
				$username = $db->query('SELECT username FROM users WHERE UserID='.$row['userID']);
				$username = $username->fetch_array()[0]; //gets the username So for example 'Ryan Clough'
				$commentHTML .= '<div class="comment">';
					$commentHTML .= '<p>'.$username.'</p>';
					$commentHTML .= $row['message'];	
				$commentHTML .= '<div class="comment">';
			}		
		$commentHTML .= '</div';
		echo $commentHTML."</div>";
		
	}
?>				