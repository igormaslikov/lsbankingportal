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
else {
$DBcon->close();

?>
<?php

$fnd_idd=$_GET['id'];
$renew_loan_create_id=$_GET['loan_id'];
$renew_loan_status=$_GET['renew_status'];
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

$sql_apr=mysqli_query($con, "SELECT MAX(loan_create_id)+1 as next_id from tbl_loan"); 
while($row_apr = mysqli_fetch_array($sql_apr)) {
  $next_loan_id = $row_apr['next_id'];
  }
?>

<?php

$id=$_GET['id'];
$loan_name=$_GET['loan'];
$due_date=$_GET['next_pay_date'];
$loan_amount=$_GET['loan_amount'];
$state=$_GET['state'];
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
      
      <h4 style="text-align:center">Creating a New Loan for Customer : <span style="color:red"><?php echo $_GET['name']; ?></span> & State : <span style="color:red"><?php echo $_GET['state'];?></span> & SSN : <span style="color:red"><?php echo $_GET['ssn'];?></span>  </h4>
      
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
     
      <div class="col-lg-6">
      <label for="usr">Portfolio*</label>
      <select name="source" id="source" class="form-control"  value="" onchange="yesnoCheck(this);" required>
<option value="Payday Loans" <?php if($loan_name=='Payday Loans'){ echo 'selected';} ?>>Payday Loans</option>
<option value="Title Loans" <?php if($loan_name=='Title Loans'){ echo 'selected';} ?>>Title Loans</option>
<option value="Personal Loans" <?php if($loan_name=='Personal Loans'){ echo 'selected';} ?>>Personal Loans</option>
<option value="Commercial Loans" <?php if($loan_name=='Commercial Loans'){ echo 'selected';} ?>>Commercial Loans</option>

     </select>
    </div>
      
    <div class="col-lg-6" hidden>
      <label for="usr"> Loan ID</label>
      <input type="text" name="loan_id" value = "<?php echo $next_loan_id; ?>" class="form-control" readonly >
      </div>

    
    <div class="col-lg-6" >
      <label for="usr">Select State</label>
     <Select id="colorselector" class="form-control" required>
   <option value=""></option>
   <option value="CA">Clifornia</option>
   <option value="NV">Nevada</option>
   <option value="IL">Illinois</option>
</Select>
    </div>

     <div id="CA" class="col-lg-6 colors" style="display:none">
      <label for="usr">Amount Of Loan For State California*</label>
      <select name="amount_loan" id="loan" class="form-control"  value="" required>
     <option> </option>
<option value="50">50</option>
<option value="100">100</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="255">255</option>
     </select>
    </div>
    
    
     <div id="NV" class="col-lg-6 colors" style="display:none">
      <label for="usr">Amount Of Loan For State Nevada*</label>
      <select name="amount_loan" id="loan" class="form-control"  value="" required>
     <option> </option>
<option value="50">50</option>
<option value="100">100</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="250">250</option>
<option value="300">300</option>
<option value="350">350</option>
<option value="400">400</option>
<option value="450">450</option>
<option value="500">500</option>
     </select>
    </div>
    
    
    <div id="IL" class="col-lg-6 colors" style="display:none">
      <label for="usr">Amount Of Loan For State Illinois*</label>
      <select name="amount_loan" id="loan" class="form-control"  value="" required>
     <option> </option>
<option value="50">50</option>
<option value="100">100</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="250">250</option>
<option value="300">300</option>
<option value="350">350</option>
<option value="400">400</option>
<option value="450">450</option>
<option value="500">500</option>
<option value="550">550</option>
<option value="600">600</option>
     </select>
    </div>

    <div class="col-lg-6">
      <label for="usr">Secured Loan*</label>
      <select name="sec_loan" id="sec_loan" class="form-control"  value="" required>
     <option value="No,this is an unsecured loan">No,this is an unsecured loan.</option>
     <option value="Yes,this loan is secured">Yes,this loan is secured.</option>
     
     
     </select>
    </div> 
    
    <div class="col-lg-6">
      <label for="usr">Contract Date*</label>
      <input type="date" name="contract_date" class="form-control" id="usr" placeholder="YYYY/MM/DD" value="<?php $date = date('Y-m-d'); echo $date; ?>" required>
    </div>
    
    <?php
   ////$Date = "2019-09-20";
 
$dayss=date('Y-m-d', strtotime($date. "+ {$apr_date} days"));


?>
    
    <div class="col-lg-6">
      <label for="usr">Due Date*</label>
      <input type="date" name="payment_date" class="form-control" id="usr" placeholder="YYYY/MM/DD" value="<?php if ($apr_date=='')
{
    
    $next=date('Y-m-d', strtotime($date. "+ 10 days"));
//echo $next;
echo $due_date;
}
else
{
  echo $dayss;  
} ?>" required>
    </div>
    
    </div>
    
    <br>
  
 
    

<button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Calculate/Save</button> 





<a href="edit_customer.php?id=<?php echo $id;?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Go Back</button> </a>  
  
  
  </form>
  
</div>
</div>

<hr>
<?php 

  include 'functions.php';

if(isset($_POST['btn-submit'])) 
{
    
    $form_name=basename(__FILE__);
    
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

 $amount_loan = number_format((float)$amount_loan, 2, '.', '');

   $date = date('Y-m-d H:i:s');

 
 $query_userid3 = mysqli_query($con,"Select user_fnd_id from fnd_user_profile where first_name ='$fnd_name_id'");
while ($row_user_id3=mysqli_fetch_array($query_userid3)){
    $fnd_id = $row_user_id3[0];
    
    $apr = $row_user_id3['apr'];
    
    //echo"<br><br><br><br><br><br><br><br> <br><br>User_Key:" .$fnd_id;

}


if ($state=="CA")
{

 $query3 = mysqli_query($con,"Select loan_fee,payoff_amount from tbl_loan_setting where loan_amount ='$amount_loan'");
while ($row3=mysqli_fetch_array($query3)){
    
                 $loan_fee = $row3['loan_fee'];
                 $payoff_amount = $row3['payoff_amount'];
    
    

}

}

if ($state=="NV")
{

 $query3 = mysqli_query($con,"Select loan_fee,payoff_amount from tbl_loan_setting_nv where loan_amount ='$amount_loan'");
while ($row3=mysqli_fetch_array($query3)){
    
                 $loan_fee = $row3['loan_fee'];
                 $payoff_amount = $row3['payoff_amount'];
    
    

}

}

 $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


    while($row_role = mysqli_fetch_array($sql_role)) {

    $form_id=$row_role['id'];
 
}  
     
     user_roles($u_access_id,$form_id);
     
     $query_loan_exists = mysqli_query($con,"SELECT COUNT(*) as count FROM tbl_loan WHERE loan_create_id ='$loan_create_id'");

     while ($row_count=mysqli_fetch_array($query_loan_exists)){
       $count_loan = $row_count['count'];
       //echo"<br><br><br><br><br><br><br><br> <br><br>User_Key:" .$fnd_id;
   
     }
 
     if($count_loan > 0){
       
        $sql_apr=mysqli_query($con, "SELECT MAX(loan_create_id)+1 as next_id from tbl_loan"); 
        while($row_apr = mysqli_fetch_array($sql_apr)) {
          $next_loan_id = $row_apr['next_id'];
        }
         //echo '<script type="text/javascript">alert("Loan ID ' . $loan_create_id . ' is exists. LoanID well be regerated to '.$next_loan_id.')</script>';
         $loan_create_id = $next_loan_id;
     }
    
         
         $query  = "INSERT INTO tbl_loan (user_fnd_id,bg_id,amount_of_loan,secured_loan,contract_date,payment_date,creation_date,created_by,loan_create_id,loan_fee,loan_total_payable,loan_status,secondary_portfolio)  VALUES ('$fnd_idd','Payday Loan','$amount_loan','$secure_loan','$contract_date','$payment_date','$date','$u_id','$loan_create_id','$loan_fee','$payoff_amount','Active','None')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
        
        
        if($renew_loan_status=="1")

     {
     
     
     $sql_access=mysqli_query($con, "select * from tbl_users where user_id= '$u_id'"); 

while($row_access = mysqli_fetch_array($sql_access)) {

$username=$row_access['username'];

	//	echo "<br><br><br><br><br><br>". $access_level_name;

}
     
     
        $transaction_id="";
        $status="Renew Loan with this ID ( $loan_create_id ) is created by $username";
        
        application_notes_update($fnd_idd,$loan_create_id,$u_id,$status,$transaction_id);
     }
        
        else{
            
        
         $transaction_id="";
         $status="NEW Loan with this ID ( $loan_create_id ) is created";
         application_notes_update($fnd_idd,$loan_create_id,$u_id,$status,$transaction_id);
        }
     

 ?>
 <script type="text/javascript">
window.location.href = 'initial_setup.php?fnd_id=<?php echo $fnd_idd ;?>&loan_id=<?php echo $renew_loan_create_id ;?>';
</script>

 <?php

 
 
}

?>
<script>
    
   $(function() {
        $('#colorselector').change(function(){
            $('.colors').hide();
            $('#' + $(this).val()).show();
        });
    });
</script>


</body>
</html>     
<?php
}
?>