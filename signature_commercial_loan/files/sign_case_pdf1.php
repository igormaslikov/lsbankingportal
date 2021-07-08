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

  $img_signed = $row1['signed_pic'];

  $result_sig = $url_logo . '/doc_signs/' . $img_signed;
}


//echo "ID is".$loan_id;





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

$business_name = "";
$sql2 = mysqli_query($con, "select business_name from tbl_business_info where user_fnd_id='$fnd_id' ");
while ($row2 = mysqli_fetch_array($sql2)) {
  $business_name = $row2['business_name'];
}

$business_name = $business_name == "" ? "_______________" : $business_name;

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

$pdf->SetFont('helvetica', '', 10);

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

$html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br>
 Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">' . $f_name . '</span><br>
Loan Number/Numero de Prestamo: <span style="text-decoration:underline">' . $loan_id_bor . '</span><br><br>


<b>Confession of Judgment: </b>Borrower hereby irrevocable authorizes and empowers any attorney-at-law to appear in any court of record and to confess judgment against Borrower for the unpaid amount of this Commercial Loan Promissory Note as evidenced by any affidavit signed by an officer of Lender setting forth the amount then due, Attorney’s fees plus costs of suit, and to release all errors, and waive all rights of appeal. If a copy of this Commercial Loan Promissory Note, verified by an affidavit, shall have been filled in the proceeding, it will not be necessary to file the original as a warrant of Attorney. Borrower waives the right to any stay of execution and the benefit of all exemption laws now or hereafter in effect. No single exercise of the foregoing warrant and power to confess judgment will be deemed to exhaust the power, whether or not any such exercise shall be held by any court to be invalid , voidable, or void ; but the power will continue undiminished and may be exercised from time to time as Lender may elect until all amounts owing on this Commercial Loan Promissory Note have been paid in full. Borrower hereby waives and releases any and all claims or causes of action which Borrower might have against any Attorney acting under the terms of authority which Borrower has granted herein arising out of or connected with the confession of judgment hereunder.
<br>
<b>Governing Law : </b>This Commercial Loan Promissory Note will be governed by California Lender’s law applicable to Lender, and to the extent not preempted by federal Law, without regard to its conflict of law provisions. This Commercial Loan Promissory Note has been accepted by Borrower and Lender in the State of California.
<br>
<b>Choice of Venue : </b>If there is a lawsuit, Borrower agrees upon Lender’s request to submit to the jurisdiction of the courts of Los Angeles County, State of California or, if required, to the courts of the Central District of California. Any suit brought hereunder shall be filed in the Van Nuys Courthouse, or in the Western Division of the Central District of California, as applicable.
<br>
<b>Collateral : </b>All present and future inventory of that business known as '.$business_name.' as well as all accounts receivable.
<br>


<b>Personal Guarantee : </b>This contract has a personal guarantee from the borrower and co-borrower in case the business mentioned above close or is sold to another or other people.
<br>
<b>Onsite Payment : </b>Lender is hereby authorized to collect payments due under this Commercial Loan Promissory Note at Borrower’s physical address, being: <span style="text-decoration:underline">' . $address . '  ' . $city . ' ' . $state . ' ' . $zip . '</span> .
<br>
<b>Successor Interest : </b>The terms of this Commercial Loan Promissory Note shall be binding upon Borrower and Lender, and upon their heirs, personal representatives and successors, and shall inure to the benefit of same.
<br>

<b>General Provisions : </b>Lender may delay or forgo enforcing any of its rights or remedies under this Commercial Loan Promissory Note without losing them. Upon any change in the terms of this Commercial Loan Promissory Note, and unless otherwise expressly states in writing, no party who signs this Commercial Loan Promissory Note, whether as maker, guarantor, accommodation maker or endorser, shall be released from liability. All such parties agree that Lender may renew or extend (repeatedly and for any length of time) this loan or release any party or guarantor; and take any other action deemed necessary by Lender without the consent of or notice to anyone. All such parties also agree that Lender may modify this loan without the consent of or notice to anyone other than the party with whom the modification is made. The obligations under this Commercial Loan Promissory Note are joint and several. 
<br>
<b>
<span style="font-size: 9px">PRIOR TO SIGNING THIS COMMERCIAL LOAN PROMISSORY NOTE, BORROWER READ AND UNDERSTOOD ALL THE PROVISIONS OF THIS COMMERCIAL LOAN PROMISSORY NOTE, INCLUDING THE INTEREST RATE PROVISIONS, BORROWER AGREES TO THE TERMS OF THE NOTE.
BORROWER ACKNOWLEDGES RECEIPT OF A COMPLETED COPY OF THIS COMMERCIAL LOAN PROMISSORY NOTE</span>

</b><br><br>


Borrower’s Signature : <img src="https://lsbankingportal.com/signature_commercial_loan/completed/doc_signs/'.$img_signed.'" alt="" style="height:300%" align="left"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date :'.$creation_date.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br>
Co-Borrower’s Signature : _________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date :'.$creation_date.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br>
Lender’s Name  : <span style="text-decoration:underline">MY MONEY LINE</span>
<br><br>
Lender’s Authorized  Signature :<span style="text-decoration:underline">MY MONEY LINE</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date :'.$creation_date.'





';

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

// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_2";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name = $id . "page_2";
$path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>