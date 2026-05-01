-- ============================================================
-- Patch: SMS Policy fields (Unsec p13) + ACH paragraph fields
-- (Unsec p14 EN / p15 ES) + position adjustments on existing
-- ach.* fields whose y-coordinates were off by ~35mm.
--
-- Uses INSERT ... ON DUPLICATE KEY UPDATE — this WILL overwrite
-- the existing ach.* positions with corrected values. SMS rows
-- are net-new and use INSERT IGNORE.
-- ============================================================

-- New fields on Unsec p13 (SMS Policy Authorization) — net-new rows
INSERT IGNORE INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('unsecured_2024_09_01', 13, 'sms.borrower_name',      'text',   35, 194, 60, 5,  9, 'C'),
  ('unsecured_2024_09_01', 13, 'sms.coborrower_name',    'text',  121, 193, 60, 5,  9, 'C'),
  ('unsecured_2024_09_01', 13, 'sms.borrower_phone',     'text',   35, 212, 60, 5,  9, 'C'),
  ('unsecured_2024_09_01', 13, 'sms.coborrower_phone',   'text',  121, 212, 60, 5,  9, 'C'),
  ('unsecured_2024_09_01', 13, 'sms.borrower_sig_img',   'image',  35, 220, 60, 15, 9, 'C'),
  ('unsecured_2024_09_01', 13, 'sms.coborrower_sig_img', 'image', 121, 220, 60, 15, 9, 'C');

-- ACH paragraph blanks on Unsec p14 (English) — corrects + adds
INSERT INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('unsecured_2024_09_01', 14, 'ach.account_last4',       'text',  23, 65,  9, 5, 9, 'C'),
  ('unsecured_2024_09_01', 14, 'ach.bank_name',           'text',  60, 65, 56, 5, 9, 'C'),
  ('unsecured_2024_09_01', 14, 'ach.payment_amount',      'text',  98, 68, 13, 5, 9, 'C'),
  ('unsecured_2024_09_01', 14, 'ach.frequency_short_en',  'text', 165, 68, 22, 5, 9, 'C'),
  ('unsecured_2024_09_01', 14, 'ach.first_payment_date',  'text',  62, 72, 14, 5, 9, 'C')
ON DUPLICATE KEY UPDATE
  field_type=VALUES(field_type), x_mm=VALUES(x_mm), y_mm=VALUES(y_mm),
  w_mm=VALUES(w_mm), h_mm=VALUES(h_mm), font_size=VALUES(font_size), align=VALUES(align);

-- ACH paragraph blanks on Unsec p15 (Spanish) — corrects + adds
INSERT INTO contract_field_coords
  (template, page_num, field_key, field_type, x_mm, y_mm, w_mm, h_mm, font_size, align)
VALUES
  ('unsecured_2024_09_01', 15, 'header.borrower_name',    'text',  75, 33,100, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'header.loan_number',      'text',  75, 38,100, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'header.date',             'text',  75, 44,100, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'ach.account_last4',       'text', 180, 64,  9, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'ach.bank_name',           'text',  48, 67, 60, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'ach.payment_amount',      'text', 115, 71, 13, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'ach.frequency_short_es',  'text',  14, 74, 30, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'ach.first_payment_date',  'text', 119, 74, 26, 5, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'signature.borrower_img',  'image', 13,224, 60,15, 9, 'C'),
  ('unsecured_2024_09_01', 15, 'ach.borrower_printed_name','text', 15,249, 70, 5, 9, 'C')
ON DUPLICATE KEY UPDATE
  field_type=VALUES(field_type), x_mm=VALUES(x_mm), y_mm=VALUES(y_mm),
  w_mm=VALUES(w_mm), h_mm=VALUES(h_mm), font_size=VALUES(font_size), align=VALUES(align);

-- Verify
SELECT page_num, COUNT(*) AS rows_count
  FROM contract_field_coords
 WHERE template='unsecured_2024_09_01' AND page_num IN (13,14,15)
 GROUP BY page_num;
-- expect:
--   p13 → 9   (header 3 + sms 6)
--   p14 → 9   (header 3 + ach 5 + signature/printed name 1+1 = 8 if pre-existing)
--   p15 → 10
