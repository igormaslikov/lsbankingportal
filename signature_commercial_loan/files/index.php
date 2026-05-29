<?php
error_reporting(0);
session_start();
include 'dbconnect.php';
include 'dbconfig.php';

$iddd = $_GET['id'] ?? '';

// Upload-signature fallback handler (POST path)
$upload_error = null;
if (isset($_POST['btnupload']) && isset($_FILES['imagee'])) {
    $imgFile = $_FILES['imagee']['name']     ?? '';
    $tmp_dir = $_FILES['imagee']['tmp_name'] ?? '';
    $imgSize = (int)($_FILES['imagee']['size'] ?? 0);

    $upload_dir = 'doc_signs/';
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
    $valid_extensions = ['jpeg', 'jpg', 'png', 'gif'];
    $userpic = rand(1000, 1000000) . "." . $imgExt;

    if (!in_array($imgExt, $valid_extensions, true)) {
        $upload_error = "Only JPG, JPEG, PNG and GIF files are allowed.";
    } elseif ($imgSize >= 5_000_000) {
        $upload_error = "File is too large (5 MB max).";
    } elseif ($tmp_dir && move_uploaded_file($tmp_dir, $upload_dir . $userpic)) {
        $iddd_esc = $con->real_escape_string((string)$iddd);
        $userpic_esc = $con->real_escape_string($userpic);
        // NOTE: original code targeted `loan_initial_banking`; real table is
        // `commercial_loan_initial_banking` per the signer page.
        $con->query("UPDATE commercial_loan_initial_banking SET sign_status='1', signed_pic='$userpic_esc' WHERE email_key='$iddd_esc'");
        header('Location: finish.php?id=' . urlencode((string)$iddd));
        exit;
    } else {
        $upload_error = "Could not save the upload. Please try again.";
    }
}

// Pull customer context for the summary card
$sig_base_url = (function () {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $idx = strpos($script, '/signature_commercial_loan/');
    $path = ($idx !== false) ? substr($script, 0, $idx) : '';
    return $scheme . '://' . $host . $path . '/';
})();

$customer_name = '';
$amount_of_loan = '';
$contract_date  = '';
$signed_already = false;
if ($iddd !== '') {
    $r = $con->query("select user_fnd_id, loan_id, sign_status, creation_date from commercial_loan_initial_banking where email_key = ?", [$iddd]);
    if ($r && ($row1 = $r->fetch_assoc())) {
        if ((int)$row1['sign_status'] > 0) { $signed_already = true; }
        $contract_date = $row1['creation_date'];
        $fnd_id = $row1['user_fnd_id'];
        $loan_id_bor = $row1['loan_id'];
        $fnd_id_esc = $con->real_escape_string((string)$fnd_id);
        $q = $con->query("select first_name, last_name from fnd_user_profile where user_fnd_id = '$fnd_id_esc'");
        if ($q && ($p = $q->fetch_assoc())) {
            $customer_name = trim(($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? ''));
        }
        $loan_id_esc = $con->real_escape_string((string)$loan_id_bor);
        $q = $con->query("select amount_of_loan from tbl_commercial_loan where loan_create_id = '$loan_id_esc'");
        if ($q && ($l = $q->fetch_assoc())) {
            $amount_of_loan = $l['amount_of_loan'];
        }
    }
}

$contract_iframe_url = 'contract_pdf.php?id=' . urlencode((string)$iddd);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign your contract · Optima Financial Solutions</title>

    <link href="css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="./css/jquery.signaturepad.css" rel="stylesheet">

    <style>
        body { background:#f7f8fa; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; color:#333; }
        input, textarea, select, button { font-size: 16px; }

        .sig-wrapper { max-width: 980px; margin: 20px auto 40px; padding: 0 14px; }

        .sig-hero { background:#fff; border-radius:10px; padding:20px 22px; margin-bottom:16px; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .sig-hero h1 { margin:0 0 6px; font-size:22px; color:#1976d2; font-weight:700; }
        .sig-hero p  { margin:0; color:#555; font-size:14px; line-height:1.5; }
        .sig-hero .meta { margin-top:10px; padding-top:10px; border-top:1px solid #f0f0f0; display:flex; flex-wrap:wrap; gap:10px 22px; font-size:13px; color:#666; }
        .sig-hero .meta b { color:#333; font-weight:600; }

        .sig-preview-card { background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.04); margin-bottom:16px; }
        .sig-preview-card .head { padding:12px 18px; font-weight:600; color:#333; border-bottom:1px solid #eee; display:flex; align-items:center; justify-content:space-between; font-size:14px; }
        .sig-preview-card .head a { font-size:12px; color:#1976d2; }
        .sig-preview-card iframe { width:100%; height:70vh; min-height:420px; border:0; background:#fff; }

        .sig-panel { background:#fff; border-radius:10px; margin-bottom:14px; box-shadow:0 2px 8px rgba(0,0,0,0.04); overflow:hidden; }
        .sig-panel .head { padding:12px 18px; font-weight:600; color:#333; border-bottom:1px solid #eee; display:flex; align-items:center; justify-content:space-between; font-size:14px; }
        .sig-panel .head .hint { font-size:11px; color:#888; font-weight:normal; }
        .sig-panel .body { padding:16px 18px; text-align:center; }

        .sig-box { width:100%; max-width:520px; margin:0 auto; }
        .sig-box canvas {
            display:block; width:100%; height:160px; background:#fff;
            border:2px dashed #cbd5e0; border-radius:8px; touch-action:none; cursor:crosshair;
        }
        .sig-hint-line { margin-top:6px; font-size:11px; color:#888; text-align:center; text-transform:uppercase; letter-spacing:.4px; }

        .btn-clear { background:#fff; color:#d9534f; border:1px solid #d9534f; padding:6px 16px;
            border-radius:6px; font-size:13px; font-weight:600; margin-top:10px; cursor:pointer; }
        .btn-clear:hover { background:#d9534f; color:#fff; }

        .btn-save { background:#1976d2; background-image:linear-gradient(to bottom,#2196f3,#1976d2); color:#fff;
            border:0; padding:14px 26px; border-radius:8px; font-size:16px; font-weight:700; cursor:pointer;
            min-width:240px; box-shadow:0 4px 10px rgba(25,118,210,.22); }
        .btn-save:hover { box-shadow:0 6px 14px rgba(25,118,210,.3); }
        .btn-save[disabled] { background:#b0bec5; cursor:wait; box-shadow:none; }

        .or-divider { display:flex; align-items:center; gap:12px; margin:18px 0 12px; color:#999; font-size:12px; letter-spacing:.6px; font-weight:600; text-transform:uppercase; }
        .or-divider::before, .or-divider::after { content:""; flex:1; height:1px; background:#e4e4e4; }

        .upload-group { display:flex; gap:10px; flex-wrap:wrap; justify-content:center; align-items:center; margin-top:6px; }
        .upload-group input[type=file] { flex:1 1 260px; max-width:340px; padding:8px; border:1px solid #ddd; border-radius:6px; background:#fff; }
        .btn-upload { background:#5cb85c; color:#fff; border:0; padding:10px 20px; border-radius:6px; font-weight:600; cursor:pointer; font-size:14px; }
        .btn-upload:hover { background:#449d44; }
        .upload-hint { font-size:12px; color:#666; margin-top:10px; }
        .upload-error { background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:10px 14px; border-radius:6px; font-size:13px; margin-top:10px; }

        .sig-overlay { position:fixed; inset:0; background:rgba(255,255,255,0.85); display:none; align-items:center; justify-content:center; z-index:2000; font-size:16px; color:#333; }
        .sig-overlay.on { display:flex; }
        .sig-overlay .spinner { width:48px; height:48px; border:4px solid #e0e0e0; border-top-color:#1976d2; border-radius:50%; animation:sig-spin 1s linear infinite; margin-right:14px; }
        @keyframes sig-spin { to { transform:rotate(360deg); } }

        .card-status { max-width:560px; margin:60px auto; background:#fff; border-radius:10px; padding:32px; text-align:center; box-shadow:0 4px 16px rgba(0,0,0,.06); }
        .card-status .ring { width:80px; height:80px; border-radius:50%; background:#dff0d8; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
        .card-status .ring i { font-size:42px; color:#5cb85c; }

        @media (max-width: 640px) {
            .sig-wrapper { padding:0 10px; margin-top:10px; }
            .sig-hero { padding:16px; }
            .sig-hero h1 { font-size:19px; }
            .sig-hero p  { font-size:13px; }
            .sig-panel .body { padding:12px; }
            .sig-box canvas { height:140px; }
            .btn-save { width:100%; }
            .sig-preview-card iframe { height:60vh; min-height:320px; }
            .upload-group input[type=file] { max-width:100%; }
        }
    </style>
</head>
<body>

<?php if ($signed_already): ?>
    <div class="card-status">
        <div class="ring"><i class="fa fa-check"></i></div>
        <h2>Contract Already Signed</h2>
        <p style="color:#666;">Thank you. If you need a copy, please contact <a href="mailto:support@ofsca.com">support@ofsca.com</a>.</p>
    </div>
<?php else: ?>

<div class="sig-wrapper">

    <div class="sig-hero">
        <h1><i class="fa fa-pencil-square-o"></i> Sign Your Loan Contract</h1>
        <p>Review the contract below, then either draw your signature or upload an image of it.</p>
        <?php if ($customer_name || $amount_of_loan): ?>
            <div class="meta">
                <?php if ($customer_name): ?><span>Borrower: <b><?php echo htmlspecialchars($customer_name); ?></b></span><?php endif; ?>
                <?php if ($amount_of_loan): ?><span>Loan Amount: <b>$<?php echo htmlspecialchars((string)$amount_of_loan); ?></b></span><?php endif; ?>
                <?php if ($contract_date): ?><span>Contract Date: <b><?php echo htmlspecialchars(date('M j, Y', strtotime((string)$contract_date))); ?></b></span><?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="sig-preview-card">
        <div class="head">
            <span><i class="fa fa-file-pdf-o"></i> Contract Preview</span>
            <a href="<?php echo htmlspecialchars($contract_iframe_url); ?>" target="_blank"><i class="fa fa-external-link"></i> Open in new tab</a>
        </div>
        <iframe src="<?php echo htmlspecialchars($contract_iframe_url); ?>" title="Contract preview"></iframe>
    </div>

    <div class="sig-panel">
        <div class="head">
            <span><i class="fa fa-pencil"></i> Your Signature</span>
            <span class="hint">Use your finger or mouse</span>
        </div>
        <div class="body">
            <div id="signArea" class="sig-box">
                <div class="sig sigWrapper" style="height:auto;">
                    <div class="typed"></div>
                    <canvas class="sign-pad" id="sign-pad" width="520" height="160"></canvas>
                </div>
                <div class="sig-hint-line">Draw your full signature</div>
            </div>
            <button type="button" id="btnClearSign" class="btn-clear" onclick="clearSig()">
                <i class="fa fa-times"></i> Clear
            </button>
            <br>
            <button type="button" id="btnSaveSign" class="btn-save" style="margin-top:14px;">
                <i class="fa fa-check-circle"></i> Save My Signature
            </button>
            <p id="txtInfo" style="color:#d9534f;margin-top:10px;font-size:13px;min-height:18px;"></p>

            <div class="or-divider">OR upload a photo</div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="upload-group">
                    <input type="file" name="imagee" accept="image/*" required>
                    <button type="submit" name="btnupload" class="btn-upload">
                        <i class="fa fa-upload"></i> Upload Signature
                    </button>
                </div>
                <p class="upload-hint">JPG, JPEG, PNG or GIF up to 5 MB.</p>
                <?php if ($upload_error): ?>
                    <div class="upload-error"><i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($upload_error); ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<div class="sig-overlay" id="sigOverlay">
    <div class="spinner"></div>
    <div>Saving your signature…</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="./js/numeric-1.2.6.min.js"></script>
<script src="./js/bezier.js"></script>
<script src="./js/jquery.signaturepad.js"></script>
<script src="./js/json2.min.js"></script>

<script>
    var signArea = null;
    $(document).ready(function() {
        signArea = $('#signArea').signaturePad({
            drawOnly: true, drawBezierCurves: true, lineTop: 150
        });
    });

    function clearSig() {
        if (signArea) signArea.clearCanvas();
        $('#txtInfo').text('');
    }

    function isCanvasEmpty(dataUrl) {
        var stripped = dataUrl.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
        return stripped.length < 2800;
    }

    $("#btnSaveSign").click(function() {
        var $btn = $(this);
        var $info = $('#txtInfo');
        $info.text('');

        var canvas = document.getElementById('sign-pad');
        if (!canvas) { $info.text('Signature canvas is not ready. Please reload the page.'); return; }

        var img_full;
        try { img_full = canvas.toDataURL('image/png'); }
        catch (e) { $info.text('Could not capture the signature: ' + e.message); return; }

        if (isCanvasEmpty(img_full)) {
            $info.text('Please draw your signature before saving.');
            return;
        }

        var img_data = img_full.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
        var key = '<?php echo htmlspecialchars($iddd, ENT_QUOTES); ?>';

        $btn.prop('disabled', true);
        $('#sigOverlay').addClass('on');

        $.ajax({
            url: 'save_sign.php',
            data: { img_data: img_data, key: key },
            type: 'post',
            dataType: 'json',
            success: function() {
                window.location.href = 'finish.php?id=' + encodeURIComponent(key);
            },
            error: function(res) {
                $btn.prop('disabled', false);
                $('#sigOverlay').removeClass('on');
                $info.text('Sorry, something went wrong saving your signature. Please try again.');
                console.log(res);
            }
        });
    });
</script>

<?php endif; ?>

</body>
</html>
