"""Quick PDF-layout inspector: find every line/text element that looks like
a signature, initial, or date placeholder, and print its mm coordinates
so we can correlate with the per-page set_image / set_info calls in
contract_pdf.php.

Output is per-page: page index, label text, (x, y, w, h) in mm.
"""
import sys
import re
import pdfplumber

PT_PER_MM = 72.0 / 25.4  # 72 PDF points per inch, 25.4 mm per inch

PATH = r"c:\temp\ofsca\loanportal\signature_commercial_loan\Optima- Business ContractUpdated2026.pdf"

KEYWORDS = re.compile(
    r"sign|signature|initials?\b|borrow|date\b|co-?borrow",
    re.IGNORECASE,
)

def pt2mm(v: float) -> float:
    return v / PT_PER_MM

def page_h_pt(page):
    return page.height

with pdfplumber.open(PATH) as pdf:
    print(f"Total pages: {len(pdf.pages)}")
    for i, page in enumerate(pdf.pages, start=1):
        w_mm = pt2mm(page.width)
        h_mm = pt2mm(page.height)
        print(f"\n=== PAGE {i}  ({w_mm:.1f}mm wide x {h_mm:.1f}mm tall) ===")

        # Text words with positions
        try:
            words = page.extract_words(use_text_flow=True, keep_blank_chars=False)
        except Exception as e:
            print(f"  word extraction failed: {e}")
            words = []

        # Filter to interesting labels
        matches = [w for w in words if KEYWORDS.search(w.get("text", ""))]
        if matches:
            print("  Labels of interest (x, y, top-of-text):")
            for w in matches:
                x_mm = pt2mm(w["x0"])
                # pdfplumber 'top' is from top of page in points; convert
                y_mm = pt2mm(w["top"])
                print(f"    {w['text']!r:35s}  x={x_mm:6.1f}mm  y={y_mm:6.1f}mm")

        # Horizontal lines (signature/date underscores) — pdfplumber.lines
        # Only print lines wider than ~10mm and below halfway down the page
        lines = page.lines or []
        long_lines = [
            l for l in lines
            if abs(l.get("x1", 0) - l.get("x0", 0)) > 28  # > 10mm
        ]
        if long_lines:
            print("  Horizontal lines >10mm (sig/date underscores):")
            for l in sorted(long_lines, key=lambda l: (l["top"], l["x0"])):
                x0 = pt2mm(l["x0"])
                x1 = pt2mm(l["x1"])
                y  = pt2mm(l["top"])
                print(f"    line  x0={x0:6.1f}mm  x1={x1:6.1f}mm  y={y:6.1f}mm  len={x1-x0:5.1f}mm")
