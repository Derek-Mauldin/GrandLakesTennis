<!DOCTYPE html>
<html>
<head>   
 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<title>Grand Lakes Tennis | Captain Registration Form</title>

	<meta name="description" content=""/>
	<meta name="keywords" content=""/>

	<link rel="icon" type="image/x-icon" href="../images/favicon.ico" />
	<link rel="stylesheet" href="../css/style.css" /> <!-- Main css file -->
	<link rel="stylesheet" href="../css/import-css.css" />	<!-- This file imports all css files -->
	<!--[if IE 8]><link rel="stylesheet" href="../css/ie8.css" /><![endif]-->
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>


	<!-- Bootstrap -->
	<!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">  -->
	<link href="css/style.css" rel="stylesheet" media="screen">

	<!--Angular JS Libraries-->
	<?php $ANGULAR_VERSION = "1.5.6"; ?>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-messages.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-animate.js"></script>

	<script type="text/javascript" src="angular/app.js"></script>
	<script type="text/javascript" src="angular/services/signup-service.js"></script>
	<script type="text/javascript" src="angular/controllers/signup-controller.js"></script>


	<script src="js/bootstrap.min.js"></script>


    
</head>



<body ng-app="app.js">


    
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
			<h1>Captain Registration Form</h1>

		</div> <!-- page-title -->

		<div id="content" class="sidebar-none">			
		
		    <div class="logo">
         <h2><?php include('db.php'); echo $logotxt; ?></h2>

    </div>

	<div ng-controller="SignupController">

	<form class="form-horizontal" id="register_form" name="register_form" ng-submit="sendActivationToken(signupData, userSignUpForm.$valid);">
         <h2>Register</h2>

			<div class="line"></div>

			<fieldset class="form-group">
				<input type="text" id="email" name="email" placeholder="Email" ng-model="signupData.email" ng-minlength="5" ng-maxlength="32" ng-required="true">
				 <div class="alert alert-danger" role="alert" ng-messages="register_form.email.$error"
						ng-if="register_form.email.$touched" ng-hide="register_form.email.$valid">
					 <p ng-messages="minlength">Email must be at least 5 characters.</p>
					 <p ng-messages="maxlength">Email cannot be more than 32 characters.</p>
					 <p ng-messages="required">Please enter an email address.</p>
				 </div>
			</fieldset>

			<fieldset class="form-group">
				<input type="text" id="username" name="username" placeholder="username" ng-model="signupData.username" ng-minlength="2" ng-maxlength="16" ng-required="true">
				<div class="alert alert-danger" role="alert" ng-messages="register_form.username.$error"
					  ng-if="register_form.username.$touched" ng-hide="register_form.username.$valid">
					<p ng-messages="minlength">Username must be at least two characters.</p>
					<p ng-messages="maxlength">Username cannot be longer than 16 characters.</p>
					<p ng-messages="required">Please enter a username.</p>
				</div>
			</fieldset>

		<fieldset class="form-group">
			<input type="password" id="password" name="password" placeholder="password" ng-model="signupData.password" ng-minlength="6" ng-maxlength="10" ng-required="true">
			<div class="alert alert-danger" role="alert" ng-messages="register_form.password.$error"
				  ng-if="register_form.password.$touched" ng-hide="register_form.password.$valid">
				<p ng-messages="minlength">Password must be at least six characthers.</p>
				<p ng-messages="maxlength">Password cannot be longer than 10 characters.</p>
				<p ng-messages="required">Please enter a password.</p>
			</div>
		</fieldset>

		<fieldset class="form-group">
			<input type="password" id="retype_password" name="retype_password" placeholder=" confirm password" ng-model="signupData.retype_password" ng-minlength="6" ng-maxlength="10" ng-required="true">
			<div class="alert alert-danger" role="alert" ng-messages="register_form.retype_password.$error"
				  ng-if="register_form.retype_password.$touched" ng-hide="register_form.retype_password.$valid">
				<p ng-messages="minlength">Password must be at least six characthers.</p>
				<p ng-messages="maxlength">Password cannot be longer than 10 characters.</p>
				<p ng-messages="required">Please enter a password.</p>
			</div>
		</fieldset>

		<button type="submit" class="btn btn-lg btn-primary btn-sign-in" data-loading-text="Loading...">Register</button>

	</form>

	</div>

<!--
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
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        email: {
                            required: "Enter your email address",
                            email: "Enter valid email address"
                        },
                        username: {
                            required: "Enter Username"

                        },
                        password: {
                            required: "Enter your password",
                            minlength: "Password must be minimum 6 characters"
                        },
                        retype_password: {
                            required: "Enter confirm password",
                            equalTo: "Passwords must match"
                        }
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
						 console.log("data1 = ", data1);
                    $.ajax({
                        type: "POST",
                        url: "php/api/signup/index.php",
                        data: data1,
                        success: function(msg) {
                            console.log(msg);
									 console.log(msg.status);
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
    -->
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