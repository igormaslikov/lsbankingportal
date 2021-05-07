c<?php
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';

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


$fnd_idd=$_GET['id'];
$name_id= $_POST['keyword']; 
//echo "<br><br><br><br><br><br><br><br><br><br>Name Is: $name_id";
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

<?php include('menu.php') ;?>

  <div class ="container wrapper" style="margin-top:100px">
      
  <div class="row wrapper">
<?php

$sql_count_loans = "SELECT * FROM tbl_personal_loans";
if ($result_count_loans=mysqli_query($con,$sql_count_loans))
  {
  // Return the number of rows in result set
  $rowcount_count_loans=mysqli_num_rows($result_count_loans)+10003;
  
  //$rowcount_count_loans= $rowcount_count_loans-100;
  //echo "<br><br><br><br><br>".$rowcount_count_loans;
  }
?>

<?php

$id=$_GET['id'];
$loan_name=$_GET['loan'];
$due_date=$_GET['next_pay_date'];

include 'dbconnect.php';
include 'dbconfig.php';

$sql_apr=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 

while($row_apr = mysqli_fetch_array($sql_apr)) {
$apr_date = $row_apr['apr'];

$first_name = $row_apr['first_name'];
$last_name = $row_apr['last_name'];
$customer_name= $first_name.' '.$last_name;
$email = $row_apr['email'];
$mobile_number = $row_apr['mobile_number'];
$address = $row_apr['address'];
$city = $row_apr['city'];
$state = $row_apr['state'];
$zip_code = $row_apr['zip_code'];
$date_of_birth = $row_apr['date_of_birth'];
$date_ofbirth=date("m-d-y", strtotime($date_of_birth) );
$ssn = $row_apr['ssn'];



//echo $apr_date;

}

$sql1 = mysqli_query($con, "SELECT  From business_group WHERE bg_name= '$loan_name'");
$row1 = mysqli_num_rows($sql1);

while ($row1 = mysqli_fetch_array($sql1)){

$portfolio = $row1['bg_name'];
}



?>
<h4 style="text-align:center">Creation Of New Installment Loan for Customer : <span style="color:red;font-weight:bold;"><?php echo $customer_name; ?></span> </h4>
<div class="row wrapper" style="background-color: #F5E09E;color: white;padding:40px;">
    
<div class="col-lg-3"><p style="color:black;">Customer Name:<b style="color:red"> <?php echo $customer_name;?></b></p></div>
<div class="col-lg-3"><p style="color:black;">Customer Phone:<b style="color:red"> <?php echo $mobile_number;?></b></p></div>
<div class="col-lg-3"><p style="color:black;">Customer Email:<b style="color:red"> <?php echo $email;?></b></p></div>
<div class="col-lg-3"><p style="color:black;">Customer Address: <b style="color:red"> <?php echo $address;?> </b> </p></div>
<div class="col-lg-3"><p style="color:black;">Customer City:<b style="color:red"> <?php echo $city;?></b></p></div>
<div class="col-lg-3"><p style="color:black;">Customer State:<b style="color:red"> <?php echo $state;?></b></p></div>
<div class="col-lg-3"><p style="color:black;">Customer SSN:<b style="color:red"> <?php echo $ssn;?></b></p></div>
<div class="col-lg-3"><p style="color:black;">Customer DOB:<b style="color:red"> <?php echo $date_ofbirth;?></b></p></div>
</div>


  <form action ="" method="POST" enctype="multipart/form-data">
      
      
      
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
     
      <div class="col-lg-6">
      <label for="usr">Portfolio</label>
      <select name="source" id="source" class="form-control"  value="" onchange="yesnoCheck(this);">
<option value="Payday Loans" <?php if($loan_name=='Payday Loans'){ echo 'selected';} ?>>Payday Loans</option>
<option value="Title Loans" <?php if($loan_name=='Title Loans'){ echo 'selected';} ?>>Title Loans</option>
<option value="Personal Loans" <?php if($loan_name=='Personal Loans'){ echo 'selected';} ?>>Personal Loans</option>
<option value="Commercial Loan" <?php if($loan_name=='Commercial Loan'){ echo 'selected';} ?>>Commercial Loan</option>

     </select>
    </div>
      
    <div class="col-lg-6">
      <label for="usr"> Loan ID</label>
      <input type="text" name="loan_id" value = "<?php echo $rowcount_count_loans; ?>"class="form-control"/>
      </div>


     <div class="col-lg-6" id="ifNo">
      <label for="usr">Principal</label>
     <input type="number" name="principal" class="form-control" id="usr" placeholder="" value="" Required>
    </div>


  <div class="col-lg-3">
      <label for="usr">Interest %</label>
      <input type="text" name="interest" class="form-control" id="usr" placeholder="" value="" Required>
    </div>
    <div class="col-lg-3">
      <label for="usr">Years</label>
      <input type="number" name="years" class="form-control" id="usr" step="any" placeholder="" value="" Required>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Late Fee</label>
      <input type="number" name="late_fee" class="form-control" id="usr" placeholder="" value="">
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Origination/Contract Fee</label>
      <input type="number" name="origination" class="form-control" id="usr" placeholder="" value="">
    </div>
    
    
    
     <div class="col-lg-6">
      <label for="usr">Installment Plan</label>
      <select name="installment_plan" id="installment_plan" class="form-control"  value="">
<option value=""></option>
<option value="Weekly">Weekly</option>
<option value="Bi-Weekly">Bi-Weekly</option>
<option value="Monthly">Monthly</option>

     </select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Total Number of Payments</label>
      <input type="number" name="total_payments" class="form-control" id="usr" placeholder="" value="">
    </div>
    
 
   
    
    <div class="col-lg-6">
      <label for="usr">Contract Strat Date</label>
      <input type="date" name="contract_date" class="form-control" id="usr" placeholder="YYYY/MM/DD" value="<?php $date = date('Y-m-d'); echo $date; ?>">
    </div>
    
    <?php
   ////$Date = "2019-09-20";
 
$dayss=date('Y-m-d', strtotime($date. "+ {$apr_date} days"));


?>
    
    <div class="col-lg-6">
      <label for="usr">Contract End Date</label>
      <input type="date" name="payment_date" class="form-control" id="usr" placeholder="YYYY/MM/DD" value="<?php if ($apr_date=='')
{
    
    $next=date('Y-m-d', strtotime($date. "+ 10 days"));
//echo $next;
echo $due_date;
}
else
{
  echo $dayss;  
} ?>">
    </div>
    
    
     <div class="col-lg-6">
      <label for="usr">Select State</label>
      <select name="state" id="state" class="form-control"  value="">
<option value=""></option>
<option value="AZ">Arizona</option>
<option value="NV">Naveda</option>
     </select>
    </div>
    
    
    
    </div>
    
    <br>
  
 
    

<button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Calculate/Save</button> 
  </form>
  
</div>
</div>

<hr>
<?php 

   
   

if(isset($_POST['btn-submit'])) 
{
     $fnd_name_id= $_POST['name_id'];
     
     $source=$_POST['source'];
     $loan_create_id=$_POST['loan_id'];
     $principal_amount=$_POST['principal'];
     $interest=$_POST['interest'];
     $years=$_POST['years'];
     $late_fee=$_POST['late_fee'];
     $origination=$_POST['origination'];
     $installment_plan=$_POST['installment_plan'];
     $total_payments=$_POST['total_payments'];
     $contract_date=$_POST['contract_date'];
     $payment_date=$_POST['payment_date'];
     $state_arizona=$_POST['state'];
     
    $apr=str_replace("%","","$apr");
     
 $amount_loan=$principal_amount*$apr;
 $amount_loan=$amount_loan/100;
 $amount_loan = number_format((float)$amount_loan, 2, '.', '');
 
$daily_interest=$amount_loan/365;
$daily_interest = number_format((float)$daily_interest, 2, '.', '');

   $date = date('Y-m-d H:i:s');

 
 $query_userid3 = mysqli_query($con,"Select user_fnd_id from fnd_user_profile where first_name ='$fnd_name_id'");
while ($row_user_id3=mysqli_fetch_array($query_userid3)){
    $fnd_id = $row_user_id3[0];
    
    $apr = $row_user_id3['apr'];
    
    //echo"<br><br><br><br><br><br><br><br> <br><br>User_Key:" .$fnd_id;

}


 $query3 = mysqli_query($con,"Select loan_fee,payoff_amount from tbl_loan_setting where loan_amount ='$amount_loan'");
while ($row3=mysqli_fetch_array($query3)){
    
                 $loan_fee = $row3['loan_fee'];
                 $payoff_amount = $row3['payoff_amount'];
    
    

}





     
    //  $query  = "INSERT INTO `tbl_personal_loans`(`user_fnd_id`, `bg_id`, `amount_of_loan`, `loan_interest`, `late_fee`, `contract_fee`, `installment_plan`, `total_payments`, `principal_amount`, `contract_date`, `payment_date`, `creation_date`, `created_by`, `loan_create_id`, `loan_status`)  VALUES ('$fnd_idd','$source','$principal_amount','$interest','$late_fee','$origination','$installment_plan','$total_payments','$principal_amount','$contract_date','$payment_date','$date','$u_id','$loan_create_id','Active')";
    //     $result = mysqli_query($con, $query);
    //     if ($result) {
    //         //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
    //     } else {
    //     echo "<h3> Error Inserting Data </h3>";
    //     } 
 

 ?>
 <script type="text/javascript">
window.location.href = 'calculate_commercial_loan.php?fnd_id=<?php echo $fnd_idd ;?>&bg_id=<?php echo $source ;?>&amount_of_loan=<?php echo $principal_amount ;?>&loan_interest=<?php echo $interest ;?>&years=<?php echo $years ;?>&late_fee=<?php echo $late_fee ;?>&contract_fee=<?php echo $origination;?>&installment_plan=<?php echo $installment_plan ;?>&total_payments=<?php echo $total_payments;?>&principal_amount=<?php echo $principal_amount;?>&contract_date=<?php echo $contract_date;?>&payment_date=<?php echo $payment_date;?>&loan_create_id=<?php echo $loan_create_id;?>&state=<?php echo $state_arizona;?>';
</script>

 <?php
}

?>
<script>
    
    function yesnoCheck(that) {
    if (that.value == "5") {
  //alert("check");
        document.getElementById("ifYes").style.display = "block";
        document.getElementById("ifNo").style.display = "none";
    } else {
        document.getElementById("ifYes").style.display = "none";
        document.getElementById("ifNo").style.display = "block";
    }
}
</script>


</body>
</html>     
