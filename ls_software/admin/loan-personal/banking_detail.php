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
 
$sql_fnd=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


$sql_bank_detail=mysqli_query($con, "select * from personal_loan_initial_banking where user_fnd_id = '$user_fnd_id'"); 

while($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {

$type_of_id=$row_bank_detail['type_of_id'];
$id_photo=$row_bank_detail['pic_of_id'];
$type_of_card=$row_bank_detail['type_of_card'];

$card_number=$row_bank_detail['card_number'];
$card_exp_date=$row_bank_detail['card_exp_date'];
$bank_front=$row_bank_detail['bank_front_pic'];

$bank_back=$row_bank_detail['bank_back_pic'];
$bank_name=$row_bank_detail['bank_name'];
$routing_number=$row_bank_detail['routing_number'];

$account_number=$row_bank_detail['account_number'];
$void_img=$row_bank_detail['void_check_pic'];
$cvv_number=$row_bank_detail['cvv_number'];

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

$sql=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');

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
<div class="col-lg-4"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-4"><p>Loan Amount: <b style="color:red">$<?php echo $amount_loan;?></b></p></div>
<div class="col-lg-4"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>
      <br><br>
      
      <?php
      include_once '../dbconnect.php';
      include_once '../dbconfig.php';
      
     if(isset($_POST['btn-submit'])) 
{
    
    
     $type_id_up= $_POST['type_id'];
     $type_card_up= $_POST['type_card'];
     $card_exp_date_up= $_POST['card_exp_date'];
     $card_number_up= $_POST['card_number'];
    
     $bank_name_up= $_POST['bank_name'];
     $routing_number_up= $_POST['routing_number'];
     $account_number_up= $_POST['account_number'];
     $cvv_number_up= $_POST['cvv_number'];
        
        
        $imgFile = $_FILES['file_image']['name'];
        $tmp_dir = $_FILES['file_image']['tmp_name'];
        $imgSize = $_FILES['file_image']['size'];
        
        $imgFilee = $_FILES['imageee']['name'];
        $tmp_dirr = $_FILES['imageee']['tmp_name'];
        $imgSizee = $_FILES['imageee']['size'];
        
        $imgFileee = $_FILES['imageeee']['name'];
        $tmp_dirrr = $_FILES['imageeee']['tmp_name'];
        $imgSizeee = $_FILES['imageeee']['size'];
        
        $imgFileeee = $_FILES['imageeeee']['name'];
        $tmp_dirrrr = $_FILES['imageeeee']['tmp_name'];
        $imgSizeeee = $_FILES['imageeeee']['size'];
        
        $final_File = "";
        $final_Filee = "";
        $final_Fileee = "";
        $final_Fileeee = "";
        
        
        if(isset($_POST['txt_image'])) 
{
    $final_File = $_POST['txt_image'];
    $final_File= str_replace(" ","","$final_File");
}
else if(isset($_FILES['file_image'])) 
{
        // Upload Picture of ID Starts
    
            $upload_dir = '../../dl_client_files/photo_id/'; // upload directory
    
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;
            $final_File  = $userpic;  
            
                if($imgSize > 0000000)  {
                    // Nothing
                }
                else {
                    $final_File = "";
                }
            // allow valid image file formats
            if(in_array($imgExt, $valid_extensions)){            
                // Check file size '5MB'
                
                if($imgSize < 5000000)                {
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
            
            
    // Upload Picture of ID Ends        
            
}


 if(isset($_POST['txt_file_bf'])) 
{
    $final_Filee = $_POST['txt_file_bf'];
    $final_Filee= str_replace(" ","","$final_Filee");
}
else if(isset($_FILES['imageee'])) 
{
    // Bank Card Front Image Start
     
             $upload_dirrr = '../../dl_client_files/bank_front_image/'; // upload directory
    
            $imgExtt = strtolower(pathinfo($imgFilee,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpicc = rand(1000,1000000).".".$imgExtt;
              $final_Filee = $userpicc; 
                if($imgSizee > 0000000)  {
                    // Nothing
                }
                else {
                    $final_Filee = "";
                }
            // allow valid image file formats
            if(in_array($imgExtt, $valid_extensionss)){            
                // Check file size '5MB'
                if($imgSizee < 5000000)                {
                    move_uploaded_file($tmp_dirr,$upload_dirrr.$userpicc);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
     
     
     // Bank Card Front Image End
}


      if(isset($_POST['txt_file_bb'])) 
{
    $final_Fileee = $_POST['txt_file_bb'];
    $final_Fileee= str_replace(" ","","$final_Fileee");
}
else if(isset($_FILES['imageeee'])) 
{
      // Bank Card Back Image Start
     
             $upload_dirrrr = '../../dl_client_files/bank_back_image/'; // upload directory
    
            $imgExtt = strtolower(pathinfo($imgFileee,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpiccc = rand(1000,1000000).".".$imgExtt;
              $final_Fileee = $userpiccc; 
                if($imgSizeee > 0000000)  {
                    // Nothing
                }
                else {
                    $final_Fileee = "";
                }
            // allow valid image file formats
            if(in_array($imgExtt, $valid_extensionss)){            
                // Check file size '5MB'
                if($imgSizeee < 5000000)                {
                    move_uploaded_file($tmp_dirrr,$upload_dirrrr.$userpiccc);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
     
     
     // Bank Card Back Image End
}



 if(isset($_POST['txt_file_vi'])) 
{
    $final_Fileeee = $_POST['txt_file_vi'];
    $final_Fileeee= str_replace(" ","","$final_Fileeee");
    //echo"<br><br><br><br>".$final_Fileeee;
}
else if(isset($_FILES['imageeeee'])) 
{
     
      // Void Check Image Start
     
             $upload_dirrrrr = '../../dl_client_files/void_img/'; // upload directory
    
            $imgExtt = strtolower(pathinfo($imgFileeee,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpicccc = rand(1000,1000000).".".$imgExtt;
                $final_Fileeee = $userpicccc;
                  if($imgSizeeee > 0000000)  {
                    // Nothing
                }
                else {
                    $final_Fileeee = "";
                }
            // allow valid image file formats
            if(in_array($imgExtt, $valid_extensionss)){            
                // Check file size '5MB'
                if($imgSizeeee < 5000000)                {
                    move_uploaded_file($tmp_dirrrr,$upload_dirrrrr.$userpicccc);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
     
     
     // Void Check Image End
   
} 
     
      mysqli_query($con, "UPDATE personal_loan_initial_banking SET type_of_id='$type_id_up', pic_of_id='$final_File', type_of_card='$type_card_up', card_number='$card_number_up', card_exp_date='$card_exp_date_up', bank_front_pic='$final_Filee', bank_back_pic='$final_Fileee', bank_name='$bank_name_up', routing_number='$routing_number_up', account_number='$account_number_up', void_check_pic='$final_Fileeee', cvv_number='$cvv_number_up' where user_fnd_id ='$user_fnd_id' AND loan_create_id='$loan_create_id'");
      
      
}
      ?>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        

  <form action ="" method="POST" enctype="multipart/form-data">
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">

  <h3>Bank Information</h3>
  <br>
  <div class="row">
      
 <!--<div class="col-lg-6">-->
 <!--     <label for="usr">Type of ID</label>-->
 <!--     <select name="type_id" id="type_id" class="form-control"  value="" >-->
 <!--    <option></option>-->
 <!--    <option value="Drivers License" >Drivers License</option>-->
 <!--     <option value="State Personal ID" >State Personal ID</option>-->
 <!--     <option value="Matricula Consular ID" >Matricula Consular ID</option>-->
 <!--     <option value="Tribal ID" >Tribal ID</option>-->
 <!--     <option value="Passport" >Passport</option>-->
 <!--     <option value="Military ID">Military ID</option>-->
 <!--     <option value="Other">Other</option>-->
 <!--    </select>-->
 <!--   </div> -->
  
     <div class="col-lg-6">
      <label for="usr">Type of Card</label>
      <select name="type_card" id="type_card" class="form-control"  value="" >
     <option></option>
     <option value="Visa" <?php if($type_of_card=='Visa'){ echo 'selected';} ?>>Visa</option>
      <option value="Master Card" <?php if($type_of_card=='Master Card'){ echo 'selected';} ?>>Master Card</option>
     </select>
    </div>
    
   
    
    <div class="col-lg-6">
      <label for="usr">Card Expiration Date</label>
      <input type="date" name="card_exp_date"  class="form-control" id="usr" value="<?php echo $card_exp_date;?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Number</label>
      <input type="text" name="card_number"  class="form-control" id="usr" value="<?php echo $card_number;?>" ><br>
    </div>
    
   
    <div class="col-lg-6">
      <label for="usr">Bank Name</label>
      <select name="bank_name" id="bank_name" class="form-control"  value="" >
     <option></option>
     <option value="Bank Of America" <?php if($bank_name=='Bank Of America'){ echo 'selected';} ?>>Bank Of America</option>
     <option value="Chase" <?php if($bank_name=='Chase'){ echo 'selected';} ?>>Chase</option>
     <option value="Wells Fargo" <?php if($bank_name=='Wells Fargo'){ echo 'selected';} ?>>Wells Fargo</option>
     <option value="Citi Bank " <?php if($bank_name=='Citi Bank'){ echo 'selected';} ?>>Citi Bank </option>
     <option value="US Bank" <?php if($bank_name=='US Bank'){ echo 'selected';} ?>>US Bank</option>
     <option value="HSBC" <?php if($bank_name=='HSBC'){ echo 'selected';} ?>>HSBC</option>
     </select><br>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Routing Number</label>
      <input type="text" name="routing_number"  class="form-control" id="usr" value="<?php echo $routing_number;?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Account Number</label>
      <input type="text" name="account_number"  class="form-control" id="usr" value="<?php echo $account_number;?>" ><br>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr">CVV Number</label>
      <input type="text" name="cvv_number"  class="form-control" id="usr" value="<?php echo $cvv_number;?>" >
    </div>
    
    </div>
       <br> 
       
      
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
    </form>

</div>
</div>
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
