SELECT 
	emp_td,
	for_month, 
	for_year,
    basic, 
    da, 
    total_salary, 
    grade_pay, 
    recovered_DCPS_with_voucher_no, 
    recovered_DCPS_with_voucher_date, 
    salary_type, 
    salary_start_date, 
    salary_end_date,
    COUNT(*) AS duplicate_count
FROM dpt_master_dcps
WHERE emp_td > 0 and is_deleted = 0
GROUP BY  
	emp_td,
	for_month, 
	for_year,
    basic, 
    da, 
    total_salary, 
    grade_pay, 
    recovered_DCPS_with_voucher_no, 
    recovered_DCPS_with_voucher_date, 
    salary_type, 
    salary_start_date, 
    salary_end_date
HAVING COUNT(*) > 1;
==================================================================================
/* Kept Last record and remove others */

UPDATE dpt_master_dcps d1
JOIN dpt_master_dcps d2
  ON d1.emp_td = d2.emp_td
 AND d1.for_month = d2.for_month
 AND d1.for_year = d2.for_year
 AND d1.basic = d2.basic
 AND d1.da = d2.da
 AND d1.total_salary = d2.total_salary
 AND d1.grade_pay = d2.grade_pay
 AND d1.recovered_DCPS_with_voucher_no = d2.recovered_DCPS_with_voucher_no
 AND d1.recovered_DCPS_with_voucher_date = d2.recovered_DCPS_with_voucher_date
 AND d1.salary_type = d2.salary_type
 AND d1.salary_start_date = d2.salary_start_date
 AND d1.salary_end_date = d2.salary_end_date
 AND d1.id < d2.id   -- KEEP LAST RECORD (highest id)

SET d1.is_deleted = 3
WHERE (d1.remark IS NULL OR d1.remark = '');


==================================================================================
UPDATE dpt_master_dcps
SET is_deleted = 4
WHERE is_deleted = 0
  AND emp_td > 0
  AND (
        for_month = 0 
        OR for_month IS NULL 
        OR for_year = 0 
        OR for_year IS NULL
      )
  AND (remark IS NULL OR remark = '');

==================================================================================
/* Kept first record and remove others */
WITH ranked AS (
    SELECT 
        id,
        ROW_NUMBER() OVER (
            PARTITION BY emp_td,
                         for_month,
                         for_year,
                         basic, 
                         da, 
                         total_salary, 
                         grade_pay, 
                         recovered_DCPS_with_voucher_no, 
                         recovered_DCPS_with_voucher_date, 
                         salary_type, 
                         salary_start_date, 
                         salary_end_date
            ORDER BY id ASC
        ) AS rn
    FROM dpt_master_dcps
)
UPDATE dpt_master_dcps d
JOIN ranked r ON d.id = r.id
SET d.is_deleted = 3
WHERE r.rn > 1 and remark is null or remark = '';

==================================================================================

/* Remove duplicate record */

WITH ranked AS (
    SELECT 
        id,
        ROW_NUMBER() OVER (
            PARTITION BY emp_td,
                         for_month,
                         for_year,
                         basic, 
                         da, 
                         total_salary, 
                         grade_pay, 
                         recovered_DCPS_with_voucher_no, 
                         recovered_DCPS_with_voucher_date, 
                         salary_type, 
                         salary_start_date, 
                         salary_end_date
            ORDER BY id ASC
        ) AS rn
    FROM dpt_master_dcps
)




DELETE FROM dpt_master_dcps
WHERE id IN (
    SELECT id FROM ranked WHERE rn > 1
);
--------------------------------------------------------------------------------
SELECT t1.*
FROM dpt_master_dcps t1
JOIN dpt_master_dcps t2 
  ON t1.emp_td = t2.emp_td
 AND t1.for_month = t2.for_month
 AND t1.for_year = t2.for_year
 AND t1.basic = t2.basic
 AND t1.da = t2.da
 AND t1.total_salary = t2.total_salary
 AND t1.grade_pay = t2.grade_pay
 AND t1.recovered_DCPS_with_voucher_no = t2.recovered_DCPS_with_voucher_no
 AND t1.recovered_DCPS_with_voucher_date = t2.recovered_DCPS_with_voucher_date
 AND t1.salary_type = t2.salary_type
 AND t1.salary_start_date = t2.salary_start_date
 AND t1.salary_end_date = t2.salary_end_date
 AND t1.id > t2.id;
-------------------------------------------------------------------------------
DELETE t1
FROM dpt_master_dcps t1
JOIN dpt_master_dcps t2 
  ON t1.emp_td = t2.emp_td
 AND t1.for_month = t2.for_month
 AND t1.for_year = t2.for_year
 AND t1.basic = t2.basic
 AND t1.da = t2.da
 AND t1.total_salary = t2.total_salary
 AND t1.grade_pay = t2.grade_pay
 AND t1.recovered_DCPS_with_voucher_no = t2.recovered_DCPS_with_voucher_no
 AND t1.recovered_DCPS_with_voucher_date = t2.recovered_DCPS_with_voucher_date
 AND t1.salary_type = t2.salary_type
 AND t1.salary_start_date = t2.salary_start_date
 AND t1.salary_end_date = t2.salary_end_date
 AND t1.id > t2.id;


