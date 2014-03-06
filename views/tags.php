<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="wrapper search">'."\n";
				$html .= '<h3> Search </h3><div class="float right"><form action="' .$_SERVER['REQUEST_URI']. '" method="post"><input type="text" name="q" placeholder="search"/></form></div>'."\n";
				$html .=' <hr />'."\n";				
				$html .= $this->getTags();							
			return $html;
		}

		function getTags(){			
				//this will get the tags....
				$rs = $this->db->getAllTags();
				if ($rs){				
					$html = '';
					$num = count($rs);
					for ($i = 0; $i < $num; $i++){						
						$res = $rs[$i];	
						$tags = $this->db->getTags($res['tagArticle'][0]['postID']);
						$html .= '<div class="search result">'."\n";
						$html .= '<div class="left">'."\n";
						$html .= '<p> Title: <a href="index.php?p=6&amp;post='.$res['tagArticle'][0]['postID'].'">'.$res['tagArticle'][0]['postTitle'].'</a></p>'."\n";					
						$html .= '<div class="tagholder">'."\n";
						for ($s = 0; $s < count($tags); $s++){							
							$html .= '<a href="index.php?p=7&amp;t=tags&amp;q=' . $tags[$s]['tagText'] . '" class="tags">' . $tags[$s]['tagText'] . '</a>';
						}
						$html .= '</div>'."\n";					
						$html .= '</div>'."\n";					
						$html .= '</div>'."\n";
					}
					return $html;
				}
		}
	}
?>