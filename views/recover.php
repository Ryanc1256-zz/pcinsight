<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="page-login wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php?p=4"> Recover </a></li>'."\n";
			$html .= '		</ul>'."\n";
			$html .= '	</div>'."\n";
			$html .= '	<div class="recover">'."\n";
			$html .= '		<h2> Recover </h2>'."\n";
			$html .= '		<hr />'."\n";
			$html .= '		<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">'."\n";
			$html .= '			<label for="email-recover"> Email </label>'."\n";
			$html .= '			<input type="text" name="email" id="email-recover" placeholder="Email"/>'."\n";
			$html .= '			<button class="btn red small" name="recoverButton"> Submit </button>'."\n";
			$html .= '		</form>'."\n";
			$html .= '	</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}	
	}
?>