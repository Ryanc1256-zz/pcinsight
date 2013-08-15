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
    'AuthenticationFailed' => 'Sorry, you entered an incorrect username or password.<br />'
  );
  $username = '';
  $email = '';

	//is social network?
  if (empty($_GET['socialnetwork']))
  {
		//check if username and password post datas are back...
	  if (empty($_POST['email']))
	  {
			returnResult('errorEmail');
	  } else {
	    $email = $_POST['email'];
	  }
	  if (empty($_POST['password']))
	  {
			returnResult("errorPassword");
	  } 

		//so now we have the password and username working fine...
		
		require_once('required/PasswordHash.php');
		$hash_cost_log2 = 8;
		// Do we require the hashes to be portable to older systems (less secure)?
		$hash_portable = FALSE;


		$staff = '0';
		$hash = '*';
		($stmt = $db->prepare('Select password, editor, UserID FROM users WHERE email = ?'))|| fail('MySQL prepare', $db->error);
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
		
		$db->close();
		returnResult($what);
	}
	else
	{
		if ($_GET['socialnetwork'] == "true")
		{
		  if (empty($_POST['email']))
		  {
			returnResult('errorEmail');
		  } else {
		    $email = $_POST['email'];
		  }
		  if (empty($_POST['password']))
		  {
			returnResult("errorPassword");
		  } 

			//so now we have the password and username working fine...		
			$staff = '0';
			($stmt = $db->prepare('Select staff, UserID FROM users WHERE email = ?'))|| fail('MySQL prepare', $db->error);
			$stmt->bind_param('s', $_POST['email'])|| fail('MySQL bind_param', $db->error);
			$stmt->execute()|| fail('MySQL execute', $db->error);	
			$stmt->bind_result($staff, $id)|| fail('MySQL bind_result', $db->error);
			if (!$stmt->fetch() && $db->errno)
				fail('MySQL fetch', $db->error);
			
			session_start();
			$_SESSION['email'] = $_POST['email'];		
			$_SESSION['staff'] = $staff;
			$_SESSION['UserID'] = $id;
			$db->close();	
			returnResult('AuthenticationSucceeded');
		}	
	}
	
	function returnResult($message) {
	    if (isset($_POST['ajax'])) {
		echo $message;
		exit;
	    } else {
		if ($message == 'AuthenticationSucceeded') {
			header('Location: ../index.php');
			exit;
		} else {
			
			global $errorMessages;
			global $email;
			$msg = $errorMessages[$message];
			header("Location: ../login.php?error=$msg&email=$email");
			exit;
		}
	    }
	}
	
		
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