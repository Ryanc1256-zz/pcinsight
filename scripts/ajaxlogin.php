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
   
   if (empty($_POST['email']))
   {
		echo "errorUsername";
		exit;
   }

	//so now we have the password and username working fine...
	
	require_once('required/PasswordHash.php');
	$staff = '0';
	$hash = '*';
	($stmt = $db->prepare('Select password, staff, UserID FROM users WHERE email = ?'))|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $_POST['email'])|| fail('MySQL bind_param', $db->error);
	$stmt->execute()|| fail('MySQL execute', $db->error);	
	$stmt->bind_result($hash, $staff, $id)|| fail('MySQL bind_result', $db->error);
	if (!$stmt->fetch() && $db->errno)
		fail('MySQL fetch', $db->error);	
		
	$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
	if ($hasher->CheckPassword($_POST['password'], $hash)) {
		$what = 'AuthenticationSucceeded';
		session_start();
		$_SESSION['email'] = $_POST['email'];		
		$_SESSION['staff'] = $staff;
		$_SESSION['UserID'] = $id;		
	} else {
		$what = 'AuthenticationFailed';
	}
	unset($hasher);
	echo $what;
	
	$db->close();
	
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