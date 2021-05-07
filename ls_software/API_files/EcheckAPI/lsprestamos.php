<?php
$f_name=$_GET['f_name'];
$l_name=$_GET['l_name'];
$tel_num=$_GET['tel_num'];
$email=$_GET['email'];
$ssn=$_GET['ssn'];
$month=$_GET['month'];
$date=$_GET['date'];
$year=$_GET['year'];
$dob= $month .'/'. $date .'/'. $year;
$gender=$_GET['gender'];
$id_type=$_GET['id_type'];
$id_num=$_GET['id_num'];
$advertiser=$_GET['advertiser'];
$street_num=$_GET['street_num'];
$cardinal_point=$_GET['cardinal_point'];
$street_name=$_GET['street_name'];
$type_street=$_GET['type_street'];
$apartment=$_GET['apartment'];
$state=$_GET['state'];
$zip=$_GET['zip'];
$time_address=$_GET['time_address'];
$emp_name=$_GET['emp_name'];
$emp_street_num=$_GET['emp_street_num'];
$emp_cardinal_point=$_GET['emp_cardinal_point'];
$emp_street_name=$_GET['emp_street_name'];
$emp_street_type=$_GET['emp_street_type'];
$suite_room=$_GET['suite_room'];
$emp_state=$_GET['emp_state'];
$emp_zip=$_GET['emp_zip'];
$emp_tel=$_GET['emp_tel'];
$emp_position=$_GET['emp_position'];
$emp_time=$_GET['emp_time'];
$emp_supervisor=$_GET['emp_supervisor'];
$direct_deposit=$_GET['direct_deposit'];
$emp_pay=$_GET['emp_pay'];
$pay_period=$_GET['pay_period'];
$pay_month=$_GET['pay_month'];
$pay_date=$_GET['pay_date'];
$pay_year=$_GET['pay_year'];
$next_payment= $pay_month .'/'. $pay_date .'/'. $pay_year;
$emp2_name=$_GET['emp2_name'];
$emp2_street_num=$_GET['emp2_street_num'];
$emp2_cardinal_point=$_GET['emp2_cardinal_point'];
$emp2_street_name=$_GET['emp2_street_name'];
$emp2_street_type=$_GET['emp2_street_type'];
$emp2_suite_room=$_GET['emp2_suite_room'];
$emp2_state=$_GET['emp2_state'];
$emp2_zip=$_GET['emp2_zip'];
$emp2_tel=$_GET['emp2_tel'];
$emp2_position=$_GET['emp2_position'];
$emp2_time=$_GET['emp2_time'];
$emp2_supervisor=$_GET['emp2_supervisor'];
$emp2_deposit=$_GET['emp2_deposit'];
$emp2_pay=$_GET['emp2_pay'];
$emp2_pay_period=$_GET['emp2_pay_period'];
$emp2_month=$_GET['emp2_month'];
$emp2_date=$_GET['emp2_date'];
$emp2_year=$_GET['emp2_year'];
$emp2_nextpay_date= $emp2_month .'/'. $emp2_date .'/'. $emp2_year;
$ref_fname=$_GET['ref_fname'];
$ref_lname=$_GET['ref_lname'];
$ref_tel=$_GET['ref_tel'];
$ref_relation=$_GET['ref_relation'];
$ref2_fname=$_GET['ref2_fname'];
$ref2_lname=$_GET['ref2_lname'];
$ref2_tel=$_GET['ref2_tel'];
$ref2_relation=$_GET['ref2_relation'];
$accept=$_GET['accept'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://app.echecktrac.com/echecktrac/isf/client/register?loginToken=LSFAO&locationCode=101",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<REQUEST>  \n<AUTHENTICATION userName=\"website\" password=\"website202\" loginToken=\"LSFAO\" locationCode=\"101\"/>  \n<PROSPECT status=\"New\" adSource=\"$advertiser\" yearsAtAddress=\"$time_address\" userName=\"\" password=\"\" emailAddress=\"$email\">    \n<PERSON SSN=\"$ssn\" firstName=\"$f_name\" lastName=\"$l_name\" sex=\"$gender\" DOB=\"$dob\" DLState=\"$state\" DLNumber=\"$id_num\"/>     \n<ADDRESS streetDir=\"$cardinal_point\" streetType=\"$type_street\" streetNo=\"$street_num\" streetName=\"$street_name\" unit=\"$apartment\" zip=\"$zip\"/>     \n<PHONE type=\"home\" number=\"$tel_num\"/>     \n<EMPLOYER name=\"$emp_name\" supervisor=\"$emp_supervisor\" position=\"$emp_position\" yearsAtJob=\"$emp_time\" payDays=\"Friday\" payAmount=\"$emp_pay\" payFrequency=\"$pay_period\" daysOff=\"Sat,Sun\" directDeposit=\"$direct_deposit\" endTime=\"5PM\" startTime=\"8AM\" nextPayDate=\"$next_payment\">     \n<ADDRESS streetDir=\"$emp_cardinal_point\" streetType=\"$emp_street_type\" streetNo=\"$emp_street_num\" streetName=\"$emp_street_name\" unit=\"$suite_room\" zip=\"$emp_zip\"/>      \n<PHONE type=\"work\" number=\"$emp_tel\"/>    \n</EMPLOYER>     \n<BANK dateOpened=\"1/2/2001\" status=\"ACTIVE\" accountNumber=\"12345\" branch=\"MyBranch\" accountType=\"CHECKING\" routingNumber=\"000000000\" achAuthorization=\"WEB\"/>     <LANDLORD name=\"LandlordCo\" ownOrRent=\"OWN\" monthlyPayment=\"500.00\">      <PERSON SSN=\"887999992\" firstName=\"Landy\" middleName=\"J\" lastName=\"Landlord\"/>      <ADDRESS streetDir=\"E\" streetType=\"Ave\" streetNo=\"345\" streetName=\"Elm\" unit=\"333\" zip=\"78777\"/>      \n<PHONE type=\"phone1\" number=\"5123334444\"/>     \n</LANDLORD>    \n<SPOUSE>      \n<PERSON firstName=\"Spousey\" middleName=\"B\" lastName=\"Spouse\" DLState=\"TX\" DLNumber=\"4567\"/>      \n<ADDRESS streetDir=\"N\" streetType=\"Cr\" streetNo=\"456\" streetName=\"Smith\" unit=\"444\" zip=\"78788\"/>     \n<PHONE type=\"home\" number=\"5123335555\"/>     \n<EMPLOYER name=\"$emp2_name\" supervisor=\"$emp2_supervisor\" position=\"$emp2_position\" yearsAtJob=\"$emp2_time\" payDays=\"Monday\" payAmount=\"$emp2_pay\"        payFrequency=\"$emp2_pay_period\" daysOff=\"Sat,Sun\" directDeposit=\"$emp2_deposit\" endTime=\"5PM\" startTime=\"8AM\"    nextPayDate=\"$emp2_nextpay_date\">       \n<ADDRESS streetDir=\"$emp2_cardinal_point\" streetType=\"$emp2_street_type\" streetNo=\"$emp2_street_num\" streetName=\"$emp2_street_name\" unit=\"$emp2_suite_room\" zip=\"$emp2_zip\"/>       <PHONE type=\"work\" number=\"$emp2_tel\"/>      </EMPLOYER>    \n</SPOUSE>     \n<CONTACT relationshipType=\"$ref_relation\">      \n<PERSON firstName=\"$ref_fname\"  lastName=\"$ref_lname\"/>      \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>    \n<PHONE type=\"home\" number=\"$ref_tel\"/>     </CONTACT>     <CONTACT relationshipType=\"$ref2_relation\">    \n<PERSON firstName=\"$ref2_fname\" lastName=\"$ref2_lname\"/>     \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>     \n<PHONE type=\"home\" number=\"$ref2_tel\"/>    \n</CONTACT>  \n</PROSPECT> \n</REQUEST> ",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml",
    "postman-token: a29a81d4-54a1-b5e9-d554-439dd432e6c7"
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
?>