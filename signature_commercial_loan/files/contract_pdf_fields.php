<?php
/**
 * Phase A — Field catalog + value resolver for data-driven contract rendering.
 *
 * Exports:
 *   $CONTRACT_FIELD_CATALOG   — array of field_key => ['label','type'].
 *   build_context_from_globals() — snapshot every relevant global from
 *                                   contract_pdf.php into an array.
 *   build_demo_context()        — realistic placeholder values for every field
 *                                   so the editor can preview a fully-populated
 *                                   PDF even when the real loan has gaps.
 *   resolve_field_value($key, $ctx) — returns string (or image path for images).
 */

$CONTRACT_FIELD_CATALOG = [
    // ---- Application: applicant identity ----
    'app.first_name'            => ['label' => 'Applicant: First Name',        'type' => 'text'],
    'app.last_name'             => ['label' => 'Applicant: Last Name',         'type' => 'text'],
    'app.ssn'                   => ['label' => 'Applicant: SSN/ITIN',          'type' => 'text'],
    'app.id_number'             => ['label' => 'Applicant: ID Number',         'type' => 'text'],
    'app.address'               => ['label' => 'Applicant: Address',           'type' => 'text'],
    'app.city'                  => ['label' => 'Applicant: City',              'type' => 'text'],
    'app.state'                 => ['label' => 'Applicant: State',             'type' => 'text'],
    'app.zip'                   => ['label' => 'Applicant: Zip Code',          'type' => 'text'],
    'app.dob'                   => ['label' => 'Applicant: DOB',               'type' => 'text'],
    'app.cellphone'             => ['label' => 'Applicant: Cellphone',         'type' => 'text'],
    'app.alt_number'            => ['label' => 'Applicant: Alternative Number','type' => 'text'],
    'app.email'                 => ['label' => 'Applicant: e-Mail',            'type' => 'text'],
    'app.source_lead'           => ['label' => 'Applicant: Where heard about us', 'type' => 'text'],
    'app.loan_amount'           => ['label' => 'Applicant: Loan Amount',       'type' => 'text'],
    'app.signature_img'         => ['label' => 'Applicant: Signature (image)', 'type' => 'image'],
    'app.signature_date'        => ['label' => 'Applicant: Signature Date',    'type' => 'text'],

    // ---- Application: co-applicant ----
    'app.coapp_first_name'      => ['label' => 'Co-Applicant: First Name',     'type' => 'text'],
    'app.coapp_last_name'       => ['label' => 'Co-Applicant: Last Name',      'type' => 'text'],
    'app.coapp_ssn'             => ['label' => 'Co-Applicant: SSN/ITIN',       'type' => 'text'],
    'app.coapp_id_number'       => ['label' => 'Co-Applicant: ID Number',      'type' => 'text'],
    'app.coapp_address'         => ['label' => 'Co-Applicant: Address',        'type' => 'text'],
    'app.coapp_city'            => ['label' => 'Co-Applicant: City',           'type' => 'text'],
    'app.coapp_state'           => ['label' => 'Co-Applicant: State',          'type' => 'text'],
    'app.coapp_zip'             => ['label' => 'Co-Applicant: Zip Code',       'type' => 'text'],
    'app.coapp_dob'             => ['label' => 'Co-Applicant: DOB',            'type' => 'text'],
    'app.coapp_cellphone'       => ['label' => 'Co-Applicant: Cellphone',      'type' => 'text'],
    'app.coapp_alt_number'      => ['label' => 'Co-Applicant: Alt Number',     'type' => 'text'],
    'app.coapp_email'           => ['label' => 'Co-Applicant: e-Mail',         'type' => 'text'],
    'app.coapp_signature_img'   => ['label' => 'Co-Applicant: Signature (image)', 'type' => 'image'],
    'app.coapp_signature_date'  => ['label' => 'Co-Applicant: Signature Date', 'type' => 'text'],

    // ---- Application: business ----
    'app.biz_name'              => ['label' => 'Business: Name',               'type' => 'text'],
    'app.biz_type'              => ['label' => 'Business: Type',               'type' => 'text'],
    'app.biz_address'           => ['label' => 'Business: Address',            'type' => 'text'],
    'app.biz_monthly_income'    => ['label' => 'Business: Monthly Income',     'type' => 'text'],
    'app.biz_city'              => ['label' => 'Business: City',               'type' => 'text'],
    'app.biz_state'             => ['label' => 'Business: State',              'type' => 'text'],
    'app.biz_zip'               => ['label' => 'Business: Zip',                'type' => 'text'],
    'app.biz_phone'             => ['label' => 'Business: Phone',              'type' => 'text'],

    // ---- Vehicle (secured templates only) ----
    'veh.year'                  => ['label' => 'Vehicle: Year',                'type' => 'text'],
    'veh.make'                  => ['label' => 'Vehicle: Make',                'type' => 'text'],
    'veh.model'                 => ['label' => 'Vehicle: Model',               'type' => 'text'],
    'veh.vin'                   => ['label' => 'Vehicle: VIN',                 'type' => 'text'],
    'veh.plate'                 => ['label' => 'Vehicle: Plate',               'type' => 'text'],
    'veh.odometer'              => ['label' => 'Vehicle: Odometer',            'type' => 'text'],
    'veh.color'                 => ['label' => 'Vehicle: Color',               'type' => 'text'],
    'veh.body_style'            => ['label' => 'Vehicle: Body Style',          'type' => 'text'],
    'veh.kbb'                   => ['label' => 'Vehicle: KBB',                 'type' => 'text'],
    'veh.summary'               => ['label' => 'Vehicle: Year Make Model',     'type' => 'text'],
    'veh.account_number'        => ['label' => 'Vehicle: Account Number',      'type' => 'text'],

    // ---- Promissory Note block ----
    'loan.contract_no'          => ['label' => 'Loan: Contract No',            'type' => 'text'],
    'loan.date'                 => ['label' => 'Loan: Contract Date',          'type' => 'text'],
    'loan.borrower_line1'       => ['label' => 'Loan: Borrower line 1 (name)', 'type' => 'text'],
    'loan.borrower_line2'       => ['label' => 'Loan: Borrower line 2 (addr)', 'type' => 'text'],
    'loan.borrower_line3'       => ['label' => 'Loan: Borrower line 3 (city)', 'type' => 'text'],
    'loan.coborrower_line1'     => ['label' => 'Loan: Co-Borrower line 1',     'type' => 'text'],
    'loan.coborrower_line2'     => ['label' => 'Loan: Co-Borrower line 2',     'type' => 'text'],
    'loan.coborrower_line3'     => ['label' => 'Loan: Co-Borrower line 3',     'type' => 'text'],
    'loan.business_line1'       => ['label' => 'Loan: Business line 1',        'type' => 'text'],
    'loan.business_line2'       => ['label' => 'Loan: Business line 2',        'type' => 'text'],
    'loan.business_line3'       => ['label' => 'Loan: Business line 3',        'type' => 'text'],
    'loan.apr'                  => ['label' => 'Loan: APR',                    'type' => 'text'],
    'loan.principal'            => ['label' => 'Loan: Amount Financed ($)',    'type' => 'text'],
    'loan.total_interest'       => ['label' => 'Loan: Finance Charge ($)',     'type' => 'text'],
    'loan.total_payments'       => ['label' => 'Loan: Total of Payments ($)',  'type' => 'text'],
    'loan.pay_sched_first_num'  => ['label' => 'Loan: First Payment Number (literal 1)', 'type' => 'text'],
    'loan.pay_sched_first_date' => ['label' => 'Loan: First Payment Date',     'type' => 'text'],
    'loan.pay_sched_beginning_date' => ['label' => 'Loan: Payments begin on',  'type' => 'text'],
    'loan.pay_sched_count'      => ['label' => 'Loan: Number of recurring payments', 'type' => 'text'],
    'loan.pay_sched_each_date'  => ['label' => 'Loan: Recurring payment date / frequency', 'type' => 'text'],
    'loan.pay_sched_last_date'  => ['label' => 'Loan: Last Payment Date',      'type' => 'text'],
    'loan.contract_fee'         => ['label' => 'Loan: Origination / Contract Fee', 'type' => 'text'],
    'loan.itemization_given'    => ['label' => 'Loan: Itemization Amount Given',     'type' => 'text'],
    'loan.itemization_paid'     => ['label' => 'Loan: Itemization Amount Paid',      'type' => 'text'],
    'loan.itemization_financed' => ['label' => 'Loan: Itemization Amount Financed',  'type' => 'text'],
    'loan.itemization_prepaid'  => ['label' => 'Loan: Itemization Prepaid Finance',  'type' => 'text'],
    'loan.itemization_gps'      => ['label' => 'Loan: Itemization GPS Fee',    'type' => 'text'],
    'loan.itemization_principal'=> ['label' => 'Loan: Itemization Principal',  'type' => 'text'],
    'loan.initials_img'         => ['label' => 'Loan: Borrower Initials (image)',    'type' => 'image'],

    // ---- Per-page header band (continuation pages) ----
    'header.borrower_name'      => ['label' => 'Header: Borrower Name',        'type' => 'text'],
    'header.loan_number'        => ['label' => 'Header: Loan Number',          'type' => 'text'],
    'header.date'               => ['label' => 'Header: Date',                 'type' => 'text'],

    // ---- Signature blocks ----
    'signature.borrower_img'    => ['label' => 'Signature: Borrower (image)',  'type' => 'image'],
    'signature.borrower_date'   => ['label' => 'Signature: Borrower Date',     'type' => 'text'],
    'signature.coborrower_img'  => ['label' => 'Signature: Co-Borrower (image)','type' => 'image'],
    'signature.coborrower_date' => ['label' => 'Signature: Co-Borrower Date',  'type' => 'text'],

    // ---- "Onsite Payment at Borrower's physical address, being: ____" ----
    'onsite.physical_address'   => ['label' => 'Onsite Payment: Physical Address', 'type' => 'text'],

    // ---- ACH authorization band ----
    'ach.account_number'        => ['label' => 'ACH: Account Number',          'type' => 'text'],
    'ach.bank_name'             => ['label' => 'ACH: Bank Name',               'type' => 'text'],
    'ach.payment_amount'        => ['label' => 'ACH: Scheduled Debit Amount',  'type' => 'text'],
    'ach.first_payment_date'    => ['label' => 'ACH: First Payment Date',      'type' => 'text'],
    'ach.borrower_printed_name' => ['label' => 'ACH: Borrower printed name',   'type' => 'text'],
];

/**
 * Snapshot every global from contract_pdf.php into a portable context array.
 * Call this AFTER contract_pdf.php has run its fetch queries.
 */
function build_context_from_globals() {
    $g = ['ff_name','l_name','ssn','dob','id_number','address','city','state','zip',
          'mobile_number','alt_number','email_addr','source_lead',
          'co_borrow_full_name','co_borrow_phone','co_borrow_address',
          'co_borrow_city','co_borrow_state','co_borrow_zip',
          'business_name','business_phone','business_address',
          'business_city','business_state','business_zip',
          'business_monthly_income','business_type',
          'principal_f','principal','anual_pr','total_interest','total_payments_amount',
          'contract_fee','in_hand','count_payments','first_payment_date','last_payment_date',
          'loan_id_bor','creation_date','f_name',
          'signed_pic','sig_coborrow_pic','initial_pic',
          'bank_name','account_number','first_payment','fnd_id'];
    $ctx = [];
    foreach ($g as $name) {
        if (isset($GLOBALS[$name])) $ctx[$name] = $GLOBALS[$name];
    }
    // Load vehicle row once (used by veh.* keys)
    $ctx['veh'] = [];
    if (isset($GLOBALS['con'], $GLOBALS['fnd_id'])) {
        $fnd = $GLOBALS['fnd_id'];
        $vq = mysqli_query($GLOBALS['con'], "select * from tbl_vehicle_info where user_fnd_id='$fnd' limit 1");
        if ($vq && ($vr = mysqli_fetch_assoc($vq))) $ctx['veh'] = $vr;
    }
    return $ctx;
}

/** Full placeholder context for the editor "preview with demo data" button. */
function build_demo_context() {
    return [
        'ff_name' => 'John',
        'l_name' => 'Doe',
        'ssn' => '123-45-6789',
        'dob' => '1985-06-15',
        'id_number' => 'DL-A123456',
        'address' => '123 Main Street',
        'city' => 'Los Angeles',
        'state' => 'CA',
        'zip' => '90001',
        'mobile_number' => '555-123-4567',
        'alt_number' => '555-999-8888',
        'email_addr' => 'john.doe@example.com',
        'source_lead' => 'Google',
        'co_borrow_full_name' => 'Jane Smith',
        'co_borrow_phone' => '555-222-3333',
        'co_borrow_address' => '456 Oak Avenue',
        'co_borrow_city' => 'Pasadena',
        'co_borrow_state' => 'CA',
        'co_borrow_zip' => '91101',
        'business_name' => 'Demo Auto Repair LLC',
        'business_phone' => '555-777-6543',
        'business_address' => '789 Commerce Blvd',
        'business_city' => 'Burbank',
        'business_state' => 'CA',
        'business_zip' => '91502',
        'business_monthly_income' => 25000.00,
        'business_type' => 'Auto Repair',
        'principal_f' => 15000.00,
        'principal' => '15,000.00',
        'anual_pr' => '92.37',
        'total_interest' => '4,250.00',
        'total_payments_amount' => '19,250.00',
        'contract_fee' => 500.00,
        'in_hand' => 3000.00,
        'count_payments' => 24,
        'first_payment_date' => '06-15-2026',
        'last_payment_date' => '05-15-2028',
        'loan_id_bor' => 'OF1-99999',
        'creation_date' => '06-01-2026',
        'f_name' => 'John Doe',
        'signed_pic' => '',
        'sig_coborrow_pic' => '',
        'initial_pic' => '',
        'bank_name' => 'Bank Of America',
        'account_number' => '1234567',
        'first_payment' => 802.08,
        'fnd_id' => 0,
        'veh' => [
            'vehicle_year' => '2022',
            'vehicle_made' => 'Toyota',
            'vehicle_model' => 'Camry',
            'vin' => '1HGBH41JXMN109186',
            'license_plate' => '7ABC123',
            'vehicle_miles' => '45000',
            'color' => 'Silver',
            'body_style' => 'Sedan',
            'vehicle_kbb' => '18500',
            'account_number' => 'VA-456',
        ],
    ];
}

/** Split a full name into [first, last]. Single-token names become [first, '']. */
function _split_name($full) {
    $parts = array_map('trim', explode(' ', trim((string)$full), 2));
    return [$parts[0] ?? '', $parts[1] ?? ''];
}

/** Compute the value (or image path) for a field key given the context. */
function resolve_field_value($key, array $ctx) {
    $get = function($k, $default = '') use ($ctx) { return $ctx[$k] ?? $default; };
    [$cb_first, $cb_last] = _split_name($get('co_borrow_full_name'));
    $veh = $ctx['veh'] ?? [];

    switch ($key) {
        // Applicant
        case 'app.first_name':        return (string)$get('ff_name');
        case 'app.last_name':         return (string)$get('l_name');
        case 'app.ssn':               return (string)$get('ssn');
        case 'app.id_number':         return (string)$get('id_number');
        case 'app.address':           return (string)$get('address');
        case 'app.city':              return (string)$get('city');
        case 'app.state':             return (string)$get('state');
        case 'app.zip':               return (string)$get('zip');
        case 'app.dob':               return (string)$get('dob');
        case 'app.cellphone':         return (string)$get('mobile_number');
        case 'app.alt_number':        return (string)$get('alt_number');
        case 'app.email':             return (string)$get('email_addr');
        case 'app.source_lead':       return (string)$get('source_lead');
        case 'app.loan_amount':       return '$' . number_format((float)$get('principal_f', 0), 2);
        case 'app.signature_img':     return (string)$get('signed_pic');
        case 'app.signature_date':    return (string)$get('creation_date');

        // Co-applicant
        case 'app.coapp_first_name':  return $cb_first;
        case 'app.coapp_last_name':   return $cb_last;
        case 'app.coapp_ssn':         return '';
        case 'app.coapp_id_number':   return '';
        case 'app.coapp_address':     return (string)$get('co_borrow_address');
        case 'app.coapp_city':        return (string)$get('co_borrow_city');
        case 'app.coapp_state':       return (string)$get('co_borrow_state');
        case 'app.coapp_zip':         return (string)$get('co_borrow_zip');
        case 'app.coapp_dob':         return '';
        case 'app.coapp_cellphone':   return (string)$get('co_borrow_phone');
        case 'app.coapp_alt_number':  return '';
        case 'app.coapp_email':       return '';
        case 'app.coapp_signature_img':  return (string)$get('sig_coborrow_pic');
        case 'app.coapp_signature_date': return (string)$get('creation_date');

        // Business
        case 'app.biz_name':          return (string)$get('business_name');
        case 'app.biz_type':          return (string)$get('business_type');
        case 'app.biz_address':       return (string)$get('business_address');
        case 'app.biz_monthly_income':return '$' . number_format((float)$get('business_monthly_income', 0), 2);
        case 'app.biz_city':          return (string)$get('business_city');
        case 'app.biz_state':         return (string)$get('business_state');
        case 'app.biz_zip':           return (string)$get('business_zip');
        case 'app.biz_phone':         return (string)$get('business_phone');

        // Vehicle
        case 'veh.year':              return (string)($veh['vehicle_year']   ?? '');
        case 'veh.make':              return (string)($veh['vehicle_made']   ?? '');
        case 'veh.model':             return (string)($veh['vehicle_model']  ?? '');
        case 'veh.vin':               return (string)($veh['vin']            ?? '');
        case 'veh.plate':             return (string)($veh['license_plate']  ?? '');
        case 'veh.odometer':          return (string)($veh['vehicle_miles']  ?? '');
        case 'veh.color':             return (string)($veh['color']          ?? '');
        case 'veh.body_style':        return (string)($veh['body_style']     ?? '');
        case 'veh.kbb':               return (string)($veh['vehicle_kbb']    ?? '');
        case 'veh.summary':           return trim(($veh['vehicle_year'] ?? '').' '.($veh['vehicle_made'] ?? '').' '.($veh['vehicle_model'] ?? ''));
        case 'veh.account_number':    return (string)($veh['account_number'] ?? '');

        // Promissory / Loan
        case 'loan.contract_no':      return (string)$get('loan_id_bor');
        case 'loan.date':             return (string)$get('creation_date');
        case 'loan.borrower_line1':   return (string)$get('f_name');
        case 'loan.borrower_line2':   return (string)$get('address');
        case 'loan.borrower_line3':   return trim((string)$get('city').', '.(string)$get('state').' '.(string)$get('zip'), ' ,');
        case 'loan.coborrower_line1': return (string)$get('co_borrow_full_name');
        case 'loan.coborrower_line2': return (string)$get('co_borrow_address');
        case 'loan.coborrower_line3': return trim((string)$get('co_borrow_city').', '.(string)$get('co_borrow_state').' '.(string)$get('co_borrow_zip'), ' ,');
        case 'loan.business_line1':   return (string)$get('business_name');
        case 'loan.business_line2':   return (string)$get('business_address');
        case 'loan.business_line3':   return trim((string)$get('business_city').', '.(string)$get('business_state').' '.(string)$get('business_zip'), ' ,');
        case 'loan.apr':              return (string)$get('anual_pr');
        case 'loan.principal':        return '$' . (string)$get('principal');
        case 'loan.total_interest':   return '$' . (string)$get('total_interest');
        case 'loan.total_payments':   return '$' . (string)$get('total_payments_amount');
        case 'loan.pay_sched_first_num':       return '1';
        case 'loan.pay_sched_first_date':      return (string)$get('first_payment_date');
        case 'loan.pay_sched_beginning_date':  return (string)$get('first_payment_date');
        case 'loan.pay_sched_count':           return (string)$get('count_payments');
        case 'loan.pay_sched_each_date':       return (string)$get('first_payment_date');
        case 'loan.pay_sched_last_date':       return (string)$get('last_payment_date');
        case 'loan.contract_fee':              return number_format((float)$get('contract_fee', 0), 2);
        case 'loan.itemization_given':     return number_format((float)$get('principal_f',0) - (float)$get('in_hand',0), 2);
        case 'loan.itemization_paid':      return number_format((float)$get('in_hand',0), 2);
        case 'loan.itemization_financed':  return number_format((float)$get('principal_f',0), 2);
        case 'loan.itemization_prepaid':   return number_format((float)$get('contract_fee',0), 2);
        case 'loan.itemization_gps':       return '';
        case 'loan.itemization_principal': return number_format((float)$get('principal_f',0) + (float)$get('contract_fee',0), 2);
        case 'loan.initials_img':     return (string)$get('initial_pic');

        // Header trio (continuation pages)
        case 'header.borrower_name':  return (string)$get('f_name');
        case 'header.loan_number':    return (string)$get('loan_id_bor');
        case 'header.date':           return (string)$get('creation_date');

        // Signatures
        case 'signature.borrower_img':     return (string)$get('signed_pic');
        case 'signature.borrower_date':    return (string)$get('creation_date');
        case 'signature.coborrower_img':   return (string)$get('sig_coborrow_pic');
        case 'signature.coborrower_date':  return (string)$get('creation_date');

        // Onsite payment
        case 'onsite.physical_address':
            return trim((string)$get('address').'  '.(string)$get('city').' '.(string)$get('state').' '.(string)$get('zip'));

        // ACH
        case 'ach.account_number':      return (string)$get('account_number');
        case 'ach.bank_name':           return (string)$get('bank_name');
        case 'ach.payment_amount':      return number_format((float)$get('first_payment',0), 2);
        case 'ach.first_payment_date':  return (string)$get('first_payment_date');
        case 'ach.borrower_printed_name': return (string)$get('f_name');
    }
    return '';  // unknown field — render nothing
}

/** Total page count per template — used by the renderer to know how many
 *  template pages to import (even those without any overlay coords). */
function contract_template_page_count($template) {
    return [
        'unsecured_2024_09_01' => 35,
        'secured'              => 47,
    ][$template] ?? 0;
}
