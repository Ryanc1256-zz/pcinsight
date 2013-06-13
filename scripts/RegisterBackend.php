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
		

		($stmt = $db->prepare('INSERT INTO users (username, password, email, staff, socialnetwork) values (?, ?, ?, false, false)'))|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('sss', $_POST['username'], $hash, $_POST['email'])|| fail('MySQL bind_param', $db->error);
		$stmt->execute()|| fail('MySQL execute', $db->error);
	}
	else
	{
		//we will tell the script that the email has been used before
		echo 'emailTaken';
		exit;
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