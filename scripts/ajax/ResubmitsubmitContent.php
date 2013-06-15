<?php
	if (empty($_POST['message']))
	{
		echo "NoMessage";
		exit;
	}
	
	session_start();
	
	//hmmm.... so we have the data now, we can check it...
	
	$message = $_POST['message'];
	$email = $_SESSION['email'];
	
	if (strlen($message) < 1)
	{
		echo "NoMessageContent";
		exit;
	}
	
	if (strlen($_POST['title']) < 1)
	{
		echo "NoTitleContent";
		exit;
	}
	
	$title = $_POST['title'];
	//now we can just submit it to the server...
	
	require_once('../required/login.php');
	$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($con))
   {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   $date = date('d/m/y');  
   $id = $_POST['id'];
   ($stmt = $db->prepare("UPDATE Articles SET articletext=?, editorsTick=1, title=? WHERE id=$id"))|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ss', $message, $title)|| fail('MySQL bind_param', $db->error);
		$stmt->execute()|| fail('MySQL execute', $db->error);
	
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