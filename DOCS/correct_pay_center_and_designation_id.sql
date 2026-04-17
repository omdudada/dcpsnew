UPDATE dpt_master_dcps_new_19012025 AS t_current
JOIN dpt_master_dcps_new_19012025 AS t_next
  ON t_current.emp_td = t_next.emp_td
  AND t_next.for_year = t_current.for_year + 1
SET 
  t_current.designation_id = t_next.designation_id,
  t_current.pay_center = t_next.pay_center
WHERE 
  t_current.designation_id = 0
  AND t_current.pay_center = 0
  AND t_next.designation_id != 0
  AND t_next.pay_center != 0
  And t_current.emp_td = 9284;
  
  
  UPDATE dpt_master_dcps_new_19012025 AS t_current
JOIN (
    SELECT emp_td, pay_center, MIN(for_year) AS ref_year
    FROM dpt_master_dcps_new_19012025
    WHERE pay_center != 0
    GROUP BY emp_td
) AS t_later
ON t_current.emp_td = t_later.emp_td
   AND t_current.for_year < t_later.ref_year
   AND t_current.pay_center = 0
SET t_current.pay_center = t_later.pay_center and t_current.emp_td = 9284;


SELECT id, emp_td, designation_id, pay_center  FROM `dpt_master_dcps_new_19012025` WHERE `emp_td` LIKE '9284' AND `pay_center` != '0'

SELECT id, emp_td, designation_id, pay_center, for_month, for_year  FROM `dpt_master_dcps_new_19012025` WHERE `emp_td` LIKE '9284' AND `pay_center` != '0' order by for_month, for_year;




SELECT *
FROM dpt_master_dcps_new_19012025 AS t1
WHERE t1.for_year = 2006 AND t1.pay_center = 0
  AND EXISTS (
    SELECT 1
    FROM dpt_master_dcps_new_19012025 AS t2
    WHERE t2.emp_td = t1.emp_td
      AND t2.for_year <> 2006
      AND t2.pay_center != 0
  );



UPDATE dpt_master_dcps_new_19012025 AS t_current
JOIN (
    SELECT 
        t1.emp_td,
        t1.for_year,
        t1.for_month,
        COALESCE(
            (SELECT designation_id 
             FROM dpt_master_dcps_new_19012025 
             WHERE emp_td = t1.emp_td AND designation_id != 0 
               AND (for_year > t1.for_year OR (for_year = t1.for_year AND for_month > t1.for_month))
             ORDER BY for_year, for_month 
             LIMIT 1),
            0
        ) AS new_designation_id,
        COALESCE(
            (SELECT pay_center 
             FROM dpt_master_dcps_new_19012025 
             WHERE emp_td = t1.emp_td AND pay_center IS NOT NULL AND pay_center != 0
               AND (for_year > t1.for_year OR (for_year = t1.for_year AND for_month > t1.for_month))
             ORDER BY for_year, for_month 
             LIMIT 1),
            0
        ) AS new_pay_center
    FROM dpt_master_dcps_new_19012025 t1
    WHERE t1.designation_id = 0 AND (t1.pay_center = 0 OR t1.pay_center IS NULL)
) AS future_values
ON t_current.emp_td = future_values.emp_td 
   AND t_current.for_year = future_values.for_year
   AND t_current.for_month = future_values.for_month
SET 
  t_current.designation_id = CASE WHEN future_values.new_designation_id != 0 THEN future_values.new_designation_id ELSE t_current.designation_id END,
  t_current.pay_center = CASE WHEN future_values.new_pay_center != 0 THEN future_values.new_pay_center ELSE t_current.pay_center END;



CALL sp_backfill_all_designation_paycenter();
