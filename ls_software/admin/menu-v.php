<?php 
date_default_timezone_set('America/Los_Angeles');

$conn = new mysqli("lsbankingportal.com","message_chat","admin$$123","message_chat");
$count=0;
$sql2="SELECT * FROM webchat_lines WHERE notification_status = 0";
$result=mysqli_query($conn, $sql2);
$count=mysqli_num_rows($result);

?>

<html>
<head>

	<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">




<style>
    
    #menu {
  background: #1E90FF ;
  color: #ffffff;
  height: 35px;
}

#menu ul,
#menu li {
  margin: 0 0;
  padding: 0 0;
  list-style: none
}

#menu ul {
  height: 35px
}

#menu li {
  float: left;
  display: inline;
  position: relative;
  font: bold 12px Arial;
  color: white;
  //text-shadow: 0 -1px 0 #000;c
  text-transform: uppercase;
  padding-left:10px;
}

#menu li:first-child {
  border-left: none
}

#menu a {
  display: block;
  line-height: 51px;
    font-size : 14px;
  text-decoration: none;
  color: #ffffff;
}

#menu li:hover > a,
#menu li a:hover {
  background: #1E90FF 
}

#menu input {
  display: none;
  margin: 0 0;
  padding: 0 0;
  width: 80px;
  height: 35px;
  opacity: 0;
  cursor: pointer
}

#menu label {
  font: bold 30px Arial;
  display: none;
  width: 35px;
  height: 36px;
  line-height: 50px;
  text-align: center
}

#menu label span {
  font-size: 12px;
  position: absolute;
  left: 35px
}

#menu ul.menus {
  height: auto;
  width: 180px;
  background: #1E90FF;
  position: absolute;
  z-index: 99;
  display: none;
  border: 0;
}

#menu ul.menus li {
  display: block;
  width: 100%;
  font: 15px Arial;
  text-transform: none;
}

#menu li:hover ul.menus {
  display: block
}

#menu a.home {
  background: #1E90FF;
}

#menu a.prett {
  padding: 0 27px 0 14px
}

#menu a.prett::after {
  content: "";
  width: 0;
  height: 0;
  border-width: 6px 5px;
  border-style: solid;
  border-color: #eee transparent transparent transparent;
  position: absolute;
  top: 15px;
  right: 9px
}

#menu ul.menus a:hover {
  background: #1E90FF;
}

#menu ul.menus .submenu {
  display: none;
  position: absolute;
  left: 180px;
  background: #1E90FF;
  top: 0;
  width: 180px;
}

#menu ul.menus .submenu li {
  background: #1E90FF;
}

#menu ul.menus .has-submenu:hover .submenu {
  display: block;
}


#notification-count{
	left: 0px;
	top: 0px;
	font-size: 16px;		
	color: red;
   padding: 5px;
   border-radius: 11px;

	font-weight:bold;
}
.top-menu {
	font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:14px;
	line-height:1.42857143;
	color:#margin-left:;
	background-color:#fff
}
.loan{
    padding-left:-0px;
}
#menu a {
    display: block;
    line-height: 29px !important;
}


</style>


</head>
<nav class="navbar navbar-default navbar-fixed-top top-menu lsbanking" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%); font-weight:600 ;font-size:20px">
      <div class="" style="width:98%">
       
        <div id="navbar" class="navbar-collapse collapse" style="float:right; position:relative; display:block; width:100%">
          <ul class="nav navbar-nav nav1" style="flex-direction:row !important; ">
            <a class="navbar-brand" href="http://lsbankingportal.com/ls_software/admin/home.php" style="color:white;"><span class="glyphicon glyphicon-home" style="font-size:20px;color:white"></span></a>
            <li class="loan"><a href="http://lsbankingportal.com/ls_software/admin/view_all_customer.php?status=All&keyword=&from_date=&to_date=&search=&website=All"  style="color:white; font-size:20px">Applications</a></li>
            <li class="loan"><a href="http://lsbankingportal.com/ls_software/admin/view_all_payday_loans.php" style="color:white;">Payday Loans</a></li>
            <li class="loan"><a href="#"  style="color:white;">Personal Loans</a></li>
            <li class="loan"><a href="#"  style="color:white;">Reports</a></li>
            <li class="loan"><a href="http://lsbankingportal.com/ls_software/admin/marketing.php"  style="color:white;">Marketing</a></li>
            
            
             
              
            <li  class="loan">
                 <ul id='menu' style="padding-left:0px; font-size:16px">
    <li class = "loan"><a  href='#' title='Menu' style="font-size:20px">Settings</a>
      <ul class='menus'>
        <li><a href="http://lsbankingportal.com/ls_software/admin/sms_settings.php"  style="color:white;" title='Dropdown 1'>SMS Settings</a>
        </li>
        <li class="portfolio"><a href="http://lsbankingportal.com/ls_software/admin/view_all_companies.php"  style="color:white;">Portfolios</a></li>
        <li class="user"><a href="http://lsbankingportal.com/ls_software/admin/view_all_user.php"  style="color:white;">User</a></li>
        
      </ul>
    </li>
  </ul>

            </li>
        <li class="loan">
                 <ul id='menu'  style="padding-left:0px; padding-right:30px; font-size:20px">
    <li class="loan"><a  href='#' title='Menu' style="font-size:20px">Tools</a>
      <ul class='menus'>
       
        <li class="loan"><a href="http://lsbankingportal.com/ls_software/admin/calculator/payday_loan.php"  style="color:white;">Calculator</a></li>
        <li class="loan"><a href="http://lsbankingportal.com/ls_software/admin/view_all_credit_reports.php"  style="color:white;">View All Credit Reports</a></li>
           
        
      </ul>
    </li>
  </ul>

            </li>
        
        
        <li class="demo-content loan">
                 <a href="view_all_notification.php">
                 <div class="demo-content">
		         <div id="notification-header">
			     <div>
			     <span id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count"><?php if($count>0) { echo $count; } ?></span><span class="glyphicon glyphicon-envelope" style="font-size:18px;color:white"></span>
				 </div>			
		         </div>
                 </div>
                 </a>
             </li>
        
   <li  style="color:white;"><a href="#"  style="color:white;"><span class="glyphicon glyphicon-user"  style="color:white;"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
            <li  style="color:white;"><a href="logout.php?logout"  style="color:white;"><span class="glyphicon glyphicon-log-out"  style="color:white;"></span>&nbsp; Logout</a></li>
           
           
            
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
          
          </ul>
        </div>
      </div>
    </nav>
    
    
    
   </html>
   </body>
    
    	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
	<script type="text/javascript">

	function myFunction() {
		$.ajax({
			url: "sms-chat/header-notification/view_notification.php",
			type: "POST",
			processData:false,
			success: function(data){
				$("#notification-count").remove();					
				$("#notification-latest").show();$("#notification-latest").html(data);
			},
			error: function(){}           
		});
	 }
	 
	 $(document).ready(function() {
		$('body').click(function(e){
			if ( e.target.id != 'notification-icon'){
				$("#notification-latest").hide();
			}
		});
	});
		 
	</script>