<?php
	class Page extends view {
		function displayContent(){
			if (!(isset($_GET['post']))){
				header('location: index.php?p=9');
			}
			$html = '<div id="mainContent" class="page-posts wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php?p=1"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php?p=6"> Article </a></li>'."\n";
			$html .= '		</ul>'."\n";
			$html .= '	</div>'."\n";	
			$html .= '	<div class="mainPost">'."\n";
			$html .= $this->getPost();			
			$html .= '	<div class="comments">'."\n";
			$html .= $this->getComments();
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}

		function getPost(){
			$post = $this->model->getPostByID();
			$tags = $this->model->getTags();
			
			$html = '';
			for ($i = 0; $i < count($post); $i++){
				$content = $this->processArticle($post[$i]['postContent']);
				$username = $this->db->getUsersInfo($post[$i]['postWriter']);
				$html .= '<h3>'. $post[$i]['postTitle'] . '</h3>'."\n";
				$html .= '<p> By <span class="bold">' . $username['Username'] .'</span> on ' . $post[$i]['postDate'] .'</p>'."\n";
				$html .= '<div class="tagholder">'."\n";				
				for ($s = 0; $s < count($tags); $s++){
					$html .= '<a href="index.php?p=7&amp;t=tags&amp;q='.$this->removeSpaces($tags[$s]['tagText']).'" class="tags">'. $tags[$s]['tagText'] . '</a>'."\n";
				}
				$html .= '</div>'."\n";
				$html .= $content;				
				
			}
			return $html;
		}
		
		function processArticle($article){
			$article = htmlspecialchars_decode($article);			
			return $article;
		}
		
		function removeSpaces($string){
			if ($string){
				$string = str_replace(' ', '%20', $string);				
			}
			return $string;
		}
		
		function getComments(){
			$comments = $this->model->getComments();
			$html = '<p> Comments </p>'."\n";		
			if ($this->model->isLoggedin() && $this->db->isRegistered()){
				$html .= '<form action="' . htmlentities($_SERVER['REQUEST_URI']) . '" method="post">'."\n";
				$html .= '<textarea name="comment"></textarea>'."\n";
				$html .= '<input type="submit" class="btn blue" name="commentSubmitButton" value="post comment"/>'."\n";			
				$html .= '</form>'."\n";
				$html .= '<hr />'."\n";
			} else {
				$html .= '<p> please login to make a comment <a href="index.php?p=2">Login</a></p>';
			}
		
			for ($i = 0; $i < count($comments); $i++){		
				$username = $this->db->getUsersInfo($comments[$i]['userID']);
				$username = $username['Username'];		
				$html .= '<div class="comment">'."\n";
					$html .= '<p><span class="fromUser">' . $username .'</span> - <span class="date"> ' . $comments[$i]['Date'] .' </span></p>'."\n";
					$html .= '<p>'. $comments[$i]['Comment'].'</p>'."\n";	
				$html .= '</div>'."\n";
			}
			return $html;
		}
		
	}
?>