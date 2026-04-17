SELECT 
mst.id, 
mst.emp_td,
mst.emp_name,
mst.bunch_no,
mst.file_no,
mst.for_month,
mst.for_year,
mst.recovered_DCPS_with_voucher_no,
mst.recovered_DCPS_with_voucher_date,
mst.basic,
mst.grade_pay,
mst.da,
mst.total_salary,
mst.Ideal_contribution_of_employee_for_DCPS,
mst.emp_DCPS_supplimentory_contribution, dd.designation_name, em.emp_name, em.joining_date, em.fixed_pay FROM `dpt_master_dcps_new_19012025` AS mst 
LEFT JOIN dpt_emp_master AS em ON em.emp_id = mst.emp_td 
LEFT JOIN dpt_designation AS dd ON dd.id = mst.designation_id 
WHERE  mst.is_deleted = 0 and mst.emp_td > 0 AND mst.`emp_td` = 9255 AND ( (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = 2011) OR (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = 2012) ) ORDER BY mst.pay_center ASC, mst.emp_td ASC




/* mst.id = 264918 and */