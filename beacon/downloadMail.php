<?php

// hide all basic notices from PHP
error_reporting(E_ALL ^ E_NOTICE); 

if( isset($_POST['msg-submitted']) ) {
	$udid = $_POST['udid'];
	$email = $_POST['email'];

	// server validation
	if( trim($udid) === '' ) {
		$nameError = 'Please provide your UDID.';
		$hasError = true;
	}

	if( trim($email) === '' ) {
		$emailError = 'Please provide your email address.';
		$hasError = true;
	} else if( !preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($email)) ) {
		$emailError = 'Please provide valid email address.';
		$hasError = true;
	}
		
	if(!isset($hasError)) {
		
		$emailTo = 'sjoerd.smink@ns.nl';
		$subject = 'New UDID: ' . $email;
		$body = "UDID: $udid \n\nEmail: $email";
		$headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		
		$message = 'Thank you ' . $name . ', your message has been submitted.';
		$result = true;
	
	} else {

		$arrMessage = array( $nameError, $emailError, $messageError );

		foreach ($arrMessage as $key => $value) {
			if( !isset($value) )
				unset($arrMessage[$key]);
		}

		$message = implode( '<br/>', $arrMessage );
		$result = false;
	}

	header("Content-type: application/json");
	echo json_encode( array( 'message' => $message, 'result' => $result ));
	die();
}


?>