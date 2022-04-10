 <?php
 
 
  
    $htmlContent = '
    <html>
    <body>
    <a href="http://lsprestamos.com/rapido">
<img  src="https://pacificafinancegroup.com/loanportal/flayeraie/flayerarie.png"  />
</a>
</body>
    </html>
';
   
   $to = 'kenneth@lsbanking.com';
$subject = 'LS BANKING REPIDO';
$from = 'info@pacificafinancegroup.com';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
   mail($to, $subject, $htmlContent, $headers);   
   
// echo $htmlContent;
   
   ?>