<?php


//require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once dirname(dirname(__DIR__)) . "/lib/connect-to-mysql.php";
require_once dirname(dirname(__DIR__)) . "/classes/autoloader.php";


/**
 * controller/api for the users class
 *
 * @author Derek Mauldin
 **/


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

	//sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	//handle REST calls
	if($method === "GET") {
		//set XSRF cookie
		//	setXsrfCookie("/");

		//sanitize and trim the other fields
		$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL);
		$userName = filter_input(INPUT_GET, "userName", FILTER_SANITIZE_STRING);
		$activationKey = filter_input(INPUT_GET, "activationKey", FILTER_SANITIZE_STRING);


		//get the user or users based on the given field
		if(empty($id) === false) {
			$user = Users::getUserById($pdo, $id);
			if($user !== null) {
				$reply->data = $user;
			}
		} else if(empty($email) === false) {
			$user = Users::getUserByEmail($pdo, $email);
			if($user !== null) {
				$reply->data = $user;
			}
		} else if(empty($userName) === false) {
			$user = Users::getUserByUserName($pdo, $userName);
			if($user !== null) {
				$reply->data = $user;
			}
		} else if(empty($activationKey) === false) {
			$user = Users::getUserByActivationKey($pdo, $activationKey);
			if($user !== null) {
				$reply->data = $user;
			}
		} else {
			$users = Users::getAllUsers($pdo);
			if($users !== null) {
				$reply->data = $users->toArray();
			}
		}
	}


	if($method === "PUT") {
		
	//	verifyXsrf();
		
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure all necessary fields are present
		if(empty($requestObject->userName) === false) {
			$userName = $requestObject->userName;
		} else {
			$userName = null;
		}
		if(empty($requestObject->email) === false) {
			$email = $requestObject->email;
		} else {
			$email = null;
		}


		//perform the put or post

		if(($userName === null) && ($email === null)) {
			throw (new InvalidArgumentException("Cannot update username or email.  Fields received are empty.", 405));
		}
		
		$user = Users::getUserById($pdo, $id);
		if($user === null) {
			throw(new RuntimeException("User does not exist", 404));
		}

		if ($userName !== null) {
			$user->setUserName($userName);
		} else {
			$user->setEmail($email);
		}
		$user->update($pdo);

		$reply->message = "User updated OK";

	} else if($method === "DELETE") {
		//verifyXsrf();

		$user = Users::getUserById($pdo, $id);
		if($user === null) {
			throw(new RuntimeException("User does not exist", 404));
		}

		$user->delete($pdo);

		$reply->message = "User deleted OK";
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);