<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
    
<?php




$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>CXP434</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml; charset=utf-8",
    "host: integration.decisionlogic.com",
    "postman-token: 656d6424-254f-0521-fabb-3e0fe463fc5d",
    "soapaction: https://integration.decisionlogic.com/GetMultipleReportDetailsFromRequestCode7"
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



$dom = new DOMDocument();
$dom->loadXML($response);
$hotels = $dom->getElementsByTagName('TransactionSummary5');
	
	echo "<table>
	<tr>
	 <td>Type Of Transaction</td>
	  <td>Payroll Description:Standard Employment Income</td>
	  <td></td>
	</tr>
  <tr>
    <th>Date</th>
    <th>Description</th>
    <th>Amount</th>
  </tr>";
	
foreach ($hotels as $hotel) {
	
	$TypeCode = $hotel->getElementsByTagName('TypeCodes')->item(0)->nodeValue;
    $Amount = $hotel->getElementsByTagName('Amount')->item(0)->nodeValue;
    $Description= $hotel->getElementsByTagName('Description')->item(0)->nodeValue;
	$TransactionDate= $hotel->getElementsByTagName('TransactionDate')->item(0)->nodeValue;
	
$payroll_date= date('m/d/Y',strtotime($TransactionDate));
	
	if($TypeCode == "py,dp")
	{
	
 echo"
 <tr>
    <td>$payroll_date</td>
    <td>$Description</td>
    <td>$$Amount</td>
  </tr>
 ";

        
	
	}
	
   
}
echo"</table>";
?>
</body>
</html>
