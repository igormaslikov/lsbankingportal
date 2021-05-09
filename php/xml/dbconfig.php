<?php
$host = "lsbankingportal.com"; 
$user = "db2lsuser2021"; 
$password = "^%D24L*!Ti5%"; 
$database = "dbs64065"; 

// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>