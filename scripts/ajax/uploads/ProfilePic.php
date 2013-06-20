<?php	
	 session_start();
	 $uploaddir = 'images/';
	 $sendData = $_POST['Data'];
	
	$sendData = explode(',', $sendData);
	
	
	 $image = $sendData[2];	 
	 $image = str_replace('"}', '', $image);
     $encodedData = str_replace(' ','+',$image);
	 $decodedData = base64_decode($encodedData);
	 
	 
	
	 $name = str_replace('"}', '', $sendData[0]);
	 $name = str_replace(':', '', $name);
	 $name = str_replace('"', '', $name);
	 $name = str_replace('{name', '', $name);

	 $getMime = explode('.', $name);
	 $mime = end($getMime);
	 
	$randomName = substr_replace(sha1(microtime(true)), '', 12).'.'.$mime;
	

	if(file_put_contents($uploaddir.$randomName, $decodedData)) {
		//echo $randomName.":uploaded successfully";
		require_once('../../required/login.php');
		$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
		if (mysqli_connect_errno($con))
	   {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
	   }	   
	   $id = $_SESSION['UserID'];
	   $loc = '/pcinsight/scripts/ajax/uploads/images/'.$randomName;  
	   	($stmt = $db->prepare('UPDATE users SET userProfile=? WHERE UserID=?'))|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ss', $loc, $id)|| fail('MySQL bind_param', $db->error);
		$stmt->execute()|| fail('MySQL execute', $db->error);	
	   echo "worked!";
	   mysqli_close($db);
	}
	else {
		// Show an error message should something go wrong.
		echo "Something went wrong. Check that the file isn't corrupted";
	}
	
	function fail($msg)
	{
		echo $msg;
	}
 ?>