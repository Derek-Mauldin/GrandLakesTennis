<?php

require_once ("autoloader.php");
require_once dirname(__DIR__) . "/lib/connect-to-mysql.php";

class CourtReservations implements JsonSerializable {

	/**
	 * id for this reservation - it is the primary key
	 *
	 * @var int $resId ;
	 */
	private $resId;

	/**
	 * teamName
	 *
	 * @var string $teamName
	 */
	private $teamName;

	/**
	 * reservation Date and Time
	 *
	 * @var DateTime $dateTime
	 */
	private $dateTime;

	/**
	 * courts
	 *
	 * @var string $courts
	 */
	private $courts;

	/**
	 * reservation type
	 *
	 * @var string $resType
	 */
	private $resType;


	/**
	 * @param int|null $newResID id of this reservation or a new reservation
	 * @param string $teamName
	 * @param DateTime|string $newDateTime date and time of reservation
	 * @param string $courts
	 * @param string $resType
	 * @throws InvalidArgumentException if the data types are not valid
	 * @throws RangeException if data values are out of bounds
	 * @throws TypeError if data types violate type hints
	 * @throws Exception if some other exception occurs
	 **/
	public function __construct(int $newResID = null, string $teamName, $newDateTime, string $courts, string $resType) {

		try {

			$this->setResId($newResID);
			$this->setTeamName($teamName);
			$this->setResDateTime($newDateTime);
			$this->setCourt($courts);
			$this->setResType($resType);

		} catch(InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			//rethrow exception to caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new TypeError($typeError->getMessage(), 0, $typeError));
		} catch(Exception $exception) {
			//rethrow regular exception to caller
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for user reservation id
	 *
	 * @return int|null value of reservation id
	 */
	public function getResId() {
		return ($this->resId);
	}


	/**
	 * mutator method for reservation id
	 *
	 * @param int|null $newResId new value for reservation id
	 * @throws RangeException if $newResId is not positive
	 * @throws TypeError if $newResId  is not an integer
	 **/
	public function setResId(int $newResId = null) {

		//base case: if the reservation is null, this is a new user without a mySQL assigned id
		if($newResId === null) {
				$this->resId = null;
				return;
		}

		//verify reservation id is positive
		if($newResId <= 0) {
			throw(new \RangeException("user id is not positive"));
		}

		//store reservation id
		$this->resId = $newResId;
	}


	/**
	 * accessor method for team name
	 *
	 * @return string teamName
	 **/
	public function getTeamName() {
		return ($this->teamName);
	}


	/**
	 * mutator method for team name
	 *
	 * @param string $teamName
	 * @throws TypeError if $newUserCompanyId is not an integer
	 **/
	public function setTeamName(string $teamName) {

		// sanitize
		$teamName = trim($teamName);
		$teamName = filter_var($teamName, FILTER_SANITIZE_STRING);

		if(empty($teamName) === true) {
			throw (new InvalidArgumentException("team name is invalid"));
		}

		//store team name
		$this->teamName = $teamName;

	}


	/**
	 * accessor method for reservation date
	 *
	 * @return DateTime
	 **/
	public function getResDateTime() {
		return ($this->dateTime);
	}


	/**
	 * mutator method for reservation datetime
	 *
	 * @param mixed $newResDateTime reserervation dateTime as a DateTime object or string (or null to load the current time)
	 * @throws InvalidArgumentException if $newResDateTime is not a valid object or string
	 * @throws RangeException if $newMessageDate is a date that does not exist
	 * @throws Exception for any other exceptions
	 **/
	public function setResDateTime($newResDateTime) {

		// base case: if the date is null, use the current date and time
		if($newResDateTime === null) {
				$this->dateTime = new DateTime('now');
				return;
		}

		// store the message date
		try {
			$newResDateTime = validateDate($newResDateTime);

		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
		$this->dateTime = $newResDateTime;
	}


	/**
	 * accessor method for courts
	 *
	 * @return string court
	 **/
	public function getCourt() {
		return ($this->courts);
	}


	/**
	 * mutator method for courts
	 *
	 * @param string $court
	 * @throws TypeError if $court is not a string
	 * @trhows InvalidArgumentException if $court is invalid
	 **/
	public function setCourt(string $court) {

		// sanitize
		$court = trim($court);
		$court = filter_var($court, FILTER_SANITIZE_STRING);

		if(empty($court) === true) {
			throw (new InvalidArgumentException("court name is invalid"));
		}

		//store team name
		$this->courts = $court;

	}


	/**
	 * accessor method for reservation type
	 *
	 * @return string resType
	 **/
	public function getResType() {
		return ($this->resType);
	}


	/**
	 * mutator method for reservation type
	 *
	 * @param string $resType
	 * @throws TypeError if $resType is not a string
	 * @trhows InvalidArgumentException if $resType is invalid
	 **/
	public function setResType(string $resType) {

		// sanitize
		$resType = trim($resType);
		$resType = filter_var($resType, FILTER_SANITIZE_STRING);

		if(empty($resType) === true) {
			throw (new InvalidArgumentException("resType is invalid"));
		}

		//store team name
		$this->resType = $resType;

	}


	/**
	 * inserts this reservation into mySQL
	 *
	 * @param pdo $pdo PDO connection object
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(PDO $pdo) {

		//enforce userId is null
		if($this->resId !== null) {
			throw(new PDOException("not a new reservation"));
		}

		//create query template
		$query = "INSERT INTO courtReservations(teamName, resDateTime, courts, resType)
					VALUES(:teamName, :resDateTime, :courts, :resType)";
		$statement = $pdo->prepare($query);

		//bind the variables to the place holders in the template
		$parameters = ["teamName" 			=> $this->teamName,
							"resDateTime" 		=> $this->getResDateTime()->format("Y-m-d H:i:s"),
							"courts" 			=> $this->courts,
							"resType" 			=> $this->resType];

		$statement->execute($parameters);

		//update the null user id with the id mySQL just inserted
		$this->resId = intval($pdo->lastInsertId());

	}


	/**
	 * deletes this reservation from mySQL
	 *
	 * @param   PDO $pdo PDO connection object
	 * @throws  PDOException when mySQL related errors occur
	 * @throws  TypeError if $pdo is not a PDO connection object
	 */
	public function delete(PDO $pdo) {

		//enforce the the reservation id is not null
		if($this->resId === null) {
			throw(new PDOException("unable to delete a reservation that does not exist"));
		}

		//create query template
		$query = "DELETE FROM courtReservations WHERE resId = :resId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["resId" => $this->resId];
		$statement->execute($parameters);

	}


	/**
	 * updates this reservation in mySQL
	 *
	 * @param PDO $pdo PDO connection to object
	 * @throws PDOException when mySQL related errors occurs
	 * @throws TypeError if $pdo is not a PDO connection object
	 */

	public function update(PDO $pdo) {
		//enforce the userId is not null
		if($this->resId === null) {
			throw(new PDOException("unable to update a reservation that does not exist"));
		}

		//create query template
		$query = "UPDATE courtReservations SET teamName = :teamName, resDateTime = :resDateTime, courts = :courts, resType = :resType
                WHERE resId = :resId";

		$statement = $pdo->prepare($query);

		//bind the variables to the place holders in the template
		$parameters = ["teamName" 			=> $this->teamName,
							"resDateTime" 		=> $this->getResDateTime()->format("Y-m-d H:m:s"),
							"courts" 			=> $this->courts,
							"resType" 			=> $this->resType,
							"resId" 				=> $this->resId];

		$statement->execute($parameters);

	}


	/**
	 * gets the reservation by team name
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  string $teamName
	 * @return SplFixedArray of court reservations
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception when other exceptions are caught
	 */
	public static function getReservationsByTeamName(PDO $pdo, string $teamName) {

		//sanitize teamname before searching
		$teamName = trim($teamName);
		$teamName = filter_var($teamName, FILTER_SANITIZE_STRING);
		if(empty($teamName) === true) {
			throw(new PDOException("invalid team name"));
		}

		//create query template
		$query = "SELECT resId, teamName, resDateTime, courts, resType FROM courtReservations WHERE teamName = :teamName";
		$statement = $pdo->prepare($query);

		//bind
		$parameters = ["teamName" => $teamName];
		$statement->execute($parameters);

		if($statement->rowCount() === 0) {
			return null;
		}

		try {

			$reservations = new SplFixedArray($statement->rowCount());
			$statement->setFetchMode(PDO::FETCH_ASSOC);


			while(($row = $statement->fetch()) !== false) {

				$reservation = new CourtReservations($row["resId"], $row["teamName"], $row["resDateTime"], $row["courts"], $row["resType"]);
				$reservations[$reservations->key()] = $reservation;
				$reservations->next();
			}
		} catch(PDOException $exception) {
			// rethrow
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}  catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($reservations);

	}


	/**
	 * gets the reservation by date
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  mixed string | DateTime $resDate
	 * @return SplFixedArray|null array of courtReservation objects or null if no reservations exists for $resDate
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception when other exceptions are caught
	 */
	public static function getReservationsByDate(PDO $pdo, $resDate) {

		// validate $resdate
		$resDate = validateDate($resDate);

		//create query template
		$query = "SELECT resId, teamName, resDateTime, courts, resType FROM courtReservations WHERE resDateTime LIKE :resDate";
		$statement = $pdo->prepare($query);

		// get the date in the correct format and add % for the select
		$resDate = $resDate->format("Y-m-d") . "%";

		//bind
		$parameters = ["resDate" => $resDate];
		$statement->execute($parameters);
		
		// if there are no reservations for $resDate, return null
		if($statement->rowCount() === 0) {
			return null;
		}

		// build array of reservations
		try {
			
			$reservations = new SplFixedArray($statement->rowCount());
			$statement->setFetchMode(PDO::FETCH_ASSOC);

			while (($row = $statement->fetch()) !== false) {
				$reservation = new CourtReservations($row["resId"], $row["teamName"], $row["resDateTime"], $row["courts"], $row["resType"]);
				$reservations[$reservations->key()] = $reservation;
				$reservations->next();
			}

		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($reservations);

	}


	/**
	 * gets the reservation by user id
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  int $resId user id to search for
	 * @return CourtReservations|null reservation found or null if not found
	 * @throws PDOException when mySQL related errors occurs
	 * @throws TypeError when variables are not the correct type
	 * @throws Exception - rethrow other caught exceptions
	 */

	public static function getReservationById(PDO $pdo, int $resId) {

		//check that reservation id is positive
		if($resId <= 0) {
			throw(new PDOException("reservation ID is not positive"));
		}

		//create query template
		$query = "SELECT resId, teamName, resDateTime, courts, resType FROM courtReservations WHERE resId = :resId";
		$statement = $pdo->prepare($query);

		//bind
		$parameters = ["resId" => $resId];
		$statement->execute($parameters);

		try {
			
			$reservation = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				$reservation = new CourtReservations($row["resId"], $row["teamName"], $row["resDateTime"], $row["courts"], $row["resType"]);
				
			}
		} catch(PDOException $exception) {
			// rethrow
			throw(new PDOException($exception->getMessage(), 0, $exception));
		} catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($reservation);

	}


	/**
	 * gets all reservations
	 *
	 * @param PDO $pdo PDO connection object
	 * @return splFixedArray|null - array of courtReservation objects found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception - rethrow other caught exceptions
	 */


	public static function getAllReservations(PDO $pdo) {

		//create query update
		$query = "SELECT resId, teamName, resDateTime, courts, resType FROM courtReservations";
		$statement = $pdo->prepare($query);
		$statement->execute();

		if($statement->rowCount() === 0 ) {
			return null;
		}

		try {

			//build an array of reservations
			$reservations = new SPLFixedArray($statement->rowCount());
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			
			while(($row = $statement->fetch()) !== false) {
				$reservation = new CourtReservations($row["resId"], $row["teamName"], $row["resDateTime"], $row["courts"], $row["resType"]);
				$reservations[$reservations->key()] = $reservation;
				$reservations->next();
			}

		} catch(PDOException $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		} catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($reservations);
	}


	/**
	 * gets the reservation by date and court
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  DateTime $resDate
	 * @param  string $court
	 * @return SplFixedArray|null array of courtReservation objects or null if no reservations exists for $resDate
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception when other exceptions are caught
	 */
	public static function getResByDateAndCourt(PDO $pdo, DateTime $resDate, string $court) {

		// validate date
		$resDate = validateDate($resDate);

		$query = "SELECT resId, teamName, resDateTime, courts, resType FROM courtReservations WHERE resDateTime LIKE :resDate AND courts = :court";
		$statement = $pdo->prepare($query);

		// get the date in the correct format and add % for the select
		$resDate = $resDate->format("Y-m-d") . "%";

		//bind
		$parameters = ["resDate" => $resDate, "court" =>$court];
		$statement->execute($parameters);

		// if there are no reservations for $resDate and this $court, return null
		if($statement->rowCount() === 0) {
			return null;
		}

		// build array of reservations
		try {

			$reservations = new SplFixedArray($statement->rowCount());
			$statement->setFetchMode(PDO::FETCH_ASSOC);

			while (($row = $statement->fetch()) !== false) {
				$reservation = new CourtReservations($row["resId"], $row["teamName"], $row["resDateTime"], $row["courts"], $row["resType"]);
				$reservations[$reservations->key()] = $reservation;
				$reservations->next();
			}

		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($reservations);

	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
	
} // CourtReservations