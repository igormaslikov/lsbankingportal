<?php
// fetch.php — autocomplete endpoint for customer first name search
require_once $_SERVER['DOCUMENT_ROOT'] . '/SqlServerDb.php';
$con = portal_get_sqlsrv_db();

$request = isset($_POST["query"]) ? $_POST["query"] : '';
$result = $con->query(
    "SELECT DISTINCT first_name FROM fnd_user_profile WHERE first_name LIKE ?",
    ['%' . $request . '%']
);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row["first_name"];
    }
}
echo json_encode($data);
?>
