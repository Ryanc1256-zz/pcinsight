<?php
	class Page extends view {
		function displayContent(){
			$html = '<div id="mainContent" class="page-posts wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php?p=1"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php?p=6"> Posts </a></li>'."\n";
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
				$username = $this->db->getUsersInfo($post[$i]['postWriter']);
				$html .= '<h3>'. $post[$i]['postTitle'] . '</h3>'."\n";
				$html .= '<p> By <span class="bold"><a href="#">' . $username['Username'] .'</a></span> on ' . $post[$i]['postDate'] .'</p>'."\n";
				$html .= '<div class="tagholder">'."\n";				
				for ($s = 0; $s < count($tags); $s++){
					$html .= '<span class="tags">'. $tags[$s]['tagText'] . '</span>'."\n";
				}
				$html .= '</div>'."\n";
				$html .= $post[$i]['postContent'];					
				$html .= '</div>'."\n";
			}
			return $html;
		}
		
		function getComments(){
			$comments = $this->model->getComments();
			$html = '<p> Comments </p>'."\n";		
			if ($this->model->isLoggedin()){
				$html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">'."\n";
				$html .= '<textarea name="comment"></textarea>'."\n";
				$html .= '<input type="submit" class="btn blue" name="commentSubmitButton" />'."\n";			
				$html .= '</form>'."\n";
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