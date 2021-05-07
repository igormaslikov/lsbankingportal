<?php
session_start();

include_once 'dbconnect.php';
include_once 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php

$query = "select * from msg_template where msg_name='past_due' ";
$sql=mysqli_query($con, "$query"); 
  $rowcount=mysqli_num_rows($sql);
while($row = mysqli_fetch_array($sql)) {
    $msg_name = $row['msg_name'];
    $msg_content= $row['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name."</h3>";

}



?>


<?php

$query2 = "select * from msg_template where msg_name='collections' ";
$sql2=mysqli_query($con, "$query2"); 
  $rowcount2=mysqli_num_rows($sql2);
while($row2 = mysqli_fetch_array($sql2)) {
    $msg_name2 = $row2['msg_name'];
    $msg_content2= $row2['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name2."</h3>";

}



?>



<?php

$query3 = "select * from msg_template where msg_name='chargeoff' ";
$sql3=mysqli_query($con, "$query3"); 
  $rowcount3=mysqli_num_rows($sql3);
while($row3 = mysqli_fetch_array($sql3)) {
    $msg_name3 = $row3['msg_name'];
    $msg_content3= $row3['msg_content'];
 echo "<br><br><br>";
 
// echo "<h3> is : ".$msg_content."</h3>";

}



?>



<?php

$query4 = "select * from msg_template where msg_name='closed_account' ";
$sql4=mysqli_query($con, "$query4"); 
  $rowcount4=mysqli_num_rows($sql4);
while($row4 = mysqli_fetch_array($sql4)) {
    $msg_name4 = $row4['msg_name'];
    $msg_content4= $row4['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content4."</h3>";

}



?>

<?php

$query5 = "select * from msg_template where msg_name='chargeback' ";
$sql5=mysqli_query($con, "$query5"); 
  $rowcount5=mysqli_num_rows($sql5);
while($row5 = mysqli_fetch_array($sql5)) {
    $msg_name5 = $row5['msg_name'];
    $msg_content5= $row5['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content5."</h3>";

}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<style>
.wrapper {
    width: 100%;
    max-width: 1340px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
</head>

<body>

<?php include('menu.php') ;?>






    
  <div class ="container wrapper" style="margin-top:100px">


  <div class="row wrapper">

  
  <form action ="" method="POST" enctype="multipart/form-data">
  
  <h3>Add New Daily Message</h3>
  <div class="row">
   
   <div class="col-lg-6" >
      <label for="usr">Add Description</label>
      <input name="description" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
   
   
      
  <div class="col-lg-6" >
      <label for="usr">Type (Application/Loan)</label>
      <select name="status_type" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value=""></option>
<option value="New Application">New Application</option>
<option value="Credit Report Completed">Credit Report Completed</option>
<option value="Decision Logic Completed">Decision Logic Completed</option>
<option value="Credit Report Needed">Credit Report Needed</option>
<option value="Bank Information Needed">Bank Information Needed</option>
<option value="Final Review For Personal Loan">Final Review For Personal Loan</option>
<option value="No Decision Logic For Payday">No Decision Logic For Payday</option>
<option value="Review For Payday">Review For Payday</option>
<option value="Approved Payday Loan">Approved Payday Loan</option>
<option value="Approved Personal Loan">Approved Personal Loan</option>
<option value="Approved Title Loan">Approved Title Loan</option>
<option value="Interview Completed">Interview Completed</option>
<option value="Pending Documents">Pending Documents</option>
<option value="Rejected By Customer">Rejected By Customer</option>
<option value="No Answer">No Answer</option>
<option value="Funded">Funded</option>
<option value="Declined">Declined</option>
<option value="Active">Active</option>
<option value="Paid">Paid</option>
<option value="Past Due">Past Due</option>
<option value="Promise to Pay">Promise to Pay</option>
<option value="Payment Plan">Payment Plan</option>
<option value="Collections">Collections</option>
<option value="Chargeoff">Chargeoff</option>
<option value="Closed Account">Closed Account</option>
<option value="Chargeback">Chargeback</option>
<option value="Bankruptcy">Bankruptcy</option>
</select>
    </div>
  
     <div class="col-lg-6">
      <label for="usr">Status</label>
      <input name="status" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Day</label>
      <select name="day" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value=""></option>
<option value="Sunday">Sunday</option>
<option value="Monday">Monday</option>
<option value="Tuseday">Tuseday</option>
<option value="Wednesday">Wednesday</option>
<option value="Thursday">Thursday</option>
<option value="Friday">Friday</option>
<option value="Saturday">Saturday</option>
</select>
    </div>
    
    <div class="col-lg-3">
      <label for="usr">Hours</label>
      <select name="hours" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value=""></option>
   <option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
</select>
    </div>
    
    
  <div class="col-lg-3">
<label for="usr">Minutes</label>
      <select name="minutes" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value=""></option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
<option value="60">60</option>
</select>
    </div>  
    
    
    
    
    
    
    
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Add Now</button>
  </form>
  
  <br><hr>
 
   <form action ="" method="POST" enctype="multipart/form-data">
  
  <h3 style="color:red;">Message Settings</h3>
  
    
   
   
   

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Past Due Loan Status</label>
      <textarea type="text" name="past_due"  class="form-control" id="usr"  style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content; ?></textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Collections Loan Status</label>
      <textarea type="text" name="collections"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content2; ?></textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Chargeoff Loan Status</label>
      <textarea type="text" name="chargeoff"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content3; ?></textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Closed Account Loan Status</label>
      <textarea type="text" name="closed_account"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content4; ?></textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Chargeback Loan Status</label>
      <textarea type="text" name="chargeback"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content5; ?></textarea>
    </div>
</div>

    <br>
    
      <button name="btn-submit_loan" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;"> Update Message</button>
  </form>
  
  
  
</div>
</div>

  </div></div>
   
<hr>    

</body>
</html>     

<?php 

if(isset($_POST['btn-submit'])) {
 
$description = $_POST['description'];
$status_type = $_POST['status_type'];
$status = $_POST['status'];
$day = $_POST['day'];
$hours = $_POST['hours'];
$minutes = $_POST['minutes'];
$time=$hours.':'.$minutes;
$date = date('Y-m-d H:i:s');
 
 
  echo $time;
$query_sms  = "INSERT INTO daily_sms (description,loan_status,time,day,status,created_at)  VALUES ('$description','$status_type','$time','$day','$status','$date')";
        $result_sms = mysqli_query($con, $query_sms);
        if ($result_sms) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
}
    ?>


<?php 


if(isset($_POST['btn-submit_loan'])) 
{
    
$past_due= $_POST['past_due'];

$collections= $_POST['collections'];

$chargeoff= $_POST['chargeoff'];
$closed_account=$_POST['closed_account'];


$chargeback= $_POST['chargeback'];



mysqli_query($con,"UPDATE msg_template SET msg_content ='$past_due' where msg_name = '$msg_name'");


mysqli_query($con,"UPDATE msg_template SET msg_content ='$collections' where msg_name = '$msg_name2'");

mysqli_query($con,"UPDATE msg_template SET msg_content ='$chargeoff' where msg_name = '$msg_name3'");


mysqli_query($con,"UPDATE msg_template SET msg_content ='$closed_account' where msg_name = '$msg_name4'");


mysqli_query($con,"UPDATE msg_template SET msg_content ='$chargeback' where msg_name = '$msg_name5'");

?>

<script type="text/javascript">
window.location.href = 'daily_sms_with_loan_status.php';
</script>
<?php
}

?>





<?php
}
?>