<?php
	class Page extends view {
		function displayContent(){
			$html = '<div id="mainContent" class="page-login wrapper">'."\n";
			$html .= '<div class="breadcrumbs">'."\n";
			$html .= '<ul>'."\n";
			$html .= '<li><a href="index.php?p=1"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
			$html .= '<li><a href="index.php?p=2"> Login </a></li>'."\n";
			$html .= '</ul>'."\n";
			$html .= '</div>'."\n";
			$html .= '<div class="login">'."\n";
			$html .= '<h2> Login </h2>'."\n";
			$html .= '<p class="bold"> Don\'t have an account yet? </p><a href="index.php?p=3"> Click here </a>'."\n";
			$html .= '<hr />'."\n";
			$html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">'."\n";
			$html .= '<label for="email-login"> Email </label>'."\n";
			$html .= '<input type="text" name="email" id="email-login" placeholder="Email" value="'.$_POST['email'].'"/>'."\n";
			$html .= '<label for="password-login"> Password </label>'."\n";
			$html .= '<input type="password" name="password" id="password-login" placeholder="Password"/>'."\n";
			$html .= '<div class="buttons">'."\n";
			$html .= '<button class="btn red small" name="loginButton"> Login </button>'."\n";
			$html .= '<a href="index.php?p=4"> Lost your password? click here</a>'."\n";
			$html .= '</div>'."\n";
			if (isset($_POST['error'])){
				$html .= '		<span class="alert alert-danger">' . $_POST['error'] .'</span>'."\n";
			}				
			$html .= '</form>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}	
	}
?>