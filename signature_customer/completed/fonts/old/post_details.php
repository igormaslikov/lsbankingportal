<?php
require_once('./include/mysqli_connect.php');

$postDetails = array();

$search_key = $_GET['term'];

//get rows query
$query = "SELECT * FROM li_ajax_post_load where post_title like '%$search_key%'";
$result = $con->query($query);

//number of rows
$rowCount = $result->num_rows;

if($rowCount > 0){
    while($row = $result->fetch_assoc()){
			$postDetails[] = ucfirst($row['post_title']);
	}
}
echo json_encode($postDetails);
?>