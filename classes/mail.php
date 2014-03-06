<?php
	class mail{
		function registerMail($to, $id){
			if ($to && filter_var($to, FILTER_VALIDATE_EMAIL) && $id){				
				$subject = 'PCInsight register';
				$headers = "From: admin@pcinsight.co.nz \r\n";		
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$message = '<html><body style="background: #eee;border: 1px solid #f1f1f1">';
				$message .= '<div style="background: #000; height: 60px;padding: 6px;"><img style="float:left;" src="'.LOGO.'" height="60" /><h2 style="color:#fff; float:left; margin-left: 30px;"> PCInsight </h2></div>';
				$message .= '<div style="height: 100px; text-align: center;"><p> Please click <a href="'.SITE_ADDRESS_ACTIVE.'&id='.$id.'">Here</a> to finish the registration process</p><p style="color: #726F6F;">Copyright PCinsight '.Date(Y).'</p></div>';
				$message .= "</body></html>";
				mail($to, $subject, $message, $headers);
			}
		}
		
		function lostPassword($to, $id){
				if ($to && filter_var($to, FILTER_VALIDATE_EMAIL) && $id){				
				$subject = 'password recovery';
				$headers = "From: admin@pcinsight.co.nz \r\n";		
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$message = '<html><body style="background: #eee;border: 1px solid #f1f1f1">';
				$message .= '<div style="background: #000; height: 60px;padding: 6px;"><img style="float:left;" src="'.LOGO.'" height="60" /><h2 style="color:#fff; float:left; margin-left: 30px;"> PCInsight </h2></div>';
				$message .= '<div style="height: 100px; text-align: center;"><p> Please click <a href="'.SITE_ADDRESS_RECOVER.'&id='.$id.'">Here</a> to recover your password</p><p style="color: #726F6F;">Copyright PCinsight '.Date(Y).'</p></div>';
				$message .= "</body></html>";
				mail($to, $subject, $message, $headers);
			}		
		}
	
	}
?>