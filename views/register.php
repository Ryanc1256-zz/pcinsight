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
			$html .= '	<div class="register-page">'."\n";
			$html .= '		<h2> Register </h2>'."\n";
			$html .= '			<p class="bold">Already have an account? </p><a href="index.php?p=2"> Click here </a>'."\n";
			$html .= '		<hr />'."\n";
			$html .= '		<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" id="registerForm">'."\n";
			$html .= '			<label for="Username-register"> Username </label>'."\n";
			$html .= '			<input type="text" name="username" id="Username-register" placeholder="Username" value="'.$_POST['username'].'"/>'."\n";
			$html .= '			<label for="email-register"> Email </label>'."\n";
			$html .= '			<input type="text" name="email" id="email-register" placeholder="Email" value="'.$_POST['email'].'"/>'."\n";
			$html .= '			<label for="password-register"> Password </label>'."\n";
			$html .= '			<input type="password" name="password" id="password-register" placeholder="Password"/>'."\n";
			$html .= '			<label for="re-password-register"> Repeat Password </label>'."\n";
			$html .= '			<input type="password" name="repeat-password" id="re-password-register" placeholder="Repeat Password"/>'."\n";			
			$html .= '			<div class="captcha">'."\n";			
			$html .= $this->captcha();
			$html .= '			</div>'."\n";
			$html .= '			<div class="buttons">'."\n";
			$html .= '				<button class="btn red small" name="registerButton"> register </button>'."\n";
			$html .= '			</div>'."\n";
			if (isset($_POST['error'])){
				$html .= '		<span class="alert alert-danger">' . $_POST['error'] .'</span>'."\n";
			}
			$html .= '		</form>'."\n";
			$html .= '	</div>'."\n";
			return $html;
		}	
		
		function captcha(){
			require_once('lib/recaptchalib.php');			
			return recaptcha_get_html(CAPTCHA_PU);			
		}
	}
?>