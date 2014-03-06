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

			if (isset($_POST['ajaxUpload'])){
				$this->processAjaxUpload();
			}
			
			if (isset($_GET['deletePOST'])){
				header('location: index.php?p=8&id='.$_GET['id']);
			}
			
			if (isset($_POST['deleteSubmit'])){
				$this->deleteArticle();
			}
			
			if (isset($_POST['falseDownload'])){
				header('location: index.php?p=2');
			}
			
			if (isset($_POST['editAboutPage'])){
				$this->editAboutPage();
			}
			
			
		}
		
		public function getAboutArticle(){
			//gets the about page from the database to display on the about page			
			return $this->db->getAboutArticle();
		}
		
		function reviewSubmit(){
			//this is the function that will validate the users article he/she has submitted...		
			$tags = $_POST['tags'];
			$article = $_POST['article'];
			$date = $_POST['date'];
			$title = $_POST['title'];
			$writer =  $_SESSION['id'];
			$file = $_POST['file'];
			$filetype = $_POST['filetype'];		
			if ($file){ 
				$file = $this->uploadImage($file, $filetype);
			}
			if (!$tags || !$article || !$title){			
				$_POST['error'] = 'Woops! Error please input all the fields to continue';
				return;
			} else {				
				if (!$date){
					$date = Date('Y-m-d');
				}		
				$article =  preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $article);
				$this->db->insertPost($date, $tags, $article, $title, $writer, $file);				
			}				
		}
		
		function editAboutPage(){
			//edit the about page.... and insert it, into the database...
			$ckeditor = $_POST['ckeditor'];			
			if ($ckeditor && strlen($ckeditor) > 5){
				$this->db->editAboutPage($ckeditor);
			} else {
				$_POST['error'] = 'Please fill in everything!';
			}
		}
		
		function updateSetPosts(){
			//sets the posts for the database
			$id = $_GET['setID'];
			$pos = $_GET['pos'];
			if (is_numeric($id)){
				$this->db->updateImageViewer($id, $pos);
			}		
		}
		
		function deleteArticle(){
			//delete article
			$id = $_POST['id'];
			$this->db->deleteArticle($id);		
		}
		
		function uploadImage($file, $mime_type){
			//the base of uploading an image, and resizing an image...
			$file = str_replace(' ', '+', $file);
			$file = base64_decode($file);
			$dateY = date('Y');			
			$dateM = date('m');
			$dateD = date('d');
			$folder = CONTENT . '/usercontent/' . $dateY . '/' . $dateM . '/' . $dateD .'/';		
			$relative = 'usercontent/' . $dateY . '/' . $dateM . '/' . $dateD .'/';
			$fileName = $folder . time();
			$thumbFolder = $folder.'/thumb/';
			$mobileFolder = $folder . '/mobile/';
			$fileExt = $_POST['fileExt'];
			if (!file_exists($folder)){
				if (!(mkdir($folder, 0777, true))){
					die('{"error": "true", "reason": "couldn\'t create dir"}');
					exit;			
				}
			}		
			
			if (!file_exists($thumbFolder)){
				if (!(mkdir($thumbFolder, 0777, true))){							
					die('{"error": "true", "reason": "couldn\'t create dir"}');
					exit;
				}
			}	
			
			if (!file_exists($mobileFolder)){
				if (!(mkdir($mobileFolder, 0777, true))){							
					die('{"error": "true", "reason": "couldn\'t create dir"}');
					exit;
				}
			}

			
			
			$mime_type = str_replace('image/', '', $mime_type);
			$fileExt = $mime_type;
			
		
			
			if (file_put_contents(($fileName.'.'.$fileExt), $file)){ 
				//saves the file, and then resizes that save file
				include('classes/resize.php');
				//for the thumbnail
				$name = time();
				$image = new ResizeImage(($fileName  . '.' .$fileExt));
				$image->resizeTo(128, 128);
				$image->saveImage(($thumbFolder . $name . '.' .$fileExt));
				
				//for the cover image.... 
				$image = new ResizeImage(($fileName . '.' .$fileExt)); 
				$image->resizeTo(900, 400);
				$image->saveImage(($fileName . '.' .$fileExt));	
				
				//for the mobile image.... 
				$image = new ResizeImage(($fileName . '.' .$fileExt)); 
				$image->resizeTo(480, 0, 'maxwidth');
				$image->saveImage(($mobileFolder . $name .'.' .$fileExt));	
				
				$relativeThumb = $relative . '/thumb/' .( $name . '.' .$fileExt );
				$relativeMobile = $relative . '/mobile/' .( $name . '.' .$fileExt );
				
				$relative = $relative . ( $name . '.' .$fileExt );
				
				
				
				return Array(
					'image' => ($fileName . '.' .$fileExt),
					'thumb' => ($thumbFolder . $name . '.' .$fileExt),
					'mobile' => ($mobileFolder . $name .'.' .$fileExt),
					'mobileRelative' => $relativeMobile,
					'relativeThumb' => $relativeThumb,
					'relative' => $relative
				);
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
			$file = $_POST['file'];
			$filetype = $_POST['filetype'];
			
			if ($file){ 
				$file = $this->uploadImage($file, $filetype);
			}
			
			if (!$tags || !$article || !$title){			
				$_POST['error'] = 'Woops! Error please input all the fields to continue';
				return;
			} else {				
				if (!$date){
					$date = Date('Y-m-d');
				}			
				$this->db->insertEditPost($date, $tags, $article, $title, $writer, $id, $file);				
			}				
		}
		
		function getPostByID(){
			//this function will just get the id from the url using $_GET and then query the database and return the results.
			$id = $_GET['id'];
			$id = strip_tags(stripslashes($id));
			return $this->db->getpostBYID($id);
		}
		
		function processAjaxUpload(){
			//this will upload the image, and echo out the result for ckeditor to add it to the current work article, for the user to resize and move around.
			$data = json_decode($_POST['data'], true);
			$image = $data['imageRes']; //we use this one as its already set up, if it doesn't work we will use the actual image....
			$actualImage = $data['actualImage'];
			$imgType = $data['type'];
			$image = str_replace(' ', '+', $image);
			$file = base64_decode($image);
			//now lets get where we are going to save it :)
			$dateY = date('Y');			
			$dateM = date('m');
			$dateD = date('d');
			$folder = CONTENT . '/usercontent/' . $dateY . '/' . $dateM . '/' . $dateD .'/';
			if (!file_exists($folder)){
				if (!(mkdir($folder, 0777, true))){
					die('{"reponse": "failed", "error": "failed to make directory"}');
					exit;
				}
			}			
			$fileExt = '';
			switch ($imgType){
				case "image/png":
					$fileExt = 'png';
					break;
				case "image/jpeg":
					$fileExt = 'jpg';
					break;
				case "image/jpg":
					$fileExt = 'jpg';
					break;
				case 'image/gif':
					$fileExt = 'gif';
					break;
				default: 
					echo '{"response": "failed", "error": "Image type not supported"}';
					exit;			
			}
			$fileNam = time();
			if (file_exists($folder . $fileNam . '.'. $fileExt)){
				//file exsits...
				$random = rand(0, 50);
				$fileNam . $random;
				if (!file_exists($folder . $fileNam .'.'. $fileExt)){
					if (file_put_contents($folder.$fileNam.'.'.$fileExt)){
						echo '{"reponse": "success", "relativePath": "' . (WEBSITE_UPLOAD . '/usercontent/' . $dateY . '/' . $dateM . '/' . $dateD .'/' . $fileNam.'.'.$fileExt ) . '", "filename": "' . $folder.$fileNam.'.'.$fileExt .'"}';
						exit;
					}
				}
			} else {		
				if (file_put_contents(($folder.$fileNam.'.'.$fileExt), $file)){
					echo '{"reponse": "success", "relativePath": "' . (WEBSITE_UPLOAD . '/usercontent/' . $dateY . '/' . $dateM . '/' . $dateD .'/' . $fileNam.'.'.$fileExt ) . '", "filename": "' . $folder.$fileNam.'.'.$fileExt .'"}';
					exit;
				}
			}
			exit;		
		}
		
		
		function submitEdit(){
			//submits and edit for a user profile
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