SELECT emp_td, COUNT(DISTINCT TRIM(pay_center)) AS unique_pay_centers
FROM dpt_master_dcps_new_19012025
WHERE TRIM(pay_center) != '' AND pay_center IS NOT NULL
GROUP BY emp_td
HAVING COUNT(DISTINCT TRIM(pay_center)) > 1;
-----------------------------------------------------------------------------
SELECT emp_td, pay_center
FROM dpt_master_dcps_new_19012025
WHERE emp_td IN (
    SELECT emp_td
    FROM dpt_master_dcps_new_19012025
    WHERE TRIM(pay_center) != '' AND pay_center IS NOT NULL
    GROUP BY emp_td
    HAVING COUNT(DISTINCT TRIM(pay_center)) > 1
)
and emp_td > 0 
ORDER BY emp_td, pay_center;

-----------------------------------------------------------------------------
SELECT DISTINCT emp_td, TRIM(pay_center) AS pay_center
FROM dpt_master_dcps_new_19012025
WHERE emp_td > 0
  AND emp_td IN (
    SELECT emp_td
    FROM dpt_master_dcps_new_19012025
    WHERE TRIM(pay_center) != '' AND pay_center IS NOT NULL
    GROUP BY emp_td
    HAVING COUNT(DISTINCT TRIM(pay_center)) > 1
)
ORDER BY emp_td, pay_center;

-----------------------------------------------------------------------------
	UPDATE dpt_master_dcps_new_19012025
SET pay_center = REPLACE(pay_center, '/', '')
WHERE pay_center LIKE '%/%';

-----------------------------------------------------------------------------
-----------------------------------------------------------------------------
-----------------------------------------------------------------------------