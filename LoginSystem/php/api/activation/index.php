<?php

//require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once dirname(dirname(__DIR__)) . "/lib/connect-to-mysql.php";
require_once dirname(dirname(__DIR__)) . "/lib/date-util.php";
require_once dirname(dirname(__DIR__)) . "/classes/autoloader.php";


/**
 * api for activation
 *
 * @author Derek Mauldin <derek.mauldin@gmail.com>
 */


//verify the xsrf challenge

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare a empty reply

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

//Grab MySQL connection
	$pdo = connectToMySQL();

//determine which http method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :$_SERVER["REQUEST_METHOD"];


	if($method === "GET") {
		//setXsrfCookie("/");

		//get the user by activation token
		$emailActivationToken = filter_input(INPUT_GET, "emailActivationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($emailActivationToken)) {
			throw(new \RangeException ("No ActivationToken Code"));
		}

		$user = Users::getUserByActivationKey($pdo, $emailActivationToken);
		if(empty($user)) {
			throw(new \InvalidArgumentException ("no user for activation token"));
		}

		$user->setActivKey(null);
		$user->update($pdo);

		$reply->message = "activation successful";

		// ToDo header("Location: ../../../")
	} else {
		throw(new \Exception("Invalid HTTP method"));
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
	header("Content-type: application/json");

} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
	$reply->trace = $typeError->getTraceAsString();
	header("Content-type: application/json");
}

echo json_encode($reply);