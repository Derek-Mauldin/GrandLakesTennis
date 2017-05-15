<?php session_start(); ?>
<!DOCTYPE html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<title>Grand Lakes Tennis | Password Reset Form</title>
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
			<div class="captain-login">
				<div class="pricing-table2-bottom">
						<a href="captain_login.php" class="button large square pink">Captain Login</a>
				</div>	<!-- pricing-table2-bottom -->
			</div>	<!--  captain-login  -->
		</div>
			<div class="clear"></div>

     
     
  <center>   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <div class="logo">
         <h2><?php include('db.php'); echo $logotxt; ?></h2>

    </div>
	<form class="form-horizontal" id="reset_pwd" method="post">
         <h2>Reset Password</h2>

        <div class="line"></div>
	<?php
	include("db.php");
	 $con=mysql_connect($server, $db_user, $db_pwd) //connect to the database server
	or die ("Could not connect to mysql because ".mysql_error());
	$key=mysql_real_escape_string($_GET["k"]);
	if (!empty($key))
{
	

	mysql_select_db($db_name)  //select the database
	or die ("Could not select to mysql because ".mysql_error());

	//query database to check activation code
	$query="select * from ".$table_name." where activ_key='$key' and activ_status='2'";
	$result=mysql_query($query,$con) or die('error');

		 if (mysql_num_rows($result))
		 {
			 $row=mysql_fetch_array($result);
			 if ($row['activ_status']='2')
			 {
			 $username=trim($row['username']);
			 $_SESSION['username'] = $username;
			 //html
			 ?>
			 
		
		
        <div class="control-group">
            <input type="password" id="password1" name="password1" placeholder="Password">
        </div>
        <div class="control-group">
            <input type="password" id="password2" name="password2" placeholder="Retype Password">
        </div>	

        <button
        type="submit" class="btn btn-lg btn-primary btn-sign-in" data-loading-text="Loading...">Reset</button>
		
            <div class="messagebox">
                <div id="alert-message"></div>
            </div>
   
		<?	 }
			 else
			 {
				echo "<div class=\"messagebox\"><div id=\"alert-message\">You can login</div></div>"; 
			 }
			 
		 }
		 else
		 {
			 echo "<div class=\"messagebox\"><div id=\"alert-message\">You can login</div></div>";
			 //header('Location: $url');
		 }
}
else
	echo "<div class=\"messagebox\"><div id=\"alert-message\">error</div></div>";
	
	?>
    
	 </form>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#reset_pwd').validate({
                debug: true,
                rules: {
                    password1: {
                        minlength: 6,
                        required: true
                    },
                    password2: {
                        required: true,
                         minlength: 6,
						 equalTo: "#password1"
                    }
                },
				messages: {
                        password1: {
                            required: "Enter password "
                        },
                        password2: {
                            required: "Retype your password",
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
                        $(element).parents('.control-group').addClass('error');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).parents('.control-group').removeClass('error');
                        $(element).parents('.control-group').addClass('success');
                    }
            });




            $("#reset_pwd").submit(function() {

                if ($("#reset_pwd").valid()) {
                    var data1 = $('#reset_pwd').serialize();
                    $.ajax({
                        type: "POST",
                        url: "process_reset.php",
                        data: data1,
                        success: function(msg) {
							 console.log(msg);
							 
							$('.messagebox').hide();
							$('.messagebox').addClass("error-message");
							$('#alert-message').html(msg);
							 $('.messagebox').slideDown('slow');
                           
							
							
							
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