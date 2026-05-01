<?php
date_default_timezone_set('America/Los_Angeles');

if (!isset($_SESSION['Optima'])) {
  $_SESSION['Optima'] = True;
}
?>

<!-- Site-wide jQuery loader.
     menu.php is included at the top of every admin page, so loading jQuery here
     makes `$` available to all downstream inline scripts (edit_customer.php etc.).
     Kept even though this file no longer uses jQuery itself. -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<style>
  /* ==================================================================
     Top navigation — scoped as .topnav-* so it doesn't collide with
     Bootstrap's own .navbar styling used elsewhere.
     ================================================================== */
  .topnav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
    background: #1976d2;
    background-image: linear-gradient(to bottom, #2196f3 0%, #1976d2 100%);
    color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 14px;
    height: 56px;
  }
  .topnav * { box-sizing: border-box; }
  .topnav-inner {
    display: flex; align-items: center;
    max-width: 100%;
    padding: 0 16px;
    height: 56px;
  }
  .topnav-brand {
    display: flex; align-items: center;
    padding: 6px 18px 6px 0;
    margin-right: 8px;
    border-right: 1px solid rgba(255,255,255,0.18);
  }
  .topnav-brand img { height: 40px; width: auto; display: block; }

  .topnav-menu { display: flex; align-items: center; list-style: none; margin: 0; padding: 0; height: 56px; }
  .topnav-menu > li { position: relative; height: 56px; display: flex; align-items: stretch; }
  .topnav-menu > li > a, .topnav-menu > li > button {
    display: flex; align-items: center; height: 56px; padding: 0 14px;
    color: #fff; text-decoration: none; font-size: 14px;
    border: 0; background: transparent; cursor: pointer;
    white-space: nowrap;
    transition: background-color .12s ease;
  }
  .topnav-menu > li > a:hover, .topnav-menu > li > button:hover,
  .topnav-menu > li.open > a, .topnav-menu > li.open > button {
    background-color: rgba(0,0,0,0.15);
    text-decoration: none; color: #fff;
  }
  .topnav-menu .glyphicon { margin-right: 7px; font-size: 13px; opacity: .9; }
  .topnav-menu .caret { margin-left: 6px; border-top-color: #fff; }

  .topnav-spacer { flex: 1 1 auto; }

  /* Dropdown menus */
  .topnav-dd {
    position: absolute; top: 56px; left: 0;
    min-width: 220px;
    background: #fff;
    color: #333;
    list-style: none; margin: 0; padding: 6px 0;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    border-radius: 0 0 4px 4px;
    display: none;
  }
  .topnav-menu > li.open .topnav-dd { display: block; }
  .topnav-dd li a {
    display: block; padding: 8px 16px; color: #333; text-decoration: none;
    font-size: 13px;
  }
  .topnav-dd li a:hover { background: #eef5fd; color: #1976d2; text-decoration: none; }
  .topnav-dd .divider { height: 1px; background: #eee; margin: 6px 0; }

  /* Optima toggle pill */
  .topnav-optima {
    display: flex; align-items: center;
    padding: 0 12px; margin: 0 6px;
    background: rgba(0,0,0,0.15); border-radius: 18px;
    height: 32px;
    cursor: pointer; user-select: none;
  }
  .topnav-optima input { position: absolute; opacity: 0; pointer-events: none; }
  .topnav-optima .dot {
    display: inline-block; width: 14px; height: 14px; border-radius: 50%;
    background: rgba(255,255,255,0.4); margin-right: 8px;
    transition: background-color .15s ease;
  }
  .topnav-optima input:checked + .dot { background: #8bc34a; box-shadow: 0 0 0 2px rgba(139,195,74,0.25); }
  .topnav-optima span.label-txt { color: #fff; font-size: 13px; font-weight: 500; }
  .topnav-optima:hover { background: rgba(0,0,0,0.22); }

  /* Right-side user block */
  .topnav-right { display: flex; align-items: center; height: 56px; }
  .topnav-right > a {
    display: flex; align-items: center; height: 56px; padding: 0 12px;
    color: #fff; text-decoration: none; font-size: 13px;
  }
  .topnav-right > a:hover { background-color: rgba(0,0,0,0.15); color: #fff; text-decoration: none; }
  .topnav-right .msg-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 18px; height: 18px; padding: 0 6px;
    background: #e53935; color: #fff; border-radius: 9px;
    font-size: 11px; font-weight: 600; margin-left: 4px;
  }
  .topnav-right .glyphicon { font-size: 16px; }
  .topnav-right .username { margin: 0 4px 0 10px; font-weight: 500; }

  /* Body gets padded so content isn't hidden under the fixed navbar */
  body { padding-top: 56px; }

  /* Mobile: hamburger + stacked menu */
  .topnav-toggle { display: none; background: transparent; border: 0; color: #fff; padding: 0 12px; height: 56px; font-size: 20px; }
  @media (max-width: 991px) {
    .topnav-toggle { display: flex; align-items: center; }
    .topnav-menu, .topnav-right {
      display: none; position: absolute; top: 56px; left: 0; right: 0;
      background: #1976d2; height: auto; flex-direction: column; align-items: stretch;
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .topnav-menu.open, .topnav-right.open { display: flex; }
    .topnav-menu > li, .topnav-right > a { height: auto; width: 100%; }
    .topnav-menu > li > a, .topnav-menu > li > button, .topnav-right > a { height: 44px; width: 100%; justify-content: flex-start; }
    .topnav-dd { position: static; background: rgba(0,0,0,0.2); box-shadow: none; }
    .topnav-dd li a { color: #fff; }
    .topnav-dd li a:hover { background: rgba(0,0,0,0.2); color: #fff; }
  }
</style>

<nav class="topnav">
  <div class="topnav-inner">
    <a class="topnav-brand" href="home.php" title="Dashboard">
      <img src="../website/images/Optima_Logo.jpg" alt="Optima">
    </a>

    <button type="button" class="topnav-toggle" aria-label="Toggle menu"
            onclick="document.querySelectorAll('.topnav-menu,.topnav-right').forEach(function(el){el.classList.toggle('open')})">
      <span class="glyphicon glyphicon-menu-hamburger"></span>
    </button>

    <ul class="topnav-menu">
      <li>
        <a href="view_all_customer_main.php?status=All&amp;state=All&amp;loan_type=All&amp;keyword=&amp;from_date=&amp;to_date=&amp;search=">
          <span class="glyphicon glyphicon-folder-open"></span> Applications
        </a>
      </li>

      <li class="has-dd">
        <button type="button" class="topnav-dd-trigger">
          <span class="glyphicon glyphicon-briefcase"></span> Commercial Loan <span class="caret"></span>
        </button>
        <ul class="topnav-dd">
          <li><a href="view_all_commercial_loans.php">All Commercial Loans</a></li>
          <li class="divider"></li>
          <li><a href="#">Upcoming Payments</a></li>
          <li><a href="#">Past Due Payments</a></li>
          <li><a href="#">Recently Paid Payments</a></li>
        </ul>
      </li>

      <li class="has-dd">
        <button type="button" class="topnav-dd-trigger">
          <span class="glyphicon glyphicon-credit-card"></span> Payday Loan <span class="caret"></span>
        </button>
        <ul class="topnav-dd">
          <li><a href="view_all_payday_loans.php">All Payday Loans</a></li>
          <li class="divider"></li>
          <li><a href="view_all_payday_loans_upcoming.php">Upcoming Due Loans</a></li>
          <li><a href="view_all_payday_loans_pastdue.php">Past Due Loans</a></li>
          <li><a href="view_all_payday_loans_recently_paid.php">Recently Paid Loans</a></li>
          <li><a href="view_payday_schedules.php">Scheduled Payments</a></li>
          <li><a href="payday_payments.php">Payments</a></li>
        </ul>
      </li>

      <li>
        <a href="#"><span class="glyphicon glyphicon-stats"></span> Reports</a>
      </li>

      <li class="has-dd">
        <button type="button" class="topnav-dd-trigger">
          <span class="glyphicon glyphicon-cog"></span> Settings <span class="caret"></span>
        </button>
        <ul class="topnav-dd">
          <li><a href="sms_settings.php">SMS Settings</a></li>
          <li><a href="loan_status_sms_settings.php">Loan Status SMS Settings</a></li>
          <li><a href="schedule_sms.php">Schedule SMS</a></li>
          <li><a href="schedule_mms.php">Schedule MMS</a></li>
          <li><a href="daily_sms_with_loan_status.php">Daily SMS Settings</a></li>
          <li class="divider"></li>
          <li><a href="view_all_companies.php">Portfolios</a></li>
          <li><a href="view_all_user.php">Users</a></li>
          <li><a href="view_all_roles.php">User Roles</a></li>
          <li><a href="view_all_form.php">Form Setup</a></li>
          <li><a href="view_all_activity_log.php">Activity Log</a></li>
        </ul>
      </li>

      <li class="has-dd">
        <button type="button" class="topnav-dd-trigger">
          <span class="glyphicon glyphicon-wrench"></span> Tools <span class="caret"></span>
        </button>
        <ul class="topnav-dd">
          <li><a href="calculator/payday_loan.php">Calculator</a></li>
          <li><a href="view_all_credit_reports.php">View All Credit Reports</a></li>
        </ul>
      </li>

      <li>
        <label class="topnav-optima" title="Toggle Optima database mode">
          <input type="checkbox" id="optima" name="optima" onchange="setOptima(this)"
                 value="Optima" <?php echo ($_SESSION['Optima'] == "true" || $_SESSION['Optima'] === true) ? 'checked' : ''; ?>>
          <span class="dot"></span><span class="label-txt">Optima</span>
        </label>
      </li>
    </ul>

    <div class="topnav-spacer"></div>

    <?php
    include_once 'dbconnect.php';
    include_once 'dbconfig.php';
    include_once 'functions.php';
    $rowcount_mc_int = 0;
    if (isset($con) && $con) {
      $sql_mc = "SELECT COUNT(*) AS n FROM `tbl_conversation` WHERE `incoming_read` = 0";
      if ($result_mc = mysqli_query($con, $sql_mc)) {
        if ($r = mysqli_fetch_assoc($result_mc)) {
          $rowcount_mc_int = (int)$r['n'];
        }
        mysqli_free_result($result_mc);
      }
    }
    // Legacy variable kept because some other files reference it
    $rowcount_mc = $rowcount_mc_int > 0 ? '<span style="background-color:red; padding:5px">' . $rowcount_mc_int . '</span>' : '';
    ?>

    <div class="topnav-right">
      <a href="view_all_conversation_messages.php" title="Messages">
        <span class="glyphicon glyphicon-envelope"></span>
        <?php if ($rowcount_mc_int > 0): ?>
          <span class="msg-badge"><?php echo $rowcount_mc_int; ?></span>
        <?php endif; ?>
      </a>
      <a href="view_all_conversation_messages.php" title="Signed-in user">
        <span class="glyphicon glyphicon-user"></span>
        <span class="username"><?php echo htmlspecialchars((string)($userRow['username'] ?? '')); ?></span>
      </a>
      <a href="logout.php?logout" title="Log out">
        <span class="glyphicon glyphicon-log-out"></span>
      </a>
    </div>
  </div>
</nav>

<script>
  // Dropdown toggle — vanilla JS (no Bootstrap JS dependency).
  (function() {
    function closeAll(except) {
      document.querySelectorAll('.topnav-menu > li.has-dd.open').forEach(function(el){
        if (el !== except) el.classList.remove('open');
      });
    }
    document.querySelectorAll('.topnav-dd-trigger').forEach(function(btn){
      btn.addEventListener('click', function(e) {
        e.preventDefault(); e.stopPropagation();
        var parent = btn.closest('li.has-dd');
        var wasOpen = parent.classList.contains('open');
        closeAll(parent);
        if (!wasOpen) parent.classList.add('open');
      });
    });
    document.addEventListener('click', function(e){
      if (!e.target.closest('.topnav-menu > li.has-dd')) closeAll(null);
    });
    // Close on Escape
    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape') closeAll(null);
    });
  })();

  // Optima toggle — preserved behavior
  function setOptima(elem) {
    var url = 'loan-commercial/functions_commercial_loan.php';
    // Using XHR directly so we don't require jQuery to be loaded already
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.onload = function() { window.location.reload(); };
    xhr.onerror = function() { window.location.reload(); };
    xhr.send('func=SetOpima&optima=' + (elem.checked ? '1' : '0'));
  }
</script>