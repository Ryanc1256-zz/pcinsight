<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="wrapper page-about">'."\n";	
			$html .= '<h2> About us </h2>'."\n";
			$html .= '<hr />'."\n";
			$html .= $this->getPageContent();
		return $html;
		}
		
		function getPageContent(){
			$rs = $this->model->getAboutArticle();
			$html = htmlspecialchars_decode($rs['pageContent']);
			return $html;
		}
	}
?>