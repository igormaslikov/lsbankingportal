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
if($u_access_id!='1'){
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



$sql=mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');

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

$sql_business_query=mysqli_query($con, "select * from tbl_business_info where user_fnd_id= '$user_fnd_id'"); 

while($row_business_source = mysqli_fetch_array($sql_business_query)) {

$business_name=$row_business_source['business_name'];
$business_phone=$row_business_source['business_phone'];
$gross_amount=$row_business_source['monthly_gross_amount'];
$business_direct_deposit=$row_business_source['direct_deposit'];
$how_paid_business=$row_business_source['how_paid'];
$business_docs=$row_business_source['business_docs'];

}
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
          <span class="glyphicon glyphicon-tower"></span>
          Business Information
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
          <div class="col-md-2"><p><strong>Loan Amount</strong><b>$<?php echo htmlspecialchars((string)$amount_loan); ?></b></p></div>
          <div class="col-md-2"><p><strong>Loan ID</strong><b><?php echo htmlspecialchars((string)$loan_create_id); ?></b></p></div>
        </div>
      </div>

      <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="emaill" value="<?php echo htmlspecialchars((string)($email ?? '')); ?>">
        <input type="hidden" name="link"   value="<?php echo htmlspecialchars((string)($message ?? '')); ?>">

        <div class="ui-panel">
          <div class="ui-panel-head">
            Business Info
            <span class="ui-panel-hint">Employer-entity details on file</span>
          </div>
          <div class="ui-panel-body">
            <div class="row">
              <div class="col-md-4 ui-field">
                <label>Business Name</label>
                <input type="text" name="business_name" class="form-control" value="<?php echo htmlspecialchars((string)($business_name ?? '')); ?>">
              </div>
              <div class="col-md-4 ui-field">
                <label>Business Phone</label>
                <input type="tel" name="business_phone" class="form-control" placeholder="123-456-7890"
                       pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                       value="<?php echo htmlspecialchars((string)($business_phone ?? '')); ?>">
              </div>
              <div class="col-md-4 ui-field">
                <label>Monthly Gross Amount</label>
                <input type="text" name="gross_amount" class="form-control" placeholder="e.g. 15000"
                       value="<?php echo htmlspecialchars((string)($gross_amount ?? '')); ?>">
              </div>

              <div class="col-md-4 ui-field">
                <label>Direct Deposit</label>
                <select name="business_direct_deposit" class="form-control">
                  <option value=""></option>
                  <option value="Yes" <?php if (($business_direct_deposit ?? '') === 'Yes') echo 'selected'; ?>>Yes</option>
                  <option value="No"  <?php if (($business_direct_deposit ?? '') === 'No')  echo 'selected'; ?>>No</option>
                </select>
              </div>
              <div class="col-md-4 ui-field">
                <label>Pay Frequency</label>
                <select name="business_get_paid" class="form-control">
                  <option value=""></option>
                  <?php foreach (['Weekly','Bi-Weekly','Semi Monthly','Monthly'] as $__pf): ?>
                    <option value="<?php echo htmlspecialchars($__pf); ?>"
                      <?php if (($how_paid_business ?? '') === $__pf) echo 'selected'; ?>><?php echo htmlspecialchars($__pf); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4 ui-field">
                <label>Business Documentation</label>
                <select name="business_docs" class="form-control">
                  <option value=""></option>
                  <?php foreach (['Business License','Sellers Permit','DBA'] as $__d): ?>
                    <option value="<?php echo htmlspecialchars($__d); ?>"
                      <?php if (($business_docs ?? '') === $__d) echo 'selected'; ?>><?php echo htmlspecialchars($__d); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="ui-action-bar">
          <a href="loan_summary.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default">Cancel</a>
          <button name="btn-submit" type="submit" class="btn btn-save">
            <span class="glyphicon glyphicon-save"></span> Update
          </button>
        </div>
      </form>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
    <?php
     
     if(isset($_POST['btn-submit'])) 
{
     $date=date('Y-m-d');
$business_name_update =$_POST['business_name'];
$business_phone_update =$_POST['business_phone'];
$gross_amount_update =$_POST['gross_amount'];
$business_direct_deposit_update =$_POST['business_direct_deposit'];
$business_get_paid_update=$_POST['business_get_paid'];
$business_docs_update=$_POST['business_docs'];

    
      mysqli_query($con, "UPDATE tbl_business_info SET business_name='$business_name_update', business_phone='$business_phone_update', monthly_gross_amount='$gross_amount_update', direct_deposit='$business_direct_deposit_update', how_paid='$business_get_paid_update', business_docs='$business_docs_update', last_update_by='$u_id', last_update_date='$date' where user_fnd_id ='$user_fnd_id' AND loan_create_id='$loan_create_id'");
      
?>

<script type="text/javascript">
window.location.href = 'business_information.php?id=<?php echo $id; ?>';
</script> 


<?php

}
      ?>
  
  
  
  
  
  
  
  
  
  
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
