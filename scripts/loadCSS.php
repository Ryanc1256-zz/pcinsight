<?php
	class loadCSS {
		public function __construct(){
			include ('../lib/lessc.inc.php');

			$less = new lessc;
			//load the css file
			header('Content-type: text/css');
			echo $less->compileFile('../resources/css/style.less');			
		}
	}
	new loadCSS();
?>