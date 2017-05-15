<?php

require_once("autoloader.php");

/**
 * social users for site
 *
 *
 * @author Derek Mauldin
 */

class UsersSocial implements JsonSerializable {

	/**
	 * id for this user - it is the primary key
	 *
	 * @var int $userId ;
	 */
	private $id;

	/**
	 * userName
	 *
	 * @var string $userName
	 */
	private $userName;

	/**
	 * user email
	 *
	 * @var string $email
	 */
	private $email;

	/**
	 * source
	 *
	 * @var string $source
	 */
	private $source;


	/**
	 * @param int|null $newId id of this user or null if new user
	 * @param string $newUserName string containing user name
	 * @param string $newEmail string containing user email
	 * @param string $newSource string containing source of social user
	 * @throws InvalidArgumentException if the data types are not valid
	 * @throws RangeException if data values are out of bounds
	 * @throws TypeError if data types violate type hints
	 * @throws Exception if some other exception occurs
	 **/
	public function __construct(int $newId = null, string $newUserName, string $newEmail, string $newSource) {
		try {
			$this->setId($newId);
			$this->setUserName($newUserName);
			$this->setEmail($newEmail);
			$this->setSource($newSource);

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
	 * accessor method for user id
	 *
	 * @return int|null value of user id
	 */
	public function getId() {
		return ($this->id);
	}


	/**
	 * mutator method for user id
	 *
	 * @param int|null $newId new value for user id
	 * @throws RangeException if $newUserId is not positive
	 * @throws TypeError if $newUserId  is not an integer
	 **/
	public function setId(int $newId = null) {

		//base case: if the user is null, this is a new user without a mySQL assigned id. (yet)
		if($newId === null) {
			$this->id = null;
			return;
		}

		//verify user id is positive
		if($newId <= 0) {
			throw(new \RangeException("user id is not positive"));
		}

		//store user id
		$this->id = $newId;
	}


	/**
	 * accessor method for user name
	 *
	 * @return string userName
	 */
	public function getUserName() {
		return ($this->userName);
	}


	/**
	 * mutator method for userName
	 *
	 * @param string $newUserName new value for userName
	 * @trhows TypeError if $newUserName is not a string
	 **/
	public function setUserName(string $newUserName) {

		// sanitize
		$newUserName = trim($newUserName);
		$newUserName = filter_var($newUserName, FILTER_SANITIZE_STRING);

		//store user name
		$this->userName = $newUserName;

	}

	/**
	 * accessor method for user email
	 *
	 * @return string email
	 */
	public function getEmail() {
		return ($this->email);
	}


	/**
	 * mutator method for user email
	 *
	 * @param  string $newUserEmail
	 * @throws InvalidArgumentException if email is insecure or empty
	 * @throws RangeException if $newUserEmail is too long
	 * @throws TypeError is $newUserEmail is not a string
	 */
	public function setEmail(string $newUserEmail) {

		//verify the User email is secure
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserEmail) === true) {
			throw(new InvalidArgumentException("user email is insecure or empty"));
		}

		//verify the user email will fit in the database
		if(strlen($newUserEmail) > 100) {
			throw(new RangeException("user email to long"));
		}

		//store the user email
		$this->email = $newUserEmail;
	}


	/**
	 * accessor method for user source
	 *
	 * @return string source
	 */
	public function getSource() {
		return ($this->source);
	}


	/**
	 * mutator method for user email
	 *
	 * @param  string $newUserSource
	 * @throws InvalidArgumentException if email is insecure or empty
	 * @throws RangeException if $newUserEmail is too long
	 * @throws TypeError is $newUserEmail is not a string
	 */
	public function setSource(string $newUserSource) {

		//verify the User email is secure
		$newUserSource = trim($newUserSource);
		$newUserSource = filter_var($newUserSource, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserSource) === true) {
			throw(new InvalidArgumentException("user email is insecure or empty"));
		}

		//verify the user email will fit in the database
		if(strlen($newUserSource) > 100) {
			throw(new RangeException("user source to long"));
		}

		//store the user email
		$this->source = $newUserSource;
	}



	/**
	 * inserts this User into mySQL
	 *
	 * @param pdo $pdo PDO connection object
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(PDO $pdo) {

		//enforce userId is null
		if($this->id !== null) {
			throw(new PDOException("not a new user"));
		}

		//create query template
		$query = "INSERT INTO usersSocial(userName, email, source) VALUES(:userName, :email, :source)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["userName" 	=> $this->userName,
							"email" 		=> $this->email,
							"source" 	=> $this->source];

		$statement->execute($parameters);

		//update the null user id with the id mySQL just inserted
		$this->id = intval($pdo->lastInsertId());

	}


	/**
	 * deletes the user from mySQL
	 *
	 * @param   PDO $pdo PDO connection object
	 * @throws  PDOException when mySQL related errors occur
	 * @throws  TypeError if $pdo is not a PDO connection object
	 */
	public function delete(PDO $pdo) {

		//enforce the the user id is not null
		if($this->id === null) {
			throw(new PDOException("unable to delete a user that does not exist"));
		}

		//create query template
		$query = "DELETE FROM usersSocial WHERE id = :id";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["id" => $this->id];
		$statement->execute($parameters);

	}


	/**
	 * updates this user in mySQL
	 *
	 * @param PDO $pdo PDO connection to object
	 * @throws PDOException when mySQL related errors occurs
	 * @throws TypeError if $pdo is not a PDO connection object
	 */

	public function update(PDO $pdo) {
		//enforce the userId is not null
		if($this->id === null) {
			throw(new PDOException("unable to update a user that does not exist"));
		}

		//create query template
		$query = "UPDATE usersSocial SET userName = :userName, email = :email, source = :source WHERE id = :id";

		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["id" 			=> $this->id,
			"userName" 	=> $this->userName,
			"email" 		=> $this->email,
			"activKey" 	=> $this->source];

		$statement->execute($parameters);

	}


	/**
	 * gets the user by Email
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  string $email
	 * @return UsersSocial object
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception when other exceptions are caught
	 */
	public static function getUserByEmail(PDO $pdo, string $email) {

		//sanitize the description before searching
		$email = trim($email);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if(empty($email) === true) {
			throw(new PDOException("invalid user email"));

		}
		//create query template
		$query = "SELECT id, userName, email, source FROM usersSocial WHERE email = :email";
		$statement = $pdo->prepare($query);

		//bind users with place holder in the template
		$parameters = ["email" => $email];
		$statement->execute($parameters);

		try {

			$userSocial = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				$userSocial = new UsersSocial($row["id"], $row["userName"], $row["email"], $row["source"]);
			}

		} catch(PDOException $exception) {
			// rethrow
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}  catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($userSocial);

	}



	/**
	 * gets the user by user name
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  string $userName
	 * @return Users object
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception when other exceptions are caught
	 */
	public static function getUserByUserName(PDO $pdo, string $userName) {

		//sanitize the description before searching
		$userName = trim($userName);
		$userName = filter_var($userName, FILTER_SANITIZE_EMAIL);
		if(empty($userName) === true) {

			throw(new PDOException("invalid user email"));

		}
		//create query template
		$query = "SELECT id, userName, email, activKey, salt, hash FROM users WHERE userName = :userName";
		$statement = $pdo->prepare($query);

		//bind
		$parameters = ["userName" => $userName];
		$statement->execute($parameters);

		try {

			$user = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				$user = new Users($row["id"], $row["userName"], $row["email"], $row["activKey"], $row["salt"], $row["hash"]);
			}

		} catch(PDOException $exception) {
			// rethrow
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}  catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($user);

	}


	/**
	 * gets the user by user id
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  int $id user id to search for
	 * @return users|null user found or null if not found
	 * @throws PDOException when mySQL related errors occurs
	 * @throws TypeError when variables are not the correct type
	 * @throws Exception - rethrow other caught exceptions
	 */

	public static function getUserById(PDO $pdo, int $id) {

		//check that user id is positive
		if($id <= 0) {
			throw(new PDOException("user ID is not positive"));
		}

		//create query template
		$query = "SELECT id, userName, email, activKey, salt, hash FROM users WHERE id = :id";
		$statement = $pdo->prepare($query);

		//bind
		$parameters = ["id" => $id];
		$statement->execute($parameters);

		//grab the user from mySQL
		try {

			$user = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				$user = new Users($row["id"], $row["userName"], $row["email"], $row["activKey"], $row["salt"], $row["hash"]);
			}

		} catch(PDOException $exception) {
			// rethrow
			throw(new PDOException($exception->getMessage(), 0, $exception));
		} catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($user);

	}


	/**
	 * gets the User by user activation key
	 *
	 * @param 	PDO $pdo PDO connection object
	 * @param  string $activationKey user Activation content to search for
	 * @return Users|null User found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception - rethrow other caught exceptions
	 **/
	public static function getUserByActivationKey(PDO $pdo, string $activationKey) {

		// sanitize
		$activationKey = trim($activationKey);
		$activationKey = filter_var($activationKey, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($activationKey) === true) {
			throw(new PDOException("user activation key is invalid"));
		}

		// create query template
		$query = "SELECT id, userName, email, activKey, salt, hash FROM users WHERE activKey = :activationKey";
		$statement = $pdo->prepare($query);

		// bind
		$parameters = ["activationKey" => $activationKey];
		$statement->execute($parameters);

		// grab user from mySQL
		try {
			$user = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				$user = new Users($row["id"], $row["userName"], $row["email"], $row["activKey"], $row["salt"], $row["hash"]);
			}
		} catch(PDOException $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		} catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return($user);

	}


	/**
	 * gets all users
	 *
	 * @param PDO $pdo PDO connection object
	 * @return splFixedArray of users found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 * @throws TypeError when variables are not the correct data type
	 * @throws Exception - rethrow other caught exceptions
	 */

	public static function getAllUsers(PDO $pdo) {

		//create query update
		$query = "SELECT id, userName, email, activKey, salt, hash FROM users";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of users
		$users = new SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);

		try {

			while(($row = $statement->fetch()) !== false) {
				$user = new Users($row["id"], $row["userName"], $row["email"], $row["activKey"], $row["salt"], $row["hash"]);
				$users[$users->key()] = $user;
				$users->next();
			}

		} catch(PDOException $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		} catch(Exception $exception) {
			// rethrow
			throw(new Exception($exception->getMessage(), 0, $exception));
		}

		return ($users);
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
}