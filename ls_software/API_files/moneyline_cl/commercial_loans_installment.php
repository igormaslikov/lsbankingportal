<?php
$_SESSION["Optima"] = "true";
date_default_timezone_set('America/Los_Angeles');
 include('../../admin/dbconfig.php');
 include('../../admin/dbconnect.php');
 include('../../admin/functions.php');


$amount=$_GET['amount'];
$payback=$_GET['payback'];

$customer_fname=$_GET['p_fname'];
$customer_lname=$_GET['p_lname'];
$customer_tel=$_GET['p_phone'];
$customer_email=$_GET['p_email'];

$payback = str_replace("_"," ","$payback");
$customer_fname = str_replace("-"," ","$customer_fname");
$customer_lname = str_replace("-"," ","$customer_lname");


$customer_ssn= "121212";


$dobb=$_GET['date_birtth'];


$address_line = $_GET['address_line'];
$address_line = str_replace("-"," ","$address_line");
$address=$address_line;
$ssn=$_GET['ssn'];
 
$customer_city=$_GET['city'];
$customer_city = str_replace("-"," ","$customer_city");

$customer_state=$_GET['state'];
$customer_state = str_replace("-"," ","$customer_state");

if ($customer_state=='AZ')
{
    $web_site="Commercial Arizona";
}

else if ($customer_state=='NV')
{
    $web_site="Commercial Nevada";
}

else{
    $web_site="Commercial $customer_state";
}

$customer_zip=$_GET['zip'];

$business_name=$_GET['business_name'];
$business_name = str_replace("-"," ","$business_name");
$business_phone=$_GET['business_phone'];
$emp_amount=$_GET['p_net_amount'];

$direct_deposit=$_GET['p_dirct_dep'];
$business_type=$_GET['business_type'];
$business_create=$_GET['business_create'];
$business_address= $_GET['business_address'];
$business_state = $_GET['business_state'];
$business_city= $_GET['business_city'];
$business_zip= $_GET['business_zip'];
$business_address = str_replace("-"," ","$business_address");
$business_state = str_replace("-"," ","$business_state");
$business_city = str_replace("-"," ","$business_city");
$business_zip = str_replace("-"," ","$business_zip");


$business_type = str_replace("-"," ","$business_type");
$business_create = str_replace("-"," ","$business_create");

$nxt_paydate=date('Y-m-d');

$type_loan= "commercial";
$app_status = "New Application";

//echo $web_site;
//echo $app_status;
$date = date('Y-m-d H:i:s');
$time_created = date("g:i a");
$to_date_filter = date('Y-m-d');

$lang= $_GET['lang'];


//echo "select * from fnd_user_profile where email = '$customer_email' AND mobile_number = '$customer_tel'";
         $date_duplicate= date('Y-m-d', strtotime('-7 day'));
			  
              $sql_fnd=mysqli_query($con, "select * from fnd_user_profile where mobile_number = '$customer_tel'"); 

            while($row_fnd_id = mysqli_fetch_array($sql_fnd)) {
            $user_fnd_iddd = $row_fnd_id['user_fnd_id'];
            $creation_date = $row_fnd_id['application_date'];
            $application_status = $row_fnd_id['application_status'];
            }
            
            
          $rowcount_funded=mysqli_num_rows($sql_fnd);

if($rowcount_funded>0){

if ($creation_date<$date_duplicate){
    $loan_create_id="";
    $user_id="";
    $status="This is Already Customer And Applied Again on $to_date_filter.";
    $loan_transaction_id="";
   
mysqli_query($con, "UPDATE fnd_user_profile SET application_status='New Application', application_date='$to_date_filter', loan_type='$type_loan' where user_fnd_id ='$user_fnd_iddd'");
$query_fnd_id  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_iddd')";
        $result_fnd = mysqli_query($con, $query_fnd_id);
        if ($result_fnd) {
            echo "<div class='form'><h3> New successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data tbl_loan </h3>";
        } 
        
        application_notes($user_fnd_iddd,$loan_create_id,$user_id,$status,$loan_transaction_id);
    
    //********************************* ADMIN EMAIL ******************************************************




// subject
$subject_data = 'Already Customer Applied Again';

// message
$message_data = '

  Loan Amount: '.$amount.'
  Payback Period: '.$payback.'
  First Name: '.$customer_fname.' 
  Last Name: '.$customer_lname.' 
  
  Phone Number: '.$customer_tel.' 
  Email: '.$customer_email.' 
  Date of Birth: '.$dobb.' 
  Address: '.$address.'
  City: '.$customer_city.' 
  State: '.$customer_state.' 
  Zip: '.$customer_zip.' 
  Business Name: '.$business_name.' 
  
  Business Phone: '.$business_phone.' 
  Net Amount of Salary (in $ s): '.$emp_amount.' 
  Direct Deposit: '.$direct_deposit.' 
  Payment Frequency: '.$emp_payfre.' 
  Last Paycheck: '.$last_paydate.' 
  Next Paycheck: '.$nxt_paydate.' 

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
    
	$to_email_de = $customer_email;
$subject_de = 'Application Declined';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message_de = "Hola ".$fname." ".$lname.", 

Thank you for submitting your application to Optima Financial Solutions Inc. Unfortunately your application has been declined. May be you have already pending application or your application has been rejected in last 7 days. If you have any questions regarding your application, contact us at support@ofsca.com and a team member will respond shortly.";
 
$headers = 'From: support@ofsca.com';
// mail($to_email,$subject,$message,$headers);

	send_email_notification($to_email_de,$subject_de,$message_de);
	
	//declined email end
	
	//Decline SMS
	
	$phone= $customer_tel;
  $fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.",Gracias por aplicar con Optima Financial Solutions Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
  
send_sms($phone,$message);	
	//Decline SMS End
}
}




else {
    
    //duplicate applications check end
    
	echo "record does not exists";
$to_email_re = $customer_email;
$subject_re = 'Application Received';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message_re = "Hello ".$fname." ".$lname.", 
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

  Loan Amount: '.$amount.'
  Payback Period: '.$payback.'
  First Name: '.$customer_fname.' 
  Last Name: '.$customer_lname.' 
  
  Phone Number: '.$customer_tel.' 
  Email: '.$customer_email.' 
  Date of Birth: '.$dobb.' 
  Address: '.$address.' 
  City: '.$customer_city.' 
  State: '.$customer_state.' 
  Zip: '.$customer_zip.' 
  Business Name: '.$business_name.' 
  
  Business Phone: '.$business_phone.' 
  Net Amount of Salary (in $ s): '.$emp_amount.' 
  Direct Deposit: '.$direct_deposit.' 
  Payment Frequency: '.$emp_payfre.' 
  Last Paycheck: '.$last_paydate.' 
  Next Paycheck: '.$nxt_paydate.' 

';



// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


//mail($to, $subject_data, $message_data, $headers);

admin_leads_email_notification($subject_data,$message_data);





//**************************************** END ***************************************************************************************
          // DB INSERTION STARTS
          
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,ssn,creation_date,application_status,website,created_time_,loan_request_amount,payback_period,loan_type,application_date,lang)  VALUES ('$customer_fname','$customer_lname','$customer_email','$customer_tel','$address','$customer_city','$customer_state','$customer_zip','$dobb','$ssn','$date','$app_status','$web_site','$time_created','$amount','$payback','$type_loan','$to_date_filter','$lang')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data Fnd </h3>";
        }
        
         $sql_fnd_11=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email'"); 

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
        
        
$sql_source_fndid=mysqli_query($con, "select * from fnd_user_profile where email= '$customer_email' AND mobile_number= '$customer_tel'"); 

while($row_sql_source_fndid = mysqli_fetch_array($sql_source_fndid)) {

$user_fnd_id=$row_sql_source_fndid['user_fnd_id'];
}
		$query_employment_entry = "INSERT INTO source_income(user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date,address_b,business_type,business_create) VALUES ('$user_fnd_id','$emp_name','$emp_phone','$emp_amount','$direct_deposit','$emp_payfre','$last_paydate','$nxt_paydate','$business_address','$business_type','$business_create')";
		
		
       mysqli_query($con,$query_employment_entry);
	   
      $query34  = "INSERT INTO tbl_loan (user_fnd_id,type_of_loan)  VALUES ('$user_fnd_id','$type_loan')";
        $result34 = mysqli_query($con, $query34);
        if ($result34) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data tbl_loan </h3>";
        } 

        $query_business  = "INSERT INTO tbl_business_info (user_fnd_id,business_name,business_phone,business_address,business_city,business_state,business_zip,monthly_gross_amount,created_at)  VALUES ('$user_fnd_id','$business_name','$business_phone','$business_address','$business_city','$business_state','$business_zip','$emp_amount','$date')";
        $result_business = mysqli_query($con, $query_business);
        if ($result_business) {
          //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
          echo "<h3> Error Inserting Data </h3>";
        }

}
?>