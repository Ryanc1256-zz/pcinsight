<?php
	class Page extends view{
		function displayContent(){
			$html = '<div id="mainContent">'."\n";
			$html .= '	<div id="gallery">'."\n";
			$html .= '		<img src="content/uploads/base.jpg" class="current"/>'."\n";
			$html .= '		<img src="content/uploads/bas.jpg"/>'."\n";
			$html .= '	</div>'."\n";
			$html .= '	<div id="postHolder">'."\n";
			$html .= $this->displayPosts();
			$html .= '	</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}

		function displayPosts(){
			//this displays the page and the pagination links
			$rs = $this->db->getAllPosts(); //gets all the posts			
			if ($rs){	
				$pagination = $this->model->pageInation($rs); //pagination stuff...
				$pagInationString = $pagination['page'] ;
				$query = $pagination['query'];
				$num = count($query);
				for ($i = 0; $i < $num; $i++){ //loop through the results and then display the content
					$rs = $query[$i];
					$html .= '		<div class="post clearfix">'."\n";
					$html .= '			<div class="left">'."\n";
					$html .= '				<a href="#"><img src="content/uploads/base.jpg" width="64" height="64" /></a>'."\n";
					$html .= '			</div>'."\n";
					$html .= '			<div class="base">'."\n";
					$html .= '				<h3 class="heading"><a href="index.php?p=6&post='.$rs['postID'].'">'.$rs['postTitle'].'</a></h3>'."\n";
					$html .= '				<p> Test </p>'."\n";
					$html .= '			</div>'."\n";
					$html .= '			<span class="clearfix"></span>'."\n";
					$html .= '		</div>'."\n";		
				}			
				if ($num >= 7){				
					$pagInationString .= $pagination['next'];
				}
				if ($_GET['page'] != 1){				
					$pagInationString = $pagination['prev'] . $pagInationString ;
				}
				$html .= $pagInationString; //display the pageination string... (next and prev buttons)
			}
			return $html;
		}
	}
?>