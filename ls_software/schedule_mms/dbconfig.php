<?php
$db_host = "50.62.151.36";
$db_user = "db2lsuser2021";
$db_pass = "^%D24L*!Ti5%";
$db_name = "dbs64065";

// Connect to remote MySQL Database for SMS operations
mysqli_report(MYSQLI_REPORT_OFF);
$con = new mysqli($db_host,$db_user,$db_pass,$db_name);

// Check connection
if ($con->connect_error) {
    error_log("schedule_mms remote DB unavailable: " . $con->connect_error);
    $con = null;
}
?>
