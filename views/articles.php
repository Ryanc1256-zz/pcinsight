<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="wrapper search">'."\n";	
				$html .= '<h2> Articles </h2>'."\n";
				$html .= $this->getArticles();				
			return $html;
		}
		
		function getArticles(){
			$rs = $this->db->getAllPosts();
			if ($rs){
				$num = count($rs);
				$html = '';
				for ($i = 0; $i < $num; $i++){
					$res = $rs[$i];	
					$tags = $this->db->getTags($res['postID']);
					$html .= '<div class="search result">'."\n";
					$html .= '<div class="left">'."\n";
					$html .= '<p> Title: <a href="index.php?p=6&amp;post='.$res['postID'].'">'.$res['postTitle'].'</a></p>'."\n";					
					$html .= '<div class="tagholder">'."\n";
					for ($s = 0; $s < count($tags); $s++){							
						$html .= '<a href="index.php?p=7&amp;t=tags&amp;q=' . $this->removeSpaces($tags[$s]['tagText']) . '" class="tags">' . $tags[$s]['tagText'] . '</a>';
					}
					$html .= '</div>'."\n";					
					$html .= '</div>'."\n";					
					$html .= '</div>'."\n";
				}
				return $html;
			}
		
		}
		
		function removeSpaces($string){
			if ($string){
				$string = str_replace(' ', '%20', $string);				
			}
			return $string;
		}
	}
?>