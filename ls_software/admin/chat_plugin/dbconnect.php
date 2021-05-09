<?php

	 $DBhost = "lsbankingportal.com";
	 $DBuser = "message_chat";
	 $DBpass = "admin$$123";
	 $DBname = "message_chat";
	 
	 $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
?>
