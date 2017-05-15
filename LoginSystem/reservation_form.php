<?php 
session_start();?>

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>Grand Lakes Tennis | Court Usage Form</title>
<meta name="description" content="Internal Grand Lakes League Tennis court reservation form"/>
<meta name="keywords" content=""/>
<link rel="icon" type="image/x-icon" href="../images/favicon.ico" />
<!-- CSS -->
<link href="../css/structure.css" rel="stylesheet">
<link href="../css/form.css" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css" /> <!-- Main css file -->
<link rel="stylesheet" href="../css/import-css.css" />	<!-- This file imports all css files -->
<!--[if IE 8]><link rel="stylesheet" href="../css/ie8.css" /><![endif]-->	
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<script src="../js/jquery.js" ></script>
<script src="../js/jquery-core-plugins.js" ></script>
<script src="../js/jquery-plugins.js" ></script>
<script src="../js/jplayer.js" ></script>
<script src="../js/theme-settings.js"></script>
<script src="../js/portfolio-sortable.js" ></script>
			
	<!-- for browsers without @media query support -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script src="../js/libs/modernizr-1.7.min.js"></script>


<!--   DatePicker  -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/overcast/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({
	    beforeShowDay: $.datepicker.noWeekends,
	    numberOfMonths: 2,
	    showOtherMonths: false,
		selectOtherMonths: true
    });
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

		<div class="page-title">
			<h1>Match Scheduling Form</h1>
			<div class="captain-login">
				<div class="pricing-table2-bottom">
						<a href="reservation_form.php" class="button large square pink">Schedule Another Match</a>
				</div>	<!-- pricing-table2-bottom -->
			</div> <!--captain-login -->
			<div class="captain-login-button2">
				<div class="pricing-table2-bottom">
						<a href="reservation_table.php" class="button large square pink">View the Court Usage Table</a>
				</div>	<!-- pricing-table2-bottom -->
			</div><!-- captain-login-button2 -->

			
		</div> <!-- page-title  -->
			<div class="clear"></div>

        <div id="contact-form" class="clearfix">
      <?php
      
     

			//init variables
			$cf = array();
			$sr = false;
			
			if(isset($_SESSION['cf_returndata'])){
				$cf = $_SESSION['cf_returndata'];
			 	$sr = true;
			}
            ?>
            <ul id="errors" class="<?php echo ($sr && !$cf['form_ok']) ? 'visible' : ''; ?>">
                <li id="info">There were some problems with your form submission:</li>
                <?php 
				if(isset($cf['errors']) && count($cf['errors']) > 0) :
					foreach($cf['errors'] as $error) :
				?>
                <li><?php echo $error ?></li>
                <?php
					endforeach;
				endif;
				?>
            </ul>
             
               
            <p id="success" class="<?php echo ($sr && $cf['form_ok']) ? 'visible' : ''; ?>">Your scheduled match has been completed.</p>
<!--  <div id="container" class="ltr">  -->


 <form action="process.php" method="post" id="reservationForm" class="round5">
  
<header class="info">
<h1>Match Scheduling Form</h1>
<p>Please fill out the form below to schedule your match(es).</p>
</header>

<ul>

<li id="teamname">
<label class="desc" id="teamname">
Select Your Team
<span id="req_1" class="req">*</span>
</label>
<div>
<select id="teamname" name="teamname" class="field select medium" tabindex="1">
<option value="" selected="selected">
</option>
<option value="WHLTA Get-A-Grip" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'WHLTA Get-A-Grip') ? "selected='selected'" : '' ?>>
WHLTA Get-A-Grip
</option>
<option value="WHLTA Twisted Sisters" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'WHLTA Twisted Sisters') ? "selected='selected'" : '' ?>>
WHLTA Twisted Sisters
</option>
<option value="WHLTA Double the Fun" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'WHLTA Double the Fun') ? "selected='selected'" : '' ?>>
WHLTA Double the Fun
</option>
<option value="WHLTA Double Shots" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'WHLTA Double Shots') ? "selected='selected'" : '' ?>>
WHLTA Double Shots
</option>
<option value="WHLTA Volley Girls" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'WHLTA Volley Girls') ? "selected='selected'" : '' ?>>
WHLTA Volley Girls
</option>
<option value="WHLTA Smart Aces" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'WHLTA Smart Aces') ? "selected='selected'" : '' ?>>
WHLTA Smart Aces
</option>
<option value="HLTA Got Tennis?" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'HLTA Got Tennis?') ? "selected='selected'" : '' ?>>
HLTA Got Tennis?
</option>
<option value="HLTA Casual Sets" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'HLTA Casual Sets') ? "selected='selected'" : '' ?>>
HLTA Casual Sets
</option>
<option value="HLTA Mood Swings" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'HLTA Mood Swings') ? "selected='selected'" : '' ?>>
HLTA Mood Swings
</option>
<option value="HLTA Double Trouble" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'HLTA Double Trouble') ? "selected='selected'" : '' ?>>
HLTA Double Trouble
</option><option value="USTA Alley Cats" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'USTA Alley Cats') ? "selected='selected'" : '' ?>>
USTA Alley Cats
</option>
</option><option value="USTA Go-Getters" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'USTA Go-Getters') ? "selected='selected'" : '' ?>>
USTA Go-Getters
</option>
</option><option value="KAT Ladies 4.0 Summer Warm-Up" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'KAT Ladies 4.0 Summer Warm-Up') ? "selected='selected'" : '' ?>>
KAT Ladies' 4.0 Summer Warm-Up
</option>


</select>
</div>
</li>


<li id="reservationdate">
<label class="desc" id="reservationdate" for="reservationdate">
Date
<span id="req_1" class="req">*</span>
</label>
<div>
<span>
<input type="text" name="reservationdate" id="datepicker" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['reservationdate'] : '' ?>" tabindex="2" />
</span>
</div>
</li>


<li id="reservationtime">
<label class="desc" id="reservationtime" for="reservationtime">
Time
<span id="req_1" class="req">*</span>
</label>
<div>
<select id="reservationtime" name="reservationtime" class="field select small" tabindex="3" >
<option value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['reservationtime'] : '' ?>" selected="selected">
</option>
<option value="9:00 & 10:30" >
9:00 & 10:30
</option>
<option value="8:00" >
8:00
</option>
<option value="8:30" >
8:30
</option>
<option value="9:00" >
9:00
</option>
<option value="9:30" >
9:30
</option>
<option value="10:00" >
10:00
</option>
<option value="10:30" >
10:30
</option>
<option value="11:00" >
11:00
</option>
<option value="11:30" >
11:30
</option>
<option value="12:00" >
12:00
</option>
<option value="12:30" >
12:30
</option>
<option value="1:00" >
1:00
</option>
<option value="1:30" >
1:30
</option>
<option value="2:00" >
2:00
</option>
<option value="2:30" >
2:30
</option>
<option value="3:00" >
3:00
</option>
<option value="3:30" >
3:30
</option>
<option value="4:00" >
4:00
</option>
<option value="4:30" >
4:30
</option>
<option value="5:00" >
5:00
</option>
<option value="5:30" >
5:30
</option>
<option value="6:00" >
6:00
</option>
<option value="6:30" >
6:30
</option>
<option value="7:00" >
7:00
</option>
<option value="7:30" >
7:30
</option>
<option value="8:00" >
8:00
</option>
</select>
</div>
</li>


<li id="court" class="threeColumns">
<fieldset>
<!--[if !IE | (gte IE 8)]>
<legend id="courts" class="desc">
Please select the courts you would like to reserve for this time.<span id="req_3" class="req">*</span>
</legend>
<![endif]>
<!--[if lt IE 8]>
<label id="courts" class="desc">
Please select the courts you would like to reserve for this time.
</label>
<![endif]-->
<div>
<span>
<input id="court" name="court[]" type="checkbox" class="field checkbox" value="Spray Park 1"  <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['court[]'] == 'Spray Park 1') ? "selected='selected'" : '' ?> tabindex="9" />
<label class="choice" >Spray Park 1</label>
</span>
<span>
<input id="court" name="court[]" type="checkbox" class="field checkbox" value="South 1" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['court[]'] == 'South 1') ? "selected='selected'" : '' ?> tabindex="10" />
<label class="choice" >South 1</label>
</span>
<span>
<input id="court" name="court[]" type="checkbox" class="field checkbox" value="North 1" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['court[]'] == 'North 1') ? "selected='selected'" : '' ?> tabindex="11" />
<label class="choice" >North 1</label>
</span>
<span>
<input id="court" name="court[]" type="checkbox" class="field checkbox" value="Spray Park 2" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['court[]'] == 'Spray Park 2') ? "selected='selected'" : '' ?> tabindex="12" />
<label class="choice">Spray Park 2</label>
</span>
<span>
<input id="court" name="court[]" type="checkbox" class="field checkbox" value="South 2" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['court[]'] == 'South 2') ? "selected='selected'" : '' ?> tabindex="13" />
<label class="choice">South 2</label>
</span>
<span>
<input id="court" name="court[]" type="checkbox" class="field checkbox" value="North 2" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['court[]'] == 'North 2') ? "selected='selected'" : '' ?> tabindex="14" />
<label class="choice">North 2</label>
</span>
</div>
</fieldset>
</li>
<li id="foli206" class="twoColumns">
<fieldset>
<!--[if !IE | (gte IE 8)]>
<legend id="title206" class="desc">
Please select the reason for this court reservation.
<span id="req_206" class="req">*</span>
</legend>
<![endif]>
<!--[if lt IE 8]>
<label id="title206" class="desc">
Please select the reason for this court reservation.
<span id="req_206" class="req">*</span>
</label>
<![endif]-->
<div>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="WHLTA Regularly Scheduled Match" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'WHLTA Regularly Scheduled Match') ? "selected='selected'" : '' ?> tabindex="15"  />
<label class="choice" for="reservationtype">WHLTA Regularly Scheduled Match</label>
</span>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="WHLTA Rain Make Up" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'WHLTA Rain Make Up') ? "selected='selected'" : '' ?> tabindex="17"  />
<label class="choice" for="reservationtype">WHLTA Rain Make Up</label>
</span>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="HLTA Regularly Scheduled Match" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'HLTA Regularly Scheduled Match') ? "selected='selected'" : '' ?> tabindex="16"  />
<label class="choice" for="reservationtype">HLTA Regularly Scheduled Match</label>
</span>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="HLTA Rain Make Up" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'HLTA Regularly Scheduled Match') ? "selected='selected'" : '' ?> tabindex="18"  />
<label class="choice" for="reservationtype">HLTA Rain Make Up</label>
</span>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="KAT Regularly Scheduled Match" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'KAT Regularly Scheduled Match') ? "selected='selected'" : '' ?> tabindex="18"  />
<label class="choice" for="reservationtype">KAT Regularly Scheduled Match</label>
</span>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="KAT Rain Make Up" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'KAT Rain Make Up') ? "selected='selected'" : '' ?> tabindex="18"  />
<label class="choice" for="reservationtype">KAT Rain Make Up</label>
</span>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="USTA Regularly Scheduled Match" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'USTA Regularly Scheduled Match') ? "selected='selected'" : '' ?> tabindex="18"  />
<label class="choice" for="reservationtype">USTA Regularly Scheduled Match</label>
</span>
<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="USTA Rain Make Up" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'USTA Rain Make Up') ? "selected='selected'" : '' ?> tabindex="18"  />
<label class="choice" for="reservationtype">USTA Rain Make Up</label>
</span>

<span>
<input id="reservationtype" name="reservationtype" type="radio" class="field checkbox" value="Team Drill" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['reservationtype'] == 'Team Drill') ? "selected='selected'" : '' ?> tabindex="19"  />
<label class="choice" for="reservationtype">Team Drill</label>
</span>
</div>
</fieldset>
</li> 

<li class="buttons ">
<div>
<input type="reset" name="reset" value="reset">
<input name="submit" class="btTxt submit" type="submit" value="Submit Match"/>
</div>
</li>

</ul>
</form> 
<?php 
	unset($_SESSION['cf_returndata']); 
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