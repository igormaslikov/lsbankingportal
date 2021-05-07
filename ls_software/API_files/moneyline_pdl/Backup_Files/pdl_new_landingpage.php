<?php
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

echo "First Name".$customer_fname;
$customer_ssn= "121212";


$dobb=$_GET['date_birtth'];


$address_line = $_GET['address_line'];
$address_line = str_replace("-"," ","$address_line");
$address=$address_line;
 
$customer_city=$_GET['city'];
$customer_city = str_replace("-"," ","$customer_city");

$customer_state=$_GET['state'];
$customer_state = str_replace("-"," ","$customer_state");

$customer_zip=$_GET['zip'];

$emp_name=$_GET['p_emp_name'];
$emp_name = str_replace("-"," ","$emp_name");
$emp_phone=$_GET['emp_mobile'];
$emp_amount=$_GET['p_net_amount'];

$direct_deposit=$_GET['p_dirct_dep'];
$emp_payfre=$_GET['emp_payfre'];
$last_paydate=$_GET['last_paydayy'];
$business_address= $_GET['business_address'];
$business_address = str_replace("-"," ","$business_address");

$nxt_paydate=date('Y-m-d');

$type_loan= "personal loan";
$app_status = "New Application";
$web_site = "Installment CA";
echo $web_site;
echo $app_status;
$date = date('Y-m-d H:i:s');
$time_created = date("g:i a");
$to_date_filter = date('Y-m-d');
// if application is already funded start

$query_check_funded = "select * from fnd_user_profile where  ((email = '$customer_email' ) OR (mobile_number = '$customer_tel') ) AND (application_status = 'Funded')";
//echo $query_check . "<br>";
$sql_check_funded=mysqli_query($con, "$query_check_funded"); 

  // Return the number of rows in result set
  $rowcount_funded=mysqli_num_rows($sql_check_funded);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount_funded>0){
    
    

  //*************************************** SMS *************************
     $message = "Hola ".$customer_fname.",You are a customer already,if you want another payday loan please contact us directly. You DO NOT have apply again.";
   send_sms($customer_tel,$message);
   //*************************************** SMS END *************************
    
    
    // MAIL TO FUNCTION FOR FUNDED APPLICATIONS START
    
    
    
    	$to_email = $customer_email;
$subject = 'Your are Already Customer';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.", 

You are a customer already,if you want another payday loan please contact us directly. You DO NOT have apply again.";
 
$headers = 'From: support@mymoneyline.com';
// mail($to_email,$subject,$message,$headers);

send_email_notification($to_email,$subject,$message);
    
 // MAIL TO FUNCTION FOR FUNDED APPLICATIONS END  
 
 
 
 
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS START
    
    
    
$email_alejandra= "asimmaqbool195@gmail.com";
$subject_alejandra = 'Notification Already Customer';
$fname_alejandra = $customer_fname;
$lname_alejandra = $customer_lname;
  $message_alejandra = "Hola Admin, 

This is $fname_alejandra $lname_alejandra already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_alejandra = 'From: support@mymoneyline.com';
//mail($email_alejandra,$subject_alejandra,$message_alejandra,$headers_alejandra);

admin_leads_email_notification($subject_alejandra,$message_alejandra);
    
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS END 
 
 
 
 
 
  // MAIL TO Mayte FOR FUNDED APPLICATIONS START
    
    
    
//$email_mayte= "leads@mymoneyline.com";
//$subject_mayte = 'Notification Already Customer';
//$fname_mayte = $customer_fname;
//$lname_mayte = $customer_lname;
 /* $message_mayte = "Hola Admin, 

This is $fname_mayte $lname_mayte already customer with this email:$customer_email,and application status is FUNDED Applied again.";*/
 
//$headers_mayte = 'From: support@mymoneyline.com';
//mail($email_mayte,$subject_mayte,$message_mayte,$headers_mayte);

//admin_email_notification($email_alejandra,$subject_alejandra,$message_alejandra);
    
 // MAIL TO Mayte FOR FUNDED APPLICATIONS END
 
 

   
     

    	//echo '<meta http-equiv="Refresh" content="1; url=https://www.mymoneyline.com/already-customer-payday-loans/">';

}
// if application is already funded end
else {


// To check whether user is declined in 90 day period
$date_decline = date('Y-m-d', strtotime('-90 days'));
echo $date_decline;
$query_check = "select * from fnd_user_profile where  ( (email = '$customer_email' AND email !='') OR (mobile_number = '$customer_tel' AND mobile_number != '') ) AND (application_status = 'Declined' OR application_status = 'Rejected By Customer') AND (creation_date BETWEEN '$date_decline'AND '$date')";
echo $query_check . "<br>";
$sql_check=mysqli_query($con, "$query_check"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_check);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount>0){
    
    
	echo "record exists";
	
	
	
//	echo '<meta http-equiv="Refresh" content="1; url=https://www.mymoneyline.com/payday-loans/">';
		//declined email
	
	$to_email_de = $customer_email;
$subject_de = 'Application Declined';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message_de = "Hola ".$fname." ".$lname.", 

Thank you for submitting your application to MoneyLine. Unfortunately your application has been declined. If you have any questions regarding your application, contact us at support@mymoneyline.com and a team member will respond shortly.";
 
$headers = 'From: support@mymoneyline.com';
// mail($to_email,$subject,$message,$headers);

	send_email_notification($subject_de,$message_de);
	
	//declined email end
	
	//Decline SMS
	
	$phone= $customer_tel;
  $fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.",Gracias por aplicar con My Money Line Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
  
send_sms($phone,$message);	
	//Decline SMS End
	
}
else {
    
    
    // Duplicate applications check start
    
    $query_check_d = "select * from fnd_user_profile where email = '$customer_email' AND mobile_number = '$customer_tel'";
echo $query_check_d . "<br>";
$sql_check_d=mysqli_query($con, "$query_check_d"); 

  // Return the number of rows in result set
  $rowcount_d=mysqli_num_rows($sql_check_d);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount_d>0){
    echo "record duplications";
    
    $sql_fnd=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email'"); 

while($row_fnd_id = mysqli_fetch_array($sql_fnd)) {
$user_fnd_id = $row_fnd_id['user_fnd_id'];

}

$query_fnd_id  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_id')";
        $result_fnd = mysqli_query($con, $query_fnd_id);
        if ($result_fnd) {
            echo "<div class='form'><h3> New successfully added.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data tbl_loan </h3>";
        } 
    //********************************* ADMIN EMAIL ******************************************************




$to  = 'asimmaqbool195@gmail.com'; 

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
  Employer Name: '.$emp_name.' 
  
  Employer Phone: '.$emp_phone.' 
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
    
    
    
    
    
    
    
    
//	echo '<meta http-equiv="Refresh" content="1; url=https://www.mymoneyline.com/payday-loans/">';
}

else {
    
    //duplicate applications check end
    
	echo "record does not exists";
$to_email_re = $customer_email;
$subject_re = 'Application Received';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message_re = "Hello ".$fname." ".$lname.", 
Thank you for applying at MoneyLine. We received your application. A team member will contact you shortly. 
Gracias por aplicar en MoneyLine. Recibimos su solicitud. Un miembro del equipo se comunicará con usted a la brevedad.
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
  Employer Name: '.$emp_name.' 
  
  Employer Phone: '.$emp_phone.' 
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
          
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,creation_date,application_status,website,created_time_,loan_request_amount,payback_period,loan_type,application_date)  VALUES ('$customer_fname','$customer_lname','$customer_email','$customer_tel','$address','$customer_city','$customer_state','$customer_zip','$dobb','$date','$app_status','$web_site','$time_created','$amount','$payback','$type_loan','$to_date_filter')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data Fnd </h3>";
        }
        
       $sql_fnd=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email'"); 

while($row_fnd_id = mysqli_fetch_array($sql_fnd)) {
$user_fnd_id = $row_fnd_id['user_fnd_id'];

}

$query_fnd_id  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_id')";
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
		$query_employment_entry = "INSERT INTO source_income(user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date,address_b) VALUES ('$user_fnd_id','$emp_name','$emp_phone','$emp_amount','$direct_deposit','$emp_payfre','$last_paydate','$nxt_paydate','$business_address')";
		
		
       mysqli_query($con,$query_employment_entry);
	   
      $query34  = "INSERT INTO tbl_loan (user_fnd_id,type_of_loan)  VALUES ('$user_fnd_id','$type_loan')";
        $result34 = mysqli_query($con, $query34);
        if ($result34) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data tbl_loan </h3>";
        } 


          
          
          
          // DB INSERTION ENDS



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://app.echecktrac.com/echecktrac/isf/client/register?loginToken=LSFAO&locationCode=101",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<REQUEST>   \n<AUTHENTICATION userName=\"website\" password=\"website202\" loginToken=\"LSFAO\" locationCode=\"101\"/>  \n<PROSPECT status=\"New\" adSource=\"foo\" yearsAtAddress=\"1.0\" userName=\"\" password=\"\" emailAddress=\"$customer_email\">    \n<PERSON SSN=\"$customer_ssn\" firstName=\"$customer_fname\" lastName=\"$customer_lname\" sex=\"M\" DOB=\"$customer_dob\" DLState=\"$customer_state\" DLNumber=\"1234\"/>    \n<ADDRESS streetDir=\"$customer_cardinal\" streetType=\"$customer_type\" streetNo=\"$customer_street_num\" streetName=\"$customer_street_name\" unit=\"$customer_unit\" zip=\"$customer_zip\"/>     \n<PHONE type=\"home\" number=\"$customer_tel\"/>    \n</PROSPECT> \n</REQUEST> ",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml",
    "postman-token: 1ef12a79-02a2-eefd-5812-b7fcf87fd85a"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
}
}}
?>