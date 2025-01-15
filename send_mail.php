<?php

$webmaster_email = "oxymoronsgj@gmail.com";
$contact_page = "contact.html";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";
$email = $_REQUEST['Email'] ;
$message = $_REQUEST['Message'] ;
$first_name = $_REQUEST['Name'] ;
$msg = 
"Name: " . $name . "\r\n" . 
"Email: " . $email . "\r\n" . 
"Message: " . $message ;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['Email'])) {
header( "Location: $contact_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($name) || empty($email)) {
header( "Location: $error_page" );
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email) || isInjected($name)  || isInjected($message) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Feedback Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>