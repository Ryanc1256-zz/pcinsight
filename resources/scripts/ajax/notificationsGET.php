<?php
	//notifications
	$array = array();
	require_once('../required/login.php');
	$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno($con))
   {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }	
   $query = mysqli_query($db, "SELECT * FROM Articles WHERE editorsTick=0");
   $e = 0;
	while ($row = mysqli_fetch_array($query))
	{
		$email = $row['writer'];
		$newquery = "SELECT * FROM users WHERE email='".$email."'";		
		$pic = mysqli_query($db, $newquery);
		while ($rows = mysqli_fetch_array($pic)){			
			$array[$e]['pic'] = $rows['userProfile'];	
			if ($rows['email'] == $row['writer'])
			{
				$array[$e]['writer'] = $rows['username'];
			}
		}
		$array[$e]['type'] = "review";
		$array[$e]['message'] = "Please click here you have need to review a article from ".$array[$e]['writer'];
		$array[$e]['id'] = $row['id'];
		$e++;
	}
	echo json_encode($array);
	
?>