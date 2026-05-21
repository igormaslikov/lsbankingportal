<?php
session_start();
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

if (isset($_POST['btn-submit'])) {
    csrf_verify();

    $user_name     = trim($_POST['user_name']     ?? '');
    $user_email    = trim($_POST['user_email']    ?? '');
    $user_password = $_POST['user_password']      ?? '';
    $phone         = trim($_POST['phone']         ?? '');
    $address       = trim($_POST['address']       ?? '');
    $c_id          = (int)($_POST['c_id']         ?? 0);
    $level_access  = (int)($_POST['level_access'] ?? 0);
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $date = date('Y-m-d H:i:s');

    $result = $con->query(
        "INSERT INTO tbl_users (bg_id, access_id, username, email, password, phone, address, status, created_by, created_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, 'Active', ?, ?)",
        [$c_id, $level_access, $user_name, $user_email, $hashed_password, $phone, $address, $u_id, $date]
    );

    if (!$result) {
        echo "<h3>Error Inserting Data</h3>";
    } else {
        echo '<script>window.location.href = "/ls_software/admin/view_all_user.php";</script>';
        exit();
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
.wrapper { width:100%; max-width:1340px; margin:20px auto 100px auto; padding:0; position:relative; }
</style>
</head>
<body>
<?php include('menu.php'); ?>
<div class="container wrapper" style="margin-top:100px">
  <h4>Add New User:</h4>
  <div class="row wrapper">
    <form action="#" method="POST">
      <?php echo csrf_field(); ?>
      <div class="col-lg-6">
        <label>User Name</label>
        <input name="user_name" type="text" class="form-control" placeholder="" value="">
      </div>
      <div class="col-lg-6">
        <label>User Email</label>
        <input name="user_email" type="text" class="form-control" placeholder="" value="">
      </div>
      <div class="col-lg-6">
        <label>User Password</label>
        <input name="user_password" type="password" class="form-control" placeholder="" value="">
      </div>
      <div class="col-lg-6">
        <label>Portfolio/Companies</label>
        <select name="c_id" class="form-control">
          <?php
          $sql1 = $con->query("SELECT bg_id, bg_name FROM business_group");
          while ($sql1 && ($row1 = $sql1->fetch_array())) {
              echo "<option value='" . (int)$row1['bg_id'] . "'>" . h($row1['bg_name']) . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-lg-6">
        <label>Level Of Access</label>
        <select name="level_access" class="form-control">
          <?php
          $sql_access = $con->query("SELECT access_id, access_level FROM access_level");
          while ($sql_access && ($row_access = $sql_access->fetch_array())) {
              echo "<option value='" . (int)$row_access['access_id'] . "'>" . h($row_access['access_level']) . "</option>";
          }
          ?>
        </select>
      </div>
      <br>
      <button name="btn-submit" type="submit" class="btn btn-danger"
        style="color:#fff;background-color:#1E90FF;border-color:#1E90FF;">Add this User</button>
    </form>
  </div>
</div>
<hr>
</body>
</html>
