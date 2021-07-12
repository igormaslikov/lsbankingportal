<?php

	 $DBhost = "mymoneyline.com/lsbankingportal/";
	 //$DBhost = "localhost";
	 $DBuser = "dblsuser2021";
	 $DBpass = "^%D24L*!Ti5%";
	 $DBname = "dbs57337";

	//include($_SERVER['DOCUMENT_ROOT'].'/dbconnection.php');
	require_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
	$DBcon = new MySQLi($db_host,$db_user,$db_pass,$db_name);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
?>
