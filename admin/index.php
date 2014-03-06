<?php
	include ("classes/viewClass.php");	
	include ("../../config.php");	
	$pageInfo;
	session_start();
	if (!($_SESSION['username'])){
		header('location: ../index.php?p=2&return=admin&error=login');
	}
	if (isset($_GET['p'])){
		//page info...
		$pageInfo = $_GET['p'];
	} else {
		$pageInfo = 1;
	}
	switch ($pageInfo){
		case '1':
			include ('views/home.php'); //home page
			$page = new Page();
			break;
		case '2':
			include ('views/AllPosts.php'); //all posts
			$page = new Page();
			break;
		case '3':
			include ('views/PostsNew.php'); //newposts
			$page = new Page();
			break;		
		case '4':
			include ('views/users.php'); //users
			$page = new Page();
			break;		
		case '5':
			include ('views/editUser.php'); //edit users
			$page = new Page();
			break;
		case '6':
			include ('views/editPost.php'); //edit users
			$page = new Page();
			break;
		case '7':
			include ('views/setPosts.php'); //edit users
			$page = new Page();
			break;
		case '8':
			include ('views/deleteArticle.php'); //edit users
			$page = new Page();
			break;
		case '9':
			include ('views/editAboutPage.php'); //edit users
			$page = new Page();
			break;
		default: 
			include ('views/404.php'); //404 page
			$page = new Page();
			break;
	}
	if ($page){
		$page->displayPage();
	}
	
	
?>