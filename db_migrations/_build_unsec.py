"""Generate a comprehensive UPDATE SQL aligning Unsec field coords with the
actual underscore-blank positions extracted from the source PDF."""
import pdfplumber

PT2MM = 25.4 / 72
PDF = r'c:/temp/ofsca/loanportal/signature_commercial_loan/Loan-Agreement-Unsecured-2024-09-01.pdf'

LAYOUT = {
    1: 'application', 2: 'application',
    3: 'promissory', 5: 'promissory',
    4: 'signature_page', 6: 'signature_page',
    8: 'header_only', 9: 'header_only', 10: 'header_only',
    11: 'header_only', 12: 'header_only',
}


def extract_blanks(page):
    chars = sorted([c for c in page.chars if c.get('text') == '_'],
                   key=lambda c: (round(c['top'], 1), c['x0']))
    runs = []
    cur = None
    for c in chars:
        if cur and abs(c['top'] - cur['top']) < 1.2 and c['x0'] - cur['x1'] < 2.5:
            cur['x1'] = c['x1']
            cur['n'] += 1
        else:
            if cur and cur['n'] >= 2:
                runs.append(cur)
            cur = {'top': c['top'], 'x0': c['x0'], 'x1': c['x1'], 'n': 1}
    if cur and cur['n'] >= 2:
        runs.append(cur)
    return [(r['top'] * PT2MM, r['x0'] * PT2MM, r['x1'] * PT2MM)
            for r in runs if (r['x1'] - r['x0']) >= 10]


def near(blanks, y_target, dy=2):
    return [b for b in blanks if abs(b[0] - y_target) < dy]


def emit_promissory(blanks):
    out = []
    rows = [
        ('loan.contract_no',      14.3),
        ('loan.date',             16.3),
        ('loan.borrower_line1',   19.4),
        ('loan.borrower_line2',   24.1),
        ('loan.borrower_line3',   28.6),
        ('loan.coborrower_line1', 33.3),
        ('loan.coborrower_line2', 38.4),
        ('loan.coborrower_line3', 43.1),
        ('loan.business_line1',   48.0),
        ('loan.business_line2',   52.3),
        ('loan.business_line3',   57.0),
    ]
    used = set()
    for fk, y in rows:
        cands = [b for b in blanks if id(b) not in used]
        if not cands:
            continue
        b = min(cands, key=lambda b: abs(b[0] - y))
        used.add(id(b))
        out.append((fk, b[1], b[0] - 1, b[2] - b[1]))

    til = sorted(near(blanks, 82.6), key=lambda b: b[1])
    for fk, b in zip(['loan.apr', 'loan.principal', 'loan.total_interest', 'loan.total_payments'], til):
        out.append((fk, b[1], b[0] - 1, b[2] - b[1]))

    row1 = sorted(near(blanks, 105.9), key=lambda b: b[1])
    if len(row1) >= 1:
        b = row1[0]; out.append(('loan.pay_sched_first_date', b[1], b[0] - 1, b[2] - b[1]))
    if len(row1) >= 2:
        b = row1[1]; out.append(('loan.pay_sched_beginning_date', b[1], b[0] - 1, b[2] - b[1]))
    row2 = near(blanks, 113.5)
    if row2:
        b = row2[0]; out.append(('loan.pay_sched_each_date', b[1], b[0] - 1, b[2] - b[1]))
    row3 = near(blanks, 121.1)
    if row3:
        b = row3[0]; out.append(('loan.pay_sched_last_date', b[1], b[0] - 1, b[2] - b[1]))

    out.append(('loan.pay_sched_first_num',    73, 105, 8))
    out.append(('loan.pay_sched_count',        73, 113, 8))
    out.append(('loan.pay_sched_first_amount', 93, 105, 18))
    out.append(('loan.pay_sched_each_amount',  93, 113, 18))
    out.append(('loan.pay_sched_frequency',   115, 113, 14))
    out.append(('loan.pay_sched_last_amount',  93, 120, 18))

    fee = near(blanks, 139.5)
    if fee:
        b = fee[0]; out.append(('loan.contract_fee', b[1], b[0] - 1, b[2] - b[1]))

    out.append(('loan.itemization_given',     170, 158, 30))
    out.append(('loan.itemization_paid',      170, 163, 30))
    out.append(('loan.itemization_financed',  170, 167, 30))
    out.append(('loan.itemization_prepaid',   170, 171, 30))
    out.append(('loan.itemization_principal', 170, 175, 30))

    init = near(blanks, 258.8, dy=3)
    if init:
        b = init[0]
        out.append(('loan.initials_img', b[1], b[0] - 15, b[2] - b[1]))
    return out


def emit_signature_page(blanks):
    out = []
    name = near(blanks, 34.8)
    if name:
        b = name[0]; out.append(('header.borrower_name', b[1], b[0] - 1, b[2] - b[1]))
    ln = near(blanks, 40.5)
    if ln:
        b = ln[0]; out.append(('header.loan_number', b[1], b[0] - 1, b[2] - b[1]))
    addr = near(blanks, 156)
    if addr:
        b = addr[0]; out.append(('onsite.physical_address', b[1], b[0] - 1, b[2] - b[1]))
    sig = sorted([b for b in blanks if 230 < b[0] < 260], key=lambda b: b[0])
    if len(sig) >= 2:
        b = sig[0]; out.append(('signature.borrower_img',   b[1], b[0] - 15, 60))
        b = sig[1]; out.append(('signature.coborrower_img', b[1], b[0] - 15, 60))
    return out


def emit_header_only(blanks):
    out = []
    top3 = sorted(blanks, key=lambda b: b[0])[:3]
    for fk, b in zip(['header.borrower_name', 'header.loan_number', 'header.date'], top3):
        out.append((fk, b[1], b[0] - 1, b[2] - b[1]))
    return out


def find_label_x_range(page, y_pt, phrase_words, dy=4):
    """Locate a label phrase on a row. Returns (left_x_pt, right_x_pt) or None."""
    words = page.extract_words(x_tolerance=2, y_tolerance=2)
    row = sorted([w for w in words if abs(w['top'] - y_pt) < dy], key=lambda w: w['x0'])
    # Find consecutive words that match the phrase tokens
    needle = [t.lower() for t in phrase_words]
    for i in range(len(row) - len(needle) + 1):
        if all(row[i + j]['text'].lower().rstrip(':') == needle[j].rstrip(':') for j in range(len(needle))):
            return row[i]['x0'], row[i + len(needle) - 1]['x1']
    return None


def emit_application(page, page_num):
    """Map data fields to the empty space immediately after each label.
    Layout is identical for English (p1) and Spanish (p2) row Y positions
    in the Unsecured template."""
    # Each entry: (field_key, label_words, row_y_pt, next_label_x_pt)
    #   next_label_x_pt = None means "extend to end of page" (about 575pt = 203mm)
    PAGE_RIGHT = 575

    # Y rows are identical between unsec p1 and p2 — verified from earlier extracts
    rows = []
    if page_num == 1:
        rows = [
            # Applicant row 1 — English labels
            ('app.first_name', ['First','Name:'],            127, 246),
            ('app.last_name',  ['Last','Name:'],             127, 441),
            ('app.ssn',        ['SSN/ITIN:'],                127, PAGE_RIGHT),
            ('app.address',    ['Address:'],                 158, 441),
            ('app.id_number',  ['Identification','Number:'], 158, PAGE_RIGHT),
            ('app.city',       ['City:'],                    190, 192),
            ('app.state',      ['State:'],                   190, 294),
            ('app.zip',        ['Zip','Code:'],              190, 441),
            ('app.dob',        ['DOB:'],                     190, PAGE_RIGHT),
            ('app.cellphone',  ['Cellphone:'],               222, 184),
            ('app.alt_number', ['Alternative','Number:'],    222, 314),
            ('app.email',      ['e-Mail:'],                  222, PAGE_RIGHT),
            ('app.source_lead',['us?'],                      253, 185),
            ('app.loan_amount',['Loan','Amount:'],           253, PAGE_RIGHT),
            # Co-applicant
            ('app.coapp_last_name',  ['Last','Name:'],        309, 227),
            ('app.coapp_first_name', ['First','Name:'],       309, 441),
            ('app.coapp_ssn',        ['SSN/ITIN:'],           309, PAGE_RIGHT),
            ('app.coapp_address',    ['Address:'],            341, 441),
            ('app.coapp_id_number',  ['Identification','Number:'], 341, PAGE_RIGHT),
            ('app.coapp_city',       ['City:'],               373, 192),
            ('app.coapp_state',      ['State:'],              373, 294),
            ('app.coapp_zip',        ['Zip','Code:'],         373, 441),
            ('app.coapp_dob',        ['DOB:'],                373, PAGE_RIGHT),
            ('app.coapp_cellphone',  ['Cellphone:'],          404, 184),
            ('app.coapp_alt_number', ['Alternative','Number:'], 404, 314),
            ('app.coapp_email',      ['e-Mail:'],             404, PAGE_RIGHT),
            # Business
            ('app.biz_name',           ['Business','Name:'],   464, 448),
            ('app.biz_type',           ['Type','of','Business:'], 464, PAGE_RIGHT),
            ('app.biz_address',        ['Business','Address:'], 494, 448),
            ('app.biz_monthly_income', ['Monthly','Income:'],   494, PAGE_RIGHT),
            ('app.biz_city',           ['City:'],               524, 168),
            ('app.biz_state',          ['State:'],              524, 275),
            ('app.biz_zip',            ['Zip','code:'],         524, 408),
            ('app.biz_phone',          ['Phone:'],              524, PAGE_RIGHT),
            # Signatures (these DO have underscore blanks — handle separately below)
        ]
    else:  # page 2 (Spanish)
        rows = [
            ('app.first_name', ['Primer','Nombre:'],          127, 227),
            ('app.last_name',  ['Apellido:'],                 127, 441),
            ('app.ssn',        ['SSN/ITIN:'],                 127, PAGE_RIGHT),
            ('app.address',    ['Dirección'],            158, 441),
            ('app.id_number',  ['Identificación:'],      158, PAGE_RIGHT),
            ('app.city',       ['Ciudad:'],                   190, 192),
            ('app.state',      ['Estado:'],                   190, 294),
            ('app.zip',        ['Codigo','Postal:'],          190, 441),
            ('app.dob',        ['Nacimiento:'],               190, PAGE_RIGHT),
            ('app.cellphone',  ['Celular:'],                  222, 184),
            ('app.alt_number', ['Numero','Alterno:'],         222, 314),
            ('app.email',      ['Electronico:'],              222, PAGE_RIGHT),
            ('app.source_lead',['nosotros?'],                 253, 185),
            ('app.loan_amount',['Monto','de','Prestamo:'],    253, PAGE_RIGHT),
            ('app.coapp_last_name',  ['Apellido'],            309, 441),
            ('app.coapp_first_name', ['Primer','Nombre'],     309, 227),
            ('app.coapp_ssn',        ['SSN/ITIN:'],           309, PAGE_RIGHT),
            ('app.coapp_address',    ['Dirección'],      341, 441),
            ('app.coapp_id_number',  ['Identificación'], 341, PAGE_RIGHT),
            ('app.coapp_city',       ['Ciudad:'],             373, 192),
            ('app.coapp_state',      ['Estado:'],             373, 294),
            ('app.coapp_zip',        ['Codigo','Postal:'],    373, 441),
            ('app.coapp_dob',        ['Nacimiento:'],         373, PAGE_RIGHT),
            ('app.coapp_cellphone',  ['Celular:'],            404, 184),
            ('app.coapp_alt_number', ['Numero','Alterno:'],   404, 314),
            ('app.coapp_email',      ['Electronico:'],        404, PAGE_RIGHT),
            ('app.biz_name',         ['Nombre','del','Negocio'], 464, 448),
            ('app.biz_type',         ['Tipo','de','Negocio:'],   464, PAGE_RIGHT),
            ('app.biz_address',      ['Direccion','del','Negocio:'], 494, 448),
            ('app.biz_monthly_income', ['Ingresos','Mensuales:'], 494, PAGE_RIGHT),
            ('app.biz_city',         ['Ciudad:'],                524, 162),
            ('app.biz_state',        ['Estado:'],               524, 264),
            ('app.biz_zip',          ['Codigo','Postal:'],      524, 409),
            ('app.biz_phone',        ['Negocio:'],              524, PAGE_RIGHT),
        ]

    out = []
    for fk, phrase, row_y_pt, next_x_pt in rows:
        rng = find_label_x_range(page, row_y_pt, phrase)
        if not rng:
            continue
        label_left, label_right = rng
        # Place data 4pt past the right edge of the label, extend to next label
        # (with a small 4pt gutter on the right too)
        x_pt = label_right + 4
        w_pt = max(20, (next_x_pt - 4) - x_pt)
        # Y: label is the top of its char; cell top should be ~1mm above for the
        # baseline to sit on the same line.
        x_mm = x_pt * PT2MM
        y_mm = (row_y_pt - 4) * PT2MM
        w_mm = w_pt * PT2MM
        out.append((fk, x_mm, y_mm, w_mm))

    # Signatures: detect underscore blanks at bottom of page
    blanks = extract_blanks(page)
    sigs = sorted([b for b in blanks if b[0] > 200], key=lambda b: b[0])
    if len(sigs) >= 2:
        b = sigs[0]
        out.append(('app.signature_img',       b[1] + 5, b[0] - 15, 60))
        out.append(('app.signature_date',      b[1] + (b[2] - b[1]) + 4, b[0] - 1, max(20, 575 * PT2MM - (b[1] + (b[2] - b[1]) + 4))))
        b = sigs[1]
        out.append(('app.coapp_signature_img', b[1] + 5, b[0] - 15, 60))
        out.append(('app.coapp_signature_date', b[1] + (b[2] - b[1]) + 4, b[0] - 1, max(20, 575 * PT2MM - (b[1] + (b[2] - b[1]) + 4))))
    return out


sql = []
sql.append('-- Auto-derived UPDATE for Unsecured pages 3-15')
sql.append('-- Extracts precise blank coordinates from the source PDF')
sql.append('-- and updates contract_field_coords accordingly.')
sql.append('')

with pdfplumber.open(PDF) as pdf:
    for pg, kind in LAYOUT.items():
        page = pdf.pages[pg - 1]
        blanks = extract_blanks(page)
        sql.append(f"-- Page {pg} ({kind}) - {len(blanks)} blanks detected")
        if kind == 'promissory':
            rows = emit_promissory(blanks)
        elif kind == 'signature_page':
            rows = emit_signature_page(blanks)
        elif kind == 'header_only':
            rows = emit_header_only(blanks)
        elif kind == 'application':
            rows = emit_application(page, pg)
        else:
            rows = []
        for fk, x, y, w in rows:
            sql.append(
                f"UPDATE contract_field_coords SET x_mm={x:.2f}, y_mm={y:.2f}, w_mm={w:.2f} "
                f"WHERE template='unsecured_2024_09_01' AND page_num={pg} AND field_key='{fk}';"
            )
        sql.append('')

out_path = r'c:/temp/ofsca/loanportal/db_migrations/2026-05-fix-unsec-all-positions.sql'
with open(out_path, 'w') as f:
    f.write('\n'.join(sql))
print(f"wrote {out_path}")
print(f"  {sum(1 for s in sql if s.startswith('UPDATE'))} UPDATEs")
