<?php
error_reporting(0);
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';
include_once 'functions.php';

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
     
   
   
   $id_fnd=$_GET['fnd_id'];
   $renew_loan_create_id=$_GET['loan_id'];
$sql_fetch_fnd=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id_fnd'"); 

while($row_fetch_fnd = mysqli_fetch_array($sql_fetch_fnd)) {

$user_fnd_id=$row_fetch_fnd['user_fnd_id'];

$email=$row_fetch_fnd['email'];

$id_photo=$row_fetch_fnd['id_photo'];
// echo "<br><br><br><br><br>".$id_photo;
$bank_front=$row_fetch_fnd['bank_front'];
$bank_back=$row_fetch_fnd['bank_back'];
$void_img=$row_fetch_fnd['void_img'];

$mobile_number=$row_fetch_fnd['mobile_number'];



}


$sql_bank_detail=mysqli_query($con, "select * from loan_initial_banking where user_fnd_id = '$id_fnd'"); 

while($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {
    
    	$type_of_id=$row_bank_detail['type_of_id'];
$id_photo=$row_bank_detail['pic_of_id'];
$type_of_card=$row_bank_detail['type_of_card'];

$card_number=$row_bank_detail['card_number'];
$card_exp_date=$row_bank_detail['card_exp_date'];
$renew_year= str_replace(substr($card_exp_date, 0, 3), '', $card_exp_date);
$renew_month= str_replace(substr($card_exp_date, 2, 3), '', $card_exp_date);
$bank_front=$row_bank_detail['bank_front_pic'];

$bank_back=$row_bank_detail['bank_back_pic'];
$bank_name=$row_bank_detail['bank_name'];
$routing_number=$row_bank_detail['routing_number'];

$account_number=$row_bank_detail['account_number'];
$void_img=$row_bank_detail['void_check_pic'];
$cvv_number=$row_bank_detail['cvv_number'];

}


$sql_fetch_loan=mysqli_query($con, "select * from tbl_loan where user_fnd_id= '$id_fnd'"); 

while($row_fetch_loan = mysqli_fetch_array($sql_fetch_loan)) {

$loan_id=$row_fetch_loan['loan_create_id'];

}
//echo "loan id:".$loan_id;
$fndd_id=$id_fnd;
// echo "loan id:".$fndd_id;

//CUSTOMER EMAIL STARTS

$to_email = $email;
$subject = 'Contract';
$message = 'https://lsbankingportal.com/signature_customer/files/contract.php?id='.$email_key;
$message_email = 'https://lsbankingportal.com/signature_customer/completed/index.php?id='.$email_key;
$headers = 'From: admin@lsfinancing.com';
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
$message_admin = 'https://lsbankingportal.com/signature_customer/completed/index.php?id='.$email_key;
$headers_admin = 'From: admin@lsfinancing.com';
//mail($to_email_admin,$subject_admin,$message_admin,$headers_admin);

admin_leads_email_notification($subject_admin,$message_admin);
//ADMIN EMAIL ENDS



   
   //echo "loan id:".$loan_id;
   //echo "Fnd id:".$fndd_id;
   
if(isset($_POST['btttn-submit'])) 
{
    
$type_id= $_POST['type_id'];
$type_card= $_POST['type_card'];
$card_number= $_POST['card_number'];
//$card_exp_date=$_POST['card_exp_date'];
$bank_name=$_POST['bank_name'];
$routing_number = $_POST['routing_number'];
$account_number = $_POST['account_number'];
$cvv_number = $_POST['cvv_number'];
$expiry_year_card = $_POST['expiry_year_card'];
$expiry_month_card = $_POST['expiry_month_card'];
$card_exp_date = $expiry_year_card. "/".$expiry_month_card;
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


 
    $query_in  = "INSERT INTO loan_initial_banking (loan_id,user_fnd_id,type_of_id,pic_of_id,type_of_card,card_number,card_exp_date,bank_front_pic,bank_back_pic,bank_name,routing_number,account_number,void_check_pic,cvv_number,creation_date,update_date,created_by,email_key,sign_status,update_by)  VALUES ('$loan_id','$fndd_id','$type_id','$final_File','$type_card','$card_number','$card_exp_date','$final_Filee','$final_Fileee','$bank_name','$routing_number','$account_number','$final_Fileeee','$cvv_number','$date','$date','$u_id','$email_key','0','$u_id')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
  
    
    
     
    
    mysqli_query($con, "UPDATE fnd_user_profile SET id_photo ='$final_File', bank_front='$final_Filee', bank_back='$final_Fileee', void_img='$final_Fileeee'  where user_fnd_id ='$fndd_id'"); 
    
?>


<script type="text/javascript">
window.location.href ='customer_email_message.php?emaill=<?php echo $email; ?>&mobile_number=<?php echo $mobile_number;?>&link=<?php echo $message;?>&email_link=<?php echo $message_email;?>&user_fnd_id=<?php echo $id_fnd;?>';
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

  <div class ="container" style="margin-top:100px">

  <div class="row">

  <form action ="" method="POST" enctype="multipart/form-data">
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $renew_month;?>" style="display:none;">
  <h3>User Information</h3>
  <br>
  <div class="row">
      
  <div class="col-lg-6">
      <label for="usr">Type of ID*</label>
      <select name="type_id" id="type_id" class="form-control"  value="" required>
     <option></option>
     <option value="Drivers License" <?php if($type_of_id=='Drivers License'){ echo 'selected';} ?>>Drivers License</option>
      <option value="State Personal ID" <?php if($type_of_id=='State Personal ID'){ echo 'selected';} ?>>State Personal ID</option>
      <option value="Matricula Consular ID" <?php if($type_of_id=='Matricula Consular ID'){ echo 'selected';} ?>>Matricula Consular ID</option>
      <option value="Tribal ID" <?php if($type_of_id=='Tribal ID'){ echo 'selected';} ?>>Tribal ID</option>
      <option value="Passport" <?php if($type_of_id=='Passport'){ echo 'selected';} ?>>Passport</option>
      <option value="Military ID" <?php if($type_of_id=='Military ID'){ echo 'selected';} ?>>Military ID</option>
      <option value="Other" <?php if($type_of_id=='Other'){ echo 'selected';} ?>>Other</option>
     </select>
    </div> 
  
  
 
 
 <?php
 if(empty($id_photo)){
    echo'<div class="col-lg-6">
      <label for="usr">Upload Picture of ID</label>
      <input type="file" name="file_image"  class="form-control" accept="image/*" ><br>
    </div>';
    }
    
    else{
        
        echo'<div class="col-lg-6">
      <label for="usr">Upload Picture of ID</label>
      <input type="text" name="txt_image" style="display:none"  class="form-control" value="';?><?php echo $id_photo;?><?php echo'"> <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/photo_id/'.$id_photo.'" target="_blank"> View Image </a><br>
      <br>
    </div>';
    }
    ?>
    
    
    
    
    <div class="col-lg-6">
      <label for="usr">Type of Card*</label>
      <select name="type_card" id="type_card" class="form-control"  value="" required>
     <option></option>
     <option value="Visa" <?php if($type_of_card=='Visa'){ echo 'selected';} ?>>Visa</option>
      <option value="Master Card" <?php if($type_of_card=='Master Card'){ echo 'selected';} ?>>Master Card</option>
     </select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Number*</label>
      <input type="text" name="card_number"  class="form-control" id="usr" value="<?php echo $card_number;?>" required>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Expiration Date*</label>
      <br>
      Month 
      <select style="width:20%" name="expiry_year_card" id="expiry_year_card" class="form-control"  value="" required>
     <option></option>
     <option value="01" <?php if($renew_month=='01'){ echo 'selected';} ?>>01</option>
     <option value="02" <?php if($renew_month=='02'){ echo 'selected';} ?>>02</option>
     <option value="03" <?php if($renew_month=='03'){ echo 'selected';} ?>>03</option>
     <option value="04" <?php if($renew_month=='04'){ echo 'selected';} ?>>04</option>
     <option value="05" <?php if($renew_month=='05'){ echo 'selected';} ?>>05</option>
     <option value="06" <?php if($renew_month=='06'){ echo 'selected';} ?>>06</option>
     <option value="07" <?php if($renew_month=='07'){ echo 'selected';} ?>>07</option>
     <option value="08" <?php if($renew_month=='08'){ echo 'selected';} ?>>08</option>
     <option value="09" <?php if($renew_month=='09'){ echo 'selected';} ?>>09</option>
     <option value="10" <?php if($renew_month=='10'){ echo 'selected';} ?>>10</option>
     <option value="11" <?php if($renew_month=='11'){ echo 'selected';} ?>>11</option>
     <option value="12" <?php if($renew_month=='12'){ echo 'selected';} ?>>12</option>
     </select>
     
     Year
      <select  style="width:20%" name="expiry_month_card" id="expiry_month_card" class="form-control"  value="" required>
     <option></option>
     <option value="20" <?php if($renew_year=='20'){ echo 'selected';} ?>>20</option>
     <option value="21" <?php if($renew_year=='21'){ echo 'selected';} ?>>21</option>
     <option value="22" <?php if($renew_year=='22'){ echo 'selected';} ?>>22</option>
     <option value="23" <?php if($renew_year=='23'){ echo 'selected';} ?>>23</option>
     <option value="24" <?php if($renew_year=='24'){ echo 'selected';} ?>>24</option>
     <option value="25" <?php if($renew_year=='25'){ echo 'selected';} ?>>25</option>
     <option value="26" <?php if($renew_year=='26'){ echo 'selected';} ?>>26</option>
     <option value="27" <?php if($renew_year=='27'){ echo 'selected';} ?>>27</option>
     <option value="28" <?php if($renew_year=='28'){ echo 'selected';} ?>>28</option>
     <option value="29" <?php if($renew_year=='29'){ echo 'selected';} ?>>29</option>
     <option value="30" <?php if($renew_year=='30'){ echo 'selected';} ?>>30</option>
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
      <a href ="/ls_software/dl_client_files/bank_front_image/'.$bank_front.'" target="_blank"> View Image </a><br>
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
      <label for="usr">Bank Name*</label>
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
      <label for="usr">Routing Number*</label>
      <input type="text" name="routing_number"  class="form-control" id="usr" value="<?php echo $routing_number;?>" required>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Account Number*</label>
      <input type="text" name="account_number"  class="form-control" id="usr" value="<?php echo $account_number;?>" required>
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
      <label for="usr">CVV Number*</label>
      <input type="text" name="cvv_number"  class="form-control" id="usr" value="<?php echo $cvv_number;?>" required>
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
