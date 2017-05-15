<?php
include("db.php");
$con = mysql_connect($server, $db_user, $db_pwd) //connect to the database server
or die ("Could not connect to mysql because " . mysql_error());

mysql_select_db($db_name) //select the database
or die ("Could not select to mysql because " . mysql_error());

//prevent sql injection
$username = mysql_real_escape_string($_POST["username"]);
$email = mysql_real_escape_string($_POST["email"]);

$username = trim($username);
$email = trim($email);

if (!empty($username)) {
    if (!empty($email))
        $query = "select * from " . $table_name . " where username='$username' and email='$email'";
    else
        $query = "select * from " . $table_name . " where username='$username'";
} else
    $query = "select * from " . $table_name . " where email='$email'";


$result = mysql_query($query, $con) or die('error');
$row = mysql_fetch_array($result);
//update user's activation key with new key
$re_activ_key = sha1(mt_rand(10000,99999).time().$email);
$activ_key = $row['activ_key'];

if (mysql_num_rows($result)) {
    //Update the activation status to 2-Reset in progress and new activation key 
    $query = "update " . $table_name . "	 set activ_status='2' , activ_key='$re_activ_key' where username='$username' and email='$email'";
    $result = mysql_query($query, $con) or die('error');

    $to = $row['email'];
    $subject = "Password Reset";
    $body = "Hi " . $row['username'] .
        "<br />Your account password has been reset: <a href=\"$url/reset.php?k=$re_activ_key\"> Please Click to set a new password</a><br /> <br /> Thanks";
    $headers = "From:" . $from_address;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail($to, $subject, $body, $headers);
	//echo $body;
    echo "Please Check your Email for resetting your password";
    //header('Content-type: application/json');
    // echo json_encode( array('result'=>1,'txt'=>"Password has been successfully sent to your Email Address"));
} else {
    //echo json_encode( array('result'=>0,'txt'=>"User account doesn't Exist"));
    echo "User account doesn't Exist";
}
?>
	