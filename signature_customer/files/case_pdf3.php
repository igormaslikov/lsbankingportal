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

    //$timestamp = strtotime($card_exp_date);
    //$card_exp_date= date("m-Y", $timestamp);

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

$ff_name=$row2['first_name'];
$l_name=$row2['last_name'];
$f_name= $ff_name.' '.$l_name;
$address1=$row2['address'];
$city=$row2['city'];
$state=$row2['state'];
$zip=$row2['zip_code'];
$mobile_number=$row2['mobile_number'];
$address= $address1.' '.$city.' '.$state.' '.$zip;




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
$anual_prr=($apr_total/$dateDiff)*100;
	//echo $anual_pr;
	$anual_pr= number_format((float)$anual_prr, 2, '.', '');

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

$pdf->SetFont('helvetica', '', 11);

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

 $html = '<br><div style="line-height:7px"><h1>Optima Financial Solutions Inc</h1>
<span style="font-size:8px">11306 EAST 183RD ST SUITE 305A CERRITOS, CA 90703</span><br><br>
</div>
 <br>
 
 
 Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br>
 &nbsp;Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span><br>
 
 <br>
 <h2 style="text-align:center"><u>Debit Card Authorization Form</u></h2> 
<span style="text-align:center">11306 EAST 183RD ST SUITE 305A CERRITOS, CA 90703</span><br><br>

Authorization to make payments on my <b>Optima Financial Solutions Inc</b> Loan # <span style="text-decoration:underline">'.$loan_id_bor.'</span> on continuing basis using the
Debit Card described below and the terms of this Loan, unless otherwise instructed in writing by the Debit Card
Holder.<br><br>
Autorización para hacer pagos en mi cuenta de <b>Optima Financial Solutions Inc</b> prestamo # <span style="text-decoration:underline">'.$loan_id_bor.'</span> sobre la base
continua utilizando la tarjeta de Débito que se describe a continuación y los términos de este préstamo , a menos
que se indique lo contrario por escrito por el titular de la Tarjeta de Débito .


<br><br>

<table style="width: 100%; text-align:left; " border="1">
<tbody>
<tr>
<td style="padding-left : 100px">
<br><br>
Type / Tipo: '.$type_of_card.'<br><br>
 Debit Card Number: ************'.substr($card_number,-4).'<br><br>
 Expiration Date: '.$card_exp_date.'<br><br>
 Debit Card Billing Address:<br><br>

 '.$address.'<br>
 <br><br>
Telephone: '.$mobile_number.' <br><br>


</td>
</tr>
</tbody>
</table>


<br><br><br>
 I, '.$f_name.', the undersigned hereby states that the above described Debit Card
is in my name and that i authorize its charge to Optima for full or partial payments.
<br><br>
 Yo , '.$f_name.', el abajo firmante de la tarjeta de crédito en mi nombre descrita
en la parte superior y que autorizo su cargos a Optima para los pagos totales o parciales. <br><br><br>

____________________________________________________<br><br>
<b>Cardholders Signature/Firma del Titular de la Tarjeta<br>
Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span> </b>


';

$pdf->writeHTML($html,25,30); 


 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

$file_name = $id."page_4";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path,'F');

//============================================================+
// END OF FILE
//============================================================+

?>