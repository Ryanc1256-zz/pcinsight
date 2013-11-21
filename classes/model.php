<?php
	class model {
		public $db;
		public function __construct(){
			include ('classes/database.php');
			$this->db = new db();
			
			
			if (isset($_POST['loginButton'])){
				$this->login();
			}
			
			if (isset($_POST['commentSubmitButton'])){
				$this->commentSubmit();
			}
			
			
		}
		
		function register(){
			//this function will be validitaing the email and password the user submited to register his password..
			//this will also add a key into the database and also send them a email saying the final steps on registering	
			$email = $_POST['email'];
			$password = $_POST['password'];
			$repassword = $_POST['repeat-password'];
			$username = $_POST['username'];
			
			if (!$email || !$password || !$repassword || !$username){
				//Error
				$_POST['error'] = 'Please Fill in all fields';				
			} else {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ //checks if its a valid email
						$_POST['error'] = 'Please Put in a valid Email Address'; //well thats a shame it's not... lets do an error
				} else {
					if ($password != $repassword){
						$_POST['error'] = 'Your passwords doesn\'t match';
					} else {
						//passwords match
						//now the logic behind the register
						//$this-db->login($username, $password, $email);
					}				
				}		
			}				
		}
		
		function login(){
			//This function will process the login data, and also log the user in...
			$email = $_POST['email'];
			$password = $_POST['password'];
			if (!$email || !$password){
				//well this is a problem...
				$_POST['error'] = 'Please Fill out all fields';
			} else {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$_POST['error'] = 'Please Put in a valid Email Address';
				} else {
					//now we can do a query...
					$this->db->login($email, $password);			
				}
			}								
			
		}
		
		
		function getPostByID(){
			//this function will be the backbone of the post... it will get the post and return  it.
			$id = $_GET['post'];
			if ($id && is_numeric($id)){
				return $this->db->getPostByID($id);
			}
						
		}
		
		function pageInation($rs, $max = 7){
				//the main part of the pagination links on the home page of the website.
				if (!$rs) { return false; }
				if (isset($_GET['page'])){
					$pn =  preg_replace('#[^0-9]#i', '',$_GET['page']);					
				} else {
					$pn = 1;
				}
				
				$prev = '<a href="index.php?page=' . ( $pn - 1 ) .'"> Prev &nbsp;</a>'."\n";
				$next = '<a href="index.php?page=' . ( $pn + 1 ) .'"> Next  &nbsp;</a>'."\n";
				
				//now get the amount of pages...
				$amountOfPages = ceil(count($rs) / $max);
				$page = '';
				for ($i = 1; $i < $amountOfPages; $i++){
					$page .= '<a href="index.php?page=' . $i .'"> ' . $i . '</a>'."\n";			
				}
				$pageInationRe = Array(
					'prev' => $prev,
					'page' => $page,
					'next' => $next,
					'query' => $this->db->getSelectedPosts($max, $pn)
				);
				return $pageInationRe;			
		
		}
		
		function pageInfo(){
			//this function will return the pageinfo for the current page...
			$pageID = $_GET['p'];
			if (!$pageID){
				$pageID = 1;
			}
			$pageID = preg_replace('#[^0-9]#i', '', $pageID);
			return $this->db->getPageInfo($pageID);
		}
		
		function commentSubmit(){
			//this function will submit the comment...
			$userID = $_SESSION['id'];
			if ($userID && is_numeric($userID)){
				$articleID = $_GET['post'];
				$comment = strip_tags($_POST['comment']);
				if ($comment && ( $articleID && is_numeric($articleID) ) && $userID) {
					return $this->db->submitComment($userID, $articleID, $comment);
				}
			} else {
				//hmm weired... no userID... lets send the user to the login page...
				header('location: index.php?p=4');
			}		
		}
		
		function isLoggedin(){
			//this is a simple check to see if the user is logged in...
			if (isset($_SESSION['username'])){
				return true;
			} 
			return false;
		}
		
		function getComments(){
			//this is the base function of getting all the comments for a post...
			$id = $_GET['post'];
			if ($id && is_numeric($id)){
				return $this->db->getCommentsByID($id);
			}
		}
		
		function isAdmin(){
			//lets check if the user is an admin or not...
			$ses = $_SESSION;	
			$usr = $this->db->getUsersInfo($ses['id']);				
			if ($usr['UserType'] == '6' || $usr['UserType'] == '5'){
				return true;
			}
			return false;
		}
		
		function getTags(){
			$id = $_GET['post'];
			if ($id){
				return $this->db->getTags($id);
			}
		}
		
	}

?>