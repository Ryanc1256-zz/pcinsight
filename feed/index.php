<?php
	include ('../../config.php');
	include ('../classes/database.php');	
	
	class rss {
		private $db;
		private $xml;
		function __construct(){			
			$this->db = new db();
			$this->xml = new DOMDocument('1.0', 'UTF-8');			
			$this->displayRSS();			
		}
		
		private function constructRss(){	
			//this actuallt constructs the rss feed.... 
			$rss = $this->xml->createElement('rss');	
			$rss->setAttribute('version', '2.0');		
			
			$this->xml->appendChild($rss);	
			
			$channel = $this->xml->createElement('channel');
			$rss->appendChild($channel);
			
			$title = $this->xml->createElement('title', 'PCINSIGHT ARTICLES');
			$link = $this->xml->createElement('link', WEBSITE_NAME);
			$description = $this->xml->createElement('description', RSS_DESCRIPTION);		
			
			$channel->appendChild($title);
			$channel->appendChild($link);
			$channel->appendChild($description);
			
			$this->getContent($channel);	
		}
		
		function getContent($channel){
			//this function will add all the posts to the rss feed...
			$rs = $this->db->getAllPosts();			
			for ($i = 0; $i < count($rs); $i++){
				$item = $this->xml->createElement('item');	
				$channel->appendChild($item);
				
				$title = $this->xml->createElement('title', $this->escapeSpecial($rs[$i]['postTitle']));
				$description = $this->xml->createElement('description', $rs[$i]['postContent']);	
				$link = $this->xml->createElement('link', 'index.php?p=6&amp;post='.$rs[$i]['postID']);	
				
				$item->appendChild($title);			
				$item->appendChild($link);				
				$item->appendChild($description);				
			}			
		}
		
		function displayRSS(){	
			header("content-type: text/xml"); //makes it seem like it's an xml page
			$this->constructRss();
			$this->xml->formatOutput = true;			
			echo $this->xml->saveXML(); //displays the rss feed
		}
		
		public function escapeSpecial($string){
			//removes the silly "error" tags
			$string = strip_tags(stripslashes($string));			
			$string = str_replace('"', '&#34;', $string);
			$string = str_replace("'", '&#39;', $string);
			$string = str_replace("&", '&amp;', $string);		
			return $string;
		}
	
	}
	
	new rss();

?>