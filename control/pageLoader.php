<?php
	/* 
		This script determins what file is loaded as the main page, it also sorts out what page is to be displayed to the user 
	*/			
	if (PAGEURL == '/admin/adminLogin' || PAGEURL == '/adminLogin' || PAGEURL == 'admin/login.php')
	{
		include('/admin/login.php');
		define('allowedToMove', false);
	}
	else
	{
		//this will determin the page and check the database for the page names and find the right scripts for what... and then pass them off to the contentLoader
		define('allowedToMove', true);
	
	}