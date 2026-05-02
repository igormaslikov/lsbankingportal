"""Generate a comprehensive UPDATE SQL aligning Unsec field coords with the
actual underscore-blank positions extracted from the source PDF."""
import pdfplumber

PT2MM = 25.4 / 72
PDF = r'c:/temp/ofsca/loanportal/signature_commercial_loan/Loan-Agreement-Unsecured-2024-09-01.pdf'

LAYOUT = {
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
