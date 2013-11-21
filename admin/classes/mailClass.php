<?php
	class mail {
		public function lostPass($key, $to){
			//this is the email function that will email the user and email on how to recover their password...
			//it will send them a 'key' as a link and it will take them to a password recovery page that will check that key...
			$from = 'noreply@' . EMAIL_NAME;
			$message = '';
			$subject = 'Thank\'s for submiting to recover your password...';
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			mail($to, $subject, $message, $headers);
		}	
	}
?>