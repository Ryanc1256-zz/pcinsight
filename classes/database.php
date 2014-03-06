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
			//querys the database for all the articles and returns them....
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
		
		public function getAboutArticle(){
			//gets the about page from the database to display on the about page
			$query = "SELECT pageContent FROM pages WHERE id=10";
			$rs = $this->db->query($query);
			if ($rs){
				return $rs->fetch_assoc();
			}
		}
		
		public function isIpNew($ip){
			//checks if the ip is actaully an new user or not...
			$query = "SELECT ip FROM clients WHERE ip = '$ip'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				return true;
			}			
			return false;
		}
		
		function recoverAccount($email){
			//sends a recover account email with instructions on how to recover his/her account
			require_once('mail.php');
			$id = uniqid();
			$query = "UPDATE users SET RandomKEY = '$id' WHERE Email = '$email'";
			$rs = $this->db->query($query);
			if ($rs){
				$mail = new mail();
				$mail->lostPassword($email, $id);
				$_POST['success'] = 'We have just sent you an email on how to recover your password...';
			}
		}
		
		function sendActivationEmail(){
			//this just sends an email out to the user for the user to activate his/her account
			require_once('mail.php');
			$res = $this->getUsersInfo($_SESSION['id']);	
			$email = $res['Email'];			
			$id = uniqid();
			$query = "UPDATE users SET RandomKEY = '$id' WHERE Email = '$email'";
			$rs = $this->db->query($query);
			if ($rs){
				$mail = new mail();
				$mail->registerMail($email, $id);
				$_POST['success'] = 'We have just sent you an email on how to recover your password...';
			}		
		}
		
		function updatePassword($pass){
			//does the processing for the account....
			$pass = $this->escapeSpecial($pass);	
			$id = $_GET['id'];
			if ($id){
				$id = $this->escapeSpecial($id);
				include('includes/PasswordHash.php');			
				$hasher = new PasswordHash(8, FALSE);
				$hash = $hasher->HashPassword($pass);	
				if (strlen($hash) > 8){
					$query = "UPDATE users SET Password = '$hash' WHERE RandomKEY = '$id'";
					$rs = $this->db->query($query);
					unset($pass);
					unset($hasher);
					unset($hash);
					if ($rs){
						header('location: index.php?p=2');
					}	
				} else {
					$_POST['error'] = 'Something when wrong, please try again later';
				}
			}
		}
		
		public function updateAmountOfVis(){
			//this will just update the database which will have the amount of page visits
			$updateSettings = "UPDATE settings SET settingValue = settingValue+1 WHERE id=2";
			$this->db->query($updateSettings);			
		}
		
		function activateAccount($id){
			//this function activates their account...
			$id = $this->escapeSpecial($id);
			if ($id){				
				$query = "UPDATE users SET Registered = '1' WHERE RandomKEY = '$id'";
				$rs = $this->db->query($query);
				if ($rs){
					return true;
				}
			}
			return false;		
		}
		
		public function addIP($ip){
			//this function just adds the ip to the database
			$query = "INSERT INTO clients (ip) VALUES ('$ip')";
			$rs = $this->db->query($query);
			if ($rs){
				$updateSettings = "UPDATE settings SET settingValue = settingValue+1 WHERE id=1";
				$this->db->query($updateSettings);
				return true;
			}			
			return false;		
		}
		
		public function searchTags($search){
			//this function will return all the different tags similar to the search results
			$search = $this->escapeSpecial($search);			
			$query = "SELECT tagID, tagText, tagArticle FROM tags WHERE tagText LIKE '%$search%'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				$results = Array();
				while ($rows = $rs->fetch_assoc()){
					$results[] = Array(
						'tagID' => $rows['tagID'],
						'tagText' => $rows['tagText'],
						'tagArticle' => $this->getPostByID($rows['tagArticle'])
					);
				}	
				return $results;
			}
		}
		
		
		public function getAllTags(){
			//gets all the tags and returns an array full of tags and articles....
			$query = "SELECT DISTINCT(tagArticle) FROM tags";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){				
				$results = Array();
				while ($rows = $rs->fetch_assoc()){
					$results[] = Array(						
						'tagArticle' => $this->getPostByID($rows['tagArticle'])
					);
				}	
				return $results;
			
			}	
		}
		
		function getSettings(){
			//this will query the database and return the settings for the admin panel which is user count and such like that....
			$query = "SELECT settingValue, settingName FROM settings";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				$results = Array();
				while ($rows = $rs->fetch_assoc()){
					$results[$rows['settingName']] = Array(
						'name' => $rows['settingName'],
						'value' => $rows['settingValue']
					);					
				}
				return $results;
			}
			return false;
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
						'postDate' => $row['postDate'],
						'images' => $this->getImagesByPostID($row['postID'])
					);
				}
				return $results;
			}
		
		}
		
		public function getPostByID($id){
			//get posts by ID?? its quite self explanatory.... it will just get the post by an id....
			$id = $this->escapeSpecial($id);
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
			//is the current user registered?
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
			$query = $this->escapeSpecial($query);
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
				//insert the users username and password
				include('includes/PasswordHash.php');
				unset($repassword);					
				$hash_cost_log2 = 8;
				$hash_portable = FALSE;												
				$username = $this->escapeSpecial($username);
				$email = $this->escapeSpecial($email);
				$password = $this->escapeSpecial($password);
				$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
				$hash = $hasher->HashPassword($password);	
				$id = uniqid(); 
				if ($this->selectUserByEmail($email)){
					$_POST['error'] = 'This email already exsits, please recover your password if this email is you one';
					return;
				}
				$query = "INSERT INTO users (Email, Password, Username, RegisteredDate, RandomKey) VALUES (?, ?, ?, now(), '$id')";			
				if ($stmt = $this->db->prepare($query)){				
					$stmt->bind_param("sss", $email, $hash, $username);
					$stmt->execute();														
					$stmt->close();		
					require_once('mail.php');
					$mail = new mail();					
					$mail->registerMail($email, $id);					
					header('location: index.php?p=2');
				}
		}	
		
		public function selectUserByEmail($email){
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
				$query = "SELECT Email, Password, Username FROM users WHERE Email = '$email'";
				$rs = $this->db->query($query);
				if ($rs && $rs->num_rows > 0){
					return $rs->fetch_assoc();
				}
				return false;
			}		
		}
		
		public function getPageInfo($id){
			//gets infomation about the page
			$id = $this->escapeSpecial($id);
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
			//the login part, quite easy.... the database interaction
			$password = $this->escapeSpecial($password);
			//well the password has been removed slashes and tags...
			include('includes/PasswordHash.php');
			$hash_cost_log2 = 8;
			$hash_portable = FALSE;
			$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
			$hash = '*';	
			$email = $this->escapeSpecial($email);			
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
					} else {
						header('location: index.php');
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
			//gets info about the user by the userID
			$userID = $this->escapeSpecial($userID);		
			$query = "SELECT Username, Email, UserType, Registered, RegisteredDate FROM users WHERE id='$userID'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){	
				$rs = $rs->fetch_assoc();			
				return $rs;			
			}
		}
		
		function submitComment($id, $article, $comment){
			//submits a comment
			if (!$id || !$article || !$comment){
				$_POST['error'] = 'An Error has occurred';
				return false;				
			}
			$comment = $this->escapeSpecial($comment);
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
			$id = $this->escapeSpecial($id);		
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
			$id = $this->escapeSpecial($id);		
			$query = "SELECT date, articleID, userID, Comment FROM comments WHERE articleID = '$id' ORDER BY date DESC";
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
		
		public function getImagesByPostID($id){
			$id = $this->escapeSpecial($id);
			$query = "SELECT imageCover, imageThumb, relativeThumb, relative, mobile, mobileRelative FROM images WHERE articleID = '$id'";		
			$rs = $this->db->query($query);
			if ($rs){
				return $rs->fetch_assoc();				
			}
			return false;
		}
		
		public function escapeSpecial($string){
			if ($string){
				$string = strip_tags(stripslashes($string));
				$string = str_replace('"', '&#34;', $string);
				$string = str_replace("'", '&#39;', $string);
			}
			return $string;			
		}
	}
?>