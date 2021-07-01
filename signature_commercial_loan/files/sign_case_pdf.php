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

  $img_signed = $row1['initial_pic'];

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
  $totLoan = number_format(
    $row_loan['amount_of_loan'] + $row_loan['loan_interest'],
    2
  );
  $creation_date = $row_loan['creation_date'];

  $timestamp = strtotime($creation_date);
  $creation_date = date("m-d-Y", $timestamp);
  $total_payments = $row_loan['total_payments'];




  $created_by = $row_loan['created_by'];
  $daily_interest = $row_loan['daily_interest'];
  $installment_plan = $row_loan['installment_plan'];
  $contract_fee=$row_loan['contract_fee'];
}

// $sql_loan_settings = mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'");

// while ($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

//   $loan_fee = $row_loan_settings['loan_fee'];
//   $loan_payable = $row_loan_settings['payoff_amount'];
// }




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

// $diff_creation_date = strtotime($fitst_payment_date);
//   $diff_payment_date = strtotime($last_payment_date);
//   $datediff =  $diff_payment_date - $diff_creation_date;
//   $datediff = round($datediff / (60 * 60 * 24));

//   $calculation = ((($contract_fee + $row_loan['loan_interest'])  / $principal_f) / ($datediff / 365) * 10000) / 100;
//   $calculation = round($calculation, 2);
//   $anual_pr = $calculation;

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

switch ($installment_plan) {
	case "Weekly":
		$number_n = 52;
		break;
	case "Bi-Weekly":
		$number_n = 26;
		break;
	case "Monthly":
		$number_n = 12;
		break;
	default:
		$number_n = 52;
		break;
}

$anual_pr = $daily_interest * $number_n;
$anual_pr = number_format($anual_pr, 2);

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


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
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


$html = '
      <br>
      <img src="images/Money-Line-Logo.JPG" alt="" style="height:400%" align="left"/>
      <br>
      <span><b>4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</b></span>
        <div style="text-align: center;">
          <h1>COMMERCIAL LOAN PROMISSORY NOTE</h1>
        </div>
      <b>Contract N:</b><span style="text-decoration:underline">' . $loan_id_bor . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date:</b><span style="text-decoration:underline">' . $creation_date . '</span>
      <br><br>
      <b>Borrower:</b><span style="text-decoration:underline">' . $f_name . '</span><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Co-Borrower:</b><span>____________________________</span>
      <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$address.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>____________________________</span>
      <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$city.', '.$state.' '.$zip.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>____________________________</span>
      <br><br>

      <table style="width: 100%;" border="1">
        <tbody>
          <tr>
            <td colspan="6" style="text-align: center;"><b>TRUTH-IN-LENDING ACT DISCLOSURES</b></td>
          </tr>
          <tr>
            <td style=" text-align: center;">
              <div>
                <b>ANNUAL PERCENTAGE RATE</b>
              </div>
              <div>
                <span>The cost of your credit as a yearly rate.</span>
              </div>
              <div>
                <span>' . $anual_pr . '%</span>
              </div>
            </td>
            <td colspan="2" style=" text-align: center;">
              <div>
                  <b>AMOUNT FINANCED</b>
                </div>
                <div>
                  <span>The amount of credit provided to you or on your behalf.</span>
                </div>
                <div>
                  <span>$' . $principal . '</span>
                </div>
            </td>
            <td style=" text-align: center;">
              <div>
                  <b>FINANCE CHARGE</b>
                </div>
                <div>
                  <span>The dollar amount the credit will coast you.</span>
                </div>
                <div>
                  <span>$' . $interest_rate . '</span>
                </div>
            </td>
            <td colspan="2" style=" text-align: center;">
              <div>
                  <b>TOTAL OF PAYMENTS</b>
                </div>
                <div >
                  <span>The amount you will have paid after making all scheduled payments.</span>
                </div>
                <div>
                  <span>$' . $totLoan . '</span>
                </div>
            </td>
          </tr>
          <tr>
            <td rowspan="4" style=" text-align: center;"><b>Payment Schedule:</b></td>
            <td style=" text-align: center;"><b>Number of Payments</b></td>
            <td style=" text-align: center;"><b>Payment Amount</b></td>
            <td colspan="3" style=" text-align: center;"><b>When Payments Are Due</b></td>
          </tr>
          <tr>
            <td style=" text-align: center;"><br><br>1<br></td>
            <td style=" text-align: center;"><br><br>'.$fitst_payment.'<br></td>
            <td colspan="3" style=" text-align: left;"><br><br>Due '.$installment_plan.', beginning ' .$fitst_payment_date.'.<br></td>
          </tr>
          <tr>
            <td style=" text-align: center;">' . $count_payments . '</td>
            <td style=" text-align: center;">'.$second_payment.'</td>
            <td colspan="3" style=" text-align: left;" >Due ' . $installment_plan . '.</td>
          </tr>
          <tr>
            <td style=" text-align: center;">Last Payment of</td>
            <td style=" text-align: center;">'.$last_payment.'</td>
            <td colspan="3" style=" text-align: left;">Due on ' . $last_payment_date . '.</td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: left; ">
              <br><br>
              <span><b>Prepayment:</b> You may prepay your loan at any time. If you pay early, you will not have to pay a penalty.</span><br><br>
              <span><b>Late Charge:</b> If a payment is more than 10 days late, you will be charged $10. </span> <br><br>
              <span><b>Origination Fee:</b> A prepaid finance charge for $75 will de add to cover the cost of processing your application and the agreement.</span> <br>
            </td>
            <td style=" text-align: center;">
                <br><br>
                <span><b>Lender’s License:</b></span><br><br>
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
                <span>Amount given to you directly……………………………………………………………………………………… $' . ($principal_f - $in_hand) . '</span><br>
                <span>Amount paid on your existing loan with us………………………………………………………………………+$'.$in_hand.' </span><br>
                <span>Amount Financed…………………………………………………………………………………………………..=$'.$principal_f.' </span><br>
                <span>Prepaid Finance Charge (Administrative Fee)………………………………………………………………….+$'.$contract_fee.'  </span><br>
                <span>Principal……………………………………………………………………………………………………………..=$'.($principal_f + $contract_fee).' </span><br>
              </div>
              
            </td>
          </tr>
        </tbody>
      </table>
      <div style="text-align: justify;">
      <p><b>Lender’s Right:</b><span> Upon Borrower’s default, Lender may declare the entire
        unpaid principal balance on this Commercial Loan Promissory Note and
        then Borrower will pay that amount.
        </span></p>
       
        <p><b>Borrower’s Default:</b> <span> Default by Borrower includes, but is not limited
        to, the following: Voluntary or involuntary bankruptcy proceedings
        wherein Borrower is named a debtor; any liens or encumbrances recorded
        upon Borrower’s current property, as listed above, whether voluntary,
        involuntary or through operation of law.
        </span></p>
        
        <p><b>Dishonored Item Fee:</b><span>Borrower will pay a fee to Lender of $ 25.00 if Borrower makes a payment on Borrower’s loan and the check or preauthorized charge with which Borrower pays is later dishonored.
        </span></p>
        
        <p><b>Attorney’s Fees; Expenses:</b><span>Lender may here or pay someone else to help collect this Commercial Loan Promissory Note if Borrower does not pay. Borrower will pay Lender that amount. This includes, subject to any limits under applicable law, Lender’s Attorney’s fees, and Lender’s legal expenses, whether or not there is a lawsuit, including Attorney’s fees, expenses for bankruptcy proceedings (Including efforts to modify or vacate an automatic stay or injunction), and appeals. Borrower also will pay any court costs, in addition to all other sums provided by law. 
        </span></p>
        </div>
        <span>Initials:</span><img src="https://lsbankingportal.com/signature_commercial_loan/completed/doc_initials/'.$img_signed.'" alt="" style="height:300%" align="left"/>
        
';

//$html = file_get_contents(dirname(__FILE__)."/contract_page1.html");
//$pdf->writeHTML($html, true, false, true, false, '');
// $sign_image_url= $_SERVER["DOCUMENT_ROOT"]."signature_commercial_loan/completed/doc_signs/".$img_signed; #"https://lsbankingportal.com/signature_commercial_loan/completed/doc_signs/".$img_signed;

// $img = file_get_contents($sign_image_url);

$pdf->writeHTML($html,25,30); 

// $pdf->Image('@' . $img, 165, 262, '30', '', 'PNG', '', 'T', false, 40, '', false, false, 10, false, false, false);

 



$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

//  $pdf->Output(dirname(__FILE__).'/Case.pdf', 'F');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_1";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );


$file_name = $id . "page_1";
$path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>