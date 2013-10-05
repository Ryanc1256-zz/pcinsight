<?php
	class info {
		public $pageInfo;
		public function __construct()
		{
			$this->getPageInfo();
		}
		
		public function getPageInfo()
		{
			$info = Array(
				'page' => 'info',
				'title' => 'home'
			);
			
			$this->pageInfo = $info;
			return $info;
		}
	
	}
?>