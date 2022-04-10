<?php
$host = "pacificafinancegroup.com/loanportal/"; 
$user = "dblsuser2021"; 
$password = "^%D24L*!Ti5%"; 
$database = "dbs57337"; 

// Connect to MySQL Database
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
$con = new mysqli($db_host,$db_user,$db_pass,$db_name);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>