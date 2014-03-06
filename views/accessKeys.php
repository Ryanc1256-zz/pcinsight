<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="page-login wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php?p=14"> Access keys </a></li>'."\n";
			$html .= '		</ul>'."\n";
			$html .= '	</div>'."\n";	
			$html .= '<h2> Access keys </h2>'."\n";
			$html .= '<p> You can use '.NICE_SITENAME.' with the following access keys instead of a mouse. </p>'."\n";
			$html .= '<ul>'."\n";
			$html .= '<li> 1 navigates to the home page</li>'."\n";
			$html .= '<li> 2 navigates to the Articles page</li>'."\n";
			$html .= '<li> 3 navigates to the About page</li>'."\n";
			$html .= '<li> 4 navigates to the accessibility page</li>'."\n";
			$html .= '<li> 5 navigates to the sitemap</li>'."\n";
			$html .= '</ul>'."\n";
			return $html;
		}	
	}
?>