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
		
		private function pageInfo()
		{
			define('get_pageInfo', false);
		}
		
		public function setTheme()
		{
			$this->theme = $this->loc.THEME;
			return $this->theme;
		}
		
		public function loadContent()
		{
			$this->pageInfo();
			
			$this->loadHead();		
			$this->loadHome();		
			$this->loadFooter();			
		}
		
		
		private function loadHead()
		{		
			include($this->theme.'\header.php');				
		}	
		
		private function loadFooter()
		{
			include($this->theme.'\footer.php');		
		}
		
		private function loadHome()
		{
			include($this->theme.'\footer.php');					
		}
		
		private function themeCSS()
		{
			return $this->theme.'\style.css';
		}
		
		
		public function addStyle()
		{
			$html = '<link rel="stylesheet" type="text/css" href="'.$this->themeCSS().'" />';
			return $html;
		}
	}
?>