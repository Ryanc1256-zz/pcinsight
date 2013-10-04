<?php
	session_start();
	$username = $_POST['username'];
	$email = $_POST['email'];
	
	require_once('../required/login.php');
	$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}	   
	if ($username)
	{
		($stmt = $db->prepare("UPDATE users SET username=? where username=?"))|| die('MySQL prepare'. $db->error);
		$stmt->bind_param('ss', $username, $username)|| die('MySQL bind_param'. $db->error);
		$stmt->execute()|| die('MySQL execute'. $db->error);
		$_SESSION['username'] = $username;
	}
	else if ($email)
	{
		($stmt = $db->prepare("UPDATE users SET email=? where email=?"))|| die('MySQL prepare'. $db->error);
		$stmt->bind_param('ss', $email, $email)|| die('MySQL bind_param'. $db->error);
		$stmt->execute()|| die('MySQL execute'. $db->error);
		$_SESSION['email'] = $email;
	}	
	
	echo "Worked!";
?>