<?php
$id=$_GET['id'];

?>


<?php
$id=$_GET['id'];
include_once 'dbconnect.php';
include_once 'dbconfig.php';




$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$id' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
   
   $loan_id=$row_loan['loan_id'];
    $user_fnd_id=$row_loan['user_fnd_id'];
    $amount_of_loan=$row_loan['amount_of_loan'];
    $amount_of_loan=number_format($amount_of_loan, 2);
    $payment_date=$row_loan['payment_date'];
    $contract_date=$row_loan['contract_date'];
     $var = "$payment_datee";
//$payment_date= date("m-d-Y", strtotime($var) );
$loan_fee = $row_loan['loan_fee'];
$loan_fee = number_format($loan_fee, 2);
$loan_payable = $row_loan['loan_total_payable'];
$loan_payable = number_format($loan_payable, 2);

    
    // echo "LOAN Amount".$amount_of_loan;
    $date1=$creation_date;
	$date2=$payment_date;
//	function dateDiff($date1, $date2) 
//	{
//	  $date1_ts = strtotime($date1);
//	  $date2_ts = strtotime($date2);
//	  $diff = $date2_ts - $date1_ts;
//	  return round($diff / 86400);
//	}
//	$dateDiff= dateDiff($date1, $date2);
// echo "Days".$dateDiff."<br>";

$diff_creation_date = strtotime($creation_date);
$diff_payment_date = strtotime($payment_date);
$datediff =  $diff_payment_date - $diff_creation_date;
$datediff = round($datediff / (60 * 60 * 24));


  $calculation = (($loan_fee/$amount_of_loan)/($datediff/365) * 10000) / 100;
  
  $calculation = round($calculation, 2);
  
//$calculation = $loan_fee/$amount_of_loan;
//$calculation_1 = $datediff/365;
//$calculation_1 = $calculation_1*10000;
//$calculation_1  = $calculation_1/100;

  //$calculation = round($calculation, 2);

	
	$anual_pr= $calculation;
    
 }


$sql2=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 
while($row2 = mysqli_fetch_array($sql2)) {
$first_name=$row2['first_name'];
$l_name=$row2['last_name'];
$f_name= $first_name.' '.$l_name;
$address=$row2['address'];
$city=$row2['city'];
$state=$row2['state'];
$zip=$row2['zip_code'];
$mobile_number=$row2['mobile_number'];
$address=$row2['address'];

}
    $search_dir = "doc_signs/$result";
   $images = glob("$search_dir/*.png");
   sort($images);

   // Image selection and display:

   //display first image
   if (count($images) > 0) { // make sure at least one image exists
       $img = $images[0]; // first image
      // echo "<img src='$img' height='150' width='150' /> ";
   } else {
       // possibly display a placeholder image?
   }
?>

<?php

$id=$_GET['id'];

include 'dbconnect.php';
include 'dbconfig.php';

$sql_source=mysqli_query($con, "select * from source_income where user_fnd_id= '$user_fnd_id'"); 

while($row_source = mysqli_fetch_array($sql_source)) {


$net_check_amount=$row_source['net_check_amount'];
$how_paid=$row_source['pay_period'];
$last_pay_date=$row_source['last_pay_date'];
$next_pay_date=$row_source['next_pay_date'];

}

?>

<?php

$id=$_GET['id'];

include 'dbconnect.php';
include 'dbconfig.php';

$sql_acount=mysqli_query($con, "select * from loan_initial_banking where user_fnd_id= '$user_fnd_id'"); 

while($row_acount = mysqli_fetch_array($sql_acount)) {


$account_number=$row_acount['account_number'];
}
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

<br><div style="line-height:7px"><h1 style="text-align:center">LOAN SUMMARY</h1>
<span style="text-align:center"> Lender: Pacifica Finance Group 4645 Van Nuys Blvd #202 Sherman Oaks, CA 91403</span><br><br>
</div>
Account Number:   :  '.$account_number.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Contract Date : '.$contract_date.' <br>
<br>
Borrower    : '. $f_name.'<br><br>


 <br><br>
        <table style="">
   <tr>
<td style="background-color: #ccc;border-top: 1px solid balck; border-bottom:  1px solid black;" height="20"><b style="text-align:left">Payment Information:</b></td>
</tr>
  <tr>
    <td style="border-top: 0.5px solid balck; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Amount Due:</span>'.$net_check_amount.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:   0.5px solid black;" height="30"><span style="font-weight:bold">Last Payment Due:</span>'.$last_pay_date.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Next Payment Due:</span>'.$next_pay_date.'</td>
  </tr>
 
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Payoff (as of 09/06/2019):</span>'.$loan_payable.'</td>
  </tr>
  
  <tr>
    <td style="border-top: 0.5px solid black; border-bottom:  0.5px solid black;" height="30"><span style="font-weight:bold">Payment Frequency Preference:</span>'.$how_paid.'</td>
  </tr><br><br>
</table>
<br><br><br>

 <table style="">
   <tr>
<td height="20"><b style="text-align:left;color:red;">COLLATERAL:</b></td>
</tr>
  <tr>
    <td style="border-top: 0.5px solid balck;" height="30"><span style="font-weight:bold">Information:</span></td>
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