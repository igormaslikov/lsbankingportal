<?php 
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



?>