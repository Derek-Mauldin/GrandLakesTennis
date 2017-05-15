<?php session_start();
//logout if session not active
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP Login System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
</head>

<body>
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand"><a href="#">Admin</a></li>
            <li><a href="admin_home.php">Dashboard</a></li>
            <li><a href="admin_user_list.php">User List</a></li>
            <li><a href="admin_user_search.php">Search User</a></li>
			<li><a href="admin_user_add.php">Add new User</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Page content -->
    <div id="page-content-wrapper">

        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">

             <form class="form-horizontal" id="register_form" method="post">
         <h2>Add new user</h2>

        <div class="line"></div>
        <div class="form-group">
            <input type="text" id="inputEmail" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="text" id="inputuserid" name="username" placeholder="Username">
        </div>

<button type="submit"
        class="btn btn-lg btn-primary btn-sign-in" data-loading-text="Loading...">Add</button>
        <div class="messagebox">
            <div id="alert-message"></div>
        </div>
    </form>
            <div class="row">

                <div class="admin_rec">

                </div>
            </div>
        </div>
    </div>

</div>


<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
</script>
<script>
        $(document).ready(function() {

		jQuery.validator.addMethod("noSpace", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
  }, "Spaces are not allowed");
  $("#register_form").validate({
  onfocusout: false,
    onkeyup: false,
    onclick: false,
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

            $("#register_form").submit(function() {

                
                if ($("#register_form").valid()) {
                    var data1 = $('#register_form').serialize();
                    $.ajax({
                        type: "POST",
                        url: "admin_add_process.php",
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
</body>
</html>