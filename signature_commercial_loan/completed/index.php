<?php
$url_logo = "https://lsbankingportal.com/signature_commercial_loan/completed";
include 'dbconnect.php';
include 'dbconfig.php';
$iddd = $_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;






$sql1 = mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' ");

while ($row1 = mysqli_fetch_array($sql1)) {

	$mail_key = $row1['email_key'];
	$signed_status = $row1['sign_status'];
	$creation_date = $row1['creation_date'];
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

if ($signed_status > 0) {
	echo "Contract Already Signed";
} else {
	//echo "ID is".$loan_id;



	$sql_loan = mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$loan_id_bor' ");

	while ($row_loan = mysqli_fetch_array($sql_loan)) {


		$amount_of_loan = $row_loan['amount_of_loan'];
		$payment_date = $row_loan['payment_date'];
		// echo "LOAN Amount".$amount_of_loan;




		$payoff = $row_loan['loan_total_payable'];
	}




	$sql2 = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' ");

	while ($row2 = mysqli_fetch_array($sql2)) {

		$f_name = $row2['first_name'];
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
?>






	<?php
	$date1 = "$creation_date";
	$date2 = "$payment_date";
	function dateDiff($date1, $date2)
	{
		$date1_ts = strtotime($date1);
		$date2_ts = strtotime($date2);
		$diff = $date2_ts - $date1_ts;
		return round($diff / 86400);
	}
	$dateDiff = dateDiff($date1, $date2);
	// echo "Days".$dateDiff."<br>";


	$payoff = str_replace('$', '', $payoff);
	$amount_of_loan = str_replace('$', '', $amount_of_loan);
	$apr = $payoff / $amount_of_loan;
	$apr_total = $apr * 365;
	$anual_pr = ($apr_total / $dateDiff) * 100;
	//echo $anual_pr;
	?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Contract Signature</title>

		<!-- Bootstrap Core Css -->
		<link href="css/bootstrap.css" rel="stylesheet" />

		<!-- Font Awesome Css -->
		<link href="css/font-awesome.min.css" rel="stylesheet" />

		<!-- Bootstrap Select Css -->
		<link href="css/bootstrap-select.css" rel="stylesheet" />

		<!-- Custom Css -->
		<link href="css/app_style.css" rel="stylesheet" />

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

		<style>
			#btnSaveSignInitial,
			#btnClearInitial,
			#btnClearSign {
				color: #fff;
				background: #f99a0b;
				padding: 5px;
				border: none;
				border-radius: 5px;
				font-size: 20px;
				margin-top: 10px;
			}

			#btnupload_initials,
			#btnupload {
				color: #fff;
				background: #f99a0b;
				padding: 5px;
				border: none;
				border-radius: 5px;
				font-size: 20px;
				margin-top: 10px;
			}


			#initialArea,
			#signArea {
				width: 304px;
				margin: 15px auto;
			}

			.sign-container {
				width: 90%;
				margin: auto;
			}

			.sign-preview {
				width: 150px;
				height: 50px;
				border: solid 1px #CFCFCF;
				margin: 10px 5px;
			}

			.tag-ingo {
				font-family: cursive;
				font-size: 12px;
				text-align: left;
				font-style: oblique;
			}

			.center-text {
				text-align: center;
			}
		</style>






	</head>

	<body>
		<div class="all-content-wrapper">
			<!-- Top Bar -->
			<?php require_once('./include/header.php'); ?>
			<!-- #END# Top Bar -->

			<section class="container">


				<div class="page-body clearfix">
					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">Digital Signature:</div>
								<div class="panel-body center-text">

									<div id="signArea">
										<h2 class="tag-ingo">Put signature below,</h2>
										<div class="sig sigWrapper" style="height:auto;">
											<div class="typed"></div>
											<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
										</div>
									</div>

									<button id="btnClearSign" onclick="clearCanvas('sign-pad')">Clear Signature</button><br>


								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">Digital Initials:</div>
								<div class="panel-body center-text">

									<div id="initialArea">
										<h2 class="tag-ingo">Put initials below,</h2>
										<div class="sig sigWrapper" style="height:auto;">
											<div class="typed"></div>
											<canvas class="initial-pad" id="initial-pad" width="300" height="100"></canvas>
										</div>
									</div>

									<button id="btnClearInitial" onclick="clearCanvas('initial-pad')">Clear Initials</button>
								</div>
							</div>
						</div>


					</div>
					<div class="row">
						<div class="col-md-12" style="text-align:center">
							<button id="btnSaveSignInitial">Save Signature and Initials</button><br><br>
						</div>
						<div class="col-md-12" style="text-align:center" style="display:none">
							<p id="txtInfo"></p><br>
						</div>
					</div>
				</div>


		</div>
		</section>
		</div>

		<!-- Jquery Core Js -->
		<script src="js/jquery.min.js"></script>

		<!-- Bootstrap Core Js -->
		<script src="js/bootstrap.min.js"></script>

		<!-- Bootstrap Select Js -->
		<script src="js/bootstrap-select.js"></script>

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		<link href="./css/jquery.signaturepad.css" rel="stylesheet">
		<script src="./js/numeric-1.2.6.min.js"></script>
		<script src="./js/bezier.js"></script>
		<script src="./js/jquery.signaturepad.js"></script>

		<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
		<script src="./js/json2.min.js"></script>

		<script>
			$(document).ready(function() {
				$('#signArea').signaturePad({
					drawOnly: true,
					drawBezierCurves: true,
					lineTop: 90
				});

				$('#initialArea').signaturePad({
					drawOnly: true,
					drawBezierCurves: true,
					lineTop: 90
				});
			});

			// var sig_canvas = null;
			// var initial_canvas = null;
			// $("#btnSaveSign").click(function(e) {
			// 	html2canvas([document.getElementById('sign-pad')], {
			// 		onrendered: function(canvas) {
			// 			sig_canvas = canvas.toDataURL('image/png');
			// 		}
			// 	});
			// });

			// $("#btnSaveInitial").click(function(e) {
			// 	html2canvas([document.getElementById('initial-pad')], {
			// 		onrendered: function(canvas) {
			// 			initial_canvas = canvas.toDataURL('image/png');
			// 		}
			// 	});
			// });

			$("#btnSaveSignInitial").click(function(e) {
				var sig_data = getDataFromCanvasById('sign-pad').replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
				var initial_data = getDataFromCanvasById('initial-pad').replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
				var key = '<?php echo $iddd; ?>';
				$.ajax({
					url: 'save_sign.php',
					data: {
						sig_data: sig_data,
						initial_data: initial_data,
						key: key
					},
					type: 'post',
					dataType: 'json',
					success: function(response) {
						window.location.href = "../files/sign_contract.php?id=<?php echo $iddd; ?>";
					},
					error: function(res) {
						console.log(res);
					}
				});
			});


			function getDataFromCanvasById(elemId) {
				var html2obj = html2canvas(document.getElementById(elemId));
				var queue = html2obj.parse();
				var canvas = html2obj.render(queue);
				var data = canvas.toDataURL('image/png');
				return data;
			}

			function clearCanvas(elemId){
				var canvas = document.getElementById(elemId);
				const context = canvas.getContext('2d');
				context.clearRect(0, 0, canvas.width, canvas.height);
			}
		</script>








	</body>

	</html>

	<?php

	include 'dbconnect.php';
	include 'dbconfig.php';
	$iddd = $_GET['id'];
	$sql_link = mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' ");

	while ($row_link = mysqli_fetch_array($sql_link)) {

		$mail_key_link = $row_link['email_key'];
		//echo $mail_key_link;
	}

	$url_link = "https://lsbankingportal.com/signature_commercial_loan/files/index.php?id=$mail_key_link";

	?>



	<iframe src="<?php echo $url_link; ?>" width="100%" height="900"></iframe>
<?php } ?>