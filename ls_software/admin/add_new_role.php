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
    $user_role = trim($_POST['user_role'] ?? '');
    if ($user_role !== '') {
        $result = $con->query("INSERT INTO access_level (access_level) VALUES (?)", [$user_role]);
        if (!$result) {
            echo "<h3>Error Inserting Data</h3>";
        }
    }
    echo '<script>window.location.href = "/ls_software/admin/view_all_roles.php";</script>';
    exit();
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
  <h4>Add New Role:</h4>
  <div class="row wrapper">
    <form action="#" method="POST">
      <?php echo csrf_field(); ?>
      <div class="col-lg-6">
        <label for="user_role">User Role</label>
        <input name="user_role" type="text" class="form-control" id="user_role" placeholder="" value="">
      </div>
      <br>
      <button name="btn-submit" type="submit" class="btn btn-danger"
        style="color:#fff;background-color:#1E90FF;border-color:#1E90FF;">Add this Role</button>
    </form>
  </div>
</div>
<hr>
</body>
</html>
