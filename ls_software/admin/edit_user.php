<?php
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';
include_once 'security.php';
error_reporting(0);

require_login();

$user_id = (int)$_SESSION['userSession'];
$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $user_id);
$userRow = $query->fetch_array();
$uuu_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];

// Only access_id=1 (admin) can edit users
if ((string)$u_access_id !== '1') {
    http_response_code(403);
    die('YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.');
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { die('Invalid ID.'); }

$sql = $con->query("SELECT * FROM tbl_users WHERE user_id = ?", [$id]);
$access_id = $status = $created_at = $created_by = $update_by = $update_date = $auth_code = '';
while ($sql && ($row = $sql->fetch_array())) {
    $access_id   = $row['access_id'];
    $status      = $row['status'];
    $created_at  = $row['created_at'];
    $created_by  = $row['created_by'];
    $update_by   = $row['last_update_by'];
    $update_date = $row['last_update_date'];
    $auth_code   = $row['auth_code'];
}

$access_level = '';
$sql = $con->query("SELECT access_level FROM access_level WHERE access_id = ?", [$access_id]);
while ($sql && ($row = $sql->fetch_array())) { $access_level = $row['access_level']; }

$name = '';
$sql = $con->query("SELECT username FROM tbl_users WHERE user_id = ?", [$created_by]);
while ($sql && ($row = $sql->fetch_array())) { $name = $row['username']; }

$name_update = '';
$sql = $con->query("SELECT username FROM tbl_users WHERE user_id = ?", [$update_by]);
while ($sql && ($row = $sql->fetch_array())) { $name_update = $row['username']; }

if (isset($_POST['btn-submit'])) {
    csrf_verify();
    $status_update       = trim($_POST['status']          ?? '');
    $access_level_update = (int)($_POST['level_of_access'] ?? 0);
    $auth_code_up        = trim($_POST['auth_code']        ?? '');
    $date = date('Y-m-d H:i:s');

    $con->query(
        "UPDATE tbl_users SET status = ?, access_id = ?, last_update_by = ?, last_update_date = ?, auth_code = ?
         WHERE user_id = ?",
        [$status_update, $access_level_update, $uuu_id, $date, $auth_code_up, $id]
    );
    echo '<script>window.location.href = "/ls_software/admin/view_all_user.php";</script>';
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
.wrapper { width:100%; max-width:1340px; padding:0; position:relative; }
</style>
</head>
<body>
<?php include('menu.php'); ?>
<div class="container wrapper" style="margin-top:70px">
  <div class="row wrapper" style="background-color:#F5E09E;color:black;padding:20px;">
    <div class="col-lg-4"><p>Status:<b style="color:red"> <?php echo h($status); ?></b></p></div>
    <div class="col-lg-4"><p>Created By:<b style="color:red"> <?php echo h($name); ?></b></p></div>
    <div class="col-lg-4"><p>Creation Date:<b style="color:red"> <?php echo h($created_at); ?></b></p></div>
    <div class="col-lg-4"><p>Last Update By:<b style="color:red"> <?php echo h($name_update); ?></b></p></div>
    <div class="col-lg-4"><p>Last Update Date:<b style="color:red"> <?php echo h($update_date); ?></b></p></div>
  </div>
  <hr>
  <div class="row wrapper">
    <form action="#" method="POST">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="record_id" value="<?php echo $id; ?>">
      <div class="col-lg-6">
        <label>Select User Status</label>
        <select class="form-control" name="status">
          <option value="Active"   <?php if ($status === 'Active')   echo 'selected'; ?>>Active</option>
          <option value="Inactive" <?php if ($status === 'Inactive') echo 'selected'; ?>>Inactive</option>
        </select>
      </div>
      <div class="col-lg-6">
        <label>Select Level Of Access</label>
        <select class="form-control" name="level_of_access">
          <?php
          $sql_access = $con->query("SELECT access_id, access_level FROM access_level");
          while ($sql_access && ($row_access = $sql_access->fetch_array())) {
              $sel = ($access_level === $row_access['access_level']) ? ' selected' : '';
              echo "<option value='" . (int)$row_access['access_id'] . "'$sel>" . h($row_access['access_level']) . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-lg-6">
        <label>Code For Repay API</label>
        <input name="auth_code" type="text" class="form-control"
          onKeyPress="if(this.value.length==5) return false;"
          value="<?php echo h($auth_code); ?>">
      </div>
      <div class="col-lg-6" style="margin-top:20px">
        <button name="btn-submit" type="submit" class="btn btn-danger"
          style="background-image:linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);
                 color:#fff;background-color:#1E90FF;border-color:#1E90FF;">Update</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
