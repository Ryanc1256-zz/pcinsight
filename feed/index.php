<?php
	include ('../../config.php');
	header("content-type: text/xml");
	echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
	echo "<rss>";
		echo "<title>PCinsight</title>";
		echo "<link>".WEBSITE_NAME."</link>";
		echo "<language>en-US</language>";
		echo "<message>Remember me this weekend</message>";
	echo "</rss>";

?>