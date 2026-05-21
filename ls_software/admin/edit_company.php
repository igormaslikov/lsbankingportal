<?php
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';
include_once 'security.php';

require_login();

$user_id = (int)$_SESSION['userSession'];
$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $user_id);
$userRow = $query->fetch_array();
$uu_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];

require_access($u_access_id);

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die('Invalid ID.');
}

$sql = $con->query("SELECT * FROM business_group WHERE bg_id = ?", [$id]);
$bg_name = $email_id = $address1 = $address2 = '';
$contact_number1 = $contact_number2 = $state = $base_currency = '';
$creation_date = $last_update = $created_by = $last_update_date = '';

while ($sql && ($row = $sql->fetch_array())) {
    $bg_name          = $row['bg_name'];
    $email_id         = $row['email_id'];
    $address1         = $row['address1'];
    $address2         = $row['address2'];
    $contact_number1  = $row['contact_number1'];
    $contact_number2  = $row['contact_number2'];
    $state            = $row['state'];
    $base_currency    = $row['base_currency'];
    $creation_date    = $row['creation_date'];
    $last_update      = $row['last_update_by'];
    $created_by       = $row['created_by'];
    $last_update_date = $row['last_update_date'];
}

$username = '';
$sql = $con->query("SELECT username FROM tbl_users WHERE user_id = ?", [$created_by]);
while ($sql && ($row = $sql->fetch_array())) {
    $username = $row['username'];
}

$username_update = '';
$sql = $con->query("SELECT username FROM tbl_users WHERE user_id = ?", [$last_update]);
while ($sql && ($row = $sql->fetch_array())) {
    $username_update = $row['username'];
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
<style>
.sidenav {
  width: 220px; position: absolute; z-index: 1; top: 3px; left: -44px;
  background: #1E90FF; overflow-x: hidden; padding: 8px 0;
}
.sidenav a {
  padding: 0px 0px 0px 7px; text-decoration: none;
  font-size: 15px; color: white; display: block;
}
.sidenav a:hover { color: white; }
.wrapper {
  width: 100%; max-width: 1260px;
  margin: 20px auto 100px auto; padding: 0; position: relative;
}
</style>
</head>
<body>

<?php include('menu.php'); ?>

<div class="container wrapper" style="margin-top:100px">
  <div class="row wrapper">
    <div class="col-lg-10">
      <div class="row" style="background-color:#F5E09E;padding:20px;">
        <div class="col-lg-4"><p>Portfolio Name:<b> <?php echo h($bg_name); ?></b></p></div>
        <div class="col-lg-4"><p>Created By:<b> <?php echo h($username); ?></b></p></div>
        <div class="col-lg-4"><p>Creation Date:<b> <?php echo h($creation_date); ?></b></p></div>
        <div class="col-lg-4"><p>Last Update By:<b> <?php echo h($username_update); ?></b></p></div>
        <div class="col-lg-4"><p>Last Update Date:<b> <?php echo h($last_update_date); ?></b></p></div>
      </div>
      <br><br>
      <form action="#" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="record_id" value="<?php echo $id; ?>">
        <div class="form-group">
          <div class="row">
            <div class="col-lg-6">
              <label for="comapny_name">Portfolio Name</label>
              <input name="comapny_name" type="text" class="form-control" id="comapny_name"
                value="<?php echo h($bg_name); ?>">
            </div>
            <div class="col-lg-6">
              <label for="company_address1">Portfolio Address</label>
              <input name="company_address1" type="text" class="form-control" id="company_address1"
                value="<?php echo h($address1); ?>">
            </div>
            <div class="col-lg-6">
              <label for="comapny_email">Portfolio Email</label>
              <input name="comapny_email" type="text" class="form-control" id="comapny_email"
                value="<?php echo h($email_id); ?>">
            </div>
            <div class="col-lg-6">
              <label for="comapny_phone1">Portfolio Phone</label>
              <input name="comapny_phone1" type="text" class="form-control" id="comapny_phone1"
                value="<?php echo h($contact_number1); ?>">
            </div>
            <div class="col-lg-6">
              <label for="comapny_state">State</label>
              <input name="comapny_state" type="text" class="form-control" id="comapny_state"
                value="<?php echo h($state); ?>">
            </div>
          </div>
        </div>
        <br>
        <button name="btn-submit" type="submit" class="btn btn-danger"
          style="background-image:linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);
                 color:white;background-color:#1E90FF;border-radius:0;border-color:#1E90FF;">
          Update
        </button>
      </form>
    </div>
  </div>
</div>
<hr>
</body>
</html>

<?php
include 'functions.php';

if (isset($_POST['btn-submit'])) {
    csrf_verify();

    // Use the id from the hidden field (already validated at top as int from GET)
    $post_id = (int)($_POST['record_id'] ?? 0);
    if ($post_id <= 0) { die('Invalid ID.'); }

    $form_name = basename(__FILE__);
    $sql_role = $con->query("SELECT * FROM access_form WHERE form_name = ?", [$form_name]);
    $form_id = null;
    while ($sql_role && ($row_role = $sql_role->fetch_array())) {
        $form_id = $row_role['id'];
    }

    $update_allowed_validate = user_edit_roles($u_access_id, $form_id);

    if ($update_allowed_validate == 1) {
        $comapny_name_update     = trim($_POST['comapny_name']     ?? '');
        $company_address1_update = trim($_POST['company_address1'] ?? '');
        $comapny_email_update    = trim($_POST['comapny_email']    ?? '');
        $comapny_phone1_update   = trim($_POST['comapny_phone1']   ?? '');
        $comapny_state_update    = trim($_POST['comapny_state']    ?? '');
        $date = date('Y-m-d H:i:s');

        $con->query(
            "UPDATE business_group
             SET bg_name = ?, email_id = ?, address1 = ?, contact_number1 = ?,
                 state = ?, last_update_by = ?, last_update_date = ?
             WHERE bg_id = ?",
            [$comapny_name_update, $comapny_email_update, $company_address1_update,
             $comapny_phone1_update, $comapny_state_update, $uu_id, $date, $post_id]
        );

        echo '<script>window.location.href = "/ls_software/admin/view_all_companies.php";</script>';
    } else {
        echo '<script>window.location.href = "/ls_software/admin/not_authorize.php";</script>';
    }
}
?>
