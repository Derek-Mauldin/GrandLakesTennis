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

<title>Grand Lakes Tennis | Captain Login Form</title>
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
 <!-- Bootstrap -->
	    <link href="css/style.css" rel="stylesheet" media="screen"> 

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
			<h1>Captain Login</h1>
			
		</div>
			<div class="clear"></div>

     
     
  <center>   
     <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <div class="logo">
         <h2><?php include('db.php'); echo $logotxt; ?></h2>
    </div>
    <form class="form-horizontal" id="login_form">
         <h2>Sign IN</h2>

        <div class="line"></div>
        <div class="form-group">
            <input type="text" id="inputEmail" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" id="inputPassword" name="password" placeholder="Password">
        </div> <a class="forgotten-password-link" href="forgot_password_form.php">Forgot password?</a>
	<a href="registration_form.php"
        class="btn btn-lg btn-register">Register</a>

        <button id="signin" type="submit" class="btn btn-lg btn-primary btn-sign-in"
        data-loading-text="Loading...">Sign in</button>
        <div class="messagebox">
            <div id="alert-message"></div>
        </div>
    </form>
  </center>
</script>
	<script type="text/javascript">
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client:plusone.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
    </script>
 <script>
        $(document).ready(function() {
		jQuery.validator.addMethod("noSpace", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
  }, "Spaces are not allowed");

  
  //add validator
$("#login_form").validate({
onfocusout: false,
    onkeyup: false,
    onclick: false,
					rules: {
                        username: {
                            required: true,
							noSpace: true
                        },
                        password: {
                            required: true,
                            minlength: 6
                        }
                    },

                    messages: {
                        username: {
                            required: "Enter your username&nbsp;&nbsp;&nbsp;&nbsp;"
                                                    },
                        password: {
                            required: "Enter your password",
                            minlength: "Password must be minimum 6 characters"
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
				
            $("#login_form").submit(function() {
				$('.social').hide('slow');
                if ($("#login_form").valid()) {
				$('.messagebox').slideUp('slow');
                    var data1 = $('#login_form').serialize();
					$("button").button('loading');
                    $.ajax({
                        type: "POST",
                        url: "login.php",
                        data: data1,
						dataType: 'json',
                        success: function(msg) {
							
                            if (msg.result == 1) {
							$('.messagebox').addClass("success-message");
							$('.message').slideDown('slow');
							$('#alert-message').text("Logged in.. Redirecting");
							
                                $('#login_form').fadeOut(5000);
								//$("button").button('reset');
                                window.location = "reservation_table.php"
                            } else {	
							$("button").button('reset');
							console.log(msg.result);
							$('.messagebox').hide();
							$('.messagebox').addClass("error-message");
							$('#alert-message').html(msg.result);
							 $('.messagebox').slideDown('slow');
							}
                        }
                    });
                }
                return false;
            });
        
        });
		

    </script>
 

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