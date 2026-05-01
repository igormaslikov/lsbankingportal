<?php
/**
 * Phase B — Admin coordinate editor for contract field placements.
 *
 * URL:
 *   /ls_software/admin/loan-commercial/contract_field_editor.php
 *       ?template=unsecured_2024_09_01|secured
 *       &page=N
 *
 * POST:
 *   action=save   — JSON body of rows to upsert, returns JSON {ok:true,updated:N}
 *   action=delete — JSON {id} drops a single coord row
 *   action=insert — JSON {template,page_num,field_key,x_mm,y_mm,w_mm,h_mm,font_size,align,field_type}
 */

session_start();
error_reporting(0);
ini_set('display_errors', 0);
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
    header('Location: ../index.php');
    exit;
}
$q = $DBcon->query("SELECT access_id FROM tbl_users WHERE user_id=" . (int)$_SESSION['userSession']);
$urow = $q ? $q->fetch_array() : null;
$u_id = (int)$_SESSION['userSession'];
$u_access = $urow ? $urow['access_id'] : '';
if ($u_access !== '1') {
    http_response_code(403);
    echo 'YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.';
    exit;
}
$DBcon->close();

include_once '../dbconfig.php';
require_once __DIR__ . '/../../../signature_commercial_loan/files/contract_pdf_fields.php';

$template = $_GET['template'] ?? 'secured';
$page_num = max(1, (int)($_GET['page'] ?? 1));
$total_pages = contract_template_page_count($template) ?: 1;

// ---------------- AJAX endpoints ----------------
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $payload = json_decode($_POST['rows'] ?? '[]', true);
        if (!is_array($payload)) { echo json_encode(['ok'=>false,'error'=>'bad payload']); exit; }
        $updated = 0;
        $stmt = mysqli_prepare($con,
            "UPDATE contract_field_coords
             SET x_mm=?, y_mm=?, w_mm=?, h_mm=?, font_size=?, align=?, updated_by=?
             WHERE id=?");
        foreach ($payload as $r) {
            $x = (float)($r['x_mm'] ?? 0); $y = (float)($r['y_mm'] ?? 0);
            $w = (float)($r['w_mm'] ?? 0); $h = (float)($r['h_mm'] ?? 5);
            $fs = (int)($r['font_size'] ?? 9);
            $al = substr((string)($r['align'] ?? 'C'), 0, 1);
            $id = (int)($r['id'] ?? 0);
            if ($id <= 0) continue;
            mysqli_stmt_bind_param($stmt, 'ddddisii', $x, $y, $w, $h, $fs, $al, $u_id, $id);
            if (mysqli_stmt_execute($stmt)) $updated++;
        }
        mysqli_stmt_close($stmt);
        echo json_encode(['ok'=>true,'updated'=>$updated]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) { echo json_encode(['ok'=>false,'error'=>'missing id']); exit; }
        $ok = mysqli_query($con, "DELETE FROM contract_field_coords WHERE id=$id");
        echo json_encode(['ok'=>(bool)$ok]);
        exit;
    }

    if ($action === 'insert') {
        $tpl = mysqli_real_escape_string($con, $_POST['template'] ?? '');
        $pg  = (int)($_POST['page_num'] ?? 0);
        $fk  = mysqli_real_escape_string($con, $_POST['field_key'] ?? '');
        $ft  = in_array($_POST['field_type'] ?? '', ['text','image']) ? $_POST['field_type'] : 'text';
        $x = (float)($_POST['x_mm'] ?? 60); $y = (float)($_POST['y_mm'] ?? 60);
        $w = (float)($_POST['w_mm'] ?? 40); $h = (float)($_POST['h_mm'] ?? 5);
        $fs = (int)($_POST['font_size'] ?? 9);
        $al = substr((string)($_POST['align'] ?? 'C'), 0, 1);
        if ($tpl === '' || $pg <= 0 || $fk === '') { echo json_encode(['ok'=>false,'error'=>'missing fields']); exit; }
        $ok = mysqli_query($con,
            "INSERT INTO contract_field_coords
             (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align, updated_by)
             VALUES ('$tpl', $pg, '$fk', '$ft', $x, $y, $w, $h, $fs, '$al', $u_id)
             ON DUPLICATE KEY UPDATE
               field_type=VALUES(field_type), x_mm=VALUES(x_mm), y_mm=VALUES(y_mm),
               w_mm=VALUES(w_mm), h_mm=VALUES(h_mm), font_size=VALUES(font_size),
               align=VALUES(align), updated_by=VALUES(updated_by)");
        echo json_encode(['ok'=>(bool)$ok, 'error'=>$ok ? null : mysqli_error($con)]);
        exit;
    }
    echo json_encode(['ok'=>false,'error'=>'unknown action']);
    exit;
}

// ---------------- GET: render the editor form ----------------
$tpl_escaped = mysqli_real_escape_string($con, $template);
$res = mysqli_query($con, "SELECT * FROM contract_field_coords
    WHERE template='$tpl_escaped' AND page_num=$page_num ORDER BY field_key");
$rows = [];
while ($res && $r = mysqli_fetch_assoc($res)) $rows[] = $r;

// Pick a real loan_id for the "real data" preview — use the first signed
// loan of the active template, or fall back to any loan on this template.
$preview_real_loan_key = '';
$qpick = mysqli_query($con,
    "SELECT cli.email_key FROM commercial_loan_initial_banking cli
     JOIN tbl_commercial_loan cl ON cli.loan_id = cl.loan_create_id
     WHERE cl.contract_template = '$tpl_escaped' AND cli.email_key <> ''
     ORDER BY cli.sign_status DESC, cli.creation_date DESC LIMIT 1");
if ($qpick && $rp = mysqli_fetch_assoc($qpick)) $preview_real_loan_key = $rp['email_key'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Contract Field Editor — <?php echo htmlspecialchars($template); ?> · page <?php echo $page_num; ?></title>
<style>
  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; height: 100%; font: 13px/1.4 -apple-system, Segoe UI, Roboto, sans-serif; color: #222; }
  .app { display: grid; grid-template-columns: 720px 1fr; grid-template-rows: auto 1fr; height: 100vh; }
  header { grid-column: 1 / -1; padding: 10px 16px; background: #f5f5f5; border-bottom: 1px solid #ddd;
           display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
  header h1 { font-size: 16px; margin: 0 12px 0 0; }
  header select, header input, header button, header a {
      font: inherit; padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; background: #fff; color: #222; text-decoration: none;
  }
  header button.primary { background: #1E90FF; color: #fff; border-color: #1E90FF; cursor: pointer; }
  header button.primary:hover { background: #1976c2; }
  header .spacer { flex: 1; }
  header .status { color: #666; font-size: 12px; }

  #editor { padding: 10px 14px; overflow: auto; border-right: 1px solid #ddd; }
  table.coords { border-collapse: collapse; width: 100%; font-size: 12px; table-layout: fixed; }
  table.coords th { text-align: left; padding: 6px 4px; background: #fafafa; border-bottom: 1px solid #ddd; position: sticky; top: 0; }
  table.coords td { padding: 3px 4px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
  table.coords tr.dirty td { background: #fffbe6; }
  table.coords input { width: 100%; padding: 3px 5px; font: inherit; border: 1px solid #ccc; border-radius: 3px; min-width: 0; }
  table.coords input.num { text-align: right; font-variant-numeric: tabular-nums; }
  /* Hide the native spinner arrows so the digits get all the horizontal room */
  table.coords input[type="number"]::-webkit-inner-spin-button,
  table.coords input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
  table.coords input[type="number"] { -moz-appearance: textfield; }
  table.coords input[readonly] { background: #f5f5f5; color: #666; }
  table.coords select { width: 100%; padding: 2px; font: inherit; }
  table.coords .label { color: #555; font-size: 11px; }
  table.coords .key { font-family: monospace; font-size: 11px; color: #1976d2; }
  table.coords .img-marker { color: #d9534f; font-size: 10px; font-weight: 600; }
  table.coords td.del { width: 24px; text-align: center; }
  table.coords td.del button { background: transparent; border: 0; color: #d9534f; cursor: pointer; font-size: 14px; padding: 0; }
  table.coords td.del button:hover { color: #8a2626; }
  #preview { background: #eee; display: flex; flex-direction: column; overflow: hidden; }
  .vis-toolbar { padding: 6px 10px; background: #fff; border-bottom: 1px solid #ddd;
                 display: flex; gap: 10px; align-items: center; font-size: 12px; }
  .vis-toolbar button { padding: 4px 8px; font: inherit; cursor: pointer;
                        border: 1px solid #ccc; border-radius: 3px; background: #fff; }
  .vis-toolbar .spacer { flex: 1; }
  .vis-toolbar .hint { color: #666; }
  #canvasContainer { position: relative; overflow: auto; flex: 1; padding: 16px; background: #dcdcdc; }
  #canvasStage { position: relative; margin: 0 auto; box-shadow: 0 0 6px rgba(0,0,0,0.25); background: #fff; }
  #pdfCanvas { display: block; }
  #markersLayer { position: absolute; inset: 0; pointer-events: none; }
  .marker {
      position: absolute; box-sizing: border-box;
      border: 1px solid rgba(30,144,255,0.7); background: rgba(30,144,255,0.12);
      cursor: move; pointer-events: auto; touch-action: none;
      font-size: 10px; color: #1565c0; user-select: none;
      display: flex; align-items: center; justify-content: center; text-align: center;
      /* No overflow:hidden here — it would clip the resize handle which sits
         OUTSIDE the marker bounds. Long labels are clipped on .marker-label. */
  }
  .marker.image { border-color: rgba(217,83,79,0.7); background: rgba(217,83,79,0.15); color: #8a2626; }
  .marker:hover { background: rgba(30,144,255,0.22); }
  .marker.image:hover { background: rgba(217,83,79,0.25); }
  .marker.selected { outline: 2px solid #ff9800; outline-offset: 1px; z-index: 5; }
  .marker.dragging { opacity: 0.85; z-index: 10; }
  .marker .marker-label { pointer-events: none; padding: 0 2px; font-family: monospace; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; }
  /* Resize handle: fully OUTSIDE the marker body so it can't intercept
     drags on thin markers (e.g., 5mm-tall signature rows). Only shown
     while the marker is selected to avoid cluttering the canvas. */
  .marker .handle { position: absolute; width: 12px; height: 12px; background: #fff;
                    border: 1px solid #1E90FF; bottom: -14px; right: -14px;
                    cursor: nwse-resize; display: none; }
  .marker.image .handle { border-color: #d9534f; }
  .marker.selected .handle { display: block; }
  #previewFrameWrap { display: none; flex: 0 0 260px; border-top: 1px solid #999; background: #fff; }
  #previewFrameWrap iframe { width: 100%; height: 100%; border: 0; }
  #previewFrameWrap.open { display: block; }

  table.coords tr.selected td { background: #fff3e0; }

  .key-col { min-width: 160px; max-width: 220px; }
  .x-col, .y-col, .w-col, .h-col { width: 72px; }
  .fs-col { width: 52px; }
  .align-col, .type-col { width: 60px; }

  .add-row { margin: 12px 0; padding: 10px; background: #f8f9fa; border: 1px dashed #ccc; border-radius: 4px; }
  .add-row h3 { margin: 0 0 8px 0; font-size: 13px; }
  .add-row > div { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
  .add-row select, .add-row input { padding: 4px 6px; }
</style>
</head>
<body>
<div class="app">
  <header>
    <h1>Contract Field Editor</h1>
    <form method="GET" style="display: contents;">
      <label>Template
        <select name="template" onchange="this.form.submit()">
          <?php foreach (['unsecured_2024_09_01'=>'Unsecured (9.1.2024)','secured'=>'Secured'] as $k=>$v): ?>
            <option value="<?php echo $k; ?>" <?php if ($k===$template) echo 'selected'; ?>><?php echo $v; ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label>Page
        <select name="page" onchange="this.form.submit()">
          <?php for ($p=1; $p<=$total_pages; $p++): ?>
            <option value="<?php echo $p; ?>" <?php if ($p===$page_num) echo 'selected'; ?>>p<?php echo $p; ?></option>
          <?php endfor; ?>
        </select>
      </label>
    </form>
    <div class="spacer"></div>
    <button type="button" class="primary" id="btnSave">Save &amp; refresh preview</button>
    <label style="display:flex;align-items:center;gap:4px;">
      <input type="radio" name="ds" value="demo" checked> demo data
    </label>
    <label style="display:flex;align-items:center;gap:4px;">
      <input type="radio" name="ds" value="real"> real loan
      <input type="text" id="realKey" placeholder="email_key" value="<?php echo htmlspecialchars($preview_real_loan_key); ?>" style="width: 110px;">
    </label>
    <span class="status" id="status"></span>
  </header>

  <div id="editor">
    <div style="color:#666; margin-bottom: 8px;">
      <?php echo count($rows); ?> field(s) on <?php echo htmlspecialchars($template); ?> · page <?php echo $page_num; ?>.
      Units in mm (US Letter = 215.9 × 279.4 mm).
    </div>

    <table class="coords">
      <colgroup>
        <col style="width: 220px;">   <!-- Field -->
        <col style="width: 78px;">    <!-- x   -->
        <col style="width: 78px;">    <!-- y   -->
        <col style="width: 78px;">    <!-- w   -->
        <col style="width: 78px;">    <!-- h   -->
        <col style="width: 56px;">    <!-- font -->
        <col style="width: 60px;">    <!-- align -->
        <col style="width: 60px;">    <!-- type  -->
        <col style="width: 28px;">    <!-- del  -->
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>x</th>
          <th>y</th>
          <th>w</th>
          <th>h</th>
          <th>font</th>
          <th>align</th>
          <th>type</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="rowsBody">
        <?php foreach ($rows as $r):
            $label = $CONTRACT_FIELD_CATALOG[$r['field_key']]['label'] ?? $r['field_key'];
        ?>
          <tr data-id="<?php echo (int)$r['id']; ?>"
              data-field-key="<?php echo htmlspecialchars($r['field_key']); ?>"
              data-field-type="<?php echo $r['field_type']; ?>">
            <td>
              <div class="label" title="<?php echo htmlspecialchars($label); ?>"><?php echo htmlspecialchars($label); ?></div>
              <div class="key"><?php echo htmlspecialchars($r['field_key']); ?>
                <?php if ($r['field_type']==='image'): ?><span class="img-marker"> (img)</span><?php endif; ?>
              </div>
            </td>
            <td><input type="number" step="0.1" class="num x" value="<?php echo $r['x_mm']; ?>"></td>
            <td><input type="number" step="0.1" class="num y" value="<?php echo $r['y_mm']; ?>"></td>
            <td><input type="number" step="0.1" class="num w" value="<?php echo $r['w_mm']; ?>"></td>
            <td><input type="number" step="0.1" class="num h" value="<?php echo $r['h_mm']; ?>"></td>
            <td><input type="number" step="1" class="num fs" value="<?php echo $r['font_size']; ?>"></td>
            <td>
              <select class="align">
                <option value="C" <?php if ($r['align']==='C') echo 'selected'; ?>>C</option>
                <option value="L" <?php if ($r['align']==='L') echo 'selected'; ?>>L</option>
                <option value="R" <?php if ($r['align']==='R') echo 'selected'; ?>>R</option>
              </select>
            </td>
            <td>
              <input value="<?php echo $r['field_type']; ?>" readonly>
            </td>
            <td class="del"><button type="button" onclick="delRow(this)" title="Delete">×</button></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="add-row">
      <h3>Add a new field to this page</h3>
      <div>
        <select id="newKey">
          <?php foreach ($CONTRACT_FIELD_CATALOG as $k=>$v): ?>
            <option value="<?php echo $k; ?>" data-type="<?php echo $v['type']; ?>">
              <?php echo htmlspecialchars($v['label']); ?> (<?php echo $k; ?>)
            </option>
          <?php endforeach; ?>
        </select>
        <input type="number" id="newX" placeholder="x" step="0.1" style="width:70px;" value="60">
        <input type="number" id="newY" placeholder="y" step="0.1" style="width:70px;" value="60">
        <input type="number" id="newW" placeholder="w" step="0.1" style="width:70px;" value="40">
        <input type="number" id="newH" placeholder="h" step="0.1" style="width:50px;" value="5">
        <button type="button" onclick="insertNew()">+ Add</button>
      </div>
    </div>
  </div>

  <div id="preview">
    <div class="vis-toolbar">
      <span class="hint">Drag markers to reposition · drag corner to resize · click to highlight the row.</span>
      <span class="spacer"></span>
      <label><input type="checkbox" id="chkShowPreview"> Show rendered PDF below</label>
      <button type="button" id="btnReloadTpl">↻ Reload template</button>
    </div>
    <div id="canvasContainer">
      <div id="canvasStage">
        <canvas id="pdfCanvas"></canvas>
        <div id="markersLayer"></div>
      </div>
    </div>
    <div id="previewFrameWrap">
      <iframe id="previewFrame" src="about:blank"></iframe>
    </div>
  </div>
</div>

<!-- pdf.js for rendering the template page visually -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

const TEMPLATE = <?php echo json_encode($template); ?>;
const PAGE_NUM = <?php echo (int)$page_num; ?>;
const SELF = '<?php echo basename($_SERVER['SCRIPT_NAME']); ?>';
const PDF_URLS = {
    unsecured_2024_09_01: '../../../signature_commercial_loan/Loan-Agreement-Unsecured-2024-09-01.pdf',
    secured:              '../../../signature_commercial_loan/Loan-Agreement-Secured.pdf'
};

// US Letter: 612 pt wide × 792 pt tall. 1 pt = 25.4/72 mm ≈ 0.3528 mm.
// We render the canvas at 1 CSS px per PDF point (so a 612-pt page is 612 CSS px).
// Therefore 1 mm = 72/25.4 ≈ 2.8346 CSS px.
const PX_PER_MM = 72 / 25.4;
const mmToPx = mm => Number(mm) * PX_PER_MM;
const pxToMm = px => Number(px) / PX_PER_MM;

const statusEl     = document.getElementById('status');
const realKeyInput = document.getElementById('realKey');
const frame        = document.getElementById('previewFrame');
const stage        = document.getElementById('canvasStage');
const layer        = document.getElementById('markersLayer');
const canvas       = document.getElementById('pdfCanvas');

function markDirty(tr) { tr.classList.add('dirty'); }

document.querySelectorAll('#rowsBody input, #rowsBody select').forEach(el => {
    el.addEventListener('change', () => {
        const tr = el.closest('tr');
        markDirty(tr);
        // Live-sync: if x/y/w/h/h changed, nudge the visual marker too
        const m = getMarker(tr);
        if (m) syncMarkerFromRow(m, tr);
    });
    el.addEventListener('input', () => markDirty(el.closest('tr')));
});

function collectRows() {
    const out = [];
    document.querySelectorAll('#rowsBody tr').forEach(tr => {
        out.push({
            id: +tr.dataset.id,
            x_mm: +tr.querySelector('.x').value,
            y_mm: +tr.querySelector('.y').value,
            w_mm: +tr.querySelector('.w').value,
            h_mm: +tr.querySelector('.h').value,
            font_size: +tr.querySelector('.fs').value,
            align: tr.querySelector('.align').value,
        });
    });
    return out;
}

async function saveAll() {
    statusEl.textContent = 'Saving…';
    const body = new URLSearchParams();
    body.set('action', 'save');
    body.set('rows', JSON.stringify(collectRows()));
    const res = await fetch(SELF, { method: 'POST', body });
    const j = await res.json();
    if (!j.ok) { statusEl.textContent = 'save error: ' + (j.error || '?'); return; }
    statusEl.textContent = `saved ${j.updated} row(s)`;
    document.querySelectorAll('#rowsBody tr.dirty').forEach(tr => tr.classList.remove('dirty'));
    if (document.getElementById('chkShowPreview').checked) refreshPreview();
}

function refreshPreview() {
    const useDemo = document.querySelector('input[name="ds"]:checked').value === 'demo';
    const realKey = realKeyInput.value.trim();
    const id = realKey || 'DEMO';
    const url = '../../../signature_commercial_loan/files/contract_pdf.php'
        + '?id=' + encodeURIComponent(id)
        + '&page=' + PAGE_NUM
        + '&template=' + encodeURIComponent(TEMPLATE)
        + (useDemo ? '&demo=1' : '')
        + '&_ts=' + Date.now();
    frame.src = url;
}

async function delRow(btn) {
    const tr = btn.closest('tr');
    const id = +tr.dataset.id;
    if (!id) { tr.remove(); return; }
    if (!confirm('Delete this field placement?')) return;
    const body = new URLSearchParams({action: 'delete', id});
    let res;
    try {
        res = await fetch(SELF, { method: 'POST', body, credentials: 'same-origin' });
    } catch (e) {
        alert('Delete network error: ' + e.message);
        return;
    }
    const txt = await res.text();
    let j;
    try { j = JSON.parse(txt); }
    catch (e) {
        alert('Delete returned non-JSON (HTTP ' + res.status + '). First 200 chars:\n\n' + txt.slice(0, 200));
        return;
    }
    if (j.ok) {
        tr.remove();
        removeMarker(id);
        statusEl.textContent = 'deleted';
    } else {
        alert('Delete failed (HTTP ' + res.status + '): ' + (j.error || '?'));
    }
}

async function insertNew() {
    const sel = document.getElementById('newKey');
    const key = sel.value;
    const type = sel.selectedOptions[0].dataset.type || 'text';
    const body = new URLSearchParams({
        action: 'insert', template: TEMPLATE, page_num: PAGE_NUM,
        field_key: key, field_type: type,
        x_mm: +document.getElementById('newX').value,
        y_mm: +document.getElementById('newY').value,
        w_mm: +document.getElementById('newW').value,
        h_mm: +document.getElementById('newH').value,
    });
    const res = await fetch(SELF, { method: 'POST', body });
    const j = await res.json();
    if (j.ok) { location.reload(); }
    else { alert('Insert failed: ' + (j.error || '?')); }
}

document.getElementById('btnSave').addEventListener('click', saveAll);
document.querySelectorAll('input[name="ds"]').forEach(r => r.addEventListener('change', () => {
    if (document.getElementById('chkShowPreview').checked) refreshPreview();
}));
realKeyInput.addEventListener('change', () => {
    if (document.querySelector('input[name="ds"]:checked').value === 'real'
        && document.getElementById('chkShowPreview').checked) refreshPreview();
});
document.getElementById('chkShowPreview').addEventListener('change', e => {
    document.getElementById('previewFrameWrap').classList.toggle('open', e.target.checked);
    if (e.target.checked) refreshPreview();
});
document.getElementById('btnReloadTpl').addEventListener('click', () => loadPdfPage());

// ====================== VISUAL EDITOR ======================

// Map: id → marker DOM element
const markerMap = new Map();

function getMarker(tr) { return markerMap.get(+tr.dataset.id); }
function getRow(id)    { return document.querySelector(`#rowsBody tr[data-id="${id}"]`); }

function removeMarker(id) {
    const m = markerMap.get(id);
    if (m) { m.remove(); markerMap.delete(id); }
}

async function loadPdfPage() {
    const url = PDF_URLS[TEMPLATE];
    if (!url) { return; }
    statusEl.textContent = 'Loading template…';
    try {
        const task = pdfjsLib.getDocument(url);
        const pdf  = await task.promise;
        const page = await pdf.getPage(PAGE_NUM);
        const dpr  = window.devicePixelRatio || 1;
        // Render at DPR for crisp display, keep CSS size = PDF point size.
        const viewport = page.getViewport({ scale: dpr });
        canvas.width  = viewport.width;
        canvas.height = viewport.height;
        canvas.style.width  = (viewport.width / dpr) + 'px';
        canvas.style.height = (viewport.height / dpr) + 'px';
        stage.style.width  = canvas.style.width;
        stage.style.height = canvas.style.height;
        const ctx = canvas.getContext('2d');
        await page.render({ canvasContext: ctx, viewport }).promise;
        statusEl.textContent = `template ${TEMPLATE} p${PAGE_NUM} loaded`;
        renderMarkers();
    } catch (e) {
        statusEl.textContent = 'pdf.js load error — ' + e.message;
        console.error(e);
    }
}

function renderMarkers() {
    layer.innerHTML = '';
    markerMap.clear();
    document.querySelectorAll('#rowsBody tr').forEach(tr => {
        const m = createMarker(tr);
        layer.appendChild(m);
        markerMap.set(+tr.dataset.id, m);
    });
}

function createMarker(tr) {
    const id   = +tr.dataset.id;
    const key  = tr.dataset.fieldKey;
    const type = tr.dataset.fieldType || 'text';
    const m = document.createElement('div');
    m.className = 'marker ' + type;
    m.dataset.id = id;
    m.innerHTML = `<span class="marker-label">${key}</span><div class="handle"></div>`;
    syncMarkerFromRow(m, tr);
    wireMarkerEvents(m, tr);
    return m;
}

function syncMarkerFromRow(marker, tr) {
    const x = +tr.querySelector('.x').value;
    const y = +tr.querySelector('.y').value;
    const w = +tr.querySelector('.w').value;
    const h = +tr.querySelector('.h').value;
    marker.style.left   = mmToPx(x) + 'px';
    marker.style.top    = mmToPx(y) + 'px';
    marker.style.width  = Math.max(6, mmToPx(w)) + 'px';
    marker.style.height = Math.max(6, mmToPx(h)) + 'px';
}

function selectMarker(id) {
    document.querySelectorAll('.marker').forEach(m => m.classList.remove('selected'));
    document.querySelectorAll('#rowsBody tr').forEach(tr => tr.classList.remove('selected'));
    const m = markerMap.get(id);
    const tr = getRow(id);
    if (m) m.classList.add('selected');
    if (tr) {
        tr.classList.add('selected');
        tr.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function wireMarkerEvents(marker, tr) {
    let mode = null;   // 'drag' | 'resize'
    let start = null;

    marker.addEventListener('pointerdown', e => {
        if (e.target.classList.contains('handle')) {
            mode = 'resize';
        } else {
            mode = 'drag';
        }
        marker.setPointerCapture(e.pointerId);
        start = {
            x: e.clientX, y: e.clientY,
            left:   parseFloat(marker.style.left),
            top:    parseFloat(marker.style.top),
            width:  parseFloat(marker.style.width),
            height: parseFloat(marker.style.height),
        };
        marker.classList.add('dragging');
        selectMarker(+marker.dataset.id);
        e.preventDefault();
    });

    marker.addEventListener('pointermove', e => {
        if (!start) return;
        const dx = e.clientX - start.x;
        const dy = e.clientY - start.y;
        if (mode === 'drag') {
            marker.style.left = Math.max(0, start.left + dx) + 'px';
            marker.style.top  = Math.max(0, start.top  + dy) + 'px';
        } else {
            marker.style.width  = Math.max(6, start.width  + dx) + 'px';
            marker.style.height = Math.max(6, start.height + dy) + 'px';
        }
    });

    const finish = () => {
        if (!start) return;
        marker.classList.remove('dragging');
        // Write back to row inputs (in mm, 2-decimal precision)
        const newX = pxToMm(parseFloat(marker.style.left)).toFixed(2);
        const newY = pxToMm(parseFloat(marker.style.top)).toFixed(2);
        const newW = pxToMm(parseFloat(marker.style.width)).toFixed(2);
        const newH = pxToMm(parseFloat(marker.style.height)).toFixed(2);
        const xi = tr.querySelector('.x'); const yi = tr.querySelector('.y');
        const wi = tr.querySelector('.w'); const hi = tr.querySelector('.h');
        const dirty = (xi.value != newX) || (yi.value != newY)
                   || (mode === 'resize' && (wi.value != newW || hi.value != newH));
        xi.value = newX; yi.value = newY;
        if (mode === 'resize') { wi.value = newW; hi.value = newH; }
        if (dirty) markDirty(tr);
        start = null; mode = null;
    };

    marker.addEventListener('pointerup',     finish);
    marker.addEventListener('pointercancel', finish);
}

// Click on a row (not on an input) selects the corresponding marker.
document.querySelectorAll('#rowsBody tr').forEach(tr => {
    tr.addEventListener('click', e => {
        if (['INPUT','SELECT','BUTTON'].includes(e.target.tagName)) return;
        selectMarker(+tr.dataset.id);
    });
});

// Kick everything off
loadPdfPage();
</script>
</body>
</html>
