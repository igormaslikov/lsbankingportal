<?php
$host = "lsbankingportal.com"; 
//$host = "localhost"; 
$user = "dblsuser2021"; 
$password = "^%D24L*!Ti5%"; 
$database = "dbs57337"; 

// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
