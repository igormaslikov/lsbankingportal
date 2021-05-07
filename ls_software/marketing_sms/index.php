<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script src="jquery-3.2.1.min.js"></script>
  
  <style>
body {
	font-family: Arial;
	width: 550px;
}

.outer-scontainer {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 20px;
	border-radius: 2px;
}

.input-row {
	margin-top: 0px;
	margin-bottom: 20px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
	color: #f0f0f0;
	font-size: 0.9em;
	width: 128px;
	border-radius: 2px;
	cursor: pointer;
	margin-left: -18px;
}

.outer-scontainer table {
	border-collapse: collapse;
	width: 100%;
}

.outer-scontainer th {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.outer-scontainer td {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}


.wrapper {
    width: 100%;
    max-width: 1330px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
</script>

</head>
<body>




<?php
error_reporting(0);

include_once 'dbconfig.php';

if (isset($_POST["import"])) {
    $msg = $_POST['message'];
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into marketing_sms (phone_number,message,status)
                   values ('" . $column[0] . "','$msg','0')";
            $result = mysqli_query($con, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>

    <h2>Import CSV file</h2>
    
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    <div class="outer-scontainer wrapper">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <h3>Enter Message To Send.</h3>
                <textarea name="message" style="margin: 0px; height: 267px; width: 491px;"></textarea>
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Bulk SMS with Twilio</button>
                    <br />

                </div>

            </form>

        </div>
               <?php
               $count=1;
            $sqlSelect = "SELECT * FROM marketing_sms where status='1' ORDER BY sms_id DESC LIMIT 5";
            $result = mysqli_query($con, $sqlSelect);
            
            if (mysqli_num_rows($result) > 0) {
                ?>
            <table id='userTable'>
            <thead>
                <h3>Last 5 SMS Sent:</h3>
                <tr>
                    <th>SMS ID</th>
                    <th>Phone Number</th>
                    

                </tr>
            </thead>
<?php
                
                while ($row = mysqli_fetch_array($result)) {
                    ?>
  
                <tbody>
                <tr>
                    <td><?php  echo $count++ ?></td>
                    <td><?php  echo $row['phone_number']; ?></td>
                    
                </tr>
                    <?php
                }
                ?>
                </tbody>
        </table>
        <?php } ?>

<!-- TOTAL SMS SENT STARTS -->
        
 <?php
      $rowcount = 0;
$con=mysqli_connect("localhost","db2lsuser2021","^%D24L*!Ti5%","dbs64065");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * FROM marketing_sms WHERE status='1'";

if ($result=mysqli_query($con,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  //printf("Result set has %d rows.\n",$rowcount);
  // Free result set
  mysqli_free_result($result);
  }

echo"<br><b>TOTAL SMS SENT :</b><span style='color:red;font-size:20px;'>" .$rowcount."</span>";
mysqli_close($con);
?>          



<!-- TOTAL SMS SENT ENDS -->


<!-- QUEUED SMS STARTS -->

<?php
$con=mysqli_connect("localhost","
db2lsuser2021","^%D24L*!Ti5%","dbs64065");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * FROM marketing_sms WHERE status='0'";


if ($result=mysqli_query($con,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  //printf("Result set has %d rows.\n",$rowcount);
  // Free result set
  mysqli_free_result($result);
  }

echo"<br><b>TOTAL QUEUED SMS :</b><span style='color:red;font-size:20px;'>" .$rowcount."  </span>";
mysqli_close($con);
?>    
        
        <!-- QUEUED SMS ENDS -->
        
        
    </div>

</body>

</html>