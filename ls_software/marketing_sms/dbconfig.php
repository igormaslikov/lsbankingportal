<?php
$db_host = "50.62.151.36"; 
$db_user = "db2lsuser2021"; 
$db_pass = "^%D24L*!Ti5%"; 
$db_name = "dbs64065"; 

// Connect to MySQL Database
//include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
$con = new mysqli($db_host,$db_user,$db_pass,$db_name);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>

<?php

	 $DBhost = "pacificafinancegroup.com/loanportal/";
	 $DBuser = "dblsuser2021";
	 $DBpass = "^%D24L*!Ti5%";
	 $DBname = "dbs57337";
	 
	include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
	 $DBcon = new MySQLi($db_host,$db_user,$db_pass,$db_name);;
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
?>
