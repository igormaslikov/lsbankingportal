<?php

$url_logo="http://lsbankingportal.com/signature_customer/completed"; 

include 'dbconnect.php';
include 'dbconfig.php';
$idd=$_GET['id'];

//echo "key is".$mail_key;

$sql=mysqli_query($con, "select * from personal_loan_initial_banking where email_key='$idd' "); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
$creation_date=$row['creation_date'];
$fnd_id=$row['user_fnd_id'];

$type_of_card=$row['type_of_card'];
$card_number=$row['card_number'];
$card_exp_date=$row['card_exp_date'];

$bank_name=$row['bank_name'];
$routing_number=$row['routing_number'];
$account_number=$row['account_number'];

$cvv_number=$row['cvv_number'];

$img_signed = $row['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;

 //echo $result_sig;
 
}

 //echo "ID is".$img_signed;

$sql_loan=mysqli_query($con, "select * from tbl_personal_loans where loan_id= '$loan_id' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $payment_date=$row_loan['payment_date'];
     // echo "LOAN Amount".$amount_of_loan;

    
    
    $payoff=$row_loan['amount_of_loan'];
    
  if($payoff== '$50'){
        $payoff= '$8.83' ;
        
        }
        else if($payoff== '$100')
        {
             $payoff= '$17.65' ;
        }
        
        else if($payoff== '$150')
        {
             $payoff= '$26.47' ;
        }
        
        else if($payoff== '$200')
        {
             $payoff= '$35.30' ;
        }
        
        else if($payoff== '$255')
        {
             $payoff= '$45.00' ;
        }    
    
}





$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 

while($row = mysqli_fetch_array($sql)) {

$f_name=$row['first_name'];
$address=$row['address'];
$city=$row['city'];
$state=$row['state'];
$zip=$row['zip_code'];
$mobile_number=$row['mobile_number'];
$address=$row['address'];

}

    $search_dir = "doc_signs/$result";
   $images = glob("$search_dir/*.png");
   sort($images);

   // Image selection and display:

   //display first image
   if (count($images) > 0) { // make sure at least one image exists
       $img = $images[0]; // first image
      // echo "<img src='$img' height='150' width='150' /> ";
   } else {
       // possibly display a placeholder image?
   }
?>

<?php
	$date1="$creation_date";
	$date2="$payment_date";
	function dateDiff($date1, $date2) 
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}
	$dateDiff= dateDiff($date1, $date2);
 //echo "Days".$dateDiff."<br>";


$payoff=str_replace('$', '', $payoff);
$amount_of_loan=str_replace('$', '', $amount_of_loan);
$apr=$payoff/$amount_of_loan;
$apr_total=$apr*365;
$anual_pr=($apr_total/$dateDiff)*100;
	//echo $anual_pr;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contract Signature</title>
    
    <!-- Bootstrap Core Css -->
    <link href="css/bootstrap.css" rel="stylesheet" />

    <!-- Font Awesome Css -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

	<!-- Bootstrap Select Css -->
    <link href="css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/app_style.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<style>
		
		.download {
			color: #fff;
			background: #f99a0b;
			padding: 5px;
			border: none;
			border-radius: 5px;
			font-size: 20px;
			margin-top: 10px;
		}

	</style>
	
	
<STYLE type="text/css">

body {margin-top: 0px;margin-left: 0px;}

#page_1 {position:relative; overflow: hidden;margin: 42px 0px 72px 48px;padding: 0px;border: none;width: 768px;height: 942px;}

#page_1 #p1dimg1 {position:absolute;top:891px;left:0px;z-index:-1;width:720px;height:51px;}
#page_1 #p1dimg1 #p1img1 {width:720px;height:51px;}




#page_2 {position:relative; overflow: hidden;margin: 43px 0px 80px 48px;padding: 0px;border: none;width: 768px;height: 933px;}

#page_2 #p2dimg1 {position:absolute;top:882px;left:0px;z-index:-1;width:720px;height:51px;}
#page_2 #p2dimg1 #p2img1 {width:720px;height:51px;}




#page_3 {position:relative; overflow: hidden;margin: 43px 0px 71px 48px;padding: 0px;border: none;width: 768px;}
#page_3 #id3_1 {border:none;margin: 0px 0px 0px 0px;padding: 0px;border:none;width: 768px;overflow: hidden;}
#page_3 #id3_2 {border:none;margin: 35px 0px 0px 84px;padding: 0px;border:none;width: 684px;overflow: hidden;}


#page_3 #p3inl_img1 {position:relative;width:20px;height:20px;}



#page_4 {position:relative; overflow: hidden;margin: 46px 0px 78px 48px;padding: 0px;border: none;width: 768px;}
#page_4 #id4_1 {border:none;margin: 0px 0px 0px 0px;padding: 0px;border:none;width: 768px;overflow: hidden;}
#page_4 #id4_2 {border:none;margin: 13px 0px 0px 0px;padding: 0px;border:none;width: 768px;overflow: hidden;}

#page_4 #p4dimg1 {position:absolute;top:373px;left:118px;z-index:-1;width:491px;height:296px;}
#page_4 #p4dimg1 #p4img1 {width:491px;height:296px;}

#page_4 #p4inl_img1 {position:relative;width:21px;height:20px;}



#page_5 {position:relative; overflow: hidden;margin: 56px 0px 77px 0px;padding: 0px;border: none;width: 816px;}
#page_5 #id5_1 {border:none;margin: 0px 0px 0px 0px;padding: 0px;border:none;width: 816px;overflow: hidden;}
#page_5 #id5_2 {border:none;margin: 26px 0px 0px 86px;padding: 0px;border:none;width: 648px;overflow: hidden;}
#page_5 #id5_2 #id5_2_1 {float:left;border:none;margin: 0px 0px 0px 0px;padding: 0px;border:none;width: 276px;overflow: hidden;}
#page_5 #id5_2 #id5_2_2 {float:left;border:none;margin: 1px 0px 0px 57px;padding: 0px;border:none;width: 315px;overflow: hidden;}
#page_5 #id5_3 {border:none;margin: 58px 0px 0px 96px;padding: 0px;border:none;width: 720px;overflow: hidden;}


#page_5 #p5inl_img1 {position:relative;width:21px;height:20px;}



#page_6 {position:relative; overflow: hidden;margin: 82px 0px 55px 48px;padding: 0px;border: none;width: 721px;}





#page_7 {position:relative; overflow: hidden;margin: 58px 0px 87px 48px;padding: 0px;border: none;width: 711px;}





.ft0{font: bold 29px 'Calibri';line-height: 36px;}
.ft1{font: 19px 'Calibri';line-height: 23px;}
.ft2{font: 16px 'Calibri';line-height: 19px;}
.ft3{font: 1px 'Calibri';line-height: 1px;}
.ft4{font: bold 12px 'Calibri';line-height: 14px;}
.ft5{font: bold 13px 'Calibri';line-height: 15px;}
.ft6{font: 11px 'Calibri';line-height: 13px;}
.ft7{font: 13px 'Calibri';line-height: 15px;}
.ft8{font: 13px 'Calibri';margin-left: 6px;line-height: 17px;}
.ft9{font: 13px 'Calibri';line-height: 17px;}
.ft10{font: 13px 'Calibri';margin-left: 6px;line-height: 15px;}
.ft11{font: 13px 'Calibri';line-height: 18px;}
.ft12{font: bold 16px 'Calibri';line-height: 20px;}
.ft13{font: bold 16px 'Calibri';line-height: 19px;}
.ft14{font: bold 24px 'Calibri';line-height: 29px;}
.ft15{font: 15px 'Calibri';line-height: 18px;}
.ft16{font: 12px 'Calibri';line-height: 14px;}
.ft17{font: 13px 'Calibri';margin-left: 3px;line-height: 17px;}
.ft18{font: 13px 'Calibri';margin-left: 3px;line-height: 15px;}
.ft19{font: bold 15px 'Calibri';line-height: 19px;}
.ft20{font: bold 15px 'Calibri';line-height: 18px;}
.ft21{font: bold 27px 'Verdana';line-height: 32px;}
.ft22{font: 8px 'Verdana';line-height: 10px;}
.ft23{font: 12px 'Verdana';line-height: 14px;}
.ft24{font: bold 16px 'Verdana';line-height: 18px;}
.ft25{font: 8px 'Verdana';line-height: 13px;}
.ft26{font: 9px 'Verdana';line-height: 12px;}
.ft27{font: bold 11px 'Verdana';line-height: 13px;}
.ft28{font: 21px 'Verdana';line-height: 25px;}
.ft29{font: bold 12px 'Verdana';line-height: 14px;}
.ft30{font: bold 19px 'Verdana';text-decoration: underline;line-height: 23px;}
.ft31{font: 11px 'Verdana';line-height: 13px;}
.ft32{font: 12px 'Verdana';line-height: 16px;}
.ft33{font: 13px 'Verdana';line-height: 16px;}
.ft34{font: italic bold 11px 'Verdana';line-height: 13px;}
.ft35{font: bold 19px 'Verdana';line-height: 23px;}
.ft36{font: italic 12px 'Verdana';line-height: 15px;}
.ft37{font: 12px 'Verdana';line-height: 15px;}
.ft38{font: italic 12px 'Verdana';line-height: 14px;}
.ft39{font: 1px 'Verdana';line-height: 1px;}
.ft40{font: bold 13px 'Verdana';text-decoration: underline;line-height: 16px;}
.ft41{font: bold 13px 'Verdana';line-height: 16px;}
.ft42{font: bold 9px 'Verdana';color: #ffffff;line-height: 12px;}
.ft43{font: bold 9px 'Verdana';line-height: 12px;}
.ft44{font: bold 8px 'Verdana';color: #ffffff;line-height: 10px;}
.ft45{font: 1px 'Verdana';line-height: 6px;}
.ft46{font: 9px 'Verdana';line-height: 11px;}
.ft47{font: 1px 'Verdana';line-height: 11px;}
.ft48{font: bold 11px 'Verdana';color: #ffffff;line-height: 13px;}
.ft49{font: 1px 'Verdana';line-height: 9px;}
.ft50{font: 1px 'Verdana';line-height: 4px;}
.ft51{font: 1px 'Verdana';line-height: 8px;}
.ft52{font: 1px 'Verdana';line-height: 7px;}
.ft53{font: 1px 'Verdana';line-height: 5px;}

.p0{text-align: left;padding-left: 14px;margin-top: 0px;margin-bottom: 0px;}
.p1{text-align: left;padding-left: 71px;margin-top: 4px;margin-bottom: 0px;}
.p2{text-align: left;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p3{text-align: left;padding-left: 86px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p4{text-align: left;padding-left: 34px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p5{text-align: center;padding-left: 1px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p6{text-align: center;padding-right: 2px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p7{text-align: center;padding-right: 1px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p8{text-align: center;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p9{text-align: left;margin-top: 14px;margin-bottom: 0px;}
.p10{text-align: left;padding-right: 61px;margin-top: 0px;margin-bottom: 0px;text-indent: 15px;}
.p11{text-align: left;padding-left: 15px;margin-top: 0px;margin-bottom: 0px;}
.p12{text-align: left;margin-top: 17px;margin-bottom: 0px;}
.p13{text-align: left;padding-left: 39px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p14{text-align: left;padding-left: 67px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p15{text-align: left;padding-left: 77px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p16{text-align: left;margin-top: 13px;margin-bottom: 0px;}
.p17{text-align: left;padding-right: 60px;margin-top: 3px;margin-bottom: 0px;}
.p18{text-align: left;padding-right: 50px;margin-top: 12px;margin-bottom: 0px;}
.p19{text-align: left;padding-right: 51px;margin-top: 13px;margin-bottom: 0px;}
.p20{text-align: left;padding-right: 51px;margin-top: 17px;margin-bottom: 0px;}
.p21{text-align: left;margin-top: 18px;margin-bottom: 0px;}
.p22{text-align: left;padding-left: 367px;margin-top: 0px;margin-bottom: 0px;}
.p23{text-align: left;padding-left: 6px;margin-top: 0px;margin-bottom: 0px;}
.p24{text-align: left;padding-left: 51px;margin-top: 4px;margin-bottom: 0px;}
.p25{text-align: left;padding-left: 103px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p26{text-align: left;padding-left: 15px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p27{text-align: left;padding-right: 57px;margin-top: 2px;margin-bottom: 0px;text-indent: 18px;}
.p28{text-align: left;padding-left: 18px;margin-top: 0px;margin-bottom: 0px;}
.p29{text-align: left;padding-left: 41px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p30{text-align: left;padding-left: 89px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p31{text-align: left;padding-left: 99px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p32{text-align: left;padding-right: 57px;margin-top: 3px;margin-bottom: 0px;}
.p33{text-align: justify;padding-right: 87px;margin-top: 13px;margin-bottom: 0px;}
.p34{text-align: left;padding-right: 70px;margin-top: 13px;margin-bottom: 0px;}
.p35{text-align: left;padding-right: 57px;margin-top: 10px;margin-bottom: 0px;}
.p36{text-align: left;margin-top: 12px;margin-bottom: 0px;}
.p37{text-align: left;margin-top: 0px;margin-bottom: 0px;}
.p38{text-align: left;padding-left: 3px;margin-top: 5px;margin-bottom: 0px;}
.p39{text-align: left;padding-left: 4px;margin-top: 24px;margin-bottom: 0px;}
.p40{text-align: left;padding-left: 8px;margin-top: 7px;margin-bottom: 0px;}
.p41{text-align: left;padding-left: 152px;margin-top: 7px;margin-bottom: 0px;}
.p42{text-align: left;padding-left: 190px;margin-top: 32px;margin-bottom: 0px;}
.p43{text-align: left;padding-right: 67px;margin-top: 10px;margin-bottom: 0px;}
.p44{text-align: left;padding-right: 59px;margin-top: 5px;margin-bottom: 0px;}
.p45{text-align: left;margin-top: 5px;margin-bottom: 0px;}
.p46{text-align: left;margin-top: 7px;margin-bottom: 0px;}
.p47{text-align: justify;padding-right: 98px;margin-top: 7px;margin-bottom: 0px;}
.p48{text-align: left;padding-right: 49px;margin-top: 6px;margin-bottom: 0px;}
.p49{text-align: left;padding-left: 310px;margin-top: 4px;margin-bottom: 0px;}
.p50{text-align: left;padding-right: 58px;margin-top: 2px;margin-bottom: 0px;}
.p51{text-align: left;padding-left: 314px;margin-top: 3px;margin-bottom: 0px;}
.p52{text-align: left;padding-right: 63px;margin-top: 2px;margin-bottom: 0px;}
.p53{text-align: left;padding-left: 190px;margin-top: 21px;margin-bottom: 0px;}
.p54{text-align: left;padding-right: 54px;margin-top: 10px;margin-bottom: 0px;}
.p55{text-align: left;padding-left: 84px;margin-top: 34px;margin-bottom: 0px;}
.p56{text-align: left;padding-left: 83px;margin-top: 26px;margin-bottom: 0px;}
.p57{text-align: left;padding-left: 83px;margin-top: 15px;margin-bottom: 0px;}
.p58{text-align: left;padding-left: 84px;margin-top: 26px;margin-bottom: 0px;}
.p59{text-align: left;padding-left: 78px;margin-top: 67px;margin-bottom: 0px;}
.p60{text-align: left;padding-left: 78px;margin-top: 3px;margin-bottom: 0px;}
.p61{text-align: left;margin-top: 21px;margin-bottom: 0px;}
.p62{text-align: left;padding-left: 4px;margin-top: 7px;margin-bottom: 0px;}
.p63{text-align: left;padding-left: 148px;margin-top: 8px;margin-bottom: 0px;}
.p64{text-align: left;padding-left: 160px;margin-top: 34px;margin-bottom: 0px;}
.p65{text-align: left;padding-left: 157px;margin-top: 3px;margin-bottom: 0px;}
.p66{text-align: left;margin-top: 25px;margin-bottom: 0px;}
.p67{text-align: left;padding-right: 84px;margin-top: 2px;margin-bottom: 0px;}
.p68{text-align: left;margin-top: 9px;margin-bottom: 0px;}
.p69{text-align: left;padding-right: 77px;margin-top: 3px;margin-bottom: 0px;}
.p70{text-align: left;padding-left: 143px;margin-top: 63px;margin-bottom: 0px;}
.p71{text-align: left;padding-left: 143px;margin-top: 21px;margin-bottom: 0px;}
.p72{text-align: left;padding-left: 143px;margin-top: 15px;margin-bottom: 0px;}
.p73{text-align: left;padding-left: 148px;margin-top: 21px;margin-bottom: 0px;}
.p74{text-align: left;padding-left: 147px;margin-top: 15px;margin-bottom: 0px;}
.p75{text-align: left;padding-left: 131px;margin-top: 26px;margin-bottom: 0px;}
.p76{text-align: left;padding-left: 21px;margin-top: 64px;margin-bottom: 0px;}
.p77{text-align: left;margin-top: 2px;margin-bottom: 0px;}
.p78{text-align: left;padding-left: 21px;margin-top: 34px;margin-bottom: 0px;}
.p79{text-align: left;margin-top: 3px;margin-bottom: 0px;}
.p80{text-align: left;margin-top: 83px;margin-bottom: 0px;}
.p81{text-align: left;padding-left: 48px;margin-top: 0px;margin-bottom: 0px;}
.p82{text-align: left;padding-left: 48px;margin-top: 5px;margin-bottom: 0px;}
.p83{text-align: left;padding-left: 48px;margin-top: 22px;margin-bottom: 0px;}
.p84{text-align: left;padding-left: 52px;margin-top: 8px;margin-bottom: 0px;}
.p85{text-align: left;padding-left: 196px;margin-top: 7px;margin-bottom: 0px;}
.p86{text-align: left;padding-left: 281px;margin-top: 45px;margin-bottom: 0px;}
.p87{text-align: right;padding-right: 225px;margin-top: 13px;margin-bottom: 0px;}
.p88{text-align: justify;margin-top: 0px;margin-bottom: 0px;}
.p89{text-align: left;margin-top: 46px;margin-bottom: 0px;}
.p90{text-align: left;margin-top: 45px;margin-bottom: 0px;}
.p91{text-align: left;margin-top: 65px;margin-bottom: 0px;}
.p92{text-align: left;margin-top: 29px;margin-bottom: 0px;}
.p93{text-align: left;padding-left: 173px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p94{text-align: left;padding-left: 164px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p95{text-align: left;padding-left: 97px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p96{text-align: left;padding-left: 4px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p97{text-align: left;padding-left: 6px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p98{text-align: center;padding-right: 19px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p99{text-align: center;padding-right: 18px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p100{text-align: center;padding-left: 2px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p101{text-align: left;padding-left: 53px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p102{text-align: left;padding-left: 12px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p103{text-align: left;padding-left: 70px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p104{text-align: left;padding-left: 175px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p105{text-align: left;padding-left: 207px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p106{text-align: left;padding-left: 26px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p107{text-align: left;padding-left: 120px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p108{text-align: left;padding-left: 5px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p109{text-align: left;padding-left: 24px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p110{text-align: left;padding-left: 36px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p111{text-align: left;padding-left: 31px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p112{text-align: center;padding-right: 12px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p113{text-align: left;padding-left: 91px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p114{text-align: left;padding-left: 40px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p115{text-align: left;padding-left: 9px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p116{text-align: left;padding-left: 74px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}

.td0{padding: 0px;margin: 0px;width: 187px;vertical-align: bottom;}
.td1{padding: 0px;margin: 0px;width: 180px;vertical-align: bottom;}
.td2{padding: 0px;margin: 0px;width: 168px;vertical-align: bottom;}
.td3{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 187px;vertical-align: bottom;}
.td4{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 180px;vertical-align: bottom;}
.td5{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 168px;vertical-align: bottom;}
.td6{border-left: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 186px;vertical-align: bottom;}
.td7{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 360px;vertical-align: bottom;}
.td8{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 167px;vertical-align: bottom;}
.td9{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 185px;vertical-align: bottom;}
.td10{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 179px;vertical-align: bottom;}
.td11{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 167px;vertical-align: bottom;}
.td12{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 185px;vertical-align: bottom;}
.td13{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 179px;vertical-align: bottom;}
.td14{border-left: #000000 1px solid;border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 191px;vertical-align: bottom;}
.td15{border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 245px;vertical-align: bottom;}
.td16{border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 275px;vertical-align: bottom;}
.td17{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 191px;vertical-align: bottom;}
.td18{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 245px;vertical-align: bottom;}
.td19{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 275px;vertical-align: bottom;}
.td20{padding: 0px;margin: 0px;width: 264px;vertical-align: bottom;}
.td21{padding: 0px;margin: 0px;width: 95px;vertical-align: bottom;}
.td22{padding: 0px;margin: 0px;width: 278px;vertical-align: bottom;}
.td23{padding: 0px;margin: 0px;width: 25px;vertical-align: bottom;}
.td24{padding: 0px;margin: 0px;width: 175px;vertical-align: bottom;}
.td25{padding: 0px;margin: 0px;width: 174px;vertical-align: bottom;}
.td26{padding: 0px;margin: 0px;width: 378px;vertical-align: bottom;}
.td27{padding: 0px;margin: 0px;width: 210px;vertical-align: bottom;}
.td28{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 175px;vertical-align: bottom;}
.td29{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 174px;vertical-align: bottom;}
.td30{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 210px;vertical-align: bottom;}
.td31{border-left: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 174px;vertical-align: bottom;}
.td32{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 551px;vertical-align: bottom;}
.td33{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 173px;vertical-align: bottom;}
.td34{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 173px;vertical-align: bottom;}
.td35{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 209px;vertical-align: bottom;}
.td36{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 173px;vertical-align: bottom;}
.td37{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 173px;vertical-align: bottom;}
.td38{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 209px;vertical-align: bottom;}
.td39{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 150px;vertical-align: bottom;}
.td40{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 295px;vertical-align: bottom;}
.td41{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 282px;vertical-align: bottom;}
.td42{border-left: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;}
.td43{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 28px;vertical-align: bottom;}
.td44{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 265px;vertical-align: bottom;}
.td45{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 281px;vertical-align: bottom;}
.td46{padding: 0px;margin: 0px;width: 31px;vertical-align: bottom;}
.td47{padding: 0px;margin: 0px;width: 122px;vertical-align: bottom;}
.td48{padding: 0px;margin: 0px;width: 310px;vertical-align: bottom;}
.td49{padding: 0px;margin: 0px;width: 139px;vertical-align: bottom;}
.td50{padding: 0px;margin: 0px;width: 150px;vertical-align: bottom;}
.td51{padding: 0px;margin: 0px;width: 449px;vertical-align: bottom;}
.td52{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 122px;vertical-align: bottom;}
.td53{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 293px;vertical-align: bottom;}
.td54{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 156px;vertical-align: bottom;}
.td55{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 120px;vertical-align: bottom;background: #000000;}
.td56{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 598px;vertical-align: bottom;}
.td57{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 120px;vertical-align: bottom;background: #000000;}
.td58{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;}
.td59{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 120px;vertical-align: bottom;background: #515053;}
.td60{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;}
.td61{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 120px;vertical-align: bottom;background: #515053;}
.td62{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 17px;vertical-align: bottom;}
.td63{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 139px;vertical-align: bottom;}
.td64{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 415px;vertical-align: bottom;}
.td65{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 17px;vertical-align: bottom;}
.td66{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 139px;vertical-align: bottom;}
.td67{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 150px;vertical-align: bottom;}
.td68{border-left: #515053 1px solid;border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 413px;vertical-align: bottom;background: #515053;}
.td69{padding: 0px;margin: 0px;width: 17px;vertical-align: bottom;background: #515053;}
.td70{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 138px;vertical-align: bottom;background: #515053;}
.td71{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;background: #515053;}
.td72{border-left: #515053 1px solid;border-right: #515053 1px solid;padding: 0px;margin: 0px;width: 120px;vertical-align: bottom;background: #515053;}
.td73{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 292px;vertical-align: bottom;background: #515053;}
.td74{border-left: #515053 1px solid;border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 413px;vertical-align: bottom;background: #515053;}
.td75{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 17px;vertical-align: bottom;background: #515053;}
.td76{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 138px;vertical-align: bottom;background: #515053;}
.td77{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;background: #515053;}
.td78{border-left: #bbbbbb 1px solid;border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 413px;vertical-align: bottom;}
.td79{padding: 0px;margin: 0px;width: 17px;vertical-align: bottom;}
.td80{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 138px;vertical-align: bottom;}
.td81{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;}
.td82{border-left: #bbbbbb 1px solid;border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 413px;vertical-align: bottom;}
.td83{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 138px;vertical-align: bottom;}
.td84{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;}
.td85{border-left: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 121px;vertical-align: bottom;}
.td86{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 292px;vertical-align: bottom;}
.td87{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 288px;vertical-align: bottom;}
.td88{border-left: #515053 1px solid;border-right: #515053 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 120px;vertical-align: bottom;background: #515053;}
.td89{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 292px;vertical-align: bottom;background: #515053;}
.td90{padding: 0px;margin: 0px;width: 98px;vertical-align: bottom;}
.td91{padding: 0px;margin: 0px;width: 419px;vertical-align: bottom;}
.td92{padding: 0px;margin: 0px;width: 192px;vertical-align: bottom;}
.td93{padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;}
.td94{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 98px;vertical-align: bottom;}
.td95{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 305px;vertical-align: bottom;}
.td96{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 114px;vertical-align: bottom;}
.td97{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 192px;vertical-align: bottom;}
.td98{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;}
.td99{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;background: #000000;}
.td100{padding: 0px;margin: 0px;width: 611px;vertical-align: bottom;}
.td101{padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;background: #000000;}
.td102{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;background: #000000;}
.td103{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;background: #000000;}
.td104{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;background: #5b5b5b;}
.td105{padding: 0px;margin: 0px;width: 316px;vertical-align: bottom;}
.td106{padding: 0px;margin: 0px;width: 103px;vertical-align: bottom;}
.td107{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;background: #5b5b5b;}
.td108{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;}
.td109{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 103px;vertical-align: bottom;}
.td110{border-bottom: #5b5b5b 1px solid;padding: 0px;margin: 0px;width: 403px;vertical-align: bottom;}
.td111{border-bottom: #5b5b5b 1px solid;padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;}
.td112{border-bottom: #5b5b5b 1px solid;padding: 0px;margin: 0px;width: 103px;vertical-align: bottom;}
.td113{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 192px;vertical-align: bottom;}
.td114{border-left: #5b5b5b 1px solid;border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 401px;vertical-align: bottom;background: #5b5b5b;}
.td115{padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;background: #5b5b5b;}
.td116{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 102px;vertical-align: bottom;background: #5b5b5b;}
.td117{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 191px;vertical-align: bottom;background: #5b5b5b;}
.td118{border-left: #5b5b5b 1px solid;border-right: #5b5b5b 1px solid;padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;background: #5b5b5b;}
.td119{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 304px;vertical-align: bottom;background: #5b5b5b;}
.td120{padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;background: #bbbbbb;}
.td121{border-left: #5b5b5b 1px solid;border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 401px;vertical-align: bottom;background: #5b5b5b;}
.td122{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;background: #5b5b5b;}
.td123{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 102px;vertical-align: bottom;background: #5b5b5b;}
.td124{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 191px;vertical-align: bottom;background: #5b5b5b;}
.td125{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;background: #bbbbbb;}
.td126{border-left: #bbbbbb 1px solid;border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 401px;vertical-align: bottom;}
.td127{padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;}
.td128{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 102px;vertical-align: bottom;}
.td129{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 191px;vertical-align: bottom;}
.td130{border-left: #bbbbbb 1px solid;border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 401px;vertical-align: bottom;}
.td131{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;}
.td132{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 102px;vertical-align: bottom;}
.td133{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 191px;vertical-align: bottom;}
.td134{border-left: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 97px;vertical-align: bottom;}
.td135{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 304px;vertical-align: bottom;}
.td136{border-right: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 294px;vertical-align: bottom;}
.td137{border-left: #5b5b5b 1px solid;border-right: #5b5b5b 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;background: #5b5b5b;}
.td138{border-right: #bbbbbb 1px solid;border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 304px;vertical-align: bottom;background: #5b5b5b;}
.td139{border-bottom: #bbbbbb 1px solid;padding: 0px;margin: 0px;width: 103px;vertical-align: bottom;}

.tr0{height: 26px;}
.tr1{height: 19px;}
.tr2{height: 20px;}
.tr3{height: 21px;}
.tr4{height: 15px;}
.tr5{height: 17px;}
.tr6{height: 16px;}
.tr7{height: 39px;}
.tr8{height: 33px;}
.tr9{height: 22px;}
.tr10{height: 23px;}
.tr11{height: 18px;}
.tr12{height: 41px;}
.tr13{height: 32px;}
.tr14{height: 37px;}
.tr15{height: 25px;}
.tr16{height: 34px;}
.tr17{height: 24px;}
.tr18{height: 12px;}
.tr19{height: 13px;}
.tr20{height: 30px;}
.tr21{height: 6px;}
.tr22{height: 36px;}
.tr23{height: 29px;}
.tr24{height: 11px;}
.tr25{height: 46px;}
.tr26{height: 31px;}
.tr27{height: 27px;}
.tr28{height: 9px;}
.tr29{height: 4px;}
.tr30{height: 8px;}
.tr31{height: 38px;}
.tr32{height: 7px;}
.tr33{height: 5px;}
.tr34{height: 35px;}

.t0{width: 715px;margin-top: 13px;font: 11px 'Calibri';}
.t1{width: 714px;font: 13px 'Calibri';}
.t2{width: 662px;margin-left: 8px;margin-top: 17px;font: 13px 'Calibri';}
.t3{width: 727px;margin-top: 22px;font: bold 13px 'Calibri';}
.t4{width: 727px;margin-top: 13px;font: 13px 'Calibri';}
.t5{width: 668px;margin-left: 8px;margin-top: 17px;font: 13px 'Calibri';}
.t6{width: 721px;font: 9px 'Verdana';}
.t7{width: 711px;font: 8px 'Verdana';}

</STYLE>	
	
	
	
</head>
<body>
    <div class="all-content-wrapper">
		<!-- Top Bar -->
		<?php require_once('./include/header.php'); ?>
		<!-- #END# Top Bar -->
	
		<section class="container">
			<div class="form-group custom-input-space has-feedback">
				<div class="page-heading">
					<h3 class="post-title"></h3>
				</div>
				
<DIV id="page_1">
<DIV id="p1dimg1">
<IMG src="data:image/jpg;base64,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" id="p1img1"></DIV>


<P class="p0 ft0">PAYDAY LOAN CONTRACT AND DISCLOSURE STATEMENT</P>
<P class="p1 ft1">Lender: LS Financing, Inc 4645 Van Nuys Blvd #202 Sherman Oaks, CA 91403</P>
<TABLE cellpadding=0 cellspacing=0 class="t0">
<TR>
	<TD class="tr0 td0"><P class="p2 ft2">Contract Date:<span style="color:blue"><?php echo $creation_date;?></span></P></TD>
	<TD class="tr0 td1"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr0 td1"><P class="p3 ft2">Loan ID:<span style="color:blue"><?php echo $loan_id;?></span></P></TD>
	<TD class="tr0 td2"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr1 td0"><P class="p2 ft2">Borrower:<span style="color:blue"><?php echo $f_name;?></span></P></TD>
	<TD class="tr1 td1"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr1 td1"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr1 td2"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr2 td0"><P class="p2 ft2">Address:<span style="color:blue"><?php echo $address;?></span></P></TD>
	<TD class="tr2 td1"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr2 td1"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr2 td2"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr3 td0"><P class="p2 ft2">City, State, Zip:<span style="color:blue"><?php echo $city.','.$state.','.$zip;?></span></P></TD>
	<TD class="tr3 td1"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr3 td1"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr3 td2"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr4 td3"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr4 td4"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr4 td4"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr4 td5"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr5 td6"><P class="p2 ft3">&nbsp;</P></TD>
	<TD colspan=2 class="tr5 td7"><P class="p4 ft4">FEDERAL <NOBR>TRUTH-IN-LENDING</NOBR> DISCLOSURE STATEMENT</P></TD>
	<TD class="tr5 td8"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr4 td9"><P class="p5 ft5">ANNUAL</P></TD>
	<TD class="tr4 td10"><P class="p6 ft5">FINANCE</P></TD>
	<TD class="tr4 td10"><P class="p6 ft5">AMOUNT</P></TD>
	<TD class="tr4 td11"><P class="p7 ft5">TOTAL OF</P></TD>
</TR>
<TR>
	<TD class="tr5 td9"><P class="p8 ft5">PERCENTAGE</P></TD>
	<TD class="tr5 td10"><P class="p7 ft5">CHARGE</P></TD>
	<TD class="tr5 td10"><P class="p6 ft5">FINANCED</P></TD>
	<TD class="tr5 td11"><P class="p7 ft5">PAYMENTS</P></TD>
</TR>
<TR>
	<TD class="tr4 td9"><P class="p5 ft5">RATE</P></TD>
	<TD class="tr4 td10"><P class="p6 ft6"> </P></TD>
	<TD class="tr4 td10"><P class="p6 ft6"> </P></TD>
	<TD class="tr4 td11"><P class="p7 ft6"> </P></TD>
</TR>
<TR>
	<TD class="tr4 td9"><P class="p5 ft6"> <span style="color:blue"><?php echo "$".number_format((float)$anual_pr, 2, '.', '');?> </span></P></TD>
	<TD class="tr4 td10"><P class="p6 ft6"> <span style="color:blue"><?php echo "$".$payoff;?> </span> </P></TD>
	<TD class="tr4 td10"><P class="p6 ft6"> <span style="color:blue"><?php echo "$".$amount_of_loan;?> </span> </P></TD>
	<TD class="tr4 td11"><P class="p7 ft6"> <span style="color:blue"> <?php $payoff=str_replace('$', '', $payoff);
    $amount_of_loan=str_replace('$', '', $amount_of_loan); $total_am= $payoff+$amount_of_loan; echo "$" .number_format((float)$total_am, 2, '.', ''); ?> </span> </P></TD>
</TR>
<TR>
	<TD class="tr6 td9"><P class="p8 ft6"></P></TD>
	<TD class="tr6 td10"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr6 td10"><P class="p6 ft6"> </P></TD>
	<TD class="tr6 td11"><P class="p6 ft6"> </P></TD>
</TR>
<TR>
	<TD class="tr7 td12"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr7 td13"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr7 td13"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr7 td8"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
</TABLE>
<P class="p9 ft7">Security</P>
<P class="p10 ft9"><SPAN class="ft7">*</SPAN><SPAN class="ft8">Your </SPAN><NOBR>post-dated</NOBR> payment(s) and/or Automated Clearing House Authorization ("ACHA") which if so attached, is/are made part of this Agreement, as though fully stated herein is security for the loan.</P>
<P class="p11 ft7"><SPAN class="ft7">*</SPAN><SPAN class="ft10">Your wage assignment, if given, is also security for this loan.</SPAN></P>
<P class="p12 ft7"><SPAN class="ft5">PAYMENT SCHEDULE </SPAN>Your payment schedule will be:</P>
<TABLE cellpadding=0 cellspacing=0 class="t1">
<TR>
	<TD class="tr1 td14"><P class="p13 ft7">Number of Payments</P></TD>
	<TD class="tr1 td15"><P class="p14 ft7">Amount of Payment</P></TD>
	<TD class="tr1 td16"><P class="p15 ft7">When Payment is Due</P></TD>
</TR>
<TR>
	<TD class="tr8 td17" style="text-align: center"><P class="p2 ft3">&nbsp;</P> <span style="color:blue;"> <?php $pay_am="1"; echo "$pay_am"; ?> </span> </TD>
	<TD class="tr8 td18" style="text-align: center"><P class="p2 ft3">&nbsp;</P> <span style="color:blue"><?php $payoff=str_replace('$', '', $payoff);
    $amount_of_loan=str_replace('$', '', $amount_of_loan); $total_am= $payoff+$amount_of_loan; echo "$" .number_format((float)$total_am, 2, '.', '');    ?> </span></TD>
	<TD class="tr8 td19" style="text-align: center"><P class="p2 ft3">&nbsp;</P> <span style="color:blue"> <?php echo $payment_date; ?> </span></TD>
</TR>
</TABLE>
<P class="p16 ft5">Prepayment</P>
<P class="p17 ft9">A Consumer may cancel future payment obligations on a payday loan, without cost or finance charges, no later than the end of the second business day, immediately following the day on which the payday loan was executed. If you pay off early, you will not be entitled to a refund of a portion of the finance charge. See below and and/or second page of this contract for any additional information about nonpayment, default, any required payment in full before the scheduled date, and prepayment refunds and penalties.</P>
<P class="p18 ft11">By signing this Loan Contract and Disclosure Statement (this "contract") and accepting a loan from LS Financing, Inc ("Lender") the undersigned borrower ("I", "you", "borrower") agrees to and accept the terms and conditions set forth on all pages of this contract.</P>
<P class="p19 ft12">I UNDERSTAND THAT IF I STILL OWE ON ONE OR MORE PAYDAY LOANS AFTER 35 DAYS, I AM ENTITLED TO ENTER INTO A REPAYMENT TO ENTER INTO A REPAYMENT PLAN THAT I WILL GIVE ME AT LEAST 55 DAYS TO REPAY THE LOAN IN INSTALLMENTS WITH NO ADDITIONAL FINANCE CHARGES, INTEREST, FEES, OR OTHER CHARGES OF ANY KIND.</P>
<P class="p20 ft12">WARNING: THIS LOAN IS NOT INTENTED TO MEET <NOBR>LONG-TERM</NOBR> FINANCIAL NEEDS. THIS LOAN SHOULD ONLY BE USED TO MEET <NOBR>SHORT-TERM</NOBR> CASH NEEDS. THE COST OF YOUR LOAN MAY BE HIGHER THAT LOANS OFFERED BY OTHER LENDING INSTITUTIONS. THIS LOAN IS REGULATED BY THE DEPARTMENT OF FINANCIAL AND PROFESSIONAL REGULATION.</P>
<P class="p21 ft13">YOU CANNOT BE PROSECUTED IN CRIMINAL COURT TO COLLECT THIS LOAN.</P>
<TABLE cellpadding=0 cellspacing=0 class="t2">
<TR>
	<TD class="tr9 td20"><P class="p2 ft7">Signature of Borrower <?php echo "<img src='$result_sig' style='height:130%;width:35%;margin-bottom:-20%;' />";?> </P></TD>
	<TD class="tr9 td21"><P class="p2 ft7">Date</P></TD>
	<TD class="tr9 td22"><P class="p2 ft7">Lender: LS Financing, Inc</P></TD>
	<TD class="tr9 td23"><P class="p2 ft7">Date</P></TD>
</TR>
</TABLE>
<P class="p22 ft5">Name:<SPAN style="padding-left:133px;">Title:</SPAN></P>
</DIV>
<DIV id="page_2">
<DIV id="p2dimg1">
<IMG src="data:image/jpg;base64,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" id="p2img1"></DIV>


<P class="p23 ft14">CONTRATO DE PRÉSTAMO DE PAGO Y DECLARACIÓN DE DIVULGACIÓN</P>
<P class="p24 ft1">Prestamista: LS Financing, Inc 4645 Van Nuys Blvd # 202 Sherman Oaks, CA 91403</P>
<TABLE cellpadding=0 cellspacing=0 class="t3">
<TR>
	<TD class="tr10 td24"><P class="p2 ft15">Fecha del Contrato: <span style="color:blue;"> <?php echo $creation_date; ?> </span></P></TD>
	<TD class="tr10 td25"><P class="p2 ft3">&nbsp;</P></TD>
	<TD colspan=2 class="tr10 td26"><P class="p25 ft15">Número de Préstamo: <span style="color:blue;"> <?php echo $loan_id; ?> </span></P></TD>
</TR>
<TR>
	<TD class="tr11 td24"><P class="p2 ft15">Prestatario: <span style="color:blue;"> <?php echo $f_name; ?> </span></P></TD>
	<TD class="tr11 td25"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr11 td2"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr11 td27"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr11 td24"><P class="p2 ft15">Dirección: <span style="color:blue;"> <?php echo $address; ?> </span></P></TD>
	<TD class="tr11 td25"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr11 td2"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr11 td27"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr1 td24"><P class="p2 ft15">Código postal: <span style="color:blue;"> <?php echo $zip; ?> </span></P></TD>
	<TD class="tr1 td25"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr1 td2"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr1 td27"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr5 td28"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr5 td29"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr5 td5"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr5 td30"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr6 td31"><P class="p2 ft3">&nbsp;</P></TD>
	<TD colspan=3 class="tr6 td32"><P class="p26 ft4">DECLARACIÓN FEDERAL DE DIVULGACIÓN DE VERDAD EN PRÉSTAMO</P></TD>
</TR>
<TR>
	<TD class="tr6 td33"><P class="p5 ft5">TASA DE PORCENTAJE</P></TD>
	<TD class="tr6 td34"><P class="p7 ft5">CARGOS DE</P></TD>
	<TD class="tr6 td11"><P class="p7 ft5">MONTO FINANCIADO</P></TD>
	<TD class="tr6 td35"><P class="p7 ft5">TOTAL DE PAGOS</P></TD>
</TR>
<TR>
	<TD class="tr6 td33"><P class="p8 ft5">ANUAL</P></TD>
	<TD class="tr6 td34"><P class="p7 ft5">FINANCIAMIENTO</P></TD>
	<TD class="tr6 td11"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr6 td35"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr6 td33"><P class="p8 ft6">El costo de su crédito</P></TD>
	<TD class="tr6 td34"><P class="p7 ft6"> </P></TD>
	<TD class="tr6 td11"><P class="p7 ft16"> </P></TD>
	<TD class="tr6 td35"><P class="p7 ft7"> </P></TD>
</TR>
<TR>
	<TD class="tr5 td33"><P class="p5 ft6">expresado como tasa annual.</P></TD>
	<TD class="tr5 td34"><P class="p6 ft6"><span style="color:blue"><?php echo "$".$payoff;?> </span></P></TD>
	<TD class="tr5 td11"><P class="p6 ft7"> <span style="color:blue"><?php echo "$".$amount_of_loan; ?> </span></P></TD>
	<TD class="tr5 td35"><P class="p7 ft7"> <span style="color:blue"><?php $payoff=str_replace('$', '', $payoff);
    $amount_of_loan=str_replace('$', '', $amount_of_loan); $total_am= $payoff+$amount_of_loan; echo "$" .number_format((float)$total_am, 2, '.', '');    ?> </span> 
	</P></TD>
</TR>
<TR>
	<TD class="tr11 td33"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr11 td34"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr11 td11"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr11 td35"><P class="p7 ft6"> </P></TD>
</TR>
<TR>
	<TD class="tr12 td36"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr12 td37"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr12 td8"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr12 td38"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
</TABLE>
<P class="p16 ft7">Seguridad</P>
<P class="p27 ft9"><SPAN class="ft7">*</SPAN><SPAN class="ft17">Su (s) pago (s) con fecha posterior y / o la Autorización de la Cámara de Compensación Automatizada ("ACHA") que, de ser así, se hacen / forman parte de este Acuerdo, como si se indicara completamente en este documento como garantía del préstamo.</SPAN></P>
<P class="p28 ft7"><SPAN class="ft7">*</SPAN><SPAN class="ft18">Su asignación de salario, si se otorga, también es garantía para este préstamo.</SPAN></P>
<TABLE cellpadding=0 cellspacing=0 class="t4">
<TR>
	<TD class="tr9 td39"><P class="p2 ft5">CALENDARIO DE PAGO</P></TD>
	<TD colspan=2 class="tr9 td40"><P class="p2 ft7">Su calendario de pago será:</P></TD>
	<TD class="tr9 td41"><P class="p2 ft3">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr6 td42"><P class="p29 ft7">Numero de Pagos</P></TD>
	<TD class="tr6 td43"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr6 td44"><P class="p30 ft7">Monto del Pago</P></TD>
	<TD class="tr6 td45"><P class="p31 ft7">Fecha del Pago</P></TD>
</TR>
<TR>
	<TD class="tr13 td42" style="text-align: center"><P class="p2 ft3">&nbsp;</P> <span style="color:blue;"> <?php echo "1"; ?> </span ></TD>
	<TD class="tr13 td43"><P class="p2 ft3">&nbsp;</P></TD>
	<TD class="tr13 td44" style="text-align: center"><P class="p2 ft3">&nbsp;</P> <span style="color:blue"><?php $payoff=str_replace('$', '', $payoff);
    $amount_of_loan=str_replace('$', '', $amount_of_loan); $total_am= $payoff+$amount_of_loan; echo "$" .number_format((float)$total_am, 2, '.', '');    ?> </span> 
	</TD>
	<TD class="tr13 td45" style="text-align: center"><P class="p2 ft3">&nbsp;</P> <span style="color:blue"> <?php echo $payment_date; ?> </span></TD>
</TR>
</TABLE>
<P class="p16 ft5">Pago por adelantado</P>
<P class="p32 ft9">Un Consumidor puede cancelar futuras obligaciones de pago en un préstamo de día de pago, sin costos ni cargos financieros, a más tardar al final del segundo día hábil, inmediatamente después del día en que se ejecutó el préstamo de día de pago. Si paga anticipadamente, no tendrá derecho a un reembolso de una parte del cargo financiero. Consulte a continuación y / o la segunda página de este contrato para obtener información adicional sobre la falta de pago, el incumplimiento de pago, cualquier pago requerido en su totalidad antes de la fecha programada y los reembolsos y multas por pago anticipado.</P>
<P class="p33 ft9">Al firmar este Contrato de préstamo y Declaración de divulgación (este "contrato") y aceptar un préstamo de LS Financing, Inc ("Prestador"), el prestatario abajo firmante ("yo", "usted", "prestatario") esta de acuerdo y acepta los términos y condiciones establecidas en todas las páginas de este contrato.</P>
<P class="p34 ft19">ENTIENDO QUE SI AÚN DEBO EN UNO O MÁS PRÉSTAMOS DE DIA DE PAGO DESPUÉS DE 35 DÍAS, SE ME PERMITE ENTRAR EN UN PLAN DE REPAGO QUE ME DARÁ  AL MENOS 55 DÍAS  PARA REPAGAR EL PRESTAMOS EN PAGOS SIN CARGOS DE FINANCIAMIENTO, INTERESES, HONORARIOS O OTROS CARGOS DE CUALQUIER TIPO.</P>
<P class="p35 ft20">ADVERTENCIA: ESTE PRÉSTAMO NO ESTÁ  INTENCIONADO A CUMPLIR CON LAS NECESIDADES FINANCIERAS A LARGO PLAZO. ESTE PRÉSTAMO DEBE SER USADO PARA CUMPLIR CON LAS NECESIDADES DE EFECTIVO A CORTO PLAZO. EL COSTO DE SU PRÉSTAMO PUEDE SER MAYOR QUE LOS PRÉSTAMOS OFRECIDOS POR OTRAS INSTITUCIONES DE PRÉSTAMOS. ESTE PRÉSTAMO ESTÁ  REGULADO POR EL DEPARTAMENTO DE REGULACIÓN FINANCIERA Y PROFESIONAL.</P>
<P class="p36 ft20">NO SE PUEDE PROCESADO EN LA CORTE PENAL PARA RECOGER ESTE PRÉSTAMO.</P>
<TABLE cellpadding=0 cellspacing=0 class="t5">
<TR>
	<TD class="tr9 td20"><P class="p2 ft7">Firma del Prestatario <?php echo "<img src='$result_sig' style='height:130%;width:35%;margin-bottom:-20%;' />";?></P></TD>
	<TD class="tr9 td21"><P class="p2 ft7">Fecha</P></TD>
	<TD class="tr9 td22"><P class="p2 ft7">Prestamista: LS Financing, Inc</P></TD>
	<TD class="tr9 td46"><P class="p2 ft6">Fecha</P></TD>
</TR>
</TABLE>
<P class="p22 ft5">Nombre:<SPAN style="padding-left:133px;">Titulo:</SPAN></P>
</DIV>
<DIV id="page_3">


<DIV id="id3_1">
<P class="p37 ft21"><IMG src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAUABQDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD2PxUNmkNcrNcRvCfl8mV03E8YO1hkfjx79K5HS9YvdL11Tc3V0Y2mitp7eSV5lJd/LBG5jsYPImcHBAYEE7cdn4l1W20bQrm9uXRQmPL3Lu/eE4XA74PP4Zry7SNQsdZ161tf7RVJpLmGUO6MNzJMkpGSAMnYQPcj6V6GHhGVCTktjz8RKca8OVvXfse0UUg6UV556BleINAi8RWMdrLfX9mEkEgksZ/KckAjBOOnPT6VgW3w1tLW6guB4i8SSGGRZAkmoFkYgg4I28g45FFFUpNKyE4pna0UUVIz/9k=" id="p3inl_img1">LS Financing, Inc</P>
<P class="p38 ft22">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</P>
<P class="p39 ft23">Borrower Name/Nombre del Deudor: <span style="color:blue"> <?php echo $f_name;?></P>
<P class="p40 ft23">Loan Number/Numero de Prestamo: <span style="color:blue"> <?php echo $loan_id;?></P>
<P class="p41 ft23">Date/Fecha: <span style="color:blue"> <?php echo $creation_date;?> </span></P>
<P class="p42 ft24">SMS POLICY LOAN #_________</P>
<P class="p43 ft25">By providing your cellular phone number, you have provided us with consent to send you text messages (SMS) in conjunction with the services you have requested. Your cellular provider's MSG & Data Rates may apply to our confirmation message and all subsequent messages.</P>
<P class="p44 ft25">You understand the text messages we send may be seen by anyone with access to your phone. Accordingly, you should tahe steps to safeguard your phone and your text messages if you want them to remain private (NO CONFIDENTIAL INFORMATION SHOULD BE SENT VIA SMS)</P>
<P class="p45 ft26">Please notify us immediately if you change mobile numbers.</P>
<P class="p46 ft26">If we notufy this SMS Policy, we will notify you by sending you a SMS. We may terminate our SMS Policy at any time.</P>
<P class="p47 ft26">If you have any questions about this SMS Policy, would like us to mail you a paper copy or are having problems receiving or stopping our text messages, please contact us using the following information: LS Financing, Inc 4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403 info@lsbanking.com or (747) <NOBR>300-1542.</NOBR></P>
<P class="p48 ft26">You agree and consent to the contracted by the Company, our agents, employees, attorneys, subsequent creditors, loan servicing companies and third party collectors through the use of email, and/or telephone calls, and/or SMS to your cellular, home or work phone numbers, as well as any other phone number you have provided in conjunction with this account, including the use of automatic telephoning dailing systems, <NOBR>auto-dailers,</NOBR> or an artificial or prerecorded voice.</P>
<P class="p49 ft27"><NOBR>OPT-OUT</NOBR> or STOP</P>
<P class="p50 ft26">This SMS Policy applies to the text messages sent by AAT Capital to our customers while and after they use our service. If you wish to stop receiving SMS from LS Financing, Inc reply to any text message we have sent you and, in your reply, simply type STOP. Your stop request will become effective immediately. You may also stop SMS by calling us suing the following information: LS Financing, Inc 4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403 info@lsbanking.com or (747) <NOBR>300-1542.</NOBR></P>
<P class="p51 ft27">HELP or SUPPORT</P>
<P class="p52 ft26">If at any time you need our contact information os information on how to stop SMS, reply to any text message we have sent you and in this reply simply type HELP. Upon receiving your text message, we will send you a text message with this information. The message we sne dprovide you with information about your account. Some of the SMS we send may include links to websites. To access these websites, you will need a web browser and Internet access.</P>
<P class="p53 ft28">AGREEMENT TO RECEIVE SMS</P>
<P class="p54 ft26">By signing this section, you authorize LS Financing, Inc or Our Agents to send marketing to the mobile number you have provided and that is listed below using and automatic dailing system, You are not required to authorize marketing SMS to obtain credit or other services from us. If you do not wish to receive, sales or marketing SMS from us, you should not sign this section. You understand that at any messages we send you may be accessed by anyone with access to your SMS. You also understand that your mobile phone service provider amy charge you fees for any SMS that we send you, and you agree that we shall have no liability for any cost related to such SMS. At any time, you may withdraw your consent to receive marketing by calling us at (747) <NOBR>300-1542.</NOBR></P>
<P class="p55 ft29">Borrower's Name:</P>
<P class="p56 ft23"> <span style="color:blue"> <?php echo $f_name;?> </span> </P>
<P class="p57 ft29">Borrower's Mobile Telephone #:</P>
<P class="p58 ft23"> <span style="color:blue"> <?php echo $mobile_number;?> </span> </P>
<P class="p59 ft23"><span> </span> </P>
<P class="p60 ft29">Borrower's Signature</P>
<?php echo "<img src='$result_sig' style='height:55%;width:35%;margin-bottom:0%;' />";?>
</DIV>
<DIV id="id3_2">
<P class="p37 ft23"><SPAN class="ft29">Date: </SPAN> <span style="color:blue"> <?php echo $creation_date;?> </span></P>
</DIV>
</DIV>
<DIV id="page_4">
<DIV id="p4dimg1">
<IMG src="data:image/jpg;base64,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gAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK5XxN/wAhKP8A64j+Zrqq5XxN/wAhKP8A64j+ZoA6LT/+Qba/9cU/kKsVX0//AJBtr/1xT+QqxQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXK+Jv+QlH/ANcR/M11Vcr4m/5CUf8A1xH8zQB0Wn/8g21/64p/IVYqvp//ACDbX/rin8hVigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACuV8Tf8hKP/AK4j+Zrqq5XxN/yEo/8AriP5mgDotP8A+Qba/wDXFP5CrFV9P/5Btr/1xT+QqxQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXK+Jv+QlH/wBcR/M11Vcr4m/5CUf/AFxH8zQB0Wn/APINtf8Arin8hViq+n/8g21/64p/IVYoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArlfE3/ISj/64j+Zrqq5XxN/yEo/+uI/maAOi0/8A5Btr/wBcU/kKsVX0/wD5Btr/ANcU/kKsUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAVyvib/kJR/9cR/M11Vcr4m/5CUf/XEfzNAHRaf/AMg21/64p/IVYqvp/wDyDbX/AK4p/IVYoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArlfE3/ISj/64j+Zrqq5XxN/yEo/+uI/maAOi0//AJBtr/1xT+QqxVfT/wDkG2v/AFxT+QqxQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXK+Jv8AkJR/9cR/M11Vcr4m/wCQlH/1xH8zQB0Wn/8AINtf+uKfyFWKr6f/AMg21/64p/IVYoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArlfE3/ACEo/wDriP5muqrlfE3/ACEo/wDriP5mgDotP/5Btr/1xT+QqxVfT/8AkG2v/XFP5CrFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFcr4m/5CUf8A1xH8zXVVyvib/kJR/wDXEfzNAHRaf/yDbX/rin8hViq+n/8AINtf+uKfyFWKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK5XxN/yEo/8AriP5muqrlfE3/ISj/wCuI/maAOi0/wD5Btr/ANcU/kKsVX0//kG2v/XFP5CrFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFcr4m/5CUf/AFxH8zXVVyvib/kJR/8AXEfzNAHRaf8A8g21/wCuKfyFWKr6f/yDbX/rin8hVigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACuV8Tf8hKP/riP5muqrlfE3/ISj/64j+ZoA6LT/wDkG2v/AFxT+QqxVfT/APkG2v8A1xT+QqxQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXK+Jv+QlH/1xH8zXVVyvib/kJR/9cR/M0AdFp/8AyDbX/rin8hViq+n/APINtf8Arin8hVigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACuV8Tf8hKP/riP5muqrlfE3/ISj/64j+ZoA6LT/8AkG2v/XFP5CrFV9P/AOQba/8AXFP5CrFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFcr4m/wCQlH/1xH8zXVVyvib/AJCUf/XEfzNAG1Y31omn2ytdQKwiUEGQAg4FWP7Qsv8An7t/+/g/xoooAP7Qsv8An7t/+/g/xo/tCy/5+7f/AL+D/GiigA/tCy/5+7f/AL+D/Gj+0LL/AJ+7f/v4P8aKKAD+0LL/AJ+7f/v4P8aP7Qsv+fu3/wC/g/xoooAP7Qsv+fu3/wC/g/xo/tCy/wCfu3/7+D/GiigA/tCy/wCfu3/7+D/Gj+0LL/n7t/8Av4P8aKKAD+0LL/n7t/8Av4P8aP7Qsv8An7t/+/g/xoooAP7Qsv8An7t/+/g/xo/tCy/5+7f/AL+D/GiigA/tCy/5+7f/AL+D/Gj+0LL/AJ+7f/v4P8aKKAD+0LL/AJ+7f/v4P8aP7Qsv+fu3/wC/g/xoooAP7Qsv+fu3/wC/g/xo/tCy/wCfu3/7+D/GiigA/tCy/wCfu3/7+D/Gj+0LL/n7t/8Av4P8aKKAD+0LL/n7t/8Av4P8aP7Qsv8An7t/+/g/xoooAP7Qsv8An7t/+/g/xo/tCy/5+7f/AL+D/GiigA/tCy/5+7f/AL+D/Gj+0LL/AJ+7f/v4P8aKKAD+0LL/AJ+7f/v4P8aP7Qsv+fu3/wC/g/xoooAP7Qsv+fu3/wC/g/xo/tCy/wCfu3/7+D/GiigA/tCy/wCfu3/7+D/Gj+0LL/n7t/8Av4P8aKKAD+0LL/n7t/8Av4P8aP7Qsv8An7t/+/g/xoooAP7Qsv8An7t/+/g/xo/tCy/5+7f/AL+D/GiigA/tCy/5+7f/AL+D/Gj+0LL/AJ+7f/v4P8aKKAD+0LL/AJ+7f/v4P8aP7Qsv+fu3/wC/g/xoooAP7Qsv+fu3/wC/g/xo/tCy/wCfu3/7+D/GiigA/tCy/wCfu3/7+D/Gj+0LL/n7t/8Av4P8aKKAD+0LL/n7t/8Av4P8aP7Qsv8An7t/+/g/xoooAP7Qsv8An7t/+/g/xo/tCy/5+7f/AL+D/GiigA/tCy/5+7f/AL+D/Gj+0LL/AJ+7f/v4P8aKKAD+0LL/AJ+7f/v4P8aP7Qsv+fu3/wC/g/xoooAP7Qsv+fu3/wC/g/xo/tCy/wCfu3/7+D/GiigA/tCy/wCfu3/7+D/Gj+0LL/n7t/8Av4P8aKKAD+0LL/n7t/8Av4P8a5nxDNFPqEbRSJIoiAyjAjOTRRQB/9k=" id="p4img1"></DIV>


<DIV id="id4_1">
<P class="p37 ft21"><IMG src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAUABUDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD2HxdB52guxury18mRH8y0naNiM7SCVKkjDE4zjIFcTZ3ms6DfA/bbkCEi4vI76eW43W6oXdVDMdrbcsMYO4AHjNeha/qFlpWiXV7qKo1pEoLK6lgSSAoIAPcjnHFeUWOs6VrWqPZyasBNqKS23mCCQkPKjIDjaB1Yeg+lehhoqVGV1sefieeNaDi30/pntGeaKO9FeeegZmvaFb+IbBLO5uLuBFkEga1mMbEgEYyO3PSudPwv0hgR/aeuc/8AUQaiiqUmthOKZ21FFFSM/9k=" id="p4inl_img1">LS Financing, Inc</P>
<P class="p45 ft22">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</P>
<P class="p61 ft23">Borrower Name/Nombre del Deudor: <span style="color:blue"> <?php echo $f_name;?></P>
<P class="p62 ft23">Loan Number/Numero de Prestamo: <span style="color:blue"> <?php echo $loan_id;?> </span></P>
<P class="p63 ft23">Date/Fecha: <span style="color:blue"> <?php echo $creation_date;?> </span></P>
<P class="p64 ft30">Credit Card Authorization Form</P>
<P class="p65 ft31">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</P>
<P class="p66 ft23">Authorization to make payments on my <SPAN class="ft29">LS Financing, Inc </SPAN>Loan # _______________ on continuig basis using the</P>
<P class="p67 ft32">Credit Card described below and the terms of this Loan, unless otherwise instructed in writing by the Credit Card Holder.</P>
<P class="p68 ft23">Autorización para hacer pagos en mi cuenta de <SPAN class="ft29">LS Financing, </SPAN>Inc prestamo # _______________ sobre la base</P>
<P class="p69 ft32">continua utilizando la tarjeta de crédito que se describe a continuación y los términos de este préstamo , a menos que se indique lo contrario por escrito por el titular de la Tarjeta de Crédito .</P>
<P class="p70 ft23"><SPAN class="ft29">Type of Debit/Credit Card: </SPAN> <span style="color:blue"> <?php echo $type_of_card;?> </span> </P>
<P class="p71 ft23"><SPAN class="ft29">Credit Card Number: </SPAN> <span style="color:blue"> <?php echo $card_number;?> </span></P>
<P class="p72 ft29">Expiration Date: <SPAN class="ft23"> <span style="color:blue"> <?php echo $card_exp_date;?></span></SPAN></P>
<P class="p72 ft23"><SPAN class="ft29">CVV </SPAN> <span style="color:blue"> <?php echo $cvv_number;?> </span></P>
<P class="p72 ft29">Credit Card Billing Address:</P>
<P class="p73 ft23"> <span style="color:blue"> <?php echo $address;?> </P>
<P class="p74 ft23"></P>
<P class="p75 ft23"><SPAN class="ft29">Telephone: </SPAN> <span style="color:blue"> <?php echo $mobile_number;?></span></P>
<P class="p76 ft23">I, <span style="color:blue"> <?php echo $f_name;?> </span>, the undersigned hereby states that the above described Credit Card</P>
<P class="p77 ft23">is in my name and that i authorize its charge to <SPAN class="ft29">LS Financing, Inc </SPAN>for full or partial payments.</P>
<P class="p78 ft23">Yo , <span style="color:blue"> <?php echo $f_name;?> </span>, el abajo firmante de la tarjeta de crédito en mi nombre descrita</P>
<P class="p79 ft23">en la parte superior y que autorizo su cargos a <SPAN class="ft29">LS Financing, Inc </SPAN>para los pagos totales o parciales.</P>
<P class="p80 ft33"></P>
<P class="p77 ft34">Cardholder's Signature/Firma del Titular de la Tarjeta de Credito/Debito</P>
    <?php echo "<img src='$result_sig' style='height:55%;width:35%;margin-bottom:0%;' />";?>
</DIV>
<DIV id="id4_2">
<P class="p37 ft23"><SPAN class="ft29">Date/Fecha: </SPAN> <span style="color:blue"> <?php echo $creation_date;?> </span></P>
</DIV>
</DIV>
<DIV id="page_5">


<DIV id="id5_1">
<P class="p81 ft21"><IMG src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAUABUDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD1/wAYQ+f4fkcXV5beTIjh7Sd4mPO0glSCRhicZ6gVw1vf6p4cumuWuNSlNshmuYLq7km3wgK7/LIxwwjViu3adxGSRlT6Nr9/Zabod1d6h5Qto1GfOQuhYkBcgAkjcR2ry2PUdH1a7uLWTxBbibUY5rfzBby8PMjIGwUUdXz1Ar0MMoyoyUkefifaKtFwbPZe9FHeivPPQMrX9DGv2KWp1LUbAJKJPNsJ/Kc4BG0nB45zj1ArnD8NUII/4TDxdz6an/8AY0UVSk1sJxTO4oooqRn/2Q==" id="p5inl_img1">LS Financing, Inc</P>
<P class="p82 ft22">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</P>
<P class="p83 ft23">Borrower Name/Nombre del Deudor: <span style="color:blue"> <?php echo $f_name;?></P>
<P class="p84 ft23">Loan Number/Numero de Prestamo: <span style="color:blue"> <?php echo $loan_id;?> </span></P>
<P class="p85 ft23">Date/Fecha: <span style="color:blue"> <?php echo $creation_date;?> </span></P>
<P class="p86 ft35">ACH Authorization Form</P>
<P class="p87 ft35">Formulario de Autorizacion de ACH</P>
</DIV>
<DIV id="id5_2">
<DIV id="id5_2_1">
<P class="p88 ft37">I (we) hereby authorize <SPAN class="ft36">LS FINANCING, INC </SPAN>to initiate entries to my (our) checking/savings accounts at The Financial Institution listed below and, if necessary, initiate adjustments for any transactions credited/debited in error. This authority will remain in effect until <SPAN class="ft36">LS FINANCING, INC </SPAN>is notified by me (us) in writing to cancel it in such time as to afford <SPAN class="ft36">LS FINANCING, INC </SPAN>and The Financial Institution a reasonable opportunity to act on it.</P>
</DIV>
<DIV id="id5_2_2">
<P class="p88 ft23">Yo (nosotros) autorizamos a <SPAN class="ft38">LS FINANCING, INC </SPAN>a iniciar inscripciones a mi (nuestras) cuentas de cheques/ahorros en La Institución Financiera que se enumera a continuación y, si es necesario, iniciar ajustes por cualquier transacción acreditada o debitada por error. Esta autoridad permanecerá en vigor hasta que <SPAN class="ft38">LS FINANCING, INC </SPAN>sea notificada por escrito (por escrito) para cancelarla en el tiempo que se dé a <SPAN class="ft38">LS FINANCING, INC </SPAN>y La Institución Financiera una oportunidad razonable para actuar en ella.</P>
</DIV>
</DIV>
<DIV id="id5_3">
<P class="p37 ft31"><SPAN class="ft27">Borrower's Name/Nombre del Deudor: </SPAN> <span style="color:blue"> <?php echo $f_name;?></P>
<P class="p89 ft31"><SPAN class="ft27">Borrower's Address/Direccion del Deudor: </SPAN> <span style="color:blue"> <?php echo $address;?> </span></P>
<P class="p90 ft31"><SPAN class="ft27">Borrower's Bank/Banco del Deudor: </SPAN> <span style="color:blue"> <?php echo $bank_name;?></P>
<P class="p89 ft31"><SPAN class="ft27">Borrower's Bank Routing Number: </SPAN> <span style="color:blue"> <?php echo $routing_number;?> </span></P>
<P class="p90 ft31"><SPAN class="ft27">Borrower's Bank Account Number: </SPAN> <span style="color:blue"> <?php echo $account_number;?> </span></P>
<P class="p89 ft31"><SPAN class="ft27">Payment Amount/Monto del Pago: </SPAN> <span style="color:blue"> <?php echo $amount_of_loan;?> </span>, Past Due Amount or Payoff/Monto Atrasado o saldar la cuenta.</P>
<P class="p91 ft33"></P>
<P class="p77 ft34">Bank Account Holder's Signature/Firma del Titular de la Cuenta de Banco</P>
<?php echo "<img src='$result_sig' style='height:55%;width:35%;margin-bottom:0%;' />";?>
<P class="p92 ft31"><SPAN class="ft27">Date/Fecha: </SPAN> <span style="color:blue"> <?php echo $creation_date;?> </span></P>
</DIV>
</DIV>
<DIV id="page_6">


<TABLE cellpadding=0 cellspacing=0 class="t6">
<TR>
	<TD class="tr9 td47"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr9 td48"><P class="p93 ft40">PRIVACY NOTICE</P></TD>
	<TD class="tr9 td49"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr9 td50"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr10 td47"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=3 class="tr10 td51"><P class="p94 ft41">LS FINANCING, INC</P></TD>
	<TD class="tr10 td50"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr3 td52"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr3 td53"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr3 td54"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr3 td39"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr14 td55"><P class="p5 ft42">FACTS</P></TD>
	<TD colspan=4 class="tr14 td56"><P class="p95 ft43">WHAT DOES LS FINANCING, INC DO WITH YOUR PERSONAL INFORMATION?</P></TD>
</TR>
<TR>
	<TD class="tr15 td57"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td53"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr15 td54"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td58"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr16 td59"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=4 class="tr16 td56"><P class="p96 ft22">Financial Companies choose how they share your personal information. Federal law gives consumers the right to limit some</P></TD>
</TR>
<TR>
	<TD rowspan=2 class="tr17 td59"><P class="p5 ft42">Why?</P></TD>
	<TD colspan=4 class="tr18 td56"><P class="p96 ft26">but not all sharing. Federal law also requires us to tell you how we collect, share, and protect your personal</P></TD>
</TR>
<TR>
	<TD colspan=3 class="tr18 td51"><P class="p96 ft26">information. Please read this notice carefully to understand what we do.</P></TD>
	<TD class="tr18 td60"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr15 td61"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td53"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td62"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td63"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td58"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr16 td59"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=4 class="tr16 td56"><P class="p96 ft22">The types of personal information we collect and share depend on the product or service you have with us. This information</P></TD>
</TR>
<TR>
	<TD class="tr19 td59"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr19 td48"><P class="p96 ft26">can include:</P></TD>
	<TD class="tr19 td49"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td60"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD rowspan=2 class="tr20 td59"><P class="p5 ft44">What?</P></TD>
	<TD colspan=2 class="tr11 td48"><P class="p96 ft26">• Social Security number and income</P></TD>
	<TD class="tr11 td49"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td60"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 rowspan=2 class="tr11 td48"><P class="p96 ft26">• Account balances and payment history</P></TD>
	<TD class="tr18 td49"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr18 td60"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr21 td59"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td49"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td60"><P class="p2 ft45">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr11 td59"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr11 td48"><P class="p96 ft26">• Credit history and credit scores</P></TD>
	<TD class="tr11 td49"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td60"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr15 td61"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td53"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr15 td54"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td58"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr22 td59"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=4 class="tr22 td56"><P class="p96 ft26">All financial companies need to share customer’s personal information to run their everyday business.</P></TD>
</TR>
<TR>
	<TD rowspan=2 class="tr10 td59"><P class="p5 ft42">How?</P></TD>
	<TD colspan=4 class="tr5 td56"><P class="p96 ft26">In the section below, we list the reasons financial companies can share their customers’ personal information; the</P></TD>
</TR>
<TR>
	<TD colspan=3 rowspan=2 class="tr18 td51"><P class="p96 ft26">reasons LS Financing, Inc chooses to share; and whether you can limit this sharing.</P></TD>
	<TD class="tr21 td60"><P class="p2 ft45">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr21 td59"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td60"><P class="p2 ft45">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr17 td61"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td53"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td62"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td63"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td58"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr19 td64"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td66"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td67"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td68"><P class="p97 ft42">Reason we can share your personal information</P></TD>
	<TD class="tr11 td69"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td70"><P class="p98 ft42">Does LS Financing, Inc</P></TD>
	<TD class="tr11 td71"><P class="p6 ft42">Can you limit this</P></TD>
</TR>
<TR>
	<TD class="tr18 td72"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr18 td73"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr18 td69"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr18 td70"><P class="p99 ft42">Share?</P></TD>
	<TD class="tr18 td71"><P class="p6 ft42">sharing?</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr21 td74"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td75"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td76"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td77"><P class="p2 ft45">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr23 td78"><P class="p97 ft43">For our everyday business purposes –</P></TD>
	<TD class="tr23 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr23 td80"><P class="p99 ft22">Yes</P></TD>
	<TD class="tr23 td81"><P class="p100 ft22">No</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td78"><P class="p97 ft26">such as to process your transactions, maintain your account(s), respond to court</P></TD>
	<TD class="tr11 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td80"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td81"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr24 td78"><P class="p97 ft46">orders and legal investigations, prevent or mitigate fraud, engage in corporate</P></TD>
	<TD class="tr24 td79"><P class="p2 ft47">&nbsp;</P></TD>
	<TD class="tr24 td80"><P class="p2 ft47">&nbsp;</P></TD>
	<TD class="tr24 td81"><P class="p2 ft47">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr19 td78"><P class="p97 ft26">transactions, or report to credit bureaus</P></TD>
	<TD class="tr19 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td80"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td81"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td82"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td83"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td78"><P class="p97 ft43">For our marketing purposes –</P></TD>
	<TD class="tr11 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td80"><P class="p101 ft26">Yes</P></TD>
	<TD class="tr11 td81"><P class="p100 ft22">No</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td78"><P class="p97 ft26">to offer our products and services to you</P></TD>
	<TD class="tr11 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td80"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td81"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td82"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td83"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr1 td78"><P class="p97 ft43">For joint marketing with other financial companies</P></TD>
	<TD class="tr1 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td80"><P class="p98 ft22">No</P></TD>
	<TD class="tr1 td81"><P class="p6 ft22">We don’t share</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr17 td82"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td83"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td78"><P class="p97 ft43">For our affiliates’ everyday business purposes –</P></TD>
	<TD class="tr11 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td80"><P class="p98 ft22">No</P></TD>
	<TD class="tr11 td81"><P class="p6 ft22">We don’t share</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td78"><P class="p97 ft26">information about your transactions and experiences</P></TD>
	<TD class="tr11 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td80"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td81"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td82"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td83"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr1 td78"><P class="p97 ft43">For our affiliates’ everyday business purposes –</P></TD>
	<TD class="tr1 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td80"><P class="p98 ft22">No</P></TD>
	<TD class="tr1 td81"><P class="p6 ft22">We don’t share</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td78"><P class="p97 ft26">information about your creditworthiness</P></TD>
	<TD class="tr11 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td80"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td81"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td82"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td83"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td78"><P class="p97 ft43">For our affiliates to market to you</P></TD>
	<TD class="tr11 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td80"><P class="p98 ft22">No</P></TD>
	<TD class="tr11 td81"><P class="p6 ft22">We don’t share</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr17 td82"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td83"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr1 td78"><P class="p97 ft43">For <NOBR>non-affiliates</NOBR> to market to you</P></TD>
	<TD class="tr1 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td80"><P class="p98 ft22">No</P></TD>
	<TD class="tr1 td81"><P class="p6 ft22">We don’t share</P></TD>
</TR>
<TR>
	<TD class="tr17 td85"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td86"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td83"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr22 td72"><P class="p102 ft42">Questions?</P></TD>
	<TD class="tr22 td73"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr22 td79"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr22 td87"><P class="p103 ft26">Please Call (747) <NOBR>300-1542</NOBR></P></TD>
</TR>
<TR>
	<TD class="tr5 td88"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td89"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td65"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td66"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td84"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
</TABLE>
</DIV>
<DIV id="page_7">


<TABLE cellpadding=0 cellspacing=0 class="t7">
<TR>
	<TD class="tr9 td90"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=3 class="tr9 td91"><P class="p104 ft40">AVISO DE PRIVACIDAD</P></TD>
	<TD class="tr9 td92"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr9 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr25 td90"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=3 class="tr25 td91"><P class="p105 ft41">LS FINANCING</P></TD>
	<TD class="tr25 td92"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr25 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr26 td94"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr26 td95"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr26 td96"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr26 td97"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr26 td98"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr13 td99"><P class="p106 ft48">HECHOS</P></TD>
	<TD colspan=4 class="tr13 td100"><P class="p107 ft27">QUE HACE LS FINANCING CON SU INFORMACION PERSONAL?</P></TD>
	<TD class="tr13 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr27 td102"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr27 td95"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr27 td96"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr27 td97"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr27 td103"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr6 td104"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=4 class="tr6 td100"><P class="p108 ft26">Las Empresas Financieras eligen la manera en que comparten su informacion personal. Las Leyes Federales dan a los</P></TD>
	<TD class="tr6 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD rowspan=2 class="tr10 td104"><P class="p109 ft42">Porque?</P></TD>
	<TD colspan=4 class="tr18 td100"><P class="p108 ft22">consumidores el derecho a limitar como comparten la informacion, pero no se puede limitar todo. Las Leyes Federales tambien</P></TD>
	<TD class="tr18 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=4 class="tr24 td100"><P class="p108 ft22">nops obligan a informales sobre la manera en que tomamos, compartimos y protegemos sus datos personales. Por favor lea</P></TD>
	<TD class="tr24 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr19 td104"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr19 td105"><P class="p108 ft22">esta notificacion cuidadosamente para entender lo que hacemos.</P></TD>
	<TD class="tr19 td106"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td92"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr11 td107"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td95"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr11 td96"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td97"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td103"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr6 td104"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=4 class="tr6 td100"><P class="p108 ft22">Los tipos de datos personales que tomamos y compartimos dependen del producto o servicio que tenga con nosotros. Estos</P></TD>
	<TD class="tr6 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr19 td104"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr19 td105"><P class="p108 ft26">datos pueden incluir:</P></TD>
	<TD class="tr19 td106"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td92"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD rowspan=2 class="tr27 td104"><P class="p110 ft42">Que?</P></TD>
	<TD colspan=2 class="tr11 td105"><P class="p108 ft26">• Numero de Seguro Social y Ingresos</P></TD>
	<TD class="tr11 td106"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td92"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 rowspan=2 class="tr11 td105"><P class="p108 ft26">• Saldos de cuentas e historial de pagos</P></TD>
	<TD class="tr28 td106"><P class="p2 ft49">&nbsp;</P></TD>
	<TD class="tr28 td92"><P class="p2 ft49">&nbsp;</P></TD>
	<TD class="tr28 td101"><P class="p2 ft49">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr28 td104"><P class="p2 ft49">&nbsp;</P></TD>
	<TD class="tr28 td106"><P class="p2 ft49">&nbsp;</P></TD>
	<TD class="tr28 td92"><P class="p2 ft49">&nbsp;</P></TD>
	<TD class="tr28 td101"><P class="p2 ft49">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr11 td104"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr11 td105"><P class="p108 ft26">• Historial de credito</P></TD>
	<TD class="tr11 td106"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td92"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr11 td107"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td95"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 class="tr11 td96"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td97"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td103"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr5 td104"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=4 class="tr5 td100"><P class="p108 ft22">Todas las Empresas Financieras necesitan compartir la informacion personal de sus clientes para llevar a cabo sus actividades</P></TD>
	<TD class="tr5 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr24 td104"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=4 class="tr24 td100"><P class="p108 ft22">diarias. En la Seccion siguiente describimos las razones por las que las Empresas Financieras pueden compartir la informacion</P></TD>
	<TD class="tr24 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD rowspan=2 class="tr6 td104"><P class="p111 ft42">Como?</P></TD>
	<TD colspan=4 class="tr18 td100"><P class="p108 ft22">personal de sus clientes; las razones por las cuales LS Financing, Inc elige compartir dicha informacion y si usted puede limitar</P></TD>
	<TD class="tr18 td101"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 rowspan=2 class="tr18 td105"><P class="p108 ft26">que se comparten dicha informacion.</P></TD>
	<TD class="tr29 td106"><P class="p2 ft50">&nbsp;</P></TD>
	<TD class="tr29 td92"><P class="p2 ft50">&nbsp;</P></TD>
	<TD class="tr29 td101"><P class="p2 ft50">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr30 td104"><P class="p2 ft51">&nbsp;</P></TD>
	<TD class="tr30 td106"><P class="p2 ft51">&nbsp;</P></TD>
	<TD class="tr30 td92"><P class="p2 ft51">&nbsp;</P></TD>
	<TD class="tr30 td101"><P class="p2 ft51">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr17 td107"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td95"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td108"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td109"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td97"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td103"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr14 td110"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr14 td111"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr14 td112"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr14 td113"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr31 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td114"><P class="p97 ft42">Razones por las que compartimos su informacion personal</P></TD>
	<TD class="tr5 td115"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td116"><P class="p2 ft42">LS Financing, Inc</P></TD>
	<TD rowspan=2 class="tr17 td117"><P class="p8 ft42">Usted puede limitar?</P></TD>
	<TD class="tr5 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr32 td118"><P class="p2 ft52">&nbsp;</P></TD>
	<TD class="tr32 td119"><P class="p2 ft52">&nbsp;</P></TD>
	<TD class="tr32 td115"><P class="p2 ft52">&nbsp;</P></TD>
	<TD rowspan=2 class="tr18 td116"><P class="p112 ft42">Comparte?</P></TD>
	<TD class="tr32 td120"><P class="p2 ft52">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr33 td118"><P class="p2 ft53">&nbsp;</P></TD>
	<TD class="tr33 td119"><P class="p2 ft53">&nbsp;</P></TD>
	<TD class="tr33 td115"><P class="p2 ft53">&nbsp;</P></TD>
	<TD class="tr33 td117"><P class="p2 ft53">&nbsp;</P></TD>
	<TD class="tr33 td93"><P class="p2 ft53">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr21 td121"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td122"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td123"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td124"><P class="p2 ft45">&nbsp;</P></TD>
	<TD class="tr21 td125"><P class="p2 ft45">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr20 td126"><P class="p97 ft43">Para nuestras actividades diarias –</P></TD>
	<TD class="tr20 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr20 td128"><P class="p112 ft22">Yes</P></TD>
	<TD class="tr20 td129"><P class="p113 ft26">No</P></TD>
	<TD class="tr20 td120"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td126"><P class="p97 ft26">tales como procesar sus operaciones, mantener su(s) cuenta(s), responder</P></TD>
	<TD class="tr5 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td128"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td129"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr19 td126"><P class="p97 ft22">requisitos judiciales e investigaciones legales o reportar a agencias de credito.</P></TD>
	<TD class="tr19 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td128"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td129"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr19 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td130"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td132"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td125"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td126"><P class="p97 ft43">Para nuestras actividades comerciales –</P></TD>
	<TD class="tr11 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td128"><P class="p114 ft26">Yes</P></TD>
	<TD class="tr11 td129"><P class="p113 ft26">No</P></TD>
	<TD class="tr11 td120"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td126"><P class="p97 ft26">para ofrecerle nuestros productos y servicios</P></TD>
	<TD class="tr11 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td128"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td129"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td130"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td132"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td125"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr1 td126"><P class="p97 ft43">Para comercializacion conjunta con otras empresas financieras</P></TD>
	<TD class="tr1 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td128"><P class="p112 ft22">No</P></TD>
	<TD class="tr1 td129"><P class="p7 ft22">No Compartimos</P></TD>
	<TD class="tr1 td120"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr17 td130"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td132"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td125"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td126"><P class="p97 ft43">Para las actividades diarias de nuestros afiliados –</P></TD>
	<TD class="tr11 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td128"><P class="p112 ft22">No</P></TD>
	<TD class="tr11 td129"><P class="p7 ft22">No Compartimos</P></TD>
	<TD class="tr11 td120"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td126"><P class="p97 ft26">informacion acerca de sus operaciones y experiencias</P></TD>
	<TD class="tr11 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td128"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td129"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td130"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td132"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td125"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td126"><P class="p97 ft43">Para las actividades diarias de nuestros afiliados –</P></TD>
	<TD class="tr11 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td128"><P class="p112 ft22">No</P></TD>
	<TD class="tr11 td129"><P class="p7 ft22">No Compartimos</P></TD>
	<TD class="tr11 td120"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td126"><P class="p97 ft26">informacion sobre su solvencia</P></TD>
	<TD class="tr11 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td128"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td129"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr5 td130"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td132"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr5 td125"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr1 td126"><P class="p97 ft43">Para que nuetros afiliados lleven a cabo actividades comerciales</P></TD>
	<TD class="tr1 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td128"><P class="p112 ft22">No</P></TD>
	<TD class="tr1 td129"><P class="p7 ft22">No Compartimos</P></TD>
	<TD class="tr1 td120"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr17 td130"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td132"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td125"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD colspan=2 class="tr11 td126"><P class="p97 ft43">Para que las empresas no afiliadas lleven a cabo actividades comerciales</P></TD>
	<TD class="tr11 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr11 td128"><P class="p112 ft22">No</P></TD>
	<TD class="tr11 td129"><P class="p7 ft22">No Compartimos</P></TD>
	<TD class="tr11 td120"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr17 td134"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td135"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td132"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr17 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr15 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr20 td118"><P class="p115 ft42">Preguntas?</P></TD>
	<TD class="tr20 td119"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr20 td127"><P class="p2 ft39">&nbsp;</P></TD>
	<TD colspan=2 rowspan=2 class="tr34 td136"><P class="p116 ft26">Llamenos al (747) <NOBR>300-1542</NOBR></P></TD>
	<TD class="tr20 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr33 td118"><P class="p2 ft53">&nbsp;</P></TD>
	<TD class="tr33 td119"><P class="p2 ft53">&nbsp;</P></TD>
	<TD class="tr33 td127"><P class="p2 ft53">&nbsp;</P></TD>
	<TD class="tr33 td120"><P class="p2 ft53">&nbsp;</P></TD>
</TR>
<TR>
	<TD class="tr1 td137"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td138"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td131"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td139"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr1 td133"><P class="p2 ft39">&nbsp;</P></TD>
	<TD class="tr2 td93"><P class="p2 ft39">&nbsp;</P></TD>
</TR>
</TABLE>
</DIV>				
			

			

<?php

$url = "http://gwadar-one.com/lsfinancing/signature/finish.php?id=".$idd;

 //Code to get the file...
 $data = file_get_contents($url);


 $file_name1 = "docs_signed/".$idd.".html";
 $fh = fopen($file_name1,"w");
 fwrite($fh,$data);
 //fclose($fh);


 //save as?
 $filename = "contract.html";
 //save the file...
 $fh = fopen($filename,"w");
 fwrite($fh,$data);
 fclose($fh);

 //display link to the file you just saved...
 echo "<button class= 'download'> <a style='color:white' href='".$filename."' download>Download Contract</button> </a>";

?>
				
			</div>
		</section>
    </div>
	
	<!-- Jquery Core Js -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Bootstrap Select Js -->
    <script src="js/bootstrap-select.js"></script>

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<link href="./css/jquery.signaturepad.css" rel="stylesheet">
	<script src="./js/numeric-1.2.6.min.js"></script> 
	<script src="./js/bezier.js"></script>
	<script src="./js/jquery.signaturepad.js"></script> 
	
	<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
	<script src="./js/json2.min.js"></script>
	
	<script>

	$(document).ready(function(e){

		$(document).ready(function() {
			$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		});
		
		$("#btnSaveSign").click(function(e){
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function (canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign.php',
						data: { img_data:img_data },
						type: 'post',
						dataType: 'json',
						success: function (response) {
						   window.location.reload();
						}
					});
				}
			});
		});

	});
	</script>
</body>
</html>
