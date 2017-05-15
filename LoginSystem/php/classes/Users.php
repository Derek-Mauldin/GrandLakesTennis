<?php

require_once("autoloader.php");

/**
 * users for site
 *
 *
 * @author Derek Mauldin
 */

class Users implements JsonSerializable {
	
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
	 * user active key
	 * 
	 * @var string $activKey
	 */
	private $activKey;
	
	/**
	 * user salt
	 * 
	 * @var string $salt
	 */
	private $salt;
	
	/**
	 * user hash
	 * 
	 * @var string $hash
	 */
	private $hash;


	/**
	 * @param int|null $newId id of this user or null if new user
	 * @param string $newUserName string containing user name
	 * @param string $newEmail string containing user email
	 * @mixed string|null $newActivKey string containing user activation key
	 * @param string $newHash string containing user hash
	 * @param string $newSalt containing user salt
	 * @throws InvalidArgumentException if the data types are not valid
	 * @throws RangeException if data values are out of bounds
	 * @throws TypeError if data types violate type hints
	 * @throws Exception if some other exception occurs
	 **/
	public function __construct(int $newId = null, string $newUserName, string $newEmail, $newActivKey,
										 string $newSalt, string $newHash) {
		try {
			$this->setId($newId);
			$this->setUserName($newUserName);
			$this->setEmail($newEmail);
			$this->setActivKey($newActivKey);
			$this->setUserHash($newHash);
			$this->setUserSalt($newSalt);

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
	 * accessor method user activation key
	 *
	 * @return string $activKey
	 */
	public function getActivKey() {
		return ($this->activKey);
	}

	
	/**
	 * mutator method for user activation key
	 *
	 * @param  string $newActivKey - user activation key
	 * @throws RangeException if $newRangeException is not = 100
	 * @throws TypeError if $newUserActivation is not a string
	 */
	public function setActivKey($newActivKey) {

		$newActivKey = trim($newActivKey);


		// activation will be set to null when member activates the account
		if($newActivKey === null || $newActivKey === "") {
			$this->activKey = null;
			return;
		}

		// sanitize
		$newActivKey = filter_var($newActivKey, FILTER_SANITIZE_STRING);

		if(empty($newActivKey) === true) {
			throw(new InvalidArgumentException("Activation code content is empty or insecure"));
		}

		if(strlen($newActivKey) !== 32) {
			throw(new RangeException("activation code should be 32 hex digits"));
		}
		//store activation code
		$this->activKey = $newActivKey;

	}

	
	/**
	 * accessor method for user hash
	 *
	 * @return int|null for $newUserHash
	 */
	public function getHash() {
		return ($this->hash);
	}

	/**
	 * unset method for user hash
	 *
	 */
	public function unsetHash() {
		 unset($this->hash);
	}
	
	/**
	 * mutator method for user hash
	 *
	 * @param  string $newHash string of user hash
	 * @throws InvalidArgumentException if $Hash is not a string
	 * @throws RangeException if $newUserHash != 128
	 * @throws TypeError if $newUserHash is not a string
	 */
	public function setUserHash(string $newHash) {

		//make sure that user activation cannot be null
		if(ctype_xdigit($newHash) === false) {
			throw(new RangeException("user hash cannot be null"));
		}
		//make sure user activation =  128
		if(strlen($newHash) !== 128) {
			throw(new RangeException("user hash is not 128 characters"));
		}

		//convert and store user activation
		$this->hash = $newHash;
	}

	
	/**
	 * accessor method for user salt
	 *
	 * @returns int|null for $newUserSalt
	 */
	public function getUserSalt() {
		return ($this->salt);
	}


	/**
	 * unset method for user salt
	 */
	public function unsetSalt() {
		unset($this->salt);
	}

	
	/**
	 * mutator method for user salt
	 *
	 * @param string $newSalt string of user salt
	 * @throws  InvalidArgumentException if user salt is not a string
	 * @throws  RangeException if $newSalt = 64
	 * @throws  TypeError if $newSalt is not a string
	 */
	public function setUserSalt(string $newSalt) {

		//verification that $userSalt is secure
		$newSalt = strtolower(trim($newSalt));

		//make sure that user activation cannot be null
		if(ctype_xdigit($newSalt) === false) {
			throw(new RangeException("user salt cannot be null"));
		}
		//make sure user activation =  64
		if(strlen($newSalt) !== 64) {
			throw(new RangeException("user salt has to be 64"));
		}

		//convert and store user salt
		$this->salt = $newSalt;
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
		$query = "INSERT INTO users(userName, email, activKey, salt, hash) VALUES(:userName, :email, :activKey, :salt, :hash)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["userName" 	=> $this->userName,
							"email" 		=> $this->email,
							"activKey" 	=> $this->activKey,
							"salt" 		=> $this->salt,
							"hash" 		=> $this->hash];

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
		$query = "DELETE FROM users WHERE id = :id";
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
		$query = "UPDATE users SET userName = :userName, email = :email, activKey = :activKey, salt = :salt,
                hash = :hash WHERE id = :id";

		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["id" 			=> $this->id,
							"userName" 	=> $this->userName,
							"email" 		=> $this->email,
							"activKey" 	=> $this->activKey,
							"salt" 		=> $this->salt,
							"hash" 		=> $this->hash];

		$statement->execute($parameters);

	}

	
	/**
	 * gets the user by Email
	 *
	 * @param  PDO $pdo PDO connection object
	 * @param  string $email 
	 * @return Users object
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
		$query = "SELECT id, userName, email, activKey, salt, hash FROM users WHERE email = :email";
		$statement = $pdo->prepare($query);
		
		//bind users with place holder in the template
		$parameters = ["email" => $email];
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