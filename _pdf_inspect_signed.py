"""Inspect a SIGNED PDF: per page, dump
  1. Labels matching sign/initial/firma/iniciales/borrower/co-borrow/date
  2. Embedded image positions (where the signature/initial PNGs landed)
  3. Horizontal underscore-like lines (signature/date lines)

Helps correlate set_image() coordinates with the actual rendered output.
"""
import sys, re, pdfplumber

PT_PER_MM = 72.0 / 25.4
PATH = sys.argv[1] if len(sys.argv) > 1 else \
    r"c:\temp\ofsca\loanportal\signature_commercial_loan\files\Barcodes\signed\DoBW6mEi.pdf"

LABEL_RE = re.compile(
    r"sign|signature|initials?\b|firma|iniciales|borrow|date|fecha|co-?borrow",
    re.IGNORECASE,
)

def pt2mm(v): return v / PT_PER_MM

with pdfplumber.open(PATH) as pdf:
    print(f"File: {PATH}")
    print(f"Pages: {len(pdf.pages)}\n")
    for i, page in enumerate(pdf.pages, start=1):
        print(f"=== PAGE {i}  ({pt2mm(page.width):.0f}mm x {pt2mm(page.height):.0f}mm) ===")

        # Image overlays (the signature/initial PNGs)
        try:
            images = page.images or []
        except Exception as e:
            images = []
            print(f"  image extraction failed: {e}")
        for img in images:
            x0 = pt2mm(img['x0']); x1 = pt2mm(img['x1'])
            y0 = pt2mm(img['top']); y1 = pt2mm(img['bottom'])
            w_mm = x1 - x0; h_mm = y1 - y0
            print(f"  [image]  x0={x0:6.1f}  y0={y0:6.1f}  w={w_mm:5.1f}mm  h={h_mm:5.1f}mm")

        # Labels of interest
        try:
            words = page.extract_words(keep_blank_chars=False)
        except Exception:
            words = []
        seen = set()
        for w in words:
            t = w.get('text', '')
            if LABEL_RE.search(t) and t not in seen:
                seen.add(t)
                x_mm = pt2mm(w['x0']); y_mm = pt2mm(w['top'])
                print(f"  [text ]  {t!r:30s}  x={x_mm:6.1f}  y={y_mm:6.1f}")
        print()
