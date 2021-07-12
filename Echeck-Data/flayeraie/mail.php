<?php 
   $to = "crunchapple99@gmail.com";
     
     


$bound_text = "----*%$!$%*";
$bound = "--".$bound_text."\r\n";
$bound_last = "--".$bound_text."--\r\n";

$headers = "From: youremail@host.com\r\n";
$headers .= "MIME-Version: 1.0\r\n" .
"Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;

$message = " you may wish to enable your email program to accept HTML \r\n".
$bound;

$message .=
'Content-Type: text/html; charset=UTF-8'."\r\n".
'Content-Transfer-Encoding: 7bit'."\r\n\r\n".
'

<html>

<head>
<style> p {color:green} </style>
</head>
<body>

A line above
<br>
<<img style="position:absolute;top:2px;left:3px;width:50px;height:80px" src="https://mymoneyline.com/lsbankingportal/ci_1.png"  />
<br>
a line below
</body>

</html>'."\n\n".
$bound;

$file = file_get_contents("https://mymoneyline.com/lsbankingportal/ci_1.png");

$message .= "Content-Type: image/jpeg; name=\"https://mymoneyline.com/lsbankingportal/ci_1.png\"\r\n"
."Content-Transfer-Encoding: base64\r\n"
."Content-ID: <https://mymoneyline.com/lsbankingportal/ci_1.png>\r\n"
."\r\n"
.chunk_split(base64_encode($file))
.$bound_last;
 mail("crunchapple99@gmail.com", $subject, $message, $headers) ;
 
 echo $message;

?>