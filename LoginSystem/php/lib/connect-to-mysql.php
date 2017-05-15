<?php



/**
 * connects to mySQL database
 *
 * @return PDO connection to mySQL
 **/
function connectToMySQL() {

	require_once dirname(dirname(__DIR__)) . "/db.php";

	// grab the encrypted mySQL properties file and create the DSN
	$dsn = "mysql:host=" . $server . ";dbname=" . $db_name;
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

	// create the PDO interface and return it
	$pdo = new PDO($dsn, $db_user, $db_pwd, $options);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return($pdo);
}

