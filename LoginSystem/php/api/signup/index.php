<?php

//require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once dirname(dirname(__DIR__)) . "/lib/connect-to-mysql.php";
require_once dirname(dirname(__DIR__)) . "/lib/date-util.php";
require_once dirname(dirname(__DIR__)) . "/classes/autoloader.php";


/**
 * api for signup
 *
 * @author Derek Mauldin <derek.mauldin@gmail.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;


try {
	//grab the mySQL connection
	$pdo = connectToMySQL();

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	$reply->method = $method;

	if($method === "POST") {


		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		$reply->data = $requestObject;

		if(empty($requestObject->email) === true) {
			throw(new \InvalidArgumentException ("Must fill in email address", 405));
		} else {
			$email = filter_var($requestObject->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if(empty($requestObject->username) === true) {
			throw(new \InvalidArgumentException ("Must fill in valid user name", 405));
		} else {
			$username = filter_var($requestObject->username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if(empty($requestObject->password) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		} else {
			$password = filter_var($requestObject->password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if(empty($requestObject->retype_password) === true) {
			throw(new \InvalidArgumentException ("Must retype valid password", 405));
		} else {
			$retype_password = filter_var($requestObject->retype_password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if($password !== $retype_password) {
			throw(new \InvalidArgumentException ("Passwords do not match", 405));
		}

		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);
		$userActivationToken = bin2hex(random_bytes(16));

		$user = new Users(null, $username, $email, $userActivationToken, $salt, $hash);

		$user->insert($pdo);


			//send email for the user with password
		$url="http://www.grandlakestennis.com/LoginSystem";

		$to=$email;
		$from_address="admin@GrandLakesTennis.com";
		$subject="New Registration -- Grand Lakes Tennis";
		$body="Hi ".$username.
			"<br /> Thanks for your registration.<br />".
			"Click the link below to activate your account<br />".
			"<a href=" . $url . "/php/api/activation/index.php?emailActivationToken" . $userActivationToken . "\"> Activate Account </a>";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From:". $from_address . "\r\n";;

		mail($to,$subject,$body,$headers);
		$reply->data = $userActivationToken;

		//ToDo: add relocation

	} else{
		throw (new InvalidArgumentException("invalid http request"));
	}


}catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}


header("Content-type: application/json");
echo json_encode($reply);