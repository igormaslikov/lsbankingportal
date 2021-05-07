<?php


$email = $_POST['email'];
$password = $_POST['password'];
$re_password = $_POST['re_password'];
$pass=$re_password;
//echo $pass;
$phone = $_POST['phone'];


        $phone = str_replace('+', '%2B', $phone);
        echo $phone;
    
    // API Starts...................................// 
    
 $url = "Body=$num&From=";
$url.= "%2B12019926499";
$url.= "&To=";
$url.= "$phone";
    
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/AC9a1716ea74edacd62fe38ebc3e0f7b20/Messages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "$url",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUM5YTE3MTZlYTc0ZWRhY2Q2MmZlMzhlYmMzZTBmN2IyMDowZjMzZTkxZTM0MzIzNTJmNTRhMjIxZDkzZTQ5YWM5ZQ==",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 17dbdeda-1147-f00b-2c91-47cd85574741"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
 
 // API END.....................................// 



?>
<?php 
function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < $length; $i++) {
       $randomString .= $characters[rand(0, $charactersLength - 1)];
   }
   return $randomString;
}

?>

<script type="text/javascript">
var x = 1;

   function setValue(){
   setTimeout(
   function() {
   function randomString(length, chars) {
   var result = '';
   for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
   return result;
}
var rString = randomString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
   
   if(x>0){
       document.getElementById('user_key').value=rString;
   }
   x++;
   },1000);
   }
     </script>


