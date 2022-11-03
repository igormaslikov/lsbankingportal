<?php 
    $_SESSION["Optima"] = "true";
	$result = array();
	$imagedata = base64_decode($_POST['img_data']);
	$filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
	$file_name = './doc_signs/'.$filename.'.png';
	file_put_contents($file_name,$imagedata);
	$result['status'] = 1;
	$result['file_name'] = $file_name;
	echo json_encode($result);
    $key = $_POST['key'];
    $filename=$filename.".png";
include 'dbconnect.php';
include 'dbconfig.php';

    $query_sign  = "UPDATE `loan_initial_banking` SET `sign_status`='1',`signed_pic`='$filename' WHERE `email_key` = '$key'";
        $result_sign = mysqli_query($con, $query_sign);
        if ($result_sign) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
$sql=mysqli_query($con, "select * from loan_initial_banking where email_key = '$key' "); 
$loan_id = "";
while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
echo $loan_id;
}
mysqli_query ($con,"UPDATE `tbl_loan` SET `sign_status`='1' WHERE `loan_create_id` = '$loan_id'");

?>

<script type="text/javascript">
window.location.href = 'https://ofsca.com/loanportal/signature_customer/files/contract_pdf.php?id=<?php echo $key ;?>';
</script>