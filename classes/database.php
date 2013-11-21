<?php
	class db {
		public $db;
		public function __construct(){
			$this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			if (mysqli_connect_errno()) {
				echo 'error';
			}
		}
		
		public function getAllPosts(){
			$query = 'SELECT postID, postTitle, postContent, postWriter, postConfirmed, postReviewer, postDate FROM articles  WHERE postConfirmed=1 ORDER BY postDate ASC';
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				$results = Array();				
				while ($row = $rs->fetch_assoc()) {					
					$results[] = Array(
						'postID' => $row['postID'],
						'postTitle' => $row['postTitle'],
						'postContent' => $row['postContent'],
						'postWriter' => $row['postWriter'],
						'postConfirmed' => $row['postConfirmed'],
						'postDate' => $row['postDate']
					);
				}
				return $results;
			} 		
		}
		
		public function getSelectedPosts($max, $pn){
			//this function will be coupled with pagination in the model Class....
			$limit = 'LIMIT ' .($pn - 1) * $max .',' .$max;
			$query = 'SELECT postID, postTitle, postContent, postWriter, postConfirmed, postReviewer, postDate FROM articles WHERE postConfirmed=1 ORDER BY postDate ASC '.$limit;
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				$results = Array();				
				while ($row = $rs->fetch_assoc()) {					
					$results[] = Array(
						'postID' => $row['postID'],
						'postTitle' => $row['postTitle'],
						'postContent' => $row['postContent'],
						'postWriter' => $row['postWriter'],
						'postConfirmed' => $row['postConfirmed'],
						'postDate' => $row['postDate']
					);
				}
				return $results;
			}
		
		}
		
		public function getPostByID($id){
			$query = "SELECT postID, postTitle, postContent, postWriter, postDate FROM articles WHERE postID = $id";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				$results = Array();				
				while ($row = $rs->fetch_assoc()) {					
					$results[] = Array(
						'postID' => $row['postID'],
						'postTitle' => $row['postTitle'],
						'postContent' => $row['postContent'],
						'postWriter' => $row['postWriter'],
						'postConfirmed' => $row['postConfirmed'],
						'postDate' => $row['postDate']
					);
				}
				return $results;
			}	
		}
		
		public function isRegistered(){
			if ($_SESSION['id']){
				$res = $this->getUsersInfo($_SESSION['id']);			
				if ($res['Registered'] == '1'){
					return true;
				} else {
					return false;
				}
			} else {
				return true; //we dont want a user that hasn't logged in yet to, be have the message
			}
			return false;		
		}
		
		public function getSearchRes($query){	
			//this function will do the server side search query and return the results from the query
			$ACquery = "SELECT postID, postTitle, postContent, postWriter, postDate FROM articles WHERE postTitle like '%$query%' or postWriter LIKE '%$query%' AND postConfirmed=1";
			$rs = $this->db->query($ACquery);
			if ($rs && $rs->num_rows > 0){
				$results = Array();				
				while ($row = $rs->fetch_assoc()) {					
					$results[] = Array(
						'postID' => $row['postID'],
						'postTitle' => $row['postTitle'],
						'postContent' => $row['postContent'],
						'postWriter' => $row['postWriter'],						
						'postDate' => $row['postDate']
					);
				}
				return $results;
			}
		}
		
		public function register($username, $password, $email){
				include('includes/PasswordHash.php');
				unset($repassword);					
				$hash_cost_log2 = 8;
				$hash_portable = FALSE;
				$password = stripslashes(strip_tags($password));
				$email = stripslashes(strip_tags($email));
				$username = stripslashes(strip_tags($username));
				$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
				$hash = $hasher->HashPassword($password);						
				$query = "INSERT INTO users (Email, Password, Username, RegisteredDate) VALUES (?, ?, ?, now())";		
				//$this->db->query($query);
				//echo $this->db->error;
				if ($stmt = $this->db->prepare($query)){				
					$stmt->bind_param("sss", $email, $hash, $username);
					$stmt->execute();														
					$stmt->close();							
				}
		}	
		
		public function getPageInfo($id){
			$query = "SELECT pageTitle, pageDescription, pageName FROM pages WHERE id = '$id'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
			$results = Array();						
				while ($row = $rs->fetch_assoc()) {					
					$results[] = Array(
						'pageName' => $row['pageName'],
						'pageTitle' => $row['pageTitle'],
						'pageDescription' => $row['pageDescription']
					);
				}
				return $results[0];
			}
		}
		
		public function login($email, $password){			
			$password = stripslashes(strip_tags($password));
			//well the password has been removed slashes and tags...
			include('includes/PasswordHash.php');
			$hash_cost_log2 = 8;
			$hash_portable = FALSE;
			$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
			$hash = '*';					
			$query = "SELECT password, id, username, Email, UserType, Registered FROM users WHERE Email=?";						
			if ($stmt = $this->db->prepare($query)){				
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$stmt->bind_result($hash, $id, $username, $Email, $userType, $Registered);
				$stmt->fetch();	
				$stmt->close();
				if ($hasher->CheckPassword($password, $hash)) {
					//Authentication succeeded
					$_SESSION['id'] = $id;
					$_SESSION['username'] = $username;
					$_SESSION['userType'] = $userType;
					$_SESSION['registered'] = $Registered;
					if (isset($_GET['return'])){
						$ret = $_GET['return'];
						if ($ret == 'admin'){
							header('location: admin/');
						}
					}					
				} else {
					//password or email error
					$_POST['error'] = 'You inserted your email or password wrong, please try again';
				}
				unset($hasher);
				unset($password);
			}
		}
		
		public function getUsersInfo($userID){
			$query = "SELECT Username, Email, UserType, Registered, RegisteredDate FROM users WHERE id='$userID'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){	
				$rs = $rs->fetch_assoc();			
				return $rs;			
			}
		}
		
		function submitComment($id, $article, $comment){
			if (!$id || !$article || !$comment){
				$_POST['error'] = 'An Error has occurred';
				return false;				
			}
			$query = "INSERT INTO comments (articleID, userID, Comment, date) VALUES ('$article', '$id', '$comment', now())";			
			$rs = $this->db->query($query) || die ($this->db->error);
			if ($rs){			
				return true;
			} else {
				$_POST['error'] = 'Something went wrong, please try again';
				return false;
			}
		}

		function getTags($id){
			//this will get the tags for the article	
			$query = "SELECT tagID, tagText, tagArticle FROM tags WHERE tagArticle = '$id'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows){
				$result = array();
				while ($row = $rs->fetch_assoc()){
					$result[] = Array(
						'tagID' => $row['tagID'],
						'tagText' => $row['tagText'],
						'tagArticle' => $row['tagArticle']
					);					
				}
				return $result;
			}
		}
		
		public function getCommentsByID($id){
			//this will get all the comments that are the post...
			$query = "SELECT date, articleID, userID, Comment FROM comments WHERE articleID = '$id' ORDER by date ASC";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				$results = Array();				
				while ($row = $rs->fetch_assoc()) {					
					$results[] = Array(
						'articleID' => $row['articleID'],
						'userID' => $row['userID'],
						'Comment' => $row['Comment'],
						'Date' => $row['date']
					);
				}
				return $results;
			}			
		}
	}
?>