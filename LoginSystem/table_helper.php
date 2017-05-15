<?php
	function echoComboBoxOptions()
	{
		// acquire the current date and related variables
		date_default_timezone_set("America/Chicago");
		$curDate = new DateTime();
		$curMonthNum = (int)$curDate->format("n");
		$curYearNum = (int)$curDate->format("Y");
		
		// loop through the combobox options
		for($i = -2; $i <= 4; $i++)
		{
			// adjust the numeric month and year to suit the various options
			$monthNum = $curMonthNum + $i;
			$yearNum = $curYearNum;
			if($monthNum > 12)
			{
				$monthNum %= 12;
				$yearNum++;
			}
			if($monthNum < 0)
			{
				$monthNum = ($monthNum + 12) % 12;
				$yearNum--;
			}
			
			// acquire name of month from numeric
			$monthStr = "";
			switch($monthNum)
			{
				case 1:
					$monthStr = "January";
					break;
				case 2:
					$monthStr = "February";
					break;
				case 3:
					$monthStr = "March";
					break;
				case 4:
					$monthStr = "April";
					break;
				case 5:
					$monthStr = "May";
					break;
				case 6:
					$monthStr = "June";
					break;
				case 7:
					$monthStr = "July";
					break;
				case 8:
					$monthStr = "August";
					break;
				case 9:
					$monthStr = "September";
					break;
				case 10:
					$monthStr = "October";
					break;
				case 11:
					$monthStr = "November";
					break;
				case 12:
					$monthStr = "December";
					break;
			}
			
			// echo out the options
			echo "<option value='" . $monthStr . " " . $yearNum . "'";
			if ($i == 0)
			{
				echo " selected='selected'";
			}
			echo ">" . $monthStr . " " . $yearNum . "</option>\r\n";
		}
	}
	
	function echoCurMonthTable()
	{
		// acquire the current date and related variables
		date_default_timezone_set("America/Chicago");
		$curDate = new DateTime();
		
		// call function to echo out the table
		echoTable($curDate);
	}
	
	
	function echoTable($dateTime)
	{
		// date string formatted with a mysql wildcard for convenience
		$curDateStr = $dateTime->format("Y-m-%");
		
		// connect to the database
		$con = new mysqli("localhost", "debswebs_tennis", "ScreaMInG945TANgerINEs", "debswebs_GLTennis");
		
		// kill the script if the connection failes
		if ($con->connect_errno)
		{
			// 
			// error handling in case of a connection failure?
			// 
			die("<p>Unable to load reservations. Sorry for the inconvenience. Please try again.</p>");
		}
		
		// fetch all reservations from the given month (and year)
		$query = "SELECT TeamName, ResDate, ResTime, Courts, ResType FROM COURT_RESERVATIONS WHERE ResDate LIKE " .
			"'$curDateStr' ORDER BY ResDate, ResTime, Courts;";
		$result = $con->query($query);
		if(!$result)
		{
			// 
			// error handling in case SELECT query fails
			// 
			die("<p>Unable to pull reservations from the database. Please try again.</p>");
		}
		$data = array();
		while($row = $result->fetch_array())
		{
			$data[] = array("TeamName" => $row["TeamName"], "ResDate" => $row["ResDate"], "ResTime" => $row["ResTime"],
				"Courts" => $row["Courts"], "ResType" => $row["ResType"]);
		}
		$result->free();
		
		// echo out header for the month and the opening segment of the table
		echo "<br/>";
		echo "<h1>" . $dateTime->format("F") . " " . $dateTime->format("Y") . "</h1>\r\n";
		
		echo "<table>\r\n";
		echo "<tr>\r\n";
		echo "<th>Date</th>\r\n";
		echo "<th>Spray Park 1</th>\r\n";
		echo "<th>Spray Park 2</th>\r\n";
		echo "<th>South 1</th>\r\n";
		echo "<th>South 2</th>\r\n";
		echo "<th>North 1</th>\r\n";
		echo "<th>North 2</th>\r\n";
		echo "</tr>\r\n";
		
		// echo out table rows for each day of the month
		for($i = 1; $i <= (int)$dateTime->format("t"); $i++)
		{
			// build array of court reservations for a given day
			$resOnDateArr = array();
			foreach($data as $res)
			{
				if(substr($res["ResDate"], 8) == ("" . $i) || substr($res["ResDate"], 8) == ("0" . $i))
				{
					$resOnDateArr[] = $res;
				}
			}
			
			// output initial HTML
			echo "<tr>\r\n";
			echo "<td>" . $i . "</td>\r\n";
			
			// look for a reservation on each of the courts in the order they appear in the table (Spray 1 & 2,
			// South 1 & 2, North 1 & 2) on this date and output the corresponding HTML
			$courts = array("Spray Park 1", "Spray Park 2", "South 1", "South 2", "North 1", "North 2");
			$teamCSSClassArr = array("WHLTA Get-A-Grip" => "whltaGetAGrip",
				"WHLTA Twisted Sisters" => "whltaTwistedSisters", "WHLTA Double the Fun" => "whltaDoubleTheFun",
				"WHLTA Double Shots" => "whltaDoubleShots", "WHLTA Volley Girls" => "whltaVolleyGirls", "WHLTA Smart Aces" => 				"whltaSmartAces", "HLTA Got Tennis?" => "hltaGotTennis", "HLTA Casual Sets" => "hltaCasualSets",
				"HLTA Mood Swings" => "hltaMoodSwings", "HLTA Double Trouble" => "hltaDoubleTrouble", "USTA Go-Getters" => "ustaGoGetters", "USTA Alley Cats" => "ustaAlleyCats", "KAT Ladies 4.0 Summer Warm-Up" => "katLadies40SummerWarmUp");
			foreach($courts as $court)
			{
				$resFound = false;
				foreach($resOnDateArr as $res)
				{
					if(strpos($res["Courts"], $court) !== false)
					{
						$resFound = true;
						/*
						<td class="hltaMoodSwings" >
							<strong><big>HLTA Mood Swings</big></strong><br/>9:00 & 10:30 <br/>Regularly Scheduled HLTA Match
						</td>
						*/
						echo "<td class='" . $teamCSSClassArr[$res["TeamName"]] . "'><span class='teamName'>" .
							$res["TeamName"] . "</span><br/>" . $res["ResTime"] . "</br/>" . $res["ResType"] .
							"</td>\r\n";
						break;
					}
				}
				if(!$resFound)
				{
					echo "<td></td>\r\n";
				}
			}
			
			// output ending HTML
			echo "</tr>\r\n";
			
			
			
			
			
			
			
			
			/*
			echo "<td></td>\r\n";
			echo "<td></td>\r\n";
			echo "<td></td>\r\n";
			echo "<td></td>\r\n";
			echo "<td></td>\r\n";
			echo "<td></td>\r\n";
			*/
			
			
			
		}
		
		// echo out the ending segment of the table
		echo "</table>";
	}
?>