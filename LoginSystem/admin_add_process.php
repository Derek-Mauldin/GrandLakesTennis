<?php
	include("db.php");

	 $con=mysql_connect($server, $db_user, $db_pwd) //connect to the database server
	or die ("Could not connect to mysql because ".mysql_error());

	mysql_select_db($db_name)  //select the database
	or die ("Could not select to mysql because ".mysql_error());

//prevent sql injection
$username=mysql_real_escape_string($_POST["username"]);
$email=mysql_real_escape_string($_POST["email"]);
	
//check if user exist already
$query="select * from ".$table_name." where username='$username'";
$result=mysql_query($query,$con) or die('error');
if (mysql_num_rows($result))
  {
 die($msg_reg_user);
  }
  //check if user exist already
$query="select * from ".$table_name." where email='$email'";
$result=mysql_query($query,$con) or die('error');
if (mysql_num_rows($result))
  {
die($msg_reg_email);

  }
  
 
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $password=substr(str_shuffle($chars),0,8);
	
	$activ_key = sha1(mt_rand(10000,99999).time().$email);
	$hashed_password = crypt($password); 
	$query="insert into ".$table_name."(username,password,email,activ_key) values ('$username','$hashed_password','$email','$activ_key')";
	
	if (!mysql_query($query,$con))
  {
die('Error: ' . mysql_error());

  }
 
  //send email for the user with password
	
	$to=$email;
	$subject="New Registration";
	$body="Hi ".$username.
	"<br /> Thanks for your registration.<br />".
	"Your password is ".$password."<br />".
	"Click the below link to activate your account<br />".
	"<a href=\"$url/activate.php?k=$activ_key\"> Activate Account </a>";
	
	
	$headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .="From:".$from_address . "\r\n";;
	
	
	
	mail($to,$subject,$body,$headers);
	echo $msg_reg_activ;
	 
?>