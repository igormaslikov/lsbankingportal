<?php
$_SESSION["Optima"] = "true";
$url_logo="../signature_customer/completed";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from loan_initial_banking where email_key='$iddd' "); 

while($row1 = mysqli_fetch_array($sql1)) {

$mail_key=$row1['email_key'];
$signed_status=$row1['sign_status'];

$creation_datee=$row1['creation_date'];
 
 $timestamp = strtotime($creation_datee);
 $creation_date= date("m-d-Y", $timestamp);


$fnd_id=$row1['user_fnd_id'];
$loan_id_bor=$row1['loan_id'];
$type_of_card=$row1['type_of_card'];
$card_number=$row1['card_number'];
$card_exp_date=$row1['card_exp_date'];

$bank_name=$row1['bank_name'];
$routing_number=$row1['routing_number'];
$account_number=$row1['account_number'];
$account_number = strlen($account_number) > 4 ? substr($account_number, -4) : $account_number;

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];
$signed_pic = $row1['signed_pic'] == "" ? "" : '../completed/doc_signs/'.$row1['signed_pic'];

}


//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $amount_of_loan=number_format($amount_of_loan, 2);
    $total_loan_payable=$row_loan['loan_total_payable'];

    $loan_fee=$row_loan['loan_fee'];
    $loan_payable=$amount_of_loan+$loan_fee;
    $loan_payable=number_format($loan_payable, 2);
    $payment_date=$row_loan['payment_date'];
    $payment_date_db=$row_loan['payment_date'];
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['contract_date'];
    $creation_date_db=$row_loan['contract_date'];
    $timestamp = strtotime($creation_date);
    $creation_date= date("m-d-Y", $timestamp);
    
//$payment_date= date("m-d-Y", strtotime($var) );
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

$start = strtotime($creation_date_db);
$end = strtotime($payment_date_db);

$days_between = ceil(abs($end - $start) / 86400);

$created_by = $row_loan['created_by'];
    
 }
 
 



 
  
    $calculation = $loan_fee/$amount_of_loan*365/$days_between*100;
    $calculation = round($calculation, 2);
  	$anual_pr= $calculation;
 
 
 $sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}


 
 
 

$sql2=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 
while($row2 = mysqli_fetch_array($sql2)) {
$ff_name=$row2['first_name'];
$l_name=$row2['last_name'];
$f_name= $ff_name.' '.$l_name;
$address=$row2['address'];
$city=$row2['city'];
$state=$row2['state'];
$zip=$row2['zip_code'];
$mobile_number=$row2['mobile_number'];
$address=$row2['address'];
}




function set_info($pdf,$x,$y,$w,$h,$info,$side='C',$bold='I',$font_size=8){
    $pdf->SetXY($x,$y);
    //Select Arial italic 8
    $pdf->SetFont('Arial',$bold,$font_size);
    //Print centered cell with a text in it
    $pdf->Cell($w, $h, $info, 0, 0, $side);
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
    global $anual_pr;
    global $loan_fee;
    global $amount_of_loan;
    global $loan_payable;
    global $payment_date;
    global $username;
    global $signed_pic;


    $tpl = $pdf->importPage(1);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,28,21,50,6,$loan_id_bor,'L');
    set_info($pdf,38,25.5,50,6,$creation_date,'L');
    set_info($pdf,30,30,50,6,$f_name,'L');
    set_info($pdf,29,34.5,70,6,$address,'L');
    set_info($pdf,38,39,60,6,$city.' '.$state.' '.$zip,'L');

    set_info($pdf,11,85,46,6,$anual_pr."%");
    set_info($pdf,58,85,46,6,"$".$loan_fee);
    set_info($pdf,106,85,46,6,"$".$amount_of_loan);
    set_info($pdf,153,85,46,6,"$".$loan_payable);

    set_info($pdf,22,122,36,6,"$".$amount_of_loan);
    set_info($pdf,78,122,50,6,"$".$amount_of_loan);
    set_info($pdf,149,122,38,6,"$0");


    set_info($pdf,22,144,36,6,"1");
    set_info($pdf,78,144,50,6,"$".$loan_payable);
    set_info($pdf,149,144,38,6,$payment_date);
    
    set_image($pdf,$signed_pic,11,264,-200);//$initial_pic
    set_info($pdf,51,270,33,6,$creation_date);
    set_info($pdf,87,270,36,6,$username);
    set_info($pdf,125,270,36,6,"Rep");
    set_info($pdf,163,270,36,6,$creation_date);



}




function page_2($pdf){
    global $loan_id_bor;
    global $creation_date;
    global $f_name;
    global $address;
    global $city;
    global $state;
    global $zip;
    global $anual_pr;
    global $loan_fee;
    global $amount_of_loan;
    global $loan_payable;
    global $payment_date;
    global $username;
    global $signed_pic;

    $tpl = $pdf->importPage(2);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,28,21+6.5,50,6,$loan_id_bor,'L');
    set_info($pdf,46,25.5+6,50,6,$creation_date,'L');
    set_info($pdf,34,30+6,50,6,$f_name,'L');
    set_info($pdf,32,34+6,70,6,$address,'L');
    set_info($pdf,38,39+5,60,6,$city.' '.$state.' '.$zip,'L');

    set_info($pdf,11,85,46,6,$anual_pr."%");
    set_info($pdf,58,85,46,6,"$".$loan_fee);
    set_info($pdf,106,85,46,6,"$".$amount_of_loan);
    set_info($pdf,153,85,46,6,"$".$loan_payable);

    set_info($pdf,22,122,36,6,"$".$amount_of_loan);
    set_info($pdf,78,122,50,6,"$".$amount_of_loan);
    set_info($pdf,149,122,38,6,"$0");


    set_info($pdf,22,141,36,6,"1");
    set_info($pdf,78,141,50,6,"$".$loan_payable);
    set_info($pdf,149,141,38,6,$payment_date);
    
    set_image($pdf,$signed_pic,11,264-2,-200);//$initial_pic
    set_info($pdf,51,270-2,33,6,$creation_date);
    set_info($pdf,87,270-2,36,6,$username);
    set_info($pdf,125,270-2,36,6,"Rep");
    set_info($pdf,163,270-2,36,6,$creation_date);

}

function page_3($pdf){
    global $loan_id_bor;
    global $creation_date;
    global $f_name;
    global $mobile_number;
    global $signed_pic;

    $tpl = $pdf->importPage(3);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,74,30,50,6,$f_name,'L');
    set_info($pdf,76,35.5,50,6,$loan_id_bor,'L');
    set_info($pdf,32,40,50,6,$creation_date,'L');

    set_info($pdf,74,54,30,6,$loan_id_bor,'L');
    set_info($pdf,172,54,90,6,$loan_id_bor,'L');

    set_info($pdf,10,233,90,6,$f_name.' - ('.$mobile_number.')');
    set_image($pdf,$signed_pic,40,250.5,-200);//$initial_pic


}

function page_4($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $type_of_card;
    global $card_number;
    global $card_exp_date;
    global $address;
    global $mobile_number;
    global $signed_pic;

    $tpl = $pdf->importPage(4);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,76,35,50,6,$f_name,'L');
    set_info($pdf,76,40,50,6,$loan_id_bor,'L');
    set_info($pdf,77,45,50,6,$creation_date,'L');

    set_info($pdf,148,84,15,6,$loan_id_bor);
    set_info($pdf,173,100,12,6,$loan_id_bor);

    set_info($pdf,42,128,50,6,$type_of_card,'L');
    set_info($pdf,50,137.5,50,6,'************'.substr($card_number,-4),'L');
    set_info($pdf,42,147.5,50,6,$card_exp_date,'L');
    set_info($pdf,20,165,100,6,$address,'L');
    set_info($pdf,32,181.5,50,6,$mobile_number,'L');

    set_info($pdf,12,205,34,6,$f_name);
    set_info($pdf,16,220,34,6,$f_name);

    set_image($pdf,$signed_pic,20,245.5,-200);//$initial_pic
    set_info($pdf,34,262,50,6,$creation_date,'L');


}

function page_5($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $account_number;
    global $bank_name;
    global $total_loan_payable;
    global $payment_date;
    global $signed_pic;


    $tpl = $pdf->importPage(5);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,74,35,50,6,$f_name,'L');
    set_info($pdf,74,45,50,6,$loan_id_bor,'L');
    set_info($pdf,34,55,50,6,$creation_date,'L');

    set_info($pdf,82,89.5,8,6,$account_number);
    set_info($pdf,109,89.5,19,6,$bank_name,'C','I',6);
    set_info($pdf,48,93,12,6,$total_loan_payable);
    set_info($pdf,128,93,14,6,$payment_date);

    set_image($pdf,$signed_pic,20,240,-200);//$initial_pic
    set_info($pdf,130,247,46,6,$f_name);


}

function page_6($pdf){
    global $loan_id_bor;
    global $f_name;
    global $creation_date;
    global $account_number;
    global $bank_name;
    global $total_loan_payable;
    global $payment_date;
    global $signed_pic;
    
    $tpl = $pdf->importPage(6);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);

    set_info($pdf,74,35-3,50,6,$f_name,'L');
    set_info($pdf,74,45-3,50,6,$loan_id_bor,'L');
    set_info($pdf,34,55-3,50,6,$creation_date,'L');

    set_info($pdf,135,72.5,8,6,$account_number);
    set_info($pdf,161,72.5,21,6,$bank_name,'C','I',6);
    set_info($pdf,139,76,14,6,$total_loan_payable);
    set_info($pdf,70,79.5,14,6,$payment_date);

    set_image($pdf,$signed_pic,16,251,-200);//$initial_pic
    set_info($pdf,130,258,46,6,$f_name);

}

function page_7($pdf){
    $tpl = $pdf->importPage(7);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);
}

function page_8($pdf){
    $tpl = $pdf->importPage(8);
    $pdf->grid = false;
    $pdf->AddPage();
    $pdf->useTemplate($tpl);
}

$pdf = new PDF_Grid();

$pagecount = $pdf->setSourceFile("../Optima Contract-PDF.pdf");


page_1($pdf);
page_2($pdf);
page_3($pdf);
page_4($pdf);
page_5($pdf);
page_6($pdf);
page_7($pdf);
page_8($pdf);



$file_name = $iddd;
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