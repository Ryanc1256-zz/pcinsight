<?php
	class Page extends view {
		function displayContent(){	
			$this->db->sendActivationEmail();
			$html = '<div id="mainContent" class="page-login wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php"> Activate Account </a></li>'."\n";
			$html .= '		</ul>'."\n";
			$html .= '	</div>'."\n";
			$html .= '	<div class="recover">'."\n";			
			$html .= '		<p> We have just sent you an email to activate your account, please follow the instructions on the email </p>'."\n";			
			$html .= '	</div>'."\n";
			return $html;
		}	
	}
?>