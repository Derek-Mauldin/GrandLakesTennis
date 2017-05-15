<?php 
session_start();
session_destroy();
?>

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

<title>Grand Lakes Tennis | Court Reservation Form</title>
<meta name="description" content="Internal Grand Lakes League Tennis court reservation form"/>
<meta name="keywords" content=""/>
<link rel="icon" type="image/x-icon" href="/images/favicon.ico" />

  <!-- Bootstrap -->
   <!-- <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">  -->
	    <link href="LoginSystem/css/style.css" rel="stylesheet" media="screen">

<!-- CSS -->
<link href="css/structure.css" rel="stylesheet">
<link href="css/form.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css" /> <!-- Main css file -->
<link rel="stylesheet" href="css/import-css.css" />	<!-- This file imports all css files -->
<!--[if IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->	
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<script src="js/jquery.js" ></script>
<script src="js/jquery-core-plugins.js" ></script>
<script src="js/jquery-plugins.js" ></script>
<script src="js/jplayer.js" ></script>
<script src="js/theme-settings.js"></script>
<script src="js/portfolio-sortable.js" ></script>
			
	<!-- for browsers without @media query support -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script src="js/libs/modernizr-1.7.min.js"></script>



</head>
<body>

<!-- ____________________Top Header Start____________________ -->	

<div id="header">
	<div id="logosection">
		<a href="index.html" title="evolve"><img src="images/" alt="" /></a>
	</div>
	
<!-- Top Menu start -->
	<div class="top-menu">
		<ul class="sf-menu" id="nav">
			<!-- Tab 1 -->
			<li><a href="index.html">Welcome</a>
			</li>
			<!-- Tab 2 -->
			<li class="active"><a href="captains.php">Team Captains</a>							
			</li>
			<!-- Tab 4 -->
			<li><a href="contact.php">Contact</a>
			</li>
		</ul>
	</div>
<!-- Top Menu End -->

</div> <!-- #header -->

<!-- ____________________Top Header End____________________ -->


<!-- ____________________Container Start____________________ -->
<div id="container">

		<div class="page-title">
			<h1>Captain Login Form</h1>
			
		</div>
			<div class="clear"></div>

     <center>
   <script src="LoginSystem/js/jquery.js"></script>
    <script src="LoginSystem/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="LoginSystem/js/jquery.validate.js"></script>
    <div class="logo">
         <h2><?php include('LoginSystem/db.php'); echo $logotxt; ?></h2>

    </div>
    <form class="form-horizontal" id="register_form" method="post">
         <h2>Register</h2>

        <div class="line"></div>
        <div class="form-group">
            <input type="text" id="inputEmail" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="text" id="inputuserid" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" id="inputPassword" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="password" id="inputPassword_2" name="retype_password" placeholder="Retype Password">
        </div>	

<button type="submit"
        class="btn btn-lg btn-primary btn-sign-in" data-loading-text="Loading...">Register</button>
        	<a href="captain_login.php" class="btn btn-lg btn-register">Sign in</a>
        <div class="messagebox">
            <div id="alert-message"></div>
        </div>
    </form>
    <script>
        $(document).ready(function() {

		jQuery.validator.addMethod("noSpace", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
  }, "Spaces are not allowed");
  
            $("#register_form").submit(function() {

                $("#register_form").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        username: {
                            required: true,
							noSpace: true
                        },
                        password: {
                            required: true,
                            minlength: 6
                        },
                        retype_password: {
                            required: true,
                            equalTo: "#inputPassword"
                        },
                    },
                    messages: {
                        email: {
                            required: "Enter your email address",
                            email: "Enter valid email address"
                        },
                        username: {
                            required: "Enter Username",

                        },
                        password: {
                            required: "Enter your password",
                            minlength: "Password must be minimum 6 characters"
                        },
                        retype_password: {
                            required: "Enter confirm password",
                            equalTo: "Passwords must match"
                        },
                    },



                    errorPlacement: function(error, element) {
                        error.hide();
                        $('.messagebox').hide();
                        error.appendTo($('#alert-message'));
                        $('.messagebox').slideDown('slow');



                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).parents('.form-group').addClass('has-error');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).parents('.form-group').removeClass('has-error');
                        $(element).parents('.form-group').addClass('has-success');
                    }
                });

                if ($("#register_form").valid()) {
                    var data1 = $('#register_form').serialize();
                    $.ajax({
                        type: "POST",
                        url: "register.php",
                        data: data1,
                        success: function(msg) {
                            console.log(msg);
                            $('.messagebox').hide();
							$('#alert-message').html(msg);
							 $('.messagebox').slideDown('slow');
                        }
                    });
                }
                return false;
            });
        });
    </script>
 
     </center>
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