<?php
#if ($_SERVER['REQUEST_URI']==$_SERVER['PHP_SELF']) { $_SERVER['HTTP_USER_AGENT'] }
#else {
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "lm2db";
   
   $konek = mysqli_connect($host, $user, $pass, $db);
   
   if (mysqli_connect_errno($konek )) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   $pass="";
	$user="";
	$host="";
#}
?>
