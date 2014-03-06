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
			
			if (isset($_POST['registerButton'])){
				$this->register();
			}
			
			if (isset($_POST['recoverButton'])){
				$this->recoverAccount();
			}
			
			if (isset($_POST['recoverPasswordButton'])){
				$this->recoverPassword();
			}	

			
			$this->collectStats($this->getUserIP());
			
		}
		
		function recoverPassword(){
			//just validates a form before submiting it to the database class
			$pass = $_POST['password'];
			$repass = $_POST['repassword'];
			if ($pass !== $repass){
				$_POST['error'] = 'The passwords you entered didn\'t match please try again';
			} else {
				$this->db->updatePassword($pass);
			}
		}
		
		function register(){
			//this function will be validitaing the email and password the user submited to register his password..
			//this will also add a key into the database and also send them a email saying the final steps on registering	
			$email = $_POST['email'];
			$password = $_POST['password'];
			$repassword = $_POST['repeat-password'];
			$username = $_POST['username'];
			
			require_once('lib/recaptchalib.php');
			$privatekey = CAPTCHA_PR;
			$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
			
			 if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
				$_POST['error'] = 'Please insert the correct captcha';
				return false;
			} 			
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
						$this->db->register($username, $password, $email);
					}				
				}		
			}				
		}
		
		function getAboutArticle(){
			//gets the about page from the database to display on the about page
			return $this->db->getAboutArticle();
		}
		
		function recoverAccount(){
			//just validates a form before submiting it to the database class
			$email = $_POST['email'];
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
				$this->db->recoverAccount($email);
			} else {
				$_POST['error'] = 'Please Put in a valid Email Address'; //well thats a shame it's not... lets do an error
				return;
			}
		}
		
		function checkActivation(){
			//checkes the active ID and submits it, and return the data
			$id = $_GET['id'];
			if ($id){				
				return $this->db->activateAccount($id);
			}
			return false;
		}
		
		function collectStats($ip){
			//this function will collect stats about how many users come to the website and how many unique (ips) come to the site
			$this->db->updateAmountOfVis();
			//well now we check if the ip is an actual value then we insert into the database and update the values		
			if ($ip){			
				if (!$this->db->isIpNew($ip)){
					$this->db->addIP($ip);
				}
			}
		}
		
		function getUserIP(){
			//this a function to get the current users ip, so we can check if its a new user or not... 
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = $_SERVER['REMOTE_ADDR'];

			if(filter_var($client, FILTER_VALIDATE_IP))
			{
				$ip = $client;
			}
			elseif(filter_var($forward, FILTER_VALIDATE_IP))
			{
				$ip = $forward;
			}
			else
			{
				$ip = $remote;
			}

			return $ip;
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