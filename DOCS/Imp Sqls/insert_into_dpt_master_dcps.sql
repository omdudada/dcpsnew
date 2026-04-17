INSERT INTO dpt_master_dcps_new_19012025 
(for_month, for_year, bunch_no, file_no, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date, pay_center, emp_td, emp_name, designation_id, basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS, emp_DCPS_supplimentory_contribution, NMC_supplimentory_DCPS_contribution, amount_to_be_recovered_from_emp, 
DCPS_loan_taken_by_an_employee, dcps_loan_installment_no, dcps_loan_total_installment_no, 
salary_start_date, salary_end_date, remark, reason)  
SELECT for_month, for_year, bunch_no, file_no, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date, 
pay_center, emp_td, emp_name, designation_id, basic, grade_pay, da, total_salary, 
Ideal_contribution_of_employee_for_DCPS, emp_DCPS_supplimentory_contribution, 
NMC_supplimentory_DCPS_contribution, amount_to_be_recovered_from_emp, 
DCPS_loan_taken_by_an_employee, dcps_loan_installment_no, dcps_loan_total_installment_no, 
salary_start_date, salary_end_date, remark, reason  
FROM dcps_suplimentory_consolidated_data  
WHERE 1;




SELECT mst.`emp_td`, dd.designation_name, em.emp_name, em.joining_date, em.pay_center, em.fixed_pay, SUM(mst.`Ideal_contribution_of_employee_for_DCPS`) AS ideal_contribution, SUM(mst.`emp_DCPS_contribution`) AS emp_DCPS_contribution, SUM(mst.emp_DCPS_supplimentory_contribution) AS emp_DCPS_supplimentory_contribution, SUM(mst.`NMC_DCPS_contribution`) AS NMC_DCPS_contribution, SUM(mst.NMC_supplimentory_DCPS_contribution) AS NMC_supplimentory_DCPS_contribution, ( SUM(mst.`emp_DCPS_contribution`) + SUM(mst.emp_DCPS_supplimentory_contribution) + SUM(mst.`NMC_DCPS_contribution`) + SUM(mst.NMC_supplimentory_DCPS_contribution) + SUM(mst.loan_installment_paid_through_salary) ) AS total_contribution, SUM(mst.`loan_installment_paid_through_salary`) AS loan_installment_paid_through_salary, SUM(mst.`DCPS_loan_taken_by_an_employee`) AS DCPS_loan_taken_by_an_employee, mst.`for_month`, mst.`for_year` FROM `dpt_master_dcps_new_19012025` AS mst LEFT JOIN dpt_emp_master AS em ON em.emp_id = mst.emp_td LEFT JOIN dpt_designation AS dd ON dd.id = mst.designation_id WHERE mst.is_deleted = 0 and mst.emp_td > 0 AND ( (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = 2008) OR (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = 2009) ) AND mst.emp_td = 8967 and for_month=6 and for_year=2008 GROUP BY mst.emp_td, mst.for_month, mst.for_year;


