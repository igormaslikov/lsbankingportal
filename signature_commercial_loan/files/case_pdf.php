<?php
$id = $_GET['id'];
$url_logo = "https://pacificafinancegroup.com/loanportal/signature_commercial_loan/completed/";

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
  $totLoan = number_format(
    $row_loan['amount_of_loan'] + $row_loan['loan_interest'],
    2
  );
  $creation_date = $row_loan['creation_date'];
  $daily_interest = $row_loan['daily_interest'];

  $timestamp = strtotime($creation_date);
  $creation_date = date("m-d-Y", $timestamp);
  $total_payments = $row_loan['total_payments'];

  $installment_plan = $row_loan['installment_plan'];

  $created_by = $row_loan['created_by'];

  $installment_plan = $row_loan['installment_plan'];
  $contract_fee=$row_loan['contract_fee'];
  $in_hand=$row_loan['previous_amount_loan'];
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
// $search_dir = "doc_signs/$result";
// $images = glob("$search_dir/*.png");
// sort($images);

// Image selection and display:

//display first image
// if (count($images) > 0) { // make sure at least one image exists
//   $img = $images[0]; // first image
//   // echo "<img src='$img' height='150' width='150' /> ";
// } else {
//   // possibly display a placeholder image?
// }

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

// $sql_installment = mysqli_query($con, "SELECT count(loan_id) as count, loan_create_id FROM tbl_commercial_loan WHERE user_fnd_id = $fnd_id order by loan_id desc limit 2");
// while ($row_installment = mysqli_fetch_array($sql_installment)) {
//   $count = $row_installment['count'];
//   $previous_loan_id = $row_installment['loan_create_id'];
// }

// $in_hand = 0;
// if($count>1){
//   $sql_installment = mysqli_query($con, "SELECT SUM(payment) as in_hand FROM `tbl_commercial_loan_installments` where `loan_create_id`= $previous_loan_id and `status` = 0 order by id desc");
//   while ($row_installment = mysqli_fetch_array($sql_installment)) {
//     $in_hand = $row_installment['in_hand'];
//   }
// }

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
// $pdf->SetAuthor('Crunch Apple');
// $pdf->SetTitle('LSBANKING');
// $pdf->SetSubject('');
// $pdf->SetKeywords('');

// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// $pdf->SetFont('helvetica', '', 11);

// add a page
 

//$pdf->MultiCell(70, 50, $key1 , 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);

$pdf->SetFont('helvetica', '', 8.25);
$tagvs = [
  'p' => [
    ['h'=>0.1, ],
    ['h'=>0.1, ]
  ]
];
// $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
$pdf->setHtmlVSpace($tagvs);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetMargins(10,0,10);
$pdf->SetAutoPageBreak(TRUE, 0);
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$pdf->AddPage();

$html = '
        <p style="text-align:center">
          <h1>COMMERCIAL LOAN PROMISSORY NOTE</h1>
        </p>
        <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contract N:</b><span style="text-decoration:underline">' . $loan_id_bor . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date:</b><span style="text-decoration:underline">' . $creation_date . '</span>
      <br><br>


      <table style="width: 100%;">
        <tbody>
          <tr>
            <td style="width:65%">
            <b>Borrower:</b><span style="text-decoration:underline">' . $f_name . '</span>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$address.'</span>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$city.', '.$state.' '.$zip.'</span>
            <br><br>
            <b>Co-Borrower:</b><span>____________________________</span>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>____________________________</span>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>____________________________</span>
            </td>
            <td style="width:10%">
              <span><b>Lender:</b></span>
            </td>
            <td style="width:25%; text-align:center">
              
              <img src="images/pacifica.jpeg" alt="" style="height:400%" align="left"/><br>
              <span><b>Pacifica Financial Group</b></span><br>
              <span><b>5900 S Eastern Ave Suite 114 Commerce, CA 90040</b></span><br>
              <span><b>Tel: 323-797-5398</b></span>
            </td>
          </tr>
        </tbody>
      </table>
      <br><br>
      <table style="width: 100%;" border="1">
        <tbody>
          <tr>
            <td colspan="6" style="text-align: center;line-height:1.5"><b>TRUTH-IN-LENDING ACT DISCLOSURES</b></td>
          </tr>
          <tr>
            <td style="width:25%;">
              <b>ANNUAL PERCENTAGE RATE</b>
              <p>The cost of your credit as a yearly rate.</p>
              <p style="text-decoration:underline; text-align:center; line-height:5">' . $anual_pr . '%</p>
            </td>
            <td colspan="2" style="width:25%">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>AMOUNT FINANCED</b>
              <p>The amount of credit provided to you or on your behalf.</p>
              <p style="text-decoration:underline; text-align:center; line-height:5">' . $principal . '%</p>
            </td>
            <td style="width:20%">
              &nbsp;&nbsp;&nbsp;&nbsp;<b>FINANCE CHARGE</b>
              <p>The dollar amount the credit will coast you.</p>
              <p style="text-decoration:underline; text-align:center; line-height:5">$' . $interest_rate . '</p>
            </td>
            <td colspan="2" style="width:30%">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>TOTAL OF PAYMENTS</b>
              <p>The amount you will have paid after making all scheduled payments.</p>
              <p style="text-decoration:underline; text-align:center; line-height:5">$' . $totLoan . '</p>
            </td>
          </tr>
          <tr>
            <td rowspan="4" style="text-align: center;"><br><br><br><br><b>Payment Schedule:</b></td>
            <td style=" text-align: center;"><br><br><b>Number of Payments</b><br></td>
            <td style=" text-align: center;"><br><br>&nbsp;&nbsp;<b>Payment Amount</b></td>
            <td colspan="3" style=" text-align: left;"><br><br><b>When Payments Are Due</b></td>
          </tr>
          <tr>
            <td style=" text-align: center;"><br><br>1<br></td>
            <td style=" text-align: center;"><br><br>'.$fitst_payment.'<br></td>
            <td colspan="3" style=" text-align: left;"><br><br>Due '.$installment_plan.', beginning ' .$fitst_payment_date.'.<br></td>
          </tr>
          <tr>
            <td style=" text-align: center;"><br><br>' . $count_payments . '<br></td>
            <td style=" text-align: center;"><br><br>'.$second_payment.'</td>
            <td colspan="3" style=" text-align: left;"><br><br>Due ' . $installment_plan . '.</td>
          </tr>
          <tr>
            <td style=" text-align: center;"><br><br>Last Payment of<br></td>
            <td style=" text-align: center;"><br><br>'.$last_payment.'</td>
            <td colspan="3" style=" text-align: left;"><br><br>Due on ' . $last_payment_date . '.</td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: left; width:80%">
              <p style="line-height:1"><b>Prepayment:</b> You may prepay your loan at any time. If you pay early, you will not have to pay a penalty.</p><br>
              <p style="line-height:normal"><b>Late Charge:</b> If a payment is more than 10 days late, you will be charged $10. </p><br>
              <p style="line-height:normal"><b>Origination Fee:</b> A prepaid finance charge for $'.$contract_fee.' will de add to cover the cost of processing your application and the agreement.</p><br>
            </td>
            <td style=" text-align: center; width:20%">
                <br><br>
                <span><b>Lender’s License:</b></span><br><br>
                <span> 603 K724</span>
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
      <table>
        <tbody>
          <tr>
            <td>
              <p><b>Lender’s Right:</b><span> Upon Borrower’s default, Lender may declare the entire
              unpaid principal balance on this Commercial Loan Promissory Note and
              then Borrower will pay that amount.
              </span></p><br>
              
              <p><b>Borrower’s Default:</b> <span> Default by Borrower includes, but is not limited
              to, the following: Voluntary or involuntary bankruptcy proceedings
              wherein Borrower is named a debtor; any liens or encumbrances recorded
              upon Borrower’s current property, as listed above, whether voluntary,
              involuntary or through operation of law.
              </span></p><br>
              
              <p><b>Dishonored Item Fee:</b><span>Borrower will pay a fee to Lender of $ 25.00 if Borrower makes a payment on Borrower’s loan and the check or preauthorized charge with which Borrower pays is later dishonored.
              </span></p><br>
              
              <p><b>Attorney’s Fees; Expenses:</b><span>Lender may here or pay someone else to help collect this Commercial Loan Promissory Note if Borrower does not pay. Borrower will pay Lender that amount. This includes, subject to any limits under applicable law, Lender’s Attorney’s fees, and Lender’s legal expenses, whether or not there is a lawsuit, including Attorney’s fees, expenses for bankruptcy proceedings (Including efforts to modify or vacate an automatic stay or injunction), and appeals. Borrower also will pay any court costs, in addition to all other sums provided by law. 
              </span></p>
              <br><br><br>
              <p style="text-align:right;line-height:4"><span>Initials:__________________________</span></p>
            </td>
          </tr>
        </tbody>
      </table>
        
';

//$html = file_get_contents(dirname(__FILE__)."/contract_page1.html");
//$pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTML($html, false, false);



$data_shipment  = ":";



// $pdf->Ln();
// $html = '<h1>LSBANKING </h1>';
// $html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
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