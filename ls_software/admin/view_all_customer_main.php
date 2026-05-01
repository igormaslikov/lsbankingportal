<?php
session_start();
error_reporting(0);
include_once 'dbconnect.php';

// --- Layer 2 helpers: CSRF + filter-preserving URLs ---
if (empty($_SESSION['vac_csrf'])) {
    $_SESSION['vac_csrf'] = bin2hex(random_bytes(16));
}
function vac_csrf_ok() {
    return isset($_POST['csrf_token']) && hash_equals($_SESSION['vac_csrf'] ?? '', $_POST['csrf_token']);
}
// Build query string from current GET params with overrides (null → drop key).
function vac_query_string(array $overrides = []) {
    $params = $_GET;
    foreach ($overrides as $k => $v) {
        if ($v === null) { unset($params[$k]); } else { $params[$k] = $v; }
    }
    $qs = http_build_query($params);
    return $qs === '' ? '' : ('?' . htmlspecialchars($qs));
}
// XSS-safe echo helper
function vac_e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// --- Layer 3+4: shared WHERE with placeholders for the customer list ---
// Returns [where_sql, types_str, params_array] suitable for mysqli_stmt_bind_param.
function vac_filter_where() {
    $clauses = [];
    $types   = '';
    $params  = [];

    $status = trim($_GET['status'] ?? '');
    if ($status !== '' && $status !== 'All') {
        $clauses[] = "application_status = ?";
        $types   .= 's';
        $params[] = $status;
    }

    $state = trim($_GET['state'] ?? '');
    if ($state !== '' && $state !== 'All') {
        $clauses[] = "state = ?";
        $types   .= 's';
        $params[] = $state;
    }

    $loan_type = trim($_GET['loan_type'] ?? '');
    if ($loan_type !== '' && $loan_type !== 'All') {
        $clauses[] = "loan_type = ?";
        $types   .= 's';
        $params[] = $loan_type;
    }

    $keyword = trim($_GET['keyword'] ?? '');
    if ($keyword !== '') {
        $clauses[] = "CONCAT_WS(' ', first_name, last_name, email, mobile_number, dl_code) LIKE ?";
        $types   .= 's';
        $params[] = '%' . $keyword . '%';
    }

    $from_date = trim($_GET['from_date'] ?? '');
    $to_date   = trim($_GET['to_date']   ?? '');
    if ($from_date !== '' && $to_date !== '') {
        $clauses[] = "creation_date BETWEEN ? AND ?";
        $types   .= 'ss';
        $params[] = $from_date;
        $params[] = $to_date;
    }

    // Merged from view_all_customer_unread.php: ?unread=1 filters to applications that have not been read yet
    if (!empty($_GET['unread'])) {
        $clauses[] = "bold_status = '0'";
    }

    $where = $clauses ? (' WHERE ' . implode(' AND ', $clauses)) : '';
    return [$where, $types, $params];
}
include 'dbconfig.php';
if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];
if ($u_access_id == '0') {
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
} else {
    $DBcon->close();

?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="typeahead.min.js"></script>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome - <?php echo $userRow['email']; ?></title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="style.css" type="text/css" />
        <link rel="stylesheet" href="../paging/css/bootstrap.min.css">
        <!-- css/style1.css removed: it's a repurposed sports-page template (.nfl/.mlb/.nhl classes,
             dark body bg, .row:hover dark overlay) that breaks this layout. -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="style.css" type="text/css" />
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>








    </head>

    <body>

        <?php include('menu.php'); ?>

        <br>
        <br>

        <section class="wrapper" style="font-size:15px !important">
            <!-- Row title -->

            <br><br>
            <?php

            // Layer 3+4: single COUNT query via prepared statement + shared filter WHERE
            list($filter_where, $filter_types, $filter_params) = vac_filter_where();
            $count_sql = "SELECT COUNT(*) AS total FROM fnd_user_profile" . $filter_where;

            $rowcount = 0;
            if ($stmt_cnt = mysqli_prepare($con, $count_sql)) {
                if ($filter_types !== '') {
                    mysqli_stmt_bind_param($stmt_cnt, $filter_types, ...$filter_params);
                }
                if (mysqli_stmt_execute($stmt_cnt)) {
                    $cnt_res = mysqli_stmt_get_result($stmt_cnt);
                    if ($cnt_row = mysqli_fetch_assoc($cnt_res)) {
                        $rowcount = (int)$cnt_row['total'];
                    }
                    mysqli_free_result($cnt_res);
                }
                mysqli_stmt_close($stmt_cnt);
            }

            $rowcount_UNREAD = 0;
            if ($result_UNREAD = mysqli_query($con, "SELECT COUNT(*) AS n FROM `fnd_user_profile` WHERE `bold_status` = '0'")) {
                if ($r = mysqli_fetch_assoc($result_UNREAD)) {
                    $rowcount_UNREAD = (int)$r['n'];
                }
                mysqli_free_result($result_UNREAD);
            }
            ?>

            <!-- Toolbar -->
            <div class="vac-toolbar">
                <div class="vac-toolbar-left">
                    <a href="add_new_customer.php" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Add New Application
                    </a>
                </div>
                <div class="vac-toolbar-right">
                    <span class="vac-page-title">Customer Applications</span>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="row vac-kpi-row">
                <div class="col-sm-6 col-md-4">
                    <div class="panel panel-default vac-kpi-card">
                        <div class="panel-body">
                            <div class="vac-kpi-label">Matching Filters</div>
                            <div class="vac-kpi-value"><?php echo (int)$rowcount; ?></div>
                            <div class="vac-kpi-sub">Current filter selection</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="panel panel-default vac-kpi-card">
                        <div class="panel-body">
                            <div class="vac-kpi-label">Unread Applications</div>
                            <div class="vac-kpi-value vac-kpi-danger"><?php echo (int)$rowcount_UNREAD; ?></div>
                            <div class="vac-kpi-sub"><a href="view_all_customer_main.php?unread=1">View unread only &rsaquo;</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="panel panel-default vac-kpi-card">
                        <div class="panel-body">
                            <div class="vac-kpi-label">Quick Date Range</div>
                            <?php
                            // Preserve non-date filters when clicking a quick range
                            $qd_base = ['status' => $_GET['status'] ?? '', 'state' => $_GET['state'] ?? '', 'loan_type' => $_GET['loan_type'] ?? '', 'keyword' => $_GET['keyword'] ?? ''];
                            $qd_link = function($from, $to, $label) use ($qd_base) {
                                $p = array_merge($qd_base, ['from_date' => $from, 'to_date' => $to]);
                                return "<a href='view_all_customer_main.php?" . htmlspecialchars(http_build_query($p)) . "'>" . htmlspecialchars($label) . "</a>";
                            };
                            $today = date('Y-m-d');
                            $yest  = date('Y-m-d', strtotime('-1 day'));
                            $d3    = date('Y-m-d', strtotime('-3 day'));
                            $d7    = date('Y-m-d', strtotime('-7 day'));
                            $mo1   = date('Y-m-d', strtotime('first day of this month'));
                            $y1    = date('Y-01-01');
                            echo '<div class="vac-quick-dates">'
                                . $qd_link($today, $today, 'Today') . ' · '
                                . $qd_link($yest,  $yest,  'Yesterday') . ' · '
                                . $qd_link($d3,    $today, 'Last 3d') . ' · '
                                . $qd_link($d7,    $today, 'Last 7d') . ' · '
                                . $qd_link($mo1,   $today, 'This Month') . ' · '
                                . $qd_link($y1,    $today, 'This Year')
                                . '</div>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <form action="view_all_customer_main.php" method="GET" id="vac-filter-form">
                <div class="panel panel-default vac-filter-panel">
                    <div class="panel-heading">
                        <strong><span class="glyphicon glyphicon-filter"></span> Filters</strong>
                        <a href="view_all_customer_main.php" class="btn btn-link btn-xs pull-right vac-clear-link">Clear all</a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 vac-field">
                                <label>Application Status</label>
                                <select name="status" class="form-control">
                                    <?php
                                    $status_options = ['All', 'New Application', 'Declined', 'Funded', 'No Answer', 'Rejected By Customer', 'Approved Payday CA', 'Review Payday CA', 'DL/Bank Payday CA'];
                                    $cur_status = $_GET['status'] ?? '';
                                    foreach ($status_options as $opt) {
                                        $sel = ($cur_status === $opt) ? ' selected' : '';
                                        $label = ($opt === 'All') ? 'All Applications' : $opt;
                                        echo '<option value="' . htmlspecialchars($opt) . '"' . $sel . '>' . htmlspecialchars($label) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 vac-field">
                                <label>State</label>
                                <select name="state" class="form-control">
                                    <option value="All" <?php if (($_GET['state'] ?? '') === 'All') echo 'selected'; ?>>All</option>
                                    <option value="CA"  <?php if (($_GET['state'] ?? '') === 'CA')  echo 'selected'; ?>>California</option>
                                </select>
                            </div>
                            <div class="col-md-2 vac-field">
                                <label>Application Type</label>
                                <select name="loan_type" class="form-control">
                                    <option value="All"        <?php if (($_GET['loan_type'] ?? '') === 'All')        echo 'selected'; ?>>All</option>
                                    <option value="payday"     <?php if (($_GET['loan_type'] ?? '') === 'payday')     echo 'selected'; ?>>Payday</option>
                                    <option value="commercial" <?php if (($_GET['loan_type'] ?? '') === 'commercial') echo 'selected'; ?>>Commercial</option>
                                </select>
                            </div>
                            <div class="col-md-5 vac-field">
                                <label>Keyword (name / email / phone / DL code)</label>
                                <input type="text" class="form-control" name="keyword" placeholder="type to search..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 vac-field">
                                <label>Application Date (from)</label>
                                <input type="date" class="form-control" name="from_date" value="<?php echo htmlspecialchars($_GET['from_date'] ?? ''); ?>">
                            </div>
                            <div class="col-md-3 vac-field">
                                <label>Application Date (to)</label>
                                <input type="date" class="form-control" name="to_date" value="<?php echo htmlspecialchars($_GET['to_date'] ?? ''); ?>">
                            </div>
                            <div class="col-md-3 vac-field">
                                <label>&nbsp;</label>
                                <div class="checkbox vac-unread-toggle">
                                    <label>
                                        <input type="checkbox" name="unread" value="1" <?php if (!empty($_GET['unread'])) echo 'checked'; ?>>
                                        Unread applications only
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 vac-field vac-search-actions">
                                <label>&nbsp;</label>
                                <div>
                                    <button id="btnSearch" name="search" type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search"></span> Search
                                    </button>
                                    <a href="view_all_customer_main.php" class="btn btn-default">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div style="width:100%; margin:0 auto;">

                    <table class="table table-striped vac-results-table">
                        <thead>
                            <tr>
                                <th style='width:7%;text-align:center;'>ID</th>
                                <th style='width:13%;text-align:center;'>Application Date</th>
                                <th style='width:15%;text-align:center;'>First Name</th>
                                <th style='width:15%;text-align:center;'>Last Name</th>
                                <th style='width:10%;text-align:center;'>Phone</th>
                                <th style='width:6%;text-align:center;'>State</th>
                                <th style='width:9%;text-align:center;'>App Type</th>
                                <th style='width:15%;text-align:center;'>Application Status</th>
                                <th style='width:10%;text-align:center;'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Pagination math
                            $page_no = (isset($_GET['page_no']) && $_GET['page_no'] !== '') ? max(1, (int)$_GET['page_no']) : 1;
                            $total_records_per_page = 100;
                            $offset = ($page_no - 1) * $total_records_per_page;
                            $previous_page = $page_no - 1;
                            $next_page = $page_no + 1;
                            $adjacents = 2;
                            $total_records = $rowcount;
                            $total_no_of_pages = $total_records_per_page > 0 ? (int)ceil($total_records / $total_records_per_page) : 0;
                            $second_last = $total_no_of_pages - 1;

                            // Layer 3+4: single LIST query via prepared statement — filters NOW actually apply to the list
                            // (old code used a submission-based query that ignored filters entirely).
                            $list_sql = "SELECT * FROM fnd_user_profile" . $filter_where . " ORDER BY user_fnd_id DESC LIMIT ?, ?";
                            $list_types  = $filter_types . 'ii';
                            $list_params = array_merge($filter_params, [$offset, $total_records_per_page]);

                            $result = false;
                            $stmt_list = mysqli_prepare($con, $list_sql);
                            if ($stmt_list) {
                                mysqli_stmt_bind_param($stmt_list, $list_types, ...$list_params);
                                mysqli_stmt_execute($stmt_list);
                                $result = mysqli_stmt_get_result($stmt_list);
                            }

                            $rows_rendered_vac = 0;
                            while ($result && ($row = mysqli_fetch_assoc($result))) {
                                $id          = $row['user_fnd_id'];
                                $cr_date     = $row['application_date'];
                                $lang        = $row['lang'] ?? '';
                                $bold_status = $row['bold_status'] ?? '';
                                $newDate     = $cr_date ? date("m-d-y", strtotime($cr_date)) : '';

                                $image_lang = ($lang === 'en')
                                    ? "<img src='imgs/en.png' alt='EN' />"
                                    : "<img src='imgs/es.png' alt='ES' />";

                                $string_red_rejected = '';
                                switch ($row['application_status']) {
                                    case 'Declined':
                                    case 'Rejected By Customer':           $string_red_rejected = 'style="color:red"'; break;
                                    case 'Decision Logic Completed':
                                    case 'Credit Report Needed':
                                    case 'Pending Documents':              $string_red_rejected = 'style="color:#b8bb01"'; break;
                                    case 'Final Review':                   $string_red_rejected = 'style="color:orange"'; break;
                                    case 'Approved Payday Loan':
                                    case 'Approved Personal Loan':
                                    case 'Approved Title Loan':            $string_red_rejected = 'style="color:green"'; break;
                                    case 'No Answer':                      $string_red_rejected = 'style="color:#9370DB"'; break;
                                    case 'Funded':                         $string_red_rejected = 'style="color:black"'; break;
                                }

                                $decision_logic_Status = '';
                                $experian_credit_score = '';
                                if (($row['decision_logic_status'] ?? 0) > 0) {
                                    $decision_logic_Status = ' <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" title="DL Verified" style="color:green"></span>  ';
                                }
                                if (($row['experian_credit_score'] ?? 0) > 100 && ($row['experian_credit_score'] ?? 0) < 9999) {
                                    $experian_credit_score = ' <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" title="Experian" style="color:red"></span>  ';
                                }

                                $bold_app = ($bold_status == '0')
                                    ? 'style="font-weight:bold"'
                                    : 'style="font-size:16px !important"';

                                // Escape-once values used in URLs/attributes
                                $id_url  = urlencode($id);
                                $uid_url = urlencode((string)$u_id);
                                // Merge id (and uid) into a single query string so we don't
                                // end up with two `?` separators, which PHP parses as part of id.
                                $edit_qs   = vac_query_string(['id'  => $id]);
                                $delete_qs = vac_query_string(['id'  => $id, 'uid' => $u_id]);

                                // Build per-row Actions dropdown
                                $actions  = "<div class='btn-group'>";
                                $actions .= "<button type='button' class='btn btn-default btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions <span class='caret'></span></button>";
                                $actions .= "<ul class='dropdown-menu dropdown-menu-right vac-actions-menu'>";
                                $actions .= "<li><a href='edit_customer.php$edit_qs'><span class='glyphicon glyphicon-edit'></span> Edit Customer</a></li>";
                                $actions .= "<li><a href='customer_loan_history.php?id=$id_url'><span class='glyphicon glyphicon-collapse-up'></span> Loan History</a></li>";
                                $actions .= "<li class='divider'></li>";
                                $actions .= "<li><a class='remove-box vac-action-delete' href='delete_customer.php$delete_qs'><span class='glyphicon glyphicon-remove'></span> Delete Customer</a></li>";
                                $actions .= "</ul></div>";

                                echo "<tr " . $string_red_rejected . " " . $bold_app . ">
                                    <td class='text-center'>$image_lang " . vac_e($id) . "</td>
                                    <td class='text-center'>" . vac_e($newDate) . "</td>
                                    <td class='text-center'>" . vac_e($row['first_name']) . "</td>
                                    <td class='text-center'>" . vac_e($row['last_name']) . "</td>
                                    <td class='text-center'>" . vac_e($row['mobile_number']) . "</td>
                                    <td class='text-center'>" . vac_e($row['state']) . "</td>
                                    <td class='text-center'>" . vac_e($row['loan_type']) . "</td>
                                    <td class='text-center'>" . vac_e($row['application_status']) . " " . $decision_logic_Status . $experian_credit_score . "</td>
                                    <td class='text-center'>" . $actions . "</td>
                                    </tr>";
                                $rows_rendered_vac++;
                            }
                            if ($rows_rendered_vac === 0) {
                                echo "<tr><td colspan='9' class='vac-empty-state'>No applications match your current filters. <a href='view_all_customer_main.php'>Clear all</a>.</td></tr>";
                            }
                            if (!empty($stmt_list)) {
                                mysqli_stmt_close($stmt_list);
                            }
                            mysqli_close($con);
                            ?>
                        </tbody>
                    </table>

                    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                        <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                    </div>

                    <ul class="pagination">
                        <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
                        ?>

                        <?php
                        // Layer 2: pagination links use vac_query_string() so ALL filter params are preserved
                        $page_link = function($n, $label = null, $active = false, $disabled = false) {
                            $lbl = $label ?? $n;
                            if ($active)   return "<li class='active'><a>$lbl</a></li>";
                            if ($disabled) return "<li class='disabled'><a>$lbl</a></li>";
                            $href = vac_query_string(['page_no' => $n]);
                            return "<li><a href='$href'>$lbl</a></li>";
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

        <style>
            /* Layout */
            section.wrapper { padding: 10px 20px 40px; }

            /* Toolbar */
            .vac-toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 14px;
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
            }
            .vac-toolbar-left .btn { margin-right: 6px; }
            .vac-page-title { font-size: 18px; font-weight: 600; color: #555; }

            /* KPI cards */
            .vac-kpi-row { margin-bottom: 12px; }
            .vac-kpi-card { margin-bottom: 10px; }
            .vac-kpi-card .panel-body { padding: 14px 16px; }
            .vac-kpi-label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
            .vac-kpi-value { font-size: 24px; font-weight: 600; color: #333; line-height: 1.1; }
            .vac-kpi-sub { font-size: 12px; color: #777; margin-top: 6px; }
            .vac-kpi-danger { color: #d9534f !important; }
            .vac-quick-dates a { font-size: 13px; color: #337ab7; white-space: nowrap; }
            .vac-quick-dates a:hover { text-decoration: underline; }

            /* Filter panel */
            .vac-filter-panel { margin-bottom: 14px; }
            .vac-filter-panel .panel-heading { padding: 8px 14px; background-color: #fafafa; }
            .vac-clear-link { padding: 0 !important; }
            .vac-field { margin-bottom: 8px; }
            .vac-field label { font-size: 12px; color: #666; font-weight: 600; text-transform: uppercase; letter-spacing: .3px; margin-bottom: 4px; }
            .vac-search-actions label { visibility: hidden; }
            .vac-unread-toggle { margin: 0; padding-top: 6px; }
            .vac-unread-toggle label { text-transform: none; font-weight: normal; color: #333 !important; letter-spacing: normal; }
            .vac-unread-toggle input { margin-right: 6px; }

            /* Results table */
            .vac-results-table thead tr { background-color: #f5f5f5; }
            .vac-results-table th { color: #333 !important; font-weight: 600; border-bottom: 2px solid #ddd !important; padding: 10px 8px !important; }
            .vac-results-table td { vertical-align: middle !important; padding: 8px !important; }
            .vac-empty-state { text-align: center; padding: 40px !important; color: #999; font-style: italic; }

            /* Action dropdown — escape table clipping with high z-index on the open state */
            .vac-results-table td { overflow: visible !important; }
            .vac-results-table tbody tr td .btn-group.open .dropdown-menu { z-index: 2000; }
            .vac-actions-menu { min-width: 200px; z-index: 2000; }
            .vac-actions-menu > li > a { padding: 6px 14px !important; text-align: left; }
            .vac-actions-menu > li > a:hover { background-color: #f5f5f5 !important; color: #333 !important; }
            .vac-actions-menu .glyphicon { width: 18px; color: #666; margin-right: 4px; }
            .vac-action-delete { color: #d9534f !important; }

            /* Flash messages */
            .vac-flash { margin-bottom: 12px; padding: 10px 14px; }
            .vac-flash .glyphicon { margin-right: 6px; }
        </style>

        <script type="text/javascript">
            $(document).on('click', '.remove-box', function() {
                return confirm('Are you sure you want to delete this customer?');
            });

            // Manual dropdown toggle — robust against duplicate jQuery loads breaking Bootstrap's data-toggle
            $(document).on('click', '.vac-results-table .dropdown-toggle', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $bg = $(this).closest('.btn-group');
                var wasOpen = $bg.hasClass('open');
                $('.vac-results-table .btn-group.open').removeClass('open');
                if (!wasOpen) $bg.addClass('open');
            });
            // Click outside closes any open dropdown
            $(document).on('click', function() {
                $('.vac-results-table .btn-group.open').removeClass('open');
            });
            // Click inside the menu shouldn't close before the link navigates
            $(document).on('click', '.vac-actions-menu', function(e) { e.stopPropagation(); });

            // Enter key submits the filter form, not accidentally any action link
            $(document).keypress(function(e) {
                if (e.which == 13 && $(e.target).closest('#vac-filter-form').length) {
                    document.getElementById("btnSearch").click();
                }
            });

            // Auto-dismiss flash messages after 5s
            $(document).ready(function(){
                setTimeout(function(){ $('.vac-flash').fadeOut(400); }, 5000);
            });
        </script>

    </body>

    </html>

<?php
}
?>