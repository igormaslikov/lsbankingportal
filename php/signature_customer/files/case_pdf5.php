<?php
$id=$_GET['id'];
?>


<?php
include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from loan_initial_banking where email_key='$iddd' "); 

while($row1 = mysqli_fetch_array($sql1)) {

$mail_key=$row1['email_key'];
$signed_status=$row1['sign_status'];

$creation_datee=$row1['creation_date'];
$var = "$creation_datee";
$creation_date= date("m-d-Y", strtotime($var) );

$fnd_id=$row1['user_fnd_id'];
$loan_id_bor=$row1['loan_id'];
$type_of_card=$row1['type_of_card'];
$card_number=$row1['card_number'];
$card_exp_date=$row1['card_exp_date'];

$bank_name=$row1['bank_name'];
$routing_number=$row1['routing_number'];
$account_number=$row1['account_number'];

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;
}



//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    
    $payment_datee=$row_loan['payment_date'];
		 $var = "$payment_datee";
	$payment_date= date("m-d-Y", strtotime($var) );
   
    
     
    $payoff=$row_loan['amount_of_loan'];
    
   
    
  if($payoff== '$50'){
        $payoff= '$8.83' ;
        
        }
        else if($payoff== '$100')
        {
             $payoff= '$17.65' ;
        }
        
        else if($payoff== '$150')
        {
             $payoff= '$26.47' ;
        }
        
        else if($payoff== '$200')
        {
             $payoff= '$35.30' ;
        }
        
        else if($payoff== '$255')
        {
             $payoff= '$45.00' ;
        }  
        
        
        
        
}




$sql2=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 

while($row2 = mysqli_fetch_array($sql2)) {

$f_name=$row2['first_name'];
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
	$date1="$creation_date";
	$date2="$payment_date";
	function dateDiff($date1, $date2) 
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}
	$dateDiff= dateDiff($date1, $date2);
// echo "Days".$dateDiff."<br>";


$payoff=str_replace('$', '', $payoff);

$amount_of_loan=str_replace('$', '', $amount_of_loan);
$total_amount= $payoff+$amount_of_loan;
$apr=$payoff/$amount_of_loan;
$apr_total=$apr*365;
$anual_pr=($apr_total/$dateDiff)*100;
	//echo $anual_pr;

?>



<?php

$id=$_GET['id'];
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

$pdf->SetFont('helvetica', '', 9);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// set style for barcode
$style = array(
	'border' => false,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

// set style for barcode
$style = array(
	'border' => 0,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

 $html = '
<h1 style="text-align:center"> <span style="text-decoration:underline">PRIVACY NOTICE</span><br>
Pacifica Finance Group</h1>
 
 
 <table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 15.8733%; text-align:center; background-color:black;color:white"><br><br>FACTS<br></td>
<td style="width: 83.1267%; text-align:center"><br><br>WHAT DOES Pacifica Finance Group DO WITH YOUR PERSONAL INFORMATION?<br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>WHY ?<br></td>
<td style="width: 83.1267%;"><br><br>Financial Companies choose how they share your personal information. Federal law gives consumers the right to limit some
but not all sharing. Federal law also requires us to tell you how we collect, share, and protect your personal
information. Please read this notice carefully to understand what we do. <br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br><br>WHAT ?<br></td>
<td style="width: 83.1267%;"><br><br>The types of personal information we collect and share depend on the product or service you have with us. This information
can include:<br><br>
• Social Security number and income<br>
• Account balances and payment history<br>
• Credit history and credit scores <br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>HOW ? <br></td>
<td style="width: 83.1267%;"><br><br>All financial companies need to share customer’s personal information to run their everyday business.<br>
In the section below, we list the reasons financial companies can share their customers’ personal information; the
reasons Pacifica Finance Group chooses to share; and whether you can limit this sharing. 
<br><br></td>
</tr>
</tbody>
</table>
 
<br><br>
<table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 60%; text-align:left; color:white; background-color:grey "><b>Reason we can share your personal information</b></td>
<td style="width: 20.1019%; text-align:center;background-color:grey; color:white"><b>Does Pacifica Finance Group
Share?</b></td>
<td style="width: 20.8981%; text-align:center;background-color:grey; color:white"><b>Can you limit this
sharing?</b></td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our everyday business purposes –</b><br>
such as to process your transactions, maintain your account(s), respond to court
orders and legal investigations, prevent or mitigate fraud, engage in corporate
transactions, or report to credit bureaus<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> Yes &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our marketing purposes –</b> <br>
to offer our products and services to you<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> Yes &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our marketing purposes –</b> <br>
to offer our products and services to you<br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We Dont Share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For joint marketing with other financial companies</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our affiliates’ everyday business purposes –</b> <br>
information about your transactions and experiences<br><br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our affiliates’ everyday business purposes –</b> <br>
information about your creditworthiness<br><br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our affiliates to market to you</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br>No &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><b>For non-affiliates to market to you</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br>NO</td>
<td style="width: 20.8981%;text-align:center"><br> We dont share</td>
</tr>
<tr>
<td style="width: 60%;"><br><b>Questions ? </b> &nbsp;</td>
<td colspan = "2" style="width: 20.1019%;">Please Call (747) 300-1542</td>
</tr>
</tbody>
</table>
<!-- DivTable.com -->

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

$file_name = $id."page_6";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>