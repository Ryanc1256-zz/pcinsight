<?php
	class db {
		public $db;
		public function __construct(){
			$this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			$this->db->set_charset('utf-8');
			if (mysqli_connect_errno()) {
				echo 'error';
			}
		}
		
		function getAllPosts(){
			//gets all the posts 
			$query = 'SELECT postID, postTitle, postContent, postWriter, postConfirmed, postReviewer, postDate FROM articles';
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
		
		function deleteArticle($id){
			//deletes the article from the DB...
			$query = "DELETE FROM articles WHERE postID = '$id'";
			$this->db->query($query);
			header('location: index.php?p=2');
		}
		
		public function getAboutArticle(){
			//gets the about page from the database to display on the about page
			$query = "SELECT pageContent FROM pages WHERE id=10";
			$rs = $this->db->query($query);
			if ($rs){
				return $rs->fetch_assoc();
			}
		}
		
		function editAboutPage($article){
			//this will update the text on the about page			
			if ($article && strlen($article) > 5){
				$article = htmlspecialchars($article, ENT_QUOTES);
				$query = "UPDATE pages SET pageContent='$article' WHERE id=10 ";
				$rs = $this->db->query($query) or die($this->db->error);
				if ($rs){
					$_POST['success'] = 'The about page was successfully updated!';
					return true;
				} else {
					$_POST['error'] = 'An Error has occurred';
				}				
			} else {
				$_POST['error'] = 'Please fill in everything!';
			}
		}
		
		function getpostBYID($id){
			if (!$id) {return false;}
			//this function will get a article from the database and return that as an array...
			$query = "SELECT postID, postTitle, postContent, postWriter, postConfirmed, postReviewer, postDate FROM articles WHERE postID = '$id'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){			
				return $rs->fetch_assoc();
			} else {
				return false;
			}
		}
		
		function updateImageViewer($id, $pos){
			//this function updates the settings in the database for the image viewer...
			switch ($pos){
				case '1':
					$query = "UPDATE settings SET settingValue = '$id'	WHERE id=3";
					break;
				case '2':
					$query = "UPDATE settings SET settingValue = '$id'	WHERE id=4";
					break;
				case '3':
					$query = "UPDATE settings SET settingValue = '$id'	WHERE id=5";
					break;			
			}
			if ($query){
				$this->db->query($query) || die($this->db->error);
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
		
		
		
		function insertEditPost($date, $tags, $article, $title, $writer, $id, $file){
			//lets just double check all the values exsist...			
			if (!$date || !$tags || !$article || !$title || !$writer){		
				$_POST['error'] = 'Woop\'s an Error has occured, please check the values you have inserted';	
			}
		
			$article = htmlspecialchars($article, ENT_QUOTES, 'UTF-8'); //replaces the quotes with good representation of the character... with ascii code				
			$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
			//now also lets add the tags....
			$Userid = $_SESSION['id'];		
			$query = "UPDATE articles SET postContent = '$article', postTitle = '$title', postReviewer='$Userid', postWriter = '$writer', postConfirmed = '1', postDate='$date' WHERE postID = '$id'";
			
			$rs = $this->db->query($query);
			if ($rs){
				if ($this->deleteTagsForID($id)){
					$this->addTAGS($id, $tags);	
					if ($file){
						$this->editImages($file, $id);
					}
					echo '{"result": "true"}';	
				}
			} else {				
				echo '{"result": "false"}';	
			}
			die();			
		}	
		
		function editImages($file, $id){
			//this will update the images table on the database....
			$imageCover = $file['image'];
			$imageThumb = $file['thumb'];
			$relativeThumb = $file['relativeThumb'];
			$relative = $file['relative'];
			$mobile = $file['mobile'];			
			$mobileRelative = $file['mobileRelative'];			
			$id = $id;
			
			$query = "UPDATE images SET imageCover = '$imageCover', imageThumb = '$imageThumb', relativeThumb = '$relativeThumb', relative = '$relative', mobile = '$mobile', mobileRelative = '$mobileRelative' WHERE articleID = '$id'";
			$this->db->query($query);
		}
		
		function deleteTagsForID($id){
			//this function will delete every tag with an articles ID, as we are overriding it, and we don't need them anymore
			$query = "DELETE FROM tags WHERE tagArticle = '$id'";
			$rs = $this->db->query($query);
			if ($rs){
				return true;
			} else{
				return false;
			}
		}
		
		function insertPost($date, $tags, $article, $title, $writer, $image){
			//lets just double check all the values exsist...			
			if (!$date || !$tags || !$article || !$title || !$writer || !$image){			
				$_POST['error'] = 'Woop\'s an Error has occured, please check the values you have inserted';
				echo '{"result": "false"}';
				exit;				
			}
		
			$article = htmlspecialchars($article, ENT_QUOTES, 'UTF-8'); //replaces the quotes with good representation of the character... with ascii code							
			$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); //replaces the quotes with good representation of the character... with ascii code							
			
			//now also lets add the tags....
			
			$query = "INSERT INTO articles (postContent, postTitle, postWriter, postConfirmed, postDate) VALUES ('$article', '$title', '$writer', 0, '$date')";
			$rs = $this->db->query($query) || die($this->db->error);
			if ($rs){
				$id = $this->db->insert_id;
				$this->addTAGS($id, $tags);	
				$this->addImages($id, $image);
				echo '{"result": "true"}';				
			} else {
				echo '{"result": "false"}';	
			}
			die();			
		}	
		
		function addImages($id, $image){
			//this function will just add the images to the database...
			$imageCover = $image['image'];
			$thumb = $image['thumb'];
			$relative = $image['relative'];
			$relativeThum = $image['relativeThumb'];
			$mobile = $image['mobile'];
			$mobileRelative = $image['mobileRelative'];
			
			$query = "INSERT INTO images (articleID, imageCover, imageThumb, relativeThumb, relative, mobileRelative, mobile) VALUE ('$id', '$imageCover', '$thumb', '$relativeThum', '$relative', '$mobileRelative', '$mobile')";
			$rs = $this->db->query($query);
			if ($rs){
				return true;
			} else {
				return false;
			}		
			return false;
		}
		
		function getTags($id){
			//this function will get all the tags for that article...
			$query = "SELECT tagID, tagText, tagArticle FROM tags WHERE tagArticle = '$id'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){
				$result = Array();
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
		
		function addTAGS($id, $tags){
			$tags = explode('#', $tags);
			for ($i = 0; $i < count($tags); $i++){
				$tagText = $tags[$i];
				$query = "INSERT INTO tags (tagText, tagArticle) VALUES ('$tagText', '$id')";
				$rs = $this->db->query($query);
				if ($rs){
					
				}
			}
			
		}
		
	
		
		function getUsersInfo($userID){
			//gets the users info... with the ID 
			$query = "SELECT Username, Email, UserType, Registered, RegisteredDate FROM users WHERE id='$userID'";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){	
				$rs = $rs->fetch_assoc();			
				return $rs;			
			}
		}
		
		function allUsers(){
			//this will get all the users in the database and return them
			$query = "SELECT id, Username, Email, UserType, Registered, RegisteredDate FROM users";
			$rs = $this->db->query($query);
			if ($rs && $rs->num_rows > 0){	
				$results = Array();				
				while ($row = $rs->fetch_assoc()) {					
					$results[] = Array(
						'id' => $row['id'],
						'username' => $row['Username'],
						'email' => $row['Email'],
						'usertype' => $row['UserType'],
						'registered' => $row['Registered'],
						'registeredDate' => $row['RegisteredDate']					
					);
				}
				return $results;	
			}
		}
		
		function getAllTags(){
			//this function will just return all the tags and return them.
			$query = "SELECT tagID, tagText, TagArticle FROM tags";
			$rs = $this->db->query($query);
			if ($rs) {
				$result = Array();
				while ($rows = $rs->fetch_assoc()){
					$result[] = Array(
						'id' => $rows['tagID'],
						'text' => $rows['tagText'],
						'article' => $rows['tagArticle']
					);					
				}
				return $result;
			}
		}
		
		function submitEdit($userID, $email, $userType, $date, $username, $Registered){
			//updates users account...
			if (!$email || !$date || !$username || !$userType){
				$_POST['error'] = 'please fill in all messages';
			} else {
				$Registered = $Registered == 0? 'false' : 'true';			
				$query = "UPDATE users SET Email = '$email', Username = '$username', UserType = '$userType', Registered = $Registered, RegisteredDate = '$date' WHERE id = '$userID'";
				$this->db->query($query);			
				$_POST['success'] = 'success';
			}
		}
	}
?>