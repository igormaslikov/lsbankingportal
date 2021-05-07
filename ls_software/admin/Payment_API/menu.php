<?php 
date_default_timezone_set('America/Los_Angeles');
?>

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
  color:white;
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
</style>

<nav class="navbar navbar-default navbar-fixed-top" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home.php" style="color:white;">Home</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            
            <li>
  
  
                 <ul id='menu'>
    <li><a  href='#' title='Menu'>Fund A Card</a>
      <ul class='menus'>
        <li><a href="fund_card.php"  style="color:white;" title='Dropdown 1'>Fund Now</a>
        </li>
        <li class="portfolio"><a href="view_all_fund_cards.php"  style="color:white;">View All Fund Cards</a></li>
        <!--<li class="user"><a href="http://lsbankingportal.com/ls_software/admin/view_all_user.php"  style="color:white;">User</a></li>-->
        
      </ul>
    </li>
  </ul>

            </li>
            
             <li>
  
  
                 <ul id='menu'>
    <li><a  href='#' title='Menu'>Payment With Card</a>
      <ul class='menus'>
        <li><a href="pay_with_card.php"  style="color:white;" title='Dropdown 1'>Pay Now</a>
        </li>
        <li class="portfolio"><a href="view_all_payments.php"  style="color:white;">View All Payment</a></li>
        <!--<li class="user"><a href="http://lsbankingportal.com/ls_software/admin/view_all_user.php"  style="color:white;">User</a></li>-->
        
      </ul>
    </li>
  </ul>

            </li>
            
            
            
            
            <li>
  
  
                 <ul id='menu'>
    <li><a  href='#' title='Menu'>Scheduled A Payment</a>
      <ul class='menus'>
        <li><a href="scheduled_payment.php"  style="color:white;" title='Dropdown 1'>Scheduled Payment</a>
        </li>
        <li class="portfolio"><a href="view_schedule_payments.php"  style="color:white;">View Scheduled Payment</a></li>
        <!--<li class="user"><a href="http://lsbankingportal.com/ls_software/admin/view_all_user.php"  style="color:white;">User</a></li>-->
        
      </ul>
    </li>
  </ul>

            </li>
            
              
              
            
        <li>
  <!--               <ul id='menu'>-->
  <!--  <li><a  href='#' title='Menu'>Tools</a>-->
  <!--    <ul class='menus'>-->
       
  <!--      <li class="user"><a href="http://lsbankingportal.com/ls_software/admin/calculator/payday_loan.php"  style="color:white;">Calculator</a></li>-->
  <!--      <li class="user"><a href="http://lsbankingportal.com/ls_software/admin/view_all_credit_reports.php"  style="color:white;">View All Credit Reports</a></li>-->
           
        
  <!--    </ul>-->
  <!--  </li>-->
  <!--</ul>-->

            </li>
        
        
        
        
 
           
           
            
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li  style="color:white;"><a href="#"  style="color:white;"><span class="glyphicon glyphicon-user"  style="color:white;"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
            <li  style="color:white;"><a href="logout.php?logout"  style="color:white;"><span class="glyphicon glyphicon-log-out"  style="color:white;"></span>&nbsp; Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>