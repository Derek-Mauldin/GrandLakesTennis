<?php session_start(); ?>  

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<meta content ="Internal Grand Lakes League Tennis captain contact form">
<link rel="icon" type="image/x-icon" href="/images/favicon.ico" />

	<title>Grand Lakes Tennis Leagues: Captain Contact Form</title>


	<link href="includes/reset.css" rel="stylesheet" type="text/css" media="all"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
			
	<!-- for browsers without @media query support -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script src="js/libs/modernizr-1.7.min.js"></script>



<!-- CSS -->
<link href="css/structure.css" rel="stylesheet">
<link href="css/form.css" rel="stylesheet">

</head>

<body>
<div id="content">
 <div id="container">

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
             
               
            <p id="success" class="<?php echo ($sr && $cf['form_ok']) ? 'visible' : ''; ?>">Your email has been sent.</p>
<!--  <div id="container" class="ltr">  -->

<!--Start Contact Form-->
				<div class="contact-form">
					<div id="contactdiv" style="clear:both;">
						<!-- Start is msg display -->
						<div id="msg"></div>
						<!-- End msg display -->

 <form action="captain-process.php" method="post" >
  

<ul>

<li id="teamname">
<label class="desc" id="teamname">
Select the Team
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
</option>
<option value="USTA Go-Getters" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['teamname'] == 'USTA Go-Getters') ? "selected='selected'" : '' ?>>
USTA Go-Getters
</option>




</select>
</div>
</li>

<li>
<label><strong>Name</strong> <span>(required)</span></label>	<br/>					
							<!--  <input name="name" id="name" value="" type="text" class="input-text" tabindex="1" />  -->
				<input class="input-text" type="text" id="name" name="name" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['name'] : '' ?>" placeholder="First Last" required autofocus />
</li>

<li>
<label><strong>Email</strong>  <span>(required)</span></label>	<br/>	
							<!--  <input name="email" id="email" value="" type="text" class="input-text" tabindex="2" />	-->					 <input class="input-text" type="email" id="email" name="email" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['email'] : '' ?>" placeholder="name@domain.com" required />
							
</li>
<li>	
<label><strong>Telephone</strong>  <span>(required)</span></label>	<br/>	
						               <!-- <label for="telephone">Telephone: </label>-->
                <input type="tel" id="telephone" name="telephone" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['telephone'] : '' ?>" placeholder="### ###-####"/>
</li>
<li>
<label><strong>Comments</strong>  <span>(required)</span></label><br/>
						<!--	<textarea name="message" id="message" cols="1" rows="3" class="input-textarea" tabindex="3"></textarea>  -->	 <textarea class="input-textarea" id="message" name="message" cols="35" rows="3" required data-minlength="20"><?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['message'] : '' ?></textarea>
</li>
<li>
		<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
							<p>Enter the characters above.
							<input type="text" name="captcha_code" size="2" maxlength="6" />
<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false"><span class="blue">Select a Different Image</span></a></p>
</li>				
<li>
			<span id="loading"></span>
					<input type="submit" name="submit" id="submit" value="Send Email" class="button small purple square" />
</li>

</ul>
</form> 
<?php 
	unset($_SESSION['cf_returndata']); 
?>
</div><!--container-->



</body>
</html>
