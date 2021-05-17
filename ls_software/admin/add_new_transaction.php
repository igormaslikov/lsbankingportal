<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
//echo $u_id;
$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
}


  
   

if(isset($_POST['btn-submit'])) 
{

$payment_method= $_POST['payment_method']; 
$payoff_amount= $_POST['payoff_amount'];
$payment_date= $_POST['payment_date'];
$loan_id_payoff= $_POST['loan_id'];
$info= $_POST['info'];
$quick_pay= $_POST['quick_pay'];
$type_of_payment= $_POST['type_of_payment'];
$laon_notes=$_POST['loan_notes'];
$date = date('Y-m-d H:i:s');

$query  = "INSERT INTO loan_transaction (loan_id,payment_method,payoff_amount,payment_date,info,quick_pay,type_of_payment,created_at,created_by)  VALUES ('$loan_id_payoff','$payment_method','$payoff_amount','$payment_date','$info','$quick_pay','$type_of_payment','$date','$u_id')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
 
$query_notes  = "INSERT INTO tbl_loan_notes (loan_id,notes,created_at,created_by)  VALUES ('$loan_id_payoff','$laon_notes','$date','$u_id')";
        $result = mysqli_query($con, $query_notes);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }  

?>

<script type="text/javascript">
window.location.href = 'edit_loan.php?id=<?php  $loan_id_payoff= $_GET['loan_id']; echo $loan_id_payoff ;?>';
</script>
<?php
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

</head>

<body>

<?php include('menu.php') ;?>

    
  <div class ="container" style="margin-top:100px">

  <div class="row">

  <form action ="" method="POST" enctype="multipart/form-data">
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
      
      <div class="col-lg-6">
      <label for="usr">Payment Method</label>
    <select name="payment_method" id="payment_method" class="form-control"  value="">
<option value=""></option>
<option value="Cash">Cash</option>
<option value="Check">Check</option>
<option value="Debit">Debit</option>
<option value="eCheck">eCheck</option>
<option value="EFT">EFT</option>
<option value="Other">Other</option>
<option value="PayNearMe">PayNearMe</option>
<option value="Payroll">Payroll</option>
<option value="Email Transfer">Email Transfer</option>
<option value="Direct Deposit">Direct Deposit</option>
<option value="Misc">Misc</option>
<option value="AAT Wells Fargo Bank Deposit">AAT Wells Fargo Bank Deposit</option>
<option value="Charge Off">Charge Off</option>

</select>
    </div>
      
      
     <div class="col-lg-6">
      <label for="usr">Amount</label>
      <input type="text" name="payoff_amount" class="form-control" id="usr" placeholder="Payoff Amount" value="">
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Payment Date</label>
      <input type="date" name="payment_date" class="form-control" id="usr" placeholder="" value="<?php echo date('Y-m-d');?>">
      
      <input type="text" name="loan_id" class="form-control" id="usr" placeholder="" value="<?php echo $_GET['loan_id']; ?>" style="display:none;">
    </div>
    
     <div class="col-lg-6">
      <label for="usr">INFO:</label>
      <input type="text" name="info" class="form-control" id="usr" placeholder="INFO" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Amount Quick Pay</label>
    <select name="quick_pay" id="quick_pay" class="form-control"  value="">
<option value=""></option>
<option value="Make Selection">Make Selection</option>

</select>
    </div>
    
        <div class="col-lg-6">
      <label for="usr">Type Of Payment</label>
    <select name="type_of_payment" id="type_of_payment" class="form-control"  value="">
<option value=""></option>
<option value="Payoff">Payoff</option>
<option value="Pay Down">Pay Down</option>
<option value="Chargeoff">Chargeoff</option>

</select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Loan Notes</label>
      <textarea name="loan_notes" class="form-control" id="usr" placeholder="Loan Notes" value=""></textarea>
    </div>
    
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add New Transaction</button>
  </form>
  
</div>
</div>

<hr>


</body>
</html>