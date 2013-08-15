<?php
	require_once('required/login.php');
	$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($db))
   {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   
   $errorMessages = array(
     'errorPassword' => 'You must supply a password.<br />',
     'errorUsername' => 'You must supply a username.<br />',
     'errorEmail' => 'You must supply an email address.<br />',
     'errorRepassword' => 'You must re-enter your password.<br />',
     'errorPassMatch' => 'The passwords do not match.<br />',
     'errorHash' => 'Sorry, there was a problem storing your password.<br />',
     'emailTaken' => 'Sorry, that email address is unavailable.<br />',
     'usernameTaken' => 'Sorry, that username is unavailable.<br />',
     'usernameEmailTaken' => 'Both the username and email specified are unavailable. Did you intend to log in?<br />'
   );
   $username = '';
   $email = '';
   //check if username and password post datas are back...
   if (empty($_POST['username']))
   {
      returnResult('errorUsername');
   } else {
    $username = $_POST['username'];
   }
   if (empty($_POST['email']))
   {
      returnResult('errorEmail');
   } else {
    $email = $_POST['email'];
   }
   
   

	//so now we have the password and username working fine...
	
	require_once('required/PasswordHash.php');
	
	$hash_cost_log2 = 8;
		// Do we require the hashes to be portable to older systems (less secure)?
	$hash_portable = FALSE;

	//now we check if the email address is been used before...
	
	($stmt = $db->prepare('SELECT * FROM users WHERE email=?'))|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $email)|| fail('MySQL bind_param', $db->error);
	$stmt->execute()|| fail('MySQL execute', $db->error);
	$stmt->store_result()|| fail('MySQL store_result', $db->error);
	($stmt2 = $db->prepare('SELECT * FROM users WHERE username=?'))|| fail('MySQL prepare', $db->error);
	$stmt2->bind_param('s', $username)|| fail('MySQL bind_param', $db->error);
	$stmt2->execute()|| fail('MySQL execute', $db->error);
	$stmt2->store_result()|| fail('MySQL store_result', $db->error);
	if ($stmt->num_rows === 0 && $stmt2->num_rows === 0) {
		//username hasn't been taken yet...
		
		if (empty($_POST['password']))
		{
		  returnResult('errorPassword');
		}
		if (!isset($_POST['ajax'])) {
		  if (empty($_POST['repassword'])) {
		    returnResult('errorRepassword');
		  } elseif ($_POST['repassword'] != $_POST['password']) {
		    returnResult('errorPassMatch');
		  }
		}
    
		$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
		$hash = $hasher->HashPassword($_POST['password']);
		if (strlen($hash) < 20)
			returnResult('errorHash');
		unset($hasher);
		
		$id = generateRandomString(); //generate a random key
		
		($stmt = $db->prepare('INSERT INTO users (username, password, email, staff, socialnetwork, idGen) values (?, ?, ?, false, false, ?)'))|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ssss', $username, $hash, $email, $id)|| fail('MySQL bind_param', $db->error);
		$stmt->execute()|| fail('MySQL execute', $db->error);
		
		date_default_timezone_set('Pacific/Auckland');

		$to = $email;
		$subject = 'Pcinsight register';
		$headers = "From: admin@pcinsight.co.nz \r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = '<html><body style="background: #eee;border: 1px solid #f1f1f1">';
		$message .= '<div style="background: #000; height: 60px;padding: 6px;"><img style="float:left;" src="http://linuxuser.heliohost.org/pcinsight/images/logo.png" height="60" /><h2 style="color:#fff; float:left; margin-left: 30px;"> PCinsight </h2></div>';
		$message .= '<div style="height: 100px; text-align: center;"><p> Please click <a href="http://linuxuser.heliohost.org/pcinsight/?activate='.$id.'">Here</a> to finish the registration process</p><p style="color: #726F6F;">Copyright PCinsight '.Date('Y').'</p></div>';
		$message .= "</body></html>";
		mail($to, $subject, $message, $headers);	
		returnResult('done');
		
	} elseif ($stmt->num_rows === 0 /* && $stmt2->num_rows !== 0*/) {
	  //username in use
	  returnResult('usernameTaken');
	} elseif (/*$stmt->num_rows !== 0 && */ $stmt2->num_rows === 0) {
	  //email in use
	  returnResult('emailTaken');
	} else {
	  //email and username in use... Do you mean to log in?
	  returnResult('usernameEmailTaken');
	}

	function returnResult($message) {
	    if (isset($_POST['ajax'])) {
		echo $message;
		exit;
	    } else {
		if ($message == 'done') {
			header('Location: ../index.php');
			exit;
		} else {
			
			global $errorMessages;
			global $username;
			global $email;
			$msg = $errorMessages[$message];
			header("Location: ../register.php?error=$msg&username=$username&email=$email");
			exit;
		}
	    }
	}
	
	function generateRandomString($length = 20) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	// Are we debugging this code?  If enabled, OK to leak server setup details.
	$debug = false;

	function fail($pub, $pvt = '')
	{
		global $debug;
		$msg = $pub;
		if ($debug && $pvt !== '')
			$msg .= ": $pvt";
		exit("An error occurred ($msg).\n");
	}
?>