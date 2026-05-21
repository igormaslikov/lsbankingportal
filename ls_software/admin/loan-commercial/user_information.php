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
$sql_fnd=$con->query("select * from tbl_commercial_loan where loan_id = '$id'"); 

while($row_fnd = $sql_fnd->fetch_array()) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}



$sql=$con->query("select * from tbl_commercial_loan where loan_id= '$id'"); 

while($row = $sql->fetch_array()) {

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


$sql_user=$con->query("select * from tbl_users where user_id= '$created_by'"); 

while($row_user = $sql_user->fetch_array()) {

$username=$row_user['username'];

}

$sql_user=$con->query("select * from tbl_loan_notes where loan_id= '$id'"); 

while($row_user = $sql_user->fetch_array()) {

$loan_notes=$row_user['notes'];

}

//echo "fname is:".$loan_notes;

$sql_fnd=$con->query("select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row_fnd = $sql_fnd->fetch_array()) {
    
$first_name=$row_fnd['first_name'];
$last_name=$row_fnd['last_name'];
$full_name= $first_name.' '.$last_name;
$email=$row_fnd['email'];
$mobile_number=$row_fnd['mobile_number'];
$address=$row_fnd['address'];
$city=$row_fnd['city'];
$state=$row_fnd['state'];
$zip=$row_fnd['zip_code'];
$date_of_birth_db=$row_fnd['date_of_birth'];

       $timestamp = strtotime($date_of_birth_db);
       $date_of_birth= date("m-d-Y", $timestamp);
       
$ssn=$row_fnd['ssn']; 
$id_photo=$row_fnd['customer_img'];
$block_status=$row_fnd['block_status'];
$block_by=$row_fnd['block_by'];

}

$sql_bank_detail=$con->query("select * from commercial_loan_initial_banking where user_fnd_id = '$user_fnd_id'"); 

while($row_bank_detail = $sql_bank_detail->fetch_array()) {
    
    	$type_of_id=$row_bank_detail['type_of_id'];

}


$sql_block=$con->query("select * from tbl_users where user_id= '$block_by'"); 

while($row_block = $sql_block->fetch_array()) {

$blocked_by=$row_block['username'];

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
        <span class="glyphicon glyphicon-user"></span>
        Customer's Information
        <small>&nbsp;·&nbsp;<?php echo htmlspecialchars((string)$loan_create_id); ?> · <?php echo htmlspecialchars(trim((string)$first_name . ' ' . (string)$last_name)); ?></small>
      </h3>
      <div>
        <a href="loan_summary.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default">
          <span class="glyphicon glyphicon-arrow-left"></span> Back to loan
        </a>
      </div>
    </div>

    <!-- Summary card -->
    <div class="ui-summary">
      <div class="row">
        <div class="col-md-3"><p><strong>Name</strong><b><?php echo htmlspecialchars(trim((string)$first_name . ' ' . (string)$last_name)); ?></b></p></div>
        <div class="col-md-2"><p><strong>Phone</strong><b><?php echo htmlspecialchars((string)$mobile_number); ?></b></p></div>
        <div class="col-md-2"><p><strong>DOB</strong><b><?php echo htmlspecialchars((string)$date_of_birth); ?></b></p></div>
        <div class="col-md-2"><p><strong>Loan Amount</strong><b><?php echo htmlspecialchars((string)($val . $amount_loan)); ?></b></p></div>
        <div class="col-md-2"><p><strong>Loan Date</strong><b><?php echo htmlspecialchars((string)$new_creation_date); ?></b></p></div>
        <div class="col-md-1"><p><strong>Loan ID</strong><b><?php echo htmlspecialchars((string)$loan_create_id); ?></b></p></div>
      </div>
    </div>

    <?php if ((string)$block_status === '5'): ?>
      <div class="ui-blacklist">
        <span class="glyphicon glyphicon-ban-circle"></span>
        This customer has been blacklisted by <?php echo htmlspecialchars((string)$blocked_by); ?>.
      </div>
    <?php endif; ?>

    <!-- Photo + blacklist actions -->
    <div class="ui-photo-panel">
      <?php $__photo_src = (empty($id_photo)) ? 'imgs/DP.jpg' : '../../dl_client_files/customer_imgs/' . $id_photo; ?>
      <img src="<?php echo htmlspecialchars($__photo_src); ?>" alt="Customer photo" class="ui-photo-img"/>
      <div class="ui-photo-actions">
        <a href="upload_user_img.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-primary">
          <span class="glyphicon glyphicon-camera"></span> Change Picture
        </a>
        <form action="" method="post" style="display:inline-block;margin:0;">
          <?php if ((string)$block_status === '0'): ?>
            <button name="btn-block" type="submit" class="btn btn-danger"
                    onclick="return confirm('Blacklist this customer?');">
              <span class="glyphicon glyphicon-ban-circle"></span> Blacklist
            </button>
          <?php else: ?>
            <button name="btn-unblock" type="submit" class="btn btn-success">
              <span class="glyphicon glyphicon-ok-sign"></span> Remove from Blacklist
            </button>
          <?php endif; ?>
        </form>
      </div>
    </div>

    <form action="" method="POST" enctype="multipart/form-data">

      <!-- Personal Info -->
      <div class="ui-panel">
        <div class="ui-panel-head">
          Personal Information
          <span class="ui-panel-hint">Identity &amp; ID document</span>
        </div>
        <div class="ui-panel-body">
          <div class="row">
            <div class="col-md-4 ui-field">
              <label>First Name</label>
              <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars((string)$first_name); ?>">
            </div>
            <div class="col-md-4 ui-field">
              <label>Last Name</label>
              <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars((string)$last_name); ?>">
            </div>
            <div class="col-md-4 ui-field">
              <label>Date of Birth</label>
              <input type="text" name="dob" class="form-control" placeholder="MM-DD-YYYY" value="<?php echo htmlspecialchars((string)$date_of_birth); ?>">
            </div>
            <div class="col-md-4 ui-field">
              <label>SSN / ITIN</label>
              <input type="text" name="ssn" class="form-control" value="<?php echo htmlspecialchars((string)$ssn); ?>">
            </div>
            <div class="col-md-8 ui-field">
              <label>Type of ID</label>
              <select name="type_id" id="type_id" class="form-control">
                <option value=""></option>
                <?php foreach (['Drivers License','State Personal ID','Matricula Consular ID','Tribal ID','Passport','Military ID','Other'] as $opt): ?>
                  <option value="<?php echo htmlspecialchars($opt); ?>" <?php echo ($type_of_id == $opt) ? 'selected' : ''; ?>><?php echo htmlspecialchars($opt); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="ui-panel">
        <div class="ui-panel-head">
          Contact Information
          <span class="ui-panel-hint">Email, phone, address</span>
        </div>
        <div class="ui-panel-body">
          <div class="row">
            <div class="col-md-6 ui-field">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars((string)$email); ?>">
              <?php if (!empty($email)): ?>
                <a href='mailto:<?php echo htmlspecialchars((string)$email); ?>' class="ui-email-link">
                  <span class="glyphicon glyphicon-envelope"></span> Send Email via Outlook
                </a>
              <?php endif; ?>
            </div>
            <div class="col-md-6 ui-field">
              <label>Phone Number</label>
              <input type="tel" name="ph_numbr" class="form-control" value="<?php echo htmlspecialchars((string)$mobile_number); ?>">
            </div>
            <div class="col-md-6 ui-field">
              <label>Primary Address</label>
              <input type="text" name="p_address" class="form-control" value="<?php echo htmlspecialchars((string)$address); ?>">
            </div>
            <div class="col-md-3 ui-field">
              <label>City</label>
              <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars((string)$city); ?>">
            </div>
            <div class="col-md-1 ui-field">
              <label>State</label>
              <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars((string)$state); ?>">
            </div>
            <div class="col-md-2 ui-field">
              <label>Zip</label>
              <input type="text" name="zip_code" class="form-control" value="<?php echo htmlspecialchars((string)$zip); ?>">
            </div>
          </div>
        </div>
      </div>

      <!-- References (collapsed by default) -->
      <div class="ui-panel ui-collapsible collapsed" id="ui-refs">
        <div class="ui-panel-head" onclick="this.parentElement.classList.toggle('collapsed')">
          References
          <span class="ui-panel-hint">Optional · click to expand <span class="caret"></span></span>
        </div>
        <div class="ui-panel-body">
          <?php for ($rn = 1; $rn <= 4; $rn++):
            $suffix = ($rn === 1) ? '' : (string)$rn;
            $phone_field = ($rn === 4) ? 'ref_phon4' : 'ref_phone' . $suffix; // preserve original typo for field 4
          ?>
            <div class="ui-ref-row">
              <div class="ui-ref-label">Reference <?php echo $rn; ?></div>
              <div class="row">
                <div class="col-md-4 ui-field">
                  <label>Name</label>
                  <input type="text" name="ref_name<?php echo $suffix; ?>" class="form-control" value="">
                </div>
                <div class="col-md-4 ui-field">
                  <label>Phone</label>
                  <input type="text" name="<?php echo $phone_field; ?>" class="form-control" value="">
                </div>
                <div class="col-md-4 ui-field">
                  <label>Relationship</label>
                  <input type="text" name="ref_relation<?php echo $suffix; ?>" class="form-control" value="">
                </div>
              </div>
            </div>
          <?php endfor; ?>
        </div>
      </div>

      <!-- Action bar -->
      <div class="ui-action-bar">
        <a href="loan_summary.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default">Cancel</a>
        <button name="btn-submit" type="submit" class="btn btn-save">
          <span class="glyphicon glyphicon-save"></span> Save Customer
        </button>
      </div>
    </form>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
 <?php
  if(isset($_POST['btn-submit'])) {
    

$first_name_update =$_POST['full_name'];
$last_name_update =$_POST['last_name'];
$ssn_update =$_POST['ssn'];
$dob_update =$_POST['dob'];
$email_update =$_POST['email'];
$phone_number_update =$_POST['ph_numbr'];
$address_update =$_POST['p_address'];
$city_update =$_POST['city'];
$state_update =$_POST['state'];
$zip_update =$_POST['zip_code'];
$type_id_update =$_POST['type_id'];

$date= date('Y-m-d H:i:s');

  
  
  
  $con->query("UPDATE fnd_user_profile SET first_name ='$first_name_update' , last_name='$last_name_update' , mobile_number='$phone_number_update' , email='$email_update', address='$address_update', city='$city_update', state='$state_update',  zip_code='$zip_update', date_of_birth='$dob_update', ssn='$ssn_update' where user_fnd_id ='$user_fnd_id'"); 


$con->query("UPDATE commercial_loan_initial_banking SET type_of_id ='$type_id_update'  where user_fnd_id ='$user_fnd_id'"); 

  
      
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
