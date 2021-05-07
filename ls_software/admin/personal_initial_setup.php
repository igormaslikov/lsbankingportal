<?php
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
else {
$DBcon->close();

?>


<?php function generateRandomString($length = 8) {
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
     

   
   $id_fnd=$_GET['fnd_id'];

$sql_fetch_fnd=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id_fnd'"); 

while($row_fetch_fnd = mysqli_fetch_array($sql_fetch_fnd)) {

$email=$row_fetch_fnd['email'];

$id_photo=$row_fetch_fnd['id_photo'];
// echo "<br><br><br><br><br>".$id_photo;
$bank_front=$row_fetch_fnd['bank_front'];
$bank_back=$row_fetch_fnd['bank_back'];
$void_img=$row_fetch_fnd['void_img'];



}



$sql_fetch_loan=mysqli_query($con, "select * from tbl_personal_loans where user_fnd_id= '$id_fnd'"); 

while($row_fetch_loan = mysqli_fetch_array($sql_fetch_loan)) {

$loan_id=$row_fetch_loan['loan_create_id'];

}
//echo "loan id:".$loan_id;
$fndd_id=$id_fnd;
// echo "loan id:".$fndd_id;
$state=$_GET['state'];

if($state=='AZ')
{


$azrizona_message='https://lsbankingportal.com/signature_personal_arizona_customer/files/contract.php?id='.$email_key;
$azrizona_email='https://lsbankingportal.com/signature_personal_arizona_customer/completed/index.php?id='.$email_key;

    //echo $azrizona_message;
    //echo $azrizona_email;
}

else
{
     $azrizona_message='https://lsbankingportal.com/signature_personal_naveda_customer/files/contract.php?id='.$email_key;
     $azrizona_email='https://lsbankingportal.com/signature_personal_naveda_customer/completed/index.php?id='.$email_key;
     
     //echo $azrizona_message;
     //echo $azrizona_email;
}


//CUSTOMER EMAIL STARTS

$to_email = $email;
$subject = 'Contract';
$message = $azrizona_message;
$message_email = $azrizona_email;
$headers = 'From: support@mymoneyline.com';
//mail($to_email,$subject,$message,$headers);

//CUSTOMER EMAIL ENDS

//echo "loan id:".$loan_id;


$sql_fetch_user=mysqli_query($con, "select * from tbl_users"); 

while($row_fetch_user = mysqli_fetch_array($sql_fetch_user)) {

$email_admin=$row_fetch_user['email'];
//echo "<br><br><br><br><br>admin email:".$email_admin;
}

//ADMIN EMAIL STARTS

$to_email_admin = $email_admin;
$subject_admin = 'A New Customer Has Signed The Contract';
$message_admin = $azrizona_email;
$headers_admin = 'From: support@mymoneyline.com';
mail($to_email_admin,$subject_admin,$message_admin,$headers_admin);

//ADMIN EMAIL ENDS


?>

<?php 
   
   //echo "loan id:".$loan_id;
   //echo "Fnd id:".$fndd_id;
   
if(isset($_POST['btttn-submit'])) 
{
    
$type_id= $_POST['type_id'];
$type_card= $_POST['type_card'];
$card_number= $_POST['card_number'];
//$card_exp_date=$_POST['card_exp_date'];

$expiry_year_card = $_POST['expiry_year_card'];
$expiry_month_card = $_POST['expiry_month_card'];
$card_exp_date = $expiry_month_card. "/".$expiry_year_card;

$bank_name=$_POST['bank_name'];
$routing_number = $_POST['routing_number'];
$account_number = $_POST['account_number'];
$cvv_number = $_POST['cvv_number'];

     $sourcee=$_POST['bg_idd'];
     $loan_create_idd=$_POST['loan_create_idd'];
     $principal_amountt=$_POST['principal_amountt'];
     $interestt=$_POST['loan_interest'];
     $yearss=$_POST['yearss'];
     $late_feee=$_POST['late_feee'];
     $originationn=$_POST['contract_feee'];
     $installment_plann=$_POST['installment_plann'];
     $total_paymentss=$_POST['total_paymentss'];
     $contract_datee=$_POST['contract_datee'];
     $payment_datee=$_POST['payment_datee'];
   





$date = date('Y-m-d H:i:s');

        $imgFile = $_FILES['file_image']['name'];
        $tmp_dir = $_FILES['file_image']['tmp_name'];
        $imgSize = $_FILES['file_image']['size'];
        
        $imgFilee = $_FILES['imageee']['name'];
        $tmp_dirr = $_FILES['imageee']['tmp_name'];
        $imgSizee = $_FILES['imageee']['size'];
        
        $imgFileee = $_FILES['imageeee']['name'];
        $tmp_dirrr = $_FILES['imageeee']['tmp_name'];
        $imgSizeee = $_FILES['imageeee']['size'];
        
        $imgFileeee = $_FILES['imageeeee']['name'];
        $tmp_dirrrr = $_FILES['imageeeee']['tmp_name'];
        $imgSizeeee = $_FILES['imageeeee']['size'];
        
        $final_File = "";
        $final_Filee = "";
        $final_Fileee = "";
        $final_Fileeee = "";
        
        
        if(isset($_POST['txt_image'])) 
{
    $final_File = $_POST['txt_image'];
    $final_File= str_replace(" ","","$final_File");
}
else if(isset($_FILES['file_image'])) 
{
        // Upload Picture of ID Starts
    
            $upload_dir = '../dl_client_files/photo_id/'; // upload directory
    
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;
            $final_File  = $userpic;  
            
                if($imgSize > 0000000)  {
                    // Nothing
                }
                else {
                    $final_File = "";
                }
            // allow valid image file formats
            if(in_array($imgExt, $valid_extensions)){            
                // Check file size '5MB'
                
                if($imgSize < 5000000)                {
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
            
            
    // Upload Picture of ID Ends        
            
}


 if(isset($_POST['txt_file_bf'])) 
{
    $final_Filee = $_POST['txt_file_bf'];
    $final_Filee= str_replace(" ","","$final_Filee");
}
else if(isset($_FILES['imageee'])) 
{
    // Bank Card Front Image Start
     
             $upload_dirrr = '../dl_client_files/bank_front_image/'; // upload directory
    
            $imgExtt = strtolower(pathinfo($imgFilee,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpicc = rand(1000,1000000).".".$imgExtt;
              $final_Filee = $userpicc; 
                if($imgSizee > 0000000)  {
                    // Nothing
                }
                else {
                    $final_Filee = "";
                }
            // allow valid image file formats
            if(in_array($imgExtt, $valid_extensionss)){            
                // Check file size '5MB'
                if($imgSizee < 5000000)                {
                    move_uploaded_file($tmp_dirr,$upload_dirrr.$userpicc);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
     
     
     // Bank Card Front Image End
}


      if(isset($_POST['txt_file_bb'])) 
{
    $final_Fileee = $_POST['txt_file_bb'];
    $final_Fileee= str_replace(" ","","$final_Fileee");
}
else if(isset($_FILES['imageeee'])) 
{
      // Bank Card Back Image Start
     
             $upload_dirrrr = '../dl_client_files/bank_back_image/'; // upload directory
    
            $imgExtt = strtolower(pathinfo($imgFileee,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpiccc = rand(1000,1000000).".".$imgExtt;
              $final_Fileee = $userpiccc; 
                if($imgSizeee > 0000000)  {
                    // Nothing
                }
                else {
                    $final_Fileee = "";
                }
            // allow valid image file formats
            if(in_array($imgExtt, $valid_extensionss)){            
                // Check file size '5MB'
                if($imgSizeee < 5000000)                {
                    move_uploaded_file($tmp_dirrr,$upload_dirrrr.$userpiccc);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
     
     
     // Bank Card Back Image End
}



 if(isset($_POST['txt_file_vi'])) 
{
    $final_Fileeee = $_POST['txt_file_vi'];
    $final_Fileeee= str_replace(" ","","$final_Fileeee");
    //echo"<br><br><br><br>".$final_Fileeee;
}
else if(isset($_FILES['imageeeee'])) 
{
     
      // Void Check Image Start
     
             $upload_dirrrrr = '../dl_client_files/void_img/'; // upload directory
    
            $imgExtt = strtolower(pathinfo($imgFileeee,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpicccc = rand(1000,1000000).".".$imgExtt;
                $final_Fileeee = $userpicccc;
                  if($imgSizeeee > 0000000)  {
                    // Nothing
                }
                else {
                    $final_Fileeee = "";
                }
            // allow valid image file formats
            if(in_array($imgExtt, $valid_extensionss)){            
                // Check file size '5MB'
                if($imgSizeeee < 5000000)                {
                    move_uploaded_file($tmp_dirrrr,$upload_dirrrrr.$userpicccc);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
     
     
     // Void Check Image End
   
} 
 
    $query_in  = "INSERT INTO personal_loan_initial_banking (loan_id,user_fnd_id,type_of_id,pic_of_id,type_of_card,card_number,card_exp_date,bank_front_pic,bank_back_pic,bank_name,routing_number,account_number,void_check_pic,cvv_number,creation_date,update_date,created_by,email_key,sign_status,update_by)  VALUES ('$loan_create_idd','$fndd_id','$type_id','$final_File','$type_card','$card_number','$card_exp_date','$final_Filee','$final_Fileee','$bank_name','$routing_number','$account_number','$final_Fileeee','$cvv_number','$date','$date','$u_id','$email_key','0','$u_id')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
    
    
       $query  = "INSERT INTO `tbl_personal_loans`(`user_fnd_id`, `bg_id`, `amount_of_loan`, `loan_interest`, `years`, `late_fee`, `contract_fee`, `installment_plan`, `total_payments`, `principal_amount`, `contract_date`, `payment_date`, `creation_date`, `created_by`, `loan_create_id`, `loan_status`, `state`)  VALUES ('$fndd_id','$sourcee','$principal_amountt','$interestt','$yearss','$late_feee','$originationn','$installment_plann','$total_paymentss','$principal_amountt','$contract_datee','$payment_datee','$date','$u_id','$loan_create_idd','Active','$state')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
    
     
    
    mysqli_query($con, "UPDATE fnd_user_profile SET id_photo ='$final_File', bank_front='$final_Filee', bank_back='$final_Fileee', void_img='$final_Fileeee'  where user_fnd_id ='$fndd_id'"); 
    
?>

















<script type="text/javascript">
window.location.href = 'customer_email_message_personal_loan.php?emaill=<?php echo $email; ?>&link=<?php echo $message;?>&email_link=<?php echo $message_email;?>';
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
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">

<input type="text" name="fnd_idd" value="<?php echo $_GET['fnd_id'];?>" style="display:none;">
<input type="text" name="bg_idd" value="<?php echo $_GET['bg_id'];;?>" style="display:none;">
<input type="text" name="loan_create_idd" value="<?php echo $_GET['loan_create_id'];;?>" style="display:none;">
<input type="text" name="principal_amountt" value="<?php echo $_GET['principal_amount'];;?>" style="display:none;">
<input type="text" name="loan_interest" value="<?php echo $_GET['loan_interest'];;?>" style="display:none;">
<input type="text" name="yearss" value="<?php echo $_GET['years'];;?>" style="display:none;">
<input type="text" name="late_feee" value="<?php echo $_GET['late_fee'];;?>" style="display:none;">
<input type="text" name="contract_feee" value="<?php echo $_GET['contract_fee'];;?>" style="display:none;">
<input type="text" name="installment_plann" value="<?php echo $_GET['installment_plan'];;?>" style="display:none;">
<input type="text" name="total_paymentss" value="<?php echo $_GET['total_payments'];;?>" style="display:none;">
<input type="text" name="contract_datee" value="<?php echo $_GET['contract_date'];;?>" style="display:none;">
<input type="text" name="payment_datee" value="<?php echo $_GET['payment_date'];;?>" style="display:none;">


  <h3>User Information</h3>
  <br>
  <div class="row">
      
 <div class="col-lg-6">
      <label for="usr">Type of ID</label>
      <select name="type_id" id="type_id" class="form-control"  value="">
     <option></option>
     <option value="Drivers License">Drivers License</option>
      <option value="State Personal ID">State Personal ID</option>
      <option value="Matricula Consular ID">Matricula Consular ID</option>
      <option value="Tribal ID">Tribal ID</option>
      <option value="Passport">Passport</option>
      <option value="Military ID">Military ID</option>
      <option value="Other">Other</option>
     </select>
    </div> 
  
  
 
 
 <?php
 if(empty($id_photo)){
    echo'<div class="col-lg-6">
      <label for="usr">Upload Picture of ID</label>
      <input type="file" name="file_image"  class="form-control" accept="image/*"><br>
    </div>';
    }
    
    else{
        
        echo'<div class="col-lg-6">
      <label for="usr">Upload Picture of ID</label>
      <input type="text" name="txt_image" style="display:none"  class="form-control" value="';?><?php echo $id_photo;?><?php echo'"> <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/photo_id/'.$id_photo.'" target="_blank" > View Image </a><br>
      <br>
    </div>';
    }
    ?>
    
    
    
    
    <div class="col-lg-6">
      <label for="usr">Type of Card</label>
      <select name="type_card" id="type_card" class="form-control"  value="">
     <option></option>
     <option value="Visa">Visa</option>
      <option value="Master Card">Master Card</option>
     </select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Number</label>
      <input type="text" name="card_number"  class="form-control" id="usr"><br>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Expiration Date</label>
       <br>
      Month 
      <select style="width:20%" name="expiry_year_card" id="expiry_year_card" class="form-control"  value="" required>
     <option></option>
     <option value="01">01</option>
     <option value="02">02</option>
     <option value="03">03</option>
     <option value="04">04</option>
     <option value="05">05</option>
     <option value="06">06</option>
     <option value="07">07</option>
     <option value="08">08</option>
     <option value="09">09</option>
     <option value="10">10</option>
     <option value="11">11</option>
     <option value="12">12</option>
     </select>
     
     Year
      <select  style="width:20%" name="expiry_month_card" id="expiry_month_card" class="form-control"  value="" required>
     <option></option>
     <option value="20">20</option>
     <option value="21">21</option>
     <option value="22">22</option>
     <option value="23">23</option>
     <option value="24">24</option>
     <option value="25">25</option>
     <option value="26">26</option>
     <option value="27">27</option>
     <option value="28">28</option>
     <option value="29">29</option>
     <option value="30">30</option>
     </select>
     
     
     
    </div>
    
    
    <?php
 if(empty($bank_front)){
    echo '<div class="col-lg-6">
      <label for="usr">Upload Bank Card Front</label>
      <input type="file" name="imageee"  class="form-control" accept="image/*"><br>
    </div>';
    
 }
 
  else{
        
        echo'<div class="col-lg-6">
      <label for="usr">Upload Bank Card Front</label>
      <input type="text" name="txt_file_bf" style="display:none"  class="form-control" value="';?><?php $bank_front= str_replace(" ","","$bank_front");echo $bank_front;?><?php echo'">
       <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/bank_front_image/'.$bank_front.'" target="_blank" > View Image </a><br>
      <br>
    </div>';
    }
    
    ?>
    
    
    
    <?php
    if(empty($bank_back)){
    echo '
    
    <div class="col-lg-6">
      <label for="usr">Upload Bank Card Back</label>
      <input type="file" name="imageeee"  class="form-control" accept="image/*">
    </div>';
    }
    
    
    else{
        
        echo'

    <div class="col-lg-6">
      <label for="usr">Upload Bank Card Back</label>
      <input type="text" name="txt_file_bb" style="display:none"  class="form-control" value="'; ?><?php $bank_back= str_replace(" ","","$bank_back"); echo $bank_back; ?><?php echo '">
       <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/bank_back_image/'.$bank_back.'" target="_blank" > View Image </a><br>
      <br>
    </div>';
    }
    ?>
    
    <div class="col-lg-6">
      <label for="usr">Bank Name</label>
      <select name="bank_name" id="bank_name" class="form-control"  value="">
     <option></option>
     <option value="Bank Of America">Bank Of America</option>
     <option value="Chase">Chase</option>
     <option value="Wells Fargo">Wells Fargo</option>
     <option value="Citi Bank ">Citi Bank </option>
     <option value="US Bank">US Bank</option>
     <option value="HSBC">HSBC</option>
     </select><br>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Routing Number</label>
      <input type="text" name="routing_number"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Account Number</label>
      <input type="text" name="account_number"  class="form-control" id="usr"><br>
    </div>
    
    <?php
    if(empty($void_img)){
    echo '
    <div class="col-lg-6">
      <label for="usr">Upload Void Check</label>
      <input type="file" name="imageeeee"  class="form-control" accept="image/*">
    </div>';
    }
     else{
        
        echo'

    <div class="col-lg-6">
      <label for="usr">Upload Void Check</label>
      <input type="text" name="txt_file_vi"  style="display:none" class="form-control" value="'; ?><?php $void_img= str_replace(" ","","$void_img");  echo $void_img; ?><?php echo '">
       <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/void_img/'.$void_img.'" target="_blank" > View Image </a><br>
      <br>
    </div>';
    }
    ?>
    
    
    <div class="col-lg-6">
      <label for="usr">CVV Number</label>
      <input type="text" name="cvv_number"  class="form-control" id="usr">
    </div>
    
    </div>

    <br>
    
     <button name="btttn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add this Setup</button>
  </form>
  
</div>
</div>

<hr>

</body>
</html>    


<?php
}
?>



  <div class ="container wrapper" style="margin-top:100px">
  <div class="row wrapper">
  <div align="center">

<?php

     $fnd_idd=$_GET['fnd_id'];

     $source=$_GET['bg_id'];
     $loan_create_id=$_GET['loan_create_id'];
     $principal_amount=$_GET['principal_amount'];
     $loan_interest=$_GET['loan_interest'];
     $years=$_GET['years'];
     
     $late_fee=$_GET['late_fee'];
     $origination=$_GET['contract_fee'];
     $installment_plan=$_GET['installment_plan'];
     $total_payments=$_GET['total_payments'];
     $contract_date=$_GET['contract_date'];
     $payment_date=$_GET['payment_date'];
     //$years_interest=$loan_interest*$years;
     if($installment_plan=='Weekly')
     {
         $number_of_payments='52';
     }
     
      else if($installment_plan=='Bi-Weekly')
     {
         $number_of_payments='26';
     }
     
     else if($installment_plan=='Monthly')
     {
         $number_of_payments='12';
     }
     
     $one_payment_interest=$loan_interest/$number_of_payments;

//echo $one_payment_interest;
// look for no POST entries, or the RESET button
if (count($_POST) == 0 or @$_POST['reset']) {
    // POST array is empty - set initial values
    $principal = $principal_amount;
    $number    = $total_payments;
    $rate      = $one_payment_interest;
    //$payment   = $principal_amount/$total_payments;
    $payment = calc_payment($principal, $number, $rate, 2);
} else {
    // retrieve values from POST array
    $principal = $_POST['principal'];
    $number    = $_POST['number'];
    $rate      = $_POST['rate'];
    $payment   = $_POST['payment'];
    $loan_create_id = $_POST['loan_create_id'];
} // if
// validate all fields
$error = array();
if (!empty($principal)) {
   if (!is_numeric($principal)) {
      $error['principal'] = "must be numeric";
   } elseif ($principal < 0) {
      $error['principal'] = "must be > zero";
   } else {
      $principal = (float)$principal;    // convert to floating point
   } // if
} // if

if (!empty($number)) {
   if (!preg_match('/^[0-9]+$/', $number)) {
      $error['number'] = "must be an integer";
   } else {
      $number = (int)$number;    // convert to integer
   } // if
} // if

if (!empty($rate)) {
   if (!is_numeric($rate)) {
      $error['rate'] = "must be numeric";
   } elseif ($rate < 0) {
      $error['rate'] = "must be > zero";
   } else {
      $rate = (float)$rate;    // convert to floating point
   } // if
} // if

if (!empty($payment)) {
   if (!is_numeric($payment)) {
      $error['payment'] = "must be numeric";
   } elseif ($payment < 0) {
      $error['payment'] = "must be > zero";
   } else {
      $payment = (float)$payment;    // convert to floating point
   } // if
} // if

if (count($error) == 0) {
   // no errors - perform requested action
   if (isset($_POST['button1'])) {
      $principal = calc_principal($number, $rate, $payment);
   } // if
   if (isset($_POST['button2'])) {
      $number = calc_number($principal , $rate, $payment);
   } // if
   if (isset($_POST['button3'])) {
      $rate = calc_rate($principal, $number, $payment);
   } // if
   if (isset($_POST['button4'])) {
      $payment = calc_payment($principal, $number, $rate, 2);
   } // if
} // if
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<table border="1">
<colgroup align="right">
<colgroup align="left">
<colgroup align="center">
<!--<tr>-->
<!--    <td>Principal</td><td><input type="text" name="principal" value="<?php //echo $principal ?>" >-->
<?php
  if (isset($error['principal'])) {
      echo '<p class="error">' .$error['principal'] .'</p>';
   } // if
?>
<!--    </td><td><input type="submit" name="button1" value="calculate Principal" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;width: 100%;"></td>-->
<!--</tr>-->
<!--<tr>-->
<!--    <td>Number of Payments</td><td><input type="text" name="number" value="<?php //echo $number ?>" >-->
<?php
   if (isset($error['number'])) {
      echo '<p class="error">' .$error['number'] .'</p>';
   } // if
?>
<!--    </td><td><input type="submit" name="button2" value="calculate Number " style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;width: 100%;"></td>-->
<!--</tr>-->
<!--<tr>-->
<!--    <td>Interest Rate (%) per Payment</td><td><input type="text" name="rate" value="<?php //echo $rate ?>" >-->
<?php
   if (isset($error['rate'])) {
      echo '<p class="error">' .$error['rate'] .'</p>';
   } // if
?>
<!--    </td><td><input type="submit" name="button3" value="calculate Interest" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;width: 100%;"></td>-->
<!--</tr>-->
<!--<tr>-->
<!--    <td>Payment</td><td><input type="text" name="payment" value="<?php //echo $payment ?>" >-->
<?php
   if (isset($error['payment'])) {
      echo '<p class="error">' .$error['payment'] .'</p>';
   } // if
?>
<!--    </td><td><input type="submit" name="button4" value="calculate Payment" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;width: 100%;"></td>-->
<!--</tr>-->
</table>
<br><br>
<!--<p><input type="submit" name="reset" value="Reset" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">&nbsp;&nbsp;&nbsp;<input type="submit" name="button5" value ="Payment Schedule" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;"></p>-->
</form>

<?php
 
   print_schedule($principal, $rate, $payment);
   
?>

 

</div>

<?php

function calc_principal($payno, $int, $pmt)
{
// check that required values have been supplied
if (empty($payno)) {
   echo "<p class='error'>a value for NUMBER of PAYMENTS is required</p>";
   exit;
} // if
if (empty($int)) {
   echo "<p class='error'>a value for INTEREST RATE is required</p>";
   exit;
} // if
if (empty($pmt)) {
   echo "<p class='error'>a value for PAYMENT is required</p>";
   exit;
} // if

// now do the calculation using this formula:

//******************************************
//             ((1 + INT) ** PAYNO) - 1
// PV = PMT * --------------------------
//            INT * ((1 + INT) ** PAYNO)
//******************************************

$int    = $int / 100;        //convert to percentage
$value1 = (pow((1 + $int), $payno)) - 1;
$value2 = $int * pow((1 + $int), $payno);
$pv     = $pmt * ($value1 / $value2);
$pv     = number_format($pv, 2, ".", "");

return $pv;

} // calc_principal ==================================================================

function calc_number($pv, $int, $pmt)
{
// check that required values have been supplied
if (empty($pv)) {
   echo "<p class='error'>a value for PRINCIPAL is required</p>";
   exit;
} // if
if (empty($int)) {
   echo "<p class='error'>a value for INTEREST RATE is required</p>";
   exit;
} // if
if (empty($pmt)) {
   echo "<p class='error'>a value for PAYMENT is required</p>";
   exit;
} // if

// now do the calculation using this formula:

//******************************************
//         log(1 - INT * PV/PMT)
// PAYNO = ---------------------
//             log(1 + INT)
//******************************************

$int    = $int / 100;
$value1 = log(1 - $int * ($pv / $pmt));
$value2 = log(1 + $int);
$payno  = $value1 / $value2;
$payno  = abs($payno);
$payno  = number_format($payno, 0, ".", "");

return $payno;

} // calc_number =====================================================================

function calc_rate($pv, $payno, $pmt)
{
// check that required values have been supplied
if (empty($pv)) {
   echo "<p class='error'>a value for PRINCIPAL is required</p>";
   exit;
} // if
if (empty($payno)) {
   echo "<p class='error'>a value for NUMBER of PAYMENTS is required</p>";
   exit;
} // if
if (empty($pmt)) {
   echo "<p class='error'>a value for PAYMENT is required</p>";
   exit;
} // if

// now try and guess the value using the binary chop technique
$GuessHigh   = (float)100;    // maximum value
$GuessMiddle = (float)2.5;    // first guess
$GuessLow    = (float)0;      // minimum value
$GuessPMT    = (float)0;      // result of test calculation

do {
   // use current value for GuessMiddle as the interest rate,
   // and set level of accurracy to 6 decimal places
   $GuessPMT = (float)calc_payment($pv, $payno, $GuessMiddle, 6);

   if ($GuessPMT > $pmt) {    // guess is too high
      $GuessHigh   = $GuessMiddle;
      $GuessMiddle = $GuessMiddle + $GuessLow;
      $GuessMiddle = $GuessMiddle / 2;
   } // if

   if ($GuessPMT < $pmt) {    // guess is too low
      $GuessLow    = $GuessMiddle;
      $GuessMiddle = $GuessMiddle + $GuessHigh;
      $GuessMiddle = $GuessMiddle / 2;
   } // if

   if ($GuessMiddle == $GuessHigh) break;
   if ($GuessMiddle == $GuessLow) break;

   $int = number_format($GuessMiddle, 9, ".", "");    // round it to 9 decimal places
   if ($int == 0) {
      echo "<p class='error'>Interest rate has reached zero - calculation error</p>";
      exit;
   } // if

} while ($GuessPMT !== $pmt);

return $int;

} // calc_rate =======================================================================

function calc_payment($pv, $payno, $int, $accuracy)
{
// check that required values have been supplied
if (empty($pv)) {
   echo "<p class='error'>a value for PRINCIPAL is required</p>";
   exit;
} // if
if (empty($payno)) {
   echo "<p class='error'>a value for NUMBER of PAYMENTS is required</p>";
   exit;
} // if
if (empty($int)) {
   echo "<p class='error'>a value for INTEREST RATE is required</p>";
   exit;
} // if

// now do the calculation using this formula:

//******************************************
//            INT * ((1 + INT) ** PAYNO)
// PMT = PV * --------------------------
//             ((1 + INT) ** PAYNO) - 1
//******************************************

$int    = $int / 100;    // convert to a percentage
$value1 = $int * pow((1 + $int), $payno);
$value2 = pow((1 + $int), $payno) - 1;
$pmt    = $pv * ($value1 / $value2);
// $accuracy specifies the number of decimal places required in the result
$pmt    = number_format($pmt, $accuracy, ".", "");

return $pmt;

} // calc_payment ====================================================================

function print_schedule($balance, $rate, $payment)
{
// check that required values have been supplied
if (empty($balance)) {
   echo "<p class='error'>a value for PRINCIPAL is required</p>";
   exit;
} // if
if (empty($rate)) {
   echo "<p class='error'>a value for INTEREST RATE is required</p>";
   exit;
} // if
if (empty($payment)) {
   echo "<p class='error'>a value for PAYMENT is required</p>";
   exit;
} // if

echo '<table border="1 solid #ddd" width="100%">';
echo '<colgroup align="right" width="20">';
echo '<colgroup align="right" width="115">';
echo '<colgroup align="right" width="115">';
echo '<colgroup align="right" width="115">';
echo '<colgroup align="right" width="115">';
//echo '<tr style="background-color: #F5E09E;"><th>#</th><th>PAYMENT</th><th>INTEREST</th><th>PRINCIPAL</th><th>BALANCE</th></tr>';

    include 'dbconfig.php';
    $loan_create_id=$_GET['loan_create_id'];
    $installment_plan=$_GET['installment_plan'];
    $payment_date=$_GET['payment_date'];
    $payment_date_weekly = $payment_date;
    
   // mysqli_query($con,"DELETE FROM `tbl_personal_loan_installments` WHERE `loan_create_id` = '$loan_create_id'");
$count = 0;
do {
   $count++;

   // calculate interest on outstanding balance
   $interest = $balance * $rate/100;

   // what portion of payment applies to principal?
   $principal = $payment - $interest;

   // watch out for balance < payment
   if ($balance < $payment) {
      $principal = $balance;
      $payment   = $interest + $principal;
   } // if

   // reduce balance by principal paid
   $balance = $balance - $principal;

   // watch for rounding error that leaves a tiny balance
   if ($balance < 0) {
      $principal = $principal + $balance;
      $interest  = $interest - $balance;
      $balance   = 0;
   } // if







   //echo "<tr>";
   //echo "<td>$count</td>";
   //echo "<td>" .number_format($payment,   2, ".", ",") ."</td>";
   //echo "<td>" .number_format($interest,  2, ".", ",") ."</td>";
   //echo "<td>" .number_format($principal, 2, ".", ",") ."</td>";
   //echo "<td>" .number_format($balance,   2, ".", ",") ."</td>";
   //echo "</tr>";

   // echo "Payment: $payment<br>";
//echo "interest: $interest<br>";
//echo "principal: $principal<br>";
//echo "balance: $balance<br>";

   
     if($installment_plan=='Weekly')
{
$payment_date_weekly= date( "Y-m-d", strtotime( "$payment_date_weekly +7 day" ) );
}

if($installment_plan=='Bi-Weekly')
{
$payment_date_weekly= date( "Y-m-d", strtotime( "$payment_date_weekly +14 day" ) );
}

if($installment_plan=='Monthly')
{
$payment_date_weekly= date( "Y-m-d", strtotime( "$payment_date_weekly +30 day" ) );
}
   
   
   
//   $query_install1  = "INSERT INTO `tbl_personal_loan_installments`(`loan_create_id`, `payment`, `interest`, `principal`, `balance`, `payment_date`) VALUES ('$loan_create_id','$payment','$interest','$principal','$balance','$payment_date_weekly')";
//         $result_install1 = mysqli_query($con, $query_install1);
//         if ($result_install1) {
//             //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
//         } else {
//         echo "<h3> Error Inserting Data tbl_personal_loan_installments</h3>";
//         }
   


   @$totPayment   = $totPayment + $payment;
   @$totInterest  = $totInterest + $interest;
   @$totPrincipal = $totPrincipal + $principal;

   if ($payment < $interest) {
      echo "</table>";
      echo "<p>Payment < Interest amount - rate is too high, or payment is too low</p>";
      exit;
   } // if

} while ($balance > 0);

//echo "<tr>";
//echo "<td>&nbsp;</td>";
//echo "<td><b>" .number_format($totPayment,   2, ".", ",") ."</b></td>";
//echo "<td><b>" .number_format($totInterest,  2, ".", ",") ."</b></td>";
//echo "<td><b>" .number_format($totPrincipal, 2, ".", ",") ."</b></td>";
//echo "<td>&nbsp;</td>";
//echo "</tr>";
echo "</table>";
//echo "<br>";
       ?>
      
<?php

} // print_schedule ==================================================================
?>

  
  
</div>
</div>
