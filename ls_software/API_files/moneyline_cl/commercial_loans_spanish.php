<?php
date_default_timezone_set('America/Los_Angeles');
 
 include('../../admin/dbconfig.php');
 include('../../admin/dbconnect.php');
 include('../../admin/functions.php');


$customer_fname=$_GET['p_fname'];
$customer_lname=$_GET['p_lname'];
$customer_tel=$_GET['p_phone'];
$customer_email=$_GET['p_email'];

$customer_ssn= "";


$dobb=$_GET['date_birtth'];



$address = $_GET['street_address'];
$address_line = $_GET['address_line'];

$address = str_replace("-"," ","$address");
$address_line = str_replace("-"," ","$address_line");
  

  
$customer_city=$_GET['city'];
$customer_city = str_replace("-"," ","$customer_city");


$customer_state=$_GET['state'];
$customer_zip=$_GET['zip'];


$address_b = $_GET['street_address_b'];
$address_line_b = $_GET['address_line_b'];
$customer_city_b=$_GET['city_b'];

$address_b = str_replace("-"," ","$address_b");
$address_line_b = str_replace("-"," ","$address_line_b");
$customer_city_b = str_replace("-"," ","$customer_city_b");



$customer_state_b=$_GET['state_b'];
$customer_zip_b=$_GET['zip_b'];
$emp_phone=$_GET['emp_mobile'];
$emp_amount=$_GET['p_net_amount'];
$emp_payfre=$_GET['emp_payfre'];
$last_paydate=$_GET['last_paydayy'];


$emp_name="";
$direct_deposit="";



$type_loan= "commercial loan";
$app_status = "New Application";
$web_site = "mymoneyline_cl";
echo $web_site;
echo $app_status;
$date = date('Y-m-d H:i:s');
$time_created = date("g:i a");

// if application is already funded start

$query_check_funded = "select * from fnd_user_profile where  ((email = '$customer_email' ) OR (mobile_number = '$customer_tel')  AND (application_status = 'Funded')";
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
 
$headers = 'From: support@pacificafinancegroup.com';
// mail($to_email,$subject,$message,$headers);

    send_email_notification($to_email,$subject,$message);
    admin_leads_email_notification($subject,$message);
    
 // MAIL TO FUNCTION FOR FUNDED APPLICATIONS END  
 
 
 
 
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS START
    
    
    
$email_alejandra= "leads@mymoneyline.com";
$subject_alejandra = 'Notification Already Customer';
$fname_alejandra = $customer_fname;
$lname_alejandra = $customer_lname;
  $message_alejandra = "Hola Admin, 

This is $fname_alejandra $lname_alejandra already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_alejandra = 'From: support@pacificafinancegroup.com';
//mail($email_alejandra,$subject_alejandra,$message_alejandra,$headers_alejandra);

admin_leads_email_notification($subject_alejandra,$message_alejandra);
    
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS END 
 
 
 
 
 
  // MAIL TO Mayte FOR FUNDED APPLICATIONS START
    
    
    
/*$email_mayte= "leads@mymoneyline.com";
$subject_mayte = 'Notification Already Customer';
$fname_mayte = $customer_fname;
$lname_mayte = $customer_lname;
  $message_mayte = "Hola Admin, 

This is $fname_mayte $lname_mayte already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_mayte = 'From: support@pacificafinancegroup.com';
mail($email_mayte,$subject_mayte,$message_mayte,$headers_mayte);*/
    
 // MAIL TO Mayte FOR FUNDED APPLICATIONS END
 
 
 // MAIL TO Denice FOR FUNDED APPLICATIONS START
    
    
    
/*$email_denice= "leads@mymoneyline.com";
$subject_denice = 'Notification Already Customer';
$fname_denice= $customer_fname;
$lname_denice= $customer_lname;
  $message_denice = "Hola Admin, 

This is $fname_denice $lname_denice already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_denice = 'From: support@pacificafinancegroup.com';
mail($email_denice,$subject_denice,$message_denice,$headers_denice);*/
    
 // MAIL TO Denice FOR FUNDED APPLICATIONS END
   
     

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
	
	$to_email = $customer_email;
$subject = 'Application Declined';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.", 

Gracias por aplicar con Money Line Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
 
$headers = 'From: support@pacificafinancegroup.com';
//mail($to_email,$subject,$message,$headers);
send_email_notification($to_email,$subject,$message);
	
	//declined email end
	
	//Decline SMS
	
$phone= $customer_tel;
  $fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.",Gracias por aplicar con Money Line Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
  
	send_sms($phone,$message);
	
	//Decline SMS End
	
}
else {
    
    
    // Duplicate applications check start
    
    $query_check_d = "select * from fnd_user_profile where  (email = '$customer_email' AND application_status ='New Application') ";
echo $query_check_d . "<br>";
$sql_check_d=mysqli_query($con, "$query_check_d"); 

  // Return the number of rows in result set
  $rowcount_d=mysqli_num_rows($sql_check_d);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount_d>0){
    echo "record duplications";
    
//	echo '<meta http-equiv="Refresh" content="1; url=https://www.mymoneyline.com/payday-loans/">';
}

else {
    
    //duplicate applications check end
    $to_email = $customer_email;
$subject = 'Application Received ';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.", 

Thank you for submitting your application to MoneyLine. Your application has been received. Our team members are reviewing your application and will contact you shortly. If you have any questions you can always contact us at support@pacificafinancegroup.com";
 
$headers = 'From: support@pacificafinancegroup.com';
//mail($to_email,$subject,$message,$headers);
send_email_notification($to_email,$subject,$message);
admin_leads_email_notification($subject,$message);

	echo "record does not exists";

          // DB INSERTION STARTS
          
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,creation_date,application_status,website,created_time_,loan_type)  VALUES ('$customer_fname','$customer_lname','$customer_email','$customer_tel','$address','$customer_city','$customer_state','$customer_zip','$dobb','$date','$app_status','$web_site','$time_created','$type_loan')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data Fnd </h3>";
        }
$sql_source_fndid=mysqli_query($con, "select * from fnd_user_profile where email= '$customer_email'  AND mobile_number= '$customer_tel'"); 

while($row_sql_source_fndid = mysqli_fetch_array($sql_source_fndid)) {

$user_fnd_id=$row_sql_source_fndid['user_fnd_id'];
}
		$query_employment_entry = "INSERT INTO tbl_business_info(user_fnd_id,business_name,address_b,address_line_b,city_b,state_b,zip_b,business_phone,monthly_gross_amount,how_paid,last_payday) VALUES ('$user_fnd_id','$emp_name','$address_b','$address_line_b','$customer_city_b','$customer_state_b','$customer_zip_b','$emp_phone','$emp_amount','$emp_payfre','$last_paydate')";
		
		
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