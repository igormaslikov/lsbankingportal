<?php
date_default_timezone_set('America/Los_Angeles');
 include('dbconfig.php');
 include('../../admin/functions.php');


$customer_fname=$_POST['p_fname'];
$customer_lname=$_POST['p_lname'];
$customer_fname = str_replace("-"," ","$customer_fname");
$customer_lname = str_replace("-"," ","$customer_lname");

$customer_tel=$_POST['p_phone'];
$customer_email=$_POST['p_email'];
$customer_ssn= "";
$dobb=$_POST['date_birtth'];
$address = $_POST['street_address'];
$address = str_replace("-"," ","$address");
$customer_city=$_POST['city'];
$customer_city = str_replace("-"," ","$customer_city");
$customer_state=$_POST['state'];
$customer_zip=$_POST['zip'];


    $web_site="Payday Mobile";

$emp_name=$_POST['p_emp_name'];
$emp_phone=$_POST['emp_mobile'];
$emp_amount=$_POST['p_net_amount'];

$emp_name = str_replace("-"," ","$emp_name");
$direct_deposit=$_POST['p_dirct_dep'];
$emp_payfre=$_POST['emp_payfre'];
$last_paydate=$_POST['last_paydayy'];
$nxt_paydate= $_POST['next_paydayy']; 
$type_loan= "payday";
$app_status = "New Application";
//echo $web_site;
//echo $app_status;
$date = date('Y-m-d H:i:s');
$time_created = date("g:i a");
$to_date_filter = date('Y-m-d');

$statement1= $_POST['statement1'];
$statement2= $_POST['statement2'];
$statement3= $_POST['statement3'];

//echo "select * from fnd_user_profile where email = '$customer_email' AND mobile_number = '$customer_tel'";
         $date_duplicate= date('Y-m-d', strtotime('-7 day'));
			  
              $sql_fnd=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email' AND mobile_number = '$customer_tel' AND date_of_birth='$dobb'"); 
echo "select * from fnd_user_profile where email = '$customer_email' AND mobile_number = '$customer_tel' AND date_of_birth='$dobb'";
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
    
    application_notes_update($user_fnd_iddd,$loan_create_id,$user_id,$status,$loan_transaction_id);
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

else if($application_status!='New Application') {
    
	$to_email_de = $customer_email;
$subject_de = 'Application Declined';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message_de = "Hola ".$fname." ".$lname.", 

Thank you for submitting your application to MoneyLine. Unfortunately your application has been declined. May be you have already pending application or your application has been rejected in last 7 days. If you have any questions regarding your application, contact us at support@pacificafinancegroup.com and a team member will respond shortly.";
 
$headers = 'From: support@pacificafinancegroup.com';
// mail($to_email,$subject,$message,$headers);

	send_email_notification($to_email_de,$subject_de,$message_de);
	
	//declined email end
	
	//Decline SMS
	
	$phone= $customer_tel;
  $fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.",Gracias por aplicar con Pacifica Finance Group, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
  
send_sms($phone,$message);	
	//Decline SMS End
}
echo "hello1";
}




else {
    
    //************************************** DL CODE**************************************************************
    
    // DL VErification : 


echo "hello";
$curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <CreateRequest4 xmlns=\"https://integration.decisionlogic.com\">\r\n       <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n\t\t<siteUserGuid>18b362a9-96d7-4a34-b510-328606d796a1</siteUserGuid>\r\n\t\t<profileGuid>07a99504-8061-4ff1-973e-0e2c494485f8</profileGuid>\r\n      <customerId>string1</customerId>\r\n      <firstName></firstName>\r\n      <lastName></lastName>\r\n      <accountNumber></accountNumber>\r\n      <routingNumber></routingNumber>\r\n      <contentServiceId>0</contentServiceId>\r\n      <emailAddress>$customer_email</emailAddress>\r\n    </CreateRequest4>\r\n  </soap:Body>\r\n</soap:Envelope>\r\n   ",
 CURLOPT_HTTPHEADER => array(
   "cache-control: no-cache",
   "content-type: text/xml"
 ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
 echo "cURL Error #:" . $err;
} else {
// echo $response;
}$dom = new DOMDocument();
$dom->loadXML($response);
$hotels = $dom->getElementsByTagName('CreateRequest4Response');

foreach ($hotels as $hotel) {
   $code = $hotel->getElementsByTagName('CreateRequest4Result')->item(0)->nodeValue;
   
   
}

//echo "Code : ".$code;
$date_dl = date("Y/m/d");
mysqli_query($con,"Insert into decision_login_codes (code,email,date) Values ('$code','$customer_email','$date_dl')");
//Decision Logic END


    
    //************************************ DL CODE END ***********************************************************
    
    //duplicate applications check end
    
	//echo "record does not exists";
$to_email_re = $customer_email;
$subject_re = 'Application Received';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message_re = "Hello ".$fname." ".$lname.", 
Thank you for applying at MoneyLine. We received your application. A team member will contact you shortly. 
Gracias por aplicar en MoneyLine. Recibimos su solicitud. Un miembro del equipo se comunicará con usted a la brevedad.
If you have any questions you can always contact us at support@pacificafinancegroup.com";
 
$headers = 'From: support@pacificafinancegroup.com';
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
        
         $sql_fnd_11=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email'"); 

while($row_fnd_id = mysqli_fetch_array($sql_fnd_11)) {
$user_fnd_iddd = $row_fnd_id['user_fnd_id'];

}

$query_fnd_id  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_iddd')";
        $result_fnd = mysqli_query($con, $query_fnd_id);
        if ($result_fnd) {
            //echo "<div class='form'><h3> New successfully added.</h3><br/></div>";
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


}

?>