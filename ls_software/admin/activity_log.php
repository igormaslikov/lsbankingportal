<?php
include('dbconnect.php');
include('dbconfig.php');
date_default_timezone_set('America/Los_Angeles');


$result_status = $con->query("SELECT TOP 400 * FROM application_status_updates  ORDER BY id desc");

echo '<br><table style="width:100%;padding:10px; text-align:left" class="table table-striped table-bordered">'."
<tr>
<th>Date</th>
<th>Activity Log</th>
<th>Application ID</th>
<th>Loan ID</th>
<th>User</th>
</tr>";

while($row_status = $result_status->fetch_array())

{
    $application_id = $row_status['application_id'];
$created_by_get_db_activity = $row_status['user_id'];
$sql_activity_by_user=$con->query("select * from tbl_users where user_id= '$created_by_get_db_activity'"); 
$final_activity_by_user = '';
while($row_sql_activity_by_user = $sql_activity_by_user->fetch_array()) {
	$final_activity_by_user = $row_sql_activity_by_user['username'];
}
	

	
echo "<tr>";
echo "<td>" . $row_status['creation_date'] . "</td>";
echo "<td>Activity: " . $row_status['status'] . "</td>";
echo "<td>" . $application_id . "</td>";
echo "<td>" . $row_status['loan_create_id'] . "</td>";
echo "<td>" . $final_activity_by_user . "</td>";
echo "</tr>";
}
echo "</table><br>";
