<?php

$f_name =$_GET['f_name'];
$l_name =$_GET['l_name'];
$email =$_GET['email'];
$mobile_number =$_GET['mobile_number'];
$user_fnd_id =$_GET['user_fnd_id'];
$url =$_GET['url'];

$name=$f_name.' '.$l_name;
echo"Name :".$name."<br>";
echo"email :".$email."<br>";
echo"mobile_number :".$mobile_number."<br>";
echo"user_fnd_id :".$user_fnd_id."<br>";
echo"url :".$url."<br>";




$to_email = $user_email;
$subject = 'Contract Signature From Optima';
$message = "Please Sign here by clicking on this link : ".$email_link;
$headers = 'From: support@ofsca.com';
mail($to_email,$subject,$message,$headers);

//CUSTOMER EMAIL ENDS

echo "<b>Contract was sent successfully</b>";


?>

<iframe src="<?php echo $url; ?>" width="100%" height="900"></iframe>