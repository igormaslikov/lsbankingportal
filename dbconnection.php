<?php 
	//  //$db_host = "50.62.151.36";
	//  $db_host = "localhost";
	//  //$db_host = "161.97.149.121";
	//  $db_user = "dblsuser2021";
	//  $db_pass = "^%D24L*!Ti5%";
	//  $db_name = "dbs57337";

	$db_host = "213.136.93.169";
	//$db_host = "localhost";
	$db_user = "ki902621_ofsca_portal_user";
	$db_pass = "(a%Dk?jE0o*e";
	$db_name = "ki902621_ofsca_portal";

	$if_optima = "NOT LIKE";
	$if_optima_loan_id = "loan_create_id < 90000";
	if (isset($_SESSION['Optima']) && ($_SESSION["Optima"] == "true" or $_SESSION["Optima"] == "True")) {

		$if_optima = "LIKE";
		$if_optima_loan_id = "loan_create_id >= 90001";

		// $and_check = 1;
	}

?>