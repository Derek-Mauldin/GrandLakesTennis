<?php
session_start();
	include("db.php");
	 $con=mysql_connect($server, $db_user, $db_pwd) //connect to the database server
	or die ("Could not connect to mysql because ".mysql_error());
	mysql_select_db($db_name)  //select the database
	or die ("Could not select to mysql because ".mysql_error());
	//prevent sql injection
	$username=mysql_real_escape_string($_POST["username"]);
	$password=mysql_real_escape_string($_POST["password"]);
	
	if($username==$admin_user)
	{
	if($password==$admin_password)
	{
	echo json_encode( array('result'=>1));
		//echo 1;  //return success
		$_SESSION['admin'] = true;		
	}
	else
	{
	echo json_encode( array('result'=>$msg_admin_pwd));
	//echo "Incorect password";
	}
	}
	else
	{
	echo json_encode( array('result'=>$msg_admin_user));
	//echo "Username Doesn't exist";
	}
	
	
	

?>