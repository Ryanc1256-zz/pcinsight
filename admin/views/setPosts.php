<?php
	class Page extends view{
		function displayContent(){
			$this->model->updateSetPosts();
			$html = '<div class="mainContent">'."\n";
			$html .= '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-question"></i>'."\n";
			$html .= '					<h2> Edit postition </h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left page-allPosts">'."\n";
			$html .= '				<div id="innerContent">'."\n";
			$html .= '					<div class="user alert alert-dismissable alert-info">'."\n";
			$html .= '						<a class="close" data-dismiss="alert" href="#">x</a>'."\n";
			$html .= '						 This page is for setting what posts go on the home page....'."\n";
			$html .= '					</div>'."\n";
			$html .= '					<table class="listPosts">'."\n";
			$html .= '					<tr><td>Title</td><td>set #1</td><td> Set #2 </td><td> Set #3 </td></tr>'."\n";
			$html .=			 $this->posts();
			$html .= '					</table>'."\n";		
			$html .= '				</div>'."\n";		
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}
		
		
		function posts(){
			//this figures out what elements are checked...
			$res = $this->db->getAllPosts();
			$req = $this->db->getSettings();
			
			$pos1 = $req['imageViewerPos1']['value'];
			$pos2 = $req['imageViewerPos2']['value'];
			$pos3 = $req['imageViewerPos3']['value'];
			
					
			$amount = count($res);						
			for ($i = 0; $i < $amount; $i++){
				$result = $res[$i];	
				$re1 = '';
				$re2 = '';
				$re3 = '';
				if ($pos1 == $result['postID']){
					$re1 = 'selected';
				} if ($pos2 == $result['postID']){
					$re2 = 'selected';
				} if ($pos3 == $result['postID']){
					$re3 = 'selected';
				}
							
				$list .= '<tr class="post"><td>' . $result['postTitle'] .'</td><td><a href="index.php?p=7&amp;pos=1&amp;setID='.$result['postID'].'" class="btn red '.$re1.'">Set</a></td><td><a href="index.php?p=7&amp;pos=2&amp;setID='.$result['postID'].'" class="btn red '.$re2.'">Set</a></td><td><a href="index.php?p=7&amp;pos=3&amp;setID='.$result['postID'].'" class="btn red '.$re3.'">Set</a></tr>'."\n";
			}
			return $list;
		}
	}		
?>