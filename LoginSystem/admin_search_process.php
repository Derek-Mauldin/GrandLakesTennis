<?php

include("db.php");
$con = mysql_connect($server, $db_user, $db_pwd) //connect to the database server
or die ("Could not connect to mysql because " . mysql_error());

mysql_select_db($db_name) //select the database
or die ("Could not select to mysql because " . mysql_error());

$username = mysql_real_escape_string($_POST["username"]);
$email = mysql_real_escape_string($_POST["email"]);


$query = "SELECT username, case when activ_status='0' then 'Not Activated' when activ_status='1' then 'activated' end as activ_status,  'email' as source FROM " . $table_name . " where email='" . $email . "' or username='" . $username . "' UNION ALL SELECT username,  'activated', source FROM " . $table_name_social . " where email='" . $email . "' or username='" . $username . "'";
$result = mysql_query($query, $con) or die('error');
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

} else {
    die("Username Doesn't exist");
}

?>