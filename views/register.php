<?php
	class Page extends view {
		function displayContent(){	
			$html = '<div id="mainContent" class="page-login wrapper">'."\n";
			$html .= '	<div class="breadcrumbs">'."\n";
			$html .= '		<ul>'."\n";
			$html .= '			<li><a href="index.php"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '			<li><a href="index.php?p=3"> Register </a></li>'."\n";
			$html .= '		</ul>'."\n";
			$html .= '	</div>'."\n";
			$html .= '	<div class="login">'."\n";
			$html .= '		<h2> Register </h2>'."\n";
			$html .= '			<p class="bold">Already have an account? </p><a href="index.php?p=2"> Click here </a>'."\n";
			$html .= '		<hr />'."\n";
			$html .= '		<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">'."\n";
			$html .= '			<label for="Username-register"> Username </label>'."\n";
			$html .= '			<input type="text" name="username" id="Username-register" placeholder="Username"/>'."\n";
			$html .= '			<label for="email-register"> Email </label>'."\n";
			$html .= '			<input type="text" name="email" id="email-register" placeholder="Email"/>'."\n";
			$html .= '			<label for="password-register"> Password </label>'."\n";
			$html .= '			<input type="password" name="password" id="password-register" placeholder="Password"/>'."\n";
			$html .= '			<label for="re-password-register"> Repeat Password </label>'."\n";
			$html .= '			<input type="password" name="repeat-password" id="re-password-register" placeholder="Repeat Password"/>'."\n";
			$html .= '			<label>'.$_POST['error'].'</label>'."\n";
			$html .= '			<div class="captcha">'."\n";			
			$html .= ' 				<p> catcha </p>'."\n";		
			$html .= '			</div>'."\n";
			$html .= '			<div class="buttons">'."\n";
			$html .= '				<button class="btn red small" name="registerButton"> register </button>'."\n";
			$html .= '			</div>'."\n";
			$html .= '		</form>'."\n";
			$html .= '	</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}	
	}
?>