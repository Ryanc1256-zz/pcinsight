<?php
	class Page extends view{
		function displayContent(){	
			$html = '<div class="mainContent">'."\n";
			$html .= '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-file  red"></i>'."\n";
			$html .= '					<h2> Create a post</h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left">'."\n";
			$html .= '				<div id="innerContent" class="posts page content page-newArticle">'."\n";
			$html .= '					<div class="user alert alert-dismissable alert-info">'."\n";
			$html .= '						<a class="close" data-dismiss="alert" href="#">x</a>'."\n";
			$html .= '						If you want to put a date in or it will get submited to queue Instantly'."\n";
			$html .= '					</div>'."\n";
			$html .= '					<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" id="ArticlePOST">'."\n";			
			$html .= '						<label for="tileForm"> Name </label>'."\n";
			$html .= '						<input type="text" name="title" id="tileForm" />'."\n";
			$html .= '						<textarea id="ckeditor"></textarea>'."\n";
			$html .= '						<div id="tagsHolder">'."\n";
			$html .= '							<p> Tags </p>'."\n";
			$html .= '							<div class="tagsHolder">'."\n";
				$html .= '							<span class="tagsEnclosure"></span>'."\n";
				$html .= '							<input type="text" id="tags" />'."\n";
			$html .= '							</div>'."\n";
			$html .= '						</div>'."\n";
			$html .= '						<div id="submitDate">'."\n";
			$html .= '							<p> What date do you want to submit it? </p>'."\n";
			$html .= '							<input type="text" id="calender" />'."\n";
			$html .= '						</div>'."\n";
			$html .= '						<input type="submit" name="reviewSubmit" class="btn red" value="submit review">'."\n";
			$html .= '					</form>'."\n";
			$html .= '				</div>'."\n";		
			$html .= '				<span class="line break block clearfix"></span>'."\n";
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";			
			$html .= '</div>'."\n";			
			$html .= '</div>'."\n";			
			$html .= '<script src="resources/ckeditor/ckeditor.js"></script>'."\n";
			$html .= '<script src="resources/ckeditor/adapters/jquery.js"></script>'."\n";
			$html .= '<script src="resources/js/tags.js"></script>'."\n";
			$html .= '<script src="resources/js/calender.js"></script>'."\n";
			$html .= '<script>$("#ckeditor").ckeditor();</script>'."\n";
			return $html;
		}
	}
?>