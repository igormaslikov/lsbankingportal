<?php
$host = "localhost"; 
$user = "android_devloper"; 
$password = "vvP8qe083iL9"; 
$database = "dbs57337"; 

// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
