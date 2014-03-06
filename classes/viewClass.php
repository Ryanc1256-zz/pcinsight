<?php
	abstract class view {
		public $db;	
		public $model;
		public $pageInfo;
		
		public function __construct(){			
			include ('classes/model.php');		
			$this->model = new model();
			$this->db = $this->model->db;
			$this->pageInfo = $this->model->pageInfo();		
		}
		
		abstract function displayContent();
		private function displayHeader(){
			//this function will display the header of the page...				
			$html = '<!doctype html>'."\n";
			$html .= '<!--[if LT IE 9]>'."\n";
			$html .= '<html class="ie">'."\n";
			$html .= '<![endIF]-->'."\n";
			$html .= '<!--[if !IE]><!-->'."\n";
			$html .= '<html>'."\n";
			$html .= '<!--<![endif]-->'."\n";
			$html .= '<head>'."\n";
			$html .= '<title> PCInsight | ' .$this->pageInfo['pageTitle'].'</title>'."\n";
			$html .= '<link rel="stylesheet" type="text/css" href="scripts/loadCSS.php" />'."\n";
			$html .= '<link rel="shortcut icon" type="image/png" href="resources/images/favicon.png" />'."\n";
			$html .= '<link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />'."\n";
			$html .= '<meta charset="UTF-8" />'."\n";
			$html .= '<meta name="description" content="'.$this->pageInfo['pageDescription'].'" />'."\n";
			$html .= '<script src="resources/lib/jquery-1.10.2.min.js" type="text/javascript"></script>'."\n";
			$html .= '<script src="resources/js/main.js" type="text/javascript"></script>'."\n";
			$html .= '</head>'."\n";
			$html .= '<body class="nojs">'."\n";
			$html .= '<div id="topbar" class="clearfix">'."\n";
			$html .= '<div class="wrapper">'."\n";
			$html .= '<div class="left">'."\n";
			$html .= '<h1 class="mainHeader"><a href="index.php"><span> PC</span>insight </a></h1>'."\n";
			$html .= '<nav>'."\n";
			$html .= '<ul>'."\n";
			$html .= '<li><a href="index.php" accesskey="1"> Home </a></li>'."\n";
			$html .= '<li><a href="index.php?p=9" accesskey="2"> Articles </a></li>'."\n";		
			$html .= '<li><a href="index.php?p=10" accesskey="3"> About </a></li>'."\n";
			$html .= '</ul>'."\n";
			$html .= '</nav>'."\n";
			$html .= '</div>'."\n";
			$html .= '<div class="mobilenav">'."\n";
			$html .= '<span class="mobileNavBu"></span>'."\n";
			$html .= '<div class="menu">'."\n";
			$html .= '<ul>'."\n";
			$html .= '<li><a href="index.php"> Home </a></li>'."\n"; 
			$html .= '<li><a href="index.php?p=9"> Articles </a></li>'."\n"; 			
			$html .= '<li><a href="index.php?p=10"> About </a></li>'."\n";
			if (!(isset($_SESSION['username']))){
				$html .= '<li><a href="index.php?p=2" accesskey="4"> Login </a></li>'."\n";
				$html .= '<li><a href="index.php?p=3" accesskey="5"> Register </a></li>'."\n";
			} else {
				if ($this->model->isAdmin()){
					$html .= '<li><a href="admin/"> Admin </a></li>'."\n";
				}
				$html .= '<li><a href="index.php?p=5" accesskey="6"> Logout </a></li>'."\n";
			}
			$html .= '</ul>'."\n";
			$html .= '<form action="index.php" method="get">'."\n";
			$html .= '<input type="hidden" name="p" value="7"/>'."\n";
			$html .= '<input type="text" class="search" placeholder="Search" name="q" value="'.$_GET['q'].'"/>'."\n";
			$html .= '<input type="submit" class="btn blue small" value="search"/>'."\n";
			$html .= '</form>'."\n";			
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '<div class="right">'."\n";
			if (!(isset($_SESSION['username']))){
				$html .= '<div class="login">'."\n";
				$html .= '<a href="index.php?p=2"> Login </a>'."\n";
				$html .= '<a href="index.php?p=3"> Register </a>'."\n";
				$html .= '</div>'."\n";
			} else {
				$html .= '<div class="login">'."\n";
				$html .= '<a href="index.php?p=5"> Logout </a>'."\n";
				if ($this->model->isAdmin()){
					$html .= '<a href="admin/"> Admin </a>'."\n";
				}
				$html .= '</div>'."\n";
			}
			$html .= '<div class="search">'."\n";
			$html .= '<form action="index.php" method="get">'."\n"; 
			$html .= '<input type="hidden" name="p" value="7"/>'."\n";
			$html .= '<input type="text" class="search" placeholder="Search" name="q" value="'.$_GET['q'].'"/>'."\n";
			$html .= '<input type="submit" class="btn blue small" value="Search" />'."\n";
			$html .= '</form>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			if (!$this->db->isRegistered()){
				$html .= '<div class="register"><p> Please register your account <a href="index.php?p=13">here</a></p></div>';
			}
			return $html;
		}
		
		private function displayFooter(){
			//this function will display the footer of the page...			
			$html = '</div>'."\n"; //closing main container div
			$html .= '<div id="footer">'."\n";
			$html .= '<div class="wrapper">'."\n";
			$html .= '<div class="left">'."\n";
			$html .= '<h3> Links </h3>'."\n";
			$html .= '<ul>'."\n";
			$html .= '<li><a href="index.php">Home</a></li>'."\n";
			$html .= '<li><a href="index.php?p=10">About</a></li>'."\n";
			$html .= '<li><a href="index.php?p=9">Articles</a></li>'."\n";					
			$html .= '<li><a href="feed/">Rss</a></li>'."\n";
			$html .= '<li><a href="index.php?p=14" accesskey="4">Accessibility</a></li>'."\n";
			$html .= '<li><a href="index.php?p=15" accesskey="5">Sitemap</a></li>'."\n";
			$html .= '</ul>'."\n";
			$html .= '</div>'."\n";			
			$html .= '<div class="right">'."\n";
			$html .= '<h3> Follow </h3>'."\n";
			$html .= '<ul>'."\n";
			$html .= '<li><a href="http://facebook.com" target="_blank">Facebook</a></li>'."\n";
			$html .= '<li><a href="http://twitter.com"  target="_blank">Twitter</a></li>'."\n";
			$html .= '<li><a href="feed/">Rss</a></li>'."\n";
			$html .= '</ul>'."\n";
			$html .= '</div>'."\n";
			$html .= '<p class="copyright">Copyright &copy; '.COPY_RIGHT. ' '. Date('Y').'</p>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
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