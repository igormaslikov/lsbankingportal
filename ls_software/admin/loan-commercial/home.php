<?php
error_reporting(0);

// $id = $_GET['id'];
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
    header("Location: ../index.php");
}

// --- Layer 2 helpers: CSRF + filter-preserving URLs ---
if (empty($_SESSION['cl_csrf'])) {
    $_SESSION['cl_csrf'] = bin2hex(random_bytes(16));
}
function cl_csrf_ok() {
    return isset($_POST['csrf_token']) && hash_equals($_SESSION['cl_csrf'] ?? '', $_POST['csrf_token']);
}
function cl_csrf_input() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['cl_csrf']) . '">';
}
// Build query string from current GET params with overrides applied.
// Pass null as a value to drop that key. Escapes via http_build_query + htmlspecialchars.
function cl_query_string(array $overrides = []) {
    $params = $_GET;
    foreach ($overrides as $k => $v) {
        if ($v === null) { unset($params[$k]); } else { $params[$k] = $v; }
    }
    $qs = http_build_query($params);
    return $qs === '' ? '' : ('?' . htmlspecialchars($qs));
}

// --- Layer 4: shared WHERE with placeholders for prepared statements ---
// Assumes `tbl_commercial_loan l` LEFT JOIN `fnd_user_profile u` in the caller.
// Returns [where_sql, types_str, params_array] suitable for mysqli_stmt_bind_param.
function cl_filter_where($sign_status_int) {
    $sign = (int)$sign_status_int;
    $clauses = [];
    $types   = '';
    $params  = [];

    // Historical quirk: unsigned loans may have sign_status stored as '' (empty) instead of '0'.
    // Match both on the unsigned branch. No placeholders needed (no user input).
    if ($sign === 0) {
        $clauses[] = "(l.sign_status = '0' OR l.sign_status = '' OR l.sign_status IS NULL)";
    } else {
        $clauses[] = "l.sign_status = ?";
        $types   .= 's';
        $params[] = (string)$sign;
    }

    $status = trim($_GET['status'] ?? '');
    if ($status !== '' && $status !== 'All') {
        $clauses[] = "l.loan_status = ?";
        $types   .= 's';
        $params[] = $status;
    }

    $keyword = trim($_GET['keyword'] ?? '');
    if ($keyword !== '') {
        $clauses[] = "l.loan_create_id = ?";
        $types   .= 's';
        $params[] = $keyword;
    }

    $keyword_name = trim($_GET['keyword_name'] ?? '');
    if ($keyword_name !== '') {
        $clauses[] = "(u.user_fnd_id LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ? OR u.mobile_number LIKE ?)";
        $types   .= 'sssss';
        $like = '%' . $keyword_name . '%';
        array_push($params, $like, $like, $like, $like, $like);
    }

    $to_date     = trim($_GET['to_date']  ?? '');
    $from_date   = trim($_GET['from_date'] ?? '');
    $loan_date   = trim($_GET['loan_date'] ?? '');
    $due_date_gp = trim($_GET['due_date']  ?? '');

    if ($from_date !== '') {
        $clauses[] = "(l.last_payment_date BETWEEN ? AND ?)";
        $types   .= 'ss';
        $params[] = $from_date;
        $params[] = $to_date;
    }
    if ($loan_date !== '') {
        $clauses[] = "(l.contract_date BETWEEN ? AND ?)";
        $types   .= 'ss';
        $params[] = $loan_date;
        $params[] = $to_date;
    }
    if ($due_date_gp !== '') {
        $clauses[] = "(l.payment_date BETWEEN ? AND ?)";
        $types   .= 'ss';
        $params[] = $due_date_gp;
        $params[] = $to_date;
    }

    $where = $clauses ? (' WHERE ' . implode(' AND ', $clauses)) : '';
    return [$where, $types, $params];
}

// Small XSS-safe echo helper
function cl_e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];
if ($u_access_id == '2' || $u_access_id == '4' || $u_access_id == '5') {
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
    session_start();
} else {
    $DBcon->close();

?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome - <?php echo $userRow['email']; ?></title>

        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">

        <link rel="stylesheet" href="../style.css" type="text/css" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>

    <body>


        <section class="wrapper">
            <!-- Row title -->

            <br><br>
            <?php

            include '../dbconnect.php';
            include '../dbconfig.php';

            // POST-only destructive operations (CSRF protected, int-cast to neutralize injection)
            $cl_flash_ok = null;
            $cl_flash_err = null;
            $cl_flash_debug = null;
            // Diagnostic: dump what we received so we can see WHY the
            // success/error branches aren't firing. Remove after fixing.
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $cl_flash_debug = 'POST received | csrf_ok=' . (cl_csrf_ok() ? 'yes' : 'no')
                    . ' | signed_loan=' . var_export($_POST['signed_loan'] ?? null, true)
                    . ' | all POST keys=' . implode(',', array_keys($_POST))
                    . ' | session_id=' . session_id();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!cl_csrf_ok()) {
                    $cl_flash_err = 'Security check failed. Please reload the page and try again.';
                } elseif (!empty($_POST['signed_loan'])) {
                    $signed_id = (int)$_POST['signed_loan'];
                    if ($signed_id > 0) {
                        // Use ->success because the SqlServerDb shim returns a
                        // SqlServerResult (always truthy) even on failure; a
                        // bare 'if ($con->query(...))' would always take the
                        // success branch and silently swallow the real error.
                        $r = $con->query("UPDATE tbl_commercial_loan SET sign_status='1' WHERE loan_id = $signed_id");
                        if ($r && $r->success) {
                            $cl_flash_ok = "Loan #$signed_id marked as signed.";
                        } else {
                            $cl_flash_err = "Could not mark loan #$signed_id as signed."
                                . ($r ? (" SQL Server: " . htmlspecialchars($r->error_message)) : "");
                        }
                    } else {
                        $cl_flash_err = "Invalid loan id.";
                    }
                }
            }
            // Parse sign_status filter (varchar '0' or '1' in DB)
            $sign_status_raw = isset($_GET['sign_status']) ? $_GET['sign_status'] : '';
            switch ($sign_status_raw) {
                case 'UnSigned': $sign_status = 0; break;
                case 'Signed':
                default:         $sign_status = 1; break;
            }

            // Shared filter WHERE for count and list, as prepared-statement fragments (Layer 4)
            list($filter_where, $filter_types, $filter_params) = cl_filter_where($sign_status);

            // COUNT query via prepared statement
            $count_sql = "SELECT COUNT(*) AS total
                          FROM tbl_commercial_loan l
                          LEFT JOIN fnd_user_profile u ON u.user_fnd_id = l.user_fnd_id
                          $filter_where";
            $rowcount = 0;
            if ($cnt_res = $con->query($count_sql, $filter_params)) {
                if ($cnt_row = $cnt_res->fetch_assoc()) {
                    $rowcount = (int)$cnt_row['total'];
                }
            }
            ?>
            <?php


            $us = 0; $pay_off = 0; $totall_trans = 0; $avg = 0; $avg_pay = 0; $total_loan_fee = 0;
$query_us = $con->query("SELECT SUM(TRY_CAST(principal_amount AS DECIMAL(18,2))) AS value_sum FROM tbl_commercial_loan where sign_status= $sign_status or sign_status= '$sign_status'");
            while ($query_us && ($row_us = $query_us->fetch_array())) {
                $us = $row_us['value_sum'];

                $us = number_format((float)$us, 2, '.', '');
                break;
            }


            $query_le = $con->query("SELECT SUM(TRY_CAST(payment AS DECIMAL(18,2))) AS value_sum FROM tbl_commercial_loan_installments where status= '0'");
            while ($query_le && ($row_le = $query_le->fetch_array())) {
                $pay_off = $row_le['value_sum'];
                break;
            }

            $query_trns = $con->query("SELECT SUM(TRY_CAST(principal_amount AS DECIMAL(18,2))) AS value_sum FROM commercial_loan_transaction ");
            while ($query_trns && ($row_trns = $query_trns->fetch_array())) {
                $totall_trans = $row_trns['value_sum'];
                break;
            }
            $totall_trans = number_format((float)$totall_trans, 2, '.', '');
            $pay_off = number_format((float)$pay_off, 2, '.', '');
            $avg_pay_off = 0;
            $avg_amount = 0;
            if ($rowcount > 0){
                
                $avg_pay_off = $pay_off / $rowcount;

                $avg_pay = round($avg_pay_off, 2);
                $avg_amount = $us / $rowcount;
            }
            

            $avg = number_format((float)$avg_amount, 2, '.', '');


            $query_interest = $con->query("SELECT SUM(TRY_CAST(interest AS DECIMAL(18,2))) AS value_sum FROM commercial_loan_transaction ");
            while ($query_interest && ($row_interest = $query_interest->fetch_array())) {
                $total_loan_fee = $row_interest['value_sum'];
                if ($total_loan_fee == NULL){
                     $total_loan_fee = 0;
                }
                break;
            }

            $query_pament_amount = $con->query("SELECT SUM(TRY_CAST(payment_amount AS DECIMAL(18,2))) AS value_sum FROM commercial_loan_transaction ");
            while ($query_pament_amount && ($row_pament_amount = $query_pament_amount->fetch_array())) {
                $totall_pament_amount = $row_pament_amount['value_sum'];
                break;
            }



            ?>

            <!-- Flash messages -->
            <?php if (!empty($cl_flash_debug)): ?>
                <div class="alert alert-info cl-flash" style="font-family:monospace;font-size:12px;">
                    DEBUG: <?php echo htmlspecialchars($cl_flash_debug); ?>
                </div>
            <?php endif; ?>
            <?php if ($cl_flash_ok): ?>
                <div class="alert alert-success cl-flash">
                    <span class="glyphicon glyphicon-ok-sign"></span> <?php echo htmlspecialchars($cl_flash_ok); ?>
                </div>
            <?php endif; ?>
            <?php if ($cl_flash_err): ?>
                <div class="alert alert-danger cl-flash">
                    <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo htmlspecialchars($cl_flash_err); ?>
                </div>
            <?php endif; ?>

            <!-- Toolbar -->
            <div class="cl-toolbar">
                <div class="cl-toolbar-left">
                    <a href="../search_customer.php" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Add New Loan
                    </a>
                    <a href="loan_settings.php" class="btn btn-default">
                        <span class="glyphicon glyphicon-cog"></span> Loan Settings
                    </a>
                    <a href="repeat_loan.php" class="btn btn-default">
                        <span class="glyphicon glyphicon-repeat"></span> Loan Repeat Summary
                    </a>
                </div>
                <div class="cl-toolbar-right">
                    <span class="cl-page-title">Commercial Loans</span>
                </div>
            </div>

            <!-- KPI Cards -->
            <?php $uncollect = $pay_off - $totall_pament_amount; ?>
            <div class="row cl-kpi-row">
                <div class="col-sm-6 col-md-3">
                    <div class="panel panel-default cl-kpi-card">
                        <div class="panel-body">
                            <div class="cl-kpi-label">Loan Accounts</div>
                            <div class="cl-kpi-value"><?php echo (int)$rowcount; ?></div>
                            <div class="cl-kpi-sub">Avg amount: $<?php echo number_format((float)$avg, 2); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="panel panel-default cl-kpi-card">
                        <div class="panel-body">
                            <div class="cl-kpi-label">Total Principal</div>
                            <div class="cl-kpi-value">$<?php echo number_format((float)$us, 2); ?></div>
                            <div class="cl-kpi-sub">Avg payoff: $<?php echo number_format((float)$avg_pay, 2); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="panel panel-default cl-kpi-card">
                        <div class="panel-body">
                            <div class="cl-kpi-label">Outstanding</div>
                            <div class="cl-kpi-value cl-kpi-danger">$<?php echo number_format((float)$pay_off, 2); ?></div>
                            <div class="cl-kpi-sub">Uncollected: $<?php echo ($uncollect > 0) ? number_format((float)$uncollect, 2) : '0.00'; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="panel panel-default cl-kpi-card">
                        <div class="panel-body">
                            <div class="cl-kpi-label">Payments Received</div>
                            <div class="cl-kpi-value cl-kpi-success">$<?php echo number_format((float)$totall_trans, 2); ?></div>
                            <div class="cl-kpi-sub">Interest collected: $<?php echo number_format((float)$total_loan_fee, 2); ?></div>
                        </div>
                    </div>
                </div>
            </div>




            <br>
            <form action="home.php" method="GET" id="cl-filter-form">
                <div class="panel panel-default cl-filter-panel">
                    <div class="panel-heading">
                        <strong><span class="glyphicon glyphicon-filter"></span> Filters</strong>
                        <a href="home.php" class="btn btn-link btn-xs pull-right cl-clear-link">Clear all</a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 cl-field">
                                <label>Sign Status</label>
                                <select id="lstbSignStatus" name="sign_status" class="form-control">
                                    <option value="Signed" <?php if (($_GET['sign_status'] ?? '') == 'Signed') echo 'selected'; ?>>Signed</option>
                                    <option value="UnSigned" <?php if (($_GET['sign_status'] ?? '') == 'UnSigned') echo 'selected'; ?>>UnSigned</option>
                                </select>
                            </div>
                            <div class="col-md-3 cl-field">
                                <label>Account Status</label>
                                <select name="status" class="form-control">
                                    <?php
                                    $status_options = ['All', 'Active', 'Paid', 'Past Due', 'Promise to Pay', 'Payment Plan', 'Collections', 'Chargeoff', 'Closed Account', 'Chargeback', 'Bankruptcy'];
                                    $current_status = isset($_GET['status']) ? $_GET['status'] : '';
                                    foreach ($status_options as $opt) {
                                        $sel = ($current_status === $opt) ? ' selected' : '';
                                        echo '<option value="' . htmlspecialchars($opt) . '"' . $sel . '>' . htmlspecialchars($opt) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 cl-field">
                                <label>Search by Name / Phone / Email</label>
                                <input type="text" id="search_name" class="form-control" name="keyword_name" placeholder="e.g. John, 555…, @gmail" value="<?php echo htmlspecialchars($_GET['keyword_name'] ?? ''); ?>">
                            </div>
                            <div class="col-md-3 cl-field">
                                <label>Loan ID</label>
                                <input type="text" id="search" class="form-control" name="keyword" placeholder="e.g. OF1-10001" value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 cl-field">
                                <label>Loan Date (from)</label>
                                <input type="date" id="loan_date" class="form-control" name="loan_date" value="<?php echo htmlspecialchars($_GET['loan_date'] ?? ''); ?>">
                            </div>
                            <div class="col-md-2 cl-field">
                                <label>Due Date (from)</label>
                                <input type="date" id="due_date" class="form-control" name="due_date" value="<?php echo htmlspecialchars($_GET['due_date'] ?? ''); ?>">
                            </div>
                            <div class="col-md-2 cl-field">
                                <label>Payment Date (from)</label>
                                <input type="date" id="from_date" class="form-control" name="from_date" value="<?php echo htmlspecialchars($_GET['from_date'] ?? ''); ?>">
                            </div>
                            <div class="col-md-2 cl-field">
                                <label>To Date</label>
                                <input type="date" id="to_date" class="form-control" name="to_date" value="<?php echo htmlspecialchars($_GET['to_date'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4 cl-field cl-search-actions">
                                <label>&nbsp;</label>
                                <div>
                                    <button id="btnSearch" name="search" type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search"></span> Search
                                    </button>
                                    <a href="home.php" class="btn btn-default">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="width:100%; margin:0 auto;">
                    <table class="table table-striped table-hover cl-results-table">
                        <thead>
                            <tr>
                                <th style='width:8%;text-align:center;'>Loan ID</th>
                                <th style='width:10%;text-align:center;'>Status</th>
                                <th style='width:15%;text-align:center;'>Customer</th>
                                <th style='width:11%;text-align:center;'>Phone</th>
                                <th style='width:10%;text-align:center;'>Principal</th>
                                <th style='width:10%;text-align:center;'>Interest</th>
                                <th style='width:9%;text-align:center;'>Loan Date</th>
                                <th style='width:9%;text-align:center;'>Due Date</th>
                                <th style='width:9%;text-align:center;'>Last Payment</th>
                                <th style='width:9%;text-align:center;'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            include('../db.php');

                            // Pagination math
                            $page_no = (isset($_GET['page_no']) && $_GET['page_no'] !== '') ? max(1, (int)$_GET['page_no']) : 1;
                            $total_records_per_page = 25;
                            $count = 1 + $total_records_per_page * ($page_no - 1);
                            $offset = ($page_no - 1) * $total_records_per_page;
                            $previous_page = $page_no - 1;
                            $next_page = $page_no + 1;
                            $adjacents = 2;

                            $total_records = $rowcount;
                            $total_no_of_pages = $total_records_per_page > 0 ? (int)ceil($total_records / $total_records_per_page) : 0;
                            $second_last = $total_no_of_pages - 1;

                            // Layer 3+4: single list query via prepared statement
                            // JOIN + correlated subqueries replace per-row N+1; bind_param eliminates injection.
                            $list_sql = "
                                SELECT
                                    l.loan_id,
                                    l.loan_create_id,
                                    l.loan_status,
                                    l.principal_amount,
                                    l.loan_interest,
                                    l.balance_due,
                                    l.payment_date,
                                    l.daily_interest,
                                    l.contract_date,
                                    l.user_fnd_id,
                                    l.sign_status,
                                    u.first_name,
                                    u.last_name,
                                    u.mobile_number,
                                    u.decision_logic_status,
                                    (SELECT TOP 1 i.payment_date
                                       FROM tbl_commercial_loan_installments i
                                       WHERE i.loan_create_id = l.loan_create_id AND i.status = 0
                                       ORDER BY i.id ASC) AS next_due_date,
                                    (SELECT TOP 1 t.created_at
                                       FROM commercial_loan_transaction t
                                       WHERE t.loan_create_id = l.loan_create_id
                                       ORDER BY t.transaction_id DESC) AS last_txn_at
                                FROM tbl_commercial_loan l
                                LEFT JOIN fnd_user_profile u ON u.user_fnd_id = l.user_fnd_id
                                $filter_where
                                ORDER BY l.loan_id DESC
                                OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

                            $list_params = array_merge($filter_params, [$offset, $total_records_per_page]);

                            $result = $con->query($list_sql, $list_params);
                            $rows_rendered = 0;
                            while ($row = $result->fetch_array()) {
                                $user_fnd_id           = $row['user_fnd_id'];
                                $user_name             = $row['first_name'];
                                $last_name             = $row['last_name'];
                                $user_mobile           = $row['mobile_number'];
                                $decision_logic_status = $row['decision_logic_status'];

                                $loan_create_id = $row['loan_create_id'];
                                $id             = $row['loan_id'];
                                $loan_status    = $row['loan_status'];
                                $amount_of_loan = $row['principal_amount'];
                                $balance_due    = $row['balance_due'];
                                $payment_date   = $row['payment_date'];
                                $daily_interest = $row['daily_interest'];
                                $interest_amount = number_format((float)$row['loan_interest'], 2, '.', ',');

                                // Row color by loan status
                                $string_red_rejected = '';
                                switch ($row['loan_status']) {
                                    case 'Active':           $string_red_rejected = 'style="color:green"'; break;
                                    case 'Paid':             $string_red_rejected = 'style="color:black"'; break;
                                    case 'Past Due':         $string_red_rejected = 'style="color:#ff8c00"'; break;
                                    case 'Promise to Pay':
                                    case 'Payment Plan':     $string_red_rejected = 'style="color:#1E90FF"'; break;
                                    case 'Collections':      $string_red_rejected = 'style="color:#999900"'; break;
                                    case 'Chargeoff':
                                    case 'Closed Account':
                                    case 'Chargeback':
                                    case 'Bankruptcy':       $string_red_rejected = 'style="color:red"'; break;
                                }

                                // Values from correlated subqueries (no per-row round trips)
                                $due_date   = $row['next_due_date'] ?? '';
                                $created_at = $row['last_txn_at'] ?? '';

                                $last_payment_date = '';
                                if ($created_at) {
                                    $last_payment_date = date('m-d-Y', strtotime($created_at));
                                }
                                $new_contract = $row['contract_date'] ? date('m-d-Y', strtotime($row['contract_date'])) : '';
                                $amount_of_loan = number_format((float)$amount_of_loan, 2);
                                // Build Actions dropdown per row
                                $csrf_val = htmlspecialchars($_SESSION['cl_csrf']);
                                // Escape-once values for safe embedding in HTML attributes and URLs
                                $id_url            = urlencode($id);
                                $user_fnd_id_url   = urlencode((string)$user_fnd_id);
                                $loan_create_attr  = cl_e($loan_create_id);

                                $actions  = "<div class='btn-group'>";
                                $actions .= "<button type='button' class='btn btn-default btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions <span class='caret'></span></button>";
                                $actions .= "<ul class='dropdown-menu dropdown-menu-right cl-actions-menu'>";
                                $actions .= "<li><a href='loan_summary.php?id=$id_url'><span class='glyphicon glyphicon-user'></span> View Summary</a></li>";
                                if ($sign_status == 1) {
                                    $actions .= "<li><a href='add_new_transaction.php?id=$id_url'><span class='glyphicon glyphicon-usd cl-icon-danger'></span> Make Payment</a></li>";
                                    if ($decision_logic_status == '1') {
                                        $actions .= "<li><a href='#'><span class='glyphicon glyphicon-ok-circle cl-icon-success'></span> DL Verified</a></li>";
                                    } else {
                                        $actions .= "<li><a href='#'><span class='glyphicon glyphicon-book'></span> Bank Statement</a></li>";
                                    }
                                } else {
                                    // Mark-as-Signed is a POST form to prevent GET-triggered state changes
                                    // Preserve current view (sign_status filter etc.) so the
                                    // user stays on Unsigned after marking, not bounced to Signed.
                                    $form_action_qs = cl_query_string([]);
                                    $actions .= "<li>"
                                        . "<form method='post' action='home.php$form_action_qs' class='cl-inline-form cl-signed-form' data-confirm='Mark loan #$loan_create_attr as signed?'>"
                                        . "<input type='hidden' name='csrf_token' value='$csrf_val'>"
                                        . "<input type='hidden' name='signed_loan' value='" . (int)$id . "'>"
                                        . "<button type='submit' class='cl-dropdown-submit'><span class='glyphicon glyphicon-ok-sign cl-icon-success'></span> Mark as Signed</button>"
                                        . "</form>"
                                        . "</li>";
                                }
                                $actions .= "<li class='divider'></li>";
                                $actions .= "<li><a class='remove-box cl-action-delete' href='delete_loan.php?loan_id=$id_url&fnd_id=$user_fnd_id_url'><span class='glyphicon glyphicon-remove'></span> Delete Loan</a></li>";
                                $actions .= "</ul></div>";

                                echo "<tr " . $string_red_rejected . ">
                                <td class='text-center'>" . cl_e($loan_create_id) . "</td>
                                <td class='text-center'>" . cl_e($loan_status) . "</td>
                                <td class='text-center'>" . cl_e($user_name . ' ' . $last_name) . "</td>
                                <td class='text-center'>" . cl_e($user_mobile) . "</td>
                                <td class='text-center'>$" . cl_e($amount_of_loan) . "</td>
                                <td class='text-center'>$" . cl_e($interest_amount) . "</td>
                                <td class='text-center'>" . cl_e($new_contract) . "</td>
                                <td class='text-center'>" . cl_e($due_date) . "</td>
                                <td class='text-center'>" . cl_e($last_payment_date) . "</td>
                                <td class='text-center'>" . $actions . "</td>
                                </tr>";
                                $rows_rendered++;
                            }
                            if ($rows_rendered === 0) {
                                echo "<tr><td colspan='10' class='cl-empty-state'>No loans match your current filters. <a href='home.php'>Clear all</a>.</td></tr>";
                            }
                            $con->close();
                            ?>

                        </tbody>
                    </table>
                    <?php //echo $query_search; 
                    ?>
                    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                        <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                    </div>

                    <ul class="pagination">
                        <?php
                        // Helper: emit one page link preserving all current filters
                        $page_link = function($n, $label = null, $active = false, $disabled = false) {
                            $label = $label ?? $n;
                            if ($active) {
                                return "<li class='active'><a>$label</a></li>";
                            }
                            if ($disabled) {
                                return "<li class='disabled'><a>$label</a></li>";
                            }
                            $href = cl_query_string(['page_no' => $n]);
                            return "<li><a href='$href'>$label</a></li>";
                        };

                        echo $page_link($previous_page, 'Previous', false, $page_no <= 1);

                        if ($total_no_of_pages <= 10) {
                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                echo $page_link($counter, null, $counter == $page_no);
                            }
                        } elseif ($total_no_of_pages > 10) {
                            if ($page_no <= 4) {
                                for ($counter = 1; $counter < 8; $counter++) {
                                    echo $page_link($counter, null, $counter == $page_no);
                                }
                                echo "<li class='disabled'><a>…</a></li>";
                                echo $page_link($second_last);
                                echo $page_link($total_no_of_pages);
                            } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                                echo $page_link(1);
                                echo $page_link(2);
                                echo "<li class='disabled'><a>…</a></li>";
                                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                    echo $page_link($counter, null, $counter == $page_no);
                                }
                                echo "<li class='disabled'><a>…</a></li>";
                                echo $page_link($second_last);
                                echo $page_link($total_no_of_pages);
                            } else {
                                echo $page_link(1);
                                echo $page_link(2);
                                echo "<li class='disabled'><a>…</a></li>";
                                for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                    echo $page_link($counter, null, $counter == $page_no);
                                }
                            }
                        }

                        echo $page_link($next_page, 'Next', false, $page_no >= $total_no_of_pages);
                        if ($page_no < $total_no_of_pages) {
                            echo $page_link($total_no_of_pages, 'Last &rsaquo;&rsaquo;');
                        }
                        ?>
                    </ul>


                    <br /><br />

                </div>
            </form>

        </section>

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>
        <script type="text/javascript">
            // Confirm before destructive actions
            $(document).on('click', '.remove-box', function() {
                return confirm('Are you sure you want to delete this loan? This will also remove its transactions and installments.');
            });

            // Confirm before POST-submitting Mark as Signed forms
            $(document).on('submit', '.cl-signed-form', function(e) {
                var msg = $(this).data('confirm') || 'Are you sure?';
                if (!confirm(msg)) { e.preventDefault(); return false; }
                return true;
            });

            // Enter key submits the filter form (not any in-row action form)
            $(document).keypress(function(e) {
                if (e.which == 13 && $(e.target).closest('#cl-filter-form').length) {
                    document.getElementById("btnSearch").click();
                }
            });

            // Sign-status dropdown auto-submits the filter form
            $(document).ready(function(){
                var node = document.getElementById('lstbSignStatus');
                if (node) {
                    node.addEventListener('change', function(){
                        document.getElementById("btnSearch").click();
                    });
                }

                // Auto-dismiss flash messages after 5s
                setTimeout(function(){ $('.cl-flash').fadeOut(400); }, 5000);
            });
        </script>


        <style>
            /* Layout */
            section.wrapper { padding: 10px 20px 40px; }

            /* Toolbar */
            .cl-toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 14px;
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
            }
            .cl-toolbar-left .btn { margin-right: 6px; }
            .cl-page-title { font-size: 18px; font-weight: 600; color: #555; }

            /* KPI cards */
            .cl-kpi-row { margin-bottom: 12px; }
            .cl-kpi-card { margin-bottom: 10px; border-radius: 4px; }
            .cl-kpi-card .panel-body { padding: 14px 16px; }
            .cl-kpi-label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
            .cl-kpi-value { font-size: 24px; font-weight: 600; color: #333; line-height: 1.1; }
            .cl-kpi-sub { font-size: 12px; color: #777; margin-top: 6px; }
            .cl-kpi-danger { color: #d9534f !important; }
            .cl-kpi-success { color: #5cb85c !important; }

            /* Filter panel */
            .cl-filter-panel { margin-bottom: 14px; }
            .cl-filter-panel .panel-heading { padding: 8px 14px; background-color: #fafafa; }
            .cl-clear-link { padding: 0 !important; }
            .cl-field { margin-bottom: 8px; }
            .cl-field label { font-size: 12px; color: #666; font-weight: 600; text-transform: uppercase; letter-spacing: .3px; margin-bottom: 4px; }
            .cl-search-actions label { visibility: hidden; }

            /* Results table */
            .cl-results-table thead tr { background-color: #f5f5f5; }
            .cl-results-table th { color: #333 !important; font-weight: 600; border-bottom: 2px solid #ddd !important; padding: 10px 8px !important; }
            .cl-results-table td { vertical-align: middle !important; padding: 8px !important; }
            .cl-empty-state { text-align: center; padding: 40px !important; color: #999; font-style: italic; }

            /* Action dropdown */
            .cl-actions-menu { min-width: 200px; }
            .cl-actions-menu > li > a,
            .cl-actions-menu .cl-dropdown-submit {
                display: block;
                width: 100%;
                padding: 6px 14px !important;
                text-align: left;
                background: transparent;
                border: 0;
                color: #333;
                font: inherit;
                cursor: pointer;
            }
            .cl-actions-menu .cl-dropdown-submit:hover,
            .cl-actions-menu > li > a:hover { background-color: #f5f5f5; }
            .cl-actions-menu .glyphicon { width: 18px; color: #666; margin-right: 4px; }
            .cl-icon-danger { color: #d9534f !important; }
            .cl-icon-success { color: #5cb85c !important; }
            .cl-action-delete { color: #d9534f !important; }
            .cl-inline-form { margin: 0; padding: 0; }

            /* Flash messages */
            .cl-flash { margin-bottom: 12px; padding: 10px 14px; }
            .cl-flash .glyphicon { margin-right: 6px; }

            /* Pagination */
            .pagination { margin-top: 10px; }
        </style>

    </body>

    </html>

<?php
}
?>




