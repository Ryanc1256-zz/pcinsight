<?php
	class Page extends view{
		function displayContent(){
			$html = '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-question"></i>'."\n";
			$html .= '					<h2> Posts </h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left page-allPosts">'."\n";
			$html .= '				<div id="innerContent">'."\n";
			$html .= '					<table class="listPosts">'."\n";
			$html .= '					<tr><td>Writer</td><td>Title</td><td>date</td><td> Accepted </td><td> Edit </td></tr>'."\n";
			$html .=			 $this->posts();
			$html .= '					</table>'."\n";		
			$html .= '				</div>'."\n";		
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}
		
		
		function posts(){
			$res = $this->db->getAllPosts();
			$amount = count($res);	
			$list = '';			
			for ($i = 0; $i < $amount; $i++){
				$result = $res[$i];						
				$writer = $this->db->getUsersInfo($result['postWriter']);
				$conf = $result['postConfirmed'] == true ? 'checked' : ''; 
				$list .= '<tr class="post"><td>' . $writer['Username'] . '</td><td>' . $result['postTitle'] .'</td><td>' . $result['postDate'] . '</td><td><input type="checkbox" '.$conf.' /></td><td><a href="index.php?p=6&id='.$result['postID'].'" class="btn red">Edit</a></tr>'."\n";
			}
			return $list;
		}
	}
?>