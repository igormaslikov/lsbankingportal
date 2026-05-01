-- ============================================================
-- Patch: add the "Due ____." (recurring row) field on the
-- Promissory Note pages of both contract templates, and
-- restore loan.pay_sched_first_num if it was deleted.
--
-- Uses INSERT IGNORE so any row that already exists is skipped
-- (no risk of overwriting positions you've already tuned).
-- ============================================================

-- Unsecured pages 3 (EN) and 5 (ES)
INSERT IGNORE INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('unsecured_2024_09_01', 3, 'loan.pay_sched_first_num',  'text', 75, 106, 15, 5, 9, 'C'),
  ('unsecured_2024_09_01', 3, 'loan.pay_sched_each_date',  'text', 120, 114, 22, 5, 9, 'C'),
  ('unsecured_2024_09_01', 5, 'loan.pay_sched_first_num',  'text', 75, 106, 15, 5, 9, 'C'),
  ('unsecured_2024_09_01', 5, 'loan.pay_sched_each_date',  'text', 120, 114, 22, 5, 9, 'C');

-- Secured pages 3 (EN) and 13 (ES)
INSERT IGNORE INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('secured', 3,  'loan.pay_sched_first_num', 'text', 70, 199, 15, 5, 9, 'C'),
  ('secured', 3,  'loan.pay_sched_each_date', 'text', 115, 207, 30, 5, 9, 'C'),
  ('secured', 13, 'loan.pay_sched_first_num', 'text', 70, 199, 15, 5, 9, 'C'),
  ('secured', 13, 'loan.pay_sched_each_date', 'text', 115, 207, 30, 5, 9, 'C');

-- Verify (expect 4 rows for each new field across both templates)
SELECT field_key, COUNT(*) AS rows_count
  FROM contract_field_coords
 WHERE field_key IN ('loan.pay_sched_first_num', 'loan.pay_sched_each_date')
 GROUP BY field_key;
-- expect: pay_sched_first_num 4 ; pay_sched_each_date 4
