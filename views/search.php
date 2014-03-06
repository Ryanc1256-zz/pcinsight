<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="wrapper search">'."\n";
				$html .= '<h3> Search </h3><div class="float right"><form action="index.php" method="get"><input type="text" name="q" placeholder="search" value="' . $_GET['q'] . '"/><input type="hidden" name="p" value="7" /></form></div>'."\n";
				$html .=' <hr />'."\n";
				$html .=' <div class="searchRes">'."\n";
				$html .= $this->searchPosts();
				$html .= '</div>'."\n";
			$html .=' </div>'."\n";				
			return $html;
		}

		function searchPosts(){
			$query = $_GET['q'];
			if ($_GET['t'] == 'tags'){
				//this will get the tags....
				$rs = $this->db->searchTags($_GET['q']);
				if ($rs){
					$html = '';
					$num = count($rs);
					for ($i = 0; $i < $num; $i++){						
						$res = $rs[$i];					
						$html .= '<div class="search result">'."\n";
						$html .= '<div class="left">'."\n";
						$html .= '<p> Title: <a href="index.php?p=6&amp;post='.$res['tagArticle'][0]['postID'].'">'.$res['tagArticle'][0]['postTitle'].'</a></p>'."\n";					
						$html .= '</div>'."\n";					
						$html .= '</div>'."\n";
					}				
				}
			} else if ($query){
				$rs = $this->db->getSearchRes($query);
				if ($rs){
					$num = count($rs);
					$html = '';
					for ($i = 0; $i < $num; $i++){
						$res = $rs[$i];
						$writer = $this->db->getUsersInfo($res['postWriter']);
						$html .= '<div class="search result">'."\n";
						$html .= '<div class="left">'."\n";
						$html .= '<p> Title: <a href="index.php?p=6&amp;post='.$res['postID'].'">'.$res['postTitle'].'</a></p>'."\n";					
						$html .= '</div>'."\n";
						$html .= '<div class="writer">'."\n";
						$html .= '<p> writer: '.$writer['Username'].' </p>'."\n";
						$html .= '</div>'."\n";
						$html .= '</div>'."\n";
					}
				} else {
					$html .= '<div class="search result noRes">'."\n";
						$html .= '<p> No results </p>'."\n";
					$html . '</div>'."\n";
				}				
			} else {
				$html .= '<div class="search result noRes">'."\n";
					$html .= '<p> No results </p>'."\n";
				$html . '</div>'."\n";
			}
			return $html;
		}
	}
?>