<?php
	class Page extends view {
		function displayContent(){	
			$this->activateAccount();
			$html = '<div id="mainContent" class="wrapper page-about">'."\n";	
				$html .= '<h2> Register Account </h2>'."\n";
				$html .= '<hr />'."\n";
				$html .= '<p> Thank you for registering your account </p>'."\n";				
			return $html;
		}
		
		function activateAccount(){
			if ($this->model->checkActivation()){			
				header('location: index.php');
			}
		
		}
	}
?>