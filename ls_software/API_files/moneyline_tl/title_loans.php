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


$car_year=$_GET['car_year'];
$car_make=$_GET['car_make'];
$car_model=$_GET['car_model'];
$mileage=$_GET['mileage'];
$lienholder=$_GET['lienholder'];
$holder_name=$_GET['holder_name'];




$type_loan= "Title loan";
$app_status = "New Application";
$web_site = "mymoneyline_tl";
echo $web_site;
echo $app_status;
$date = date('Y-m-d H:i:s');
$time_created = date("g:i a");

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
 
$headers = 'From: info@lsbanking.com';
//mail($to_email,$subject,$message,$headers);

    send_email_notification($to_email,$subject,$message);
    admin_leads_email_notification($subject,$message);
    
 // MAIL TO FUNCTION FOR FUNDED APPLICATIONS END  
 
 
 
 
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS START
    
    
    
$email_alejandra= "alejandra@lsbanking.com";
$subject_alejandra = 'Notification Already Customer';
$fname_alejandra = $customer_fname;
$lname_alejandra = $customer_lname;
  $message_alejandra = "Hola Admin, 

This is $fname_alejandra $lname_alejandra already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_alejandra = 'From: info@lsbanking.com';
//mail($email_alejandra,$subject_alejandra,$message_alejandra,$headers_alejandra);

admin_leads_email_notification($subject_alejandra,$message_alejandra);
    
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS END 
 
 
 
 
 
  // MAIL TO Mayte FOR FUNDED APPLICATIONS START
    
    
    
/*$email_mayte= "mayte@lsbanking.com";
$subject_mayte = 'Notification Already Customer';
$fname_mayte = $customer_fname;
$lname_mayte = $customer_lname;
  $message_mayte = "Hola Admin, 

This is $fname_mayte $lname_mayte already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_mayte = 'From: info@lsbanking.com';
mail($email_mayte,$subject_mayte,$message_mayte,$headers_mayte);*/
    
 // MAIL TO Mayte FOR FUNDED APPLICATIONS END
 
 
 // MAIL TO Denice FOR FUNDED APPLICATIONS START
    
    
    
/*$email_denice= "denice@lsbanking.com";
$subject_denice = 'Notification Already Customer';
$fname_denice= $customer_fname;
$lname_denice= $customer_lname;
  $message_denice = "Hola Admin, 

This is $fname_denice $lname_denice already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_denice = 'From: info@lsbanking.com';
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

Gracias por aplicar con LS Financing Inc, lamentamos informarle que su aplicaci??n ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un pr??stamo en estos momentos. Puede volver a aplicar despu??s de 90 d??as.";
 
$headers = 'From: info@lsbanking.com';
//mail($to_email,$subject,$message,$headers);

send_email_notification($to_email,$subject,$message);
	
	//declined email end
	
	//Decline SMS
	
	$phone= $customer_tel;
  $fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.",Gracias por aplicar con LS Financing Inc, lamentamos informarle que su aplicaci??n ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un pr??stamo en estos momentos. Puede volver a aplicar despu??s de 90 d??as.";
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

Thank you for submitting your application to MoneyLine. Your application has been received. Our team members are reviewing your application and will contact you shortly. If you have any questions you can always contact us at support@mymoneyline.com";
 
$headers = 'From: support@mymoneyline.com';
//mail($to_email,$subject,$message,$headers);

send_email_notification($to_email,$subject,$message);
admin_leads_email_notification($subject,$message);
    
	echo "record does not exists";

          // DB INSERTION STARTS
          
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,creation_date,application_status,website,created_time_)  VALUES ('$customer_fname','$customer_lname','$customer_email','$customer_tel','$address','$customer_city','$customer_state','$customer_zip','$dobb','$date','$app_status','$web_site','$time_created')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data Fnd </h3>";
        }
$sql_source_fndid=mysqli_query($con, "select * from fnd_user_profile where email= '$customer_email' AND mobile_number= '$customer_tel'"); 

while($row_sql_source_fndid = mysqli_fetch_array($sql_source_fndid)) {

$user_fnd_id=$row_sql_source_fndid['user_fnd_id'];
}
		$query_employment_entry = "INSERT INTO tbl_vehicle_info(user_fnd_id,vehicle_year,vehicle_made,vehicle_model,vehicle_miles,line_holder,holder_name) VALUES ('$user_fnd_id','$car_year','$car_make','$car_model','$mileage','$lienholder','$holder_name')";
		
		
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