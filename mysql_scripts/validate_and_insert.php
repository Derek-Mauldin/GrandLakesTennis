<?php
	// declare variables
	$resID = "";//not from form
	$teamName = "";
	$date = "";
	$time = "";
	$court = "";
	$type = "";
	
	
	/*
		IDs from php form
		teamname, reservationdate, reservationtime, court, reservationtype	
	*/
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// somehow generate resID: either randomize, increment, or draw from
		// table of serialized values
		$resID = "" . rand(0, 9999) . "";
		while (strl($resID) < 4)
			$resId = " " . $resId;
		
		// the time, stripslashes, and htmlspecialchars methods format the strings
		// both for appearance and security
		$teamName = htmlspecialchars(stripslashes(trim($_POST['teamname'])));
		$date = htmlspecialchars(stripslashes(trim($_POST['reservationdate'])));
		$time = htmlspecialchars(stripslashes(trim($_POST['reservationtime'])));
		$court = htmlspecialchars(stripslashes(trim($_POST['court'])));
		$type = htmlspecialchars(stripslashes(trim($_POST['reservationtype'])));
		
		// validate data
		
		// if data is valid
		
		// connect to the database
		$con = mysqli_connect("localhost", "debswebs_tennis",
			"ScreaMInG945TANgerINEs", "debswebs_GLTennis");
		
		// kill the script if the connection failes
		if (mysqli_connect_errno())
			die("Failed to connect to MySQL: " . mysqli_connect_error());
		
		// escape special characters based on the charset to avoid exploitation
		$teamName = mysqli_real_escape_string($teamName);
		$date = mysqli_real_escape_string($date);
		$time = mysqli_real_escape_string($time);
		$court = mysqli_real_escape_string($court);
		$type = mysqli_real_escape_string($type);
		
		// data binding for sql injection prevention
		$query = $con->prepare("INSERT INTO COURT_RESERVATIONS(ResID, TeamName, " .
			"ResDate, ResTime, Court, ResType) VALUES('$resID', ?, ?, ?, ?, ?)");
		$query->bind_param("sssss", $teamName, $date, $time, $court, $type);
		
		// execute
		if (!$query->execute())
			die("Insert query failed: " . $query->error);
		
		// close
		$query->close();
		$con->close();
	}
?>