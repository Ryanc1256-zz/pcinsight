<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="page-login wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php?p=15"> Sitemap </a></li>'."\n";
			$html .= '		</ul>'."\n";
			$html .= '	</div>'."\n";	
			$html .= '<h2> Sitemap </h2>'."\n";
			$html .= '<p> Bellow are all the links for all the viewable page on '.NICE_SITENAME.'</p>'."\n";
			$html .= '<ul>'."\n";
				$html .= '<li><a href="index.php"> Home </a></li>'."\n";
				$html .= '<li><a href="index.php?p=2"> Login </a></li>'."\n";
				$html .= '<li><a href="index.php?p=3"> Register </a></li>'."\n";
				$html .= '<li><a href="index.php?p=4"> Recover your account </a></li>'."\n";
				$html .= '<li><a href="index.php?p=7"> Search Articles </a></li>'."\n";
				$html .= '<li><a href="index.php?p=9"> Articles </a></li>'."\n";
			$html .= '</ul>'."\n";
			return $html;
		}	
	}
?>