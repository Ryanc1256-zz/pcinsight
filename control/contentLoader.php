<?php
	class contentLoader
	{
		private $loc;	
		private $theme;
		public function __construct()
		{		
			$this->loc =  WEBSITE_BASE_LOC.'/content/theme/';
			$this->setTheme();
		}
		
		public function loadTheme()
		{
			$files = scandir($loc);
			for ($i = 0; $i < count($files); $i++)
			{
			
			}	
		}
		
		public function setTheme()
		{
			$this->theme = $this->loc.THEME;
			return $this->theme;
		}
		
		public function loadContent()
		{	
			if (allowedToMove){ //this is probably the admin area
				$this->loadHead();		
				$this->loadHome();		
				$this->loadFooter();
			}			
		}
		
		
		private function loadHead()
		{		
			$config = new config();
			$info = new info();			
			$themePath = $this->themeCSS();
			include($this->theme.'\header.php');				
		}	
		
				
		private function loadFooter()
		{
			include($this->theme.'\footer.php');		
		}
		
		private function loadHome()
		{
			include($this->theme.'\home.php');					
		}
		
		private function themeCSS()
		{
			return '../content/theme/' . THEME .'/' .'style.css';
		}
		
		
		public function addStyle()
		{
			$html = '<link rel="stylesheet" type="text/css" href="'.$this->themeCSS().'" />';
			return $html;
		}
	}
?>