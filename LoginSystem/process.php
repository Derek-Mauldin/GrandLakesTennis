<?php
	if(isset($_POST))
	{
		// form validation vars
		$formok = true;
		$dataok = true;
		$errors = array();
	
		// sumbission data
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$reservationdate = date('d/m/Y');
		$reservationtime = date('H:i');
		$date = date('d/m/Y');
		$time = date('H:i');
	
		// form data
		$teamname = $_POST['teamname'];
		$reservationdate = trim(htmlentities(strip_tags($_POST['reservationdate'])));
		$reservationtime = $_POST['reservationtime'];
		$courts = $_POST['court'];
		$reservationtype = $_POST['reservationtype'];
	
		// validate form data
		if(empty($teamname))
		{
			$formok = false;
			$errors[] = "You have not entered a Team Name";
		}
		if(empty($reservationdate))
		{
			$formok = false;
			$errors[] = "You have not entered a date";
		}
		if(empty($reservationtime))
		{
			$formok = false;
			$errors[] = "You have not entered a time";
		}
		if(count($courts) == 0)
		{
			$formok = false;		
			$errors[] = "You have not chosen a court";
		}
		if(empty($reservationtype))
		{
			$formok = false;		
			$errors[] = "You have not chosen a reservation type";
		}
		
		// move on to validate the input if the form is ok
		if($formok)
		{
			// connect to the database
			$con = new mysqli("localhost", "debswebs_tennis", "ScreaMInG945TANgerINEs", "debswebs_GLTennis");
		
			// kill the script if the connection failes
			if ($con->connect_errno)
			{
				// 
				// change to be more user friendly
				// 
				die("Failed to connect to MySQL: " . $con->connect_error());
			}
		
			// create date with mysql formatting
			$sqldate = substr($reservationdate, 6) . "-" . substr($reservationdate, 0, 2) . "-" .
				substr($reservationdate, 3, 2);
		
			// create a string separating all court names with _ delimiters
			$courtStr = $courts[0];
			if(count($courts) > 1)
			{
				for($i = 1; $i < count($courts); $i++)
				{
					$courtStr .= "_" . $courts[$i];
				}
			}
			
			// fetch all ResID, ResDate, ResTime, and Courts data from COURT_RESERVATIONS
			$query = "SELECT ResID, TeamName, ResDate, ResTime, Courts FROM COURT_RESERVATIONS;";
			$result = $con->query($query);
			$data = array();
			$conflictingCourts = array();
			while($row = $result->fetch_array())
			{
				$data[$row["ResID"]] = $row["ResDate"];

				// check for any date, time, and court conflicts and add the court to the array of conflicts
				if($row["ResDate"] == $sqldate && $row["ResTime"] == $reservationtime)
				{
					foreach(explode("_", $row["Courts"]) as $presentCourt)
					{
						foreach($courts as $inputCourt)
						{
							echo $presentCourt . " & " . $inputCourt . "<br>";
							if($presentCourt == $inputCourt)
							{
								$dataok = false;
								if(!in_array($inputCourt, $conflictingCourts))
								{
									$conflictingCourts[] = $inputCourt;
								}
							}
						}
					}
				}
			}
			$result->free();
			if(!$dataok)
			{
				$errorMsg = "The following courts are reserved for your selected date and time: " .
					$conflictingCourts[0];
				for($i = 1; $i < count($conflictingCourts); $i++)
				{
					$errorMsg .= ", " . $conflictingCourts[$i];
				}
				$errors[] = $errorMsg;
			}
			
			// insert data if ok
			if($dataok)
			{
				// create a ResID that is not presently in COURT_RESERVATIONS
				$resID = "";
				do
				{
					$resID = "" . rand(0, 9999) . "";
					while (strlen($resID) < 4)
					{
						$resID = "0" . $resID;
					}
				}
				while(in_array($resID, array_keys($data)));
		
				// insert data
				$query = "INSERT INTO COURT_RESERVATIONS(ResID, TeamName, ResDate, ResTime, Courts, ResType) VALUES(" .
					"'$resID', '$teamname', '$sqldate', '$reservationtime', '$courtStr', '$reservationtype')";
				$result = $con->query($query);
				if (!$result)
				{
					// 
					// change to be more user friendly
					// 
					die("Insert query failed: " . $con->error);
				}
			
				// remove all reservations more than 1 year past the reservation date from the main table and archive them
				date_default_timezone_set('America/Chicago');
				$curDate = new DateTime();
				foreach (array_keys($data) as $key)
				{
					$keyDate = new DateTime(substr($data[$key], 5, 2) . "/" . substr($data[$key], 8) . "/" .
						substr($data[$key], 0, 4));
					$elapsedTime = date_diff($curDate, $keyDate, true);
					if ($elapsedTime->format('%y') != '0')
					{
						// archive the old reservation
						$query = "SELECT * FROM COURT_RESERVATIONS WHERE ResID = '$key';";
						$result = $con->query($query);
						$resultArr = $result->fetch_array($result);
						$resultResID = $resultArr['ResID'];
						$resultTeamName = $resultArr['TeamName'];
						$resultResDate = $resultArr['ResDate'];
						$resultResTime = $resultArr['ResTime'];
						$resultCourts = $resultArr['Courts'];
						$resultResType = $resultArr['ResType'];
						$result->free();
						$query = "INSERT INTO RESERVATION_ARCHIVES(ResID, TeamName, ResDate, ResTime, Courts, ResType) " .
							"VALUES('$resultResID', '$resultTeamName', '$resultResDate', '$resultResTime', " .
							"'$resultCourts', '$resultResType');";
						$result = $con->query($query);
					
						// delete the old reservation
						$query = "DELETE FROM COURT_RESERVATIONS WHERE ResID = '$key';";
						$result = $con->query($con, $query);
					}
				}
			}
			// close
			$con->close();
		}
		// data to return to the form
		$returndata = array('posted_form_data' => array('teamname' => $teamname, 'reservationdate' => $reservationdate,
			'reservationtime' => $reservationtime, 'court[]' => $courts, 'reservationtype' => $reservationtype),
			'form_ok' => $formok && $dataok, 'errors' => $errors);
		// if this is not an ajax request
		if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
		{
			echo "in if<br>";
			// set session variables
			session_start();
			$_SESSION['cf_returndata'] = $returndata;
		
			// redirect back to form
			header('location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
?>