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
			$html .= '	<head>'."\n";
			$html .= '		<title>' .$this->pageInfo['pageTitle'].'</title>'."\n";
			$html .= '		<link rel="stylesheet" type="text/css" href="scripts/loadCSS.php" />'."\n";
			$html .= '		<meta name="description" content="A description" />'."\n";
			$html .= '		<script src="resources/lib/jquery-1.10.2.min.js" type="text/javascript"></script>'."\n";
			$html .= '		<script src="resources/js/main.js" type="text/javascript"></script>'."\n";
			$html .= '	</head>'."\n";
			$html .= '	<body class="nojs">'."\n";
			$html .= '		<div id="topbar" class="clearfix">'."\n";
			$html .= '			<div class="wrapper">'."\n";
			$html .= '				<div class="left">'."\n";
			$html .= '					<h1 class="mainHeader"> <span> PC</span>insight </h1>'."\n";
			$html .= '					<nav>'."\n";
			$html .= '						<ul>'."\n";
			$html .= '							<li><a href="index.php"> Home </a></li>'."\n";
			$html .= '							<li><a href="#"> Reviews </a></li>'."\n";
			$html .= '							<li><a href="#"> Tags </a></li>'."\n";
			$html .= '							<li><a href="#"> About </a></li>'."\n";
			$html .= '						</ul>'."\n";
			$html .= '					</nav>'."\n";
			$html .= '				</div>'."\n";
			$html .= '				<div class="right">'."\n";
			if (!(isset($_SESSION['username']))){
				$html .= '					<div class="login">'."\n";
				$html .= '						<a href="index.php?p=2"> Login </a>'."\n";
				$html .= '						<a href="index.php?p=3"> Register </a>'."\n";
				$html .= '					</div>'."\n";
			} else {
				$html .= '					<div class="login">'."\n";
				$html .= '						<a href="index.php?p=5"> Logout </a>'."\n";
				if ($this->model->isAdmin()){
					$html .= '<a href="admin/"> Admin </a>'."\n";
				}
				$html .= '					</div>'."\n";
			}
			$html .= '					<div class="search">'."\n";
			$html .= '						<form action="index.php?p=7" method="post">'."\n";
			$html .= '							<input type="text" class="search" placeholder="Search" name="q"/>'."\n";
			$html .= '							<a href="#" class="btn blue small"> Search </a>'."\n";
			$html .= '						</form>'."\n";
			$html .= '					</div>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '		</div>'."\n";
			if (!$this->db->isRegistered()){
				$html .= '<div class="register"><p> Please register your account <a href="#">here</a></p></div>';
			}
			return $html;
		}
		
		private function displayFooter(){
			//this function will display the footer of the page...			
			$html = '		</div>'."\n"; //closing main container div
			$html .= '		<div id="footer">'."\n";
			$html .= '			<div class="wrapper">'."\n";
			$html .= '				<div class="left">'."\n";
			$html .= '					<h3> Links </h3>'."\n";
			$html .= '					<ul>'."\n";
			$html .= '						<li><a href="#">Home</a></li>'."\n";
			$html .= '						<li><a href="#">About</a></li>'."\n";
			$html .= '						<li><a href="#">Articles</a></li>'."\n";
			$html .= '						<li><a href="#">Tags</a></li>'."\n";
			$html .= '						<li><a href="#">Reviews</a></li>'."\n";
			$html .= '						<li><a href="#">Rss</a></li>'."\n";
			$html .= '					</ul>'."\n";
			$html .= '				</div>'."\n";
			$html .= '				<div class="middle">'."\n";
			$html .= '					<h3> Topics </h3>'."\n";
			$html .= '					<ul>'."\n";
			$html .= '						<li><a href="#">CPUS</a></li>'."\n";
			$html .= '						<li><a href="#">Motherboard</a></li>'."\n";
			$html .= '						<li><a href="#">HDD/SDD</a></li>'."\n";
			$html .= '						<li><a href="#">Mobile</a></li>'."\n";
			$html .= '						<li><a href="#">IT/Datacenter</a></li>'."\n";
			$html .= '						<li><a href="#">Memory</a></li>'."\n";
			$html .= '					</ul>'."\n";
			$html .= '				</div>'."\n";
			$html .= '				<div class="right">'."\n";
			$html .= '					<h3> Follow </h3>'."\n";
			$html .= '					<ul>'."\n";
			$html .= '						<li><a href="#">Facebook</a></li>'."\n";
			$html .= '						<li><a href="#">Twitter</a></li>'."\n";
			$html .= '						<li><a href="#">Rss</a></li>'."\n";
			$html .= '					</ul>'."\n";
			$html .= '				</div>'."\n";
			$html .= '				<p class="copyright">Copyright &copy; <?php date_default_timezone_set(\'Pacific/Auckland\'); echo date(\'Y\');?></p>'."\n";
			$html .= '			</div>'."\n";
			$html .= '		</div>'."\n";
			$html .= '	</body>'."\n";
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