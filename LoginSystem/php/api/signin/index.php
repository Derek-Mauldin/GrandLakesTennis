<?php

//require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once dirname(dirname(__DIR__)) . "/lib/connect-to-mysql.php";
require_once dirname(dirname(__DIR__)) . "/lib/date-util.php";
require_once dirname(dirname(__DIR__)) . "/classes/autoloader.php";


/**
 * api for signing in
 *
 *
 * @author Derek Mauldin <derek.mauldin@gmail.com>
 **/

//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	//grab the mySQL connection
	$pdo = connectToMySQL();

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//perform the actual POST
	if($method === "POST") {
		//verifyXsrf();

		// convert JSON to an object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check that username and password fields have been filled, and sanitize
		if(empty($requestObject->username) === true) {
			throw(new \InvalidArgumentException("Must enter a username", 405));
		} else {
			$username = filter_var($requestObject->username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if (empty($requestObject->password) === true) {
			throw(new \InvalidArgumentException ("Must enter a password", 405));
		} else {
			$password = filter_var($requestObject->password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		//create the user
		$user = Users::getUserByUserName($pdo, $username);

		//if the user doesn't exist, throw an exception
		if(empty($user)) {
			throw (new \InvalidArgumentException("Username or password is incorrect", 401));
		}

		//if they have an activation token, the account is not activated yet
		if($user->getActivKey() !== null) {
			throw(new \InvalidArgumentException("Account has not been activated yet, please see your email to activate", 401));
		}

		//get the hash
		$hash =  hash_pbkdf2("sha512", $password, $user->getUserSalt(), 262144);

		//check the hash against inputted data-- no match, throw exception
		if($hash !== $user->getHash()) {
			throw(new \InvalidArgumentException("Username or password is incorrect", 401));
		}

		$user->unsetHash();
		$user->unsetSalt();
		$_SESSION["user"] = $user;

		$reply->data = $_SESSION["user"];
		$reply->message = "Successfully logged in!";  //ToDo

	} else {
		throw (new \InvalidArgumentException("Invalid HTTP method request"));
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");

// encode and return reply to front end caller
echo json_encode($reply);