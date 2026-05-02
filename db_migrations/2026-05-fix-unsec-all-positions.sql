-- Auto-derived UPDATE for Unsecured pages 3-15
-- Extracts precise blank coordinates from the source PDF
-- and updates contract_field_coords accordingly.

-- Page 3 (promissory) - 21 blanks detected
UPDATE contract_field_coords SET x_mm=36.71, y_mm=13.34, w_mm=34.82 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.contract_no';
UPDATE contract_field_coords SET x_mm=161.72, y_mm=15.34, w_mm=27.03 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.date';
UPDATE contract_field_coords SET x_mm=37.21, y_mm=18.37, w_mm=61.85 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.borrower_line1';
UPDATE contract_field_coords SET x_mm=37.04, y_mm=23.11, w_mm=61.80 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.borrower_line2';
UPDATE contract_field_coords SET x_mm=37.80, y_mm=27.57, w_mm=61.84 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.borrower_line3';
UPDATE contract_field_coords SET x_mm=37.00, y_mm=32.31, w_mm=61.85 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.coborrower_line1';
UPDATE contract_field_coords SET x_mm=36.68, y_mm=37.34, w_mm=61.86 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.coborrower_line2';
UPDATE contract_field_coords SET x_mm=36.68, y_mm=42.08, w_mm=61.81 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.coborrower_line3';
UPDATE contract_field_coords SET x_mm=36.09, y_mm=46.95, w_mm=62.08 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.business_line1';
UPDATE contract_field_coords SET x_mm=36.63, y_mm=51.27, w_mm=62.08 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.business_line2';
UPDATE contract_field_coords SET x_mm=36.63, y_mm=55.93, w_mm=62.08 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.business_line3';
UPDATE contract_field_coords SET x_mm=25.49, y_mm=81.50, w_mm=22.05 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.apr';
UPDATE contract_field_coords SET x_mm=65.20, y_mm=81.50, w_mm=28.40 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.principal';
UPDATE contract_field_coords SET x_mm=114.06, y_mm=81.50, w_mm=28.40 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.total_interest';
UPDATE contract_field_coords SET x_mm=152.00, y_mm=81.50, w_mm=28.40 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.total_payments';
UPDATE contract_field_coords SET x_mm=116.90, y_mm=104.88, w_mm=18.96 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_first_date';
UPDATE contract_field_coords SET x_mm=150.77, y_mm=104.88, w_mm=17.36 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_beginning_date';
UPDATE contract_field_coords SET x_mm=116.90, y_mm=112.46, w_mm=18.96 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_each_date';
UPDATE contract_field_coords SET x_mm=120.96, y_mm=120.04, w_mm=18.97 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_last_date';
UPDATE contract_field_coords SET x_mm=73.00, y_mm=105.00, w_mm=8.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_first_num';
UPDATE contract_field_coords SET x_mm=73.00, y_mm=113.00, w_mm=8.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_count';
UPDATE contract_field_coords SET x_mm=93.00, y_mm=105.00, w_mm=18.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_first_amount';
UPDATE contract_field_coords SET x_mm=93.00, y_mm=113.00, w_mm=18.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_each_amount';
UPDATE contract_field_coords SET x_mm=115.00, y_mm=113.00, w_mm=14.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_frequency';
UPDATE contract_field_coords SET x_mm=93.00, y_mm=120.00, w_mm=18.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.pay_sched_last_amount';
UPDATE contract_field_coords SET x_mm=80.60, y_mm=138.40, w_mm=11.07 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.contract_fee';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=158.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.itemization_given';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=163.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.itemization_paid';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=167.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.itemization_financed';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=171.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.itemization_prepaid';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=175.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.itemization_principal';
UPDATE contract_field_coords SET x_mm=181.98, y_mm=243.65, w_mm=21.26 WHERE template='unsecured_2024_09_01' AND page_num=3 AND field_key='loan.initials_img';

-- Page 5 (promissory) - 21 blanks detected
UPDATE contract_field_coords SET x_mm=47.07, y_mm=14.68, w_mm=34.78 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.contract_no';
UPDATE contract_field_coords SET x_mm=175.35, y_mm=14.97, w_mm=27.03 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.date';
UPDATE contract_field_coords SET x_mm=46.81, y_mm=20.57, w_mm=61.77 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.borrower_line1';
UPDATE contract_field_coords SET x_mm=46.74, y_mm=25.31, w_mm=61.84 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.borrower_line2';
UPDATE contract_field_coords SET x_mm=46.46, y_mm=31.05, w_mm=61.76 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.borrower_line3';
UPDATE contract_field_coords SET x_mm=46.16, y_mm=35.79, w_mm=61.76 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.coborrower_line1';
UPDATE contract_field_coords SET x_mm=46.46, y_mm=40.54, w_mm=61.76 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.coborrower_line2';
UPDATE contract_field_coords SET x_mm=46.46, y_mm=45.28, w_mm=61.76 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.coborrower_line3';
UPDATE contract_field_coords SET x_mm=46.60, y_mm=51.47, w_mm=62.08 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.business_line1';
UPDATE contract_field_coords SET x_mm=46.54, y_mm=56.12, w_mm=62.08 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.business_line2';
UPDATE contract_field_coords SET x_mm=46.54, y_mm=60.78, w_mm=62.08 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.business_line3';
UPDATE contract_field_coords SET x_mm=118.50, y_mm=113.56, w_mm=18.93 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_each_date';
UPDATE contract_field_coords SET x_mm=119.74, y_mm=120.25, w_mm=18.92 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_last_date';
UPDATE contract_field_coords SET x_mm=73.00, y_mm=105.00, w_mm=8.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_first_num';
UPDATE contract_field_coords SET x_mm=73.00, y_mm=113.00, w_mm=8.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_count';
UPDATE contract_field_coords SET x_mm=93.00, y_mm=105.00, w_mm=18.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_first_amount';
UPDATE contract_field_coords SET x_mm=93.00, y_mm=113.00, w_mm=18.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_each_amount';
UPDATE contract_field_coords SET x_mm=115.00, y_mm=113.00, w_mm=14.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_frequency';
UPDATE contract_field_coords SET x_mm=93.00, y_mm=120.00, w_mm=18.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.pay_sched_last_amount';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=158.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.itemization_given';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=163.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.itemization_paid';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=167.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.itemization_financed';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=171.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.itemization_prepaid';
UPDATE contract_field_coords SET x_mm=170.00, y_mm=175.00, w_mm=30.00 WHERE template='unsecured_2024_09_01' AND page_num=5 AND field_key='loan.itemization_principal';

-- Page 4 (signature_page) - 5 blanks detected
UPDATE contract_field_coords SET x_mm=72.86, y_mm=33.83, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=4 AND field_key='header.borrower_name';
UPDATE contract_field_coords SET x_mm=72.94, y_mm=39.46, w_mm=82.68 WHERE template='unsecured_2024_09_01' AND page_num=4 AND field_key='header.loan_number';
UPDATE contract_field_coords SET x_mm=73.48, y_mm=155.03, w_mm=112.49 WHERE template='unsecured_2024_09_01' AND page_num=4 AND field_key='onsite.physical_address';
UPDATE contract_field_coords SET x_mm=12.70, y_mm=221.53, w_mm=60.00 WHERE template='unsecured_2024_09_01' AND page_num=4 AND field_key='signature.borrower_img';
UPDATE contract_field_coords SET x_mm=12.70, y_mm=238.42, w_mm=60.00 WHERE template='unsecured_2024_09_01' AND page_num=4 AND field_key='signature.coborrower_img';

-- Page 6 (signature_page) - 5 blanks detected
UPDATE contract_field_coords SET x_mm=12.70, y_mm=216.96, w_mm=60.00 WHERE template='unsecured_2024_09_01' AND page_num=6 AND field_key='signature.borrower_img';
UPDATE contract_field_coords SET x_mm=12.70, y_mm=233.81, w_mm=60.00 WHERE template='unsecured_2024_09_01' AND page_num=6 AND field_key='signature.coborrower_img';

-- Page 8 (header_only) - 4 blanks detected
UPDATE contract_field_coords SET x_mm=72.86, y_mm=20.19, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=8 AND field_key='header.borrower_name';
UPDATE contract_field_coords SET x_mm=71.84, y_mm=25.78, w_mm=82.68 WHERE template='unsecured_2024_09_01' AND page_num=8 AND field_key='header.loan_number';
UPDATE contract_field_coords SET x_mm=72.62, y_mm=31.41, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=8 AND field_key='header.date';

-- Page 9 (header_only) - 7 blanks detected
UPDATE contract_field_coords SET x_mm=72.86, y_mm=29.21, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=9 AND field_key='header.borrower_name';
UPDATE contract_field_coords SET x_mm=71.90, y_mm=34.84, w_mm=82.68 WHERE template='unsecured_2024_09_01' AND page_num=9 AND field_key='header.loan_number';
UPDATE contract_field_coords SET x_mm=72.62, y_mm=40.47, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=9 AND field_key='header.date';

-- Page 10 (header_only) - 5 blanks detected
UPDATE contract_field_coords SET x_mm=72.88, y_mm=24.43, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=10 AND field_key='header.borrower_name';
UPDATE contract_field_coords SET x_mm=71.84, y_mm=30.06, w_mm=82.68 WHERE template='unsecured_2024_09_01' AND page_num=10 AND field_key='header.loan_number';
UPDATE contract_field_coords SET x_mm=72.62, y_mm=35.65, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=10 AND field_key='header.date';

-- Page 11 (header_only) - 4 blanks detected
UPDATE contract_field_coords SET x_mm=72.90, y_mm=22.69, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=11 AND field_key='header.borrower_name';
UPDATE contract_field_coords SET x_mm=71.84, y_mm=28.32, w_mm=82.68 WHERE template='unsecured_2024_09_01' AND page_num=11 AND field_key='header.loan_number';
UPDATE contract_field_coords SET x_mm=72.60, y_mm=33.95, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=11 AND field_key='header.date';

-- Page 12 (header_only) - 5 blanks detected
UPDATE contract_field_coords SET x_mm=72.86, y_mm=22.69, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=12 AND field_key='header.borrower_name';
UPDATE contract_field_coords SET x_mm=71.90, y_mm=28.32, w_mm=82.68 WHERE template='unsecured_2024_09_01' AND page_num=12 AND field_key='header.loan_number';
UPDATE contract_field_coords SET x_mm=72.62, y_mm=33.95, w_mm=82.64 WHERE template='unsecured_2024_09_01' AND page_num=12 AND field_key='header.date';
