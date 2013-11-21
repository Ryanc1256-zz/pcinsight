<?php
	class Page extends view{
		function displayContent(){
			$html = '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-question"></i>'."\n";
			$html .= '					<h2> Posts </h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left page-allPosts">'."\n";
			$html .= '				<div id="innerContent">'."\n";
			$html .= '					<table class="listPosts">'."\n";
			$html .= '					<tr><td>Username</td><td>Email</td><td>User Type</td><td> Registered </td><td> Registered Date </td><td>Edit Users</td></tr>'."\n";
			$html .=			 $this->getAllUsers();
			$html .= '					</table>'."\n";		
			$html .= '				</div>'."\n";		
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}
		
		function getAllUsers(){
			$users = $this->model->db->allUsers();
			$html = '';
			for ($i = 0; $i < count($users); $i++){
				$rs = $users[$i];
				$registered = $rs['registered'] == true ? 'checked' : '';
				$html .= '<tr><td>' . $rs['username'] . '</td><td>'. $rs['email'] .'</td><td>'. $rs['usertype'] .'</td><td><input type="checkbox" '.  $registered . ' /></td><td>' . $rs['registeredDate'] . '</td><td><a href="index.php?p=5&usr='.$rs[id].'" class="btn red"> Edit </a></td></tr>'."\n";
			}
			return $html;
		
		}
	}
?>