<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>	
		<link rel="stylesheet" href="css/table.css" type="text/css"/>	
		<script type="text/javascript">
            $(document).ready(function(){
               $('.striped tr:even').addClass('alt');
            });
        </script>
	</head>
	<body>
		<div id="container">
			<h2>Please select the month you would like to view.</h2>
			<div class="monthButton">				
				<form action "">
					<select name="month" class=".monthButton" onchange="
						document.getElementById('tableView').innerHTML =
							document.getElementById('' + selectedIndex).innerHTML;
						">
						<?php
							// display options in the combobox for the range of 2 months in the past through 4 months
							// in the future
							include_once "table_helper.php";
							echoComboBoxOptions();
						?>
					</select>
				</form>
			</div><!--monthButton -->	
			<br/>
			<div class="table" id="tableView" style="width:1100px;height:150px;">
				<?php
					// 
					// code to produce the table of the current month
					// 
					include_once "table_helper.php";
					echoCurMonthTable();
				?>
				<br/><br/>
			</div>
			
			
			
			<?php
				// 
				// code to produce 7 invisible divs (ids "0"-"6" with class "invisTable") containing headers (for the month being
				// displayed) and the corresponding tables
				// 
				include_once "table_helper.php";
				
				// acquire the current date and related variables
				date_default_timezone_set("America/Chicago");
				$curDate = new DateTime();
				$year = (int)$curDate->format('Y');
				$month = (int)$curDate->format('n') - 2;
				$monthStr = "" . $month;
				if (strlen($monthStr) == 1)
				{
					$monthStr = "0" . $monthStr;
				}
				$curDate->setDate("" . $year, $monthStr, "01");
				
				// loop through all the desired months and build tables inside divs
				for($i = 0; $i <= 6; $i++)
				{
					echo "<div class='invisTable' id='" . $i . "'>";
					echoTable($curDate);
					echo "</div>";
					$month++;
					$monthStr = "" . $month;
					if (strlen($monthStr) == 1)
					{
						$monthStr = "0" . $monthStr;
					}
					$curDate->setDate("" . $year, $monthStr, "01");
				}
			?>
			
			
			
		</div> <!-- container -->
	</body>
</html>