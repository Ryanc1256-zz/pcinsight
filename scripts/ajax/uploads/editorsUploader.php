<?php	
	 session_start();
	 $uploaddir = '/home/karl/public_html/pcinsight/images/uploads/editors/';
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
	   $loc = '/pcinsight/images/uploads/editors/'.$randomName;  
	   echo $loc;
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