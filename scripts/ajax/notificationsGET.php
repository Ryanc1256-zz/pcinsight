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
		$array[$e]['type'] = "review";
		$array[$e]['message'] = "Please click here you have need to review a article";
		$array[$e]['id'] = $row['id'];
		$e++;
	}
	echo json_encode($array);
	
?>