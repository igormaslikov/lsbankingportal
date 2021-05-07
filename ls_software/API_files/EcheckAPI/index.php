<?php
$fname=$_GET['fname'];
$lname=$_GET['lname'];
$email=$_GET['email'];
$ssn=$_GET['ssn'];
$month=$_GET['month'];
$date=$_GET['date'];
$year=$_GET['year'];
$dob=$month .'/'.$date .'/'.$year;
$sex=$_GET['sex'];
$state=$_GET['state'];
$phone=$_GET['phone'];
$street_no=$_GET['street_no'];
$street_dr=$_GET['street_dr'];
$street_name=$_GET['street_name'];
$street_type=$_GET['street_type'];
$unit=$_GET['unit'];
$zip=$_GET['zip'];
$yrs_at=$_GET['yrs_at'];
$id=$_GET['id'];
$employe=$_GET['employe'];
$directdeposit=$_GET['directdeposit'];
$payfrequency=$_GET['payfrequency'];
$nextpaydate=$_GET['nextpaydate'];
$payAmount=$_GET['payAmount'];
$achAuthorization=$_GET['achAuthorization'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://app.echecktrac.com/echecktrac/isf/client/register?loginToken=LSFAO&locationCode=101",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<REQUEST>  \n<AUTHENTICATION userName=\"website\" password=\"website202\" loginToken=\"LSFAO\" locationCode=\"101\"/>  \n<PROSPECT status=\"New\" adSource=\"foo\" yearsAtAddress=\"$yrs_at\" userName=\"\" password=\"\" emailAddress=\"$email\">    \n<PERSON SSN=\"$ssn\" firstName=\"$fname\" lastName=\"$lname\" sex=\"$sex\" DOB=\"$dob\" DLState=\"$state\" DLNumber=\"$id\"/>     \n<ADDRESS streetDir=\"$street_dr\" streetType=\"$street_type\" streetNo=\"$street_no\" streetName=\"$street_name\" unit=\"$unit\" zip=\"$zip\"/>     \n<PHONE type=\"home\" number=\"$phone\"/>     \n<EMPLOYER name=\"$employe\" supervisor=\"Fred\" position=\"Manager\" yearsAtJob=\"1\" payDays=\"Friday\" payAmount=\"$payAmount\" payFrequency=\"$payfrequency\" daysOff=\"Sat,Sun\" directDeposit=\"$directdeposit\" endTime=\"5PM\" startTime=\"8AM\" nextPayDate=\"$nextpaydate\">     \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"234\" streetName=\"Oak\" unit=\"222\" zip=\"78766\"/>      \n<PHONE type=\"work\" number=\"512333333\"/>    \n</EMPLOYER>     \n<BANK dateOpened=\"1/2/2001\" status=\"ACTIVE\" accountNumber=\"12345\" branch=\"MyBranch\" accountType=\"CHECKING\" routingNumber=\"000000000\" achAuthorization=\"WEB\"/>     <LANDLORD name=\"LandlordCo\" ownOrRent=\"OWN\" monthlyPayment=\"500.00\">      <PERSON SSN=\"887999992\" firstName=\"Landy\" middleName=\"J\" lastName=\"Landlord\"/>      <ADDRESS streetDir=\"E\" streetType=\"Ave\" streetNo=\"345\" streetName=\"Elm\" unit=\"333\" zip=\"78777\"/>      \n<PHONE type=\"phone1\" number=\"5123334444\"/>     \n</LANDLORD>    \n<SPOUSE>      \n<PERSON firstName=\"Spousey\" middleName=\"B\" lastName=\"Spouse\" DLState=\"TX\" DLNumber=\"4567\"/>      \n<ADDRESS streetDir=\"N\" streetType=\"Cr\" streetNo=\"456\" streetName=\"Smith\" unit=\"444\" zip=\"78788\"/>     \n<PHONE type=\"home\" number=\"5123335555\"/>     \n<EMPLOYER name=\"SpouseCo\" supervisor=\"Sally\" position=\"Clerk\" yearsAtJob=\"2\" payDays=\"Monday\" payAmount=\"2000.00\"        payFrequency=\"Weekly\" daysOff=\"Sat,Sun\" directDeposit=\"No\" endTime=\"5PM\" startTime=\"8AM\"    nextPayDate=\"10/1/2007\">       \n<ADDRESS streetDir=\"E\" streetType=\"Dr\" streetNo=\"567\" streetName=\"Hackberry\" unit=\"555\" zip=\"78799\"/>       <PHONE type=\"work\" number=\"512333333\"/>      </EMPLOYER>    \n</SPOUSE>     \n<CONTACT relationshipType=\"Friend\">      \n<PERSON firstName=\"Friendly\" middleName=\"F\" lastName=\"Friend\"/>      \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>    \n<PHONE type=\"home\" number=\"5123337777\"/>     </CONTACT>     <CONTACT relationshipType=\"Friend\">    \n<PERSON firstName=\"Friendly2\" middleName=\"F\" lastName=\"Friend\"/>     \n<ADDRESS streetDir=\"W\" streetType=\"St\" streetNo=\"654\" streetName=\"Juniper\" unit=\"665\" zip=\"78799\"/>     \n<PHONE type=\"home\" number=\"5123337777\"/>    \n</CONTACT>  \n</PROSPECT> \n</REQUEST> ",
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