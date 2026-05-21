<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";

}
else {
$DBcon->close();

?>

<?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';

if (!function_exists('app_base_url')) {
    function app_base_url() {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        $idx = strpos($script, '/ls_software/');
        $path = ($idx !== false) ? substr($script, 0, $idx) : '';
        return $scheme . '://' . $host . $path . '/';
    }
}

$id = $_GET['id'];
$user_fnd_id = $loan_create_id = $contract_status = $contract_db = '';
$sql_fnd = $con->query("select * from tbl_commercial_loan where loan_id = '$id'");
while ($row_fnd = $sql_fnd->fetch_array()) {
    $user_fnd_id     = $row_fnd['user_fnd_id'];
    $loan_create_id  = $row_fnd['loan_create_id'];
    $contract_status = $row_fnd['contract_status'];
    $contract_db     = $row_fnd['contract'];
    $state           = $row_fnd['state'];
}

$first_name = $last_name = $customer_numbr = '';
$sql = $con->query("select * from fnd_user_profile where user_fnd_id = '$user_fnd_id'");
while ($row = $sql->fetch_array()) {
    $first_name     = $row['first_name'];
    $last_name      = $row['last_name'];
    $customer_numbr = $row['mobile_number'];
    $id_photo       = $row['id_photo'];
    $bank_front     = $row['bank_front'];
    $bank_back      = $row['bank_back'];
    $void_img       = $row['void_img'];
}

$val = '';
$amount_loan = '0.00';
$new_creation_date = '';
$sql = $con->query("select * from tbl_commercial_loan where user_fnd_id = '$user_fnd_id' AND loan_id = '$id'");
while ($row = $sql->fetch_array()) {
    $amount_loan = number_format((float)$row['principal_amount'], 2, '.', '');
    if ($amount_loan != '0') { $val = '$'; }
    $creation_date = $row['contract_date'];
    if ($creation_date) {
        $new_creation_date = date("m-d-Y", strtotime((string)$creation_date));
    }
    $created_by = $row['created_by'];
}

$mail_key = '';
$sql_mail_key = $con->query("select * from commercial_loan_initial_banking where loan_id = '$loan_create_id'");
while ($row_mail_key = $sql_mail_key->fetch_array()) {
    $mail_key = $row_mail_key['email_key'];
}

$address_contract = app_base_url() . 'signature_commercial_loan';

$doc_cards = [
    ['label' => 'Picture of ID', 'file' => $id_photo ?? '',   'folder' => 'photo_id',         'change_url' => 'change_id_pic.php',     'modal_id' => 'ui-img-modal-1'],
    ['label' => 'Bank Front',    'file' => $bank_front ?? '', 'folder' => 'bank_front_image', 'change_url' => 'change_bank_front.php', 'modal_id' => 'ui-img-modal-2'],
    ['label' => 'Bank Back',     'file' => $bank_back ?? '',  'folder' => 'bank_back_image',  'change_url' => 'change_bank_back.php',  'modal_id' => 'ui-img-modal-3'],
    ['label' => 'Void Image',    'file' => $void_img ?? '',   'folder' => 'void_img',         'change_url' => 'change_void_img.php',   'modal_id' => 'ui-img-modal-4'],
];

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

  <!-- Shared scoped styles for loan-commercial detail tabs -->
  <link href="css/ui-tabs.css" rel="stylesheet">

<style>
/* Document cards grid */
.ui-doc-grid {
    display: grid; gap: 12px;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
}
.ui-doc-card {
    background: #fff; border: 1px solid #e4e4e4; border-radius: 6px;
    overflow: hidden; display: flex; flex-direction: column;
}
.ui-doc-card .ui-doc-label {
    padding: 8px 12px; font-size: 11px; font-weight: 700;
    color: #888; text-transform: uppercase; letter-spacing: .4px;
    border-bottom: 1px solid #f0f0f0; background: #fafafa;
}
.ui-doc-card .ui-doc-body {
    padding: 12px; display: flex; flex-direction: column; align-items: center;
    gap: 8px; flex: 1; justify-content: center;
}
.ui-doc-card .ui-doc-img {
    width: 140px; height: 100px; object-fit: cover; border-radius: 4px;
    background: #f5f5f5; border: 1px solid #e4e4e4; cursor: pointer;
    transition: box-shadow .2s;
}
.ui-doc-card .ui-doc-img:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.ui-doc-card .ui-doc-missing {
    width: 140px; height: 100px; border-radius: 4px;
    background: #f5f5f5; border: 1px dashed #d0d7de;
    display: flex; align-items: center; justify-content: center;
    color: #aaa; font-size: 11px; text-align: center; padding: 8px;
}
.ui-doc-card .ui-doc-actions {
    padding: 8px 12px; border-top: 1px solid #f0f0f0;
    background: #fafafa; text-align: center;
}
.ui-doc-card .ui-doc-actions a {
    font-size: 12px; color: #1976d2; text-decoration: none;
    display: inline-block; padding: 3px 6px;
}
.ui-doc-card .ui-doc-actions a:hover { text-decoration: underline; }

/* Image lightbox overlay */
.ui-img-modal {
    display: none; position: fixed; z-index: 1050;
    top: 0; left: 0; width: 100%; height: 100%;
    padding-top: 60px; background: rgba(0,0,0,0.85);
    overflow: auto; text-align: center;
}
.ui-img-modal img {
    max-width: 90%; max-height: 85vh; margin: auto;
    display: block; background: #fff; border-radius: 4px;
}
.ui-img-modal .ui-img-close {
    position: absolute; top: 14px; right: 28px;
    color: #fff; font-size: 40px; font-weight: bold;
    cursor: pointer; user-select: none;
}
.ui-img-modal .ui-img-close:hover { color: #bbb; }
</style>
</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> </div>
      <div class="list-group list-group-flush">

        <?php include('vertical_menu.php'); ?>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <?php include('horizontal_menu.php'); ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>

      <!-- Page toolbar -->
      <div class="ui-toolbar">
        <h3 class="ui-page-title">
          <span class="glyphicon glyphicon-folder-open"></span>
          Documentation
          <small>&nbsp;·&nbsp;<?php echo htmlspecialchars((string)$loan_create_id); ?> · <?php echo htmlspecialchars(trim((string)$first_name . ' ' . (string)$last_name)); ?></small>
        </h3>
        <a href="loan_summary.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default">
          <span class="glyphicon glyphicon-arrow-left"></span> Back to loan
        </a>
      </div>

      <!-- Customer summary -->
      <div class="ui-summary">
        <div class="row">
          <div class="col-md-3"><p><strong>Name</strong><b><?php echo htmlspecialchars(trim((string)$first_name . ' ' . (string)$last_name)); ?></b></p></div>
          <div class="col-md-3"><p><strong>Phone</strong><b><?php echo htmlspecialchars((string)$customer_numbr); ?></b></p></div>
          <div class="col-md-2"><p><strong>Loan Date</strong><b><?php echo htmlspecialchars((string)$new_creation_date); ?></b></p></div>
          <div class="col-md-2"><p><strong>Loan Amount</strong><b><?php echo htmlspecialchars((string)($val . $amount_loan)); ?></b></p></div>
          <div class="col-md-2"><p><strong>Loan ID</strong><b><?php echo htmlspecialchars((string)$loan_create_id); ?></b></p></div>
        </div>
      </div>

      <!-- Customer documents panel -->
      <div class="ui-panel">
        <div class="ui-panel-head">
          Customer Documents
          <a href="lender_documents.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-plus"></span> Add New Document
          </a>
        </div>
        <div class="ui-panel-body">
          <div class="ui-doc-grid">
            <?php foreach ($doc_cards as $__card): ?>
              <div class="ui-doc-card">
                <div class="ui-doc-label"><?php echo htmlspecialchars($__card['label']); ?></div>
                <div class="ui-doc-body">
                  <?php if (!empty($__card['file'])): ?>
                    <img src="../../../ls_software/dl_client_files/<?php echo htmlspecialchars($__card['folder']); ?>/<?php echo htmlspecialchars($__card['file']); ?>"
                         class="ui-doc-img"
                         data-modal="<?php echo htmlspecialchars($__card['modal_id']); ?>"
                         alt="<?php echo htmlspecialchars($__card['label']); ?>">
                  <?php else: ?>
                    <div class="ui-doc-missing">No file uploaded</div>
                  <?php endif; ?>
                </div>
                <div class="ui-doc-actions">
                  <a href="<?php echo htmlspecialchars($__card['change_url']); ?>?id=<?php echo urlencode((string)$id); ?>">
                    <span class="glyphicon glyphicon-refresh"></span>
                    <?php echo !empty($__card['file']) ? 'Change / Update' : 'Upload'; ?>
                  </a>
                </div>
              </div>
            <?php endforeach; ?>

            <!-- Contract card -->
            <div class="ui-doc-card" style="grid-column: span 2;">
              <div class="ui-doc-label">Contract</div>
              <div class="ui-doc-body" style="flex-direction:column; align-items:stretch; padding:14px 16px; justify-content:flex-start; gap:6px;">
                <a href="<?php echo htmlspecialchars($address_contract); ?>/files/contract_pdf.php?t=<?php echo time(); ?>&amp;id=<?php echo urlencode((string)$mail_key); ?>"
                   target="_blank" class="btn btn-default btn-sm">
                  <span class="glyphicon glyphicon-file"></span> View Contract
                </a>
                <?php if ($contract_status == '1'): ?>
                  <a href="<?php echo htmlspecialchars(app_base_url() . 'ls_software/admin/loan-commercial/uploads_contract/' . $contract_db); ?>"
                     target="_blank" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-file"></span> View Echeck Contract
                  </a>
                <?php else: ?>
                  <a href="upload_contract.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-upload"></span> Upload Echeck Contract
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Lender documents panel -->
      <div class="ui-panel">
        <div class="ui-panel-head">
          Lender Documents
          <span class="ui-panel-hint">Uploaded files for this customer</span>
        </div>
        <div class="ui-panel-body" style="padding:0;">
          <table class="ui-table">
            <thead>
              <tr>
                <th style="width:140px;">Date</th>
                <th>File Name</th>
                <th style="width:200px;">Created By</th>
                <th style="width:180px; text-align:right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $__doc_rows = 0;
              $sql_doc = $con->query("select * from lender_documents where fnd_user_id = '$user_fnd_id' ORDER BY id desc");
              while ($row_doc = $sql_doc->fetch_array()) {
                  $__doc_rows++;
                  $doc_id           = $row_doc['id'];
                  $date_created     = $row_doc['date_created'];
                  $file_name        = $row_doc['file_name'];
                  $doc_created_by   = $row_doc['created_by'];
                  $description_name = $row_doc['description'];

                  $final_lender_by_user = '';
                  $sql_lbu = $con->query("select username from tbl_users where user_id = '$doc_created_by' limit 1");
                  if ($sql_lbu && ($r = $sql_lbu->fetch_assoc())) {
                      $final_lender_by_user = $r['username'];
                  }
                  ?>
                  <tr>
                    <td><?php echo htmlspecialchars((string)$date_created); ?></td>
                    <td><?php echo htmlspecialchars((string)$description_name); ?></td>
                    <td><?php echo htmlspecialchars((string)$final_lender_by_user); ?></td>
                    <td style="text-align:right; white-space:nowrap;">
                      <a href="../uploads_lender_documents/<?php echo rawurlencode((string)$file_name); ?>" target="_blank" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                      </a>
                      <a href="delete_lender_documents.php?id=<?php echo urlencode((string)$user_fnd_id); ?>&amp;doc_id=<?php echo urlencode((string)$doc_id); ?>&amp;loan_id=<?php echo urlencode((string)$id); ?>"
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Delete this document?');">
                        <span class="glyphicon glyphicon-trash"></span>
                      </a>
                    </td>
                  </tr>
                  <?php
              }
              if ($__doc_rows === 0) {
                  echo '<tr><td colspan="4" class="ui-empty-row">No lender documents uploaded yet.</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Image lightbox overlays (one per document card) -->
      <div id="ui-img-modal-1" class="ui-img-modal"><span class="ui-img-close">&times;</span><img alt=""></div>
      <div id="ui-img-modal-2" class="ui-img-modal"><span class="ui-img-close">&times;</span><img alt=""></div>
      <div id="ui-img-modal-3" class="ui-img-modal"><span class="ui-img-close">&times;</span><img alt=""></div>
      <div id="ui-img-modal-4" class="ui-img-modal"><span class="ui-img-close">&times;</span><img alt=""></div>

    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    // Image lightbox: any .ui-doc-img click opens its referenced modal with the same src.
    document.querySelectorAll('.ui-doc-img').forEach(function(img){
      img.addEventListener('click', function(){
        var modal = document.getElementById(this.dataset.modal);
        if (!modal) return;
        var m_img = modal.querySelector('img');
        m_img.src = this.src;
        m_img.alt = this.alt;
        modal.style.display = 'block';
      });
    });
    document.querySelectorAll('.ui-img-modal').forEach(function(modal){
      modal.addEventListener('click', function(e){
        if (e.target === modal || e.target.classList.contains('ui-img-close')) {
          modal.style.display = 'none';
        }
      });
    });
  </script>
<?php
}
?>
</body>

</html>
