<?php
	class Page extends view{
		function displayContent(){
			$html = '	<div class="mainContent">'."\n";
			$html .= '<div id="mainHeader">'."\n";
			$html .= '				<div class="header">'."\n";
			$html .= '					<i class="icon-question"></i>'."\n";
			$html .= '					<h2> Edit User </h2>'."\n";
			$html .= '				</div>'."\n";
			$html .= '			</div>'."\n";
			$html .= '			<section id="innerContentWrapper" class="float left page-editUsers">'."\n";
			$html .= '				<div id="innerContent">'."\n";
			$html .=		 $this->getAllUsers();	
			$html .= '				</div>'."\n";
			if (isset($_POST['success'])){
				$html .= '<div class="user alert alert-dismissable alert-info">'."\n";					
				$html .= '	 User updated!'."\n";
				$html .= '</div>'."\n";
			}
			$html .= '			</section>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			$html .= '</div>'."\n";
			return $html;
		}
		
		function getAllUsers(){
			$usrID = strip_tags($_GET['usr']);
			$users = $this->model->db->getUsersInfo($usrID);
			$html = '';	
			$selectedOptions = Array('','','','','','');
			$id = $users['UserType'];
			$id = $id-1;			
			$selectedOptions[$id] = 'selected="selected"';				
			$registered = $users['Registered'] == 0 ? '' : 'checked="true"';
			$html .= '<form action="' . $_SERVER['REQUEST_URI'] .'" method="post">'."\n";
				$html .= '<label for="username"> Username </label>'."\n";
				$html .= '<input type="text" id="username" name="username" value="'.$users['Username'].'"/>'."\n";		
				
				$html .= '<label for="email"> Email </label>'."\n";
				$html .= '<input type="text" id="email" name="email" value="'.$users['Email'].'"/>'."\n";	
				
				$html .= '<label for="Registered"> Registered </label>'."\n";
				$html .= '<input type="checkbox" '.$registered . ' value="1" name="Registered"/>'."\n";
				
				$html .= '<label for="registeredDate"> Registered Date </label>'."\n";
				$html .= '<input type="text" id="registeredDate" name="date" value="'. $users['RegisteredDate'] .'" />'."\n";
				
				$html .= '<label for="userType"> User Type </label>'."\n";
				$html .= '<select name="userType" id="userType">'."\n";
					$html .= '<option value="1" ' .$selectedOptions[0] .'> User </option>'."\n";
					$html .= '<option value="2" ' .$selectedOptions[1] .'> Writer </option>'."\n";
					$html .= '<option value="3" ' .$selectedOptions[2] .'> Reviewer </option>'."\n";
					$html .= '<option value="4" ' .$selectedOptions[3] .'> Developer </option>'."\n";
					$html .= '<option value="5" ' .$selectedOptions[4] .'> Admin </option>'."\n";
					$html .= '<option value="6" ' .$selectedOptions[5] .'> Developer + Admin </option>'."\n";
				$html .= '</select>'."\n";
				$html .= '<p class="error">' . $_POST['error'] . '</p>'."\n";
				$html .= '<input type="submit" value="Submit Edit" name="submitEdit" class="btn red"/>'."\n";
			$html .= '</form>'."\n";		
			return $html;
		
		}
	}
?>