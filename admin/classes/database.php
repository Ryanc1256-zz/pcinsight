<?php
	class db {
		public $db;
		public function __construct(){
			$this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
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
		
		
		
		function insertEditPost($date, $tags, $article, $title, $writer, $id){
			//lets just double check all the values exsist...			
			if (!$date || !$tags || !$article || !$title || !$writer){		
				$_POST['error'] = 'Woop\'s an Error has occured, please check the values you have inserted';	
			}
		
			$article = str_replace('"', "&#34;", $article); //replaces the quotes with good representation of the character... with ascii code
			$article = str_replace('"', "&#39;", $article); //replaces the quotes with good representation of the character... with ascii code				
			$article = str_replace('’', "&#34;", $article); //replaces the quotes with good representation of the character... with ascii code				
			
			//now also lets add the tags....
			
			$query = "UPDATE articles SET postContent = '$article', postTitle = '$title', postWriter = '$writer', postConfirmed = '1', postDate='$date' WHERE postID = '$id'";
			$rs = $this->db->query($query);
			if ($rs){
				if ($this->deleteTagsForID($id)){
					$this->addTAGS($id, $tags);				
					echo '{"result": "true"}';	
				}
			} else {				
				echo '{"result": "false"}';	
			}
			die();			
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
		
		function insertPost($date, $tags, $article, $title, $writer){
			//lets just double check all the values exsist...			
			if (!$date || !$tags || !$article || !$title || !$writer){		
				$_POST['error'] = 'Woop\'s an Error has occured, please check the values you have inserted';	
			}
		
			$article = str_replace('"', "&#34;", $article); //replaces the quotes with good representation of the character... with ascii code
			$article = str_replace('"', "&#39;", $article); //replaces the quotes with good representation of the character... with ascii code				
			$article = str_replace('’', "&#34;", $article); //replaces the quotes with good representation of the character... with ascii code				
			
			//now also lets add the tags....
			
			$query = "INSERT INTO articles (postContent, postTitle, postWriter, postConfirmed, postDate) VALUES ('$article', '$title', '$writer', 0, '$date')";
			$rs = $this->db->query($query);
			if ($rs){
				$id = $this->db->insert_id;
				$this->addTAGS($id, $tags);				
				echo '{"result": "true"}';				
			} else {
				echo '{"result": "false"}';	
			}
			die();			
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