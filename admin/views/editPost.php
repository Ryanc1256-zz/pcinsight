<?php
	class Page extends view{
		function displayContent(){
			$rs = $this->model->getPostByID();					
			$html = '	<div class="mainContent">'."\n";
			$html .= '			<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-file  red"></i>'."\n";
			$html .= '					<h2> Edit a Post</h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper">'."\n";
			$html .= '				<div id="innerContent" class="posts page content page-newArticle">'."\n";
			$html .= '					<div class="user alert alert-dismissable alert-info">'."\n";
			$html .= '						<a class="close" data-dismiss="alert" href="#">x</a>'."\n";
			$html .= '						If you want to put a date in or it will get submited to queue Instantly'."\n";
			$html .= '					</div>'."\n";
			$html .= '					<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" id="EditArticlePOST">'."\n";			
			$html .= '						<label for="tileForm"> Name </label>'."\n";
			$html .= '						<input type="text" name="title" id="tileForm" value="'.$rs['postTitle'].'"/>'."\n";
			$html .= '						<textarea id="ckeditor">'.$rs['postContent'].'</textarea>'."\n";
			$html .= '						<div id="tagsHolder">'."\n";
			$html .= '							<p> Tags </p>'."\n";
			$html .= '							<div class="tagsHolder">'."\n";
				$html .= '							<span class="tagsEnclosure">'."\n";
				$html .= $this->getTags();
				$html .= '							</span>'."\n";
				$html .= '							<input type="text" id="tags" />'."\n";
			$html .= '							</div>'."\n";
			$html .= '						</div>'."\n";
			$html .= '						<div id="submitDate">'."\n";
			$html .= '							<p> What date do you want to submit it? </p>'."\n";
			$html .= '							<input type="text" id="calender" value="'.$rs['postDate'].'"/>'."\n";
			$html .= '						</div>'."\n";
			$html .= '						<a href="index.php?p=7&id='.$_GET['id'].'" class="btn red"> Delete Article </a>'."\n";
			$html .= '						<input type="submit" name="reviewSubmitEdit" class="btn red" value="submit Edit">'."\n";
			$html .= '					</form>'."\n";
			$html .= '				</div>'."\n";		
			$html .= '				<span class="line break block clearfix"></span>'."\n";
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";			
			$html .= '</div>'."\n";			
			$html .= '<script src="resources/ckeditor/ckeditor.js"></script>'."\n";
			$html .= '<script src="resources/ckeditor/adapters/jquery.js"></script>'."\n";
			$html .= '<script src="resources/js/tags.js"></script>'."\n";
			$html .= '<script src="resources/js/calender.js"></script>'."\n";
			$html .= '<script>$("#ckeditor").ckeditor();</script>'."\n";
			return $html;
		}
		
		function getTags(){
			$id = $_GET['id'];
			$id = strip_tags(stripslashes($id));
			$rs = $this->db->getTags($id);
			$html = '';		
			if ($rs){
				for ($i = 0; $i < count($rs); $i++){
					$html .= '<span class="tags">' . $rs[$i]['tagText'] . '</span>';
				}			
			}
			return $html;
		
		}
		
		
	}
?>