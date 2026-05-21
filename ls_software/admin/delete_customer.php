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
if ($id <= 0) { die('Invalid ID.'); }

$form_name = basename(__FILE__);
$sql_role = $con->query("SELECT * FROM access_form WHERE form_name = ?", [$form_name]);
$form_id = null;
while ($sql_role && ($row_role = $sql_role->fetch_array())) {
    $form_id = $row_role['id'];
}

$loan_status = '';
$sql_loan = $con->query("SELECT loan_status FROM tbl_loan WHERE user_fnd_id = ?", [$id]);
while ($sql_loan && ($row_loan = $sql_loan->fetch_array())) {
    $loan_status = $row_loan['loan_status'];
}

$delete_allowed = user_roles($u_access_id, $form_id);

if ($delete_allowed == 1 && $loan_status !== 'Active') {
    $tables = [
        'fnd_user_profile',
        'fnd_user_profile_submission',
        'source_income',
        'binary_questions',
        'application_notes',
        'tbl_bank_statements',
    ];
    foreach ($tables as $table) {
        $con->query("DELETE FROM $table WHERE user_fnd_id = ?", [$id]);
    }

    $status    = $_GET['status']    ?? 'All';
    $keyword   = $_GET['keyword']   ?? '';
    $from_date = $_GET['from_date'] ?? '';
    $to_date   = $_GET['to_date']   ?? '';
    $page_no   = (int)($_GET['page_no'] ?? 1);

    $qs = "status=" . urlencode($status)
        . "&keyword=" . urlencode($keyword)
        . "&from_date=" . urlencode($from_date)
        . "&to_date=" . urlencode($to_date)
        . "&page_no=" . $page_no;

    echo '<script>window.location.href = "/ls_software/admin/view_all_customer_main.php?' . $qs . '";</script>';
} else {
    echo '<script>window.location.href = "/ls_software/admin/not_authorize_or_active_loan.php";</script>';
}
