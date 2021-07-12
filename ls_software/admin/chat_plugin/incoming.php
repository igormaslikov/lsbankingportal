<?php
$data = json_decode(file_get_contents('php://input'), true);
$mesg = $data['msg'];
$number = $data['sent_from'];
$number = substr($number, 1);
$number = substr($number, 0, 3) .'-'.substr($number, 3, 3) .'-'.substr($number, 6);
// echo $number;

include('../dbconnect.php');
include('../dbconfig.php');


$sql=mysqli_query($con, "select * from fnd_user_profile where mobile_number= '$number'"); 

while($row = mysqli_fetch_array($sql)) {
$fnd_id =$row['user_fnd_id'];
$first_name = $row['first_name'];
echo $customer_phone;
}




    
include('dbconnect.php');
include('dbconfig.php');


//$mesg .= get_headers('https://mymoneyline.com/lsbankingportal/ls_software/admin/chat_plugin/incoming.php');
//$url = 'https://mymoneyline.com/lsbankingportal/ls_software/admin/chat_plugin/incoming.php';

  //         $headers = get_headers($url,0);
//foreach ($headers as $header => $key) {
  //         $mesg .=$header. $key. "j";
//}
  mysqli_query($con, "INSERT INTO `webchat_lines`( `author`,`gravatar`, `text`, `msg_status`) VALUES ('$first_name','$fnd_id','$mesg','incoming')");
  
?>