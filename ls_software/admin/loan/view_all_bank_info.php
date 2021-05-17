<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php
$id=$_GET['id'];



 

$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
$payoff=$row_fnd['loan_total_payable'];
$loan_status=$row_fnd['loan_status'];
}



$query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction where loan_id= '$id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}

$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row_loan = mysqli_fetch_array($sql_loan)) {

$loan_id=$row_loan['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row_loan['amount_of_loan'];

if ($amount_loan !='0')
{
   
   $val="$";
}

//echo "Amount is:".$amount_loan;

$amount_left =$row_loan['loan_total_payable'];

$payment_tenure =$row_loan['payment_tenure'];
$escrow=$row_loan['escrow'];
$primary_port=$row_loan['primary_portfolio'];
$creation_date=$row_loan['contract_date'];
$created_by=$row_loan['created_by'];
$last_update=$row_loan['last_update_by'];
$last_update_date=$row_loan['last_update_date'];

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}




$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> </div>
      <div class="list-group list-group-flush">
 
        <?php include('vertical_menu.php'); ?>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
       <?php include('horizontal_menu.php'); ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

       
      </nav>
      <br>
      
      <div class="row container-fluid" style="background-color: #F5E09E;color:black;padding:20px;">

<div class="col-lg-4"><p>Customer First Name:<b style="color:red"> <?php echo $first_name;?></b></p></div>
<div class="col-lg-4"><p>Customer Last Name: <b style="color:red"><?php echo $last_name;?> </b></p></div>
<div class="col-lg-4"><p>Customer Phone:<b style="color:red"> <?php echo $customer_numbr;?> </b> </p></div>
<div class="col-lg-3"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-3"><p>Money Amount: <b style="color:red"> <?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
<br><br><br><br>

      <div class="container-fluid">
         <div class="row"> 
         <div class="col-lg-4">
<h3>All Banks Info</h3>

</div>

<div class="col-lg-4" align="center">
</div>

   <div class="col-lg-4" align="right">
 <a href="add_secondary_bank.php?id=<?php echo $id; ?>"> <button name="btn" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);
    color: #fff;
    background-color: red;
    border-color: red;">Add Secondary Bank</button></a>

</div>


          
</div>
    <br>      
          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:10%;color:black;'>Loan ID</th>
<th style='width:15%;color:black;'>Bank Name</th>
<th style='width:15%;color:black;'>Account Number</th>
<th style='width:15%;'>Type of Card</th>
<th style='width:15%;color:black;'>Card Number</th>
<th style='width:10%;color:black;'>Routing Number</th>

<th style='width:7%;color:black;'>EXP Date </th>
<th style='width:15%;color:black;'>Action</th>
</tr>
</thead>
<tbody>
    
    
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';;
$count=1;
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	$count = $count + (25*($page_no-1));
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 25;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM loan_initial_banking where user_fnd_id = '$user_fnd_id'");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

   $sql_loan=mysqli_query($con, "select * from loan_initial_banking where user_fnd_id = '$user_fnd_id'  GROUP BY `card_number`, `card_exp_date` ORDER BY initial_id DESC"); 

while($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
       $loan_create_idd=$row_bank_detail_sec['loan_id'];
       $initial_id=$row_bank_detail_sec['initial_id'];
       $type_of_id_sec=$row_bank_detail_sec['type_of_id'];
$id_photo_sec=$row_bank_detail_sec['pic_of_id'];
$type_of_card_sec=$row_bank_detail_sec['type_of_card'];

$card_number_sec=$row_bank_detail_sec['card_number'];
$card_exp_date_sec=$row_bank_detail_sec['card_exp_date'];
$bank_front_sec=$row_bank_detail_sec['bank_front_pic'];

$bank_back_sec=$row_bank_detail_sec['bank_back_pic'];
$bank_name_sec=$row_bank_detail_sec['bank_name'];
$routing_number_sec=$row_bank_detail_sec['routing_number'];

$account_number_sec=$row_bank_detail_sec['account_number'];
$void_img_sec=$row_bank_detail_sec['void_check_pic'];
$cvv_number_sec=$row_bank_detail_sec['cvv_number'];
$primary_status=$row_bank_detail_sec['primary_status'];
          
	
	       
            
		echo "<tr>
		      <td>".$loan_create_idd."</td>
	 	      <td>".$bank_name_sec."</td>
	 		  <td>".$account_number_sec."</td>
			  <td>".$type_of_card_sec."</td>
	 		  <td>".$card_number_sec."</td>
	 		  <td>".$routing_number_sec."</td>
	 		  <td>".$card_exp_date_sec."</td>
	 		  <td><a href='banking_detail.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Edit This User'>Edit</a> - 

<a class='remove-box' style='display:none' href='delete_bank_info.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Delete This User'>Delete</a> -
<a class='remove-box' href='add_secondary_card.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Add Card'>Add Another Card</a>

</td>
		   	  

		   	  </tr>";
        }

    ?>
   
</tbody>
</table>
<br>
<h3>All Cards Info</h3>

          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:16%;'>Type of Card</th>
<th style='width:16%;color:black;'>Card Number</th>
<th style='width:18%;color:black;'>Account Number</th>
<th style='width:15%;color:black;'>Routing Number</th>
<th style='width:17%;color:black;'>Action</th>
</tr>
</thead>
<tbody>
    
    
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';;
$count=1;
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	$count = $count + (25*($page_no-1));
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 25;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM  tbl_bank_cards where user_fnd_id = '$user_fnd_id'");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

   $sql_loan=mysqli_query($con, "select * from  tbl_bank_cards where user_fnd_id = '$user_fnd_id'"); 

while($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
       $initial_id=$row_bank_detail_sec['bank_id'];
       $type_of_id_sec=$row_bank_detail_sec['type_of_id'];
$id_photo_sec=$row_bank_detail_sec['pic_of_id'];
$type_of_card_sec=$row_bank_detail_sec['type_of_card'];

$card_number_sec=$row_bank_detail_sec['card_number'];
$card_exp_date_sec=$row_bank_detail_sec['card_exp_date'];
$bank_front_sec=$row_bank_detail_sec['bank_front_pic'];

$bank_back_sec=$row_bank_detail_sec['bank_back_pic'];
$bank_name_sec=$row_bank_detail_sec['bank_name'];
$routing_number_sec=$row_bank_detail_sec['routing_number'];

$account_number_sec=$row_bank_detail_sec['account_number'];
$void_img_sec=$row_bank_detail_sec['void_check_pic'];
$cvv_number_sec=$row_bank_detail_sec['cvv_number'];
$primary_status=$row_bank_detail_sec['primary_status'];
          
	
	       
            
		echo "<tr>
	 	      
			  <td>".$type_of_card_sec."</td>
	 		  <td>".$card_number_sec."</td>
	 		  <td>".$account_number_sec."</td>
	 		  <td>".$routing_number_sec."</td>
	 		  <td><a href='edit_card.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Edit This User'>Edit</a> - 

<a class='remove-box' href='delete_card.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Delete This User'>Delete</a>

</td>
		   	  

		   	  </tr>";
        }

    ?>
   
</tbody>
</table>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
<?php
}
?>
</body>

</html>
