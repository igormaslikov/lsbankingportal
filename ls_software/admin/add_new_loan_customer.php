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

include 'functions.php';

function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
      $user_key = generateRandomString();;
     // echo $user_key;
     

if(isset($_POST['btn-submit'])) 
{
    
$first_name= $_POST['first_name'];
//$middle_name= $_POST['middle_name'];
$last_name= $_POST['last_name'];
$phone_number=$_POST['phone_number'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$state = $_POST['state'];
$monthly_income = $_POST['monthly_income'];
$payment = $_POST['payment'];
$address = $_POST['address'];
$dob = $_POST['dob'];
$ssn = $_POST['ssn'];
//$picture = $_POST['image'];

$income_month=$_POST['income_month'];
$employer_name = $_POST['employer_name'];
$work_phone = $_POST['work_phone'];
$working = $_POST['working'];
$get_paid = $_POST['get_paid'];
$last_check = $_POST['last_check'];
$next_check = $_POST['next_check'];
//$pdf_file = $_POST['pdf_file'];
$card_number = $_POST['card_number'];
$exp_date = $_POST['exp_date'];
$name_on_Card = $_POST['name_on_Card'];
$zip_code = $_POST['zip_code'];
$cvv_number = $_POST['cvv_number'];
$acc_number = $_POST['acc_number'];

$application_status=$_POST['app_status'];
$source_of_lead=$_POST['source_of_lead'];
$decline_reason=$_POST['decline_reason'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

$date = date('Y-m-d H:i:s');

        $imgFile = $_FILES['imagee']['name'];
        $tmp_dir = $_FILES['imagee']['tmp_name'];
        $imgSize = $_FILES['imagee']['size'];
        
         $imgFilee = $_FILES['imageee']['name'];
        $tmp_dirr = $_FILES['imageee']['tmp_name'];
        $imgSizee = $_FILES['imageee']['size'];
        
        
      if($password!=$confirm_password)
{
     echo "Password does't match! Enter Correct Password";
}

            $upload_dir = 'user_id_front_images/'; // upload directory
    
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;
                
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
            
     // Backe ID Card Image Start
     
             $upload_dirr = 'user_id_back_images/'; // upload directory
    
            $imgExtt = strtolower(pathinfo($imgFilee,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpicc = rand(1000,1000000).".".$imgExtt;
                
            // allow valid image file formats
            if(in_array($imgExtt, $valid_extensionss)){            
                // Check file size '5MB'
                if($imgSizee < 5000000)                {
                    move_uploaded_file($tmp_dirr,$upload_dirr.$userpicc);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
     
     
     // Back ID Card Image End
       
        // PDF To Folder Start
     
          
 $targetfolder = "pdf_files/";

 $targetfolder = $targetfolder . basename( $_FILES['pdf_file']['name']) ;

 $ok=1;

$file_type=$_FILES['pdf_file']['type'];

if ($file_type=="application/pdf") {

 if(move_uploaded_file($_FILES['pdf_file']['tmp_name'], $targetfolder))

 {

 echo "The file ". basename( $_FILES['pdf_file']['name']). " is uploaded";

 }

 else {

 echo "Problem uploading file";

 }

}

else {

 // echo "You may only upload PDFs files.<br>";

}

     // PDF To Folder End
     
     $form_name=basename(__FILE__);

    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


    while($row_role = mysqli_fetch_array($sql_role)) {

    $form_id=$row_role['id'];
 
}  
     
     user_roles($u_access_id,$form_id);
     
  
           
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,password,address,zip_code,date_of_birth,ssn,created_by,creation_date,user_key,application_status,source_of_lead,declined_reason)  VALUES ('$first_name','$last_name','$email','$phone_number','$hashed_password','$address','$zip_code','$dob','$ssn','$u_id','$date','$user_key','$application_status','$source_of_lead','$decline_reason')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
      
    
//$created_by= $userRow['user_id'];
$query_userid = mysqli_query($con,"Select * from fnd_user_profile where user_key = '$user_key'");
while ($row_user_id=mysqli_fetch_array($query_userid)){
    $user_id = $row_user_id[0];
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$user_id;

}

$query3  = "INSERT INTO source_income (user_fnd_id,employer_name,work_phone_no,pay_period,last_pay_date,next_pay_date,monthly_income,created_by,start_date,creation_date)  VALUES ('$user_id','$employer_name','$work_phone','$get_paid','$last_check','$next_check','$income_month','$u_id','$working','$date')";
        $result3 = mysqli_query($con, $query3);
        if ($result3) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
        
    $query3  = "INSERT INTO binary_questions (user_fnd_id,bq_answer,created_by,creation_date)  VALUES ('$user_id','$payment','$u_id','$date')";
        $result3 = mysqli_query($con, $query3);
        if ($result3) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }  
?>


<script type="text/javascript">
window.location.href = 'view_all_customer.php';
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

<?php include('menu.php') ;?>

    
  <div class ="container wrapper" style="margin-top:100px">

  <div class="row wrapper">

  <form action ="" method="POST" enctype="multipart/form-data">
  
  <h3>User Information</h3>
  <div class="row">
      
  <div class="col-lg-6" >
      <label for="usr">First Name</label>
      <input name="first_name" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
  
  <div class="col-lg-4" style="display:none;">
      <label for="usr">Middle Name</label>
      <input name="middle_name" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>

    <div class="col-lg-6">
      <label for="usr">Last Name</label>
      <input name="last_name" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone Number</label>
      <input name="phone_number" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Email</label>
      <input name="email" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Password</label>
      <input name="password" type="password" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Confirm Password</label>
      <input name="confirm_password" type="password" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    </div>
     
     <h3>Personal  Information</h3>
    <div class="row">
    <div class="col-lg-4">
      <label for="usr">DOB</label>
      <input type="date" name="dob"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">SSN/ITIN</label>
      <input type="text" name="ssn"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Upload Front Picture of ID</label>
      <input type="file" name="imagee"  class="form-control" accept="image/*">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Upload Back Picture of ID</label>
      <input type="file" name="imageee"  class="form-control" accept="image/*">
    </div>
    <div class="col-lg-6">
      <label for="usr">Address</label>
      <textarea type="text" name="address"  class="form-control" id="usr"></textarea>
    </div>
    </div>
    
    
    <h3>Pre Qualification</h3>
    <div class="row">
       
    <div class="col-lg-6">
      <label for="usr">Monthly income? </label>
<input name="income_month" type="number" class="form-control"  id="usr" placeholder="" value="">

    </div>
    
    <div class="col-lg-6">
      <label for="usr"> Mode of Payment</label>
<select name="payment" id="payment" class="form-control"  value="">
<option value="Direct Deposit">Direct Deposit</option>
<option value="Check">Check</option>
<option value="Cash">Cash</option>
<option value="Military">Military</option>
<option value="Disability/Workers Compensation">Disability/Workers Compensation</option>

</select>
    </div>
    
    </div>
    
    
    
    <h3>Employment Info</h3>
    <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Employer Name</label>
 <input type="text" name="employer_name"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Work Phone Number</label>
 <input type="text" name="work_phone"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">When Did You Begin Working There?</label>
 <input type="date" name="working"  class="form-control" id="usr">
    </div>

<div class="col-lg-4">
      <label for="usr">How often do you get paid?</label>
 <select name="get_paid" id="get_paid" class="form-control"  value="">
<option value="Weekly">Weekly</option>
<option value="Bi-Weekly">Bi-Weekly</option>
<option value="Semi Monthly">Semi Monthly</option>
<option value="Monthly">Monthly</option>

</select>

    </div>

<div class="col-lg-4">
      <label for="usr">Last Paycheck Date</label>
 <input type="date" name="last_check"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Next Paycheck Date</label>
 <input type="date" name="next_check"  class="form-control" id="usr">
    </div>

    </div>
     <h3>Sign Contract</h3>
    <div class="row">

 
     <div class="form-col-lg-12">
      <label for="usr">PDF File</label>
      <input type="file" name="pdf_file"  class="form-control" id="usr" accept="application/pdf">
    </div>
    
    </div>
    <h3 style="display:none;">Get Fund</h3>
      <div class="row" style="display:none;">
 
    
         <div class="col-lg-4">
      <label for="usr">Card Number</label>
      <input type="text" name="card_number"  class="form-control" id="usr">
    </div>
    
     <div class="col-lg-4">
      <label for="usr"> Exp Date</label>
      <input type="date" name="exp_date"  class="form-control" id="usr">
    </div>
   
    <div class="col-lg-4">
      <label for="usr">Name on card</label>
      <input type="text" name="name_on_Card"  class="form-control" id="usr">
    </div>

  <div class="col-lg-4">
      <label for="usr"> Account Number </label>
      <input type="number" name="acc_number"  class="form-control" id="usr">
    </div>

    <div class="col-lg-4">
      <label for="usr"> ZIP Code </label>
      <input type="number" name="zip_code"  class="form-control" id="usr">
    </div>

     <div class="col-lg-4">
      <label for="usr"> CVV Number </label>
      <input type="number" name="cvv_number"  class="form-control" id="usr">
    </div>
    
    </div>
   
    <h3 style="color:red">Application Status</h3>
    <div class="row">
    <div class="col-lg-6">
      <label for="usr"> Any Application Status</label>
<select name="app_status" id="app_status" class="form-control"  value="">
<option value="New Application">New Application</option>
<option value="Initial Review">Initial Review</option>
<option value="Pre-Approved">Pre-Approved</option>
<option value="Final Review">Final Review</option>
<option value="Approved">Approved</option>
<option value="Funded">Funded</option>
<option value="Declined">Declined</option>

</select>
    </div>
    
      <div class="col-lg-6">
      <label for="usr"> Source of Lead</label>
<select name="source_of_lead" id="source_of_lead" class="form-control"  value="">
<option value="Facebook">Facebook</option>
<option value="Google">Google</option>
<option value="Instagram">Instagram</option>
<option value="Banner">Banner</option>
<option value="Radio">Radio</option>
<option value="Referred by Customer">Referred by Customer</option>
<option value="Repeat Customer">Repeat Customer</option>

</select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr"> Declined Reason</label>
<select name="decline_reason" id="decline_reason" class="form-control"  value="">
<option value="No Credit">No Credit</option>
<option value="Bad Credit">Bad Credit</option>
<option value="Too Many Loans">Too Many Loans</option>
<option value="Too Many NSF Fees">Too Many NSF Fees</option>
<option value="Repeat Application">Repeat Application</option>
<option value="Declined by Customer">Declined by Customer</option>
<option value="Incomplete Paperwork">Incomplete Paperwork</option>
<option value="No Answer">No Answer</option>

</select>
    </div>
    
    </div>

    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add this Customer</button>
  </form>
  
</div>
</div>

<hr>

</body>
</html>     
<?php
}
?>