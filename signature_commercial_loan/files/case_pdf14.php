<?php
$id=$_GET['id'];
$url_logo="http://lsbankingportal.com/signature_commercial_loan/completed/";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
 echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' "); 

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

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;
}


//echo "ID is".$loan_id;


$sql_loan=mysqli_query($con, "select * from tbl_commercial_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $principal=$row_loan['amount_of_loan'];
    $principal=number_format($principal, 2);
    $payment_date=$row_loan['payment_date'];
    $interest_rate=$row_loan['loan_interest'];
    $interest_rate=number_format($interest_rate, 2);
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['creation_date'];
    
    $timestamp = strtotime($creation_date);
    $creation_date= date("m-d-Y", $timestamp);
    
     $var = "$payment_datee";
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
    
 }
 
 $sql_loan_settings=mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'"); 

while($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];
}
 
   $calculation = (($loan_fee/$amount_of_loan)/($datediff/365) * 10000) / 100;
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
$anual_pr=($apr_total/$dateDiff)*100;
	//echo $anual_pr;
}
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

$pdf->SetFont('helvetica', '', 9);

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
<h1 style="text-align:center"> <span style="text-decoration:underline">PRIVACY NOTICE</span><br>
LS FINANCING, INC</h1>
 
 
 <table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 15.8733%; text-align:center; background-color:black;color:white"><br><br>HECHOS<br></td>
<td style="width: 83.1267%; text-align:center"><br><br>QUE HACE LS FINANCING CON SU INFORMACION PERSONAL?<br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>Porque?<br></td>
<td style="width: 83.1267%;"><br><br>Las Empresas Financieras eligen la manera en que comparten su informacion personal. Las Leyes Federales dan a los
consumidores el derecho a limitar como comparten la informacion, pero no se puede limitar todo. Las Leyes Federales tambien
nops obligan a informales sobre la manera en que tomamos, compartimos y protegemos sus datos personales. Por favor lea
esta notificacion cuidadosamente para entender lo que hacemos.<br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br><br>Que?<br></td>
<td style="width: 83.1267%;"><br><br>Los tipos de datos personales que tomamos y compartimos dependen del producto o servicio que tenga con nosotros. Estos
datos pueden incluir:<br><br>
• Numero de Seguro Social y Ingresos<br>
• Saldos de cuentas e historial de pagos<br>
• Historial de credito<br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>Como ? <br></td>
<td style="width: 83.1267%;"><br><br>Todas las Empresas Financieras necesitan compartir la informacion personal de sus clientes para llevar a cabo sus actividades
diarias. En la Seccion siguiente describimos las razones por las que las Empresas Financieras pueden compartir la informacion
personal de sus clientes; las razones por las cuales LS Financing, Inc elige compartir dicha informacion y si usted puede limitar
que se comparten dicha informacion. 
<br><br></td>
</tr>
</tbody>
</table>
 
<br><br>
<table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 60%; text-align:left; color:white; background-color:grey "><b>Razones por las que compartimos su informacion personal</b></td>
<td style="width: 20.1019%; text-align:center;background-color:grey; color:white"><b>LS Financing, Inc
Comparte?</b></td>
<td style="width: 20.8981%; text-align:center;background-color:grey; color:white"><b>Usted puede limitar?</b></td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para nuestras actividades diarias –</b><br>
tales como procesar sus operaciones, mantener su(s) cuenta(s), responder
requisitos judiciales e investigaciones legales o reportar a agencias de credito.<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> Yes &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para nuestras actividades comerciales –</b> <br>
para ofrecerle nuestros productos y servicios<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> Yes &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para comercializacion conjunta con otras empresas financieras–</b> <br></td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para las actividades diarias de nuestros afiliados –</b> <br>informacion acerca de sus operaciones y experiencias&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para las actividades diarias de nuestros afiliados –</b> <br>informacion sobre su solvencia<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> No Compartimos&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para que nuetros afiliados lleven a cabo actividades comerciales –</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para que las empresas no afiliadas lleven a cabo actividades comerciales</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br>No &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><b>Questions ? </b> &nbsp;</td>
<td colspan = "2" style="width: 20.1019%;">Please Call (747) 300-1542</td>
</tr>
</tbody>
</table>

<!-- DivTable.com -->

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

$file_name =$id. "page_15";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>