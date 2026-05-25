"""
Phase 3 helper: for each page in the given PDF, find every run of underscore
characters (which mark a blank to be filled), record its position, and pair it
with the closest label text on that page.

Output is a JSON file per source PDF: [{page, x, y, w, label, sample_text}, ...]
Coordinates are in PDF points (origin top-left, same basis as FPDI/FPDF uses).
"""
import json, os, sys
import pdfplumber

IN_OUT = [
    (r'c:/temp/ofsca/loanportal/signature_commercial_loan/Loan-Agreement-Unsecured-2024-09-01.pdf',
     r'c:/temp/ofsca/loanportal/signature_commercial_loan/files/phase3_analysis/unsecured_blanks.json'),
    (r'c:/temp/ofsca/loanportal/signature_commercial_loan/Loan-Agreement-Secured.pdf',
     r'c:/temp/ofsca/loanportal/signature_commercial_loan/files/phase3_analysis/secured_blanks.json'),
]

def group_underscore_runs(chars):
    """Group consecutive underscore chars on the same baseline into runs."""
    runs = []
    cur = None
    # Sort by y, then x
    us = [c for c in chars if c.get('text') == '_']
    us.sort(key=lambda c: (round(c['top'], 1), c['x0']))
    for c in us:
        if cur is None:
            cur = {'top': c['top'], 'bottom': c['bottom'], 'x0': c['x0'], 'x1': c['x1'],
                   'page': c['page_number']}
            continue
        # Same line (top within 1pt) AND adjacent (gap < 2pt)
        if abs(c['top'] - cur['top']) < 1.2 and (c['x0'] - cur['x1']) < 2.5:
            cur['x1'] = c['x1']
        else:
            runs.append(cur)
            cur = {'top': c['top'], 'bottom': c['bottom'], 'x0': c['x0'], 'x1': c['x1'],
                   'page': c['page_number']}
    if cur: runs.append(cur)
    # Only keep runs wide enough to be a real blank (>= 15pt)
    return [r for r in runs if (r['x1'] - r['x0']) >= 15]

def nearest_label(page, run):
    """Find the closest text fragment to the left-of / above-left of the run."""
    words = page.extract_words(x_tolerance=2, y_tolerance=2)
    run_cy = (run['top'] + run['bottom']) / 2
    best = None
    best_d = 1e9
    for w in words:
        wx1 = w['x1']; wy = (w['top'] + w['bottom']) / 2
        # Candidates: to the left of run on same line, OR directly above run
        same_line = abs(wy - run_cy) < 4
        left      = wx1 <= run['x0'] + 1
        above     = (w['bottom'] < run['top']) and abs((w['x0']+w['x1'])/2 - (run['x0']+run['x1'])/2) < 40
        if same_line and left:
            d = run['x0'] - wx1
            if d < best_d:
                best_d = d; best = w
        elif above and best is None:
            d = run['top'] - w['bottom']
            if d < 20 and d < best_d:
                best_d = d; best = w
    return best

def label_context(page, run, span_left=180):
    """Extract the text immediately to the left of the run for labeling context."""
    left  = max(0, run['x0'] - span_left)
    right = run['x0']
    top   = max(0, run['top'] - 2)
    bot   = run['bottom'] + 2
    try:
        crop = page.within_bbox((left, top, right, bot))
        txt  = crop.extract_text() or ''
    except Exception:
        txt = ''
    return txt.strip()

def main():
    for src, dst in IN_OUT:
        print(f"-- {os.path.basename(src)}")
        out = []
        with pdfplumber.open(src) as pdf:
            for i, page in enumerate(pdf.pages, 1):
                chars = page.chars
                for c in chars:
                    c['page_number'] = i
                runs = group_underscore_runs(chars)
                for r in runs:
                    ctx = label_context(page, r)
                    out.append({
                        'page':  i,
                        'x':     round(r['x0'], 1),
                        'y':     round(r['top'], 1),
                        'w':     round(r['x1'] - r['x0'], 1),
                        'label': ctx[-60:],  # last 60 chars before blank
                    })
        os.makedirs(os.path.dirname(dst), exist_ok=True)
        with open(dst, 'w', encoding='utf-8') as f:
            json.dump(out, f, ensure_ascii=False, indent=1)
        print(f"   wrote {len(out)} blanks -> {dst}")

if __name__ == '__main__':
    main()
