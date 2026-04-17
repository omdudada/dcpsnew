/* dpt_master_dcps table column names to upload the csv 

month_year, for_year, bunch_no, file_no, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date, pay_center, emp_td, emp_name, designation_id, basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS, emp_DCPS_supplimentory_contribution, NMC_supplimentory_DCPS_contribution, amount_to_be_recovered_from_emp, DCPS_loan_taken_by_an_employee, dcps_loan_installment_no, dcps_loan_total_installment_no, salary_start_date, salary_end_date, remark, reason

*/



SELECT 
    STR_TO_DATE(LEFT(month_year, 3), '%b') AS full_date,
    MONTH(STR_TO_DATE(LEFT(month_year, 3), '%b 1')) AS for_month,
    RIGHT(month_year, 4) AS for_year
FROM dpt_master_dcps_new_01032025;



UPDATE dcps_suplimentory_consolidated_data
SET 
    for_month = MONTH(STR_TO_DATE(LEFT(month_year, 3), '%b 1')),
    for_year = RIGHT(month_year, 4);