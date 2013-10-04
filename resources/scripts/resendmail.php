<?php
		session_start();
		if (isset($_SESSION['email']))
		{		
			$id = generateRandomString();
			$to = $_SESSION['email'];
			$subject = 'Pcinsight register';
			$headers = "From: Admin@pcinsight.co.nz \r\n";		
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = '<html><body style="background: #eee;border: 1px solid #f1f1f1">';
			$message .= '<div style="background: #000; height: 60px;padding: 6px;"><img style="float:left;" src="http://linuxuser.heliohost.org/pcinsight/images/logo.png" height="60" /><h2 style="color:#fff; float:left; margin-left: 30px;"> PCinsight </h2></div>';
			$message .= '<div style="height: 100px; text-align: center;"><p> Please click <a href="http://linuxuser.heliohost.org/pcinsight/?activate='.$id.'">Here</a> to finish the registration process</p><p style="color: #726F6F;">Copyright PCinsight '.Date(Y).'</p></div>';
			$message .= "</body></html>";
			mail($to, $subject, $message, $headers);
			require_once('required/login.php');
			$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
			if ($db->connect_error)
			{
				echo "Failed to connect to MySQL: ";
			}			
			$userid = $_SESSION['UserID'];	
			$query = "UPDATE users SET idGen='".$id."' WHERE UserID=".$userid;
			$db->query($query) or die($db->error);			
			header('location: ../index.php');
		}
		else
		{
			//error prevention
			header('location: ../index.php');
		}
		
		function generateRandomString($length = 20) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}		
?>
