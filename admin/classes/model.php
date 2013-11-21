<?php
	class model {
		public $db;
		public function __construct(){
			include ('classes/database.php');
			$this->db = new db();
			
			
			if (isset($_POST['reviewSubmit'])){
				$this->reviewSubmit();
			}
			
			if (isset($_POST['submitEdit'])){
				$this->submitEdit();
			}
			
			if (isset($_POST['EditArticlePOST'])){
				$this->EditArticle();
			}			
		}
		
		function reviewSubmit(){
			//this is the function that will validate the users article he/she has submitted...		
			$tags = $_POST['tags'];
			$article = $_POST['article'];
			$date = $_POST['date'];
			$title = $_POST['title'];
			$writer =  $_SESSION['id'];
			if (!$tags || !$article || !$title){			
				$_POST['error'] = 'Woops! Error please input all the fields to continue';
				return;
			} else {				
				if (!$date){
					$date = Date('Y-m-d');
				}			
				$this->db->insertPost($date, $tags, $article, $title, $writer);				
			}				
		}
		
		function EditArticle(){
			//this is the function that will validate the users article he/she has submitted...		
			$tags = $_POST['tags'];
			$article = $_POST['article'];
			$date = $_POST['date'];
			$title = $_POST['title'];
			$writer =  $_SESSION['id'];
			$id = $_POST['id'];
			if (!$tags || !$article || !$title){			
				$_POST['error'] = 'Woops! Error please input all the fields to continue';
				return;
			} else {				
				if (!$date){
					$date = Date('Y-m-d');
				}			
				$this->db->insertEditPost($date, $tags, $article, $title, $writer, $id);				
			}				
		}
		
		function getPostByID(){
			//this function will just get the id from the url using $_GET and then query the database and return the results.
			$id = $_GET['id'];
			$id = strip_tags(stripslashes($id));
			return $this->db->getpostBYID($id);
		}
		
		function submitEdit(){
			$userType = $_POST['userType'];
			$Registered = $_POST['Registered'];	
			$date = $_POST['date'];
			$email = $_POST['email'];
			$username = $_POST['username'];
			$userID = strip_tags(stripslashes($_GET['usr']));
			if (!$Registered) {
				$Registered = 0;
			} else {
				$Registered = 1;
			}
			if (!$userID || !$userType || !$date || !$email || !$username){
				$_POST['error'] = "Please fill in every feild";
			} else {
				if (filter_var($email, FILTER_VALIDATE_EMAIL)){
					$this->db->submitEdit($userID, $email, $userType, $date, $username, $Registered);
				} else {
					$_POST['error'] = 'Please insert a proper email address';
				}
			}	
		}		
	}
?>