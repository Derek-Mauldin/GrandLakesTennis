<?php
//require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once dirname(dirname(__DIR__)) . "/lib/connect-to-mysql.php";
require_once dirname(dirname(__DIR__)) . "/lib/date-util.php";
require_once dirname(dirname(__DIR__)) . "/classes/autoloader.php";


/**
 * API for the CourtReservations class
 *
 * @author Derek Mauldin
 **/

// Verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// Prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Grab the mySQL connection
	$pdo = connectToMySQL();

	// Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// Sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	// Make sure the id is valid for methods that require it
	if(($method === "DELETE" ) && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// Sanitize and trim the rest of the inputs
	$teamName = filter_input(INPUT_GET, "teamName", FILTER_SANITIZE_STRING);
	$resDateTime = filter_input(INPUT_GET, "resDateTime", FILTER_SANITIZE_STRING);
	$courts = filter_input(INPUT_GET, "courts", FILTER_SANITIZE_STRING);
	$resType = filter_input(INPUT_GET, "resType", FILTER_SANITIZE_STRING);

	// Handle all restful calls
	if($method === "GET") {
		// Set XSRF cookie
	//	setXsrfCookie("/");

		// Get the reservation based on given
		if(empty($id) === false) {
			$reservation = CourtReservations::getReservationById($pdo, $id);
			if($reservation !== null) {
				$reply->data = $reservation;
			}
		} else if(empty($teamName) === false) {
			$reservations = CourtReservations::getReservationsByTeamName($pdo, $teamName);
			if($reservations !== null) {
				$reply->data = $reservations;
			}
		} else if(empty($resDateTime) === false) {
			$reservations = CourtReservations::getReservationsByDate($pdo, $resDateTime);
			if($reservations !== null) {
				$reply->data = $reservations;
			}
		} else {
			$reservations = CourtReservations::getAllReservations($pdo);
			$reply->data = $reservations;
		}

	} else if($method === "POST") {

		// Set XSRF cookie
		//verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// Make sure all fields are present, in order, to prevent database issues
		if(empty($requestObject->teamName) === true) {
			throw(new InvalidArgumentException ("Team Name cannot be empty.", 405));
		}
		if(empty($requestObject->resDate) === true) {
			throw(new InvalidArgumentException ("Reservation Date cannot be empty.", 405));
		}
		if(empty($requestObject->resTime) === true) {
			throw(new InvalidArgumentException ("Reservation Time cannot be empty.", 405));
		}
		if(empty($requestObject->courts) === true) {
			throw(new InvalidArgumentException ("Court cannot be empty", 405));
		}
		if(empty($requestObject->resType) === true) {
			throw(new InvalidArgumentException ("Court cannot be empty", 405));
		}

		// work with resDate and resTime to create a datetime object
		// separate date into components
		if((preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $requestObject->resDate, $matches)) !== 1) {
			throw(new InvalidArgumentException("date is not a valid date"));
		}
		$month    = intval($matches[1]);
		$day  = intval($matches[2]);
		$year	  = intval($matches[3]);

		// separate time into components
		if((preg_match("/^(\d{2}):(\d{2})$/", $requestObject->resTime, $matches)) !== 1) {
			throw(new InvalidArgumentException("time is not a valid time"));
		}
		$hour   = intval($matches[1]);
		$minute = intval($matches[2]);
		$second = '00';

		// create date time object
		$resDateTime = $year . "-" . $month . "-" . $day . " " . $hour . ":" . "$minute" . ":" . $second;
		$resDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $resDateTime);
		$resDateTime = validateDate($resDateTime);

		// get reservations by date and court
		$currentReservations = CourtReservations::getResByDateAndCourt($pdo, $resDateTime, $requestObject->courts);

		// do only if there is a reservation for this court on this day
		if($currentReservations !== null) {
			$currentReservations = $currentReservations->toArray();

			// check if there is overlap with another reservation on this court
			foreach($currentReservations as $cRes) {

				// get current reservation start time and setup its end time
				$currentResStart = $cRes->getResDateTime();
				$currentResEnd = clone $currentResStart;
				$currentResEnd->add(new DateInterval('PT2H'));

				// get desired reservation start time and setup its end time
				$desiredResStart = clone $resDateTime;
				$desiredResEnd = clone $desiredResStart;
				$desiredResEnd->add(new DateInterval('PT2H'));

				// check for overlap
				if((($desiredResStart < $currentResEnd) && ($desiredResEnd > $currentResStart))) {
					throw(new RangeException("The requested reservation overlaps with another reservation", 405));
				}

			}
		}

		$verifiedRes = new CourtReservations(null, $requestObject->teamName, $resDateTime->format("Y-m-d H:i:s"), $requestObject->courts, $requestObject->resType);
		$verifiedRes->insert($pdo);

		// Update reply
		$reply->message = "Reservation Created";


		} else if($method === "DELETE") {
			//verifyXsrf();

			// Retrieve the brewery to be deleted
			$reservation = CourtReservations::getReservationById($pdo, $id);

			if($reservation === null) {
				throw(new RuntimeException("Reservation does not exist.", 404));
			}

			// Delete Reservation
			$reservation->delete($pdo);

			// Update reply
			$reply->message = "Reservation deleted";

		} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}

	// Update reply with exception information
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

// Encode and return reply to front end caller
echo json_encode($reply);