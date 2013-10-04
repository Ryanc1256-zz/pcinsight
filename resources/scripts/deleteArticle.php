<?php
	session_start();
	if (isset($_SESSION['email']))
	{
		$ArticleId = $_GET['articleid'];
		require_once('../scripts/required/login.php');
		$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$query = mysqli_query($db, "DELETE FROM Articles WHERE id=$ArticleId");	
		mysqli_close($db);
	}
	header('location: ../StaffArea/articles.php');
?>