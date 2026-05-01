<?php
/**
 * Sidebar for commercial-loan detail pages.
 * Grouped into four logical sections, icons on every item, the current
 * page gets highlighted as `.lcnav-active`.
 */
$__lcnav_current = basename($_SERVER['PHP_SELF'] ?? '');
$__lcnav_id      = isset($id) ? $id : ($_GET['id'] ?? '');
$__lcnav_qs      = '?id=' . urlencode((string)$__lcnav_id);

$__lcnav_sections = [
    'Overview' => [
        ['loan_summary.php',       'Loan Summary',          'glyphicon-list-alt'],
        ['user_information.php',   "Customer's Information",'glyphicon-user'],
        ['user_loan_history.php',  'Loan History',          'glyphicon-time'],
    ],
    'Activity' => [
        ['notes_for_loan.php',         'Notes',            'glyphicon-pencil'],
        ['view_all_ptp.php',           'PTP',              'glyphicon-calendar'],
        ['view_all_installments.php',  'Installments',     'glyphicon-usd'],
        ['loan_status_activity_log.php','Log Activity',    'glyphicon-tasks'],
    ],
    'Details' => [
        ['view_all_bank_info.php',  'Bank Information',      'glyphicon-credit-card'],
        ['employer_detail.php',     'Job Information',       'glyphicon-briefcase'],
        ['business_information.php','Business Information',  'glyphicon-tower'],
        ['vehicle_information.php', 'Vehicle Information',   'glyphicon-road'],
    ],
    'Advanced' => [
        ['user_files.php',              'Documentation',       'glyphicon-folder-open'],
        ['decision_logic.php',          'Decision Logic',      'glyphicon-stats'],
        ['add_late_installment_fee.php','Late Fee Settings',   'glyphicon-cog'],
    ],
];
?>
<style>
    /* Scoped sidebar styles — only apply under #sidebar-wrapper */
    #sidebar-wrapper .lcnav {
        padding: 12px 0 18px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    #sidebar-wrapper .lcnav-section {
        margin-bottom: 14px;
    }
    #sidebar-wrapper .lcnav-section-title {
        font-size: 10px; font-weight: 700; color: #888;
        text-transform: uppercase; letter-spacing: .8px;
        padding: 4px 16px 6px; margin: 0;
    }
    #sidebar-wrapper .lcnav-item {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 16px 9px 14px;
        font-size: 13.5px; color: #37474f;
        text-decoration: none !important;
        border-left: 3px solid transparent;
        background: #fff;
        transition: background-color .12s ease, border-left-color .12s ease, color .12s ease;
    }
    #sidebar-wrapper .lcnav-item:hover {
        background: #f0f6fc;
        color: #1976d2;
        border-left-color: #bbdefb;
    }
    #sidebar-wrapper .lcnav-item .glyphicon {
        font-size: 13px; width: 16px; text-align: center; color: #90a4ae;
        flex: 0 0 16px;
    }
    #sidebar-wrapper .lcnav-item:hover .glyphicon { color: #1976d2; }

    #sidebar-wrapper .lcnav-active,
    #sidebar-wrapper .lcnav-active:hover {
        background: #e3f2fd;
        color: #0d47a1;
        border-left-color: #1976d2;
        font-weight: 600;
    }
    #sidebar-wrapper .lcnav-active .glyphicon { color: #1976d2; }
</style>

<nav class="lcnav" aria-label="Loan navigation">
    <?php foreach ($__lcnav_sections as $__section => $__items): ?>
        <div class="lcnav-section">
            <div class="lcnav-section-title"><?php echo htmlspecialchars($__section); ?></div>
            <?php foreach ($__items as $__it):
                [$__href, $__label, $__icon] = $__it;
                $__active = ($__lcnav_current === $__href) ? ' lcnav-active' : '';
            ?>
                <a href="<?php echo htmlspecialchars($__href . $__lcnav_qs); ?>"
                   class="lcnav-item<?php echo $__active; ?>">
                    <span class="glyphicon <?php echo htmlspecialchars($__icon); ?>" aria-hidden="true"></span>
                    <span><?php echo htmlspecialchars($__label); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</nav>
