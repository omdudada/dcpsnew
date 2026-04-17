select recovered_DCPS_with_voucher_date from dpt_master_dcps_new_19012025 where recovered_DCPS_with_voucher_date REGEXP '^[0-9]{5}$'; 
select salary_start_date from dpt_master_dcps_new_19012025 where salary_start_date REGEXP '^[0-9]{5}$'; 
select salary_end_date from dpt_master_dcps_new_19012025 where salary_end_date REGEXP '^[0-9]{5}$'; 

-----------------------------------------------------------------------------------------------------------
UPDATE dpt_master_dcps_new_19012025
SET recovered_DCPS_with_voucher_date = DATE_ADD('1899-12-30', INTERVAL recovered_DCPS_with_voucher_date DAY)
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{5}$';


UPDATE dpt_master_dcps_new_19012025
SET salary_start_date = DATE_ADD('1899-12-30', INTERVAL salary_start_date DAY)
WHERE salary_start_date REGEXP '^[0-9]{5}$';

	
UPDATE dpt_master_dcps_new_19012025
SET salary_end_date = DATE_ADD('1899-12-30', INTERVAL salary_end_date DAY)
WHERE salary_end_date REGEXP '^[0-9]{5}$';
-----------------------------------------------------------------------------------------------------------



select id, emp_td, emp_name, bunch_no, file_no, recovered_DCPS_with_voucher_no,  recovered_DCPS_with_voucher_date, recovered_DCPS_with_voucher_date_1, for_month, for_year from dpt_master_dcps_new_19012025_after_update where recovered_DCPS_with_voucher_date REGEXP '^[0-9]{5}$';

UPDATE dpt_master_dcps_new_19012025_after_update
SET recovered_DCPS_with_voucher_date_1 = DATE_ADD('1899-12-30', INTERVAL recovered_DCPS_with_voucher_date DAY)
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{5}$'; -- only 5-digit numbers like 41548




UPDATE dpt_master_dcps_new_19012025_after_update
SET recovered_DCPS_with_voucher_date_1 = STR_TO_DATE(recovered_DCPS_with_voucher_date, '%d-%m-%Y')
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$';

--------------------------------------------------------------------------------------------------------
/* 1. Dates in YYYY-MM-DD format */

SELECT id, recovered_DCPS_with_voucher_date, for_month, for_year
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
--------------------------------------------------------------------------------------------------------
/*  2. Dates in DD-MM-YYYY format */

SELECT id, recovered_DCPS_with_voucher_date, for_month, for_year
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$';
--------------------------------------------------------------------------------------------------------
/* 3. Dates in MM-DD-YYYY format */

SELECT id, recovered_DCPS_with_voucher_date, for_month, for_year
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$';
--------------------------------------------------------------------------------------------------------
/* Preview Before Update */
SELECT id,
       recovered_DCPS_with_voucher_date AS original_date,
       CONCAT(SUBSTRING(recovered_DCPS_with_voucher_date, 9, 2), '-', 
              SUBSTRING(recovered_DCPS_with_voucher_date, 6, 2), '-', 
              SUBSTRING(recovered_DCPS_with_voucher_date, 1, 4)) AS converted_date
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
-----------------------------------------------------------
SELECT id,
       salary_start_date AS original_date,
       CONCAT(SUBSTRING(salary_start_date, 9, 2), '-', 
              SUBSTRING(salary_start_date, 6, 2), '-', 
              SUBSTRING(salary_start_date, 1, 4)) AS converted_date
FROM dpt_master_dcps_new_19012025
WHERE salary_start_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
-----------------------------------------------------------
SELECT id,
       salary_end_date AS original_date,
       CONCAT(SUBSTRING(salary_end_date, 9, 2), '-', 
              SUBSTRING(salary_end_date, 6, 2), '-', 
              SUBSTRING(salary_end_date, 1, 4)) AS converted_date
FROM dpt_master_dcps_new_19012025
WHERE salary_end_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
-----------------------------------------------------------------------------------------
/* Update Query to Convert YYYY-MM-DD → DD-MM-YYYY */

UPDATE dpt_master_dcps_new_19012025
SET recovered_DCPS_with_voucher_date = CONCAT(
    SUBSTRING(recovered_DCPS_with_voucher_date, 9, 2), '-',  -- DD
    SUBSTRING(recovered_DCPS_with_voucher_date, 6, 2), '-',  -- MM
    SUBSTRING(recovered_DCPS_with_voucher_date, 1, 4)        -- YYYY
)
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
-----------------------------------------------------------
UPDATE dpt_master_dcps_new_19012025
SET salary_start_date = CONCAT(
    SUBSTRING(salary_start_date, 9, 2), '-',  -- DD
    SUBSTRING(salary_start_date, 6, 2), '-',  -- MM
    SUBSTRING(salary_start_date, 1, 4)        -- YYYY
)
WHERE salary_start_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
-----------------------------------------------------------
UPDATE dpt_master_dcps_new_19012025
SET salary_end_date = CONCAT(
    SUBSTRING(salary_end_date, 9, 2), '-',  -- DD
    SUBSTRING(salary_end_date, 6, 2), '-',  -- MM
    SUBSTRING(salary_end_date, 1, 4)        -- YYYY
)
WHERE salary_end_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
--------------------------------------------------------------------------------------------------------
SELECT id, recovered_DCPS_with_voucher_date, for_month, for_year
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(recovered_DCPS_with_voucher_date, 1, 2) AS UNSIGNED) = for_month;
--------------------------------------------------------------------------------
SELECT id, salary_start_date, for_month, for_year
FROM dpt_master_dcps_new_19012025
WHERE salary_start_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(salary_start_date, 1, 2) AS UNSIGNED) = for_month;
--------------------------------------------------------------------------------
SELECT id, salary_end_date, for_month, for_year
FROM dpt_master_dcps_new_19012025
WHERE salary_end_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(salary_end_date, 1, 2) AS UNSIGNED) = for_month;
--------------------------------------------------------------------------------



SELECT id, recovered_DCPS_with_voucher_date, for_month, for_year
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(recovered_DCPS_with_voucher_date, 1, 2) AS UNSIGNED) != for_month;





------------------------------------------------------------------------------------------------------

SELECT id,
       recovered_DCPS_with_voucher_date AS original_date,
       for_month,
       for_year,
       CONCAT(
           SUBSTRING(recovered_DCPS_with_voucher_date, 4, 2), '-',  -- DD
           SUBSTRING(recovered_DCPS_with_voucher_date, 1, 2), '-',  -- MM
           SUBSTRING(recovered_DCPS_with_voucher_date, 7, 4)        -- YYYY
       ) AS reformatted_date
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(recovered_DCPS_with_voucher_date, 1, 2) AS UNSIGNED) = for_month;
-------------------------------------------------------------------------
SELECT id, emp_td, 
       salary_start_date AS start_original_date, salary_end_date, 
       for_month,
       for_year,
       CONCAT(
           SUBSTRING(salary_start_date, 4, 2), '-',  -- DD
           SUBSTRING(salary_start_date, 1, 2), '-',  -- MM
           SUBSTRING(salary_start_date, 7, 4)        -- YYYY
       ) AS reformatted_date
FROM dpt_master_dcps_new_19012025
WHERE salary_start_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(salary_start_date, 1, 2) AS UNSIGNED) = for_month;
-------------------------------------------------------------------------
SELECT id, emp_td, 
       salary_end_date AS end_original_date,
       for_month,
       for_year,
       CONCAT(
           SUBSTRING(salary_end_date, 4, 2), '-',  -- DD
           SUBSTRING(salary_end_date, 1, 2), '-',  -- MM
           SUBSTRING(salary_end_date, 7, 4)        -- YYYY
       ) AS reformatted_date
FROM dpt_master_dcps_new_19012025
WHERE salary_end_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(salary_end_date, 1, 2) AS UNSIGNED) = for_month;
-------------------------------------------------------------------------

----------------------------------------------------------------------------------------------------

UPDATE dpt_master_dcps_new_19012025
SET recovered_DCPS_with_voucher_date = CONCAT(
    SUBSTRING(recovered_DCPS_with_voucher_date, 4, 2), '-',  -- DD
    SUBSTRING(recovered_DCPS_with_voucher_date, 1, 2), '-',  -- MM
    SUBSTRING(recovered_DCPS_with_voucher_date, 7, 4)        -- YYYY
)
WHERE recovered_DCPS_with_voucher_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(recovered_DCPS_with_voucher_date, 1, 2) AS UNSIGNED) = for_month;
-------------------------------------------------------------------------  
UPDATE dpt_master_dcps_new_19012025
SET salary_start_date = CONCAT(
    SUBSTRING(salary_start_date, 4, 2), '-',  -- DD
    SUBSTRING(salary_start_date, 1, 2), '-',  -- MM
    SUBSTRING(salary_start_date, 7, 4)        -- YYYY
)
WHERE salary_start_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$'
  AND CAST(SUBSTRING(salary_start_date, 1, 2) AS UNSIGNED) = for_month and emp_td = 9206;
-------------------------------------------------------------------------  
----------------------------------------------------------------------------------------------------
