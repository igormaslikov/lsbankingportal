<?php
error_reporting(0);
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';
include_once 'security.php';

require_login();
csrf_verify();

$user_id = (int)$_SESSION['userSession'];
$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $user_id);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];

require_access($u_access_id);
$DBcon->close();

include 'functions.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die('Invalid ID.');
}

$form_name = basename(__FILE__);
$sql_role = $con->query("SELECT * FROM access_form WHERE form_name = ?", [$form_name]);
$form_id = null;
while ($sql_role && ($row_role = $sql_role->fetch_array())) {
    $form_id = $row_role['id'];
}

$delete_allowed = user_roles($u_access_id, $form_id);

if ($delete_allowed == 1) {
    $result = $con->query("DELETE FROM business_group WHERE bg_id = ?", [$id]);
    if (!$result) {
        echo "<div class='form'><h3>Error in Deleting Data.</h3></div>";
    }
    echo '<script>window.location.href = "/ls_software/admin/view_all_companies.php";</script>';
} else {
    echo '<script>window.location.href = "/ls_software/admin/not_authorize.php";</script>';
}
