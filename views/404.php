<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="page-login wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php"> 404 </a></li>'."\n";
			$html .= '		</ul>'."\n";
			$html .= '	</div>'."\n";	
			$html .= '<p> 404 </p>'."\n";
			return $html;
		}	
	}
?>