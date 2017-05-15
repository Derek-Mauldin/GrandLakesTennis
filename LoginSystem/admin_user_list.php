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
        <div class="content-header">
            <h1>
                <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
                User List
            </h1>
        </div>
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">

            <div class="row">
                <div class="admin_rec">
                    <?php
					$pg=10;  //users per page
                    include("db.php");
                    $con = mysql_connect($server, $db_user, $db_pwd) //connect to the database server
                    or die ("Could not connect to mysql because " . mysql_error());

                    mysql_select_db($db_name) //select the database
                    or die ("Could not select to mysql because " . mysql_error());
					$query = "SELECT username FROM " . $table_name . " UNION ALL SELECT username FROM " . $table_name_social;
					$result = mysql_query($query, $con) or die('error');
					$num_rows = mysql_num_rows($result);
					//echo $num_rows;

                    //check if user exist already
                    //$query="select * from ".$table_name;
					if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
					$start_from = ($page-1) * $pg; 
					
                    $query = "SELECT username, case when activ_status='0' then 'Not Activated' when activ_status='1' then 'activated' end as activ_status,  'email' as source FROM " . $table_name . " UNION ALL SELECT username,  'activated', source FROM " . $table_name_social." order by username desc  LIMIT ".$start_from.", ".$pg; 
					//echo $query;
					$result = mysql_query($query, $con) or die('error');
					$count=($pg*($page-1))+1;
					
                    if (mysql_num_rows($result)) //if exist then check for password
                    {
                        echo "<table class=\"table table-bordered\">";

                        echo "<thead><tr><th>UserName</th><th>Activation Status</th><th>Source</th></thead>";
                        while ($db_field = mysql_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $db_field['username'] . "</td><td> " . $db_field['activ_status'] . " </td><td> <span ";
                            if ($db_field['source'] == 'Twitter') {
                                echo "class=\"label label-info\"";
                            } elseif ($db_field['source'] == 'facebook') {
                                echo "class=\"label label-primary\"";
                            } elseif ($db_field['source'] == 'Google') {
                                echo "class=\"label label-danger\"";
                            } else {
                                echo "class=\"label label-default\"";
                            }
                            echo ">" . $db_field['source'] . " </span></td></tr>";

                        }
                        echo "</table>";
						$total_pages = ceil($num_rows / $pg);
						echo "Page : ";
						for ($i=1; $i<=$total_pages; $i++) { 
							echo "  <b><a href='admin_user_list.php?page=".$i."'>".$i."</a></b> "; 
							};

                    } else {
                        die("Username Doesn't exist");
                    }

                    ?>

                    
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