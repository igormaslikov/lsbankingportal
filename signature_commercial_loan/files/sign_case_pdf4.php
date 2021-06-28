<?php
$id = $_GET['id'];
$url_logo = "http://lsbankingportal.com/signature_commercial_loan/completed/";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd = $_GET['id'];
echo "idddd" . $iddd;

//echo "key is".$mail_key;

$sql1 = mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' ");

while ($row1 = mysqli_fetch_array($sql1)) {

  $mail_key = $row1['email_key'];
  $signed_status = $row1['sign_status'];

  $creation_datee = $row1['creation_date'];

  $timestamp = strtotime($creation_datee);
  $creation_date = date("m-d-Y", $timestamp);


  $fnd_id = $row1['user_fnd_id'];
  $loan_id_bor = $row1['loan_id'];
  $type_of_card = $row1['type_of_card'];
  $card_number = $row1['card_number'];
  $card_exp_date = $row1['card_exp_date'];

  $bank_name = $row1['bank_name'];
  $routing_number = $row1['routing_number'];
  $account_number = $row1['account_number'];

  $cvv_number = $row1['cvv_number'];

  $img_signed = $row1['signed_pic'];

  $result_sig = $url_logo . '/doc_signs/' . $img_signed;
}


//echo "ID is".$loan_id;


$sql_loan = mysqli_query($con, "select * from tbl_commercial_loan where loan_create_id= '$loan_id_bor' ");

while ($row_loan = mysqli_fetch_array($sql_loan)) {


  $principal_f = $row_loan['amount_of_loan'];
  $principal = number_format($principal_f, 2);
  $payment_date = $row_loan['payment_date'];
  $interest_rate_f = $row_loan['loan_interest'];
  $interest_rate = number_format($interest_rate_f, 2);
  $timestamp = strtotime($payment_date);
  $payment_date = date("m-d-Y", $timestamp);

  $creation_date = $row_loan['creation_date'];

  $timestamp = strtotime($creation_date);
  $creation_date = date("m-d-Y", $timestamp);

  $created_by = $row_loan['created_by'];
  $contract_fee=$row_loan['contract_fee'];
}

$sql_loan_settings = mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'");

while ($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

  $loan_fee = $row_loan_settings['loan_fee'];
  $loan_payable = $row_loan_settings['payoff_amount'];
}

$calculation = (($loan_fee / $amount_of_loan) / ($datediff / 365) * 10000) / 100;
$calculation = round($calculation, 2);
$anual_pr = $calculation;


$sql2 = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' ");
while ($row2 = mysqli_fetch_array($sql2)) {
  $ff_name = $row2['first_name'];
  $l_name = $row2['last_name'];
  $f_name = $ff_name . ' ' . $l_name;
  $address = $row2['address'];
  $city = $row2['city'];
  $state = $row2['state'];
  $zip = $row2['zip_code'];
  $mobile_number = $row2['mobile_number'];
  $address = $row2['address'];
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



$sql_installment = mysqli_query($con, "select payment_date from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor ORDER by id desc limit 1");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $last_payment_date =  $row_installment['payment_date'];
}


$creation_date_array = explode("-",$creation_date);
$last_payment_date_array = explode("-",$last_payment_date);

$cd = strtotime($creation_date_array[2]."-".$creation_date_array[0]."-".$creation_date_array[1]);
$ld = strtotime($last_payment_date_array[2]."-".$last_payment_date_array[0]."-".$last_payment_date_array[1]);
$count_days = floor(abs($ld - $cd) / 60 / 60 / 24);
$anual_pr = ($contract_fee + $interest_rate_f) / $principal_f / $count_days * 365 * 100;
$anual_pr = number_format($anual_pr, 2);
?>





<?php

$id = $_GET['id'];
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


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
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
  'fgcolor' => array(0, 0, 0),
  'bgcolor' => false, //array(255,255,255)
  'module_width' => 1, // width of a single module in points
  'module_height' => 1 // height of a single module in points
);

// set style for barcode
$style = array(
  'border' => 0,
  'vpadding' => 'auto',
  'hpadding' => 'auto',
  'fgcolor' => array(0, 0, 0),
  'bgcolor' => false, //array(255,255,255)
  'module_width' => 1, // width of a single module in points
  'module_height' => 1 // height of a single module in points
);

$html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br><br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">' . $f_name . '</span><br>
Loan Number/Numero de Prestamo: <span style="text-decoration:underline">' . $loan_id_bor . '</span><br>
Date/Fecha: <span style="text-decoration:underline">' . $creation_date . '</span>

<h1 style="text-align:center">
Loan Agreement/Contrato del Prestamo
</h1>


<table>
<tbody>
<tr>
  <td style="vertical-align:baseline;text-align:justify;width:47.5%;">
    <ul>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Promise to Pay:</b><span style="font-size:7px;">In return of the loan you receive from us, you promise to pay <span style="text-decoration:underline">$' . $principal . '</span>, plus interest in accordance with the “Interest” section of this Agreement below, to LS Financing, Inc, it’s successors and assigns. You will pay these amounts in U.S. dollars.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Personal Guarantee: </b><span style="font-size:7px;">This contract has a personal guarantee from the borrower and co-borrower.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Interest: </b><span style="font-size:7px;">We will charge you interest from the date of advance until the principal, together with interest, at the rate of <span style="text-decoration:underline">' . $anual_pr . '%</span> per year, is paid. We will calculate interest based on a year of 365 days and the actual number of days elapsed. This interest rate is the rate you will pay before and after any event of default. If any law that applies to this Agreement and sets maximum loan charges is finally interpreted so that the interest or other loan charges collected or to be collected in connection with this loan exceed the permitted limits, then: (i) we will reduce the loan charge by the amount necessary to reduce the charge to the permitted limit; and (ii) we will refund any sums already collected from you that are greater than the permitted limits. We may choose to make this refund by reducing the principle you owe under this Agreement or by making a direct payment to you.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Repayment and Maturity Date: </b><span style="font-size:7px;">You will repay the principal and interest on this loan as showing in the payment schedule, which is part of the Truth-in-Lending Disclosure statement printed above. You understand that if any of your payments are received by us on dates other than the due dates or if any additional charges are added to your loan balance under the provisions of this Agreement, your actual final payment will likely be different than the amount shown above, and you agree to pay the actual payment amount. You will make the payments as described above until you have paid all the principal and interest and any other charges that you may owe under this Agreement. Notwithstanding any other provision of this Agreement, you will pay any and all amounts outstanding on <span style="text-decoration:underline">' . $last_payment_date . '</span> (the “Maturity Date”).</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Application of Payments: </b><span style="font-size:7px;">Payments will be applied first to delinquency fees and/or other charges added to the loan, next to any accrued but unpaid interest, and finally to principal.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Default and Acceleration of Payments:. </b><span style="font-size:7px;">You will be in default if you fail to make a payment on time. When you are in default, we may require, without notice or demand, that you repay the entire amount of the loan at once. (This is called “acceleration”) even if, at a time when you are in default, we do not require you to pay immediately in full as described above, we will still have the right to do so at any other time that you are in default.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Pre-payments and Payoff: </b><span style="font-size:7px;">This loan has no prepayments penalty. Repaying your loan early will lower your borrowing costs by reducing the amount of interest you will pay. However, if you pay off early, you will not be entitled to a refund of any part of the prepaid finance charge (administrative fee).</span></li>
    </ul>
  </td>
  <td style="width:5%"></td>


  <td style="vertical-align:baseline;text-align:justify;width:47.5%">
    <ul>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Promesa de pago:</b><span style="font-size:7px;">A cambio del préstamo que usted reciba de nosotros usted promete pagar <span style="text-decoration:underline">$' . $principal . '</span>de capital, mas intereses, calculado de conformidad con la sección “Intereses” más abajo, a LS Financing, Inc y sus causa habientes y cesionarios. Usted pagara estos importes en dólares estadounidenses.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Garantía Personal: </b><span style="font-size:7px;">Este contrato tiene una garantía personal del prestatario y el co-prestatario.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Intereses: </b><span style="font-size:7px;">Se cargaran intereses a partir de la fecha del anticipo hasta que se pague el capital, mas todos los intereses, a razón del <span style="text-decoration:underline">' . $anual_pr . '%</span> anual. Calcularemos los intereses con base en un ano de 365 días y el número real de días transcurridos. Esta tasa de interés es la tasa que usted para antes y después de cualquier incumplimiento. Si una ley, que se aplique a este contrato y que establezca cargos de préstamos máximos, es interpretada de manera que los intereses u otros cargos de préstamo cobrados o por cobrar en relación con este préstamo exceden los límites permitidos entonces; (i) restauraremos a dicho cargo o cuota de préstamo la cantidad necesaria para que el caro llegue al límite permitido, y (ii) le reembolsaremos cualquier importe que ya se la haya cobrado y hará excedido los límites permitidos. Podremos optar por efectuar este reembolso mediante la reducción del capital que usted deba según este contrato, o realizando un pago directo a usted.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Pago y fecha de vencimiento: </b><span style="font-size:7px;">Usted pagara el capital y los intereses de este préstamo en la forma indicada en el Calendario de pagos, que forma parte de la Declaración Informativa de Veracidad en los Préstamos impresa arriba. Usted comprende que, si recibimos cualquiera de sus pagos en una fecha destina a la fecha de vencimiento, o si se aplican cargos adicionales al saldo de su cuenta de conformidad con los términos de este contrato, es probable que su pago real final sea distinto al importe señalado arriba, y usted conviene en pagar el monto de pago real. Usted realizara los pagos en la forma descrita arriba hasta que haya pagado todo el capital u los intereses y demás caros que adeude conforme a este contrato. No obstante las demás disposiciones de este contrato, usted pagara todos los importes insolutos en <span style="text-decoration:underline">' . $last_payment_date . '</span> (la fecha de Vencimiento”).</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Aplicación de pagos:</b><span style="font-size:7px;">Los pagos se aplicaran primero a los cargos por morosidad y demás cargos sumados al préstamo, luego a los intereses acumulados pero no pagados, y por ultimo al capital.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Incumplimiento y aceleración del pago: </b><span style="font-size:7px;">Usted estará en estado de incumplimiento si no realiza un pago puntualmente. Si usted está en estado de incumplimiento, podremos requerir, sin necesidad de aviso o demanda, que usted pague de inmediato el monto total del préstamo. (eso se conoce como “aceleración de pago”). Si usted esta es estado de incumplimiento y no exigimos el pago inmediato y total, tal como se describe arriba, nos reservamos el derecho de hacerlo en cualquier otro momento que usted se encuentre en estado de incumplimiento.</span></li>
      <li style="padding-bottom:0.5em;text-align:justify"><b style="font-size:7px;">Pagos adelantados o liquidación de deuda:</b><span style="font-size:7px;">Este préstamo no tiene penalidad por prepago.  Al pagar su préstamo por adelantado bajaras sus cargos de financiamiento mediante la reducción de la cantidad de interés que pagar. Sin embargo, si liquida el préstamo en forma adelantada, no tendrá derecho a un reembolso total o parcial del cargo de financiamiento pre pagado (tarifa de procesamiento).</span></li>
    </ul>	
  </td>
</tr>

</tbody>
</table>

Initials/Iniciales:<img src="https://lsbankingportal.com/signature_commercial_loan/completed/doc_signs/"'.$img_signed.'" alt="" style="height:300%" align="left"/>

';

$pdf->writeHTML($html,25,30); 

$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_5";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name = $id . "page_5";
$path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
$pdf->Output($path, 'F');

//============================================================+
// END OF FILE
//============================================================+

?>