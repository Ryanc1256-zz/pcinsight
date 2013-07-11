<?php
	require_once('required/login.php');
	$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($con))
   {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   
   //check if username and password post datas are back...
   if (empty($_POST['password']))
   {
		echo "errorPassword";
		exit;
   }
   
   if (empty($_POST['username']))
   {
		echo "errorUsername";
		exit;
   }
   if (empty($_POST['email']))
   {
		echo "errorEmail";
		exit;
   }
   
   

	//so now we have the password and username working fine...
	
	require_once('required/PasswordHash.php');
	
	$hash_cost_log2 = 8;
		// Do we require the hashes to be portable to older systems (less secure)?
	$hash_portable = FALSE;

	//now we check if the email address is been used before...
	
	($stmt = $db->prepare('SELECT * FROM users WHERE email=?'))|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $_POST['email'])|| fail('MySQL bind_param', $db->error);
	$stmt->execute()|| fail('MySQL execute', $db->error);
	$stmt->store_result()|| fail('MySQL store_result', $db->error);
	if ($stmt->num_rows === 0){	
		//username hasn't been taken yet...
		$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
		$hash = $hasher->HashPassword($_POST['password']);
		if (strlen($hash) < 20)
			echo 'FailedToHashPassword';
		unset($hasher);
		
		$id = generateRandomString(); //generate a random key
		
		($stmt = $db->prepare('INSERT INTO users (username, password, email, staff, socialnetwork, idGen) values (?, ?, ?, false, false, ?)'))|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ssss', $_POST['username'], $hash, $_POST['email'], $id)|| fail('MySQL bind_param', $db->error);
		$stmt->execute()|| fail('MySQL execute', $db->error);
		
		
		$to = $_POST['email'];
		$subject = 'Pcinsight register';
		$headers = "From: admin@pcinsight.co.nz \r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = '<html><body style="background: #eee;border: 1px solid #f1f1f1">';
		$message .= '<div style="background: #000; height: 60px;padding: 6px;"><img style="float:left;" src="http://linuxuser.heliohost.org/pcinsight/images/logo.png" height="60" /><h2 style="color:#fff; float:left; margin-left: 30px;"> PCinsight </h2></div>';
		$message .= '<div style="height: 100px; text-align: center;"><p> Please click <a href="http://linuxuser.heliohost.org/pcinsight/?activate='.$id.'">Here</a> to finish the registration process</p><p style="color: #726F6F;">Copyright PCinsight '.Date(Y).'</p></div>';
		$message .= "</body></html>";
		mail($to, $subject, $message, $headers);	
		echo 'done';
		
	}
	else
	{
		//we will tell the script that the email has been used before
		echo 'emailTaken';
		exit;
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