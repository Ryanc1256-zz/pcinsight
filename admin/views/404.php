<?php
	class Page extends view{
		function displayContent(){
			$html = '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-question"></i>'."\n";
			$html .= '					<h2> Error </h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left">'."\n";
			$html .= '				<div id="innerContent">'."\n";
			$html .= '					<div class="user alert alert-danger alert-info">'."\n";
			$html .= '						<a class="close" data-dismiss="alert" href="#">x</a>'."\n";
			$html .= '						 <strong>404</strong> Error'."\n";
			$html .= '					</div>'."\n";		
			$html .= '				</div>'."\n";		
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}
	}
?>