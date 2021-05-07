<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';

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
include_once '../dbconnect.php';
include_once '../dbconfig.php';
$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
$contract_status=$row_fnd['contract_status'];
$contract_db=$row_fnd['contract'];
//echo "FND_ID" .$user_fnd_id;
}

?>

<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;

?>




<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

$sql=mysqli_query($con, "select * from tbl_personal_loans where user_fnd_id= '$user_fnd_id' AND p_loan_id = '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['p_loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');

if ($amount_loan !='0')
{
   
   $val="$";
}

//echo "Amount is:".$amount_loan;

$amount_left =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$next_payment =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['contract_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];

 $timestamp = strtotime($creation_date);

$new_creation_date= date("m-d-Y", $timestamp);
}

?>

<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;

?>



<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

$sql_user=mysqli_query($con, "select * from tbl_loan_notes where loan_id= '$id'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$loan_notes=$row_user['notes'];

}

//echo "fname is:".$loan_notes;

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



<style>
body {
  font-family: Verdana, sans-serif;
  margin: 0;
}

* {
  box-sizing: border-box;
}

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

/* The CClose Button */
.cclose {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.cclose:hover,
.cclose:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

/* The CCClose Button */
.ccclose {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.ccclose:hover,
.ccclose:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

/* The CCCClose Button */
.cccclose {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.cccclose:hover,
.cccclose:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
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
<div class="col-lg-4"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-4"><p>Money Amount: <b style="color:red"> <?php echo $val.$amount_loan.$variable;?></b></p></div>
<div class="col-lg-4"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>

       <br> <br>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
           
           <div class="row">
                <div class="col-lg-6">
        <h3>Documents For Client <?php echo $first_name.' '.$last_name?></h3>
    
    </div>
             <div class="col-lg-6">  
           <form action ="" method="POST" enctype="multipart/form-data">
      <div class="buttonHolder" align="right">
   <a href="lender_documents.php?id=<?php echo $id;?>" <button name="btttn-submit" type="submit"  class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New Documents</button></a>
    </div>
    
    </form> 
    </div>
   
     </div>
             
   <table class="table table-striped table-bordered">

    <tr>
<th>Picture Of ID</th>
<th>Bank Front</th>
<th>Bank Back</th>
<th>Void Image</th>
<th>Contract</th>
</tr>
<?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';

 $id=$_GET['id'];
 
$sql_fnd=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$state=$row_fnd['state'];
//echo "FND_ID" .$user_fnd_id;
}
if ($state=="AZ")
{
$address_contarct="https://lsbankingportal.com/signature_personal_arizona_customer";
}

if ($state=="NV")
{
$address_contarct="https://lsbankingportal.com/signature_personal_naveda_customer";
}


$sql_bank_detail=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id = '$user_fnd_id'"); 

while($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {

$sql_mail_key=mysqli_query($con, "select * from personal_loan_initial_banking where user_fnd_id = '$user_fnd_id'"); 

while($row_mail_key = mysqli_fetch_array($sql_mail_key)) {

$mail_key=$row_mail_key['email_key'];



}

$id_photo=$row_bank_detail['id_photo'];
$bank_front=$row_bank_detail['bank_front'];
$bank_back=$row_bank_detail['bank_back'];
$void_img=$row_bank_detail['void_img'];

if($id_photo == ''){
    echo '
    <style>
    .id_photo{
        display:none;
    }
    </style>
    ';
}
if($bank_front == ''){
    echo '
    <style>
    .bankfront{
        display:none;
    }
    </style>
    ';
}
if($bank_back == ''){
    echo '
    <style>
    .bankback{
        display:none;
    }
    </style>
    ';
}
if($void_img == ''){
    echo '
    <style>
    .voidimg{
        display:none;
    }
    </style>
    ';
}

        
        
         echo"<tr>
        
        <td> <img id='myImg' src ='../../../ls_software/dl_client_files/photo_id/$id_photo' target='_blank' style='height:100px; width:100px' > <br><br><a href ='change_id_pic.php?id=$id'>Change/Update</a></td>
        
        
        <td> <img id='mmyImg' src ='../../../ls_software/dl_client_files/bank_front_image/$bank_front'  style='height:100px; width:100px' /> <br><br><a href ='change_bank_front.php?id=$id'>Change/Update</a></td>
        
         <td><img id='mmmyImg' src ='../../../ls_software/dl_client_files/bank_back_image/$bank_back' style='height:100px; width:100px'  /> <br><br> <a href ='change_bank_back.php?id=$id'>Change/Update</a></td>
        
        
          <td><img id='mmmmyImg' src ='../../../ls_software/dl_client_files/void_img/$void_img' style='height:100px; width:100px' /><br><br> <a href ='change_void_img.php?id=$id'>Change/Update</a></td>
        
        
        <td><a onclick='myFunction_contract()' target = '_blank' class='remove-box' href='$address_contarct/files/sign_contract.php?id=$mail_key' target='_blank' title='View Contract'>View Contract</a>"?><?php
        echo"<br><br>";
        if($contract_status=='1')
        {
        echo "<a onclick='myFunction_contract_manual()' target = '_blank' class='remove-box' href='https://lsbankingportal.com/ls_software/admin/loan-personal/uploads_contract/$contract_db?id=$id' target='_blank' title='View Contract'>View Echeck Contract</a>";
        }
        else{
           echo "<a href ='upload_contract.php?id=$id'>Upload Echeck Contract</a>";
        }
       echo" </td>
        
        </tr>";
       
        
        
        
}      

?>
   
</tbody>
</table>    
       
       
             
             
        <table class="table table-striped table-bordered">

    <tr>
<th>Date</th>
<th>File Name</th>
<th>Action</th>
<th>Created By</th>
</tr>
    
<?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';

 $id=$_GET['id'];
 
$sql_fnd=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];

//echo "FND_ID" .$user_fnd_id;
}

$sql_bank_detail=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id = '$user_fnd_id'"); 

while($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {

$mail_key=$row_bank_detail['email_key'];

$id_photo=$row_bank_detail['pic_of_id'];
$bank_front=$row_bank_detail['bank_front_pic'];
$bank_back=$row_bank_detail['bank_back_pic'];
$void_img=$row_bank_detail['void_check_pic'];

}



$sql_doc=mysqli_query($con, "select * from lender_documents where fnd_user_id = '$user_fnd_id' ORDER BY id desc"); 
//echo $sql_doc;
while($row_doc = mysqli_fetch_array($sql_doc)) {
    
$doc_id = $row_doc['id'];
$date_created=$row_doc['date_created'];
$file_name=$row_doc['file_name'];
$created_by=$row_doc['created_by'];
$description_name=$row_doc['description'];


$sql_lender_by_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 
$final_lender_by_user = '';
while($row_sql_lender_by_user = mysqli_fetch_array($sql_lender_by_user)) {
	$final_lender_by_user = $row_sql_lender_by_user['username'];
}
        
        
         echo"<tr>
        
         <td>$date_created</td>
       <td>$description_name</td>
        <td> <a  onclick='myFunction_document()' target = '_blank' href = '../uploads_lender_documents/$file_name'>View Now</a> - <a class='remove-box' href='delete_lender_documents.php?id=$user_fnd_id&doc_id=$doc_id&loan_id=$id' title='Delete This Document'>Delete</a></td>
        
         <td>$final_lender_by_user</td>
         </tr>";
       
        
        
        
        
        
}
?>
   
</tbody>
</table>

 
 
 
 <!-- The Picture Of Id Image -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>


<script>

var modal = document.getElementById("myModal");

var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
 
 <!--ID image end-->
 
 <!--Bank Front Start-->
 
 <div id="mmyModal" class="modal">
  <span class="cclose">&times;</span>
  <img class="modal-content" id="img001">
  <div id="ccaption"></div>
</div>

<script>

var modal = document.getElementById("mmyModal");

var img = document.getElementById("mmyImg");
var modalImg = document.getElementById("img001");
var captionText = document.getElementById("ccaption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

var span = document.getElementsByClassName("cclose")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
 
 
 
 
 
 <!--Bank Front END-->
 
 
 
 <!--Bank Back Start-->
 
 <div id="mmmyModal" class="modal">
  <span class="ccclose">&times;</span>
  <img class="modal-content" id="img0001">
  <div id="cccaption"></div>
</div>

<script>

var modal = document.getElementById("mmmyModal");

var img = document.getElementById("mmmyImg");
var modalImg = document.getElementById("img0001");
var captionText = document.getElementById("cccaption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

var span = document.getElementsByClassName("ccclose")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
 
 
 
 
 
 <!--Bank Back END-->
 
 
 <!--Void Img Start-->
 
 <div id="mmmmyModal" class="modal">
  <span class="cccclose">&times;</span>
  <img class="modal-content" id="img00001">
  <div id="ccccaption"></div>
</div>

<script>

var modal = document.getElementById("mmmmyModal");

var img = document.getElementById("mmmmyImg");
var modalImg = document.getElementById("img00001");
var captionText = document.getElementById("ccccaption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

var span = document.getElementsByClassName("cccclose")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
 
 
 
 
 
 <!--Void Img END-->
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

<script>
$(document).ready(function(){
    $('#pdf_file').trigger('click');
};)
</script>

<div id="document" style="display:none; color:red">
 
 <b onclick="myFunction_document()">Close (X)</b>
 <iframe name="document"  style=" width:100%; height: 700px">
 </iframe>
 </div>
 <script>
function myFunction_document() {
  var x = document.getElementById("document");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

 

 <div id="contract" style="display:none; color:red">
 
 <b onclick="myFunction_contract()">Close (X)</b>
 <iframe name="contract"  style=" width:100%; height: 700px">
 </iframe>
 </div>
 <script>
function myFunction_contract() {
  var x = document.getElementById("contract");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>



<div id="contract_manual" style="display:none; color:red">
 
 <b onclick="myFunction_contract_manual()">Close (X)</b>
 <iframe name="contract"  style=" width:100%; height: 700px">
 </iframe>
 </div>
 <script>
function myFunction_contract_manual() {
  var x = document.getElementById("contract_manual");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

<br/><br/>

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
