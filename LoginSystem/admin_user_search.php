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
</head>
<script type="text/javascript">
    $(document).ready(function () {


        $("#search_user").submit(function () {


            var data1 = $('#search_user').serialize();
            $.ajax({
                type: "POST",
                url: "admin_search_process.php",
                data: data1,
                success: function (msg) {
                    console.log(msg);
                    $('.admin_rec').hide();
                    $('.admin_rec').html(msg);
                    $('.admin_rec').slideDown('slow');
                }
            });


            return false;


        });
    });
</script>
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

            <form class="form-horizontal" id="search_user" method="post">
                <h2>Search</h2>

                <div class="line"></div>
                <div class="control-group">
                    <input type="text" id="username" name="username" placeholder="Username">
                </div>
                <div class="control-group">
                    <input type="text" id="email" name="email" placeholder="Email">
                </div>

                <button
                    type="submit" class="btn btn-lg btn-primary btn-sign-in" data-loading-text="Loading...">Search
                </button>
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

<!-- Bootstrap core JavaScript -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<!-- Put this into a custom JavaScript file to make things more organized -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
</script>
</body>
</html>