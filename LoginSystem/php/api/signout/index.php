<?php

//require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once dirname(dirname(__DIR__)) . "/lib/connect-to-mysql.php";
require_once dirname(dirname(__DIR__)) . "/lib/date-util.php";
require_once dirname(dirname(__DIR__)) . "/classes/autoloader.php";


/**
 * api for signout
 *
 * @author Derek Mauldin <derek.mauldin@gmail.com>
 **/

//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToMySQL();


	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	if($method === "GET"){
		if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		$_SESSION = [];
		$reply->message = "You are now signed out";
	}
	else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);
