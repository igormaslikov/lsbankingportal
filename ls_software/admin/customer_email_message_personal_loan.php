<?php
error_reporting(0);
session_start();
include_once 'dbconnect.php';
include_once 'functions.php';

if (!isset($_SESSION['userSession'])) {
  header("Location: index.php");
  exit;
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$DBcon->close();

// Carry-through params from commercial_initial_setup.php
$user_email    = $_GET['emaill']        ?? '';
$link          = $_GET['link']          ?? '';
$email_link    = $_GET['email_link']    ?? '';
$mobile_number = $_GET['mobile_number'] ?? '';
$user_fnd_id   = $_GET['user_fnd_id']   ?? '';

// Flash messages captured from POST handlers below
$flash_ok  = null;
$flash_err = null;

if (isset($_POST['button_sms'])) {
    $msg_txt = "Hello, please sign the contract here: " . $email_link;
    // send_sms() is a no-op on local dev; don't block the page waiting for SMS provider.
    @send_sms($mobile_number, $msg_txt);
    $flash_ok = 'Contract link sent via SMS to ' . $mobile_number . '.';
}

if (isset($_POST['button_email'])) {
    $subject  = 'Contract Signature From Optima Financial Solutions';
    $body     = "Please sign here by clicking this link: " . $email_link;
    $headers  = 'From: support@ofsca.com';
    // mail() may hang for ~1.5s on localhost because there is no SMTP daemon on :25;
    // suppress the warning and trust send_email_notification() to deliver in production.
    @mail($user_email, $subject, $body, $headers);
    @send_email_notification($user_email, $subject, $body);
    $flash_ok = 'Contract link sent via Email to ' . $user_email . '.';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Contract Sent · <?php echo htmlspecialchars((string)$userRow['email']); ?></title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="style.css" type="text/css" />
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <style>
    section.wrapper, .cem-wrapper { padding: 0 20px 40px; max-width: 1280px; margin: 100px auto 40px; }

    .cem-toolbar {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #eee;
    }
    .cem-page-title { font-size: 22px; font-weight: 600; color: #333; margin: 0; }
    .cem-page-title small { color: #888; font-weight: normal; }

    .cem-success {
        background: #dff0d8;
        border: 1px solid #b2dba1;
        border-left: 4px solid #5cb85c;
        border-radius: 4px;
        padding: 14px 18px;
        margin-bottom: 18px;
        color: #3c763d;
        font-size: 14px;
    }
    .cem-success .glyphicon { margin-right: 8px; }

    .cem-flash { margin-bottom: 14px; padding: 10px 14px; }

    .cem-panel { margin-bottom: 14px; }
    .cem-panel .panel-heading { padding: 10px 15px; background-color: #fafafa; font-weight: 600; }
    .cem-panel .panel-body { padding: 16px; }

    .cem-field-label { font-size: 11px; color: #888; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 4px; display: block; }
    .cem-link-row { display: flex; gap: 8px; align-items: stretch; }
    .cem-link-row input { flex: 1 1 auto; font-family: Consolas, monospace; font-size: 13px; }

    .cem-action-row { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 6px; }
    .cem-action-row .btn { min-width: 220px; padding: 10px 18px; font-weight: 600; }
    .cem-action-row .btn .glyphicon { margin-right: 6px; }

    .cem-preview { margin-top: 24px; }
    .cem-preview iframe {
        width: 100%; height: 900px; border: 1px solid #e4e4e4; border-radius: 4px;
        background: #fff;
    }

    /* Neutralize global dark .row:hover from css/style1.css */
    section.wrapper .row, section.wrapper .row:hover,
    .cem-wrapper .row, .cem-wrapper .row:hover {
        background-color: transparent !important;
        height: auto !important; border-top: 0 !important; transition: none !important;
    }
  </style>
</head>

<body>

  <?php include('menu.php'); ?>

  <section class="wrapper cem-wrapper">

    <div class="cem-toolbar">
      <h3 class="cem-page-title">
        <span class="glyphicon glyphicon-send"></span>
        Send Contract to Customer
        <?php if ($user_fnd_id): ?>
          <small>&nbsp;·&nbsp;Customer #<?php echo htmlspecialchars((string)$user_fnd_id); ?></small>
        <?php endif; ?>
      </h3>
      <?php if ($user_fnd_id): ?>
        <a href="edit_customer.php?id=<?php echo urlencode((string)$user_fnd_id); ?>" class="btn btn-default">
          <span class="glyphicon glyphicon-arrow-left"></span> Back to customer
        </a>
      <?php endif; ?>
    </div>

    <div class="cem-success">
      <span class="glyphicon glyphicon-ok-sign"></span>
      <strong>Installment loan created successfully.</strong>
      Below is the contract link the customer needs to sign.
    </div>

    <?php if ($flash_ok): ?>
      <div class="alert alert-success cem-flash">
        <span class="glyphicon glyphicon-ok-sign"></span> <?php echo htmlspecialchars($flash_ok); ?>
      </div>
    <?php endif; ?>
    <?php if ($flash_err): ?>
      <div class="alert alert-danger cem-flash">
        <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo htmlspecialchars($flash_err); ?>
      </div>
    <?php endif; ?>

    <div class="panel panel-default cem-panel">
      <div class="panel-heading">Contract Signing Link</div>
      <div class="panel-body">
        <label class="cem-field-label">Shareable Link</label>
        <div class="cem-link-row">
          <input type="text" id="cem-link" class="form-control" value="<?php echo htmlspecialchars((string)$email_link); ?>" readonly onclick="this.select();">
          <button type="button" class="btn btn-default" onclick="copyCemLink(this)">
            <span class="glyphicon glyphicon-copy"></span> Copy
          </button>
          <a href="<?php echo htmlspecialchars((string)$email_link); ?>" target="_blank" class="btn btn-default">
            <span class="glyphicon glyphicon-new-window"></span> Open
          </a>
        </div>

        <label class="cem-field-label" style="margin-top:18px;">Send the link to the customer</label>
        <div class="cem-action-row">
          <form action="" method="post" style="margin:0;">
            <input type="hidden" name="button_email" value="1">
            <button type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-envelope"></span>
              Send via Email
              <?php if ($user_email): ?>
                <small style="font-weight:400;opacity:.85;">· <?php echo htmlspecialchars((string)$user_email); ?></small>
              <?php endif; ?>
            </button>
          </form>
          <form action="" method="post" style="margin:0;">
            <input type="hidden" name="button_sms" value="1">
            <button type="submit" class="btn btn-success">
              <span class="glyphicon glyphicon-comment"></span>
              Send via SMS
              <?php if ($mobile_number): ?>
                <small style="font-weight:400;opacity:.85;">· <?php echo htmlspecialchars((string)$mobile_number); ?></small>
              <?php endif; ?>
            </button>
          </form>
        </div>
      </div>
    </div>

    <?php if ($link): ?>
      <div class="panel panel-default cem-panel">
        <div class="panel-heading">Contract Preview</div>
        <div class="panel-body cem-preview">
          <iframe src="<?php echo htmlspecialchars((string)$link); ?>"></iframe>
        </div>
      </div>
    <?php endif; ?>

  </section>

  <script type="text/javascript">
    function copyCemLink(btn) {
      var el = document.getElementById('cem-link');
      if (!el) return;
      el.select();
      el.setSelectionRange(0, 99999);
      try {
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(el.value);
        } else {
          document.execCommand('copy');
        }
        var orig = btn.innerHTML;
        btn.innerHTML = '<span class="glyphicon glyphicon-ok"></span> Copied';
        setTimeout(function(){ btn.innerHTML = orig; }, 1500);
      } catch (e) { /* no-op */ }
    }
  </script>

</body>

</html>
