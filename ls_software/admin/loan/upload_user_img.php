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
   
   $sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id' "); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
//echo "FND_ID" .$user_fnd_id;
}

   ?>
   <?php




$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$id_photo=$row['customer_img'];

}

//echo "fname is:".$first_name;

?>
   <?php
   //echo "loan id:".$loan_id;
   //echo "Fnd id:".$fndd_id;
   
if(isset($_POST['btttn-submit'])) 
{
        $imgFile = $_FILES['file_image']['name'];
        $tmp_dir = $_FILES['file_image']['tmp_name'];
        $imgSize = $_FILES['file_image']['size'];
        
        // Upload Picture of ID Starts
    
            $upload_dir = '../../dl_client_files/customer_imgs/'; // upload directory
    
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;
             
            
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
    
    mysqli_query($con, "UPDATE fnd_user_profile SET customer_img ='$userpic' where user_fnd_id ='$user_fnd_id'");
  ?>
  <script type="text/javascript">
window.location.href = 'user_information.php?id=<?php echo $id;?>';
</script>  
<?php
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
<br><br>
      <div class="container-fluid">
        <form action ="" method="POST" enctype="multipart/form-data">
            <?php
  
  echo '<img style="width:18%;height:150px;border-radius: 10px;" src="../../dl_client_files/customer_imgs/'.$id_photo.'"/>
    <div class="col-lg-6">
      <label for="usr">Upload Customer Picture</label>
      <input type="file" name="file_image"  class="form-control" accept="image/*"><br>
    </div>';
     ?>
    
   
    <button name="btttn-submit" type="submit"  style="color: #fff;background-color: blue;border-color: blue;">Add Image</button>
    
    </form>
        
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
