<?php
session_start();
include("db.php");

$con = mysql_connect($server, $db_user, $db_pwd) //connect to the database server
or die ("Could not connect to mysql because " . mysql_error());

mysql_select_db($db_name) //select the database
or die ("Could not select to mysql because " . mysql_error());

//prevent sql injection
//$username=mysql_real_escape_string($_POST["username"]);
$password = mysql_real_escape_string($_POST["password1"]);
$username = $_SESSION['username'];

//check if user is in reset process
$query = "select * from " . $table_name . " where username='$username'  and activ_status='2'";
$result = mysql_query($query, $con) or die('error');
$row = mysql_fetch_array($result);
$email = $row['email'];

if (mysql_num_rows($result)) {
    $pwd = crypt($password);
    $query = "update " . $table_name . "	 set password='$pwd' , activ_status=1 where username='$username'";
    $result = mysql_query($query, $con) or die('error');


    //send email for the user with password

    $to = $email;
    $subject = "Password Reset";
    $body = "Hi " . $username .
        "<br /> Your new password is updated successfully<br />";

    $headers = "From:" . $from_address;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail($to, $subject, $body, $headers);
    echo "Password updated Successfully";
} else {
    echo "Cannot change password:User already active please login";
}
?>