<?php
$id=$_GET['id'];

include 'dbconfig.php';


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {
$mobile_verification = $row['mobile_verification_status'];
$first_name=$row['first_name'];
$last_name =$row['last_name'];
$name=$first_name.' '.$last_name;
$customer_phone =$row['mobile_number'];
$customer_email =$row['email'];
$address=$row['address'];
$cityy=$row['city'];
$statee=$row['state'];
$zipp=$row['zip_code'];
$dob=$row['date_of_birth'];
$ssn=$row['ssn'];
$creation_date=$row['creation_date'];
$creationdate=date("m-d-y", strtotime($creation_date) );
$last_update=$row['last_update_by'];
$created_by=$row['created_by'];
$last_update_date=$row['last_update_date'];
$last_updatedate=date("m-d-Y H:i:s", strtotime($last_update_date) );
$fnd_dl_code = $row['dl_code'];

$appli_status=$row['application_status'];
$loan_amount=$row['amount_of_loan'];
$source_lead=$row['source_of_lead'];
$declined_reason=$row['declined_reason'];
$decision_logic_status = $row['decision_logic_status'];
$id_photo = $row['id_photo'];
$bank_front = $row['bank_front'];
$bank_back = $row['bank_back'];
$personal_loan_term = $row['personal_loan'];
$void_img = $row['void_img'];
$apr = $row['apr'];

$web = $row['website'];
}


?>


<?php

// ...*********************************************EXperian API Score Starts *******************************...//


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://us-api.experian.com/oauth2/v1/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "username=lsexpapi&password=@Lsfinancing202",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "client_id: AGCcWbXoZpApAuI7yBkfbZm4RmpsyppV",
    "client_secret: WxaKtiQYy9i6ZPTP",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 4308432f-5216-d550-6902-b0848abdb035"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
}


$data=json_decode($response, true);
$access_token=$data['access_token'];

//echo $access_token;

// ...*********************************************EXperian API Token End *******************************...//


$api_ssn = str_replace("-","","$ssn");
$api_phone = str_replace("-","","$customer_phone");
$api_fname = str_replace(" ","","$first_name");
$api_lname = str_replace(" ","","$last_name");
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://us-api.experian.com/consumerservices/credit-profile/v2/credit-report",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n\r\n    \"consumerPii\": {\r\n\r\n        \"primaryApplicant\": {\r\n\r\n            \"name\": {\r\n\r\n                \"lastName\": \"$api_lname\",\r\n\r\n                \"firstName\": \"$api_fname\"\r\n\r\n            },\r\n\r\n            \"ssn\": {\r\n\r\n                \"ssn\": \"$api_ssn\"\r\n\r\n            },\r\n\r\n            \"currentAddress\": {\r\n\r\n                \"line1\": \"$address\",\r\n\r\n                \"city\": \"$cityy\",\r\n\r\n                \"state\": \"$statee\",\r\n\r\n                \"zipCode\": \"$zipp\"\r\n\r\n            },\r\n\r\n            \"phone\": [\r\n\r\n                {\r\n\r\n                    \"number\": \"$api_phone\"\r\n\r\n                }\r\n\r\n            ]\r\n\r\n        }\r\n\r\n    },\r\n\r\n    \"requestor\": {\r\n\r\n        \"subscriberCode\": \"1984405\" \r\n\r\n    },\r\n\r\n    \"addOns\": {\r\n\r\n        \"riskModels\": {\r\n\r\n            \"modelIndicator\": [\r\n\r\n                \"V4\"\r\n\r\n            ],\r\n\r\n            \"scorePercentile\": \"N\"\r\n\r\n        },\r\n\r\n        \"mla\": \"\",\r\n\r\n        \"ofacmsg\": \"Y\",\r\n\r\n        \"fraudShield\": \"Y\",\r\n\r\n        \"paymentHistory84\": \"N\"\r\n\r\n    },\r\n\r\n    \"permissiblePurpose\": {\r\n\r\n        \"type\": \"\",\r\n\r\n        \"terms\": \"\",\r\n\r\n        \"abbreviatedAmount\": \"\"\r\n\r\n    }\r\n\r\n}\r\n\r\n ",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer $access_token",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo"<br><br><br>". $response;
}
//$response = "[".$response. "]";

$quoteJson = json_decode($response);

$score= $quoteJson->creditProfile[0]->riskModel[0]->score;
$score_factor= $quoteJson->creditProfile[0]->riskModel[0]->scoreFactors[0]->code;

$api_accountt= $quoteJson->creditProfile[0]->tradeline[0]->accountNumber;

$balanceAmount= $quoteJson->creditProfile[0]->tradeline[0]->balanceAmount;
$balanceDate= $quoteJson->creditProfile[0]->tradeline[0]->balanceDate;
$subscriberName= $quoteJson->creditProfile[0]->tradeline[0]->subscriberName;

foreach($quoteJson as $mydata) {                                                                                                  
   // echo $mydata->name . "<br>";                                                                                                          
    foreach($mydata[0]->addressInformation as $key => $value)                                                                                       
    {                                                                                                                                     
        $api_city= $value->city . "<br>";                                                                                                    
        //echo $value->Description . "<br>";                                                                                            
    } 
    
    
    
}

// $icon0     = $parsed_json->forecast->txt_forecast->forecastday[0]->icon;

if($score<10){
    $color='orange';
    $score_text= 'Not Available';
    
}

if($score>400 && $score<501){
    $color='orange';
    $score_text = 'Bad';
}

if($score>500 && $score<601){
    $color='orange';
    $score_text = 'Bad';
}

if($score>600 && $score<661){
    $color='Purple';
    $score_text = 'Fair';
}

if($score>660 && $score<781){
    $color='lime';
    $score_text = 'Good';
}

if($score>780 && $score<1000){
    $color='green';
    $score_text = 'Excellent';
}

// ...*********************************************EXperian API Score End *******************************...//

?>





<?php

ob_start();


// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Crunch Apple');
$pdf->SetTitle('LSBANKING');
$pdf->SetSubject('');
$pdf->SetKeywords('');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();

//$pdf->MultiCell(70, 50, $key1 , 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);

$pdf->SetFont('helvetica', '', 10);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// set style for barcode

 

 $html = '

<br><div style="line-height:7px"><h1 style="text-align:center">Credit Report</h1>
<span style="text-align:center"> Lender: Optima Financial Solutions Inc 4645 Van Nuys Blvd #202 Sherman Oaks, CA 91403</span>
</div>
 
<h2 style="text-align:center;">Score : <span style="color:'.$color.'">'.$score.' ('.$score_text.')</span></h2>


 <br><br>
        <table style="">
   <tr>
<td style="background-color: #ccc;border-top: 1px solid balck; border-bottom:  1px solid black;" height="20"><b style="text-align:left">User Information:</b></td>
</tr>
  <tr>
    <td style="border-top: 0.5px solid balck; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Name:</span>'.$name.'</td>
  </tr>
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Number:</span>'.$customer_phone.'</td>
  </tr>
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:   0.5px solid black;" height="30"><span style="font-weight:bold">Bate of Birth:</span>'.$dob.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Address:</span>'.$address.'</td>
  </tr>
 
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">City:</span>'.$cityy.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">State:</span>'.$statee.'</td>
  </tr>
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Zip Code:</span>'.$zipp.'</td>
  </tr>
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">SSN:</span>'.$ssn.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Score Factor:</span>'.$score_factor.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Account Number:</span>'.$api_accountt.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Balance Amount:</span>'.$balanceAmount.'</td>
  </tr>
  
   <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Balance Date:</span>'.$balanceDate.'</td>
  </tr>
 
   <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Subscriber Name:</span>'.$subscriberName.'</td>
  </tr>
  <br><br>
</table>
<br><br><br>

 <table style="">
   <tr>
<td height="20"></td>
</tr>
 
</table>

';

$pdf->writeHTML($html,25,30); 


 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

$pdf->Output('Case.pdf', 'I');

$pdf_data = ob_get_contents();
$file_name = $id."page_1";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>