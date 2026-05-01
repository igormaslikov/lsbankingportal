-- ============================================================
-- Patch: add Payment Schedule amount + frequency fields on
-- Promissory Note pages of both contract templates.
--
-- Adds: pay_sched_first_amount, pay_sched_each_amount,
--       pay_sched_last_amount, pay_sched_frequency
--
-- Uses INSERT IGNORE so existing rows (including any user-tuned
-- positions for already-present fields) are preserved.
-- ============================================================

-- Unsecured pages 3 (EN) and 5 (ES)
INSERT IGNORE INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('unsecured_2024_09_01', 3, 'loan.pay_sched_first_amount', 'text',  97, 106, 18, 5, 9, 'C'),
  ('unsecured_2024_09_01', 3, 'loan.pay_sched_each_amount',  'text',  97, 114, 18, 5, 9, 'C'),
  ('unsecured_2024_09_01', 3, 'loan.pay_sched_frequency',    'text', 108, 114, 16, 5, 9, 'C'),
  ('unsecured_2024_09_01', 3, 'loan.pay_sched_last_amount',  'text',  97, 121, 18, 5, 9, 'C'),
  ('unsecured_2024_09_01', 5, 'loan.pay_sched_first_amount', 'text',  97, 106, 18, 5, 9, 'C'),
  ('unsecured_2024_09_01', 5, 'loan.pay_sched_each_amount',  'text',  97, 114, 18, 5, 9, 'C'),
  ('unsecured_2024_09_01', 5, 'loan.pay_sched_frequency',    'text', 108, 114, 16, 5, 9, 'C'),
  ('unsecured_2024_09_01', 5, 'loan.pay_sched_last_amount',  'text',  97, 121, 18, 5, 9, 'C');

-- Secured pages 3 (EN) and 13 (ES)
INSERT IGNORE INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('secured', 3,  'loan.pay_sched_first_amount', 'text',  92, 199, 18, 5, 9, 'C'),
  ('secured', 3,  'loan.pay_sched_each_amount',  'text',  92, 207, 18, 5, 9, 'C'),
  ('secured', 3,  'loan.pay_sched_frequency',    'text', 108, 207, 18, 5, 9, 'C'),
  ('secured', 3,  'loan.pay_sched_last_amount',  'text',  92, 215, 18, 5, 9, 'C'),
  ('secured', 13, 'loan.pay_sched_first_amount', 'text',  92, 199, 18, 5, 9, 'C'),
  ('secured', 13, 'loan.pay_sched_each_amount',  'text',  92, 207, 18, 5, 9, 'C'),
  ('secured', 13, 'loan.pay_sched_frequency',    'text', 108, 207, 18, 5, 9, 'C'),
  ('secured', 13, 'loan.pay_sched_last_amount',  'text',  92, 215, 18, 5, 9, 'C');

-- Verify (expect 4 rows for each new field across both templates)
SELECT field_key, COUNT(*) AS rows_count
  FROM contract_field_coords
 WHERE field_key IN ('loan.pay_sched_first_amount','loan.pay_sched_each_amount',
                     'loan.pay_sched_last_amount','loan.pay_sched_frequency')
 GROUP BY field_key;
-- expect: each → 4
