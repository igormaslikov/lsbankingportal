<?php
date_default_timezone_set('America/Los_Angeles');
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
//$password = $_POST['password'];
//$confirm_password = $_POST['confirm_password'];
//$state = $_POST['state'];
$monthly_income = $_POST['monthly_income'];
$payment = $_POST['payment'];
$customer_street_num = $_POST['street_number'];
$customer_cardinal = $_POST['cardinal_point'];
$customer_street_name = $_POST['street_name'];
$street_type = $_POST['street_type'];
$customer_unit = $_POST['apartment'];

$address = $customer_street_num .' '. $customer_cardinal .' '. $customer_street_name .' '. $street_type .' '. $customer_unit;

$city=$_POST['city'];
$state=$_POST['state'];
$zip=$_POST['zip'];

$dob = $_POST['dob'];
$ssn = $_POST['ssn'];
$loan_type = $_POST['loan_type'];
$time_created = date("g:i a");

//$income_month=$_POST['income_month'];
$employer_name = $_POST['employer_name'];
$work_phone = $_POST['work_phone'];
$net_amount = $_POST['net_amount'];
$direct_deposit=$_POST['direct_deposit_source'];
$get_paid = $_POST['get_paid'];
$last_check = $_POST['last_check'];
$next_check = $_POST['next_check'];
//$pdf_file = $_POST['pdf_file'];
$card_number = $_POST['card_number'];
$exp_date = $_POST['exp_date'];
$name_on_Card = $_POST['name_on_Card'];
//$zip_code = $_POST['zip_code'];
$cvv_number = $_POST['cvv_number'];
$acc_number = $_POST['acc_number'];

$application_status=$_POST['app_status'];
$source_of_lead=$_POST['source_of_lead'];
$decline_reason=$_POST['decline_reason'];

$application_notes=$_POST['notes'];
$to_date_filter = date('Y-m-d');
$date_duplicate= date('Y-m-d', strtotime('-7 day'));
//$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

$date = date('Y-m-d H:i:s');


$form_name=basename(__FILE__);

    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


    while($row_role = mysqli_fetch_array($sql_role)) {

    $form_id=$row_role['id'];
 
}  
     
     user_roles($u_access_id,$form_id);
     

$sql_fnd=mysqli_query($con, "select * from fnd_user_profile where email = '$email' AND mobile_number = '$phone_number'"); 

            while($row_fnd_id = mysqli_fetch_array($sql_fnd)) {
            $user_fnd_iddd = $row_fnd_id['user_fnd_id'];
            $creation_date = $row_fnd_id['application_date'];
            $application_status = $row_fnd_id['application_status'];
            }
            
          $rowcount_funded=mysqli_num_rows($sql_fnd);  
          
     if($rowcount_funded>0){
         
if ($creation_date<$date_duplicate){
mysqli_query($con, "UPDATE fnd_user_profile SET application_status='New Application', application_date='$to_date_filter', loan_type='$loan_type' where user_fnd_id ='$user_fnd_iddd'");
$query_fnd_id  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_iddd')";
        $result_fnd = mysqli_query($con, $query_fnd_id);
        if ($result_fnd) {
            echo "<div class='form'><h3> Duplicated successfully added.</h3><br/></div>";
        } else {
        echo "<h3>Error Inserting Data</h3>";
        } 
    
    //********************************* ADMIN EMAIL ******************************************************




// subject
$subject_data = 'Already Customer Applied Again';

// message
$message_data = '
  First Name: '.$first_name.' 
  Last Name: '.$last_name.' 
  
  Phone Number: '.$phone_number.' 
  Email: '.$email.' 
  Date of Birth: '.$dob.' 
  Address: '.$address.'
  City: '.$city.' 
  State: '.$state.' 
  Zip: '.$zip.' 
  Employer Name: '.$employer_name.' 
  
  Employer Phone: '.$work_phone.' 
  Net Amount of Salary (in $ s): '.$net_amount.' 
  Direct Deposit: '.$direct_deposit.' 
  Payment Frequency: '.$get_paid.' 
  Last Paycheck: '.$last_check.' 
  Next Paycheck: '.$next_check.' 

';



// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


//mail($to,$subject_data,$message_data,$headers);

admin_leads_email_notification($subject_data,$message_data);





//**************************************** END ***************************************************************************************
    
    
   
    
//	echo '<meta http-equiv="Refresh" content="1; url=https://www.ofsca.com/payday-loans/">';
}

else if($application_status!='New Application') {
    
	$to_email_de = $email;
$subject_de = 'Application Declined';
  $fname=$first_name;
  $lname= $last_name;
  $message_de = "Hola ".$fname." ".$lname.", 

Thank you for submitting your application to Optima. Unfortunately your application has been declined. May be you have already pending application or your application has been rejected in last 7 days. If you have any questions regarding your application, contact us at support@mymoneyline.com and a team member will respond shortly.";
 
$headers = 'From: support@mymoneyline.com';
// mail($to_email,$subject,$message,$headers);

	send_email_notification($to_email_de,$subject_de,$message_de);
	
	//declined email end
	
	//Decline SMS
	
	$phone= $phone_number;
  $fname=$first_name;
  $lname= $last_name;
  $message = "Hola ".$fname." ".$lname.",Gracias por aplicar con Optima Financial Solutions Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
  
send_sms($phone,$message);	
	//Decline SMS End
}

}
          
          
else {
    
    //duplicate applications check end
    
	echo "record does not exists";
$to_email_re = $email;
$subject_re = 'Application Received';
$fname=$first_name;
  $lname= $last_name;
  $message_re = "Hello ".$fname." ".$lname.", 
Thank you for applying at Optima. We received your application. A team member will contact you shortly. 
Gracias por aplicar en Optima. Recibimos su solicitud. Un miembro del equipo se comunicará con usted a la brevedad.
If you have any questions you can always contact us at support@mymoneyline.com";
 
$headers = 'From: support@mymoneyline.com';
//mail($to_email,$subject,$message,$headers);

send_email_notification($to_email_re,$subject_re,$message_re);

//********************************* ADMIN EMAIL ******************************************************




$to  = 'asimmaqbool195@gmail.com'; 

// subject
$subject_data = 'Application Received';

// message
$message_data = '
  First Name: '.$first_name.' 
  Last Name: '.$last_name.' 
  
  Phone Number: '.$phone_number.' 
  Email: '.$email.' 
  Date of Birth: '.$dob.' 
  Address: '.$address.' 
  City: '.$city.' 
  State: '.$state.' 
  Zip: '.$zip.' 
  Employer Name: '.$employer_name.' 
  
  Employer Phone: '.$work_phone.' 
  Net Amount of Salary (in $ s): '.$net_amount.' 
  Direct Deposit: '.$direct_deposit.' 
  Payment Frequency: '.$get_paid.' 
  Last Paycheck: '.$last_check.' 
  Next Paycheck: '.$next_check.' 

';



// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


//mail($to, $subject_data, $message_data, $headers);

admin_leads_email_notification($subject_data,$message_data);          
          
          
           
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,ssn,created_by,creation_date,user_key,application_status,website,created_time_,source_of_lead,declined_reason,loan_type)  VALUES ('$first_name','$last_name','$email','$phone_number','$address','$city','$state','$zip','$dob','$ssn','$u_id','$date','$user_key','New Application','By Office','$time_created','$source_of_lead','$decline_reason','$loan_type')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data FND </h3>";
        }
        
        
        $sql_fnd_11=mysqli_query($con, "select * from fnd_user_profile where email = '$email'"); 

while($row_fnd_id = mysqli_fetch_array($sql_fnd_11)) {
$user_fnd_iddd = $row_fnd_id['user_fnd_id'];

}

$query_fnd_id  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_iddd')";
        $result_fnd = mysqli_query($con, $query_fnd_id);
        if ($result_fnd) {
            echo "<div class='form'><h3> New successfully added.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data tbl_loan </h3>";
        }
        
      
//$created_by= $userRow['user_id'];
$query_userid = mysqli_query($con,"Select * from fnd_user_profile where user_key = '$user_key'");
while ($row_user_id=mysqli_fetch_array($query_userid)){
    $user_id = $row_user_id[0];
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$user_id;

}

$query3  = "INSERT INTO source_income (user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date,created_by,creation_date)  VALUES ('$user_id','$employer_name','$work_phone','$net_amount','$direct_deposit','$get_paid','$last_check','$next_check','$u_id','$date')";
        $result3 = mysqli_query($con, $query3);
        if ($result3) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data source_income </h3>";
        }
        
    $query3  = "INSERT INTO binary_questions (user_fnd_id,bq_answer,created_by,creation_date)  VALUES ('$user_id','$payment','$u_id','$date')";
        $result3 = mysqli_query($con, $query3);
        if ($result3) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data binary_questions</h3>";
        }  
        
         $query34  = "INSERT INTO application_notes (user_fnd_id,app_notes,created_by,creation_date)  VALUES ('$user_id','$application_notes','$u_id','$date')";
        $result34 = mysqli_query($con, $query34);
        if ($result34) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data application_notes</h3>";
        } 
        
}
        
?>

<script type="text/javascript">
window.location.href = 'view_all_customer_main.php';
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
  
  <h3 style="color:red;">Personal  Information</h3>
  <div class="row">
      
  <div class="col-lg-6" >
      <label for="usr">First Name</label>
      <input name="first_name" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>

    <div class="col-lg-6">
      <label for="usr">Last Name</label>
      <input name="last_name" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone Number</label>
      <input name="phone_number" type="tel" class="form-control"  id="usr" placeholder="Format:123-456-7890" value="" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Email</label>
      <input name="email" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
   
    
    <div class="col-lg-6">
      <label for="usr">SSN/ITIN</label>
      <input type="text" name="ssn"  class="form-control" id="usr">
    </div>

 <div class="col-lg-6">
      <label for="usr">DOB</label>
      <input type="date" name="dob"  class="form-control" id="usr">
    </div>
   
    <div class="col-lg-6">
      <label for="usr">Street Number</label>
      <input type="text" name="street_number"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Cardinal / Pre Point</label>
     <select name="cardinal_point" id="payment" class="form-control"  value="">
<option value=""></option>
<option value="N">N</option>
<option value="S">S</option>
<option value="AND">AND</option>
<option value="W">W</option>
<option value="NE">NE</option>
<option value="NW">NW</option>
<option value="I KNOW">I KNOW</option>
<option value="SW">SW</option>

</select>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr">Street Name</label>
       <input type="text" name="street_name"  class="form-control" id="usr">
    </div>
     
    <div class="col-lg-6">
      <label for="usr">Street Type</label>
     <select name="street_type" id="payment" class="form-control"  value="">
<option value=""></option>
<option value="Ave">Ave</option>
<option value="Bird">Bird</option>
<option value="Blv">Blv</option>
<option value="Cir">Cir</option>
<option value="Ct">Ct</option>
<option value="Dr">Dr</option>
<option value="Frwy">Frwy</option>
<option value="Hwy">Hwy</option>
<option value="Ln">Ln</option>
<option value="Parkway">Parkway</option>
<option value="Pike">Pike</option>
<option value="Place">Place</option>
<option value="Rd">Rd</option>
<option value="Ridge">Ridge</option>
<option value="St">St</option>
<option value="Tarrace">Tarrace</option>
<option value="Trail">Trail</option>
<option value="Turnpike">Turnpike</option>
<option value="Way">Way</option>

</select>
    </div>
    
    
      <div class="col-lg-6">
      <label for="usr">Apartment / Unit</label>
      <input type="text" name="apartment"  class="form-control" id="usr">
    </div>
     
    
     <div class="col-lg-3">
      <label for="usr">City</label>
      <input type="text" name="city"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-1">
      <label for="usr">State</label>
      <select name="state" id="state" class="form-control"  value="">
<option value=""></option>
<option value="CA">CA</option>


</select>
    </div>
    
    <div class="col-lg-2">
      <label for="usr">Zip Code</label>
      <input type="text" name="zip"  class="form-control" id="usr">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Loan Type / Type of Loan</label>
<select name="loan_type" id="loan_type" class="form-control"  value="">
<option value=""></option>
<option value="payday">Payday Laon</option>
<option value="installment">Personal Laon</option>
<option value="commercial">Commercial Laon</option>
<option value="Loan Staff">Loan Staff</option>

</select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Direct Deposit</label>
<select name="direct_deposit" id="direct_deposit" class="form-control"  value="">
<option value=""></option>
<option value="Yes">Yes</option>
<option value="No">No</option>

</select>
    </div>
    
    </div>
    
    <h3 style="color:red;">Employment Info</h3>
    <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Employer Name*</label>
 <input type="text" name="employer_name"  class="form-control" id="usr" >
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Work Phone Number*</label>
 <input type="tel" name="work_phone"  class="form-control" id="usr" placeholder="Format:123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" >
    </div>
    
     <div class="col-lg-4">
      <label for="usr">Net Check Amount*</label>
 <input type="text" name="net_amount"  class="form-control" id="usr" placeholder="" >
    </div>

 <div class="col-lg-4">
      <label for="usr">Direct Deposit*</label>
<select name="direct_deposit_source" id="payment" class="form-control"  value="" >
<option value=""></option>
<option value="Yes">Yes</option>
<option value="No">No</option>

</select>
    </div>
    
<div class="col-lg-4">
      <label for="usr">How often do you get paid?*</label>
 <select name="get_paid" id="get_paid" class="form-control"  value="" >
<option value=""></option>
<option value="Weekly">Weekly</option>
<option value="Bi-Weekly">Bi-Weekly</option>
<option value="Semi Monthly">Semi Monthly</option>
<option value="Monthly">Monthly</option>

</select>

    </div>

<div class="col-lg-4">
      <label for="usr">Last Paycheck Date*</label>
 <input type="date" name="last_check"  class="form-control" id="usr" >
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Next Paycheck Date*</label>
 <input type="date" name="next_check"  class="form-control" id="usr" >
    </div>

    </div>

    <h3 style="color:red">Application Status</h3>
    <div class="row">
    <div class="col-lg-6">
<label for="usr"> Any Application Status</label>
<select name="app_status" id="app_status" class="form-control"  value="">
<option ></option>
<option value="All Application">All Application</option>
<option value="New Application">New Application</option>
<option value="In Review">In Review</option>
<option value="Info Needed">Info Needed</option>
<option value="Approved">Approved</option>
<option value="Funded">Funded</option>
<option value="Declined">Declined</option>

</select>
    </div>
    
      <div class="col-lg-6">
      <label for="usr"> Source of Lead</label>
<select name="source_of_lead" id="source_of_lead" class="form-control"  value="">
    <option value=""></option>
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
    <option value=""></option>
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

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Notes</label>
      <textarea type="text" name="notes"  class="form-control" id="usr" style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"></textarea>
    </div>
</div>

    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Add this Customer</button>

 
  </form>
  
  <div class="row">
  
  <div class="col-lg-4">
</div>
 <div class="col-lg-4">
<button name="sas" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;"><a href="view_all_customer.php?status=All&keyword=&from_date=&to_date=&search=&website=All"  style="color:white; font-size:20px">Go Back</a></button>
</div>
 <div class="col-lg-4">
</div>
 </div> 
  
</div>
</div>

    


<hr>

</body>
</html>     
<?php
}
?>