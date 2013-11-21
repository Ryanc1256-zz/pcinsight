<?php
	abstract class view {
		public $db;	
		public $model;
		
		public function __construct(){			
			include ('classes/model.php');		
			$this->model = new model();
			$this->db = $this->model->db;
		}
		
		abstract function displayContent();
		private function displayHeader(){
			//this function will display the header of the page...	
			$html = '<!doctype html>'."\n";
			$html .= '<html>'."\n";
			$html .= '<title> Admin </title>'."\n";				
			$html .= '<link rel="stylesheet/less" type="text/css" href="resources/css/main.less" />'."\n";
			$html .= '<link rel="stylesheet" type="text/css" href="resources/css/font-awesome.css" />'."\n";
			$html .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>'."\n";
			$html .= '<script src="resources/js/less.min.js"></script>'."\n";
			$html .= '<script src="resources/flot/flot.min.js"></script>'."\n";
			$html .= '<script src="resources/js/base.js"></script>'."\n";
			$html .= '<!--[if lt IE 9]>'."\n";
			$html .= '<script src="resources/flot/excanvas.min.js"></script>'."\n";
			$html .= '<![endif]-->'."\n";
			$html .= '</head>'."\n";
			$html .= '<body>'."\n";
			$html .= '<nav id="top">'."\n";
			$html .= '<div id="rightcontrols">'."\n";
			$html .= '<div id="search">'."\n";
			$html .= '<form class="navbar-form">'."\n";
			$html .= '<div class="form-group">'."\n";
			$html .= '<input type="text" placeholder="Search..." />'."\n";
			$html .= '</div>'."\n";
			$html .= '</form>'."\n";
			$html .= '</div>'."\n";
			$html .= '<div id="notifications">'."\n";
			$html .= '<span class="icon notifications"></span>'."\n";
			$html .= '<span class="badge">5</span>'."\n";
			$html .= '<div class="notificationbar">'."\n";					
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '<div id="person">'."\n";
			$html .= '<div class="profilePic dark">'."\n";
			$html .= '<img src="userfiles/rsz_chrysanthemum-32.jpg" />'."\n";
			$html .= '<span> username </span>'."\n";
			$html .= '<span class="caret"></span>'."\n";				
			$html .= '</div>'."\n";
			$html .= '<ul class="dropdown"> '."\n";
			$html .= '<li>'."\n";
			$html .= '<a href="#" class="noUnderLine">'."\n";
			$html .= '<img src="userfiles/rsz_chrysanthemum.jpg" />'."\n";
			$html .= '<span> Username </span>'."\n";
			$html .= '</a>'."\n";
			$html .= '</li>'."\n";
			$html .= '<li>'."\n";
			$html .= '<a href="#"> Edit My Profile </a>'."\n";						
			$html .= '</li> '."\n";
			$html .= '<li>'."\n";
			$html .= '<a href="#"> Log Out </a>	'."\n";				
			$html .= '<li> '."\n";
			$html .= '</ul>'."\n";
			$html .= '</div>'."\n";			
			$html .= '</div>'."\n";
			$html .= '<a href="../" class="btn red backToWEb float left">'."\n";
			$html .= 'Go back to the site'."\n";
			$html .= '</a>'."\n";
			$html .= '<div class="menu menu-expand toggle btn">'."\n";
			$html .= '<i class="icon-reorder"></i> '."\n";
			$html .= '</div>'."\n";
			$html .= '</nav>'."\n";
			$html .= '<div id="mainContent">'."\n";
			$html .= '	<div id="contentWrapper">'."\n";
			$html .= '			<div id="leftNav">'."\n";
			$html .= '				<ul>'."\n";
			$html .= '					<li>'."\n";
			$html .= '						<a href="index.php?p=1"><i class="icon-dashboard"></i>'."\n";
			$html .= '						<span> Dashboard </span></a>'."\n";
			$html .= '					</li>'."\n";
			$html .= '					<li>'."\n";			
			$html .= '						<a href="index.php?p=2"><i class="icon-pushpin"></i>'."\n";
			$html .= '						<span>'."\n";
			$html .= '							Post\'s'."\n";
			$html .= '							<i class="icon-angle-down angle-down icon-right"></i>'."\n";
			$html .= '						</span></span>'."\n";
			$html .= '						<ul class="submenu">'."\n";
			$html .= '							<li>'."\n";
			$html .= '								<a href="index.php?p=2"> All posts </a>'."\n";
			$html .= '							</li>'."\n";
			$html .= '							<li>'."\n";
			$html .= '								<a href="index.php?p=3"> Add New </a>'."\n";
			$html .= '							</li>'."\n";
			$html .= '						</ul>'."\n";
			$html .= '					</li>'."\n";
			$html .= '					<li>'."\n";
			$html .= '						<a href="index.php?p=4"><i class="icon-group"></i>'."\n";
			$html .= '						<span>'."\n";
			$html .= '							Users'."\n";
			$html .= '							<i class="icon-angle-down angle-down icon-right"></i>'."\n";
			$html .= '						</span></a>'."\n";
			$html .= '						<ul class="submenu">'."\n";
			$html .= '							<li>'."\n";
			$html .= '								<a href="index.php?p=4"> All users </a>'."\n";
			$html .= '							</li>'."\n";		
			$html .= '						</ul>'."\n";
			$html .= '					</li>'."\n";
			$html .= '			</ul>'."\n";
			$html .= '		</div>'."\n";			
			return $html;
		}
		
		private function displayFooter(){
			//this function will display the footer of the page...			
			$html .= '</body>'."\n";		
			$html .= '</html>'."\n";
			return $html;
		}
		
		public function displayPage(){
			$html = $this->displayHeader();
			$html .= $this->displayContent();
			$html .= $this->displayFooter();
			echo $html;
		}	
	}
?>