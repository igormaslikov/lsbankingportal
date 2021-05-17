<?php  
session_start();  
 include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
 
if(!$_SESSION['email'])  
{  
  
    header("Location: login_page.php");//redirect to the login page to secure the welcome page without login access.  
}  
  
  $check_user="SELECT * FROM fnd_user_profile WHERE email ='{$_SESSION['email']}'";
  
    $run=mysqli_query($DBcon,$check_user);
    $userRow=$run->fetch_array();
       $user_fnd_id = $userRow['user_fnd_id'];
     $first_name = $userRow['first_name'];
     $last_name = $userRow['last_name'];
      $city = $userRow['city'];
      $address = $userRow['address'];
       $date_of_birth = $userRow['date_of_birth'];
    
      
      $sql ="SELECT * FROM `tbl_loan` WHERE `user_fnd_id`='$user_fnd_id'";
      $play=mysqli_query($DBcon,$sql);
      $row=$play->fetch_array();
        $amount_of_loan = $row['amount_of_loan'];
          $contract_date = $row['contract_date'];
           $payment_date = $row['payment_date'];
           $creation_date = $row['creation_date'];
            $loan_fee = $row['loan_fee'];
             $loan_status = $row['loan_status'];
         
        

?>  
  
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">



<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
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

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #28B463;
  color: black;
}

.topnav a.active {
  background-color: #28B463 ;
  color: white;
}

</style>
</head>
<body>
<div>
    <img src="Money-Line-Logo.JPG" style="width:20%"/>
    </div>
<div class="topnav">
 
  <a href="#" class="w3-bar-item   active"><i class="fa fa-envelope w3-margin-right"></i><?php  echo $_SESSION['email'];  ?></a>
  <a href="#about">About</a>
  <a href="#contact">Contact</a>
  <a href="logout.php" style="float: right; color: green;">Logout</a>
  
</div>
<br>
<div class="w3-container w3-content" style="max-width:1400px">  
   <div class="row"> 
   <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container">
         <h4 class="w3-center"><?php  echo $first_name;  ?> &nbsp;<?php  echo $last_name;  ?></h4>
         <p class="w3-center"><img src="Money-Line-Logo.JPG" class="w3-circle" style="height:106px;width:206px" alt="Avatar"></p>
         <hr>
         <p><i class="fa fa-envelope fa-fw w3-margin-right w3-text-theme"></i><?php  echo $_SESSION['email'];  ?></p>
         <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i><?php  echo $city;  ?> &nbsp;<?php  echo $address;  ?></p>
         <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i><?php  echo $date_of_birth;  ?></p>
        </div>
      </div>
     </div>
     <div class="w3-col m9 w3-container">
       <table>
  <tr>
    <th>amount_of_loan</th>
    <th>contract_date</th>
    <th>payment_date</th>
    <th>creation_date</th>
    <th>loan_fee</th>
    <th>loan_status</th>
  </tr>
  <tr>
    <td><?php  echo $amount_of_loan;  ?></td>
    <td><?php  echo $contract_date;  ?></td>
    <td><?php  echo $payment_date;  ?></td>
     <td><?php  echo $creation_date;  ?></td>
      <td><?php  echo $loan_fee;  ?></td>
      <td><?php  echo $loan_status;  ?></td>
  </tr>
  
</table>  
     </div>
     </div>
     </div>

</body>
</html>
