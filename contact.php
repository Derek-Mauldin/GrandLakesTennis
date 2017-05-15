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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>Grand Lakes Tennis</title>
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<link rel="icon" type="image/x-icon" href="/images/favicon.ico" />
<link rel="stylesheet" href="css/CFStyles.css" title="Grand Lakes Tennis CSS" type="text/css" media="screen">
<link rel="stylesheet" href="css/style.css" /> <!-- Main css file -->
<link rel="stylesheet" href="css/import-css.css" />	<!-- This file imports all css files -->
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- for browsers without @media query support -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script src="js/libs/modernizr-1.7.min.js"></script>


<!--[if IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->	
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<script src="js/jquery.js" ></script>
<script src="js/jquery-core-plugins.js" ></script>
<script src="js/jquery-plugins.js" ></script>
<script src="js/jplayer.js" ></script>
<script src="js/theme-settings.js"></script>
<script src="js/portfolio-sortable.js" ></script>

 <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>
<body>

<!-- ____________________Top Header Start____________________ -->	

<div id="header">
	<div id="logosection">
		<a href="index.html" title="Grand Lakes Tennis"><img src="images/GrandLakesTennis-logo1.png" alt="Grand Lakes Tennis logo" /></a>
	</div>

	
<!-- Top Menu start -->
	<div class="top-menu">
		<ul class="sf-menu" id="nav">
			<!-- Tab 1 -->
			<li><a href="index.html">Welcome</a>
			</li>
			<!-- Tab 2 -->
			<li><a href="captains.php">Team Captains</a>							
			</li>
			<!-- Tab 4 -->
			<li class="active"><a href="contact.php">Contact</a>
			</li>
		</ul>
	</div>
<!-- Top Menu End -->

</div> <!-- #header -->
<div class="header-bottom-border"></div>
<!-- ____________________Top Header End____________________ -->

<!-- ____________________Container Start____________________ -->

	<div id="container">

		<div class="page-title">
			<h1>Contact Us</h1>

		</div>

		<div id="content" class="sidebar-none">
			<div id="map" style="width: 100%; height: 400px;"></div>
			<script type="text/javascript">
				// Define your locations: HTML content for the info window, latitude, longitude
				var locations = [
					['<h4>North</h4>',29.717923,-95.769255],
					['<h4>South</h4>', 29.707896,-95.768550],
					['<h4>Spray Park</h4>', 29.710246,-95.757512],
				];
    
				// Setup the different icons and shadows
    
				var icons = [
				'images/map-marker-green.png',
				'images/map-marker-blue.png',
				'images/map-marker-purple.png'
				]
				var icons_length = icons.length;
				
				var map = new google.maps.Map(document.getElementById('map'), {
				 zoom: 14,
				 center: new google.maps.LatLng(29.713625,-95.764244),
				 mapTypeId: google.maps.MapTypeId.ROADMAP,
				 mapTypeControl: false,
				 streetViewControl: false,
				 panControl: false,
				 zoomControlOptions: {
					 position: google.maps.ControlPosition.LEFT_BOTTOM
					 }
				});
				var infowindow = new google.maps.InfoWindow({
					maxWidth: 160
				});
				var marker, i;
				for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

    function AutoCenter() {
      //  Create a new viewpoint bound
      var bounds = new google.maps.LatLngBounds();
      //  Go through each...
      $.each(markers, function (index, marker) {
        bounds.extend(marker.position);
      });
      //  Fit these bounds to the map
      map.fitBounds(bounds);
    }
    AutoCenter();
  </script> 
			<div class="clear"></div>
			<div class="divider"></div>

			<div class="two_third">
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
             <p id="success" class="<?php echo ($sr && $cf['form_ok']) ? 'visible' : ''; ?>">Thanks for your message! We will get back to you ASAP!</p>

				<h4>Get in touch</h4>
								<p>Please use the form below to contact us if you would like more information about tennis in Grand Lakes or if you  have any questions about the website.</p>

				<!--Start Contact Form-->
				<div class="contact-form">
					<div id="contactdiv" style="clear:both;">
						<!-- Start is msg display -->
						<div id="msg"></div>
						<!-- End msg display -->
						
						<form method="post" action="contact_process.php">							
							<div class="one_third">
							<label><strong>Name</strong> <span>(required)</span></label>						
							<!--  <input name="name" id="name" value="" type="text" class="input-text" tabindex="1" />  -->
							<input class="input-text" type="text" id="name" name="name" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['name'] : '' ?>"  Placeholder="First Last" required autofocus />

							</div>							
							
							<div class="one_third">
							<label><strong>Your Email</strong>  <span>(required)</span></label>		
							<!--  <input name="email" id="email" value="" type="text" class="input-text" tabindex="2" />	-->						            <input class="input-text" type="email" id="email" name="email" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['email'] : '' ?>"  Placeholder="name@domain.com" required />
							</div>
							<div class="one_third">
							<label><strong>Who should this email go to? </strong>  <span>(required)&nbsp;</span></label>		
							<select id="contact" name="contact" class="field select medium" tabindex="1">
								
								<option value="More Information" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']											['contact'] == 'More Information') ? "selected='selected'" : '' ?>>
									More Information
								</option>
								<option value="Webmaster" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['contact'] == 									'Webmaster') ? "selected='selected'" : '' ?>>
									Webmaster
								</option>
							</select>
								<br/><br/><br/>
							</div>
						

							<div class="two_third">		
							
							<label><strong>Comments</strong>  <span>(required)</span></label>
						<!--	<textarea name="message" id="message" cols="1" rows="3" class="input-textarea" tabindex="3"></textarea>  -->					 <textarea class="input-textarea" id="message" name="message" required data-minlength="20"><?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['message'] : '' ?></textarea>

							<br/><br/>
							<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
							<p>Enter the characters above.
							<input type="text" name="captcha_code" size="6" maxlength="6" />
<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false"><span class="blue">Select a Different Image</span></a></p>
					     <span id="loading"></span>
							<input type="submit" name="submit" id="submit" value="Send Email" class="button small purple square" />
							</div>
						</form>
	       <?php unset($_SESSION['cf_returndata']); ?>
	       
					</div> <!-- End Contactdiv -->
				
	
				</div> <!-- contact-form -->	

			</div>

			<div class="one_third last">
					
						<h4>Contact Info</h4>
						

						<div>							
							<ul class="the_icons">
								<li class="icon-phone">281-828-2840</li>
								<li class="icon-envelope"><a href="mailto:smbrice4@comcast.net">smbrice4@comcast.net</a></li>
							</ul>
						<div class="clear"></div>
						<br />
							<hr>
							<br/>
								<h3>Court Locations</h3>
									<ul class="ordered_list">
										<li><strong>Grand Lakes North:</strong> <br/>5608 Grand Vista Lane, Katy, TX  77494 (at the intersection of Grand Vista Lane and N. Pavilion Park Circle)</li>
										<li><strong>Grand Lakes South:</strong> <br/>22419 Coral Chase Ct., Katy, TX  77494 (at the intersection of Chadway Crossing and Emily Park Lane)</li>
										<li><strong>Grand Lakes Spray Park:</strong> <br/>E Grand Brooks, Katy, TX 77450 (at the intersection of E. Grand Brooks and Emily Park Lane)</li>
									</ul>
						</div>

						<div class="clear"></div><br />
					
				</div>

			<div class="clear"></div>
		</div> <!-- #content end -->
	</div> <!-- #container end -->

<!-- ____________________Container End____________________ -->

<!-- ____________________Footer Start____________________ -->

<div id="footer">
		<div class="small-footer">
		<div class="small-footer-content">
			<p class="left">&copy; Copyright 2015 by <a href="http://www.debswebsdesign.com" target="_blank">DebsWebs LLC</a>. All Rights Reserved. 
			 

		</div>
	</div>
</div>

<!-- ____________________Footer End____________________ -->

</body>
</html>