<?php
date_default_timezone_set('America/Los_Angeles');
session_start();
error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
// $exp_date = $_POST['exp_date'];
// $name_on_Card = $_POST['name_on_Card'];
//$zip_code = $_POST['zip_code'];
// $cvv_number = $_POST['cvv_number'];
// $acc_number = $_POST['acc_number'];

$application_status=$_POST['app_status'];
$source_of_lead=$_POST['source_of_lead'];
$decline_reason=$_POST['decline_reason'];
$application_date=$_POST['application_date'];

$application_notes=$_POST['notes'];
$to_date_filter = date('Y-m-d');
$date_duplicate= date('Y-m-d', strtotime('-7 day'));
//$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

$business_type_update = $_POST['business_type'];
$business_create_update = $_POST['business_create'];
$business_name_update = $_POST['business_name'];
$business_phone_update = $_POST['business_phone'];
$business_address_update = $_POST['business_address'];
$business_state_update = $_POST['business_state'];
$business_city_update = $_POST['business_city'];
$business_zip_update = $_POST['business_zip'];
$gross_amount_update = $_POST['gross_amount'];
$business_direct_deposit_update = $_POST['business_direct_deposit'];
$business_get_paid_update = $_POST['business_get_paid'];
$business_docs_update = $_POST['business_docs'];


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

Thank you for submitting your application to Optima Financial Solutions Inc. Unfortunately your application has been declined. May be you have already pending application or your application has been rejected in last 7 days. If you have any questions regarding your application, contact us at support@ofsca.com and a team member will respond shortly.";
 
$headers = 'From: support@ofsca.com';
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
  $message_re = "Hello ".$fname." ".$lname."

Thank you for applying at Optima Financial Solutions Inc. We received your application. A team member will contact you shortly.

If you have any questions you can always contact us at support@ofsca.com

Hola ".$fname." ".$lname."

Gracias por aplicar en Optima Financial Solutions Inc. Recibimos su solicitud. Un miembro del equipo se comunicará con usted breve.

Si tiene alguna pregunta, usted siempre puede contactarnos a support@ofsca.com

Optima Financial Solutions.
";
 
$headers = 'From: support@ofsca.com';
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
          
          
           
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,ssn,created_by,creation_date,user_key,application_status,website,created_time_,source_of_lead,declined_reason,loan_type, application_date)  VALUES ('$first_name','$last_name','$email','$phone_number','$address','$city','$state','$zip','$dob','$ssn','$u_id','$date','$user_key','New Application','By Office','$time_created','$source_of_lead','$decline_reason','$loan_type','$application_date')";
        // echo $query;
        $result = mysqli_query($con, $query);
        // echo $result;
        // exit();
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

$query3  = "INSERT INTO source_income (user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date,created_by,creation_date,business_type,business_create)  VALUES ('$user_id','$employer_name','$work_phone','$net_amount','$direct_deposit','$get_paid','$last_check','$next_check','$u_id','$date','$business_type_update', '$business_create_update')";
        $result3 = mysqli_query($con, $query3);
        if ($result3) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data source_income </h3>";
        }


        $query_business  = "INSERT INTO tbl_business_info (user_fnd_id,business_name,business_phone,business_address,business_city,business_state,business_zip,monthly_gross_amount,direct_deposit,how_paid,business_docs,created_by,created_at)  VALUES ('$user_id','$business_name_update','$business_phone_update','$business_address_update','$business_city_update','$business_state_update','$business_zip_update','$gross_amount_update','$business_direct_deposit_update','$business_get_paid_update','$business_docs_update','$u_id','$date')";
        $result_business = mysqli_query($con, $query_business);
        if ($result_business) {
          //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
          echo "<h3> Error Inserting Business Data </h3>";
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
    <title>Add New Customer</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style>
        /* Clear the fixed/sticky menu.php navbar — matches the old inline margin-top:100px */
        section.wrapper.anc-wrapper { padding: 20px 20px 40px; max-width: 1330px; margin: 100px auto 80px auto; }

        .anc-toolbar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #eee;
        }
        .anc-page-title { font-size: 22px; font-weight: 600; color: #333; margin: 0; }

        .anc-panel { margin-bottom: 14px; }
        .anc-panel .panel-heading { padding: 10px 15px; background-color: #fafafa; font-weight: 600; }
        .anc-panel .panel-heading .anc-section-hint { font-size: 12px; color: #888; font-weight: normal; text-transform: uppercase; letter-spacing: .5px; }
        .anc-required-hint { font-size: 11px; color: #888; font-weight: normal; }
        .anc-panel .panel-body { padding: 16px; }

        .anc-field { margin-bottom: 14px; }
        .anc-field label {
            font-size: 12px; color: #555; font-weight: 600;
            text-transform: uppercase; letter-spacing: .3px; margin-bottom: 4px;
        }
        .anc-req { color: #d9534f; margin-left: 2px; }
        .anc-help { font-size: 11px; color: #888; margin-top: 4px; display: block; }

        .anc-action-bar {
            margin-top: 18px; padding: 15px 20px; background-color: #fafafa;
            border: 1px solid #eee; border-radius: 4px; text-align: right;
        }
        .anc-action-bar .btn { margin-left: 6px; }

        .anc-hidden { display: none; }

        section.wrapper.anc-wrapper .row,
        section.wrapper.anc-wrapper .row:hover {
            background-color: transparent !important;
            height: auto !important;
            border-top: 0 !important;
            transition: none !important;
        }
    </style>
</head>

<body>

<?php include('menu.php'); ?>

<section class="wrapper anc-wrapper">

    <div class="anc-toolbar">
        <h3 class="anc-page-title">
            <span class="glyphicon glyphicon-user"></span> Add New Customer
        </h3>
        <a href="view_all_customer_main.php" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span> Back to customers
        </a>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" id="anc-form">

        <div class="panel panel-default anc-panel">
            <div class="panel-heading">
                Personal Information
                <span class="anc-required-hint pull-right"><span class="anc-req">*</span> required</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 anc-field">
                        <label>First Name <span class="anc-req">*</span></label>
                        <input name="first_name" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Last Name <span class="anc-req">*</span></label>
                        <input name="last_name" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Phone Number <span class="anc-req">*</span></label>
                        <input name="phone_number" type="tel" class="form-control" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                    </div>

                    <div class="col-md-4 anc-field">
                        <label>Email <span class="anc-req">*</span></label>
                        <input name="email" type="email" class="form-control" placeholder="customer@example.com" required>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>SSN / ITIN</label>
                        <input type="text" name="ssn" class="form-control" placeholder="123-45-6789 or 9 digits">
                        <span class="anc-help">Stored as entered. 9 digits or XXX-XX-XXXX.</span>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default anc-panel">
            <div class="panel-heading">Address</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2 anc-field">
                        <label>Street Number</label>
                        <input type="text" name="street_number" class="form-control">
                    </div>
                    <div class="col-md-2 anc-field">
                        <label>Cardinal</label>
                        <select name="cardinal_point" class="form-control">
                            <option value=""></option>
                            <option value="N">N</option>
                            <option value="S">S</option>
                            <option value="E">E</option>
                            <option value="W">W</option>
                            <option value="NE">NE</option>
                            <option value="NW">NW</option>
                            <option value="SE">SE</option>
                            <option value="SW">SW</option>
                        </select>
                        <span class="anc-help">Pre-directional (if any).</span>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Street Name</label>
                        <input type="text" name="street_name" class="form-control">
                    </div>
                    <div class="col-md-2 anc-field">
                        <label>Street Type</label>
                        <select name="street_type" class="form-control">
                            <option value=""></option>
                            <option value="Ave">Ave</option>
                            <option value="Blvd">Blvd</option>
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
                            <option value="Terrace">Terrace</option>
                            <option value="Trail">Trail</option>
                            <option value="Turnpike">Turnpike</option>
                            <option value="Way">Way</option>
                        </select>
                    </div>
                    <div class="col-md-2 anc-field">
                        <label>Apt / Unit</label>
                        <input type="text" name="apartment" class="form-control">
                    </div>

                    <div class="col-md-5 anc-field">
                        <label>City</label>
                        <input type="text" name="city" class="form-control">
                    </div>
                    <div class="col-md-3 anc-field">
                        <label>State</label>
                        <select name="state" class="form-control">
                            <option value=""></option>
                            <option value="CA">California</option>
                        </select>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Zip Code</label>
                        <input type="text" name="zip" class="form-control" pattern="[0-9]{5}(-[0-9]{4})?" placeholder="12345 or 12345-6789">
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default anc-panel">
            <div class="panel-heading">Loan Type</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 anc-field">
                        <label>Loan Type <span class="anc-req">*</span></label>
                        <select name="loan_type" id="anc-loan-type" class="form-control" required>
                            <option value=""></option>
                            <option value="payday">Payday Loan</option>
                            <option value="installment">Personal Loan</option>
                            <option value="commercial">Commercial Loan</option>
                            <option value="Loan Staff">Loan Staff</option>
                        </select>
                    </div>
                    <div class="col-md-6 anc-field">
                        <label>Primary Direct Deposit</label>
                        <select name="direct_deposit" class="form-control">
                            <option value=""></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <span class="anc-help">Used for the initial application flag.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default anc-panel">
            <div class="panel-heading">Employment Information</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 anc-field">
                        <label>Employer Name</label>
                        <input type="text" name="employer_name" class="form-control">
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Work Phone</label>
                        <input type="tel" name="work_phone" class="form-control" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Net Check Amount</label>
                        <input type="text" name="net_amount" class="form-control" placeholder="e.g. 1250.00">
                    </div>

                    <div class="col-md-4 anc-field">
                        <label>Direct Deposit (Employment)</label>
                        <select name="direct_deposit_source" class="form-control">
                            <option value=""></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Pay Frequency</label>
                        <select name="get_paid" class="form-control">
                            <option value=""></option>
                            <option value="Weekly">Weekly</option>
                            <option value="Bi-Weekly">Bi-Weekly</option>
                            <option value="Semi Monthly">Semi Monthly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-2 anc-field">
                        <label>Last Paycheck</label>
                        <input type="date" name="last_check" class="form-control">
                    </div>
                    <div class="col-md-2 anc-field">
                        <label>Next Paycheck</label>
                        <input type="date" name="next_check" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default anc-panel anc-hidden" id="anc-business-panel">
            <div class="panel-heading">
                Business Information
                <span class="anc-section-hint pull-right">Shown for Commercial loans</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 anc-field">
                        <label>Business Name</label>
                        <input type="text" name="business_name" class="form-control">
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Business Phone</label>
                        <input type="tel" name="business_phone" class="form-control" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Business Address</label>
                        <input type="text" name="business_address" class="form-control">
                    </div>

                    <div class="col-md-3 anc-field">
                        <label>Business City</label>
                        <input type="text" name="business_city" class="form-control">
                    </div>
                    <div class="col-md-3 anc-field">
                        <label>Business State</label>
                        <input type="text" name="business_state" class="form-control">
                    </div>
                    <div class="col-md-3 anc-field">
                        <label>Business Zip</label>
                        <input type="text" name="business_zip" class="form-control">
                    </div>
                    <div class="col-md-3 anc-field">
                        <label>Business Type</label>
                        <input type="text" name="business_type" class="form-control">
                    </div>

                    <div class="col-md-4 anc-field">
                        <label>Business Started</label>
                        <input type="text" name="business_create" class="form-control" placeholder="e.g. 2018-04">
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Monthly Gross Amount</label>
                        <input type="text" name="gross_amount" class="form-control" placeholder="e.g. 15000">
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Direct Deposit (Business)</label>
                        <select name="business_direct_deposit" class="form-control">
                            <option value=""></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="col-md-4 anc-field">
                        <label>Pay Frequency</label>
                        <select name="business_get_paid" class="form-control">
                            <option value=""></option>
                            <option value="Weekly">Weekly</option>
                            <option value="Bi-Weekly">Bi-Weekly</option>
                            <option value="Semi Monthly">Semi Monthly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-4 anc-field">
                        <label>Business Documentation</label>
                        <select name="business_docs" class="form-control">
                            <option value=""></option>
                            <option value="Business License">Business License</option>
                            <option value="Sellers Permit">Sellers Permit</option>
                            <option value="DBA">DBA</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default anc-panel">
            <div class="panel-heading">Application</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 anc-field">
                        <label>Application Status</label>
                        <select name="app_status" id="anc-app-status" class="form-control">
                            <option value=""></option>
                            <option value="New Application">New Application</option>
                            <option value="In Review">In Review</option>
                            <option value="Info Needed">Info Needed</option>
                            <option value="Approved">Approved</option>
                            <option value="Funded">Funded</option>
                            <option value="Declined">Declined</option>
                        </select>
                    </div>
                    <div class="col-md-3 anc-field">
                        <label>Source of Lead</label>
                        <select name="source_of_lead" class="form-control">
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
                    <div class="col-md-3 anc-field">
                        <label>Application Date <span class="anc-req">*</span></label>
                        <input type="date" name="application_date" class="form-control" required>
                    </div>
                    <div class="col-md-3 anc-field anc-hidden" id="anc-decline-field">
                        <label>Declined Reason</label>
                        <select name="decline_reason" class="form-control">
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
                        <span class="anc-help">Shown when status = Declined.</span>
                    </div>

                    <div class="col-md-12 anc-field">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="Anything worth recording about this applicant..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="anc-action-bar">
            <a href="view_all_customer_main.php" class="btn btn-default">Cancel</a>
            <button name="btn-submit" type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-save"></span> Save Customer
            </button>
        </div>
    </form>
</section>

<script type="text/javascript">
    $(function() {
        function syncBusinessPanel() {
            var v = $('#anc-loan-type').val();
            $('#anc-business-panel').toggleClass('anc-hidden', v !== 'commercial');
        }
        $('#anc-loan-type').on('change', syncBusinessPanel);
        syncBusinessPanel();

        function syncDeclineField() {
            var v = $('#anc-app-status').val();
            $('#anc-decline-field').toggleClass('anc-hidden', v !== 'Declined');
        }
        $('#anc-app-status').on('change', syncDeclineField);
        syncDeclineField();

        var $appDate = $('input[name="application_date"]');
        if (!$appDate.val()) {
            var d = new Date();
            var s = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
            $appDate.val(s);
        }
    });
</script>

</body>
</html>

<?php
}
?>