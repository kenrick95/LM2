<?php
#if ($_SERVER['REQUEST_URI']==$_SERVER['PHP_SELF']) { $_SERVER['HTTP_USER_AGENT'] }
#else {
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "lm2db";
	$konek = mysql_connect($host,$user,$pass);
	if (!$konek) {
		echo "Connection error : ".mysql_error();
	}
	mysql_select_db($db) or die ("Database not found ".mysql_error());
	$pass="";
	$user="";
	$host="";
#}
?>
