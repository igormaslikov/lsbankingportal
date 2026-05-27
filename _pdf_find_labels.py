"""Find specific multi-word labels in the unsigned Optima 2026 PDF and report
their (page, x, y) so we can fix signature/initial placement.
"""
import sys, re
import pdfplumber

PT_PER_MM = 72.0 / 25.4
PATH = r"c:\temp\ofsca\loanportal\signature_commercial_loan\Optima- Business ContractUpdated2026.pdf"

# Phrases to find. Use compact lowercase keys; match against page text.
PHRASES = [
    "Initials/Iniciales",
    "Iniciales",
    "Initials",
    "Borrower Signature",
    "Co-Borrower Signature",
    "Firma del deudor",
    "Firma del co-deudor",
    "Firma de co-deudor",
    "Firma del Titular",
    "Account Holder",
    "Titular de la Cuenta",
]

def pt2mm(v): return v / PT_PER_MM

with pdfplumber.open(PATH) as pdf:
    for i, page in enumerate(pdf.pages, start=1):
        # Get the whole page text as a string with positions
        try:
            words = page.extract_words(keep_blank_chars=False)
        except Exception:
            continue
        # Build a tokenized lowercase representation
        text = ' '.join(w.get('text','') for w in words)

        # For each phrase, find approximate position via the first word match
        for phrase in PHRASES:
            # Try to locate the FIRST word of the phrase among the page words
            head = phrase.split()[0].lower().rstrip(':').rstrip(',').rstrip('.')
            for w in words:
                wt = w.get('text','').lower().rstrip(':').rstrip(',').rstrip('.')
                if wt == head or wt.startswith(head):
                    # Build the surrounding span by collecting next few words on the same row
                    # find words within +/- 5pt y on this page that come after this word
                    same_row = [
                        ww for ww in words
                        if abs(ww['top'] - w['top']) < 4
                        and ww['x0'] >= w['x0']
                    ]
                    same_row.sort(key=lambda ww: ww['x0'])
                    joined = ' '.join(ww['text'] for ww in same_row[:8])
                    if phrase.lower().split()[0] in joined.lower():
                        x_mm = pt2mm(w['x0'])
                        y_mm = pt2mm(w['top'])
                        # also get the rightmost x of words in the row that come right after
                        x1_mm = pt2mm(max((ww['x1'] for ww in same_row), default=w['x1']))
                        print(f"PAGE {i:2d}  y={y_mm:6.1f}mm  x={x_mm:6.1f}..{x1_mm:6.1f}mm  '{joined[:80]}'")
                        break
