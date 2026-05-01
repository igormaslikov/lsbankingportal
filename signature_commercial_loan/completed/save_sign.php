<?php
/**
 * Persist the customer's signature / initials / optional co-borrower-signature
 * images, then flag the loan as signed.
 *
 * Called via AJAX from completed/index.php and (legacy) files/index.php.
 *
 * Fixes applied:
 *   - Filenames now use uniqid() + random bytes so concurrent writes don't
 *     collide (previous bug: three calls to md5(date("dmYhisA")) within the
 *     same second produced the same hash, so all three files were written
 *     to the same path, each overwriting the last).
 *   - Skip the write entirely when the incoming base64 payload is empty —
 *     previously we wrote a zero-byte file with a .png extension, which
 *     later broke contract_pdf.php when imagecreatefrompng() ran on it.
 *   - Save operations use prepared statements.
 */

session_start();
$_SESSION['Optima'] = "true";
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

include 'dbconnect.php';
include 'dbconfig.php';

function unique_filename() {
    // 8 hex chars of random data is plenty to avoid collisions
    try {
        $rand = bin2hex(random_bytes(8));
    } catch (Exception $e) {
        $rand = bin2hex(openssl_random_pseudo_bytes(8));
    }
    return uniqid('', true) . '-' . $rand;
}

/**
 * Decode a base64 image payload and write it to disk under $dir.
 * Returns the basename that was written, or empty string if the payload was
 * empty / too small / invalid (so the caller can store "" in the DB).
 */
function save_signature_png($base64_payload, $dir) {
    $base64_payload = (string)$base64_payload;
    if ($base64_payload === '') return '';
    // Sometimes the caller includes the "data:image/png;base64," prefix; strip it.
    if (strpos($base64_payload, ',') !== false) {
        $base64_payload = substr($base64_payload, strpos($base64_payload, ',') + 1);
    }
    $bytes = base64_decode($base64_payload, true);
    // A real signature PNG is typically > 600 bytes even when the signature is
    // short. Anything below this is almost certainly the "empty canvas" case.
    if ($bytes === false || strlen($bytes) < 600) {
        return '';
    }
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    $filename = unique_filename() . '.png';
    $path = rtrim($dir, '/\\') . '/' . $filename;
    if (file_put_contents($path, $bytes) === false) {
        return '';
    }
    return $filename;
}

// Accept either field layout:
//   completed/index.php sends sig_data + initial_data + sig_data_co_borrow
//   files/index.php     sends img_data (maps to sig_data)
$sig_b64      = $_POST['sig_data']            ?? ($_POST['img_data'] ?? '');
$initial_b64  = $_POST['initial_data']        ?? '';
$coborrow_b64 = $_POST['sig_data_co_borrow']  ?? '';
$co_borrow_name   = $_POST['co_borrow_name']   ?? '';
$co_borrow_mobile = $_POST['co_borrow_mobile'] ?? '';
$key              = $_POST['key']              ?? '';

$filename_sig          = save_signature_png($sig_b64,      './doc_signs');
$filename_initial      = save_signature_png($initial_b64,  './doc_initials');
$filename_sig_coborrow = save_signature_png($coborrow_b64, './doc_signs_coborrow');

// Update the loan banking row. Use a prepared statement so the key
// can't be used for SQL injection.
if ($key !== '' && $stmt = mysqli_prepare($con, "UPDATE commercial_loan_initial_banking
    SET sign_status='1', signed_pic=?, initial_pic=?, sig_coborrow_pic=?, co_borrow_name=?, co_borrow_mobile=?
    WHERE email_key=?")) {
    mysqli_stmt_bind_param(
        $stmt, 'ssssss',
        $filename_sig, $filename_initial, $filename_sig_coborrow,
        $co_borrow_name, $co_borrow_mobile, $key
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Flag the loan itself as signed
    $loan_id = '';
    if ($stmt2 = mysqli_prepare($con, "SELECT loan_id FROM commercial_loan_initial_banking WHERE email_key=?")) {
        mysqli_stmt_bind_param($stmt2, 's', $key);
        mysqli_stmt_execute($stmt2);
        $res = mysqli_stmt_get_result($stmt2);
        if ($row = mysqli_fetch_assoc($res)) {
            $loan_id = $row['loan_id'];
        }
        mysqli_stmt_close($stmt2);
    }
    if ($loan_id !== '' && $stmt3 = mysqli_prepare($con, "UPDATE tbl_commercial_loan SET sign_status='1' WHERE loan_create_id=?")) {
        mysqli_stmt_bind_param($stmt3, 's', $loan_id);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);
    }
}

echo json_encode([[
    'status'               => 'OK',
    'signed_pic'           => $filename_sig,
    'initial_pic'          => $filename_initial,
    'sig_coborrow_pic'     => $filename_sig_coborrow,
]]);
