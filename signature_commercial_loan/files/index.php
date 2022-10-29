<iframe src="contract_pdf.php?id=<?php echo $_GET['id'] ;?>" style="width:100%; height:94%;overflow:hidden"></iframe>



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
		
		#btnSaveSign {
			color: #fff;
			background: #f99a0b;
			padding: 5px;
			border: none;
			border-radius: 5px;
			font-size: 20px;
			margin-top: 10px;
		}
		
		
		#btnupload {
		    color: #fff;
			background: #f99a0b;
			padding: 5px;
			border: none;
			border-radius: 5px;
			font-size: 20px;
			margin-top: 10px;
		}
		
		
		#signArea{
			width:304px;
			margin: 15px auto;
		}
		.sign-container {
			width: 90%;
			margin: auto;
		}
		.sign-preview {
			width: 150px;
			height: 50px;
			border: solid 1px #CFCFCF;
			margin: 10px 5px;
		}
		.tag-ingo {
			font-family: cursive;
			font-size: 12px;
			text-align: left;
			font-style: oblique;
		}
		.center-text {
			text-align: center;
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
					<h3 class="post-title">Please Sign the Contract.</h3>
				</div>
				
	
<DIV style="padding: 50px 0px 15px 20px; font-family: Arial, Helvetica, sans-serif; font-size: 8px; color: #c8c8c8;">
	
</DIV>
				
				<div class="page-body clearfix">
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
							<div class="panel panel-default">
								<div class="panel-heading">Digital Signature:</div>
								<div class="panel-body center-text">

								<div id="signArea" >
									<h2 class="tag-ingo">Put signature below,</h2>
									<div class="sig sigWrapper" style="height:auto;">
										<div class="typed"></div>
										<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
									</div>
								</div>
								
								
						<button id="btnSaveSign">Save Signature</button> <br>
								<b>OR</b> 
								<br>
								
<?php

include 'dbconnect.php';
include 'dbconfig.php';

if(isset($_POST['btnupload'])) 
{
        $imgFile = $_FILES['imagee']['name'];
        $tmp_dir = $_FILES['imagee']['tmp_name'];
        $imgSize = $_FILES['imagee']['size'];
        
            $upload_dir = 'doc_signs/'; // upload directory
    
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;
                
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

 $query_sign  = "UPDATE loan_initial_banking SET `sign_status`='1',`signed_pic`='$userpic' WHERE `email_key` = '$iddd' ";
        $result_sign = mysqli_query($con, $query_sign);
        if ($result_sign) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
?>

<script type="text/javascript">
window.location.href = 'finish.php?id=<?php echo $iddd; ?>';
</script>


<?php
}
?>
								
		<form action ="" method="POST" enctype="multipart/form-data">						
       <label for="usr">Upload Your Signature</label>
       <input type="file" name="imagee"  class="form-control" accept="image/*" style="width:35%;margin-left:33%"><br>
       <button id="btnupload" type="submit" name="btnupload"> Upload Signature</button>
		</form>
		
								<div class="sign-container" style="display:none;">
								<?php
								$image_list = glob("./doc_signs/*.png");
								foreach($image_list as $image){
									//echo $image;
								?>
								<img src="<?php echo $image; ?>" class="sign-preview" />
								<?php
								}
								?>
								</div>
									

								</div>
							</div>
						</div>


					</div>
				</div>
			
			
			
			
			
			
			
			
			<div class="page-body clearfix">
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
							<div class="panel panel-default">
								<div class="panel-heading">Digital Signature:</div>
								<div class="panel-body center-text">

								<div id="signArea" >
									<h2 class="tag-ingo">Put signature below,</h2>
									<div class="sig sigWrapper" style="height:auto;">
										<div class="typed"></div>
										<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
									</div>
								</div>
								
								
						<button id="btnSaveSign">Save Signature</button> <br>
								<b>OR</b> 
								<br>
								
<?php

include 'dbconnect.php';
include 'dbconfig.php';

if(isset($_POST['btnupload'])) 
{
        $imgFile = $_FILES['imagee']['name'];
        $tmp_dir = $_FILES['imagee']['tmp_name'];
        $imgSize = $_FILES['imagee']['size'];
        
            $upload_dir = 'doc_signs/'; // upload directory
    
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;
                
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

 $query_sign  = "UPDATE loan_initial_banking SET `sign_status`='1',`signed_pic`='$userpic' WHERE `email_key` = '$iddd' ";
        $result_sign = mysqli_query($con, $query_sign);
        if ($result_sign) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
?>

<script type="text/javascript">
window.location.href = 'finish.php?id=<?php echo $iddd; ?>';
</script>


<?php
}
?>
								
		<form action ="" method="POST" enctype="multipart/form-data">						
       <label for="usr">Upload Your Signature</label>
       <input type="file" name="imagee"  class="form-control" accept="image/*" style="width:35%;margin-left:33%"><br>
       <button id="btnupload" type="submit" name="btnupload"> Upload Signature</button>
		</form>
		
								<div class="sign-container" style="display:none;">
								<?php
								$image_list = glob("./doc_signs/*.png");
								foreach($image_list as $image){
									//echo $image;
								?>
								<img src="<?php echo $image; ?>" class="sign-preview" />
								<?php
								}
								?>
								</div>
									

								</div>
							</div>
						</div>


					</div>
				</div>
			
			
			
			
			
			
			
			
			
			
			
			
				
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
					var key = '<?php echo $iddd;?>';
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign.php',
						data: { img_data:img_data, key:key },
						type: 'post',
						dataType: 'json',
						success: function (response) {
						   window.location.href="finish.php?id=<?php echo $iddd; ?>";
						}
					});
				}
			});
		});

	});
	</script>
	
	
	
	
	
	
	
	
</body>
</html>