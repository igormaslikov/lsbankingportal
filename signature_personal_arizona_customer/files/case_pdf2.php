<?php
$id=$_GET['id'];
?>


<?php

include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from personal_loan_initial_banking where email_key='$iddd' "); 

while($row1 = mysqli_fetch_array($sql1)) {

$mail_key=$row1['email_key'];
$signed_status=$row1['sign_status'];



$fnd_id=$row1['user_fnd_id'];
$loan_id_bor=$row1['loan_id'];
$type_of_card=$row1['type_of_card'];
$card_number=$row1['card_number'];
$card_exp_date=$row1['card_exp_date'];

$creation_datee=$row1['creation_date'];
     $timestamp = strtotime($creation_datee);
     $creation_date= date("m-d-Y", $timestamp);
     
$bank_name=$row1['bank_name'];
$routing_number=$row1['routing_number'];
$account_number=$row1['account_number'];

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;
}


//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_personal_loans where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $amount_of_loan=number_format($amount_of_loan, 2);
    $payment_date=$row_loan['payment_date'];
    
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['creation_date'];
    
     $timestamp = strtotime($creation_date);
    $creation_date= date("m-d-Y", $timestamp);
    
//$loan_fee = $row_loan['loan_fee'];
//$loan_fee = number_format($loan_fee, 2);
//$loan_payable = $row_loan['loan_total_payable'];
//$loan_payable = number_format($loan_payable, 2);

    
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


  
  
//$calculation = $loan_fee/$amount_of_loan;
//$calculation_1 = $datediff/365;
//$calculation_1 = $calculation_1*10000;
//$calculation_1  = $calculation_1/100;

  //$calculation = round($calculation, 2);

	
    
 }

$sql_loan_settings=mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'"); 

while($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];
}
 
   $calculation = (($loan_fee/$amount_of_loan)/($datediff/365) * 10000) / 100;
    $calculation = round($calculation, 2);
  	$anual_pr= $calculation;




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

 $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br><br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br>
Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br>
Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <br><br><br>
<h1 style="text-align:center">
Loan Agreement/Contrato del Prestamo
</h1>

<table>
<tbody>
<tr>
<td><b style="font-size:8px;">???Promise to Pay:</b><span style="font-size:6px;">In return of the loan you receive from us, you promise to pay <u>$'.$amount_of_loan.'</u>, plus interest in accordance with the ???Interest??? section of this Agreement below, to LS Financing, Inc, it???s successors and assigns. You will pay these amounts in U.S. dollars.</span>
<br>
<b style="font-size:8px;">???Personal Guarantee:</b><span style="font-size:6px;"> This contract has a personal guarantee from the borrower and co-borrower.</span>
<br>

<b style="font-size:8px;">???Interest:</b><span style="font-size:6px;">We will charge you interest from the date of advance until the principal, together with interest, at the rate of _____________% per year, is paid. We will calculate interest based on a year of 365 days and the actual number of days elapsed. This interest rate is the rate you will pay before and after any event of default. If any law that applies to this Agreement and sets maximum loan charges is finally interpreted so that the interest or other loan charges collected or to be collected in connection with this loan exceed the permitted limits, then: (i) we will reduce the loan charge by the amount necessary to reduce the charge to the permitted limit; and (ii) we will refund any sums already collected from you that are greater than the permitted limits. We may choose to make this refund by reducing the principle you owe under this Agreement or by making a direct payment to you.</span>
<br>  
<b style="font-size:8px;">???Repayment and Maturity Date:</b><span style="font-size:6px;"> You will repay the principal and interest on this loan as showing in the payment schedule, which is part of the Truth-in-Lending Disclosure statement printed above. You understand that if any of your payments are received by us on dates other than the due dates or if any additional charges are added to your loan balance under the provisions of this Agreement, your actual final payment will likely be different than the amount shown above, and you agree to pay the actual payment amount. You will make the payments as described above until you have paid all the principal and interest and any other charges that you may owe under this Agreement. Notwithstanding any other provision of this Agreement, you will pay any and all amounts outstanding on <u>'.$payment_date.' </u> (the ???Maturity Date???).</span>
<br>
<b style="font-size:8px;">???Application of Payments:</b><span style="font-size:6px;"> Payments will be applied first to delinquency fees and/or other charges added to the loan, next to any accrued but unpaid interest, and finally to principal.</span>
<br>  
<b style="font-size:8px;">???Default and Acceleration of Payments:</b><span style="font-size:6px;">You will be in default if you fail to make a payment on time. When you are in default, we may require, without notice or demand, that you repay the entire amount of the loan at once. (This is called ???acceleration???) even if, at a time when you are in default, we do not require you to pay immediately in full as described above, we will still have the right to do so at any other time that you are in default.</span>
<br>

<b style="font-size:8px;">??? Pre-payments and Payoff:</b><span style="font-size:6px;">This loan has no prepayments penalty. Repaying your loan early will lower your borrowing costs by reducing the amount of interest you will pay. However, if you pay off early, you will not be entitled to a refund of any part of the prepaid finance charge (administrative fee).</span>
<br>

</td>
<td></td>

<td>

<b style="font-size:8px;">???Promesa de pago:</b><span style="font-size:6px;">A cambio del pr??stamo que usted reciba de nosotros usted promete pagar <u>$'.$amount_of_loan.'</u> de capital, mas intereses, calculado de conformidad con la secci??n ???Intereses??? m??s abajo, a LS Financing, Inc y sus causa habientes y cesionarios. Usted pagara estos importes en d??lares estadounidenses.</span>
<br>

<b style="font-size:8px;">???Garant??a Personal:</b><span style="font-size:6px;">Este contrato tiene una garant??a personal del prestatario y el co-prestatario.</span>
<br>


<b style="font-size:8px;">???Intereses:</b><span style="font-size:6px;">. Se cargaran intereses a partir de la fecha del anticipo hasta que se pague el capital, mas todos los intereses, a raz??n del _____________% anual. Calcularemos los intereses con base en un ano de 365 d??as y el n??mero real de d??as transcurridos. Esta tasa de inter??s es la tasa que usted para antes y despu??s de cualquier incumplimiento. Si una ley, que se aplique a este contrato y que establezca cargos de pr??stamos m??ximos, es interpretada de manera que los intereses u otros cargos de pr??stamo cobrados o por cobrar en relaci??n con este pr??stamo exceden los l??mites permitidos entonces; (i) restauraremos a dicho cargo o cuota de pr??stamo la cantidad necesaria para que el caro llegue al l??mite permitido, y (ii) le reembolsaremos cualquier importe que ya se la haya cobrado y har?? excedido los l??mites permitidos. Podremos optar por efectuar este reembolso mediante la reducci??n del capital que usted deba seg??n este contrato, o realizando un pago directo a usted.</span>
<br>

<b style="font-size:8px;">???Pago y fecha de vencimiento:</b><span style="font-size:6px;">Usted pagara el capital y los intereses de este pr??stamo en la forma indicada en el Calendario de pagos, que forma parte de la Declaraci??n Informativa de Veracidad en los Pr??stamos impresa arriba. Usted comprende que, si recibimos cualquiera de sus pagos en una fecha destina a la fecha de vencimiento, o si se aplican cargos adicionales al saldo de su cuenta de conformidad con los t??rminos de este contrato, es probable que su pago real final sea distinto al importe se??alado arriba, y usted conviene en pagar el monto de pago real. Usted realizara los pagos en la forma descrita arriba hasta que haya pagado todo el capital u los intereses y dem??s caros que adeude conforme a este contrato. No obstante las dem??s disposiciones de este contrato, usted pagara todos los importes insolutos en <u>$'.$payment_date.'</u> (la fecha de Vencimiento???).</span>
<br>

<b style="font-size:8px;">???Aplicaci??n de pagos:</b><span style="font-size:6px;">Los pagos se aplicaran primero a los cargos por morosidad y dem??s cargos sumados al pr??stamo, luego a los intereses acumulados pero no pagados, y por ultimo al capital.</span>
<br>

<b style="font-size:8px;">???Incumplimiento y aceleraci??n del pago:</b><span style="font-size:6px;">Usted estar?? en estado de incumplimiento si no realiza un pago puntualmente. Si usted est?? en estado de incumplimiento, podremos requerir, sin necesidad de aviso o demanda, que usted pague de inmediato el monto total del pr??stamo. (eso se conoce como ???aceleraci??n de pago???). Si usted esta es estado de incumplimiento y no exigimos el pago inmediato y total, tal como se describe arriba, nos reservamos el derecho de hacerlo en cualquier otro momento que usted se encuentre en estado de incumplimiento.</span>
<br>

<b style="font-size:8px;">???Pagos adelantados o liquidaci??n de deuda:</b><span style="font-size:6px;">Este pr??stamo no tiene penalidad por prepago.  Al pagar su pr??stamo por adelantado bajaras sus cargos de financiamiento mediante la reducci??n de la cantidad de inter??s que pagar. Sin embargo, si liquida el pr??stamo en forma adelantada, no tendr?? derecho a un reembolso total o parcial del cargo de financiamiento pre pagado (tarifa de procesamiento).</span>
<br>

</td>
</tr>

</tbody>
</table>
<br>

Initials/Iniciales__________________<br>

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

$file_name = $id."page_3";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>