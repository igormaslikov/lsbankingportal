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
  $interest_rate = $row_loan['loan_interest'];
  $interest_rate = number_format($interest_rate, 2);
  $timestamp = strtotime($payment_date);
  $payment_date = date("m-d-Y", $timestamp);
  $totLoan = number_format(
    $row_loan['amount_of_loan'] + $row_loan['loan_interest'],
    2
  );
  $creation_date = $row_loan['creation_date'];

  $timestamp = strtotime($creation_date);
  $creation_date = date("m-d-Y", $timestamp);

  $var = "$payment_datee";
  //$payment_date= date("m-d-Y", strtotime($var) );
  //$loan_fee = $row_loan['loan_fee'];
  //$loan_fee = number_format($loan_fee, 2);
  //$loan_payable = $row_loan['loan_total_payable'];
  //$loan_payable = number_format($loan_payable, 2);


  // echo "LOAN Amount".$amount_of_loan;
  $date1 = $creation_date;
  $date2 = $payment_date;
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





  $created_by = $row_loan['created_by'];
  $installment_plan = $row_loan['installment_plan'];
  $contract_fee=$row_loan['contract_fee'];
}

// $sql_loan_settings = mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'");

// while ($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

//   $loan_fee = $row_loan_settings['loan_fee'];
//   $loan_payable = $row_loan_settings['payoff_amount'];
// }

// $calculation = (($loan_fee / $amount_of_loan) / ($datediff / 365) * 10000) / 100;
// $calculation = round($calculation, 2);
// $anual_pr = $calculation;


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

// $sql_installment = mysqli_query($con, "select * from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor");
// while ($row_installment = mysqli_fetch_array($sql_installment)) {
//   $payment_install = $row_installment['payment'];
//   $payment_date_install = $row_installment['payment_date'];
//   $timestampp = strtotime($payment_date_install);
//   $payment_date_installl = date("m-d-Y", $timestampp);
//   $payment_install = number_format($payment_install, 2);
// }


$sql_installment = mysqli_query($con, "select payment, payment_date from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor ORDER by id asc limit 1");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $fitst_payment = $row_installment['payment'];
  $fitst_payment_date = $row_installment['payment_date'];
}

$sql_installment = mysqli_query($con, "select payment, payment_date from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor ORDER by id desc limit 1");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $last_payment = $row_installment['payment'];
  $last_payment_date =  $row_installment['payment_date'];
}

$sql_installment = mysqli_query($con, "select count(id) as count from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $count_payments = $row_installment['count'];
}

$second_payment = 0;

if ($count_payments > 2) {
  $count_payments = $count_payments - 2;
  $sql_installment = mysqli_query($con, "select payment from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor ORDER by id asc limit 2");
  while ($row_installment = mysqli_fetch_array($sql_installment)) {
    $second_payment = $row_installment['payment'];
  }
}

$count_payments = $count_payments <= 2 ? "" : $count_payments;
$second_payment = $second_payment == 0 ? "": $second_payment;

$sql_installment = mysqli_query($con, "SELECT count(loan_id) as count, loan_create_id FROM tbl_commercial_loan WHERE user_fnd_id = $fnd_id order by loan_id desc limit 2");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $count = $row_installment['count'];
  $previous_loan_id = $row_installment['loan_create_id'];
}

$in_hand = 0;
if($count>1){
  $sql_installment = mysqli_query($con, "SELECT SUM(payment) as in_hand FROM `tbl_commercial_loan_installments` where `loan_create_id`= $previous_loan_id and `status` = 0 order by id desc");
  while ($row_installment = mysqli_fetch_array($sql_installment)) {
    $in_hand = $row_installment['in_hand'];
  }
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

$pdf->SetFont('helvetica', '', 8.25);

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
      <br>
      <img src="images/Money-Line-Logo.JPG" alt="" style="height:400%" align="left"/>
      <br>
      <span><b>4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</b></span>
        <div style="text-align: center;">
          <h1>Pagare de Prestamo Comercia</h1>
        </div>
      <b>Numero de Contrato:</b><span>' . $loan_id_bor . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha:</b><span>_______________</span>
      <br><br>
      <b>Prestatario:</b><span>' . $f_name . '</span><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Co-prestatario:</b><span>____________________________</span>
      <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$address.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>____________________________</span>
      <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$city.', '.$state.' '.$zip.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>____________________________</span>
      <br><br>

      <table style="width: 100%;" border="1">
        <tbody>
          <tr>
            <td colspan="6" style="text-align: center;"><b>DECLARACIONES INFORMATIVAS DE VERACIDAD EN LOS PRESTAMOS</b></td>
          </tr>
          <tr>
            <td style=" text-align: center;">
              <div>
                <b>TASA DE PORCENTAJE ANUAL</b>
              </div>
              <div>
                <span>El costo del credito expresado como tasa anual</span>
              </div>
              <div>
                <span>' . $anual_pr . '%</span>
              </div>
            </td>
            <td colspan="2" style=" text-align: center;">
              <div>
                  <b>MONTO FINANCIADO</b>
                </div>
                <div>
                  <span>Cantidad de credito provista a usted o en su nombre. </span>
                </div>
                <div>
                  <span>$' . $principal . '</span>
                </div>
            </td>
            <td style=" text-align: center;">
              <div>
                  <b>CARGOS DE FINANCIAMIENTO</b>
                </div>
                <div>
                  <span>El importe en dolares que le costara el credito</span>
                </div>
                <div>
                  <span>$' . $interest_rate . '</span>
                </div>
            </td>
            <td colspan="2" style=" text-align: center;">
              <div>
                  <b>TOTAL DE PAGOS</b>
                </div>
                <div >
                  <span>El monto que Habra pagado despues de haber efectuado todos los pagos programados.</span>
                </div>
                <div>
                  <span>$' . $totLoan . '</span>
                </div>
            </td>
          </tr>
          <tr>
            <td rowspan="4" style=" text-align: center;"><b>Calendario de Pagos:</b></td>
            <td style=" text-align: center;"><b>Numero de Pagos</b></td>
            <td style=" text-align: center;"><b>Cantidad del Pago</b></td>
            <td colspan="3" style=" text-align: center;"><b>Cuando Vence el Pago</b></td>
          </tr>
          <tr>
            <td style=" text-align: center;"><br><br>1<br></td>
            <td style=" text-align: center;"><br><br>'.$fitst_payment.'<br></td>
            <td colspan="3" style=" text-align: left;"><br><br>Pago  '.$installment_plan.', empezando el  ' .$fitst_payment_date.'.<br></td>
          </tr>
          <tr>
            <td style=" text-align: center;">' . $count_payments . '</td>
            <td style=" text-align: center;">'.$second_payment.'</td>
            <td colspan="3" style=" text-align: left;" >Pagos ' . $installment_plan . '.</td>
          </tr>
          <tr>
            <td style=" text-align: center;">Ultimo Pago de </td>
            <td style=" text-align: center;">'.$last_payment.'</td>
            <td colspan="3" style=" text-align: left;">Que vence en  ' . $last_payment_date . '.</td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: left; ">
              <br><br>
              <span><b>Pagos Adelantados: </b>  Usted puede liquidar su prestamo en cualquier momento. Si usted paga por adelantado, no tendra que pagar penalidad.</span><br><br>
              <span><b>Cargo por Incumplimiento: </b> Si un pago se hace con mas de 10 dias de retraso, se le cobrara $10 </span> <br><br>
              <span><b>Cargo de Originación:</b> Se agregará un cargo prepago de financiamiento por $ 75 para cubrir el costo de procesar su solicitud y el acuerdo.</span> <br>
            </td>
            <td style=" text-align: center;">
                <br><br>
                <span><b>Licencia del Prestamista:</b></span><br><br>
                <span> 60DBO-88277</span>
            </td>
          </tr>
        </tbody>
      </table>
      <br><br>
      <table style="width: 100%;" border="1">
      <tbody>
        <tr>
          <td>
            <div style="text-align:center"><b style="text-align: center;">Itemization of the Amount Financed</b></div>
            <div style="text-align:left">
              <span>Cantidad entregada a usted directamente……………………………………………………………………… $' . ($principal_f - $in_hand) . '</span><br>
              <span>Cantidad pagada por su préstamo existente con nosotros……………………………………………………+$'.$in_hand.' </span><br>
              <span>Monto financiado…………………………………………………………………………………………………...=$'.$principal_f.' </span><br>
              <span>Cargo por financiamiento pagado por adelantado (Tarifa Administrativa)…………………………………...+$'.$contract_fee.'  </span><br>
              <span>Capital…………………………………………………………………………………………………………….....=$'.($principal_f + $contract_fee).' </span><br>
            </div>
            
          </td>
        </tr>
      </tbody>
    </table>
      <div style="text-align: justify;">
      <p><b>Derecho del prestamista: </b><span> En caso de incumplimiento del prestatario, el prestamista puede declarar todo el saldo de capital impago en este Pagare de Prestamo Comercial y luego el prestatario pagará ese monto.
        </span></p>
       
        <p><b>Valor predeterminado del prestatario: </b> <span>El valor predeterminado del prestatario incluye, entre otros, los siguientes: procedimientos de quiebra voluntarios o involuntarios en los que el prestatario es nombrado deudor; cualquier gravamen o gravamenes registrado sobre la propiedad actual del Prestatario, como se menciona anteriormente, ya sea voluntario, involuntario o mediante la operación de la ley.
        </span></p>
        
        <p><b>Cargo por articulo devuelto: </b><span>El prestatario pagará al prestamista una tarifa de $ 25.00 si el prestatario hace un pago al  Pagare de Prestamo Comercial  y el cheque o  cargo con autorizacion previa con la que el prestatario paga es deshonrado despues. 
        </span></p>
        
        <p><b>Honorarios de abogados; Gastos: </b><span>El prestamista puede pagar aquí o pagar a otra persona para que le ayude a cobrar este Pagare de Prestamo Comercial si el prestatario no paga. El prestatario le pagará al prestamista ese monto. Esto incluye, sujeto a cualquier límite bajo la ley aplicable, los honorarios del abogado del prestamista y los gastos legales del prestamista, ya sea que exista o no una demanda, incluidos los honorarios del abogado, los gastos por procedimientos de bancarrota (incluidos los esfuerzos para modificar o desocupar una suspensión o mandato judicial), y apelaciones. El prestatario también pagará los costos judiciales, además de todas las demás sumas previstas por la ley.
        </span></p>
        </div>
        <span style="text-align:right"><span>Iniciales:__________________________</span></span>
        
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
// $file_name = $id."page_3";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );


$file_name =$id. "page_3";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>