<?php
/**
 * Phase A — DB-driven contract renderer.
 *
 * Replaces the old per-template hardcoded coordinate functions. All field
 * positions now live in the `contract_field_coords` table; this file just
 * iterates pages, queries coords for each page, and calls set_info/set_image.
 *
 * Entry point: render_template_from_db($pdf, $template, $ctx, $only_page = null)
 *   $pdf        — FPDI instance already set up for the right source template
 *   $template   — 'unsecured_2024_09_01' or 'secured'
 *   $ctx        — associative array from build_context_from_globals()
 *                  or build_demo_context()
 *   $only_page  — if non-null, skip every page except this one (used by the
 *                  field editor for fast single-page preview)
 */

require_once __DIR__ . '/contract_pdf_fields.php';

/** Fetch every coord row for one template keyed by page_num → list of rows. */
function _load_template_coords($con, $template) {
    $tpl_escaped = $con->real_escape_string($template);
    $sql = "SELECT page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align
            FROM contract_field_coords
            WHERE template = '$tpl_escaped'
            ORDER BY page_num, field_key";
    $res = $con->query($sql);
    $by_page = [];
    while ($res && $r = $res->fetch_assoc()) {
        $by_page[(int)$r['page_num']][] = $r;
    }
    return $by_page;
}

function render_template_from_db($pdf, $template, array $ctx, $only_page = null) {
    global $con;

    $total_pages = contract_template_page_count($template);
    if ($total_pages <= 0) return;

    $by_page = _load_template_coords($con, $template);

    for ($pg = 1; $pg <= $total_pages; $pg++) {
        if ($only_page !== null && $only_page !== $pg) continue;

        // Import the template page — every page of the source PDF gets its own
        // AddPage, whether it has overlays or not (so page counts match).
        $tpl = $pdf->importPage($pg);
        $pdf->grid = false;
        $pdf->AddPage();
        $pdf->useTemplate($tpl);

        if (empty($by_page[$pg])) continue;

        foreach ($by_page[$pg] as $c) {
            $value = resolve_field_value($c['field_key'], $ctx);
            if ($c['field_type'] === 'image') {
                // set_image: draws $value (png path) at x,y. Width param is -200
                // by historical convention (px DPI hint, not width-in-mm).
                if (!empty($value)) {
                    set_image($pdf, $value, (float)$c['x_mm'], (float)$c['y_mm'], -200);
                }
            } else {
                set_info($pdf,
                    (float)$c['x_mm'], (float)$c['y_mm'],
                    (float)$c['w_mm'], (float)$c['h_mm'],
                    (string)$value, 'I', (int)$c['font_size'], $c['align']
                );
            }
        }
    }
}
