<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <!-- Bootstrap core CSS -->
 
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

<style>
table,th, td {
  border: 1px solid black;
}
</style>
</head>

<body>
    

    <div id="page-content-wrapper">

<?php  
 //load_data.php  
 include_once '../dbconnect.php';
include_once '../dbconfig.php';  


	// load records using select box jquery ajax in PHP
	$city_name = $_POST['cityname'];

	$query = "SELECT * FROM loan_initial_banking WHERE card_number = '$city_name' limit 1";

	$result = $con->query($query);
	$output = "";

	if ($result->num_rows > 0) {
		
	
		while ($row = $result->fetch_assoc()) {
		    $output .="<div class='row'>";
		$output .= "<div class='col-lg-6'>
      <label for='usr'>CVV</label>
      <input type='text' name='cvv' class='form-control' id='usr' placeholder='' value='".$row['cvv_number']."' required>
    </div>";
    
    $output .= "<div class='col-lg-6'>
      <label for='usr'>Card Exp</label>
      <input type='text' name='exp' class='form-control' id='usr' placeholder='' value='".$row['card_exp_date']."' required>
    </div>";
    $output .="</div>";
		}					    
					    
		
		echo $output;
	}else{
		echo "No records found";
	}

 ?>  
 </div>
 </body>

</html>