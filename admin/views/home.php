<?php
	class Page extends view{
		function displayContent(){
			$user = $this->db->getUsersInfo($_SESSION['id']);
			$html = '<div class="mainContent">'."\n";
			$html .= '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-dashboard  red"></i>'."\n";
			$html .= '					<h2> Dashboard </h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left">'."\n";
			$html .= '				<div id="innerContent">'."\n";
			$html .= '					<div class="user alert alert-dismissable alert-info">'."\n";
			$html .= '						<a class="close" data-dismiss="alert" href="#">x</a>'."\n";
			$html .= '						 Welcome <strong>'.$user['Username'].'</strong>'."\n";
			$html .= '					</div>'."\n";			
			$html .= '					<span class="block clearfix"></span>'."\n";
			$html .= '					<h2 class="center"> Website stats </h2>'."\n";			
			$html .= '				</div>'."\n";			
			$html .= '				<span class="line break block clearfix"></span>'."\n";
			$html .= '				<div id="todayInfo">'."\n";
			$html .= '					<div class="groupHeader">'."\n";
			$html .= '						<i class="icon-group"></i>'."\n";
			$html .= '						<span> Visitors </span>'."\n";
			$html .= '					</div>'."\n";
			$html .= '					<div class="row">'."\n";
			$html .= '						<div class="info box static">'."\n";
			$html .= '							<h3> '.$this->getUniqueUsers().' </h3>'."\n";
			$html .= '							<small> UNIQUE </small>'."\n";
			$html .= '							<span class="icon-user float right color red"></span>'."\n";
			$html .= '						</div>'."\n";
			$html .= '						<div class="info box static">'."\n";
			$html .= '							<h3> '.$this->getVisitors().' </h3>'."\n";
			$html .= '							<small> Page vists </small>'."\n";
			$html .= '							<span class="icon-user float right color red"></span>'."\n";
			$html .= '						</div>'."\n";
			$html .= '					</div>'."\n";
			$html .= '				</div>'."\n";
			$html .= '				<span class="line break block clearfix"></span>'."\n";
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			
			return $html;
		}
		
		function getUniqueUsers(){
			$uniqueUsers = $this->db->getSettings();	
			return $uniqueUsers['uniqueUsers']['value'];
		}
		
			
		function getVisitors(){
			$visitors = $this->db->getSettings();	
			return $visitors['visitors']['value'];
		}
	
	}
?>