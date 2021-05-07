<?php
$fname=$_GET['fname'];
$eemail=$_GET['email'];
$phonee=$_GET['phone'];
$ssn_numm=$_GET['ssn'];

$empname=$_GET['emp_name'];
$empstreet_num=$_GET['street_no'];
$empcardinal_point=$_GET['street_dr'];
$empstreet_name=$_GET['street_name'];
$empstreet_type=$_GET['street_type'];
$suiteroom=$_GET['suite'];
$empstate=$_GET['state'];
$empzip=$_GET['zip'];
$emptel=$_GET['e_phone'];
$empsupervisor=$_GET['emp_supervisor'];
$empposition=$_GET['e_position'];
$emptime=$_GET['e_yr_at'];

$emp2_name=$_GET['emp2_name'];
$emp2_street_num=$_GET['emp2_streetno'];
$emp2_cardinal_point=$_GET['streetdir2'];
$emp2_street_name=$_GET['streetname2'];
$emp2_street_type=$_GET['streettype2'];
$emp2_suite_room=$_GET['suite2'];
$emp2_state=$_GET['emp_state2'];
$emp2_zip=$_GET['emp_zip2'];
$emp2_tel=$_GET['e_phone2'];
$emp2_supervisor=$_GET['emp_supervisor2'];
$emp2_position=$_GET['position2'];
$emp2_time=$_GET['e_yr_at2'];

$ref_fname=$_GET['ref_fname1'];
$ref_lname=$_GET['ref_lname1'];
$ref_tel=$_GET['ref_phone1'];
$ref_relation=$_GET['relation1'];

$ref2_fname=$_GET['ref_fname2'];
$ref2_lname=$_GET['ref_lname2'];
$ref2_tel=$_GET['ref_phone2'];
$ref2_relation=$_GET['relation2'];

$ref3_fname=$_GET['ref_fname3'];
$ref3_lname=$_GET['ref_lname3'];
$ref3_tel=$_GET['ref_phone3'];
$ref3_relation=$_GET['relation3'];

$ref4_fname=$_GET['ref_fname4'];
$ref4_lname=$_GET['ref_lname4'];
$ref4_tel=$_GET['ref_phone4'];
$ref4_relation=$_GET['relation4'];

$bank_routing_no=$_GET['bank_routing_no'];
$account_no=$_GET['account_no'];

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
  CURLOPT_POSTFIELDS => "<REQUEST>  \n<AUTHENTICATION userName=\"website\" password=\"website202\" loginToken=\"LSFAO\" locationCode=\"101\"/>  \n<PROSPECT status=\"New\" adSource=\"foo\" yearsAtAddress=\"1.0\" userName=\"\" password=\"\" emailAddress=\"$eemail\">    \n<PERSON SSN=\"$ssn_numm\" firstName=\"$fname\" lastName=\"cbc\"  DOB=\"1/23/1990\" DLState=\"CA\" DLNumber=\"1234\"/>     \n<ADDRESS streetDir=\"N\" streetType=\"Dr\" streetNo=\"2344\" streetName=\"Main\" unit=\"111\" zip=\"22115\"/>     \n<PHONE type=\"home\" number=\"$phonee\"/>     \n<EMPLOYER name=\"$empname\" supervisor=\"$empsupervisor\" position=\"$empposition\" yearsAtJob=\"$emptime\" payDays=\"Friday\" payAmount=\"1000.00\" payFrequency=\"Weekly\" daysOff=\"Sat,Sun\" directDeposit=\"No\" endTime=\"5PM\" startTime=\"8AM\" nextPayDate=\"10/1/2019\">     \n<ADDRESS streetDir=\"$empcardinal_point\" streetType=\"$empstreet_type\" streetNo=\"$empstreet_num\" streetName=\"$empstreet_name\" unit=\"$suiteroom\" zip=\"$empzip\"/>      \n<PHONE type=\"work\" number=\"$emptel\"/>    \n</EMPLOYER>     \n<BANK dateOpened=\"1/2/2001\" status=\"ACTIVE\" accountNumber=\"$account_no\" branch=\"MyBranch\" accountType=\"CHECKING\" routingNumber=\"$bank_routing_no\" achAuthorization=\"WEB\"/>     <LANDLORD name=\"LandlordCo\" ownOrRent=\"OWN\" monthlyPayment=\"500.00\">      <PERSON SSN=\"887999992\" firstName=\"Landy\" middleName=\"J\" lastName=\"Landlord\"/>      <ADDRESS streetDir=\"E\" streetType=\"Ave\" streetNo=\"345\" streetName=\"Elm\" unit=\"333\" zip=\"78777\"/>      \n<PHONE type=\"phone1\" number=\"5123334444\"/>     \n</LANDLORD>    \n<SPOUSE>      \n<PERSON firstName=\"Spousey\" middleName=\"B\" lastName=\"Spouse\" DLState=\"TX\" DLNumber=\"4567\"/>      \n<ADDRESS streetDir=\"N\" streetType=\"Cr\" streetNo=\"456\" streetName=\"Smith\" unit=\"444\" zip=\"78788\"/>     \n<PHONE type=\"home\" number=\"5123335555\"/>     \n<EMPLOYER name=\"$emp2_name\" supervisor=\"$emp2_supervisor\" position=\"$emp2_position\" yearsAtJob=\"$emp2_time\" payDays=\"Monday\" payAmount=\"2000.00\"        payFrequency=\"Weekly\" daysOff=\"Sat,Sun\" directDeposit=\"Yes\" endTime=\"5PM\" startTime=\"8AM\"    nextPayDate=\"1/12/2019\">       \n<ADDRESS streetDir=\"$emp2_cardinal_point\" streetType=\"$emp2_street_type\" streetNo=\"$emp2_street_num\" streetName=\"$emp2_street_name\" unit=\"$emp2_suite_room\" zip=\"$emp2_zip\"/>       <PHONE type=\"work\" number=\"$emp2_tel\"/>      </EMPLOYER>    \n</SPOUSE>     \n<CONTACT relationshipType=\"$ref_relation\">      \n<PERSON firstName=\"$ref_fname\"  lastName=\"$ref_lname\"/>      \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>    \n<PHONE type=\"home\" number=\"$ref_tel\"/>   \r\n   </CONTACT>    \r\n  <CONTACT relationshipType=\"$ref2_relation\">    \n<PERSON firstName=\"$ref2_fname\" lastName=\"$ref2_lname\"/>     \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>     \n<PHONE type=\"home\" number=\"$ref2_tel\"/>  \r\n  </CONTACT>  \r\n <CONTACT relationshipType=\"$ref3_relation\">    \n<PERSON firstName=\"$ref3_fname\" lastName=\"$ref3_lname\"/>     \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>     \n<PHONE type=\"home\" number=\"$ref3_tel\"/>   <CONTACT relationshipType=\"$ref4_relation\">    \n<PERSON firstName=\"$ref4_fname\" lastName=\"$ref4_lname\"/>     \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>     \n<PHONE type=\"home\" number=\"$ref4_tel\"/>  \r\n</CONTACT>  \r\n</PROSPECT> \r\n</REQUEST> ",
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