<?php
	class Page extends view{
		function displayContent(){
			$rs = $this->model->getAboutArticle();
			$html = '<div class="mainContent">'."\n";
			$html .= '<div id="mainHeader">'."\n";
			$html .= '<div class="header">'."\n";
			$html .= '<i class="icon-file  red"></i>'."\n";
			$html .= '<h2> Edit a About Page</h2>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '<section id="innerContentWrapper">'."\n";
			$html .= '<div id="innerContent" class="posts page content page-newArticle">'."\n";
			$html .= '<div class="user alert alert-dismissable alert-info">'."\n";
			$html .= '<a class="close" data-dismiss="alert" href="#">x</a>'."\n";
			$html .= 'This will edit the about page.'."\n";
			$html .= '</div>'."\n";
			$html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">'."\n";				
			$html .= '<textarea id="ckeditor" name="ckeditor">'.htmlspecialchars_decode($rs['pageContent']).'</textarea>'."\n";
			$html .= '<input type="submit" name="editAboutPage" class="btn red" value="submit Edit">'."\n";
			$html .= '</form>'."\n";
			if (isset($_POST['error'])){
				$html .= '<span class="alert alert-danger">' . $_POST['error'] .'</span>'."\n";
			}
			if (isset($_POST['success'])){
				$html .= '		<span class="alert alert-success">' . $_POST['success'] .'</span>'."\n";
			}	
			$html .= '</div>'."\n";		
			$html .= '<span class="line break block clearfix"></span>'."\n";
			$html .= '</section>'."\n";
			$html .= '</div>'."\n";			
			$html .= '</div>'."\n";			
			$html .= '<script src="resources/ckeditor/ckeditor.js"></script>'."\n";
			$html .= '<script src="resources/ckeditor/adapters/jquery.js"></script>'."\n";	
			$html .= '<script>$("#ckeditor").ckeditor();</script>'."\n";
			return $html;
		}		
	}
?>