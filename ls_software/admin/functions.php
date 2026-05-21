<?php
date_default_timezone_set('America/Los_Angeles');
include 'dbconnect.php';
include 'dbconfig.php';

// Load Twilio credentials from config file (never hardcode)
$twilio_cfg_file = __DIR__ . '/../../twilio_config.php';
if (file_exists($twilio_cfg_file)) {
    include_once $twilio_cfg_file;
} else {
    // Fallback — define empty so functions degrade gracefully
    if (!defined('TWILIO_ACCOUNT_SID')) define('TWILIO_ACCOUNT_SID', '');
    if (!defined('TWILIO_AUTH_TOKEN'))  define('TWILIO_AUTH_TOKEN',  '');
    if (!defined('TWILIO_FROM_SINGLE')) define('TWILIO_FROM_SINGLE', '');
    if (!defined('TWILIO_FROM_BULK'))   define('TWILIO_FROM_BULK',   '');
}

if (!function_exists('send_email_notification')) {
function send_email_notification($to_email, $subject, $message) {
    $headers = 'From: support@mymoneyline.com';
    mail($to_email, $subject, $message, $headers);
}
}

if (!function_exists('admin_email_notification')) {
function admin_email_notification($admin_subject, $admin_message) {
    $admin_headers = 'From: support@mymoneyline.com';
    mail('support@mymoneyline.com', $admin_subject, $admin_message, $admin_headers);
}
}

if (!function_exists('admin_leads_email_notification')) {
function admin_leads_email_notification($admin_subject, $admin_message) {
    $admin_headers = 'From: support@mymoneyline.com';
    mail('leads@mymoneyline.com', $admin_subject, $admin_message, $admin_headers);
}
}

if (!function_exists('send_sms')) {
function send_sms($phone_number, $message) {
    $message = str_replace("nnll", '\n', $message);
    $sid   = TWILIO_ACCOUNT_SID;
    $token = TWILIO_AUTH_TOKEN;
    $from  = TWILIO_FROM_SINGLE;
    if (!$sid || !$token || !$from) { return; }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => http_build_query(['From' => $from, 'To' => $phone_number, 'Body' => $message]),
        CURLOPT_USERPWD        => "{$sid}:{$token}",
        CURLOPT_HTTPHEADER     => ['content-type: application/x-www-form-urlencoded'],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) { error_log("send_sms cURL error: " . $err); }
}
}

if (!function_exists('send_sms_bluk')) {
function send_sms_bluk($phone_number, $message) {
    $message = str_replace("nnll", '\n', $message);
    $sid   = TWILIO_ACCOUNT_SID;
    $token = TWILIO_AUTH_TOKEN;
    $from  = TWILIO_FROM_BULK;
    if (!$sid || !$token || !$from) { return; }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => http_build_query(['From' => $from, 'To' => $phone_number, 'Body' => $message]),
        CURLOPT_USERPWD        => "{$sid}:{$token}",
        CURLOPT_HTTPHEADER     => ['content-type: application/x-www-form-urlencoded'],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) { error_log("send_sms_bluk cURL error: " . $err); }
}
}

if (!function_exists('application_notes_add')) {
function application_notes_add($user_fnd_id, $app_notes, $creation_date, $created_by) {
    include 'dbconfig.php';
    $con->query(
        "INSERT INTO application_notes (user_fnd_id, app_notes, creation_date, created_by)
         VALUES (?, ?, ?, ?)",
        [$user_fnd_id, $app_notes, $creation_date, $created_by]
    );
}
}

if (!function_exists('application_notes_update')) {
function application_notes_update($application_id, $loan_create_id, $user_id, $status, $loan_transaction_id) {
    include 'dbconfig.php';
    $date = date('Y-m-d H:i:s');
    $con->query(
        "INSERT INTO application_status_updates
             (application_id, loan_create_id, user_id, status, loan_transaction_id, creation_date)
         VALUES (?, ?, ?, ?, ?, ?)",
        [$application_id, $loan_create_id, $user_id, $status, $loan_transaction_id, $date]
    );
}
}

if (!function_exists('user_roles')) {
function user_roles($user_role, $form_id) {
    include 'dbconfig.php';
    $delete_allowed = 0;
    $result = $con->query(
        "SELECT delete_allowed FROM access_level_grants WHERE role_id = ? AND form_id = ?",
        [$user_role, $form_id]
    );
    while ($result && ($row = $result->fetch_array())) {
        $delete_allowed = $row['delete_allowed'];
    }
    return $delete_allowed;
}
}

if (!function_exists('user_edit_roles')) {
function user_edit_roles($user_role, $form_id) {
    include 'dbconfig.php';
    $update_allowed = 0;
    $result = $con->query(
        "SELECT update_allowed FROM access_level_grants WHERE role_id = ? AND form_id = ?",
        [$user_role, $form_id]
    );
    while ($result && ($row = $result->fetch_array())) {
        $update_allowed = $row['update_allowed'];
    }
    return $update_allowed;
}
}
