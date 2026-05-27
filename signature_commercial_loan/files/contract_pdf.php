<?php
// This endpoint streams binary PDF bytes — any PHP warning/notice printed
// to stdout corrupts the output. Suppress non-fatal diagnostics.
error_reporting(0);
ini_set('display_errors', 0);

$id = $_GET['id'];
// Defaults so the render can proceed when there's no matching DB row
// (e.g. ?id=DEMO&demo=1 for the field-editor preview).
$signed_status       = $signed_status       ?? '';
$loan_id_bor         = $loan_id_bor         ?? '';
$fnd_id              = $fnd_id              ?? '';
$co_borrow_full_name = $co_borrow_full_name ?? '';
$principal_f         = $principal_f         ?? 0;
$anual_pr            = $anual_pr            ?? '';
$installment_plan    = $installment_plan    ?? '';
$creation_date_year  = $creation_date_year  ?? date('Y');
$creation_date       = $creation_date       ?? date('m-d-Y');
$contract_template   = $contract_template   ?? '';

/**
 * Resolve the site base URL at runtime.
 * - On production: https://ofsca.com/loanportal/
 * - On local dev (e.g. php built-in server on http://localhost:8080/):
 *   http://localhost:8080/
 * Works by looking at SCRIPT_NAME for the "/ls_software/" segment so we can
 * strip off the admin path and keep whatever prefix the host uses.
 */
function app_base_url() {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $idx = strpos($script, '/signature_commercial_loan/');
    if ($idx === false) { $idx = strpos($script, '/ls_software/'); }
    $path = ($idx !== false) ? substr($script, 0, $idx) : '';
    return $scheme . '://' . $host . $path . '/';
}

$url_logo = app_base_url() . 'signature_commercial_loan/completed/';
$_SESSION['Optima'] = "true";
include 'dbconnect.php';
include 'dbconfig.php';
$iddd = $_GET['id'];

// Diagnostic mode: ?debug=1 returns JSON of each query's result instead of PDF
// so you can see whether the row exists / which fields are populated.
$__debug = !empty($_GET['debug']);
if ($__debug) {
    header('Content-Type: application/json; charset=utf-8');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$sql1 = $con->query("select * from commercial_loan_initial_banking where email_key='$iddd' ");
if ($__debug) {
    // Walk all three lookups and report columns + values for each, so we can
    // see which columns are missing on SQL Server vs what contract_pdf.php
    // expects to read.
    $rows1 = [];
    while ($r = $sql1->fetch_assoc()) { $rows1[] = $r; }
    $row1 = $rows1[0] ?? null;
    $fnd_id_dbg = $row1['user_fnd_id'] ?? null;
    $loan_id_bor_dbg = $row1['loan_id'] ?? null;

    $rows2 = [];
    if ($loan_id_bor_dbg !== null) {
        $sql2dbg = $con->query("select * from tbl_commercial_loan where loan_create_id='$loan_id_bor_dbg'");
        while ($r = $sql2dbg->fetch_assoc()) { $rows2[] = $r; }
    }

    $rows3 = [];
    if ($fnd_id_dbg !== null) {
        $sql3dbg = $con->query("select * from fnd_user_profile where user_fnd_id='$fnd_id_dbg'");
        while ($r = $sql3dbg->fetch_assoc()) { $rows3[] = $r; }
    }

    // When the requested key doesn't match, show recent existing keys so the
    // caller can copy one and re-test the PDF flow with real data.
    $recent_keys = [];
    if (!$rows1) {
        $sqlR = $con->query("SELECT TOP 20 email_key, user_fnd_id, loan_id, creation_date FROM commercial_loan_initial_banking ORDER BY creation_date DESC");
        while ($r = $sqlR->fetch_assoc()) { $recent_keys[] = $r; }
        $sqlC = $con->query("SELECT COUNT(*) AS total_rows FROM commercial_loan_initial_banking");
        $totalRow = $sqlC ? $sqlC->fetch_assoc() : null;
        $table_total_rows = $totalRow['total_rows'] ?? null;
    } else {
        $table_total_rows = null;
    }

    echo json_encode([
        'email_key' => $iddd,
        'commercial_loan_initial_banking' => [
            'row_count' => count($rows1),
            'columns' => $row1 ? array_keys($row1) : [],
            'row' => $row1,
        ],
        'tbl_commercial_loan_lookup' => [
            'loan_create_id_searched' => $loan_id_bor_dbg,
            'row_count' => count($rows2),
            'columns' => $rows2[0] ?? null ? array_keys($rows2[0]) : [],
            'row' => $rows2[0] ?? null,
        ],
        'fnd_user_profile_lookup' => [
            'user_fnd_id_searched' => $fnd_id_dbg,
            'row_count' => count($rows3),
            'columns' => $rows3[0] ?? null ? array_keys($rows3[0]) : [],
            'row' => $rows3[0] ?? null,
        ],
        'commercial_loan_initial_banking_total_rows' => $table_total_rows,
        'recent_existing_email_keys' => $recent_keys,
        'sqlsrv_errors' => function_exists('sqlsrv_errors') ? sqlsrv_errors() : null,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

while ($row1 = $sql1->fetch_array()) {

  $mail_key = $row1['email_key'];
  $signed_status = $row1['sign_status'];

  $creation_datee = $row1['creation_date'];

  $timestamp = strtotime($creation_datee);
  $creation_date = date("m-d-Y", $timestamp);


  $fnd_id = $row1['user_fnd_id'];
  $loan_id_bor = $row1['loan_id'];
  $type_of_card = $row1['type_of_card'];
  $card_number = $row1['card_number'];
  $card_number = strlen($card_number) > 4 ? substr($card_number, -4) : $card_number;
  $card_exp_date = $row1['card_exp_date'];

  $bank_name = $row1['bank_name'];
  $routing_number = $row1['routing_number'];
  $account_number = $row1['account_number'];
  $account_number = strlen($account_number) > 4 ? substr($account_number, -4) : $account_number;


  $cvv_number = $row1['cvv_number'];


  $initial_pic = $row1['initial_pic'] == "" ? "" : '../completed/doc_initials/'.$row1['initial_pic'] ;
  $signed_pic = $row1['signed_pic'] == "" ? "" : '../completed/doc_signs/'.$row1['signed_pic'];
  $sig_coborrow_pic = $row1['sig_coborrow_pic'] == "" ? "" : '../completed/doc_signs_coborrow/'.$row1['sig_coborrow_pic'];

//   $initial_pic = '../completed/doc_initials/'.$row1['initial_pic'];
//   $signed_pic = '../completed/doc_signs/'.$row1['signed_pic'];
//   $sig_coborrow_pic = '../completed/doc_signs_coborrow/'.$row1['sig_coborrow_pic'];

  $co_borrow_name = $row1['co_borrow_name'];
  $co_borrow_mobile = $row1['co_borrow_mobile'];

}

/**
 * Immutability guard for signed contracts.
 *
 * Goal: once a customer has signed a contract, any later edit to their
 * application / loan / customer data must NOT retroactively change the signed
 * PDF. We implement this as a filesystem-based freeze:
 *
 *   Barcodes/signed/{email_key}.pdf  — written exactly once, on the first
 *                                      render after sign_status flips to '1'.
 *   Barcodes/{email_key}.pdf         — live preview copy (pre-signature),
 *                                      overwritten on every render.
 *
 * When a signed request arrives, serve the frozen file directly and skip the
 * entire regenerate-from-live-data path below.
 */
$__frozen_dir  = dirname(__FILE__) . '/Barcodes/signed';
$__frozen_path = $__frozen_dir . '/' . $iddd . '.pdf';
if (!is_dir($__frozen_dir)) { @mkdir($__frozen_dir, 0755, true); }

$__is_signed = ($signed_status === '1');

if ($__is_signed && is_file($__frozen_path) && filesize($__frozen_path) > 0) {
    $__safe_name = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$iddd);
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="contract_' . $__safe_name . '.pdf"');
    header('Content-Length: ' . filesize($__frozen_path));
    readfile($__frozen_path);
    exit;
}

$sql_loan = $con->query("select * from tbl_commercial_loan where loan_create_id= '$loan_id_bor' ");

while ($row_loan = $sql_loan->fetch_array()) {


  // PHP 8 won't auto-coerce string values into floats for arithmetic or number_format().
  // Cast every money/rate/count column at the source so downstream number_format()
  // calls (there are 28+ of them in this file) can't fail on empty-string values.
  $principal_f      = (float)($row_loan['amount_of_loan']   ?? 0);
  $principal        = number_format($principal_f, 2);
  $payment_date     = $row_loan['payment_date']             ?? '';
  $interest_rate_f  = (float)($row_loan['loan_interest']    ?? 0);
  $interest_rate    = number_format($interest_rate_f, 2);
  $totLoan          = number_format($principal_f + $interest_rate_f, 2);
  $creation_date    = $row_loan['contract_date']            ?? '';
  $daily_interest   = (float)($row_loan['daily_interest']   ?? 0);

  $timestamp          = strtotime((string)$creation_date);
  $creation_date      = $timestamp ? date("m-d-Y", $timestamp) : '';
  $creation_date_year = $timestamp ? date("Y",     $timestamp) : '';
  $total_payments     = (int)  ($row_loan['total_payments'] ?? 0);

  $installment_plan = $row_loan['installment_plan']         ?? '';
  $created_by       = $row_loan['created_by']               ?? '';
  $contract_fee     = (float)($row_loan['contract_fee']         ?? 0);
  $in_hand          = (float)($row_loan['previous_amount_loan'] ?? 0);
  $anual_pr         = (float)($row_loan['apr']                  ?? 0);
  // Drives template selection below. 'unsecured_2024_09_01' / 'secured' for
  // loans created after Phase 2. Rows created before Phase 2 were backfilled
  // to 'legacy_optima_{YYYY}' so their PDFs still generate from the exact
  // per-year Optima template they were signed against.
  $contract_template = $row_loan['contract_template'] ?? ('legacy_optima_' . $creation_date_year);
}

// Editor override: when rendering demo/preview with ?template=<key>, let the
// URL param force which template gets used (so the editor can preview any
// template without needing a matching DB row).
if (!empty($_GET['template']) && in_array($_GET['template'], ['unsecured_2024_09_01','secured'], true)) {
    $contract_template = $_GET['template'];
}

$sql2 = $con->query("select * from fnd_user_profile where user_fnd_id='$fnd_id' ");
while ($row2 = $sql2->fetch_array()) {
  $ff_name = $row2['first_name'];
  $l_name = $row2['last_name'];
  $f_name = $ff_name . ' ' . $l_name;
  $address = $row2['address'];
  $city = $row2['city'];
  $state = $row2['state'];
  $zip = $row2['zip_code'];
  $mobile_number = $row2['mobile_number'];
  $address = $row2['address'];
  $co_borrow_full_name = $row2['co_borrow_full_name'];
  $co_borrow_phone = $row2['co_borrow_phone'];
  $co_borrow_address = $row2['co_borrow_address'];
  $co_borrow_state = $row2['co_borrow_state'];
  $co_borrow_city = $row2['co_borrow_city'];
  $co_borrow_zip = $row2['co_borrow_zip'];

  // Additional application-stage fields (used by the new Application pages
  // baked into the Unsecured/Secured contract PDFs).
  $ssn            = $row2['ssn']                ?? '';
  $dob            = $row2['date_of_birth']      ?? '';
  $email_addr     = $row2['email']              ?? '';
  $alt_number     = $row2['contact_number']     ?? '';
  $id_number      = $row2['dl_code']            ?? '';
  $source_lead    = $row2['source_of_lead']     ?? '';
  $loan_request   = $row2['loan_request_amount'] ?? '';
}

// Gate ALL co-borrower rendering on whether the customer profile actually has
// one. Legacy rows in commercial_loan_initial_banking may still carry a
// sig_coborrow_pic filename from the old save bug — ignore it when there's
// no co-borrower to avoid the PDF showing a stranger's signature / orphan file.
if (empty(trim((string)$co_borrow_full_name))) {
    $co_borrow_full_name = '';
    $co_borrow_phone     = '';
    $co_borrow_address   = '';
    $co_borrow_state     = '';
    $co_borrow_city      = '';
    $co_borrow_zip       = '';
    $sig_coborrow_pic    = '';   // blocks set_image() from drawing the signature
}

$sql2 = $con->query("select * from source_income where user_fnd_id='$fnd_id' ");
while ($row2 = $sql2->fetch_array()) {
  $address_b = $row2['address_b'];
  $city_b = $row2['city_b'];
  $state_b = $row2['state_b'];
  $zip_b = $row2['zip_b'];
}

$sql_business_query = $con->query("select * from tbl_business_info where user_fnd_id= '$fnd_id'");

while ($row_business_source = $sql_business_query->fetch_array()) {

  $business_name = $row_business_source['business_name'];
  $business_phone = $row_business_source['business_phone'];
  $business_address = $row_business_source['business_address'];
  $business_state = $row_business_source['business_state'];
  $business_city = $row_business_source['business_city'];
  $business_zip = $row_business_source['business_zip'];
  $business_monthly_income = (float)($row_business_source['monthly_gross_amount'] ?? 0);
  $business_type = $row_business_source['business_docs'] ?? ''; // closest DB field
}

$sql_installment = $con->query("select TOP 1 payment, payment_date from tbl_commercial_loan_installments where loan_create_id='$loan_id_bor' ORDER by id asc");
while ($row_installment = $sql_installment->fetch_array()) {
  $first_payment_date = $row_installment['payment_date'];
}

$first_payment  = 0;
$last_payment   = 0;
$count_payments = 0;
$sql_installment = $con->query("select first_payment, last_payment,total_payments from tbl_commercial_loan where loan_create_id='$loan_id_bor'");
while ($row_installment = $sql_installment->fetch_array()) {
  $first_payment  = (float)($row_installment['first_payment']  ?? 0);
  $last_payment   = (float)($row_installment['last_payment']   ?? 0);
  $count_payments = (int)  ($row_installment['total_payments'] ?? 0);
}

$sql_installment = $con->query("select TOP 1 payment, payment_date from tbl_commercial_loan_installments where loan_create_id='$loan_id_bor' ORDER by id desc");
while ($row_installment = $sql_installment->fetch_array()) {
  $last_payment_date =  $row_installment['payment_date'];
}


// $sql_installment = $con->query("select  as count from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor");
// while ($row_installment = $sql_installment->fetch_array()) {
//   $count_payments = $row_installment['count'];
// }

$second_payment = 0;

if ($count_payments > 2) {
  $count_payments = $count_payments - 2;
  $sql_installment = $con->query("select TOP 2 payment from tbl_commercial_loan_installments where loan_create_id='$loan_id_bor' ORDER by id asc");
  while ($row_installment = $sql_installment->fetch_array()) {
    $second_payment = (float)filter_var($row_installment['payment'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  }
}

// $count_payments = $count_payments <= 2 ? "" : $count_payments;
// $second_payment = $second_payment == 0 ? "": $second_payment;

$total_payments_amount = number_format($first_payment + $count_payments*$second_payment + $last_payment,2);
$total_interest = number_format($first_payment + $count_payments*$second_payment + $last_payment - $principal_f,2);

$anual_pr = number_format((float)$anual_pr, 2);

switch ($installment_plan) {
	case "Weekly":
		$every_en = "week";
        $every_es = "semana";
		break;
	case "Bi-Weekly":
		$every_en = "two weeks";
		$every_es = "dos semanas";
		break;
	case "Monthly":
		$every_en = "month";
		$every_es = "mes";
		break;
	default:
		$every_en = "";
		$every_es = "";
		break;
}



function set_info($pdf,$x,$y,$w,$h,$info,$bold='I',$font_size=8,$align='C'){
    $pdf->SetXY($x,$y);
    $pdf->SetFont('Arial',$bold,$font_size);
    $pdf->Cell($w, $h, $info, 0, 0, $align);
}

function set_image($pdf, $image_path, $x, $y, $w) {
    if (!$image_path || !file_exists($image_path)) {
        return;
    }
    // Guard against zero-byte / corrupt PNGs that may have been written by a
    // buggy save path. imagecreatefrompng() returns false on a bad file and
    // PHP 8 throws TypeError when that false is passed to imagealphablending().
    if (filesize($image_path) < 64) {
        return;
    }
    $image = @imagecreatefrompng($image_path);
    if ($image === false) {
        return;
    }
    imagealphablending($image, true);
    $transparentcolour = imagecolorallocatealpha($image, 255, 255, 255, 127);
    imagecolortransparent($image, $transparentcolour);
    imagepng($image, $image_path);
    imagedestroy($image);

    // Horizontal-center on $x; vertical bottom-anchor on $y. This means the
    // per-page (x, y) coords below should be interpreted as the MIDPOINT of
    // the signature line: x = line midpoint, y = line position.
    // FPDF $w < 0 means "render at this DPI"; convert pixel size to mm
    // (px / DPI * 25.4) and offset accordingly.
    $size = @getimagesize($image_path);
    if ($size !== false) {
        $px_w = (int)$size[0];
        $px_h = (int)$size[1];
        $dpi  = ($w < 0) ? abs($w) : 200;
        $mm_w = ($px_w / $dpi) * 25.4;
        $mm_h = ($px_h / $dpi) * 25.4;
        $x = $x - ($mm_w / 2);
        $y = $y - $mm_h;
    }

    $pdf->Image($image_path, $x, $y, $w);
}

use setasign\Fpdi\Fpdi;
require_once('../fpdf/fpdf.php');
require_once('../fpdi/src/autoload.php');

class PDF_Grid extends Fpdi {
    var $grid = false;

    function DrawGrid()
    {
        if($this->grid===true){
            $spacing = 2;
        } else {
            $spacing = $this->grid;
        }
        $this->SetDrawColor(204,255,255);
        $this->SetLineWidth(0.35);
        for($i=0;$i<$this->w;$i+=$spacing){
            $this->Line($i,0,$i,$this->h);
        }
        for($i=0;$i<$this->h;$i+=$spacing){
            $this->Line(0,$i,$this->w,$i);
        }
        $this->SetDrawColor(0,0,0);

        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(204,204,204);
        for($i=20;$i<$this->h;$i+=20){
            $this->SetXY(1,$i-3);
            $this->Write(4,$i);
        }
        for($i=20;$i<(($this->w)-($this->rMargin)-10);$i+=20){
            $this->SetXY($i-1,1);
            $this->Write(4,$i);
        }
        $this->SetXY($x,$y);
    }

    function Header()
    {
        if($this->grid)
            $this->DrawGrid();
    }
}

function page_1($pdf){
    global $loan_id_bor;
    global $creation_date;
    global $f_name;
    global $address;
    global $city;
    global $state;
    global $zip;
    global $co_borrow_full_name;
    global $co_borrow_phone;
    global $co_borrow_address;
    global $co_borrow_state;
    global $co_borrow_city;
    global $co_borrow_zip;
    global $business_name;
    global $business_phone;;
    global $business_address;
    global $business_state;
    global $business_city;
    global $business_zip;
    global $anual_pr;
    global $principal;
    global $total_interest;
    global $total_payments_amount;
    global $first_payment;
    global $installment_plan;
    global $first_payment_date;
    global $count_payments;
    global $second_payment;
    global $last_payment;
    global $last_payment_date;
    global $contract_fee;
    global $principal_f;
    global $in_hand;
    global $initial_pic;


    $tpl = $pdf->importPage(1);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,40,10,30,10,$loan_id_bor);

    //Borrower
    set_info($pdf,50,18,30,5,$f_name);
    set_info($pdf,50,23,30,5,$address);
    set_info($pdf,50,28,30,5,$city.", ".$state." ".$zip);
    
    
    //===========Co-Borrower=========
    set_info($pdf,50,32,30,5,$co_borrow_full_name);
    set_info($pdf,50,37,30,5,$co_borrow_address);
    set_info($pdf,50,42,30,5,$co_borrow_city.", ".$co_borrow_state." ".$co_borrow_zip);
    
    
    #=============Business================
    set_info($pdf,50,47,30,5,$business_name);
    set_info($pdf,50,51,30,5,$business_address);
    set_info($pdf,50,56,30,5,$business_city.", ".$business_state." ".$business_zip);
    
    #=============Date================
    set_info($pdf,160,13, 30,10,$creation_date);
    
    set_info($pdf,22,78, 30,10,$anual_pr);
    set_info($pdf,57,78, 30,10,$principal);
    set_info($pdf,106,78, 30,10,$total_interest);
    set_info($pdf,145,78, 30,10,$total_payments_amount);
    
    set_info($pdf,59,110, 30,10, $count_payments);
    set_info($pdf,85,102, 30,10,number_format($first_payment,2));
    set_info($pdf,85,110, 30,10,$second_payment);
    set_info($pdf,85,118, 30,10,number_format($last_payment,2));
    
    set_info($pdf,108,102, 30,10,$installment_plan);
    set_info($pdf,143,102, 30,10,$first_payment_date);
    set_info($pdf,108,110, 30,10,$installment_plan );
    set_info($pdf,114,117, 30,10,$last_payment_date);
    
    set_info($pdf,69,136, 30,11,number_format($contract_fee,2));
    
    
    set_info($pdf,160,155, 30,10,number_format($principal_f - $in_hand,2));
    set_info($pdf,160,159, 30,10,number_format($in_hand,2));
    set_info($pdf,160,163, 30,10,number_format($principal_f,2));
    set_info($pdf,160,167, 30,10,number_format($contract_fee,2));
    set_info($pdf,160,171, 30,10,number_format($principal_f + $contract_fee,2));
    
    set_image($pdf,$initial_pic,158,251,-200);//$initial_pic

}




function page_2($pdf){
    global $loan_id_bor;
    global $f_name;
    global $initial_pic;
    global $signed_pic;
    global $sig_coborrow_pic;
    global $creation_date;
    global $business_address;
    global $business_state;
    global $business_city;
    global $business_zip;

    $tpl = $pdf->importPage(2);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,100,30, 30,10,$f_name);
    set_info($pdf,100,36, 30,10,$loan_id_bor);

    set_info($pdf,75,153, 100,10,$business_address . '  ' . $business_city . ' ' . $business_state . ' ' . $business_zip);

    set_image($pdf,$signed_pic,46,240,-200);
    set_info($pdf,70,232, 30,10,$creation_date);


    set_image($pdf,$sig_coborrow_pic,46,257,-200);
    set_info($pdf,70,249,30,10,$creation_date);

    set_info($pdf,165,251, 30,10,$creation_date);


}

function page_3($pdf){
    global $loan_id_bor;
    global $creation_date;
    global $f_name;
    global $address;
    global $city;
    global $state;
    global $zip;
    global $co_borrow_full_name;
    global $co_borrow_phone;
    global $co_borrow_address;
    global $co_borrow_state;
    global $co_borrow_city;
    global $co_borrow_zip;
    global $business_name;
    global $business_phone;;
    global $business_address;
    global $business_state;
    global $business_city;
    global $business_zip;
    global $anual_pr;
    global $principal;
    global $total_interest;
    global $total_payments_amount;
    global $first_payment;
    global $installment_plan;
    global $first_payment_date;
    global $count_payments;
    global $second_payment;
    global $last_payment;
    global $last_payment_date;
    global $contract_fee;
    global $principal_f;
    global $in_hand;
    global $initial_pic;
    global $signed_pic;
    global $sig_coborrow_pic;

    $tpl = $pdf->importPage(3);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,50,12,30,10,$loan_id_bor);

    //Borrower
    set_info($pdf,50+10,20,30,5,$f_name);
    set_info($pdf,50+10,25,30,5,$address);
    set_info($pdf,50+10,30,30,5,$city.", ".$state." ".$zip);
    
    //===========Co-Borrower=========
    set_info($pdf,50+10,35,30,5,$co_borrow_full_name);
    set_info($pdf,50+10,40,30,5,$co_borrow_address);
    set_info($pdf,50+10,45,30,5,$co_borrow_city.", ".$co_borrow_state." ".$co_borrow_zip);
    
    
    #=============Business================
    set_info($pdf,50+10,51,30,5,$business_name);
    set_info($pdf,50+10,56,30,5,$business_address);
    set_info($pdf,50+10,61,30,5,$business_city.", ".$business_state." ".$business_zip);
    
    #=============Date================
    set_info($pdf,172,13, 30,10,$creation_date);
    
    set_info($pdf,22,78+16, 30,10,$anual_pr);
    set_info($pdf,57+8,78+16, 30,10,$principal);
    set_info($pdf,106+2,78+16, 30,10,$total_interest);
    set_info($pdf,145+14,78+16, 30,10,$total_payments_amount);
    
    set_info($pdf,59+1,110+9, 30,10,$count_payments);
    set_info($pdf,85,102+9, 30,10,number_format($first_payment,2));
    set_info($pdf,85,110+9, 30,10,$second_payment);
    set_info($pdf,85,118+8, 30,10,number_format($last_payment,2));
    
    set_info($pdf,110,102+9, 30,10,$installment_plan);
    set_info($pdf,143+10,102+9, 30,10,$first_payment_date);
    set_info($pdf,110,110+7.5, 30,10,$installment_plan );
    set_info($pdf,112+12,117+8.5, 30,10,$last_payment_date);
    
    set_info($pdf,69+34,136+7, 30,11,number_format($contract_fee,2));
    
    
    set_info($pdf,160,155+5, 30,10,number_format($principal_f - $in_hand,2));
    set_info($pdf,160,159+5, 30,10,number_format($in_hand,2));
    set_info($pdf,160,163+5, 30,10,number_format($principal_f,2));
    set_info($pdf,160,167+5, 30,10,number_format($contract_fee,2));
    set_info($pdf,160,171+5, 30,10,number_format($principal_f + $contract_fee,2));
    
    set_image($pdf,$initial_pic,210,253,-200);

}

function page_4($pdf){
    global $loan_id_bor;
    global $f_name;
    global $signed_pic;
    global $sig_coborrow_pic;
    global $creation_date;
    global $business_address;
    global $business_state;
    global $business_city;
    global $business_zip;

    $tpl = $pdf->importPage(4);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,100,20, 30,10,$f_name);
    set_info($pdf,100,26, 30,10,$loan_id_bor);

    set_info($pdf,75,136, 100,10,$business_address . '  ' . $business_city . ' ' . $business_state . ' ' . $business_zip);

    set_image($pdf,$signed_pic,47,235,-200);
    set_info($pdf,70,227, 30,10,$creation_date);


    set_image($pdf,$sig_coborrow_pic,47,252,-200);
    set_info($pdf,70,244,30,10,$creation_date);

    set_info($pdf,170,243, 30,10,$creation_date);


}

function page_5($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $principal_f;
    global $anual_pr;
    global $last_payment_date;
    global $initial_pic;

    $tpl = $pdf->importPage(5);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16,30,10,$f_name);
    set_info($pdf,80,22,30,10,$loan_id_bor);
    set_info($pdf,80,28,30,10,$creation_date);

    set_info($pdf,48,50,30,10,number_format($principal_f,2));
    set_info($pdf,156,49.5,30,10,number_format($principal_f,2));

    set_info($pdf,24,77.5,30,10,number_format($anual_pr,2));
    set_info($pdf,123,78,30,10,number_format($anual_pr,2));

    set_info($pdf,60,160,30,10,$last_payment_date);
    set_info($pdf,122,155,30,10,$last_payment_date);

    set_image($pdf,$initial_pic,82,250,-200);

}

function page_6($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $initial_pic;
    
    $tpl = $pdf->importPage(6);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16,30,10,$f_name);
    set_info($pdf,80,22,30,10,$loan_id_bor);
    set_info($pdf,80,28,30,10,$creation_date);

    set_image($pdf,$initial_pic,82,249,-200);

}

function page_7($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $signed_pic;
    global $sig_coborrow_pic;
    
    $tpl = $pdf->importPage(7);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16+10,30,10,$f_name);
    set_info($pdf,80,22+10,30,10,$loan_id_bor);
    set_info($pdf,80,28+10,30,10,$creation_date);

    set_image($pdf,$signed_pic,47,222,-200);
    set_info($pdf,78,216,30,10,$creation_date);

    set_image($pdf,$sig_coborrow_pic,145,222,-200);
    set_info($pdf,170,216,30,10,$creation_date);
}

function page_8($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $signed_pic;
    global $sig_coborrow_pic;

    $tpl = $pdf->importPage(8);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);
    
    set_info($pdf,80,16+6,30,10,$f_name);
    set_info($pdf,80,22+5,30,10,$loan_id_bor);
    set_info($pdf,80,28+5,30,10,$creation_date);

    set_image($pdf,$signed_pic,46,230,-200);
    set_image($pdf,$sig_coborrow_pic,46,254,-200);

}

function page_9($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $initial_pic;

    $tpl = $pdf->importPage(9);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16+4,30,10,$f_name);
    set_info($pdf,80,22+3,30,10,$loan_id_bor);
    set_info($pdf,80,28+3,30,10,$creation_date);

    set_image($pdf,$initial_pic,59,256,-200);

}

function page_10($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $signed_pic;
    global $sig_coborrow_pic;

    $tpl = $pdf->importPage(10);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16+4,30,10,$f_name);
    set_info($pdf,80,22+3,30,10,$loan_id_bor);
    set_info($pdf,80,28+3,30,10,$creation_date);

    set_image($pdf,$signed_pic,46,225,-200);
    set_image($pdf,$sig_coborrow_pic,46,248,-200);
}

function page_11($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $mobile_number;
    global $signed_pic;
    global $sig_coborrow_pic;

    global $co_borrow_full_name;
    global $co_borrow_phone;

    $tpl = $pdf->importPage(11);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);
    
    set_info($pdf,80,16+4,30,10,$f_name);
    set_info($pdf,80,22+3,30,10,$loan_id_bor);
    set_info($pdf,80,28+3,30,10,$creation_date);

    set_info($pdf,50,190,30,10,$f_name);
    set_info($pdf,50,208,30,10,$mobile_number);
    set_image($pdf,$signed_pic,56,236,-200);
    
    set_info($pdf,140,189,30,10,$co_borrow_full_name);
    set_info($pdf,140,207,30,10,$co_borrow_phone);
    set_image($pdf,$sig_coborrow_pic,148,236,-200);
}

function page_12($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $type_of_card;
    global $card_number;
    global $card_exp_date;
    global $cvv_number;
    global $address;
    global $mobile_number;
    global $signed_pic;

    $tpl = $pdf->importPage(12);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16+4,30,10,$f_name);
    set_info($pdf,80,22+3,30,10,$loan_id_bor);
    set_info($pdf,80,28+3,30,10,$creation_date);

    set_info($pdf,148,61,30,10,$loan_id_bor);
    set_info($pdf,176,76.5,30,10,$loan_id_bor);

    set_info($pdf,110,106,30,10,$type_of_card);
    set_info($pdf,100,114,30,10,"************".$card_number);
    set_info($pdf,80,122,30,10,$card_exp_date);
    set_info($pdf,49,130,30,10,$cvv_number);
    set_info($pdf,50,147,110,10,$address);
    set_info($pdf,50,155,110,10,"");
    set_info($pdf,66,165,50,10,$mobile_number);

    set_info($pdf,22,186,70,10,$f_name);
    set_info($pdf,22,198,70,10,$f_name);

    set_image($pdf,$signed_pic,49,233,-200);


}

function page_13($pdf,$page){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $account_number;
    global $first_payment;
    global $every_en;
    global $first_payment_date;
    global $bank_name;
    global $signed_pic;

  
    $tpl = $pdf->importPage($page);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16+3,30,10,$f_name);
    set_info($pdf,80,22+3,30,10,$loan_id_bor);
    set_info($pdf,80,28+3,30,10,$creation_date);

    set_info($pdf,22,61,10,10,$account_number);
    set_info($pdf,60,61,60,10,$bank_name);
    set_info($pdf,97,64.5,15,10,number_format($first_payment,2));
    set_info($pdf,164,64.5,20,10,$every_en);
    set_info($pdf,62,68,15,10, $first_payment_date);

    set_image($pdf,$signed_pic,30,223,-200);
    set_info($pdf,14,240,60,10,$f_name);

}

function page_14($pdf, $page){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $account_number;
    global $first_payment;
    global $every_es;
    global $first_payment_date;
    global $bank_name;
    global $signed_pic;

    $tpl = $pdf->importPage($page);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,80,16+13,30,10,$f_name);
    set_info($pdf,80,22+13,30,10,$loan_id_bor);
    set_info($pdf,80,28+12,30,10,$creation_date);

    set_info($pdf,178,60,10,10,$account_number);
    set_info($pdf,45,63,60,10,$bank_name);
    set_info($pdf,113,66.5,15,10,number_format($first_payment,2));
    set_info($pdf,14,69.5,20,10,$every_es);
    set_info($pdf,117,70,15,10,$first_payment_date);

    set_image($pdf,$signed_pic,30,227,-200);
    set_info($pdf,14,243,60,10,$f_name);
}

function page_15($pdf, $page){
    $tpl = $pdf->importPage($page);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);
}

function page_16($pdf, $page){
    $tpl = $pdf->importPage($page);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);
}

function page_17($pdf){
    global $f_name;
    global $creation_date;
    global $signed_pic;

    global $initial_pic;
    global $signed_pic;
    global $sig_coborrow_pic;

    $tpl = $pdf->importPage(1);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,60,54,80,10,$f_name);

    if($initial_pic != "" and $signed_pic != "" and $sig_coborrow_pic != ""){
        set_info($pdf,24.5,128.5,5,5,"X",'B',12);
    }

    set_image($pdf,$signed_pic,64,202,-200);
    set_info($pdf,156,206,30,10,$creation_date);



}


// US Letter matches every template PDF we import (215.9 x 279.4 mm).
// FPDF default is A4 (210x297) which clips ~6mm off the right of the template
// and leaves ~18mm of blank space at the bottom. Locking to Letter sidesteps
// both issues and makes the coordinate math line up with pdfplumber extracts.
$pdf = new PDF_Grid('P', 'mm', 'Letter');
// Overlay text near the bottom of a page must not trigger an automatic new
// page — the base template's page break is already fixed by the imported PDF.
$pdf->SetAutoPageBreak(false);
// $creation_date_year = "2022";

/**
 * Resolve $contract_template -> path of the base PDF this loan was signed on.
 *
 *   unsecured_2024_09_01 -> Loan-Agreement-Unsecured-2024-09-01.pdf   (NEW, 35 pages)
 *   secured              -> Loan-Agreement-Secured.pdf                (NEW, 47 pages)
 *   legacy_optima_{YYYY} -> Optima- Business ContractUpdated{YYYY}.pdf (old per-year templates)
 *
 * NOTE: the page_1..page_17 overlay functions below still place text using
 * coordinates from the Optima template. New unsecured/secured PDFs will render
 * structurally but with mis-positioned overlays until Phase 3 re-maps them.
 */
$__tpl = (string)$contract_template;
if ($__tpl === 'unsecured_2024_09_01') {
    $__contract_pdf = '../Loan-Agreement-Unsecured-2024-09-01.pdf';
} elseif ($__tpl === 'secured') {
    $__contract_pdf = '../Loan-Agreement-Secured.pdf';
} elseif (strpos($__tpl, 'legacy_optima_') === 0) {
    $__year = substr($__tpl, strlen('legacy_optima_'));
    $__contract_pdf = '../Optima- Business ContractUpdated' . $__year . '.pdf';
} else {
    // Unknown value — fall back to this loan's year Optima template (safe default).
    $__contract_pdf = '../Optima- Business ContractUpdated' . $creation_date_year . '.pdf';
}
$pagecount = $pdf->setSourceFile($__contract_pdf);

if ($__tpl === 'unsecured_2024_09_01' || $__tpl === 'secured') {
    // DB-driven renderer: every field position lives in contract_field_coords.
    //   ?demo=1  — render with realistic placeholder values (field editor preview)
    //   ?page=N  — render only that single page (editor fast-preview)
    require_once __DIR__ . '/contract_pdf_fields.php';
    require_once __DIR__ . '/contract_pdf_templates.php';
    $is_demo   = !empty($_GET['demo']);
    $only_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : null;
    $render_ctx = $is_demo ? build_demo_context() : build_context_from_globals();
    render_template_from_db($pdf, $__tpl, $render_ctx, $only_page);
} else {
    // Legacy Optima path — unchanged from the pre-Phase-2 behavior so every
    // pre-existing loan continues rendering exactly as it did before.
    $decrease_page = 0;
    if ($creation_date_year = "2023"){
        $decrease_page = 1;
    }
    page_1($pdf);
    page_2($pdf);
    page_3($pdf);
    page_4($pdf);
    page_5($pdf);
    page_6($pdf);
    page_7($pdf);
    page_8($pdf);
    page_9($pdf);
    page_10($pdf);
    page_11($pdf);
    //page_12($pdf);
    page_13($pdf, 13 - $decrease_page);
    page_14($pdf, 14 - $decrease_page);
    page_15($pdf, 15 - $decrease_page);
    page_16($pdf, 16 - $decrease_page);

    $pagecount = $pdf->setSourceFile("../Optima-CEP Form.pdf");
    page_17($pdf);
}


$file_name = $id;
$path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
$pdf->Output("F", $path);

// First render after signing: write the frozen copy exactly once. All future
// requests for this email_key are served from the early-exit guard at the top
// and never reach this point again.
if ($__is_signed && !is_file($__frozen_path)) {
    $pdf->Output("F", $__frozen_path);
}

$pdf->Output();

// include_once 'dbconnect.php';
// include 'dbconfig.php';

// $date_last_7days = date('Y-m-d',time()-(7*86400)); 
// echo "Fnd ID: $date_last_7days<br>";

// $sql=$con->query("select * from loan_transaction where created_at >='$date_last_7days'"); 

// while($row = $sql->fetch_array()) {
// $mobile_verification = $row['user_fnd_id'];
// $loan_create_id = $row['loan_create_id'];



// echo "Fnd ID: $mobile_verification: $loan_create_id<br>";




// }

?>