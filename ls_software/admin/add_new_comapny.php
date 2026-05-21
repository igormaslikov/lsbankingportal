<?php
session_start();
error_reporting(0);
include_once 'dbconnect.php';
include_once 'dbconfig.php';
include_once 'security.php';

require_login();

$user_id = (int)$_SESSION['userSession'];
$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $user_id);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];

require_access($u_access_id);
$DBcon->close();

include 'functions.php';

if (isset($_POST['btn-submit'])) {
    csrf_verify();

    $comapny_name    = trim($_POST['comapny_name']    ?? '');
    $company_address = trim($_POST['company_address'] ?? '');
    $comapny_email   = trim($_POST['comapny_email']   ?? '');
    $comapny_phone   = trim($_POST['comapny_phone']   ?? '');
    $comapny_state   = trim($_POST['comapny_state']   ?? '');
    $date            = date('Y-m-d H:i:s');

    $form_name = basename(__FILE__);
    $sql_role = $con->query("SELECT * FROM access_form WHERE form_name = ?", [$form_name]);
    $form_id = null;
    while ($sql_role && ($row_role = $sql_role->fetch_array())) {
        $form_id = $row_role['id'];
    }
    user_roles($u_access_id, $form_id);

    $result = $con->query(
        "INSERT INTO business_group (bg_name, email_id, address1, contact_number1, state, created_by, creation_date)
         VALUES (?, ?, ?, ?, ?, ?, ?)",
        [$comapny_name, $comapny_email, $company_address, $comapny_phone, $comapny_state, $u_id, $date]
    );

    if ($result) {
        echo '<script>window.location.href = "/ls_software/admin/view_all_companies.php";</script>';
        exit();
    } else {
        echo "<h3>Error Inserting Data</h3>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo h($userRow['email']); ?></title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style>
.wrapper {
    width: 100%;
    max-width: 1330px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
</head>
<body>

<?php include('menu.php'); ?>

  <div class="container wrapper" style="margin-top:100px">
  <div class="row wrapper">
  <form action="" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <h3>Portfolio Information</h3>
    <div class="row">
      <div class="col-lg-6">
        <label for="comapny_name">Portfolio Name</label>
        <input name="comapny_name" type="text" class="form-control" id="comapny_name" placeholder="" value="">
      </div>
      <div class="col-lg-6">
        <label for="comapny_email">Portfolio Email</label>
        <input name="comapny_email" type="text" class="form-control" id="comapny_email" placeholder="" value="">
      </div>
      <div class="col-lg-6">
        <label for="comapny_phone">Portfolio Phone</label>
        <input name="comapny_phone" type="text" class="form-control" id="comapny_phone" placeholder="" value="">
      </div>
      <div class="col-lg-6">
        <label for="comapny_state">State</label>
        <input name="comapny_state" type="text" class="form-control" id="comapny_state" placeholder="" value="">
      </div>
      <div class="col-lg-6">
        <label for="company_address">Portfolio Address</label>
        <textarea name="company_address" class="form-control" id="company_address" placeholder=""></textarea>
      </div>
    </div>
    <br>
    <button name="btn-submit" type="submit" class="btn btn-danger"
      style="color:#fff;background-color:#1E90FF;border-color:#1E90FF;">Add this Portfolio</button>
  </form>
  </div>
  </div>
<hr>
</body>
</html>
