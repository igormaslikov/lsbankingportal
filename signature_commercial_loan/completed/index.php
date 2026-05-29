<?php
error_reporting(0);
session_start();
$_SESSION['Optima'] = "true";
include 'dbconnect.php';
include 'dbconfig.php';

/**
 * Resolve the site base URL at runtime so we produce working URLs both on
 * production (https://ofsca.com/loanportal/...) and on local dev
 * (http://localhost:8080/...).
 */
function sig_base_url() {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $idx = strpos($script, '/signature_commercial_loan/');
    $path = ($idx !== false) ? substr($script, 0, $idx) : '';
    return $scheme . '://' . $host . $path . '/';
}
$url_logo = sig_base_url() . 'signature_commercial_loan/completed';

$iddd = $_GET['id'] ?? '';
$__debug = !empty($_GET['debug']);
if ($__debug) {
    header('Content-Type: application/json; charset=utf-8');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $r1 = $con->query("select * from commercial_loan_initial_banking where email_key = ?", [$iddd]);
    $row1d = $r1 ? $r1->fetch_assoc() : null;

    $row2d = null;
    if ($row1d && !empty($row1d['loan_id'])) {
        $loan_id_esc = $con->real_escape_string((string)$row1d['loan_id']);
        $r2 = $con->query("select * from tbl_commercial_loan where loan_create_id = '$loan_id_esc'");
        $row2d = $r2 ? $r2->fetch_assoc() : null;
    }

    $row3d = null;
    if ($row1d && !empty($row1d['user_fnd_id'])) {
        $fnd_esc = $con->real_escape_string((string)$row1d['user_fnd_id']);
        $r3 = $con->query("select * from fnd_user_profile where user_fnd_id = '$fnd_esc'");
        $row3d = $r3 ? $r3->fetch_assoc() : null;
    }

    echo json_encode([
        'email_key' => $iddd,
        'commercial_loan_initial_banking' => [
            'found' => (bool)$row1d,
            'columns' => $row1d ? array_keys($row1d) : [],
            'row' => $row1d,
        ],
        'tbl_commercial_loan' => [
            'loan_id_searched' => $row1d['loan_id'] ?? null,
            'found' => (bool)$row2d,
            'columns' => $row2d ? array_keys($row2d) : [],
            'row' => $row2d,
        ],
        'fnd_user_profile' => [
            'user_fnd_id_searched' => $row1d['user_fnd_id'] ?? null,
            'found' => (bool)$row3d,
            'columns' => $row3d ? array_keys($row3d) : [],
            'row' => $row3d,
        ],
        'sqlsrv_errors' => function_exists('sqlsrv_errors') ? sqlsrv_errors() : null,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// Parameterized query — email_key comes from an untrusted URL parameter.
$signed_status = null;
$row1 = null;
if ($iddd !== '') {
    $result = $con->query("select * from commercial_loan_initial_banking where email_key = ?", [$iddd]);
    if ($result && ($row1 = $result->fetch_assoc())) {
        $mail_key        = $row1['email_key'];
        $signed_status   = $row1['sign_status'];
        $creation_date   = $row1['creation_date'];
        $fnd_id          = $row1['user_fnd_id'];
        $loan_id_bor     = $row1['loan_id'];
        $type_of_card    = $row1['type_of_card'];
        $card_number     = $row1['card_number'];
        $card_exp_date   = $row1['card_exp_date'];
        $bank_name       = $row1['bank_name'];
        $routing_number  = $row1['routing_number'];
        $account_number  = $row1['account_number'];
        $cvv_number      = $row1['cvv_number'];
        $img_signed      = $row1['signed_pic'];
        $result_sig      = $url_logo . '/doc_signs/' . $img_signed;
    }
}

// ---------- Contract NOT found ----------
if (!$row1) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contract not found</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <style>
            body { background:#f7f8fa; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; padding:40px 16px; }
            .card-status { max-width:520px; margin:60px auto; background:#fff; border-radius:10px; padding:28px; text-align:center; box-shadow:0 4px 16px rgba(0,0,0,.06); }
            .card-status .glyphicon { font-size:56px; color:#d9534f; margin-bottom:10px; }
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="card-status">
            <i class="fa fa-exclamation-triangle" style="font-size:56px;color:#d9534f;"></i>
            <h2 style="margin-top:16px;">Contract not found</h2>
            <p style="color:#666;">The link you used is invalid or has expired. Please request a new link from Optima Financial Solutions.</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ---------- Contract already signed ----------
if ((int)$signed_status > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contract signed</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body { background:#f7f8fa; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; padding:40px 16px; }
            .card-status { max-width:560px; margin:60px auto; background:#fff; border-radius:10px; padding:32px; text-align:center; box-shadow:0 4px 16px rgba(0,0,0,.06); }
            .card-status .success-ring { width:80px; height:80px; border-radius:50%; background:#dff0d8; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
            .card-status .success-ring i { font-size:42px; color:#5cb85c; }
            .card-status h2 { margin:0 0 8px; color:#333; }
            .card-status .sub { color:#666; margin-bottom: 18px; }
        </style>
    </head>
    <body>
        <div class="card-status">
            <div class="success-ring"><i class="fa fa-check"></i></div>
            <h2>Contract Already Signed</h2>
            <p class="sub">Thank you — your contract has been received. If you need a copy, please contact Optima Financial Solutions at <a href="mailto:support@ofsca.com">support@ofsca.com</a>.</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ---------- Fetch the loan + customer for display context ----------
$loan_id_bor_esc = $con->real_escape_string((string)$loan_id_bor);
$sql_loan = $con->query("select * from tbl_commercial_loan where loan_create_id = '$loan_id_bor_esc'");
$amount_of_loan = '';
$payment_date = '';
$payoff = '';
if ($sql_loan && ($row_loan = $sql_loan->fetch_array())) {
    $amount_of_loan = $row_loan['amount_of_loan'];
    $payment_date   = $row_loan['payment_date'];
    $payoff         = $row_loan['loan_total_payable'];
}

$fnd_id_esc = $con->real_escape_string((string)$fnd_id);
$sql2 = $con->query("select * from fnd_user_profile where user_fnd_id = '$fnd_id_esc'");
$f_name = $l_name = $address = $city = $state = $zip = $mobile_number = '';
$has_co_borrow = false;
if ($sql2 && ($row2 = $sql2->fetch_array())) {
    $f_name        = $row2['first_name'];
    $l_name        = $row2['last_name'];
    $address       = $row2['address'];
    $city          = $row2['city'];
    $state         = $row2['state'];
    $zip           = $row2['zip_code'];
    $mobile_number = $row2['mobile_number'];
    $has_co_borrow = !empty(trim((string)($row2['co_borrow_full_name'] ?? '')));
}

// Preview the actual contract PDF directly — pointing at files/index.php would
// embed a whole second signing page (its own canvas + Save button + upload form)
// inside the iframe, which was the duplicated-UI "mess" visible in the page.
$url_contract_preview = '../files/contract_pdf.php?id=' . urlencode((string)$mail_key);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign your contract · Optima Financial Solutions</title>

    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/bootstrap-select.css" rel="stylesheet" />
    <link href="css/app_style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* ==== Reset + base ==== */
        body {
            background: #f7f8fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #333;
        }
        /* iOS auto-zoom mitigation — any text input >= 16px font */
        input, textarea, select, button { font-size: 16px; }

        .sig-wrapper { max-width: 980px; margin: 16px auto 40px; padding: 0 14px; }
        body { background: #eef3f8; }

        .sig-hero {
            background: #fff; border-radius: 10px; padding: 20px 22px; margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .sig-hero h1 { margin: 0 0 6px; font-size: 22px; color: #1976d2; font-weight: 700; }
        .sig-hero p { margin: 0; color: #555; font-size: 14px; line-height: 1.5; }
        .sig-hero .sig-meta { margin-top: 10px; padding-top: 10px; border-top: 1px solid #f0f0f0;
            display: flex; flex-wrap: wrap; gap: 12px 24px; font-size: 13px; color: #666; }
        .sig-hero .sig-meta b { color: #333; font-weight: 600; }

        /* Contract preview */
        .sig-preview-card {
            background: #fff; border-radius: 10px; overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 16px;
        }
        .sig-preview-card .sig-preview-head {
            padding: 12px 18px; font-weight: 600; color: #333; border-bottom: 1px solid #eee;
            display: flex; align-items: center; justify-content: space-between; font-size: 14px;
        }
        .sig-preview-card .sig-preview-head a { font-size: 12px; color: #1976d2; }
        .sig-preview-card iframe { width: 100%; height: 70vh; min-height: 400px; border: 0; background: #fff; }

        /* Signature panel */
        .sig-panel {
            background: #fff; border-radius: 10px; margin-bottom: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: hidden;
        }
        .sig-panel-head {
            padding: 12px 18px; font-weight: 600; color: #333; border-bottom: 1px solid #eee;
            display: flex; align-items: center; justify-content: space-between; font-size: 14px;
        }
        .sig-panel-head .sig-hint { font-size: 11px; color: #888; font-weight: normal; }
        .sig-panel-body { padding: 14px 18px; text-align: center; }

        /* Signature / initial canvases — responsive + touch-friendly */
        .sig-box { width: 100%; max-width: 520px; margin: 0 auto; }
        .sig-box canvas {
            display: block; width: 100%; height: 160px;
            background: #fff; border: 2px dashed #cbd5e0; border-radius: 8px;
            touch-action: none; cursor: crosshair;
        }
        .sig-box canvas:focus, .sig-box canvas:active { border-color: #1976d2; outline: none; }
        .sig-hint-line {
            margin-top: 4px; font-size: 11px; color: #888; text-align: center;
            text-transform: uppercase; letter-spacing: .4px;
        }
        .sig-actions {
            display: inline-flex; flex-wrap: wrap; gap: 8px; justify-content: center;
            margin-top: 10px;
        }
        .btn-clear, .btn-upload-sig {
            padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;
            border: 1px solid; cursor: pointer;
        }
        .btn-clear { background: #fff; color: #d9534f; border-color: #d9534f; }
        .btn-clear:hover { background: #d9534f; color: #fff; }
        .btn-upload-sig { background: #fff; color: #1976d2; border-color: #1976d2; }
        .btn-upload-sig:hover { background: #1976d2; color: #fff; }
        .btn-clear .fa, .btn-upload-sig .fa { margin-right: 4px; }

        /* Submit button — full width on mobile, huge on desktop */
        .sig-submit-wrap {
            background: #fff; border-radius: 10px; padding: 18px; text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-top: 10px;
        }
        .sig-submit-wrap .consent {
            font-size: 12px; color: #666; margin-bottom: 14px; line-height: 1.5;
            max-width: 640px; margin-left: auto; margin-right: auto;
        }
        .btn-sign-save {
            background: #1976d2; background-image: linear-gradient(to bottom, #2196f3, #1976d2);
            color: #fff; border: 0; padding: 16px 28px; border-radius: 8px;
            font-size: 17px; font-weight: 700; cursor: pointer;
            min-width: 260px; max-width: 100%;
            transition: transform .08s ease, box-shadow .12s ease;
            box-shadow: 0 4px 10px rgba(25,118,210,.25);
        }
        .btn-sign-save:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(25,118,210,.3); }
        .btn-sign-save:active { transform: translateY(0); }
        .btn-sign-save[disabled] { background: #b0bec5; cursor: wait; box-shadow: none; }

        /* Overlay during save */
        .sig-overlay {
            position: fixed; inset: 0; background: rgba(255,255,255,0.85);
            display: none; align-items: center; justify-content: center; z-index: 2000;
            font-size: 16px; color: #333;
        }
        .sig-overlay.on { display: flex; }
        .sig-overlay .spinner { width: 48px; height: 48px; border: 4px solid #e0e0e0;
            border-top-color: #1976d2; border-radius: 50%; animation: sig-spin 1s linear infinite;
            margin-right: 14px; }
        @keyframes sig-spin { to { transform: rotate(360deg); } }

        /* Mobile polish */
        @media (max-width: 640px) {
            .sig-wrapper { padding: 0 10px; margin-top: 10px; }
            .sig-hero { padding: 16px 16px; border-radius: 8px; }
            .sig-hero h1 { font-size: 19px; }
            .sig-hero p { font-size: 13px; }
            .sig-panel-body { padding: 12px; }
            .sig-box canvas { height: 140px; }
            .btn-sign-save { width: 100%; font-size: 16px; padding: 14px; }
            .sig-preview-card iframe { height: 60vh; min-height: 320px; }
        }
    </style>
</head>

<body>
    <div class="all-content-wrapper">
        <?php if (file_exists(__DIR__ . '/include/header.php')) { require_once __DIR__ . '/include/header.php'; } ?>

        <div class="sig-wrapper">

            <!-- Hero / instructions -->
            <div class="sig-hero">
                <h1><i class="fa fa-file-signature"></i> Sign Your Loan Contract</h1>
                <p>Please review your contract below, then sign and initial to complete. After you press <b>Save My Signature</b> you'll receive a copy of the signed contract.</p>
                <?php if ($f_name || $amount_of_loan): ?>
                <div class="sig-meta">
                    <?php if ($f_name): ?><span>Borrower: <b><?php echo htmlspecialchars(trim((string)$f_name . ' ' . (string)$l_name)); ?></b></span><?php endif; ?>
                    <?php if ($amount_of_loan): ?><span>Loan Amount: <b>$<?php echo htmlspecialchars((string)$amount_of_loan); ?></b></span><?php endif; ?>
                    <?php if ($creation_date): ?><span>Contract Date: <b><?php echo htmlspecialchars(date('M j, Y', strtotime((string)$creation_date))); ?></b></span><?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Contract preview -->
            <div class="sig-preview-card">
                <div class="sig-preview-head">
                    <span><i class="fa fa-file-pdf-o"></i> Contract Preview</span>
                    <a href="<?php echo htmlspecialchars($url_contract_preview); ?>" target="_blank"><i class="fa fa-external-link"></i> Open in new tab</a>
                </div>
                <iframe src="<?php echo htmlspecialchars($url_contract_preview); ?>" title="Contract preview"></iframe>
            </div>

            <!-- Signature -->
            <div class="sig-panel">
                <div class="sig-panel-head">
                    <span><i class="fa fa-pencil"></i> Your Signature</span>
                    <span class="sig-hint">Sign with your finger or mouse</span>
                </div>
                <div class="sig-panel-body">
                    <div id="signArea" class="sig-box">
                        <div class="sig sigWrapper" style="height:auto;">
                            <div class="typed"></div>
                            <canvas class="sign-pad" id="sign-pad" width="520" height="160"></canvas>
                        </div>
                        <div class="sig-hint-line">Draw your full signature</div>
                    </div>
                    <div class="sig-actions">
                        <button type="button" id="btnClearSign" class="btn-clear" onclick="clearCanvasFunc('sign-pad')">
                            <i class="fa fa-times"></i> Clear
                        </button>
                        <button type="button" class="btn-upload-sig" onclick="document.getElementById('upload-sign').click()">
                            <i class="fa fa-upload"></i> Upload Photo
                        </button>
                        <input type="file" id="upload-sign" accept="image/*" style="display:none"
                               onchange="loadImageToCanvas(this, 'sign-pad')">
                    </div>
                </div>
            </div>

            <!-- Initials -->
            <div class="sig-panel">
                <div class="sig-panel-head">
                    <span><i class="fa fa-pencil-square-o"></i> Your Initials</span>
                    <span class="sig-hint">First + last name initials</span>
                </div>
                <div class="sig-panel-body">
                    <div id="initialArea" class="sig-box">
                        <div class="sig sigWrapper" style="height:auto;">
                            <div class="typed"></div>
                            <canvas class="initial-pad" id="initial-pad" width="520" height="160"></canvas>
                        </div>
                        <div class="sig-hint-line">Draw your initials</div>
                    </div>
                    <div class="sig-actions">
                        <button type="button" id="btnClearInitial" class="btn-clear" onclick="clearCanvasFunc('initial-pad')">
                            <i class="fa fa-times"></i> Clear
                        </button>
                        <button type="button" class="btn-upload-sig" onclick="document.getElementById('upload-initial').click()">
                            <i class="fa fa-upload"></i> Upload Photo
                        </button>
                        <input type="file" id="upload-initial" accept="image/*" style="display:none"
                               onchange="loadImageToCanvas(this, 'initial-pad')">
                    </div>
                </div>
            </div>

            <!-- Co-borrower (hidden unless customer has one on file) -->
            <div class="sig-panel" id="coBorrowPanel" <?php echo $has_co_borrow ? '' : 'style="display:none"'; ?>>
                <div class="sig-panel-head">
                    <span><i class="fa fa-users"></i> Co-Borrower Signature</span>
                    <span class="sig-hint">If applicable</span>
                </div>
                <div class="sig-panel-body">
                    <div style="display:none">
                        <label for="coBorrowName">Name:</label>
                        <input type="text" id="coBorrowName">
                        <label for="coBorrowCellPhone">Mobile:</label>
                        <input type="number" id="coBorrowCellPhone">
                    </div>
                    <div id="signAreaCoBorrow" class="sig-box">
                        <div class="sig sigWrapper" style="height:auto;">
                            <div class="typed"></div>
                            <canvas class="sign-pad-coborrow" id="sign-pad-coborrow" width="520" height="160"></canvas>
                        </div>
                        <div class="sig-hint-line">Co-borrower signs here</div>
                    </div>
                    <div class="sig-actions">
                        <button type="button" id="btnClearCoBorrow" class="btn-clear" onclick="clearCanvasFunc('sign-pad-coborrow')">
                            <i class="fa fa-times"></i> Clear
                        </button>
                        <button type="button" class="btn-upload-sig" onclick="document.getElementById('upload-coborrow').click()">
                            <i class="fa fa-upload"></i> Upload Photo
                        </button>
                        <input type="file" id="upload-coborrow" accept="image/*" style="display:none"
                               onchange="loadImageToCanvas(this, 'sign-pad-coborrow')">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="sig-submit-wrap">
                <p class="consent">
                    By pressing <b>Save My Signature</b>, I confirm that I have read, understood, and agree to the terms of the contract shown above.
                </p>
                <button type="button" id="btnSaveSignInitial" class="btn-sign-save">
                    <i class="fa fa-check-circle"></i> Save My Signature
                </button>
                <p id="txtInfo" style="color:#d9534f;margin-top:14px;font-size:13px;"></p>
            </div>

        </div> <!-- /sig-wrapper -->

        <!-- Loading overlay -->
        <div class="sig-overlay" id="sigOverlay">
            <div class="spinner"></div>
            <div>Saving your signature…</div>
        </div>
    </div>

    <!-- jQuery + signaturepad + deps -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link href="./css/jquery.signaturepad.css" rel="stylesheet">
    <script src="./js/numeric-1.2.6.min.js"></script>
    <script src="./js/bezier.js"></script>
    <script src="./js/jquery.signaturepad.js"></script>
    <script src="./js/json2.min.js"></script>

    <script>
        var signArea = null;
        var initialArea = null;
        var signAreaCoBorrow = null;
        var hasCoBorrow = <?php echo $has_co_borrow ? 'true' : 'false'; ?>;

        $(document).ready(function() {
            signArea = $('#signArea').signaturePad({
                drawOnly: true, drawBezierCurves: true, lineTop: 150
            });
            initialArea = $('#initialArea').signaturePad({
                defaultAction: 'drawIt', drawOnly: true, drawBezierCurves: true, lineTop: 150
            });
            if (hasCoBorrow) {
                signAreaCoBorrow = $('#signAreaCoBorrow').signaturePad({
                    drawOnly: true, drawBezierCurves: true, lineTop: 150
                });
            }
        });

        function clearCanvasFunc(elemId) {
            switch (elemId) {
                case 'sign-pad':           if (signArea)          signArea.clearCanvas();          break;
                case 'initial-pad':        if (initialArea)       initialArea.clearCanvas();       break;
                case 'sign-pad-coborrow':  if (signAreaCoBorrow)  signAreaCoBorrow.clearCanvas();  break;
            }
        }

        /**
         * Load an uploaded image file onto the target signature canvas.
         * The existing save flow (html2canvas + AJAX) reads pixels from the canvas,
         * so once we've drawn the image onto it, no backend change is required.
         */
        function loadImageToCanvas(fileInput, canvasId) {
            var file = fileInput.files && fileInput.files[0];
            if (!file) return;
            if (!/^image\//.test(file.type)) {
                alert('Please choose an image file (JPG, PNG, or GIF).');
                fileInput.value = '';
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('File is too large. Maximum 5 MB.');
                fileInput.value = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function(ev) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.getElementById(canvasId);
                    if (!canvas) return;
                    var ctx = canvas.getContext('2d');
                    // First, blank the canvas so any previously drawn strokes are removed
                    ctx.fillStyle = '#fff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    // Fit the image inside the canvas preserving aspect ratio
                    var scale = Math.min(canvas.width / img.width, canvas.height / img.height) * 0.9;
                    var w = img.width * scale;
                    var h = img.height * scale;
                    var x = (canvas.width  - w) / 2;
                    var y = (canvas.height - h) / 2;
                    ctx.drawImage(img, x, y, w, h);
                };
                img.onerror = function() {
                    alert('Could not read that image. Please try a different file.');
                };
                img.src = ev.target.result;
            };
            reader.onerror = function() { alert('Could not read the file.'); };
            reader.readAsDataURL(file);
            // Allow the same file to be re-selected later
            fileInput.value = '';
        }

        // Canvas "empty" detection: a canvas with nothing drawn should still be a mostly
        // blank white image. We look at the base64 length — an empty 520x160 canvas
        // PNG is around 1700 bytes; a canvas with a drawn signature is much longer.
        function isCanvasEmpty(dataUrl) {
            // Quick sanity: strip prefix, compare to a rough threshold
            var stripped = dataUrl.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
            return stripped.length < 2800; // empirically safe threshold for 520x160
        }

        $("#btnSaveSignInitial").click(function(e) {
            var $btn = $(this);
            var $info = $('#txtInfo');
            $info.text('');

            var sig_data = getDataFromCanvasById('sign-pad');
            var initial_data = getDataFromCanvasById('initial-pad');
            var sig_data_co_borrow = hasCoBorrow ? getDataFromCanvasById('sign-pad-coborrow') : '';

            if (isCanvasEmpty(sig_data)) {
                $info.text('Please add your signature before saving.');
                return;
            }
            if (isCanvasEmpty(initial_data)) {
                $info.text('Please add your initials before saving.');
                return;
            }
            if (hasCoBorrow && isCanvasEmpty(sig_data_co_borrow)) {
                $info.text('Please add the co-borrower signature before saving.');
                return;
            }

            // Strip data: prefix before sending (save_sign.php expects bare base64)
            sig_data            = sig_data.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
            initial_data        = initial_data.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
            sig_data_co_borrow  = sig_data_co_borrow.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");

            var co_borrow_name   = "";
            var co_borrow_mobile = "";
            var key = '<?php echo htmlspecialchars($iddd, ENT_QUOTES); ?>';

            $btn.prop('disabled', true);
            $('#sigOverlay').addClass('on');

            $.ajax({
                url: 'save_sign.php',
                data: {
                    sig_data: sig_data,
                    initial_data: initial_data,
                    sig_data_co_borrow: sig_data_co_borrow,
                    co_borrow_name: co_borrow_name,
                    co_borrow_mobile: co_borrow_mobile,
                    key: key
                },
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    window.location.href = "../files/contract_pdf.php?id=" + encodeURIComponent(key);
                },
                error: function(res) {
                    $btn.prop('disabled', false);
                    $('#sigOverlay').removeClass('on');
                    $info.text('Sorry, something went wrong saving your signature. Please try again.');
                    console.log(res);
                }
            });
        });

        function getDataFromCanvasById(elemId) {
            // Read the canvas's raw pixel data directly. We used to run the element
            // through html2canvas(), which re-renders the element's CSS — including
            // the dashed UI border around the signature box — and baked that border
            // into the saved PNG. toDataURL captures only the drawing surface.
            var el = document.getElementById(elemId);
            if (!el || !el.toDataURL) return '';
            try {
                return el.toDataURL('image/png');
            } catch (e) {
                return '';
            }
        }
    </script>

</body>
</html>
