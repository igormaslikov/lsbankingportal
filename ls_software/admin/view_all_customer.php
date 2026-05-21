<?php
session_start();
error_reporting(0);
include_once 'dbconnect.php';
include 'dbconfig.php';
include_once 'security.php';
require_login();

$user_id_s = (int)$_SESSION['userSession'];
$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $user_id_s);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];
if ($u_access_id == '0') {
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
    exit;
}
$DBcon->close();

// Sanitize GET params
$status    = $_GET['status']    ?? 'All';
$keyword   = $_GET['keyword']   ?? '';
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date']   ?? '';
$website   = $_GET['website']   ?? 'All';
$state     = $_GET['state']     ?? 'All';
$loan_type = $_GET['loan_type'] ?? 'All';

// Build parameterized WHERE clause
$where_parts  = [];
$search_params = [];

if ($status !== 'All' && $status !== '') {
    $where_parts[] = "application_status = ?";
    $search_params[] = $status;
}
if ($keyword !== '') {
    $where_parts[] = "(CAST(user_fnd_id AS VARCHAR(20)) + ISNULL(first_name,'') + ISNULL(last_name,'') + ISNULL(email,'') + ISNULL(mobile_number,'') + ISNULL(dl_code,'')) LIKE ?";
    $search_params[] = '%' . $keyword . '%';
}
if ($from_date !== '' && $to_date !== '') {
    $where_parts[] = "(creation_date BETWEEN ? AND ?)";
    $search_params[] = $from_date;
    $search_params[] = $to_date;
}
if ($website !== 'All' && $website !== '') {
    $where_parts[] = "website = ?";
    $search_params[] = $website;
}
if ($state !== 'All' && $state !== '') {
    $where_parts[] = "state = ?";
    $search_params[] = $state;
}
if ($loan_type !== 'All' && $loan_type !== '') {
    $where_parts[] = "loan_type = ?";
    $search_params[] = $loan_type;
}

$where_sql = !empty($where_parts) ? " WHERE " . implode(" AND ", $where_parts) : "";

// Count matching records
$rowcount = 0;
if ($result_t = $con->query("SELECT * FROM fnd_user_profile" . $where_sql, $search_params)) {
    $rowcount = $result_t->num_rows;
}
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
    <title>Welcome - <?php echo h($userRow['email']); ?></title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="../paging/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>

<?php include('menu.php'); ?>

<br><br>

<section class="wrapper" style="font-size:15px !important">
<br><br>

<div align="right">
    <a href="add_new_customer.php">
        <button style="background-color: #1E90FF;color: white;border-color: #1E90FF;" name="btn-submit" type="submit" class="btn btn-danger">Add New Application</button>
    </a>
    <h4 style="float:left;"> Total Applications: <?php echo $rowcount; ?> </h4>
</div>
<br>

<form action="view_all_customer.php" method="GET">
<table class="table table-striped tasks-table" id="table_bg" style="font-size:15px !important">
<thead align="center">
<tr>

    <td colspan="2" style="font-weight: bold;">
        Application Status
        <select name="status" id="app_status" class="form-control" value="" style="padding: 6px 15px;">
            <option value="All" <?php if ($status == 'All') echo 'selected'; ?>>All Applications</option>
            <option value="New Application"        <?php if ($status == 'New Application') echo 'selected'; ?>>New Application</option>
            <option value="Declined"               <?php if ($status == 'Declined') echo 'selected'; ?>>Declined</option>
            <option value="Funded"                 <?php if ($status == 'Funded') echo 'selected'; ?>>Funded</option>
            <option value="No Answer"              <?php if ($status == 'No Answer') echo 'selected'; ?>>No Answer</option>
            <option value="Rejected By Customer"   <?php if ($status == 'Rejected By Customer') echo 'selected'; ?>>Rejected By Customer</option>
            <option value="Approved Payday CA"     <?php if ($status == 'Approved Payday CA') echo 'selected'; ?>>Approved Payday CA</option>
            <option value="Approved Payday NV"     <?php if ($status == 'Approved Payday NV') echo 'selected'; ?>>Approved Payday NV</option>
            <option value="Approved Payday IL"     <?php if ($status == 'Approved Payday IL') echo 'selected'; ?>>Approved Payday IL</option>
            <option value="Approved Installment CA"<?php if ($status == 'Approved Installment CA') echo 'selected'; ?>>Approved Installment CA</option>
            <option value="Approved Installment AZ"<?php if ($status == 'Approved Installment AZ') echo 'selected'; ?>>Approved Installment AZ</option>
            <option value="Approved Installment NV"<?php if ($status == 'Approved Installment NV') echo 'selected'; ?>>Approved Installment NV</option>
            <option value="Approved Installment IL"<?php if ($status == 'Approved Installment IL') echo 'selected'; ?>>Approved Installment IL</option>
            <option value="Review Payday CA"       <?php if ($status == 'Review Payday CA') echo 'selected'; ?>>Review Payday CA</option>
            <option value="Review Payday NV"       <?php if ($status == 'Review Payday NV') echo 'selected'; ?>>Review Payday NV</option>
            <option value="Review Payday IL"       <?php if ($status == 'Review Payday IL') echo 'selected'; ?>>Review Payday IL</option>
            <option value="Review Installment CA"  <?php if ($status == 'Review Installment CA') echo 'selected'; ?>>Review Installment CA</option>
            <option value="Review Installment AZ"  <?php if ($status == 'Review Installment AZ') echo 'selected'; ?>>Review Installment AZ</option>
            <option value="Review Installment NV"  <?php if ($status == 'Review Installment NV') echo 'selected'; ?>>Review Installment NV</option>
            <option value="Review Installment IL"  <?php if ($status == 'Review Installment IL') echo 'selected'; ?>>Review Installment IL</option>
            <option value="DL/Bank Payday CA"      <?php if ($status == 'DL/Bank Payday CA') echo 'selected'; ?>>DL/Bank Payday CA</option>
            <option value="DL/Bank Payday NV"      <?php if ($status == 'DL/Bank Payday NV') echo 'selected'; ?>>DL/Bank Payday NV</option>
            <option value="DL/Bank Payday IL"      <?php if ($status == 'DL/Bank Payday IL') echo 'selected'; ?>>DL/Bank Payday IL</option>
            <option value="DL/Bank Installment CA" <?php if ($status == 'DL/Bank Installment CA') echo 'selected'; ?>>DL/Bank Installment CA</option>
            <option value="DL/Bank Installment AZ" <?php if ($status == 'DL/Bank Installment AZ') echo 'selected'; ?>>DL/Bank Installment AZ</option>
            <option value="DL/Bank Installment NV" <?php if ($status == 'DL/Bank Installment NV') echo 'selected'; ?>>DL/Bank Installment NV</option>
            <option value="DL/Bank Installment IL" <?php if ($status == 'DL/Bank Installment IL') echo 'selected'; ?>>DL/Bank Installment IL</option>
        </select>
    </td>

    <td colspan="2" style="font-weight: bold;">
        State
        <select name="state" id="state" class="form-control" value="" style="padding: 6px 15px;">
            <option value="All" <?php if ($state == 'All') echo 'selected'; ?>>All</option>
            <option value="CA"  <?php if ($state == 'CA')  echo 'selected'; ?>>California</option>
            <option value="NV"  <?php if ($state == 'NV')  echo 'selected'; ?>>Nevada</option>
            <option value="AZ"  <?php if ($state == 'AZ')  echo 'selected'; ?>>Arizona</option>
            <option value="IL"  <?php if ($state == 'IL')  echo 'selected'; ?>>Illinois</option>
        </select>
    </td>

    <td colspan="2" style="font-weight: bold;">
        Application Type
        <select name="loan_type" id="loan_type" class="form-control" value="" style="padding: 6px 15px;">
            <option value="All"         <?php if ($loan_type == 'All')         echo 'selected'; ?>>All</option>
            <option value="payday"      <?php if ($loan_type == 'payday')      echo 'selected'; ?>>payday</option>
            <option value="installment" <?php if ($loan_type == 'installment') echo 'selected'; ?>>installment</option>
            <option value="commercial"  <?php if ($loan_type == 'commercial')  echo 'selected'; ?>>commercial</option>
        </select>
    </td>

    <td colspan="2" style="font-weight: bold;">
        Keyword Search
        <input type="text" id="search" class="form-control" name="keyword" placeholder="" value="<?php echo h($keyword); ?>">
    </td>

    <td colspan="2" style="font-weight: bold;">
        Application Date From:
        <input type="date" id="from_date" class="form-control" name="from_date" placeholder="" value="<?php echo h($from_date); ?>" style="line-height:20px">
    </td>

    <td colspan="2" style="font-weight: bold;">
        Application Date To:
        <input type="date" id="to_date" class="form-control" name="to_date" placeholder="" value="<?php echo h($to_date); ?>" style="line-height:20px">
    </td>

    <td colspan="1">
        <button style="background-color: #1E90FF;color: white;border-color: #1E90FF;" name="search" type="submit" class="btn btn-danger">Search</button>
    </td>
</tr>
</thead>
</table>

<div style="width:100%; margin:0 auto;">

<table class="table table-striped table-bordered" style="font-size:16px !important">
    <div style="text-align:center;margin-top: -22px;">
        <span style="font-size:13px" class="glyphicon glyphicon-filter" aria-hidden="true"></span>
        <?php
        $base_qs = "status=" . urlencode($status) . "&state=" . urlencode($state) . "&loan_type=" . urlencode($loan_type) . "&keyword=" . urlencode($keyword);
        $td = date('Y-m-d');
        echo " -<a href='view_all_customer.php?{$base_qs}&from_date=$td&to_date=$td'> Today </a> ";
        $yd = date('Y-m-d', strtotime('-1 day'));
        echo " -<a href='view_all_customer.php?{$base_qs}&from_date=$yd&to_date=$yd'> Yesterday </a> ";
        $l3 = date('Y-m-d', strtotime('-3 day'));
        echo " -<a href='view_all_customer.php?{$base_qs}&from_date=$l3&to_date=$td'> Last 3 Days </a> ";
        $l7 = date('Y-m-d', strtotime('-7 day'));
        echo " -<a href='view_all_customer.php?{$base_qs}&from_date=$l7&to_date=$td'> Last 7 Days </a> ";
        $fm = date('Y-m-d', strtotime('first day of this month'));
        echo " -<a href='view_all_customer.php?{$base_qs}&from_date=$fm&to_date=$td'> This Month </a> ";
        $fy = date('Y') . '-01-01';
        echo " -<a href='view_all_customer.php?{$base_qs}&from_date=$fy&to_date=$td'> This Year </a> ";
        ?>
    </div>
    <thead>
    <tr style="background-color: #F5E09E;color: white;">
        <th style='width:7%;color:black;'>ID</th>
        <th style='width:13%;color:black;'>Application Date</th>
        <th style='width:15%;color:black;'>First Name</th>
        <th style='width:15%;color:black;'>Last Name</th>
        <th style='width:10%;color:black;'>Phone #</th>
        <th style='width:6%;color:black;'>State</th>
        <th style='width:9%;color:black;'>App Type</th>
        <th style='width:15%;color:black;'>Application Status</th>
        <th style='width:10%;color:black;'>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $page_no = max(1, (int)($_GET['page_no'] ?? 1));
    $total_records_per_page = 100;
    $offset = ($page_no - 1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = 2;

    $total_no_of_pages = max(1, (int)ceil($rowcount / $total_records_per_page));
    $second_last = $total_no_of_pages - 1;

    $delete_customer_string = "page_no={$page_no}&status=" . urlencode($status) . "&state=" . urlencode($state) . "&loan_type=" . urlencode($loan_type) . "&keyword=" . urlencode($keyword) . "&from_date=" . urlencode($from_date) . "&to_date=" . urlencode($to_date);
    $delete_customer_pagination = "status=" . urlencode($status) . "&keyword=" . urlencode($keyword) . "&state=" . urlencode($state) . "&loan_type=" . urlencode($loan_type) . "&from_date=" . urlencode($from_date) . "&to_date=" . urlencode($to_date);

    include('db.php');

    // Fetch the page of results using same WHERE + pagination
    $page_params = array_merge($search_params, [$offset, $total_records_per_page]);
    $result = $con->query(
        "SELECT * FROM fnd_user_profile" . $where_sql . " ORDER BY user_fnd_id DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY",
        $page_params
    );

    $count = 1 + (100 * ($page_no - 1));
    $decision_logic_Status = '';
    $experian_credit_score = '';

    while ($result && ($row = $result->fetch_array())) {
        $id = $row['user_fnd_id'];
        $safe_id = (int)$id;
        $cr_date = $row['creation_date'];
        $created_time = $row['created_time_'];
        $lang = $row['lang'];
        $bold_status = $row['bold_status'];
        $newDate = date("m-d-y", strtotime((string)$cr_date));

        $image_lang = ($lang == 'en')
            ? "<img src='imgs/en.png' style='height:auto; width:auto' />"
            : "<img src='imgs/es.png' style='height:auto; width:auto' />";

        $string_red_rejected = '';
        $app_status = $row['application_status'];
        if ($app_status == 'Declined' || $app_status == 'Rejected By Customer') {
            $string_red_rejected = 'style="color:red"';
        } elseif ($app_status == 'Decision Logic Completed' || $app_status == 'Credit Report Needed' || $app_status == 'Pending Documents') {
            $string_red_rejected = 'style="color:#b8bb01"';
        } elseif ($app_status == 'Final Review') {
            $string_red_rejected = 'style="color:orange"';
        } elseif ($app_status == 'Approved Payday Loan' || $app_status == 'Approved Personal Loan' || $app_status == 'Approved Title Loan') {
            $string_red_rejected = 'style="color:green"';
        } elseif ($app_status == 'No Answer') {
            $string_red_rejected = 'style="color:#9370DB"';
        } elseif ($app_status == 'Funded') {
            $string_red_rejected = 'style="color:black"';
        }

        if (!empty($row['decision_logic_status']) && $row['decision_logic_status'] > 0) {
            $decision_logic_Status = ' <span class="glyphicon glyphicon-ok-circle" style="color:green"></span> ';
        }
        if (!empty($row['experian_credit_score']) && $row['experian_credit_score'] > 100 && $row['experian_credit_score'] < 9999) {
            $experian_credit_score = ' <span class="glyphicon glyphicon-ok-circle" style="color:red"></span> ';
        }

        $bold_app = ($bold_status == '0') ? 'style="font-weight:bold"' : 'style="font-size:16px !important"';

        echo "<tr {$string_red_rejected} {$bold_app}>
                  <td>{$image_lang} {$safe_id}</td>
                  <td>" . h($newDate) . " " . h($created_time) . "</td>
                  <td>" . h($row['first_name']) . "</td>
                  <td>" . h($row['last_name']) . "</td>
                  <td>" . h($row['mobile_number']) . "</td>
                  <td>" . h($row['state']) . "</td>
                  <td>" . h($row['loan_type']) . "</td>
                  <td>" . h($app_status) . "</td>
                  <td>
                    <a href='edit_customer.php?id={$safe_id}&{$delete_customer_string}' title='Edit This Customer'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='remove-box' href='delete_customer.php?id={$safe_id}&{$delete_customer_string}' title='Delete This Customer'><span class='glyphicon glyphicon-remove'></span>{$decision_logic_Status}{$experian_credit_score}</a>
                    <a href='customer_loan_history.php?id={$safe_id}' title='Loan History'><span class='glyphicon glyphicon-collapse-up'></span></a>
                  </td>
              </tr>";
        $decision_logic_Status = '';
        $experian_credit_score = '';
    }
    $con->close();
    ?>
    </tbody>
</table>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
    <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
    <li <?php if ($page_no <= 1) echo "class='disabled'"; ?>>
        <a <?php if ($page_no > 1) echo "href='?page_no={$previous_page}&{$delete_customer_pagination}'"; ?>>Previous</a>
    </li>
    <?php
    if ($total_no_of_pages <= 10) {
        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
            if ($counter == $page_no) {
                echo "<li class='active'><a>{$counter}</a></li>";
            } else {
                echo "<li><a href='?page_no={$counter}&{$delete_customer_pagination}'>{$counter}</a></li>";
            }
        }
    } elseif ($total_no_of_pages > 10) {
        if ($page_no <= 4) {
            for ($counter = 1; $counter < 8; $counter++) {
                if ($counter == $page_no) echo "<li class='active'><a>{$counter}</a></li>";
                else echo "<li><a href='?page_no={$counter}&{$delete_customer_pagination}'>{$counter}</a></li>";
            }
            echo "<li><a>...</a></li>";
            echo "<li><a href='?page_no={$second_last}&{$delete_customer_pagination}'>{$second_last}</a></li>";
            echo "<li><a href='?page_no={$total_no_of_pages}&{$delete_customer_pagination}'>{$total_no_of_pages}</a></li>";
        } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
            echo "<li><a href='?page_no=1&{$delete_customer_pagination}'>1</a></li>";
            echo "<li><a href='?page_no=2&{$delete_customer_pagination}'>2</a></li>";
            echo "<li><a>...</a></li>";
            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                if ($counter == $page_no) echo "<li class='active'><a>{$counter}</a></li>";
                else echo "<li><a href='?page_no={$counter}&{$delete_customer_pagination}'>{$counter}</a></li>";
            }
            echo "<li><a>...</a></li>";
            echo "<li><a href='?page_no={$second_last}&{$delete_customer_pagination}'>{$second_last}</a></li>";
            echo "<li><a href='?page_no={$total_no_of_pages}&{$delete_customer_pagination}'>{$total_no_of_pages}</a></li>";
        } else {
            echo "<li><a href='?page_no=1&{$delete_customer_pagination}'>1</a></li>";
            echo "<li><a href='?page_no=2&{$delete_customer_pagination}'>2</a></li>";
            echo "<li><a>...</a></li>";
            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                if ($counter == $page_no) echo "<li class='active'><a>{$counter}</a></li>";
                else echo "<li><a href='?page_no={$counter}&{$delete_customer_pagination}'>{$counter}</a></li>";
            }
        }
    }
    ?>
    <li <?php if ($page_no >= $total_no_of_pages) echo "class='disabled'"; ?>>
        <a <?php if ($page_no < $total_no_of_pages) echo "href='?page_no={$next_page}&{$delete_customer_pagination}'"; ?>>Next</a>
    </li>
    <?php if ($page_no < $total_no_of_pages) {
        echo "<li><a href='?page_no={$total_no_of_pages}&{$delete_customer_pagination}'>Last &rsaquo;&rsaquo;</a></li>";
    } ?>
</ul>

<br /><br />
</div>
</form>
</section>

<style>
    .navbar-default { background-color: #fb3f06 !important; }
</style>

<script type="text/javascript">
    $('.remove-box').on('click', function () {
        var x = confirm('Are you sure you want to delete?');
        return !!x;
    });
</script>

</body>
</html>
