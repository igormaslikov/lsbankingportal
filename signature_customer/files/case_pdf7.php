<?php
session_start();
$id=$_GET['id'];
?>


<?php
include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from loan_initial_banking where email_key='$iddd' "); 

while($row1 = mysqli_fetch_array($sql1)) {

$mail_key=$row1['email_key'];
$signed_status=$row1['sign_status'];
$creation_date=$row1['creation_date'];
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

if($signed_status>0){
    echo "Contract Already Signed";
}
else {
//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $payment_date=$row_loan['payment_date'];
    // echo "LOAN Amount".$amount_of_loan;
    
   
    
     
    $payoff=$row_loan['amount_of_loan'];
    
   
    
  if($payoff== '$50'){
        $payoff= '$8.83' ;
        
        }
        else if($payoff== '$100')
        {
             $payoff= '$17.65' ;
        }
        
        else if($payoff== '$150')
        {
             $payoff= '$26.47' ;
        }
        
        else if($payoff== '$200')
        {
             $payoff= '$35.30' ;
        }
        
        else if($payoff== '$255')
        {
             $payoff= '$45.00' ;
        }  
        
        
        
        
}




$sql2=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 

while($row2 = mysqli_fetch_array($sql2)) {

$f_name=$row2['first_name'];
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
<h1 style="text-align:center"> <span style="text-decoration:underline">AVISO DE PRIVACIDAD</span><br>
Optima Financial Solutions Inc</h1>
 
 
 <table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 15.8733%; text-align:center; background-color:black;color:white"><br><br>HECHOS<br></td>
<td style="width: 83.1267%; text-align:center"><br><br>QUE HACE Optima Financial Solutions Inc CON SU INFORMACION PERSONAL?<br></td>
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
personal de sus clientes; las razones por las cuales Optima Financial Solutions Inc elige compartir dicha informacion y si usted puede limitar
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
<td style="width: 20.1019%; text-align:center;background-color:grey; color:white"><b>Optima Financial Solutions Inc
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
<td style="width: 60%;"><br><b>Preguntas? </b> &nbsp;</td>
<td colspan = "2" style="width: 20.1019%;">Llamenos al (818)-856-4302</td>
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

$file_name = $id."page_8";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path,'F');

//============================================================+
// END OF FILE
//============================================================+

?>