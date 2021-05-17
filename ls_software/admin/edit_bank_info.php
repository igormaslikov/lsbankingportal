<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

error_reporting(0);
if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$uuu_id=$userRow['user_id'];
$use_name=$userRow['username'];
//echo "<br><br><br>id is:".$uu_id;

$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}

$id=$_GET['id'];
$fnd_id=$_GET['fnd_id'];
//echo "id is::".$id;


$sql_bank_detail=mysqli_query($con, "select * from loan_initial_banking where initial_id = '$id'"); 

while($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {

$type_of_id=$row_bank_detail['type_of_id'];
$id_photo=$row_bank_detail['pic_of_id'];
$type_of_card=$row_bank_detail['type_of_card'];

$card_number=$row_bank_detail['card_number'];
$card_exp_date=$row_bank_detail['card_exp_date'];
$bank_front=$row_bank_detail['bank_front_pic'];

$bank_back=$row_bank_detail['bank_back_pic'];
$bank_name=$row_bank_detail['bank_name'];
$routing_number=$row_bank_detail['routing_number'];

$account_number=$row_bank_detail['account_number'];
$void_img=$row_bank_detail['void_check_pic'];
$cvv_number=$row_bank_detail['cvv_number'];

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
    max-width: 1340px;
    padding: 0;
    position: relative;
}

.timeTextBox {
   margin-top: -33px;
    margin-left: 2px;
    height: 32px;
    width: 90%;
    border: none;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    
 $(document).ready(function(){
   
    $(".editableBox").change(function(){         
        $(".timeTextBox").val($(".editableBox option:selected").html());
    });
});   
    
    
</script>
</head>
<body>
    
    <?php include('menu.php') ;?>


  <div class ="container wrapper" style="margin-top:70px">

  <div class="row wrapper">
      
 <form action ="" method="POST" enctype="multipart/form-data">
  
     <div class="col-lg-6">
      <label for="usr">Type of Card</label>
      <select name="type_card" id="type_card" class="form-control"  value="" >
     <option></option>
     <option value="Visa" <?php if($type_of_card=='Visa'){ echo 'selected';} ?>>Visa</option>
      <option value="Master Card" <?php if($type_of_card=='Master Card'){ echo 'selected';} ?>>Master Card</option>
     </select>
    </div>
    
   
    
    <div class="col-lg-6">
      <label for="usr">Card Expiration Date</label>
      <input type="text" name="card_exp_date"  class="form-control" id="usr" value="<?php echo $card_exp_date;?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Number</label>
      <input type="text" name="card_number"  class="form-control" id="usr" value="<?php echo $card_number;?>" ><br>
    </div>
    
   
    <div class="col-lg-6">
      <label for="usr">Bank Name</label>
      <select name="bank_name" id="bank_name" class="form-control editableBox"  value="">
     <option></option>
     <option value="Bank Of America" <?php if($bank_name=='Bank Of America'){ echo 'selected';} ?>>Bank Of America</option>
     <option value="Chase" <?php if($bank_name=='Chase'){ echo 'selected';} ?>>Chase</option>
     <option value="Wells Fargo" <?php if($bank_name=='Wells Fargo'){ echo 'selected';} ?>>Wells Fargo</option>
     <option value="Citi Bank " <?php if($bank_name=='Citi Bank'){ echo 'selected';} ?>>Citi Bank </option>
     <option value="US Bank" <?php if($bank_name=='US Bank'){ echo 'selected';} ?>>US Bank</option>
     <option value="HSBC" <?php if($bank_name=='HSBC'){ echo 'selected';} ?>>HSBC</option>
     </select>
	 <input class="timeTextBox" name="bank_name" value="<?php echo $bank_name;?>"/>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Routing Number</label>
      <input type="text" name="routing_number"  class="form-control" id="usr" value="<?php echo $routing_number;?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Account Number</label>
      <input type="text" name="account_number"  class="form-control" id="usr" value="<?php echo $account_number;?>" ><br>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr">CVV Number</label>
      <input type="text" name="cvv_number"  class="form-control" id="usr" value="<?php echo $cvv_number;?>" >
    </div>
    

     <div class="col-lg-6">
     <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update Bank Info</button>
   </div>
    </form>
  
  </div>

</body>
</html>

 <?php
      include 'functions.php';
    $form_name=basename(__FILE__);
    

 $sql_role=mysqli_query($con, "select * from access_form where form_name ='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 //echo $form_id;
}
 $update_allowed_validate = user_edit_roles($u_access_id,$form_id);
      
     if(isset($_POST['btn-submit'])) 
{
    
    
     $type_id_up= $_POST['type_id'];
     $type_card_up= $_POST['type_card'];
     $card_exp_date_up= $_POST['card_exp_date'];
     $card_number_up= $_POST['card_number'];
     $bank_name_up= $_POST['bank_name'];
     $routing_number_up= $_POST['routing_number'];
     $account_number_up= $_POST['account_number'];
     $cvv_number_up= $_POST['cvv_number'];
     
     
     $type_id_up_sec= $_POST['type_id_sec'];
     $type_card_up_sec= $_POST['type_card_sec'];
     $card_exp_date_up_sec= $_POST['card_exp_date_sec'];
     $card_number_up_sec= $_POST['card_number_sec'];
     $bank_name_up_sec= $_POST['bank_name_sec'];
     $routing_number_up_sec= $_POST['routing_number_sec'];
     $account_number_up_sec= $_POST['account_number_sec'];
     $cvv_number_up_sec= $_POST['cvv_number_sec'];
   
   if ($update_allowed_validate==1)
{
   
        
        $loan_create_id="";
        $transaction_id="";
        $edit_reason="The Bank Info is Updated by $use_name";
      mysqli_query($con, "UPDATE loan_initial_banking SET type_of_card='$type_card_up', card_number='$card_number_up', card_exp_date='$card_exp_date_up', bank_name='$bank_name_up', routing_number='$routing_number_up', account_number='$account_number_up', cvv_number='$cvv_number_up' where initial_id='$id'");
   
       application_notes_update($fnd_id,$loan_create_id,$uuu_id,$edit_reason,$transaction_id);
   
     
 ?>
    
    <script type="text/javascript">
window.location.href = 'edit_customer.php?id=<?php echo $fnd_id?>&page_no=&status=All&keyword=&website=All&from_date=&to_date=';
</script>
<?php
}

else{
  echo "<script type='text/javascript'>
window.location.href = 'not_authorize.php';
</script>";
}
}


?>

