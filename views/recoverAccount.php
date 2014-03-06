<?php
	class Page extends view {
		function displayContent(){	
			if (isset($_GET['id'])){
				$html = '<div id="mainContent" class="page-login wrapper">'."\n";
				$html .= '	<div class="breadcrumbs">'."\n";
				$html .= '		<ul>'."\n";
				$html .= '			<li><a href="index.php"> Home</a> <span class="seperator">&gt;</span></li>'."\n";
				$html .= '			<li><a href="index.php?p=12"> Recover account </a></li>'."\n";
				$html .= '		</ul>'."\n";
				$html .= '	</div>'."\n";
				$html .= '	<div class="recover">'."\n";
				$html .= '		<h2> Recover Password</h2>'."\n";
				$html .= '		<hr />'."\n";
				$html .= '		<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">'."\n";
				$html .= '			<label for="password-recover"> password </label>'."\n";
				$html .= '			<input type="password" name="password" id="password-recover" placeholder="Password"/>'."\n";
				$html .= '			<label for="repassword-recover"> re password </label>'."\n";
				$html .= '			<input type="password" name="repassword" id="repassword-recover" placeholder="Re-Password"/>'."\n";
				$html .= '			<button class="btn red small" name="recoverPasswordButton"> Submit </button>'."\n";
				if (isset($_POST['error'])){
					$html .= '		<span class="alert alert-danger">' . $_POST['error'] .'</span>'."\n";
				}
				$html .= '		</form>'."\n";
				$html .= '	</div>'."\n";				
			} else {
				header('location: index.php');
			}
			return $html;
			
		}	
	}
?>