<?php
	include ("classes/viewClass.php");	
	include ("../config.php");	
	$pageInfo;
	session_start();
	//var_dump($_SESSION);
	if (isset($_GET['p'])){
		//page info...
		$pageInfo = $_GET['p'];
	} else {
		$pageInfo = 1;
	}
	
	switch ($pageInfo){
		case '1':
			include ('views/home.php'); 
			$page = new Page();
			break;
		case '2':
			include ('views/login.php');
			$page = new Page();
			break;
		case '3':
			include ('views/register.php'); 
			$page = new Page();
			break;
		case '4':
			include ('views/recover.php');//post categories
			$page = new Page();
			break;
		case '5':
			//logout
			session_destroy();
			unset($_SESSION);
			header('location: index.php');
			break;
		case '6':			
			include ('views/posts.php');//post page
			$page = new Page();
			break;
		case '7':			
			include ('views/search.php');//search page
			$page = new Page();
			break;
		case '8': 
			include ('views/tags.php');//tags page
			$page = new Page();
			break;
		case '9': 
			include ('views/articles.php');//articles
			$page = new Page();
			break;
		case '10':
			include ('views/about.php');//about page
			$page = new Page();
			break;
		case '11':
			include ('views/registerAccount.php');//register account page
			$page = new Page();
			break;
		case '12':
			include ('views/recoverAccount.php');//register account page
			$page = new Page();
			break;
		case '13':		
			include ('views/sendMessage.php');//register account page
			$page = new Page();
			break;
		case '14':		
			include ('views/accessKeys.php');//register account page
			$page = new Page();
			break;
		case '15':		
			include ('views/sitemap.php');//register account page
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