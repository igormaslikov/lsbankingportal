<nav class="navbar navbar-default navbar-fixed-top"  style="background-image: linear-gradient(to bottom,blue 0,blue 100%);">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="user_home.php" style="color:white;">Home</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class=""><a href="view_profile.php" style="color:white;">Profile</a></li>
             <li class=""><a href="apply_for_new_loan.php" style="color:white;">Apply For New Loan</a></li>
              <li class=""><a href="view_all_loan_app.php" style="color:white;">View All Loan Applications</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li style="color:white;"><a href="#" style="color:white;"><span class="glyphicon glyphicon-user" style="color:white;"></span>&nbsp; <?php echo $userRow['first_name']; ?></a></li>
            <li style="color:white;"><a href="user_logout.php?logout" style="color:white;"><span class="glyphicon glyphicon-log-out" style="color:white;"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>