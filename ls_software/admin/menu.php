<?php
date_default_timezone_set('America/Los_Angeles');
//include_once($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
$conn = new mysqli("213.136.93.169", "ofsca_message_chat_user", "~o-G%35i20-d", "ki902621_ofsca_message_chat");
$count = 0;
$sql2 = "SELECT * FROM webchat_lines WHERE notification_status = 0";
$result = mysqli_query($conn, $sql2);
$count = mysqli_num_rows($result);
if (!isset($_SESSION['Optima'])) {

  $_SESSION['Optima'] = True;
}

?>

<?php
function getMyUrl($added_to_link)
{
  $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) ? 'https://' : 'http://';
  $server = $_SERVER['SERVER_NAME'] + $added_to_link;
  $port = $_SERVER['SERVER_PORT'] ? ':' . $_SERVER['SERVER_PORT'] : '';
  return $protocol . $server . $port;
}
// $url_origin = getMyUrl("/lsbankingportal");
$url_origin = getMyUrl("/loanportal");
?>

<html>

<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">




  <style>
    #menu {
      background: #1E90FF;
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
      padding-left: 10px;
    }

    #menu li:first-child {
      border-left: none
    }

    #menu a {
      display: block;
      line-height: 51px;
      font-size: 14px;
      text-decoration: none;
      color: #ffffff;
    }

    #menu li:hover>a,
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


    #notification-count {
      left: 0px;
      top: 0px;
      font-size: 16px;
      color: red;
      padding: 5px;
      border-radius: 11px;

      font-weight: bold;
    }

    .top-menu {
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 14px;
      line-height: 1.42857143;
      color: #margin-left:;
      background-color: #fff
    }

    .loan {
      padding-right: 0.2%;
    }
  </style>
</head>
<br><br><br><br>
<nav class="navbar navbar-default navbar-fixed-top top-menu">
  <div class="container" style="background-color:white;width:100%;height:60px">
    <img src='../website/images/Optima_Logo.jpg' style="height:100%" align="left" />
  </div>


  <div class="container" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%); font-weight:600 ;font-size:20px;width:100%">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></margin-left: <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php" style="color:white;margin-top: -8px;"><img src='imgs/pie-chart.png' height='35px' ; width='35px' /></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse" style="float:right; width:95%; position:relative">
      <ul class="nav navbar-nav nav1" style="width:80%">

        <li class="loan">
          <a href="view_all_customer_main.php?status=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=" style="color:white; font-size:20px">Applications</a>
        </li>
        <!-- <li class="loan">
           <ul id='menu' style="padding-left:0px">
                <li class="loan"><a href="view_all_commercial_loans.php"  style="color:white;font-size:20px">Commercial Loan</a>
            
             <ul class='menus'>
        <li><a href="#"  style="color:white;" title=''>Upcoming Payments</a></li>
        <li><a href="#"  style="color:white;" title=''>Past Due Payments</a></li>
        <li><a href="#"  style="color:white;" title=''>Recently Paid Payments</a></li>
        </ul>
            
            </li></ul></li> -->


        <li class="loan">
          <ul id='menu' style="padding-left:0px">
            <li class="loan">
              <a href="view_all_payday_loans.php" style="color:white;font-size:20px">Payday Loan</a>
              <ul class='menus'>
                <li><a href="view_all_payday_loans_upcoming.php" style="color:white;" title=''>Upcoming Due Loans</a></li>
                <li><a href="view_all_payday_loans_pastdue.php" style="color:white;" title=''>Past Due Loans</a></li>
                <li><a href="view_all_payday_loans_recently_paid.php" style="color:white;" title=''>Recently Paid Loans</a></li>
                <li><a href="view_payday_schedules.php" style="color:white;" title=''>Scheduled Payments</a></li>
                <li><a href="payday_payments.php" style="color:white;" title=''>Payments</a></li>
              </ul>
            </li>
          </ul>
        </li>


        <!-- <li class="loan">
           <ul id='menu' style="padding-left:0px">
            <li class="loan"><a href="view_all_personal_loans.php"  style="color:white;font-size:20px">Personal Loan</a>
            
             <ul class='menus'>
        <li><a href="#"  style="color:white;" title=''>Upcoming Due Loans</a></li>
        <li><a href="#"  style="color:white;" title=''>Past Due Loans</a></li>
        <li><a href="#"  style="color:white;" title=''>Recently Paid Loans</a></li>
        <li><a href="#"  style="color:white;" title=''>Payments</a></li>
        </ul>
            
            </li></ul>
            </li>
            <li class="loan"><a href="view_all_title_loans.php"  style="color:white;">Title Loan</a></li> -->
        <li class="loan"><a href="#" style="color:white;">Reports</a></li>
        <!--<li class="loan"><a href="<?php echo $url_origin; ?>/ls_software/admin/marketing.php"  style="color:white;">Marketing</a></li>-->




        <li class="loan">
          <ul id='menu' style="padding-left:0px; font-size:16px">
            <li class="loan"><a href='#' title='' style="font-size:20px">Settings</a>
              <ul class='menus'>
                <li><a href="sms_settings.php" style="color:white;" title=''>SMS Settings</a>
                </li>
                <li><a href="loan_status_sms_settings.php" style="color:white;" title=''>Loan Status SMS Settings</a>
                </li>
                <li><a href="schedule_sms.php" style="color:white;" title=''>Schedule SMS</a>
                </li>
                <li><a href="schedule_mms.php" style="color:white;" title=''>Schedule MMS</a>
                </li>
                <li><a href="daily_sms_with_loan_status.php" style="color:white;" title=''>Daily SMS Settings</a>
                </li>
                <li class="portfolio"><a href="view_all_companies.php" style="color:white;">Portfolios</a></li>
                <li class="user"><a href="view_all_user.php" style="color:white;">User</a></li>
                <li class="user"><a href="view_all_roles.php" style="color:white;">User Role</a></li>
                <li class="user"><a href="view_all_form.php" style="color:white;">Form Setup</a></li>
                <li class="user"><a href="view_all_activity_log.php" style="color:white;">Activity Log</a></li>
              </ul>
            </li>
          </ul>

        </li>



        <li>
          <ul id='menu' style="padding-left:7px; padding-right:60px; font-size:20px">
            <li class="loan"><a href='#' title='Menu' style="font-size:20px">Tools</a>
              <ul class='menus'>

                <li class="loan"><a href="calculator/payday_loan.php" style="color:white;">Calculator</a></li>
                <li class="loan"><a href="view_all_credit_reports.php" style="color:white;">View All Credit Reports</a></li>


              </ul>
            </li>
          </ul>

        </li>
        
        <li class="loan">
            <div style="color:white; font-size:20px; line-height: 51px;">
                <input type="checkbox" id="optima" name="optima" onchange="setOptima(this)" value="Optima" <?php echo $_SESSION['Optima'] == "true" ? 'checked' : ''; ?> >
                <label for="optima" > Optima</label>
            </div>

        </li>

        <?php

        include_once 'dbconnect.php';
        include_once 'dbconfig.php';
        include_once 'functions.php';

        $sql_mc = "SELECT * FROM `tbl_conversation` WHERE `incoming_read` = 0 ";

        if ($result_mc = mysqli_query($con, $sql_mc)) {
          $rowcount_mc = mysqli_num_rows($result_mc);

          if ($rowcount_mc > 0) {
            $rowcount_mc = '<span style="background-color:red; padding:5px">' . $rowcount_mc . '</span>';
          } else {
            $rowcount_mc = "";
          }

          mysqli_free_result($result);
        }


        ?>






      </ul>
      <ul class="nav navbar-nav navbar-right" style="width:20%">

        <li style="color:white;"><a href="view_all_conversation_messages.php" style="color:white;"><span class="glyphicon glyphicon-envelope" style="color:white;"> <?php echo $rowcount_mc; ?></span>
            &nbsp; <span class="glyphicon glyphicon-user" style="color:white;"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
        <li style="color:white;"><a href="logout.php?logout" style="color:white;"><span class="glyphicon glyphicon-log-out" title="Logout" style="color:white;"></span></a></li>
      </ul>
    </div>
  </div>
</nav>




</html>
</body>

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
  function setOptima(elem){
    var url = 'loan-commercial/functions_commercial_loan.php';
         // projectName = "SPVL"
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
          'func': "SetOpima",
          'optima': elem.checked
        },
        async: true,
        success: function(data) {
          //var tableCard = data[0].cardTable;
          window.location.reload();

        },
        error: function(err) {
          if (err.responseText == "") {
              alert(err.responseText);
          } else {
              alert(err.responseText);
          }
          window.location.reload();
        }
    });
  }
</script>