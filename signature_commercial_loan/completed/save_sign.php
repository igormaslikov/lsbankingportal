<?php 
	$result = array();
	$sigdata = base64_decode($_POST['sig_data']);
	$initialdata = base64_decode($_POST['initial_data']);
	$sigdataCoBorrow = base64_decode($_POST['sig_data_co_borrow']);
	$co_borrow_name = $_POST['co_borrow_name'];
	$co_borrow_mobile = $_POST['co_borrow_mobile'];
	$filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
	$file_name = './doc_signs/'.$filename.'.png';
	file_put_contents($file_name,$sigdata);
    $key = $_POST['key'];
    $filename_sig=$filename.".png";


    $filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
    if (!file_exists('./doc_initials')) {
        mkdir('./doc_initials', 0777, true);
    }

	$file_name = './doc_initials/'.$filename.'.png';
	file_put_contents($file_name,$initialdata);
    $filename_initial=$filename.".png";

    $filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
    if (!file_exists('./doc_signs_coborrow')) {
        mkdir('./doc_signs_coborrow', 0777, true);
    }

	$file_name = './doc_signs_coborrow/'.$filename.'.png';
	file_put_contents($file_name,$sigdataCoBorrow);
    $filename_sig_coborrow=$filename.".png";

include 'dbconnect.php';
include 'dbconfig.php';

    $query_sign  = "UPDATE `commercial_loan_initial_banking` SET `sign_status`='1',`signed_pic`='$filename_sig', `initial_pic`='$filename_initial', `sig_coborrow_pic`='$filename_sig_coborrow', `co_borrow_name`='$co_borrow_name', `co_borrow_mobile`='$co_borrow_mobile' WHERE `email_key` = '$key'";
        $result_sign = mysqli_query($con, $query_sign);
        if ($result_sign) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
$sql=mysqli_query($con, "select * from commercial_loan_initial_banking where email_key = '$key' "); 
$loan_id = "";
while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo $loan_id;
}
mysqli_query ($con,"UPDATE `tbl_commercial_loan` SET `sign_status`='1' WHERE `loan_create_id` = '$loan_id'");

$articles[] = array(
    'status'         =>  "OK"
);
echo json_encode($articles);
?>