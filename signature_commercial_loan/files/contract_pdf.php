<?php
$id = $_GET['id'];
$url_logo = "https://ofsca.com/loanportal/signature_commercial_loan/completed/";
$_SESSION['Optima'] = "true";
include 'dbconnect.php';
include 'dbconfig.php';
$iddd = $_GET['id'];

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
  $anual_pr=$row_loan['apr'];
}

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
  $co_borrow_full_name = $row2['co_borrow_full_name'];
  $co_borrow_phone = $row2['co_borrow_phone'];
  $co_borrow_address = $row2['co_borrow_address'];
  $co_borrow_state = $row2['co_borrow_state'];
  $co_borrow_city = $row2['co_borrow_city'];
  $co_borrow_zip = $row2['co_borrow_zip'];
}

$sql2 = mysqli_query($con, "select * from source_income where user_fnd_id='$fnd_id' ");
while ($row2 = mysqli_fetch_array($sql2)) {
  $address_b = $row2['address_b'];
  $city_b = $row2['city_b'];
  $state_b = $row2['state_b'];
  $zip_b = $row2['zip_b'];
}

$sql_business_query = mysqli_query($con, "select * from tbl_business_info where user_fnd_id= '$fnd_id'");

while ($row_business_source = mysqli_fetch_array($sql_business_query)) {

  $business_name = $row_business_source['business_name'];
  $business_phone = $row_business_source['business_phone'];
  $business_address = $row_business_source['business_address'];
  $business_state = $row_business_source['business_state'];
  $business_city = $row_business_source['business_city'];
  $business_zip = $row_business_source['business_zip'];
}

$sql_installment = mysqli_query($con, "select payment, payment_date from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor ORDER by id asc limit 1");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $first_payment_date = $row_installment['payment_date'];
}

$sql_installment = mysqli_query($con, "select first_payment, last_payment,total_payments from tbl_commercial_loan where loan_create_id=$loan_id_bor");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $first_payment = $row_installment['first_payment'];
  $last_payment = $row_installment['last_payment'];
  $count_payments = $row_installment['total_payments'];

}

$sql_installment = mysqli_query($con, "select payment, payment_date from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor ORDER by id desc limit 1");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
  $last_payment_date =  $row_installment['payment_date'];
}


// $sql_installment = mysqli_query($con, "select  as count from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor");
// while ($row_installment = mysqli_fetch_array($sql_installment)) {
//   $count_payments = $row_installment['count'];
// }

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

$total_payments_amount = number_format($first_payment + $count_payments*$second_payment + $last_payment,2);
$total_interest = number_format($first_payment + $count_payments*$second_payment + $last_payment - $principal_f,2);

$anual_pr = number_format($anual_pr, 2);

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



function set_info($pdf,$x,$y,$w,$h,$info,$bold='I',$font_size=8){
    $pdf->SetXY($x,$y);
    //Select Arial italic 8
    $pdf->SetFont('Arial',$bold,$font_size);
    //Print centered cell with a text in it
    $pdf->Cell($w, $h, $info, 0, 0, 'C');
}

function set_image($pdf,$image_path,$x,$y,$w){
    if(!file_exists($image_path)){
        return;
    }

    $image = imagecreatefrompng($image_path);
    imagealphablending($image, true);
    $transparentcolour = imagecolorallocatealpha($image, 255,255,255,127);
    imagecolortransparent($image, $transparentcolour);
    imagepng($image, $image_path);
    
    $pdf->Image($image_path, $x,$y, $w);
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
    
    set_image($pdf,$initial_pic,178,251,-200);//$initial_pic

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

    set_info($pdf,75,153, 50,10,$business_address . '  ' . $business_city . ' ' . $business_state . ' ' . $business_zip);

    set_image($pdf,$signed_pic,20,228,-200);
    set_info($pdf,70,232, 30,10,$creation_date);


    set_image($pdf,$sig_coborrow_pic,20,245,-200);
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
    
    set_image($pdf,$initial_pic,178,248,-200);

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

    set_info($pdf,75,136, 50,10,$business_address . '  ' . $business_city . ' ' . $business_state . ' ' . $business_zip);

    set_image($pdf,$signed_pic,20,223,-200);
    set_info($pdf,70,227, 30,10,$creation_date);


    set_image($pdf,$sig_coborrow_pic,20,240,-200);
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

    set_image($pdf,$initial_pic,36,242,-200);

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

    set_image($pdf,$initial_pic,36,242,-200);

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

    set_image($pdf,$signed_pic,30,212,-200);
    set_info($pdf,78,216,30,10,$creation_date);

    set_image($pdf,$sig_coborrow_pic,122,212,-200);
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

    set_image($pdf,$signed_pic,36,218,-200);
    set_image($pdf,$sig_coborrow_pic,36,242,-200);

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

    set_image($pdf,$initial_pic,36,248,-200);

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

    set_image($pdf,$signed_pic,36,213,-200);
    set_image($pdf,$sig_coborrow_pic,36,237,-200);
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
    set_image($pdf,$signed_pic,50,226,-200);
    
    set_info($pdf,140,189,30,10,$co_borrow_full_name);
    set_info($pdf,140,207,30,10,$co_borrow_phone);
    set_image($pdf,$sig_coborrow_pic,140,227,-200);
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

    set_image($pdf,$signed_pic,50,224,-200);


}

function page_13($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $account_number;
    global $first_payment;
    global $every_en;
    global $first_payment_date;
    global $bank_name;
    global $signed_pic;

    $tpl = $pdf->importPage(13);
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

function page_14($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $account_number;
    global $first_payment;
    global $every_es;
    global $first_payment_date;
    global $bank_name;
    global $signed_pic;

    $tpl = $pdf->importPage(14);
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

function page_15($pdf){
    $tpl = $pdf->importPage(15);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);
}

function page_16($pdf){
    $tpl = $pdf->importPage(16);
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


$pdf = new PDF_Grid();

$pagecount = $pdf->setSourceFile("../Optima- Business ContractUpdated.pdf");


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
// page_12($pdf);
page_13($pdf);
page_14($pdf);
page_15($pdf);
page_16($pdf);

$pagecount = $pdf->setSourceFile("../Optima-CEP Form.pdf");
page_17($pdf);


$file_name = $id;
$path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
$pdf->Output("F", $path);

$pdf->Output();

// include_once 'dbconnect.php';
// include 'dbconfig.php';

// $date_last_7days = date('Y-m-d',time()-(7*86400)); 
// echo "Fnd ID: $date_last_7days<br>";

// $sql=mysqli_query($con, "select * from loan_transaction where created_at >='$date_last_7days'"); 

// while($row = mysqli_fetch_array($sql)) {
// $mobile_verification = $row['user_fnd_id'];
// $loan_create_id = $row['loan_create_id'];



// echo "Fnd ID: $mobile_verification: $loan_create_id<br>";




// }

?>