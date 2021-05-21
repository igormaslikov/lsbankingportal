<?php
$host = "lsbankingportal.com"; 
$user = "android_devloper"; 
$password = "vvP8qe083iL9"; 
$database = "database_android"; 

// Connect to MySQL Database
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
$con = new mysqli($db_host,$db_user,$db_pass,$db_name);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
