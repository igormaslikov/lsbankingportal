<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';
$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_commercial_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;



$sql=mysqli_query($con, "select * from tbl_commercial_loan where user_fnd_id= '$user_fnd_id' AND loan_id = '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');


if ($amount_loan !='0')
{
   $val="$";
}

//echo "Amount is:".$amount_loan;

$amount_left =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$next_payment =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['contract_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}



$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;


$sql_user=mysqli_query($con, "select * from tbl_loan_notes where loan_id= '$id'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$loan_notes=$row_user['notes'];

}

//echo "fname is:".$loan_notes;

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

  <!-- Shared scoped styles for loan-commercial detail tabs -->
  <link href="css/ui-tabs.css" rel="stylesheet">

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> </div>
      <div class="list-group list-group-flush">
 
        <?php include('vertical_menu.php'); ?>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <?php include('horizontal_menu.php'); ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

       
      </nav>

      <!-- Page toolbar -->
      <div class="ui-toolbar">
        <h3 class="ui-page-title">
          <span class="glyphicon glyphicon-briefcase"></span>
          Job Information
          <small>&nbsp;·&nbsp;<?php echo htmlspecialchars((string)$loan_create_id); ?> · <?php echo htmlspecialchars(trim((string)$first_name . ' ' . (string)$last_name)); ?></small>
        </h3>
        <a href="loan_summary.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default">
          <span class="glyphicon glyphicon-arrow-left"></span> Back to loan
        </a>
      </div>

      <!-- Customer summary -->
      <div class="ui-summary">
        <div class="row">
          <div class="col-md-3"><p><strong>Name</strong><b><?php echo htmlspecialchars(trim((string)$first_name . ' ' . (string)$last_name)); ?></b></p></div>
          <div class="col-md-3"><p><strong>Phone</strong><b><?php echo htmlspecialchars((string)$customer_numbr); ?></b></p></div>
          <div class="col-md-2"><p><strong>Loan Date</strong><b><?php echo htmlspecialchars((string)$new_creation_date); ?></b></p></div>
          <div class="col-md-2"><p><strong>Loan Amount</strong><b><?php echo htmlspecialchars((string)($val . $amount_loan)); ?></b></p></div>
          <div class="col-md-2"><p><strong>Loan ID</strong><b><?php echo htmlspecialchars((string)$loan_create_id); ?></b></p></div>
        </div>
      </div>

      <!-- Jobs panel -->
      <div class="ui-panel">
        <div class="ui-panel-head">
          Employer Records
          <a href="add_employe.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-plus"></span> Add New Job
          </a>
        </div>
        <div class="ui-panel-body" style="padding:0;">
          <table class="ui-table">
            <thead>
              <tr>
                <th>Employer</th>
                <th>Phone</th>
                <th>Net Income</th>
                <th>Direct Deposit</th>
                <th>Pay Period</th>
                <th>Last Pay</th>
                <th>Next Pay</th>
                <th style="text-align:right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $__job_rows = 0;
              $sql_doc = mysqli_query($con, "select * from source_income_commercial where user_fnd_id = '$user_fnd_id'");
              while ($row_doc = mysqli_fetch_array($sql_doc)) {
                  $__job_rows++;
                  $scr_inc_id       = $row_doc['scr_inc_id'];
                  $employer_name    = $row_doc['employer_name'];
                  $work_phone_no    = $row_doc['work_phone_no'];
                  $direct_deposit   = $row_doc['direct_deposit'];
                  $pay_period       = $row_doc['pay_period'];
                  $net_check_amount = $row_doc['net_check_amount'];
                  $last_pay_date    = $row_doc['last_pay_date'];
                  $next_pay_date    = $row_doc['next_pay_date'];
                  $new_last_pay_date = $last_pay_date ? date("m-d-Y", strtotime((string)$last_pay_date)) : '';
                  $new_next_pay_date = $next_pay_date ? date("m-d-Y", strtotime((string)$next_pay_date)) : '';
                  ?>
                  <tr>
                    <td><?php echo htmlspecialchars((string)$employer_name); ?></td>
                    <td><?php echo htmlspecialchars((string)$work_phone_no); ?></td>
                    <td>$<?php echo htmlspecialchars((string)$net_check_amount); ?></td>
                    <td><?php echo htmlspecialchars((string)$direct_deposit); ?></td>
                    <td><?php echo htmlspecialchars((string)$pay_period); ?></td>
                    <td><?php echo htmlspecialchars((string)$new_last_pay_date); ?></td>
                    <td><?php echo htmlspecialchars((string)$new_next_pay_date); ?></td>
                    <td style="text-align:right; white-space:nowrap;">
                      <a href="edit_employe.php?id_src=<?php echo urlencode((string)$scr_inc_id); ?>" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-edit"></span> Edit
                      </a>
                      <a href="delete_employe.php?id_src=<?php echo urlencode((string)$scr_inc_id); ?>&id=<?php echo urlencode((string)$id); ?>"
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Delete this employer record?');">
                        <span class="glyphicon glyphicon-trash"></span>
                      </a>
                    </td>
                  </tr>
                  <?php
              }
              if ($__job_rows === 0) {
                  echo '<tr><td colspan="8" class="ui-empty-row">No employer records on file. Click <b>Add New Job</b> to add one.</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Job notes panel -->
      <div class="ui-panel">
        <div class="ui-panel-head">
          Job Notes
          <a href="add_job_notes.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-plus"></span> Add Job Notes
          </a>
        </div>
        <div class="ui-panel-body" style="padding:0;">
          <table class="ui-table">
            <thead>
              <tr>
                <th>Note</th>
                <th style="width:160px;">Created By</th>
                <th style="width:120px;">Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $__note_rows = 0;
              $sql_doc = mysqli_query($con, "select * from tbl_job_notes where user_fnd_id = '$user_fnd_id' order by creation_date desc");
              while ($row_doc = mysqli_fetch_array($sql_doc)) {
                  $__note_rows++;
                  $notes          = $row_doc['notes'];
                  $note_created_by = $row_doc['created_by'];
                  $note_creation_date = $row_doc['creation_date']
                      ? date("m-d-Y", strtotime((string)$row_doc['creation_date']))
                      : '';
                  $final_activity_by_user = '';
                  $sql_u = mysqli_query($con, "select username from tbl_users where user_id = '$note_created_by' limit 1");
                  if ($sql_u && ($r = mysqli_fetch_assoc($sql_u))) {
                      $final_activity_by_user = $r['username'];
                  }
                  ?>
                  <tr>
                    <td style="white-space:pre-wrap;"><?php echo htmlspecialchars((string)$notes); ?></td>
                    <td><?php echo htmlspecialchars((string)$final_activity_by_user); ?></td>
                    <td><?php echo htmlspecialchars((string)$note_creation_date); ?></td>
                  </tr>
                  <?php
              }
              if ($__note_rows === 0) {
                  echo '<tr><td colspan="3" class="ui-empty-row">No job notes yet.</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
<?php
}
?>
</body>

</html>
