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
if($u_access_id!='1'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';
$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_commercial_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}



$sql=mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
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
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}


$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

$sql_user=mysqli_query($con, "select * from tbl_loan_notes where loan_id= '$id'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$loan_notes=$row_user['notes'];

}

//echo "fname is:".$loan_notes;

$sql_fnd=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {
    
$first_name=$row_fnd['first_name'];
$last_name=$row_fnd['last_name'];
$full_name= $first_name.' '.$last_name;
$email=$row_fnd['email'];
$mobile_number=$row_fnd['mobile_number'];
$address=$row_fnd['address'];
$city=$row_fnd['city'];
$state=$row_fnd['state'];
$zip=$row_fnd['zip_code'];
$date_of_birth_db=$row_fnd['date_of_birth'];

       $timestamp = strtotime($date_of_birth_db);
       $date_of_birth= date("m-d-Y", $timestamp);
       
$ssn=$row_fnd['ssn']; 
$id_photo=$row_fnd['customer_img'];
$block_status=$row_fnd['block_status'];
$block_by=$row_fnd['block_by'];

}

$sql_bank_detail=mysqli_query($con, "select * from commercial_loan_initial_banking where user_fnd_id = '$user_fnd_id'"); 

while($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {
    
    	$type_of_id=$row_bank_detail['type_of_id'];

}


$sql_block=mysqli_query($con, "select * from tbl_users where user_id= '$block_by'"); 

while($row_block = mysqli_fetch_array($sql_block)) {

$blocked_by=$row_block['username'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<style>
.buttonHolder{ text-align: left; 
    margin-left: 15px;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

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
<div class="col-lg-4"><p>Customer Phone:<b style="color:red"> <?php echo $mobile_number;?> </b> </p></div>
<div class="col-lg-4"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-4"><p>Loan Amount: <b style="color:red"> <?php echo $val.$amount_loan.$variable;?></b></p></div>
<div class="col-lg-4"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>
<?php
if($block_status=='5'){

      echo "<div class='row container-fluid' style='background-color: red;color:black;padding:20px;'>
          <b style='text-align:center;'> This User has been blacklisted by $blocked_by</b>

    </div>";

}
?>
   <br><br>
 
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
            <h3>Customer Information: </h3><br>
        
        </div>
        
        <div class="col-lg-6">
            <form action="" method="post" enctype="multipart/form-data">
                 <?php
     if($block_status=='0'){
         echo"
            <span class='glyphicon glyphicon-ban-circle' aria-hidden='true' alt='Block This Customer' style='font-size:35px;'><button name='btn-block' type='submit' style='height:35px;width:35px;'><img src='imgs/ban.png' height='35px'; width='35px' style='margin-top: -32px;margin-left: -7px;'/></button></span> <span style='font-size:35px;margin-left: 5px;'>Blacklist</span>";
        }
         else {
         echo"
	<span class='glyphicon glyphicon-ban-circle' aria-hidden='true' alt='Block This Customer' style='font-size:35px;'><button name='btn-unblock' type='submit' style='height:35px;width:35px;'><img src='imgs/ban.png' height='35px'; width='35px' style='margin-top: -32px;margin-left: -7px;'/></button></span> <span style='font-size:35px;margin-left: 5px;'>Remove from Blacklist</span>";
       
     }
        ?>
        </form>
        </div>
        
     <?php
if(isset($_POST['btn-block'])) {

mysqli_query($con,"UPDATE fnd_user_profile SET block_status ='5', block_by ='$u_id' where user_fnd_id= '$user_fnd_id' ");

}

?>
<?php
if(isset($_POST['btn-unblock'])) {

mysqli_query($con,"UPDATE fnd_user_profile SET block_status ='0', block_by ='$u_id' where user_fnd_id= '$user_fnd_id' ");

}

?>   
        
        
        
         </div>
    <img style="height:150px;border-radius: 10px;"<?php if($id_photo == ''){ echo 'src="imgs/DP.jpg';} else { ?> src="../../dl_client_files/customer_imgs/<?php echo $id_photo; } ?>"/>
    <br>
    
     
   <a href="upload_user_img.php?id=<?php echo $id;?>"> <button name="btn" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Change Picture</button></a>
    
     
  

    <div class="col-lg-12">
    
    <br><br>
    <form action ="" method="POST" enctype="multipart/form-data">
         <div class="form-group" >
    <div class="row">
    <div class="col-lg-6">
      <label for="usr">First Name</label>
      <input type="text" name="full_name" class="form-control" id="usr" placeholder="Full Name" value="<?php echo $first_name; ?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Last Name</label>
      <input type="text" name="last_name" class="form-control" id="usr" placeholder="Full Name" value="<?php echo $last_name; ?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">SSN</label>
      <input type="text" name="ssn" class="form-control" id="usr" placeholder="SSN" value="<?php echo $ssn; ?>" >
    </div>
     <div class="col-lg-6">
      <label for="usr">Date of Birth</label>
      <input type="text" name="dob" class="form-control" id="usr" placeholder="Date of Birth" value="<?php echo $date_of_birth; ?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Email Address</label>
      <input type="text" name="email" class="form-control" id="usr" placeholder="Email Address" value="<?php echo $email; ?>" >
      <a href='mailto:<?php echo $email; mail($email, $subject, $message, $headers); ?>'>Send Email via Outlook</a>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone Number</label>
      <input type="text" name="ph_numbr" class="form-control" id="usr" placeholder="Phone Number" value="<?php echo $mobile_number; ?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Primary Address</label>
      <input type="text" name="p_address" class="form-control" id="usr" placeholder="Primary Address" value="<?php echo $address; ?>" >
    </div>
    
    <div class="col-lg-3">
      <label for="usr">City</label>
      <input type="text" name="city"  class="form-control" id="usr" value="<?php echo $city;?>">
    </div>
    
    <div class="col-lg-1">
      <label for="usr">State</label>
      <input type="text" name="state"  class="form-control" id="usr" value="<?php echo $state;?>">
    </div>
    
    <div class="col-lg-2">
      <label for="usr">Zip Code</label>
      <input type="text" name="zip_code"  class="form-control" id="usr" value="<?php echo $zip;?>">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Type of ID & Number</label>
     <select name="type_id" id="type_id" class="form-control"  value="" >
     <option></option>
     <option value="Drivers License" <?php if($type_of_id=='Drivers License'){ echo 'selected';} ?>>Drivers License</option>
      <option value="State Personal ID" <?php if($type_of_id=='State Personal ID'){ echo 'selected';} ?>>State Personal ID</option>
      <option value="Matricula Consular ID" <?php if($type_of_id=='Matricula Consular ID'){ echo 'selected';} ?>>Matricula Consular ID</option>
      <option value="Tribal ID" <?php if($type_of_id=='Tribal ID'){ echo 'selected';} ?>>Tribal ID</option>
      <option value="Passport" <?php if($type_of_id=='Passport'){ echo 'selected';} ?>>Passport</option>
      <option value="Military ID" <?php if($type_of_id=='Military ID'){ echo 'selected';} ?>>Military ID</option>
      <option value="Other" <?php if($type_of_id=='Other'){ echo 'selected';} ?>>Other</option>
     </select>
    </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6">
        <span style="font-weight:bold">Reference1: </span><br>
        </div>
         <div class="col-lg-6">
        </div>
        
    <div class="col-lg-6">
      <label for="usr">Name</label>
      <input type="text" name="ref_name" class="form-control" id="usr" placeholder="Name" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone</label>
      <input type="text" name="ref_phone" class="form-control" id="usr" placeholder="Phone" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Relationship</label>
      <input type="text" name="ref_relation" class="form-control" id="usr" placeholder="Relationship" value="" >
    </div>
    
    
    </div>
    <br>
     <div class="row">
        <div class="col-lg-6">
        <span style="font-weight:bold">Reference2: </span><br>
        </div>
         <div class="col-lg-6">
        </div>
        
    <div class="col-lg-6">
      <label for="usr">Name</label>
      <input type="text" name="ref_name2" class="form-control" id="usr" placeholder="Name" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone</label>
      <input type="text" name="ref_phone2" class="form-control" id="usr" placeholder="Phone" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Relationship</label>
      <input type="text" name="ref_relation2" class="form-control" id="usr" placeholder="Relationship" value="" >
    </div>
    </div>
    <br>
     <div class="row">
        <div class="col-lg-6">
        <span style="font-weight:bold">Reference3: </span><br>
        </div>
         <div class="col-lg-6">
        </div>
        
    <div class="col-lg-6">
      <label for="usr">Name</label>
      <input type="text" name="ref_name3" class="form-control" id="usr" placeholder="Name" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone</label>
      <input type="text" name="ref_phone3" class="form-control" id="usr" placeholder="Phone" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Relationship</label>
      <input type="text" name="ref_relation3" class="form-control" id="usr" placeholder="Relationship" value="" >
    </div>
     </div>
    <br>
     <div class="row">
        <div class="col-lg-6">
        <span style="font-weight:bold">Reference4: </span><br>
        </div>
         <div class="col-lg-6">
        </div>
        
    <div class="col-lg-6">
      <label for="usr">Name</label>
      <input type="text" name="ref_name4" class="form-control" id="usr" placeholder="Name" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone</label>
      <input type="text" name="ref_phon4" class="form-control" id="usr" placeholder="Phone" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Relationship</label>
      <input type="text" name="ref_relation4" class="form-control" id="usr" placeholder="Relationship" value="" >
    </div>
   </div>
    </div>
    <br>
    <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
    </form>
</div>
 </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
 <?php
  if(isset($_POST['btn-submit'])) {
    

$first_name_update =$_POST['full_name'];
$last_name_update =$_POST['last_name'];
$ssn_update =$_POST['ssn'];
$dob_update =$_POST['dob'];
$email_update =$_POST['email'];
$phone_number_update =$_POST['ph_numbr'];
$address_update =$_POST['p_address'];
$city_update =$_POST['city'];
$state_update =$_POST['state'];
$zip_update =$_POST['zip_code'];
$type_id_update =$_POST['type_id'];

$date= date('Y-m-d H:i:s');

  
  
  
  mysqli_query($con, "UPDATE fnd_user_profile SET first_name ='$first_name_update' , last_name='$last_name_update' , mobile_number='$phone_number_update' , email='$email_update', address='$address_update', city='$city_update', state='$state_update',  zip_code='$zip_update', date_of_birth='$dob_update', ssn='$ssn_update' where user_fnd_id ='$user_fnd_id'"); 


mysqli_query($con, "UPDATE commercial_loan_initial_banking SET type_of_id ='$type_id_update'  where user_fnd_id ='$user_fnd_id'"); 

  
      
  }
?>
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
