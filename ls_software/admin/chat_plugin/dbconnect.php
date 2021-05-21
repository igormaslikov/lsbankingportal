<?php

	 $DBhost = "lsbankingportal.com";
	 $DBuser = "message_chat";
	 $DBpass = "admin$$123";
	 $DBname = "message_chat";
	 
	include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
	 $DBcon = new MySQLi($db_host,$db_user,$db_pass,$db_name);;
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
?>
