<?php
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$email_admin=$userRow['email'];
//echo $u_id;
$u_access_id = $userRow['access_id'];
if($u_access_id!='1'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
}
else {
$DBcon->close();

?>

<?php 
function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
      $email_key = generateRandomString();;
     // echo $email_key;
   
   
   
   
  


//ADMIN EMAIL STARTS

$to_email_admin = $email_admin;
$subject_admin = 'A New Customer Has Signed The Contract';
$message_admin = 'https://ofsca.com/loanportal/signature_customer/completed/index.php?id='.$email_key;
$headers_admin = 'From: admin@lsfinancing.com';
mail($to_email_admin,$subject_admin,$message_admin,$headers_admin);

//ADMIN EMAIL ENDS
?>



<?php

$fnd_idd=$_GET['id'];
$name_id= $_POST['keyword']; 
//echo "<br><br><br><br><br><br><br><br><br><br>Name Is: $name_id";
?>
<?php 

   error_reporting(0);
   include_once '../dbconnect.php';
   include_once '../dbconfig.php';

if(isset($_POST['btn-submit'])) 
{
   $fnd_name_id= $_POST['name_id'];
 
    $source=$_POST['source'];
  $loan_create_id=$_POST['loan_id'];
 // $loan_fee = 
    $amount_loan=$_POST['amount_loan'];
    $secure_loan=$_POST['sec_loan'];
    $contract_date=$_POST['contract_date'];
    $payment_date=$_POST['payment_date'];
 
 //$loan_fee = $amount_loan*0.1764;
// $total_payable = $amount_loan+$loan_fee;

// $amount_loan = number_format((float)$amount_loan, 2, '.', '');

   $date = date('Y-m-d H:i:s');

 
 $query_userid3 = mysqli_query($con,"Select user_fnd_id from fnd_user_profile where first_name ='$fnd_name_id'");
while ($row_user_id3=mysqli_fetch_array($query_userid3)){
    $fnd_id = $row_user_id3[0];
    
    $apr = $row_user_id3['apr'];
    $email = $row_user_id3['email'];
    
    //echo"<br><br><br><br><br><br><br><br> <br><br>User_Key:" .$fnd_id;

}

 //CUSTOMER EMAIL STARTS

$to_email = $email;
$subject = 'Contract';
$message = 'https://ofsca.com/loanportal/signature_customer/files/contract.php?id='.$email_key;
$message_email = 'https://ofsca.com/loanportal/signature_customer/completed/index.php?id='.$email_key;
$headers = 'From: admin@lsfinancing.com';
//mail($to_email,$subject,$message,$headers);

//CUSTOMER EMAIL ENDS


 $query3 = mysqli_query($con,"Select loan_fee,payoff_amount from tbl_loan_setting where loan_amount ='$amount_loan'");
while ($row3=mysqli_fetch_array($query3)){
    
                 $loan_fee = $row3['loan_fee'];
                 $payoff_amount = $row3['payoff_amount'];
    
    

}


$sql_fetch_loan=mysqli_query($con, "select * from tbl_commercial_loan where user_fnd_id= '$fnd_idd'"); 

while($row_fetch_loan = mysqli_fetch_array($sql_fetch_loan)) {

$loan_id=$row_fetch_loan['loan_create_id'];

}



 
$query  = "INSERT INTO tbl_commercial_loan (user_fnd_id,bg_id,amount_of_loan,secured_loan,contract_date,payment_date,creation_date,created_by,loan_create_id,loan_fee,loan_total_payable,loan_status,secondary_portfolio)  VALUES ('$fnd_idd','$source','$amount_loan','$secure_loan','$contract_date','$payment_date','$date','$u_id','$loan_create_id','$loan_fee','$payoff_amount','Active','None')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
        
        
         $query_in  = "INSERT INTO commercial_loan_initial_banking (loan_id,user_fnd_id,creation_date,update_date,created_by,email_key,sign_status,update_by)  VALUES ('$loan_id','$fndd_id','$date','$date','$u_id','$email_key','0','$u_id')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
 ?>
 
 
 
 
 
 
 
 
 <?php  
       
    $cu_id=$_GET['id'];
    //echo $cu_id;
?>  
 
 <script type="text/javascript">
window.location.href = 'customer_email_message.php?emaill=<?php echo $email; ?>&link=<?php echo $message;?>&email_link=<?php echo $message_email;?>';
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

<?php include('../menu.php') ;?>

  <div class ="container wrapper" style="margin-top:100px">
      
  <div class="row wrapper">
<?php

$sql_count_loans = "SELECT * FROM tbl_loan";
if ($result_count_loans=mysqli_query($con,$sql_count_loans))
  {
  // Return the number of rows in result set
  $rowcount_count_loans=mysqli_num_rows($result_count_loans)+9000;
  //echo "<br><br><br><br><br>".$rowcount_count_loans;
  }
?>

<?php

$id=$_GET['id'];
include '../dbconnect.php';
include '../dbconfig.php';

$sql_apr=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 

while($row_apr = mysqli_fetch_array($sql_apr)) {
$apr_date = $row_apr['apr'];
$cus_email= $row_apr['email'];
//echo $apr_date;

}
?>


  <form action ="" method="POST" enctype="multipart/form-data">
      
      <h4 style="text-align:center">Creating a New Loan for Customer : '<span style="color:red"><?php echo $_GET['name']; ?></span>' & SSN : <span style="color:red"><?php echo $_GET['ssn'];?></span>  </h4>
      
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
     
      <div class="col-lg-6">
      <label for="usr">Portfolio</label>
      <select name="source" id="source" class="form-control"  value="" onchange="yesnoCheck(this);">
     <option> </option>
     <?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';

$sql1 = mysqli_query($con, "SELECT bg_id,bg_name From business_group");
$row1 = mysqli_num_rows($sql1);

while ($row1 = mysqli_fetch_array($sql1)){

echo "<option value='". $row1['bg_id'] ."'>" .$row1['bg_name'] ."</option>" ;
}
?>
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
      <label for="usr">Secured Loan</label>
      <select name="sec_loan" id="sec_loan" class="form-control"  value="">
           <option> </option>
     <option value="Yes,this loan is secured">Yes,this loan is secured.</option>
     <option value="No,this is an unsecured loan">No,this is an unsecured loan.</option>
     
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
      <label for="usr">Payment Date</label>
      <input type="date" name="payment_date" class="form-control" id="usr" placeholder="YYYY/MM/DD" value="<?php if ($apr_date=='')
{
    
    $next=date('Y-m-d', strtotime($date. "+ 10 days"));
echo $next;
}
else
{
  echo $dayss;  
} ?>">
    </div>
    
    </div>
    
    <br>
  
 
    

<button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Calculate/Save</button> 
  </form>
  
</div>
</div>

<hr>

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
<?php
}
?>