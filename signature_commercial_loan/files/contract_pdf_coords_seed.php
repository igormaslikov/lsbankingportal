<?php
/**
 * Phase A seed — inserts every coordinate that the old contract_pdf_templates.php
 * had hardcoded into the contract_field_coords table. Idempotent: uses
 * INSERT ... ON DUPLICATE KEY UPDATE so re-running resets to seed values.
 *
 * CLI:   php contract_pdf_coords_seed.php
 * HTTP:  hit /signature_commercial_loan/files/contract_pdf_coords_seed.php?go=1
 *        (requires admin session — or run from CLI)
 */

session_start();
$_SESSION['Optima'] = 'true';
require __DIR__ . '/dbconnect.php';
require __DIR__ . '/dbconfig.php';

// Helper to build a seed row compactly.
function row($tpl, $pg, $key, $x, $y, $w, $h = 5, $font = 9, $type = 'text', $align = 'C') {
    return compact('tpl','pg','key','x','y','w','h','font','type','align');
}

// ---- UNSECURED (35 pages) ----
$rows = [];

/* pages 1 (EN) and 2 (ES) — same layout. Generated per-row-y. */
$app_rows_unsec = [
    // [y-index 0..11 => y_mm]
    0 => 45, 1 => 56, 2 => 67, 3 => 78, 4 => 89,
    5 => 109, 6 => 120, 7 => 132, 8 => 142,
    9 => 164, 10 => 174, 11 => 185,
];
$sig_unsec = ['app' => 214, 'coapp' => 240];

// Secured has its own per-page row tables
$app_rows_sec_en = [0=>32, 1=>43, 2=>54, 3=>66, 4=>77, 5=>96, 6=>108, 7=>119, 8=>130, 9=>151, 10=>162, 11=>172];
$sig_sec_en      = ['app'=>240, 'coapp'=>256];
$veh_rows_sec_en = [0=>195, 1=>204, 2=>213];

$app_rows_sec_es = [0=>39, 1=>50, 2=>62, 3=>73, 4=>84, 5=>103, 6=>114, 7=>126, 8=>137, 9=>157, 10=>168, 11=>179];
$sig_sec_es      = ['app'=>243, 'coapp'=>258];
$veh_rows_sec_es = [0=>198, 1=>207, 2=>216];

/** Emit the standard application-rows field set for a given template+page. */
function emit_app_rows(array &$rows, $tpl, $pg, array $y, array $sig) {
    // Row 0 — First/Last/SSN
    $rows[] = row($tpl, $pg, 'app.first_name',      29, $y[0], 52);
    $rows[] = row($tpl, $pg, 'app.last_name',       95, $y[0], 52);
    $rows[] = row($tpl, $pg, 'app.ssn',            168, $y[0], 38);
    // Row 1 — Address / ID
    $rows[] = row($tpl, $pg, 'app.address',         29, $y[1],105);
    $rows[] = row($tpl, $pg, 'app.id_number',      188, $y[1], 38);
    // Row 2 — City/State/Zip/DOB
    $rows[] = row($tpl, $pg, 'app.city',            25, $y[2], 50);
    $rows[] = row($tpl, $pg, 'app.state',           80, $y[2], 20);
    $rows[] = row($tpl, $pg, 'app.zip',            115, $y[2], 30);
    $rows[] = row($tpl, $pg, 'app.dob',            165, $y[2], 40);
    // Row 3 — Cellphone/Alt/email
    $rows[] = row($tpl, $pg, 'app.cellphone',       28, $y[3], 52);
    $rows[] = row($tpl, $pg, 'app.alt_number',      93, $y[3], 40);
    $rows[] = row($tpl, $pg, 'app.email',          133, $y[3], 72);
    // Row 4 — Where heard / Loan Amount
    $rows[] = row($tpl, $pg, 'app.source_lead',     60, $y[4], 40);
    $rows[] = row($tpl, $pg, 'app.loan_amount',    158, $y[4], 45);
    // Row 5 — Co-app Last/First/SSN
    $rows[] = row($tpl, $pg, 'app.coapp_last_name', 29, $y[5], 52);
    $rows[] = row($tpl, $pg, 'app.coapp_first_name',95, $y[5], 52);
    $rows[] = row($tpl, $pg, 'app.coapp_ssn',      168, $y[5], 38);
    // Row 6 — Co-app Address / ID
    $rows[] = row($tpl, $pg, 'app.coapp_address',   29, $y[6],105);
    $rows[] = row($tpl, $pg, 'app.coapp_id_number',188, $y[6], 38);
    // Row 7 — Co-app City/State/Zip/DOB
    $rows[] = row($tpl, $pg, 'app.coapp_city',      25, $y[7], 50);
    $rows[] = row($tpl, $pg, 'app.coapp_state',     80, $y[7], 20);
    $rows[] = row($tpl, $pg, 'app.coapp_zip',      115, $y[7], 30);
    $rows[] = row($tpl, $pg, 'app.coapp_dob',      165, $y[7], 40);
    // Row 8 — Co-app phones
    $rows[] = row($tpl, $pg, 'app.coapp_cellphone', 28, $y[8], 52);
    $rows[] = row($tpl, $pg, 'app.coapp_alt_number',93, $y[8], 40);
    $rows[] = row($tpl, $pg, 'app.coapp_email',    133, $y[8], 72);
    // Row 9 — Biz Name / Type
    $rows[] = row($tpl, $pg, 'app.biz_name',        33, $y[9], 85);
    $rows[] = row($tpl, $pg, 'app.biz_type',       175, $y[9], 30);
    // Row 10 — Biz Address / Monthly Income
    $rows[] = row($tpl, $pg, 'app.biz_address',     33, $y[10],85);
    $rows[] = row($tpl, $pg, 'app.biz_monthly_income',175,$y[10],30);
    // Row 11 — Biz City/State/Zip/Phone
    $rows[] = row($tpl, $pg, 'app.biz_city',        25, $y[11],35);
    $rows[] = row($tpl, $pg, 'app.biz_state',       70, $y[11],25);
    $rows[] = row($tpl, $pg, 'app.biz_zip',        110, $y[11],25);
    $rows[] = row($tpl, $pg, 'app.biz_phone',      150, $y[11],45);
    // Signatures — FPDF renders PNGs at -200 DPI, so a typical signature from
    // the sign canvas comes out ~15mm tall. Place the image so its BOTTOM
    // lands on the X-signature line: top = sig_line - 15.
    $rows[] = row($tpl, $pg, 'app.signature_img',          30, $sig['app']-15,   60, 15, 9, 'image');
    $rows[] = row($tpl, $pg, 'app.signature_date',        155, $sig['app']+1,    45);
    $rows[] = row($tpl, $pg, 'app.coapp_signature_img',    30, $sig['coapp']-15, 60, 15, 9, 'image');
    $rows[] = row($tpl, $pg, 'app.coapp_signature_date',  155, $sig['coapp']+1,  45);
}

function emit_vehicle_block(array &$rows, $tpl, $pg, array $y) {
    $rows[] = row($tpl, $pg, 'veh.year',       25, $y[0], 55);
    $rows[] = row($tpl, $pg, 'veh.make',      105, $y[0], 55);
    $rows[] = row($tpl, $pg, 'veh.model',     175, $y[0], 55);
    $rows[] = row($tpl, $pg, 'veh.vin',        25, $y[1], 55);
    $rows[] = row($tpl, $pg, 'veh.plate',     105, $y[1], 55);
    $rows[] = row($tpl, $pg, 'veh.odometer',  175, $y[1], 55);
    $rows[] = row($tpl, $pg, 'veh.color',      25, $y[2], 55);
    $rows[] = row($tpl, $pg, 'veh.body_style',105, $y[2], 55);
    $rows[] = row($tpl, $pg, 'veh.kbb',       175, $y[2], 55);
}

function emit_header_trio(array &$rows, $tpl, $pg, $yName, $yLoan, $yDate) {
    $rows[] = row($tpl, $pg, 'header.borrower_name', 75, $yName, 100);
    $rows[] = row($tpl, $pg, 'header.loan_number',   75, $yLoan, 100);
    $rows[] = row($tpl, $pg, 'header.date',          75, $yDate, 100);
}

// ==================== UNSECURED coords ====================
$TPL = 'unsecured_2024_09_01';
emit_app_rows($rows, $TPL, 1, $app_rows_unsec, $sig_unsec);
emit_app_rows($rows, $TPL, 2, $app_rows_unsec, $sig_unsec);

// Unsec Promissory Note (pg 3 EN / pg 5 ES) — identical layout
foreach ([3, 5] as $pg) {
    $rows[] = row($TPL, $pg, 'loan.contract_no', 40, 14, 55);
    $rows[] = row($TPL, $pg, 'loan.date',       165, 16, 30);
    $rows[] = row($TPL, $pg, 'loan.borrower_line1',   40, 19, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.borrower_line2',   40, 24, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.borrower_line3',   40, 29, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.coborrower_line1', 40, 34, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.coborrower_line2', 40, 39, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.coborrower_line3', 40, 44, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.business_line1',   40, 48, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.business_line2',   40, 53, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.business_line3',   40, 58, 75, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.apr',              26, 83, 28);
    $rows[] = row($TPL, $pg, 'loan.principal',        65, 83, 38);
    $rows[] = row($TPL, $pg, 'loan.total_interest',  113, 83, 38);
    $rows[] = row($TPL, $pg, 'loan.total_payments',  151, 83, 38);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_first_num',      75, 106, 15);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_first_date',    120, 106, 35);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_beginning_date',153, 106, 30);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_count',          75, 114, 15);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_each_date',     120, 114, 22);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_last_date',     120, 121, 35);
    $rows[] = row($TPL, $pg, 'loan.contract_fee',             85, 139, 22);
    $rows[] = row($TPL, $pg, 'loan.itemization_given',       170, 158, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_paid',        170, 163, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_financed',    170, 167, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_prepaid',     170, 171, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_principal',   170, 175, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.initials_img',            180, 248, 40, 10, 9, 'image');
}

// Unsec Signature pages (pg 4 EN, pg 6 ES)
foreach ([4, 6] as $pg) {
    $rows[] = row($TPL, $pg, 'header.borrower_name',    75, 35, 100);
    $rows[] = row($TPL, $pg, 'header.loan_number',      75, 41, 100);
    $rows[] = row($TPL, $pg, 'onsite.physical_address', 78,155, 115);
    $rows[] = row($TPL, $pg, 'signature.borrower_img',  18, 220, 60, 15, 9, 'image');
    $rows[] = row($TPL, $pg, 'signature.borrower_date', 82, 240, 40);
    $rows[] = row($TPL, $pg, 'signature.coborrower_img',18, 237, 60, 15, 9, 'image');
    $rows[] = row($TPL, $pg, 'signature.coborrower_date',82, 256, 40);
}

// Unsec continuation header trio (pages 7-13)
for ($pg = 7; $pg <= 13; $pg++) emit_header_trio($rows, $TPL, $pg, 20, 26, 32);

// Unsec ACH (pages 14, 15)
foreach ([14, 15] as $pg) {
    emit_header_trio($rows, $TPL, $pg, 20, 26, 32);
    $rows[] = row($TPL, $pg, 'ach.account_number',      25, 100, 40);
    $rows[] = row($TPL, $pg, 'ach.bank_name',           80, 100, 60);
    $rows[] = row($TPL, $pg, 'ach.payment_amount',     150, 100, 30);
    $rows[] = row($TPL, $pg, 'ach.first_payment_date',  50, 110, 40);
    $rows[] = row($TPL, $pg, 'signature.borrower_img',  30, 218, 60, 15, 9, 'image');
    $rows[] = row($TPL, $pg, 'ach.borrower_printed_name',15,248, 60);
}

// Pages 16-35: static (no overlays needed)

// ==================== SECURED coords ====================
$TPL = 'secured';

emit_app_rows($rows, $TPL, 1, $app_rows_sec_en, $sig_sec_en);
emit_vehicle_block($rows, $TPL, 1, $veh_rows_sec_en);
emit_app_rows($rows, $TPL, 2, $app_rows_sec_es, $sig_sec_es);
emit_vehicle_block($rows, $TPL, 2, $veh_rows_sec_es);

// Sec Promissory Note cover (pg 3 EN / pg 13 ES) — SAME layout for both
foreach ([3, 13] as $pg) {
    $rows[] = row($TPL, $pg, 'loan.date',        124, 29, 40);
    $rows[] = row($TPL, $pg, 'loan.contract_no',  40, 30, 50);
    $rows[] = row($TPL, $pg, 'loan.borrower_line1',   40, 35, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.borrower_line2',   40, 40, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.borrower_line3',   40, 45, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.coborrower_line1', 40, 50, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.coborrower_line2', 40, 55, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.coborrower_line3', 40, 59, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.business_line1',   40, 64, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.business_line2',   40, 69, 60, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.business_line3',   40, 74, 60, 4, 8);
    // Vehicle block inline on promissory (secured only)
    $rows[] = row($TPL, $pg, 'veh.make',               95, 108, 40, 4, 8);
    $rows[] = row($TPL, $pg, 'veh.vin',               155, 108, 40, 4, 8);
    $rows[] = row($TPL, $pg, 'veh.year',               95, 115, 40, 4, 8);
    $rows[] = row($TPL, $pg, 'veh.model',             130, 115, 40, 4, 8);
    $rows[] = row($TPL, $pg, 'veh.color',             155, 115, 40, 4, 8);
    $rows[] = row($TPL, $pg, 'veh.odometer',           95, 122, 40, 4, 8);
    $rows[] = row($TPL, $pg, 'veh.plate',             130, 122, 40, 4, 8);
    $rows[] = row($TPL, $pg, 'veh.body_style',        160, 122, 40, 4, 8);
    // TIL row
    $rows[] = row($TPL, $pg, 'loan.apr',              30, 168, 28);
    $rows[] = row($TPL, $pg, 'loan.principal',        76, 168, 38);
    $rows[] = row($TPL, $pg, 'loan.total_interest',  120, 168, 38);
    $rows[] = row($TPL, $pg, 'loan.total_payments',  164, 168, 38);
    // Payment schedule
    $rows[] = row($TPL, $pg, 'loan.pay_sched_first_num',      70, 199, 15);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_first_date',    115, 199, 22);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_beginning_date',150, 199, 40);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_count',          70, 207, 15);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_each_date',     115, 207, 30);
    $rows[] = row($TPL, $pg, 'loan.pay_sched_last_date',     125, 215, 40);
    // Itemization
    $rows[] = row($TPL, $pg, 'loan.itemization_given',       180, 230, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_paid',        180, 235, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_financed',    180, 239, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_prepaid',     180, 244, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_gps',         180, 248, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.itemization_principal',   180, 253, 30, 4, 8);
    $rows[] = row($TPL, $pg, 'loan.initials_img',            180, 256, 40, 10, 9, 'image');
}

// Sec English continuation (pages 4-12) header trio
for ($pg = 4; $pg <= 12; $pg++) emit_header_trio($rows, $TPL, $pg, 13, 18, 22);

// Sec Spanish continuation (pages 14-23) header trio
for ($pg = 14; $pg <= 23; $pg++) emit_header_trio($rows, $TPL, $pg, 13, 18, 22);

// Sec Vehicle pages (pg 24 EN / pg 25 ES)
foreach ([24, 25] as $pg) {
    $rows[] = row($TPL, $pg, 'veh.account_number', 52, 27, 50);
    $rows[] = row($TPL, $pg, 'veh.summary',       145, 27, 55);
    $rows[] = row($TPL, $pg, 'header.borrower_name',52, 35, 60);
    $rows[] = row($TPL, $pg, 'veh.vin',           145, 35, 55);
    $rows[] = row($TPL, $pg, 'veh.plate',         145, 43, 55);
    $rows[] = row($TPL, $pg, 'signature.borrower_date',  125, 214, 40);
    $rows[] = row($TPL, $pg, 'signature.borrower_img',    15, 216, 60, 15, 9, 'image');
    $rows[] = row($TPL, $pg, 'signature.coborrower_date',125, 238, 40);
    $rows[] = row($TPL, $pg, 'signature.coborrower_img',  15, 240, 60, 15, 9, 'image');
}

// Sec bilingual last-continuation (pg 26, 27)
foreach ([26, 27] as $pg) emit_header_trio($rows, $TPL, $pg, 14, 18, 23);

// Pages 28-47: static (no overlays)

// ==================== INSERT ====================
$stmt = mysqli_prepare($con, "INSERT INTO contract_field_coords
    (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    field_type=VALUES(field_type), x_mm=VALUES(x_mm), y_mm=VALUES(y_mm),
    w_mm=VALUES(w_mm), h_mm=VALUES(h_mm),
    font_size=VALUES(font_size), align=VALUES(align)");
if (!$stmt) { die('prepare failed: ' . mysqli_error($con)); }

$count = 0;
foreach ($rows as $r) {
    mysqli_stmt_bind_param($stmt, 'sissddddis',
        $r['tpl'], $r['pg'], $r['key'], $r['type'],
        $r['x'], $r['y'], $r['w'], $r['h'], $r['font'], $r['align']
    );
    if (mysqli_stmt_execute($stmt)) $count++;
}
echo "Inserted/updated $count rows across " . count($rows) . " seed entries.\n";
