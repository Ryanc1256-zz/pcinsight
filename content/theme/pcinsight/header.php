<!doctype html>
<html>
	<head>
		<title><?php echo $info->getPageInfo()['title']; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $themePath; ?>" />
	</head>		
	<body>
		<nav id="topbar">
			<?php $config->registerMainNav(); ?>
		</nav>
	