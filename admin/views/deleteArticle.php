<?php
	class Page extends view{
		function displayContent(){
			$html = '	<div class="mainContent">'."\n";
			$html .= '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-question"></i>'."\n";
			$html .= '					<h2> Are you sure? </h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left">'."\n";
			$html .= '				<div id="innerContent">'."\n";
			$html .= '				<p> Are you sure you want to delete this article? </p>'."\n";
			$html .= '				<form action="'.$_SERVER['REQUEST_URI'].'" method="post">'."\n";
			$html .= '					<input type="hidden" name="id" value="' . $_GET['id'] .'" />'."\n";
			$html .= '					<input type="submit" class="btn" name="falseDownload" value="no"/>'."\n";
			$html .= '					<input type="submit" class="btn red" name="deleteSubmit" value="yes"/>'."\n";
			$html .= '				</form>'."\n";
			$html .= '				</div>'."\n";		
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}
	}
?>