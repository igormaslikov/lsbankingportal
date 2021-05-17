<?php

	 $DBhost = "lsbankingportal.com";
	 //$DBhost = "localhost";
	 $DBuser = "dblsuser2021";
	 $DBpass = "^%D24L*!Ti5%";
	 $DBname = "dbs57337";
	 
	 $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
?>
