<?php
	include ('classes/mobileDetect.php');
	class Page extends view{
	
		function displayContent(){			
			$html = '<div id="mainContent">'."\n";
			$html .= '<h2> Technology Articles </h2>'."\n";
			$html .= '	<div id="gallery">'."\n";
			$html .= $this->getSliderImages();
			$html .= '	</div>'."\n";
			$html .= '	<div id="postHolder">'."\n";
			$html .= $this->displayPosts();
			$html .= '	</div>'."\n";			
			return $html;
		}
		
		function getSliderImages(){
			$mobile = new Mobile_Detect();		
			$se = $this->db->getSettings();
			$iV1 = $se['imageViewerPos1']['value'];
			$iV2 = $se['imageViewerPos2']['value'];
			$iV3 = $se['imageViewerPos3']['value'];
			$image1 = $this->db->getImagesByPostID($iV1);
			$image2 = $this->db->getImagesByPostID($iV2);
			$image3 = $this->db->getImagesByPostID($iV3);
			$mobileClass = '';
			$html = '';
			$arrayPath = 'relative';
			if ($mobile->isMobile()){
				$arrayPath = 'mobileRelative';
				$mobileClass = 'mobile';
			}			
			if ($image1){
				$rs = $this->db->getPostByID($iV1);			
				$html .= '<img src="'.$image1[$arrayPath].'" data-mobile="' . $image1['mobileRelative'] . '" data-link="index.php?p=6&amp;post='.$rs[0]['postID'].'" data-text="'.$rs[0]['postTitle'].'" class="current '.$mobileClass.'" alt="The cover image for '.$rs[0]['postTitle'].'"/>';
			}		
			if ($image2){
				$rs = $this->db->getPostByID($iV2);	
				$html .= '<img src="'.$image2[$arrayPath].'" data-mobile="' . $image1['mobileRelative'] . '" data-link="index.php?p=6&amp;post='.$rs[0]['postID'].'" data-text="'.$rs[0]['postTitle'].'" class="'.$mobileClass.'" alt="The cover image for '.$rs[0]['postTitle'].'"/>';
			}
			if ($image3){
				$rs = $this->db->getPostByID($iV3);	
				$html .= '<img src="'.$image3[$arrayPath].'" data-mobile="' . $image1['mobileRelative'] . '" data-link="index.php?p=6&amp;post='.$rs[0]['postID'].'" data-text="'.$rs[0]['postTitle'].'" class="'.$mobileClass.'" alt="The cover image for '.$rs[0]['postTitle'].'"/>';
			}
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
				$html .= '<h2> Articles </h2>'."\n";
				$html .= '<hr />'."\n";
				for ($i = 0; $i < $num; $i++){ //loop through the results and then display the content
					$rs = $query[$i];			
					$images = $rs['images'];							
					$html .= '<div class="post clearfix">'."\n";
					$html .= '<div class="left">'."\n";
					$html .= '<a href="index.php?p=6&amp;post='.$rs['postID'].'"><img src="'.$images['relativeThumb'].'" width="64" height="64" alt="An icon for the article"/></a>'."\n";
					$html .= '</div>'."\n";
					$html .= '<div class="base">'."\n";
					$html .= '<h3 class="heading"><a href="index.php?p=6&amp;post='.$rs['postID'].'">'.$rs['postTitle'].'</a></h3>'."\n";				
					$html .= '</div>'."\n";
					$html .= '<span class="clearfix"></span>'."\n";
					$html .= '</div>'."\n";		
				}			
				if ($num >= 7){				
					$pagInationString .= $pagination['next'];
				}				
				if (count($pagination['query']) > 7){				
					$pagInationString = $pagination['prev'] . $pagInationString ;
				}
				$html .= $pagInationString; //display the pageination string... (next and prev buttons)
			}
			return $html;
		}
	}
?>