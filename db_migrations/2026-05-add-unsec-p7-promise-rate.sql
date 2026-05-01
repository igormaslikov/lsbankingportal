-- ============================================================
-- Patch: add Promise-to-Pay $ + Interest % fields on the
-- bilingual "Loan Agreement" page (Unsecured page 7).
--
-- Mirrors the legacy page_5() data: principal_f and anual_pr
-- displayed in both English (left column) and Spanish (right column).
-- ============================================================

INSERT IGNORE INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('unsecured_2024_09_01', 7, 'loan.promise_amount_en', 'text',  29,  81, 21, 4, 8, 'C'),
  ('unsecured_2024_09_01', 7, 'loan.promise_amount_es', 'text', 131,  82, 21, 4, 8, 'C'),
  ('unsecured_2024_09_01', 7, 'loan.interest_rate_en',  'text',  66, 164, 27, 4, 8, 'C'),
  ('unsecured_2024_09_01', 7, 'loan.interest_rate_es',  'text', 127, 159, 25, 4, 8, 'C');

-- Verify
SELECT field_key, x_mm, y_mm
  FROM contract_field_coords
 WHERE template='unsecured_2024_09_01' AND page_num=7
   AND field_key LIKE 'loan.%'
 ORDER BY field_key;
-- expect 4 rows
