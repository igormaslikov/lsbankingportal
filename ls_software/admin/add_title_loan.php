<?php
session_start();
error_reporting(0);
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

$sql_count_loans = "SELECT * FROM tbl_title_loans";
if ($result_count_loans=mysqli_query($con,$sql_count_loans))
  {
  // Return the number of rows in result set
  $rowcount_count_loans=mysqli_num_rows($result_count_loans)+3001;
  
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

//echo $apr_date;

}
$sql1 = mysqli_query($con, "SELECT  From business_group WHERE bg_name= '$loan_name'");
$row1 = mysqli_num_rows($sql1);

while ($row1 = mysqli_fetch_array($sql1)){

$portfolio = $row1['bg_name'];
}

?>


  <form action ="" method="POST" enctype="multipart/form-data">
      
      <h4 style="text-align:center">Creating a New Loan for Customer : '<span style="color:red"><?php echo $_GET['name']; ?></span>' & SSN : <span style="color:red"><?php echo $_GET['ssn'];?></span>  </h4>
      
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

    
    <!--<div class="col-lg-6" id="ifYes" style="display: none;">-->
    <!--  <label for="usr">Amount of Loan </label>-->
    <!--  <select name="amount_loan" id="amount_loan" class="form-control"  value="">-->
    <!--       <option> </option>-->
    <!-- <option value="$50">$50</option>-->
    <!-- <option value="$100">$100</option>-->
    <!-- <option value="$150">$150</option>-->
    <!-- <option value="$200">$200</option>-->
    <!-- <option value="$255">$255</option>-->
     
    <!-- </select>-->
    <!--</div>-->

     <div class="col-lg-6" id="ifNo">
      <label for="usr">Amount Of Loan</label>
      <select name="amount_loan" id="loan" class="form-control"  value="">
     <option> </option>
     <?php


$sql2 = mysqli_query($con, "SELECT loan_amount From tbl_loan_setting");
$row2 = mysqli_num_rows($sql2);

while ($row2 = mysqli_fetch_array($sql2)){

echo "<option value='". $row2['loan_amount'] ."'>" .$row2['loan_amount'] ."</option>" ;
}
?>
     </select>
    </div>


  <div class="col-lg-6">
      <label for="usr">Daily Interset</label>
      <input type="text" name="daily_interest" class="form-control" id="usr" placeholder="" value="">
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Late Fees</label>
      <input type="text" name="late_fees" class="form-control" id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Interset Type</label>
      <input type="text" name="type_interest" class="form-control" id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Principal Amount</label>
      <input type="text" name="principal_amount" class="form-control" id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Scheduling</label>
      <input type="date" name="scheduling" class="form-control" id="usr" placeholder="" value="">
    </div>


    <div class="col-lg-6">
      <label for="usr">Secured Loan</label>
      <select name="sec_loan" id="sec_loan" class="form-control"  value="">
     <option value="No,this is an unsecured loan">No,this is an unsecured loan.</option>
     <option value="Yes,this loan is secured">Yes,this loan is secured.</option>
     
     
     </select>
    </div> 
    
    <div class="col-lg-6">
      <label for="usr">Contract Date</label>
      <input type="date" name="contract_date" class="form-control" id="usr" placeholder="YYYY/MM/DD" value="<?php $date = date('Y-m-d'); echo $date; ?>">
    </div>
    
    <?php
   ////$Date = "2019-09-20";
 
$dayss=date('Y-m-d', strtotime($date. "+ {$apr_date} days"));


?>
    
    <div class="col-lg-6">
      <label for="usr">Due Date</label>
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
    
    </div>
    <h3 style="color:red;">Vehicle Info</h3>
    <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Vehicle Year</label>
 <input type="text" name="vehicle_year"  class="form-control" id="usr" value="<?php echo $vehicle_year; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle Make</label>
 <input type="text" name="vehicle_make"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_make; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle Model</label>
 <input type="text" name="vehicle_model"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_model; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle Miles</label>
 <input type="text" name="vehicle_miles"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_miles; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle KBB</label>
 <input type="text" name="vehicle_kbb"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_kbb; ?>">
    </div>
    
     <div class="col-lg-4">
      <label for="usr">Vehicle LTV</label>
 <input type="text" name="vehicle_ltv"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_ltv; ?>">
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
     $amount_loan=$_POST['amount_loan'];
    
     $daily_interest=$_POST['daily_interest'];
     $late_fees=$_POST['late_fees'];
     $type_interest=$_POST['type_interest'];
     $principal_amount=$_POST['principal_amount'];
     $scheduling=$_POST['scheduling'];
     
     
    $secure_loan=$_POST['sec_loan'];
     $contract_date=$_POST['contract_date'];
     $payment_date=$_POST['payment_date'];
     
$vehicle_year_update =$_POST['vehicle_year'];
$vehicle_make_update =$_POST['vehicle_make'];
$vehicle_model_update =$_POST['vehicle_model'];
$vehicle_miles_update =$_POST['vehicle_miles'];
$vehicle_kbb_update=$_POST['vehicle_kbb'];
$vehicle_ltv_update=$_POST['vehicle_ltv'];

 
 //$loan_fee = $amount_loan*0.1764;
// $total_payable = $amount_loan+$loan_fee;

// $amount_loan = number_format((float)$amount_loan, 2, '.', '');

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



$query4 = mysqli_query($con,"Select * from business_group where bg_id ='$source'");
while ($row4=mysqli_fetch_array($query4)){
    
                 $bg_name = $row4['bg_name'];
    }




     
     $query  = "INSERT INTO tbl_title_loans (user_fnd_id,bg_id,amount_of_loan,daily_interest,late_fees,type_interest,principal_amount,scheduling,secured_loan,contract_date,payment_date,creation_date,created_by,loan_create_id,loan_fee,loan_total_payable,loan_status,secondary_portfolio)  VALUES ('$fnd_idd','$bg_name','$amount_loan','$daily_interest','$late_fees','$type_interest','$principal_amount','$scheduling','$secure_loan','$contract_date','$payment_date','$date','$u_id','$loan_create_id','$loan_fee','$payoff_amount','Active','None')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
 
 
 
  // *********************************** Vehicle Info Insertion **********************************************
        
        $query_vehicle  = "INSERT INTO tbl_vehicle_info (user_fnd_id,vehicle_year,vehicle_made,vehicle_model,vehicle_miles,vehicle_kbb,vehicle_ltv,created_by,created_at)  VALUES ('$id','$vehicle_year_update','$vehicle_make_update','$vehicle_model_update','$vehicle_miles_update','$vehicle_kbb_update','$vehicle_ltv_update','$u_id','$date')";
        $result_vehicle = mysqli_query($con, $query_vehicle);
        if ($result_vehicle) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 

 ?>
 <script type="text/javascript">
window.location.href = 'title_initial_setup.php?fnd_id=<?php echo $fnd_idd ;?>';
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
