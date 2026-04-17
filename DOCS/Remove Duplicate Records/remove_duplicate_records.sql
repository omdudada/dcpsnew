SELECT 
    recovered_DCPS_with_voucher_no,
    recovered_DCPS_with_voucher_date,
    basic,
    grade_pay,
    da,
    total_salary,
    Ideal_contribution_of_employee_for_DCPS,
    COUNT(*) as duplicate_count
FROM your_table_name
WHERE is_deleted = 0
GROUP BY 
    recovered_DCPS_with_voucher_no,
    recovered_DCPS_with_voucher_date,
    basic,
    grade_pay,
    da,
    total_salary,
    Ideal_contribution_of_employee_for_DCPS
HAVING COUNT(*) > 1;




SELECT *
FROM dpt_master_dcps t
WHERE (
    t.recovered_DCPS_with_voucher_no,
    t.recovered_DCPS_with_voucher_date,
    t.basic,
    t.grade_pay,
    t.da,
    t.total_salary,
    t.Ideal_contribution_of_employee_for_DCPS
) IN (
    SELECT 
        recovered_DCPS_with_voucher_no,
        recovered_DCPS_with_voucher_date,
        basic,
        grade_pay,
        da,
        total_salary,
        Ideal_contribution_of_employee_for_DCPS
    FROM dpt_master_dcps
    WHERE is_deleted = 0
    GROUP BY 
        recovered_DCPS_with_voucher_no,
        recovered_DCPS_with_voucher_date,
        basic,
        grade_pay,
        da,
        total_salary,
        Ideal_contribution_of_employee_for_DCPS
    HAVING COUNT(*) > 1
)
AND t.is_deleted = 0;
----------------------------------------------------------------------------------------------------------

SELECT 
    t.id, 
    t.emp_td, 
    t.emp_name, 
    t.for_year, 
    t.for_month, 
    t.recovered_DCPS_with_voucher_no, 
    t.recovered_DCPS_with_voucher_date, 
    t.is_deleted, 
    t.remark, 
    d.cnt AS duplicate_count
FROM dpt_master_dcps t
JOIN (
    SELECT 
        recovered_DCPS_with_voucher_no,
        recovered_DCPS_with_voucher_date,
        basic,
        grade_pay,
        da,
        total_salary,
        Ideal_contribution_of_employee_for_DCPS,
        for_year,
        for_month,
        COUNT(*) AS cnt
    FROM dpt_master_dcps
    WHERE is_deleted = 0 
      AND recovered_DCPS_with_voucher_no IS NOT NULL
      AND recovered_DCPS_with_voucher_no != ''
    GROUP BY 
        recovered_DCPS_with_voucher_no,
        recovered_DCPS_with_voucher_date,
        basic,
        grade_pay,
        da,
        total_salary,
        Ideal_contribution_of_employee_for_DCPS, 
        for_year,
        for_month
) d
ON  t.recovered_DCPS_with_voucher_no = d.recovered_DCPS_with_voucher_no
AND t.recovered_DCPS_with_voucher_date = d.recovered_DCPS_with_voucher_date
AND t.basic = d.basic
AND t.grade_pay = d.grade_pay
AND t.da = d.da
AND t.total_salary = d.total_salary
AND t.Ideal_contribution_of_employee_for_DCPS = d.Ideal_contribution_of_employee_for_DCPS
AND t.for_year = d.for_year
AND t.for_month = d.for_month
WHERE t.is_deleted = 0
AND d.cnt > 1;

-----------------------------------------------------------------------------------------------------

SELECT 
    t.id, 
    t.emp_td, 
    t.emp_name, 
    t.for_year, 
    t.for_month, 
    t.recovered_DCPS_with_voucher_no, 
    t.recovered_DCPS_with_voucher_date, 
    t.is_deleted, 
    t.remark, 
    d.cnt AS duplicate_count
FROM dpt_master_dcps t
JOIN (
    SELECT 
        CONCAT_WS('|',
            recovered_DCPS_with_voucher_no,
            recovered_DCPS_with_voucher_date,
            basic,
            grade_pay,
            da,
            total_salary,
            Ideal_contribution_of_employee_for_DCPS,
            for_year,
            for_month
        ) AS grp,
        COUNT(*) AS cnt
    FROM dpt_master_dcps
    WHERE is_deleted = 0
      AND recovered_DCPS_with_voucher_no IS NOT NULL
      AND recovered_DCPS_with_voucher_no != ''
    GROUP BY grp
    HAVING COUNT(*) > 1
) d
ON CONCAT_WS('|',
        t.recovered_DCPS_with_voucher_no,
        t.recovered_DCPS_with_voucher_date,
        t.basic,
        t.grade_pay,
        t.da,
        t.total_salary,
        t.Ideal_contribution_of_employee_for_DCPS,
        t.for_year,
        t.for_month
   ) = d.grp
WHERE t.is_deleted = 0;
----------------------------------------------------------------------------------------------------------------------

SELECT 
    t.id, 
    t.emp_td, 
    t.emp_name, 
    t.for_year, 
    t.for_month, 
    t.recovered_DCPS_with_voucher_no, 
    t.recovered_DCPS_with_voucher_date, 
    t.is_deleted, 
    t.remark, 
    d.cnt AS duplicate_count
FROM dpt_master_dcps t
group by t.emp_td, 
    t.for_year, 
    t.for_month, 
    t.recovered_DCPS_with_voucher_no, 
    t.recovered_DCPS_with_voucher_date
having cnt > 1	
----------------------------------------------------------------------------------------------------------------------