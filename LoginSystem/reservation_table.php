<?php 
session_start();


if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) {

if(empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])){

if ( !isset($_SESSION['token'])) {

if ( !isset($_SESSION['fb_access_token'])) {

 header('Location: captain_login.php');

exit;
}
}
}
}

?>



<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>Grand Lakes Tennis | Match Scheduling Form</title>
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<link rel="icon" type="image/x-icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="../css/style.css" /> <!-- Main css file -->
<link rel="stylesheet" href="../css/import-css.css" />	<!-- This file imports all css files -->
<!--[if IE 8]><link rel="stylesheet" href="../css/ie8.css" /><![endif]-->	
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<script src="../js/jquery.js" ></script>
<script src="../js/jquery-core-plugins.js" ></script>
<script src="../js/jquery-plugins.js" ></script>
<script src="../js/jplayer.js" ></script>
<script src="../js/theme-settings.js"></script>
<script src="../js/portfolio-sortable.js" ></script>
<link rel="stylesheet" href="../css/style.css" type="text/css"/>	
<link rel="stylesheet" href="../css/table.css" type="text/css"/>	
		<script type="text/javascript">
            $(document).ready(function(){
               $('.striped tr:even').addClass('alt');
            });
        </script>

</head>
<body>

<!-- ____________________Top Header Start____________________ -->	

<div id="header">
	<div id="logosection">
		<a href="../index.html" title="Grand Lakes Tennis"><img src="../images/GrandLakesTennis-logo1.png" alt="Grand Lakes Tennis logo" /></a>
	</div>

	
<!-- Top Menu start -->
	<div class="top-menu">
		<ul class="sf-menu" id="nav">
			<!-- Tab 1 -->
			<li><a href="../index.html">Welcome</a>
			</li>
			<!-- Tab 2 -->
			<li class="active"><a href="../captains.php">Team Captains</a>							
			</li>
			<!-- Tab 4 -->
			<li><a href="../contact.php">Contact</a>
			</li>
		</ul>
	</div>
<!-- Top Menu End -->

</div> <!-- #header -->

<!-- ____________________Top Header End____________________ -->


<!-- ____________________Container Start____________________ -->

	<div id="container">
	
 <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>

		<div class="page-title">
			<h1>Court Usage Table</h1>
				<div class="captain-login-button2">
					<div class="pricing-table2-bottom">
						<a href="logout.php" class="button large square blue">Logout</a>
							<div class="messagebox"><div id="alert-message"></div>
							</div><!--  messagebox  -->
					</div>	<!-- pricing-table2-bottom -->
				</div>	<!-- captain-login-button2 -->

				<div class="captain-login">
					<div class="pricing-table2-bottom">
						<a href="reservation_form.php" class="button large square pink">Schedule a Match</a>
						</div>	<!-- pricing-table2-bottom -->
				</div><!--  captain-login  -->
		</div> <!--page-title -->
		
    <div class="logo">
         <h2><?php include('db.php'); ?></h2>

    </div>
    <form class="form-horizontal" id="login_form">
    	<div class="login_notification round5">
         <h2><?php echo "Hi ".$_SESSION['username']; ?></h2>
		 <h2>You are now logged in </h2>
    	</div><!-- login_notification -->
				
    <div id="content-top" class="sidebar-none">	

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
			<div class="table round5" id="tableView" style="width:940px;">
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
			
		
			<div class="clear"></div>
		</div> <!-- #content end -->
	</div> <!-- #container end -->

<!-- ____________________Container End____________________ -->

<!-- ____________________Footer Start____________________ -->

<div id="footer">
		<div class="small-footer">
		<div class="small-footer-content">
			<p class="left">&copy; Copyright 2014 by <a href="http://www.debswebsdesign.com" target="_blank">DebsWebs LLC</a>. All Rights Reserved. 
			 

		</div>
	</div>
</div>

<!-- ____________________Footer End____________________ -->

</body>
</html>