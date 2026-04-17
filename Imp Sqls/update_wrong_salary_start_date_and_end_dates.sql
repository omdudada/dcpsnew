SELECT salary_start_date, salary_end_date
FROM dpt_master_dcps
WHERE MONTH(salary_start_date) <> MONTH(salary_end_date);

----------------------------------------------------------------
UPDATE dpt_master_dcps
SET salary_start_date = REPLACE(salary_start_date, '/', '-'),
    salary_end_date   = REPLACE(salary_end_date, '/', '-');
	
----------------------------------------------------------------
UPDATE dpt_master_dcps
SET salary_start_date = CONCAT(
        '01-',
        DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y')
    )
WHERE DATE_FORMAT(STR_TO_DATE(salary_start_date, '%d-%m-%Y'), '%m-%Y')
      <> DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y');
-----------------------------------------------------------------------------------
UPDATE dpt_master_dcps
SET salary_start_date = CONCAT(
        LPAD(DAY(STR_TO_DATE(salary_start_date, '%d-%m-%Y')), 2, '0'), '-',
        DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y')
    )
WHERE DATE_FORMAT(STR_TO_DATE(salary_start_date, '%d-%m-%Y'), '%m-%Y')
      <> DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y');

-----------------------------------------------------------------------------------	
SELECT salary_start_date AS old_start,
       CONCAT(
        '01-',
        DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y')
    ) AS new_start,
       salary_end_date
FROM dpt_master_dcps
WHERE DATE_FORMAT(STR_TO_DATE(salary_start_date, '%d-%m-%Y'), '%m-%Y')
      <> DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y');
	  
-------------------------------------------------------	  
SELECT salary_start_date AS old_start,
CONCAT(
        SUBSTRING(salary_start_date, 4, 2), '-',  -- month part
        SUBSTRING(salary_start_date, 1, 2), '-',  -- day part
        SUBSTRING(salary_start_date, 7, 4)        -- year part
    ) AS new_start, salary_end_date       
FROM dpt_master_dcps
WHERE DATE_FORMAT(STR_TO_DATE(salary_start_date, '%d-%m-%Y'), '%m-%Y')
<> DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y') and SUBSTRING(salary_start_date, 4, 2) > 1;
	  
	  
	  SELECT 
    salary_start_date,
    DATE_FORMAT(STR_TO_DATE(salary_start_date, '%d-%m-%Y'), '%m') AS month_part
FROM dpt_master_dcps WHERE DATE_FORMAT(STR_TO_DATE(salary_start_date, '%d-%m-%Y'), '%m-%Y')
      <> DATE_FORMAT(STR_TO_DATE(salary_end_date, '%d-%m-%Y'), '%m-%Y');
	  
	  
SELECT 
    salary_start_date AS old_start,
    CONCAT(
        SUBSTRING(salary_start_date, 4, 2), '-',  -- month part
        SUBSTRING(salary_start_date, 1, 2), '-',  -- day part
        SUBSTRING(salary_start_date, 7, 4)        -- year part
    ) AS swapped_date
FROM dpt_master_dcps;	  