<?php
$host = "localhost"; 
$user = "message_chat"; 
$password = "admin$$123"; 
$database = "message_chat"; 

// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>