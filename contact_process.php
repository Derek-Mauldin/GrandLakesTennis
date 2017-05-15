<?php session_start(); ?>
<?php
if(isset($_POST) ){
	
	//form validation vars
	$formok = true;
	$errors = array();
	
	//sumbission data
	date_default_timezone_set("America/Chicago");
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$date = date('d/m/Y');
	$time = date('H:i:s');
	
	//form data
	$name = $_POST['name'];	
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$message = $_POST['message'];
	
	//validate form data
	
	//validate name is not empty
	if(empty($name)) {
		$formok = false;
		$errors[] = "You have not entered a name";
	}
	
	//validate captcha 
	include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
	$securimage = new Securimage();
	
	if($securimage->check($_POST['captcha_code']) == false) {
		// the code was incorrect
			$formok = false;
			$errors[] = "The security code entered was incorrect or missing.  Please try again.";
		// or you can use the following code if there is no validation or you do not know how
		//echo "The security code entered was incorrect.<br /><br />";
		//echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
		//exit;
		}

	
	//validate email address is not empty
	if(empty($email)){
		$formok = false;
		$errors[] = "You have not entered an email address";
	//validate email address is valid
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$formok = false;
		$errors[] = "You have not entered a valid email address";
	}
	//validate contact person is chosen
	if(empty($contact)) {
		$formok = false;
		$errors[] = "You have not chosen who to send the email to";
	}
	//validate message is not empty
	if(empty($message)){
		$formok = false;
		$errors[] = "You have not entered a message";
	}
	//validate message is greater than 20 charcters
	elseif(strlen($message) < 20){
		$formok = false;
		$errors[] = "Your message must be greater than 20 characters";
	}
	
	switch($contact){
		case "More Information":
			$contactEmail = "smbrice4@comcast.net";
			break;
		case "Webmaster":
			$contactEmail = "debs_webs@sbcglobal.net";
			break;
		default:
			$contactEmail = "debs_webs@sbcglobal.net";
			break;
	}
	//send email if all is ok
	if($formok){
		$headers = "From: GrandLakesTennis.com" . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		$emailbody = "<p>You have received a new message from the enquiries form on your website.</p>
					  <p><strong>Name: </strong> {$name} </p>
					  <p><strong>Email Address: </strong> {$email} </p>
					  <p><strong>Message: </strong> {$message} </p>
					  <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";
		
		mail("$contactEmail","New Enquiry from Grand Lakes Tennis Website",$emailbody,$headers);
		
	}
	
	//what we need to return back to our form
	$returndata = array(
		'posted_form_data' => array(
			'name' => $name,
			'email' => $email,
			'message' => $message
		),
		'form_ok' => $formok,
		'errors' => $errors
	);
		
	
	//if this is not an ajax request
	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){
		//set session variables
		session_start();
		$_SESSION['cf_returndata'] = $returndata;
		
		//redirect back to form
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
}
