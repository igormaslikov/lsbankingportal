<?php
include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');

date_default_timezone_set('America/Los_Angeles');


$result_status = mysqli_query($con,"SELECT * FROM application_status_updates  ORDER BY id desc limit 400");

echo '<br><table style="width:100%;padding:10px; text-align:left" class="table table-striped table-bordered">'."
<tr>
<th>Date</th>
<th>Activity Log</th>
<th>Application ID</th>
<th>Loan ID</th>
<th>User</th>
</tr>";

while($row_status = mysqli_fetch_array($result_status))

{
    $application_id = $row_status['application_id'];
$created_by_get_db_activity = $row_status['user_id'];
$sql_activity_by_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activity'"); 
$final_activity_by_user = '';
while($row_sql_activity_by_user = mysqli_fetch_array($sql_activity_by_user)) {
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
